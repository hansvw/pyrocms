<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
        array_push($dates, date("l F jS, o", mktime(0, 0, 0, $month, $day + $dayofweek, $year)));

        while($newyear == $year)
        {
            $test = strtotime(date("r", mktime(0, 0, 0, $month, $day + $dayofweek, $year)). "+" . $i . " week");
            $i++;
            if($year == date("Y", $test))
            {
                array_push($dates, date("l F jS, o", $test));
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

    function createReservation()
    {
        $persondata = array(
   			  'firstname' => $_POST['firstname'],
              'lastname' => $_POST['lastname'],
              'email' => $_POST['email'],
              'country' => $_POST['country'],
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
            $this->db->insert('rsperson', $persondata);
            $existingperson = $persondata;
            $existingperson['id'] = $this->db->insert_id();
        }

        $query->free_result();

        $reservationdata = array(
            'code' => $_POST['reservationcode'],
            'person_id' => $existingperson['id'],
            'dtreservation' => date('Y-M-d h:i:s'),
            'startdate' => $_POST['startdate'],
            'enddate' => $_POST['enddate'],
            'status' => 'pending'
            );

        $this->db->insert('rsreservation', $reservationdata);

        return $reservation;
    }

    function editReservation()
    {
    }

    function deleteReservation()
    {
    }

// end of Model/calendar_m.php
}