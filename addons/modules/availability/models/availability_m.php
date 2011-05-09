<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define ('RSFREE', 0);
define ('RSPENDING', 1);
define ('RSCONFIRMED', 2);
define ('RSPENDINGSTART', 4);
define ('RSPENDINGEND', 8);
define ('RSCONFIRMEDSTART', 16);
define ('RSCONFIRMEDEND', 32);

class Availability_m extends MY_Model
{
	function MAvailability()
	{
		parent::Model();
	}

/**
  * Retrieve all specified days of the week in a specified year.
  * @param int $year
  * @param int $daysofweek
  * @return array
  */
    function getDaysOfWeekDatesInYear($year, $dayofweek)
    {
        $dates = array();

        $newyear = $year;
        $week = 0;
        $day = 0;
        $month = 1;
        $i = 0;

    /// Progress to first week of year
        while($week != 1)
        {
            $day++;
            $week = date("w", mktime(0, 0, 0, $month, $day, $year));
        }

    /// Push date for first week of year
        $firstdate = date("l F jS, o", mktime(0, 0, 0, $month, $day + $dayofweek, $year));
        if($this->isAvailable($firstdate))
        {
            array_push($dates, date("l F jS, o", mktime(0, 0, 0, $month, $day + $dayofweek, $year)));
        }

        while($newyear == $year)
        {
            $test = strtotime(date("r", mktime(0, 0, 0, $month, $day + $dayofweek, $year)). "+" . $i . " week");
            $i++;
            if($year == date("Y", $test))
            {
                if($this->isAvailable($test))
                {
                    array_push($dates, date("l F jS, o", $test));
                }
            }

            $newyear = date("Y", $test);
        }

        return $dates;
    }

    function getReservations($time)
    {
		$today = date("Y/n/j", time());
		$current_month = date("n", $time);
		$current_year = date("Y", $time);
		$current_month_text = date("F Y", $time);
		$total_days_of_current_month = date("t", $time);

		$reservations = array();

		$query = $this->db->query("
            SELECT DATE_FORMAT(rscalendar.calendardate,'%d') AS day,
                    rscalendar.reservation_code, rsreservation.code,
                    rsreservation.status AS status
            FROM rscalendar, rsreservation
            WHERE rscalendar.calendardate
                BETWEEN '$current_year/$current_month/01' AND
                '$current_year/$current_month/$total_days_of_current_month'
                AND rscalendar.reservation_code = rsreservation.code");

		foreach ($query->result() as $reservation_row)
		{
			$reservations[intval($reservation_row->day)][] = $reservation_row;
		}

        $query->free_result();
		return $reservations;
	}

   	function getDayReservations($day)
    {
        $query = $this->db->query("SELECT
            rscalendar.calendardate,
            rscalendar.reservation_code,
            rsreservation.code,
            rsreservation.status
            FROM rscalendar, rsreservation WHERE
            rscalendar.calendardate = '$day' AND
            rscalendar.reservation_code = rsreservation.code");
		foreach ($query->result_array() as $row_event)
		{
			$reservations[] = $row_event;
		}
		$query->free_result();
		return $reservations;
	}

    function getYearlyReservationMap($year)
    {
        $reservationMap = array();

        $first_day_of_year = strtotime($year . "-" . "01-01");
        $first_day_of_december = strtotime($year . "-" . "12-01");
        $days_in_december = date("t",$first_day_of_december);
        $last_day_of_year = strtotime($year . "-12-" . $days_in_december);

        $first_day_of_year_string = date('Y-m-d', $first_day_of_year);
        $last_day_of_year_string = date('Y-m-d', $last_day_of_year);

        $query = $this->db->query("SELECT
            startdate, enddate, code, status
            FROM rsreservation WHERE
            (startdate BETWEEN '$first_day_of_year_string' AND '$last_day_of_year_string') OR
            (enddate BETWEEN '$first_day_of_year_string' AND '$last_day_of_year_string')");

		foreach ($query->result_array() as $row_event)
		{
            $status = RSFREE;
            
            if($row_event['status'] == 'pending')
            {
                if(array_key_exists($row_event['startdate'],$reservationMap))
                {
                    $reservationMap[$row_event['startdate']] |= RSPENDINGSTART;
                }
                else
                {
                    $reservationMap[$row_event['startdate']] = RSPENDINGSTART;
                }

                if(array_key_exists($row_event['enddate'],$reservationMap))
                {
                    $reservationMap[$row_event['enddate']] |= RSPENDINGEND;
                }
                else
                {
                    $reservationMap[$row_event['enddate']] = RSPENDINGEND;
                }
            }
            else if ($row_event['status'] == 'confirmed')
            {
                if(array_key_exists($row_event['startdate'],$reservationMap))
                {
                    $reservationMap[$row_event['startdate']] |= RSCONFIRMEDSTART;
                }
                else
                {
                    $reservationMap[$row_event['startdate']] = RSCONFIRMEDSTART;
                }

                if(array_key_exists($row_event['enddate'],$reservationMap))
                {
                    $reservationMap[$row_event['enddate']] |= RSCONFIRMEDEND;
                }
                else
                {
                    $reservationMap[$row_event['enddate']] = RSCONFIRMEDEND;
                }
            }

       ///  fill in days in between start date and end date
            $checkdate = date("Y-m-d", strtotime("+1 day", strtotime($row_event['startdate'])));
            while(strtotime($checkdate) < strtotime($row_event['enddate']))
            {
                if($row_event['status'] == 'pending')
                {
                    $reservationMap[$checkdate] = RSPENDING;
                }
                else if($row_event['status'] == 'confirmed')
                {
                    $reservationMap[$checkdate] = RSCONFIRMED;
                }

            /// proceed to next date
                $checkdate = date("Y-m-d", strtotime("+1 day", strtotime($checkdate)));
            }
		}

        return $reservationMap;
    }

    function getReservationMap($startdate, $enddate)
    {
        $reservationmap = array();

        $query = $this->db->query("SELECT calendardate, reservation_status
                FROM rscalendar
                WHERE calendardate>= '$startdate' AND
                  calendardate <= '$enddate'");

        foreach($query->result_array() as $row_event)
        {
            $reservationmap[date("Y-m-d",strtotime($row_event['calendardate']))] =
            $row_event['reservation_status'];
        }

        $query->free_result();
        return $reservationmap;
    }

    function createReservation($arrivaldates,$lengthsofstay)
    {
        $arrivaldate = $arrivaldates[$_POST['arrivaldate']];
        $lengthofstay = $lengthsofstay[$_POST['lengthofstay']];

        $persondata = array(
   			  'firstname' => $_POST['firstname'],
              'lastname' => $_POST['lastname'],
              'email' => $_POST['email'],
              'country' => $_POST['country'],
              'language' => $_POST['language'],
              'tel1' => $_POST['tel1'],
              'tel2' => $_POST['tel2']
        );

        $this->db->where('email', $_POST['email']);
        $query = $this->db->get('rsperson');

        if($query->num_rows() > 0)
        {
            $existingperson = $query->row();
        }
        else
        {
            if($this->db->insert('rsperson', $persondata))
            {
                $personid = $this->db->insert_id();
                $this->db->where('id', $personid);
                $query = $this->db->get('rsperson');
                $existingperson = $query->row();
            }
            else
            {
                return FALSE;
            }
        }

        $query->free_result();

        $reservationcode = uniqid();

        $departuredate = strtotime($arrivaldate . ' + '. 7 * $lengthofstay . ' days');

        $reservationdata = array(
            'code' => $reservationcode,
            'person_id' => $existingperson->id,
            'dtreservation' => date('Y-m-d H:i:s'),
            'startdate' => date('Y-m-d',strtotime($arrivaldate)),
            'starttime' => date('H:i:s', mktime(16,0,0)),
            'enddate' => date('Y-m-d', $departuredate),
            'enddtime' => date('H:i:s', mktime(16,0,0)),
            'message' => $_POST['message'],
            'status' => 'pending'
            );

        if(!$this->db->insert('rsreservation', $reservationdata))
        {
            return FALSE;
        }

        $checkdate = $reservationdata['startdate'];

        while(strtotime($checkdate) <= strtotime($reservationdata['enddate']))
        {
            $calendarday = array(
                'calendardate' => $checkdate,
                'reservation_code' => $reservationdata['code'],
                'reservation_status' => $reservationdata['status']
            );

            $this->db->insert('rscalendar', $calendarday);
            $checkdate = date("Y-m-d", strtotime("+1 day", strtotime($checkdate)));
        }

        return $reservationdata;
    }

    function editReservation()
    {
    }

    function deleteReservation()
    {
    }

    function isAvailable($date)
    {
        $day = date('Y-m-d', $date);
		$query = $this->db->query("
            SELECT reservation_status
            FROM rscalendar
            WHERE calendardate = '$day' AND (reservation_status = 'pending' OR reservation_status = 'confirmed')");

        if($query->num_rows() > 0)
        {
            return FALSE;
        }

        return TRUE;
    }

// end of Model/calendar_m.php
}