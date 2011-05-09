<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Availability extends Public_Controller
{
    private $yearselections;
    private $selectionjs;
    private $calendar;
    private $calendarhtml;

	function __construct()
	{
		parent::Public_Controller();
        $this->load->model('availability_m');
        $this->load->helper('url');
		$this->lang->load('availability');
        $this->yearselections = array(
        	'2011' => '2011',
        	'2012' => '2012',
        	'2013' => '2013');
        $this->selectionjs = 'id="yearselector" onChange="this.form.submit();"';
        $this->template->append_metadata( css('availability.css', 'availability') );
	}

	function index()
	{
		$this->load->library('form_validation');
		$this->load->helper('form');

        if(null == $this->input->post('yearselection'))
        {
            $form_values->yearselection = 2011;
        }
        else
        {
            $form_values->yearselection = $this->input->post('yearselection');
        }

        $reservationMap = $this->availability_m->getYearlyReservationMap($form_values->yearselection);

        $this->calendar = new Calendar(date('Y-m-d'));
        $this->calendarhtml = "<ol id=\"year\">\n";
        for($i = 1; $i <= 12; $i++)
        {
            $this->calendarhtml.="<li>";
            $startdate = $this->calendar->month_start_date($form_values->yearselection, $i);
            $enddate = $this->calendar->month_end_date($form_values->yearselection,$i);
            $this->calendarhtml.=$this->calendar->output_calendar($form_values->yearselection, $i, 'calendar', $reservationMap);
            $this->calendarhtml.="</li>\n";
        }

        $this->template
			->set('yearselections', $this->yearselections)
            ->set('selectionjs', $this->selectionjs)
            ->set('pageurl', current_url())
			->set('form_values', $form_values)
            ->set('calendar_html', $this->calendarhtml)
			->build('index');
	}
}

class Calendar
{
	var $date;
	var $year;
	var $month;
	var $day;

	var $week_start_on = FALSE;
	var $week_start = 7;// sunday

	var $link_days = TRUE;
	var $link_to;
	var $formatted_link_to;

	var $mark_today = TRUE;
	var $today_date_class = 'today';

	var $mark_selected = TRUE;
	var $selected_date_class = 'selected';

	var $mark_passed = TRUE;
	var $passed_date_class = 'passed';

    var $pending_class = 'pending';
    var $confirmed_class = 'confirmed';
    var $pending_start_class = 'pending-start';
    var $pending_end_class = 'pending-end';
    var $confirmed_start_class = 'confirmed-start';
    var $confirmed_end_class = 'confirmed-end';
    var $pending_confirmed_class = 'pending-confirmed';
    var $confirmed_pending_class = 'confirmed-pending';
    var $pending_pending_class = 'pending-pending';
    var $confirmed_confirmed_class = 'confirmed-confirmed';

	var $highlighted_dates;
	var $default_highlighted_class = 'highlighted';


/*  CONSTRUCTOR */
	function Calendar($date = NULL, $year = NULL, $month = NULL)
    {
		$self = htmlspecialchars($_SERVER['PHP_SELF']);
		$this->link_to = $self;

		if( is_null($year) || is_null($month) )
        {
			if( !is_null($date) )
            {
            /// strtotime the submitted date to ensure correct format
				$this->date = date("Y-m-d", strtotime($date));
			}
            else
            {
			/// no date submitted, use today's date
				$this->date = date("Y-m-d");
			}
			$this->set_date_parts_from_date($this->date);
		}
        else
        {
			$this->year		= $year;
			$this->month	= str_pad($month, 2, '0', STR_PAD_LEFT);
		}
	}

	function set_date_parts_from_date($date)
    {
		$this->year		= date("Y", strtotime($date));
		$this->month	= date("m", strtotime($date));
		$this->day		= date("d", strtotime($date));
	}

	function day_of_week($date)
    {
		$day_of_week = date("N", $date);
		if( !is_numeric($day_of_week) )
        {
			$day_of_week = date("w", $date);
			if( $day_of_week == 0 )
            {
				$day_of_week = 7;
			}
		}
		return $day_of_week;
	}

    function month_start_date($year, $month)
    {
        $month_start_date = strtotime($year . "-" . $month . "-01");
        return $month_start_date;
    }

    function month_end_date($year, $month)
    {
        $month_start_date = $this->month_start_date($year, $month);
        $days_in_month = date("t", $month_start_date);
        $month_end_date = strtotime($year . "-" . $month . "-" . $days_in_month);
        return $month_end_date;
    }

    function check_flag($value, $flag)
    {
        return $value & $flag;
    }

	function output_calendar($year = NULL, $month = NULL, $calendar_class = 'calendar', $reservationMap = null)
    {
		if( $this->week_start_on !== FALSE )
        {
			echo "The property week_start_on is replaced due to a bug present in version before 2.6. of this class! Use the property week_start instead!";
			exit;
		}

		//--------------------- override class methods if values passed directly
		$year = ( is_null($year) )? $this->year : $year;
		$month = ( is_null($month) )? $this->month : str_pad($month, 2, '0', STR_PAD_LEFT);

		//------------------------------------------- create first date of month
		$month_start_date = strtotime($year . "-" . $month . "-01");
		//------------------------- first day of month falls on what day of week
		$first_day_falls_on = $this->day_of_week($month_start_date);
		//----------------------------------------- find number of days in month
		$days_in_month = date("t", $month_start_date);
		//-------------------------------------------- create last date of month
		$month_end_date = strtotime($year . "-" . $month . "-" . $days_in_month);
		//----------------------- calc offset to find number of cells to prepend
		$start_week_offset = $first_day_falls_on - $this->week_start;
		$prepend = ( $start_week_offset < 0 )? 7 - abs($start_week_offset) : $first_day_falls_on - $this->week_start;
		//-------------------------- last day of month falls on what day of week
		$last_day_falls_on = $this->day_of_week($month_end_date);

		//------------------------------------------------- start table, caption
		$output  = "<table class=\"" . $calendar_class . "\">\n";
		$output .= "<caption>" . ucfirst(strftime("%B %Y", $month_start_date)) . "</caption>\n";

		$col = '';
		$th = '';
		for( $i=1,$j=$this->week_start,$t=(3+$this->week_start)*86400; $i<=7; $i++,$j++,$t+=86400 )
        {
			$localized_day_name = gmstrftime('%A',$t);
			$col .= "<col class=\"" . strtolower($localized_day_name) ."\" />\n";
			$th .= "\t<th title=\"" . ucfirst($localized_day_name) ."\">" . strtoupper($localized_day_name{0}) ."</th>\n";
			$j = ( $j == 7 )? 0 : $j;
		}

		//------------------------------------------------------- markup columns
		$output .= $col;

		//----------------------------------------------------------- table head
		$output .= "<thead>\n";
		$output .= "<tr>\n";

		$output .= $th;

		$output .= "</tr>\n";
		$output .= "</thead>\n";

		//---------------------------------------------------------- start tbody
		$output .= "<tbody>\n";
		$output .= "<tr>\n";

		//---------------------------------------------- initialize week counter
		$weeks = 1;

		//--------------------------------------------------- pad start of month

		//------------------------------------ adjust for week start on saturday
		for($i=1;$i<=$prepend;$i++)
        {
			$output .= "\t<td class=\"pad\">&nbsp;</td>\n";
		}

		//--------------------------------------------------- loop days of month
		for($day=1,$cell=$prepend+1; $day<=$days_in_month; $day++,$cell++)
        {

			/*
			if this is first cell and not also the first day, end previous row
			*/
			if( $cell == 1 && $day != 1 )
            {
				$output .= "<tr>\n";
			}

			//-------------- zero pad day and create date string for comparisons
			$day = str_pad($day, 2, '0', STR_PAD_LEFT);
			$day_date = $year . "-" . $month . "-" . $day;

			//-------------------------- compare day and add classes for matches
			if( $this->mark_today == TRUE && $day_date == date("Y-m-d") )
            {
				$classes[] = $this->today_date_class;
			}

			if( $this->mark_selected == TRUE && $day_date == $this->date )
            {
				$classes[] = $this->selected_date_class;
			}

			if( $this->mark_passed == TRUE && $day_date < date("Y-m-d") )
            {
				$classes[] = $this->passed_date_class;
			}

            if( null != $reservationMap)
            {
                if(isset($reservationMap[date('Y-m-d',strtotime($day_date))]))
                {
                    $status = $reservationMap[date('Y-m-d',strtotime($day_date))];

                    if($status == RSPENDING)
                    {
                        $classes[] = $this->pending_class;
                    }
                    else if ($status == RSCONFIRMED)
                    {
                        $classes[] = $this->confirmed_class;
                    }
                    else if (($status & RSPENDINGEND) && ($status & RSCONFIRMEDSTART))
                    {
                        $classes[] = $this->pending_confirmed_class;
                    }
                    else if (($status & RSCONFIRMEDEND) && ($status & RSPENDINGSTART))
                    {
                        $classes[] = $this->confirmed_pending_class;
                    }
                    else if (($status & RSPENDINGEND) && ($status & RSPENDINGSTART))
                    {
                        $classes[] = $this->pending_pending_class;
                    }
                    else if (($status & RSCONFIRMEDEND) && ($status & RSCONFIRMEDSTART))
                    {
                        $classes[] = $this->confirmed_confirmed_class;
                    }
                    else if ($status & RSPENDINGSTART)
                    {
                        $classes[] = $this->pending_start_class;
                    }
                    else if($status & RSPENDINGEND)
                    {
                        $classes[] = $this->pending_end_class;
                    }
                    else if ($status & RSCONFIRMEDSTART)
                    {
                        $classes[] = $this->confirmed_start_class;
                    }
                    else if ($status & RSCONFIRMEDEND)
                    {
                        $classes[] = $this->confirmed_end_class;
                    }
                }
            }

			if( is_array($this->highlighted_dates) )
            {
				if( in_array($day_date, $this->highlighted_dates) )
                {
					$classes[] = $this->default_highlighted_class;
				}
			}

			//----------------- loop matching class conditions, format as string
			if( isset($classes) )
            {
				$day_class = ' class="';
				foreach( $classes AS $value )
                {
					$day_class .= $value . " ";
				}
				$day_class = substr($day_class, 0, -1) . '"';
			}
            else
            {
				$day_class = '';
			}

		/// apply css classes
		/// detect windows os and substitute for unsupported day of month modifer
			$title_format = (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')? "%A, %B %#d, %Y": "%A, %B %e, %Y";

			$output .= "\t<td" . $day_class . " title=\"" . ucwords(strftime($title_format, strtotime($day_date))) . "\">";

			//----------------------------------------- unset to keep loop clean
			unset($day_class, $classes);

			//-------------------------------------- conditional, start link tag
			switch( $this->link_days )
            {
				case 0 :
					$output .= $day;
				break;

				case 1 :
					if( empty($this->formatted_link_to) ){
						$output .= "<a href=\"" . $this->link_to . "?date=" . $day_date . "\">" . $day . "</a>";
					} else {
						$output .= "<a href=\"" . strftime($this->formatted_link_to, strtotime($day_date)) . "\">" . $day . "</a>";
					}
				break;

				case 2 :
					if( is_array($this->highlighted_dates) ){
						if( in_array($day_date, $this->highlighted_dates) ){
							if( empty($this->formatted_link_to) ){
								$output .= "<a href=\"" . $this->link_to . "?date=" . $day_date . "\">";
							} else {
								$output .= "<a href=\"" . strftime($this->formatted_link_to, strtotime($day_date)) . "\">";
							}
						}
					}

					$output .= $day;

					if( is_array($this->highlighted_dates) ){
						if( in_array($day_date, $this->highlighted_dates) ){
							if( empty($this->formatted_link_to) ){
								$output .= "</a>";
							} else {
								$output .= "</a>";
							}
						}
					}
				break;
			}

			//------------------------------------------------- close table cell
			$output .= "</td>\n";

			//------- if this is the last cell, end the row and reset cell count
			if( $cell == 7 ){
				$output .= "</tr>\n";
				$cell = 0;
			}

		}

		//----------------------------------------------------- pad end of month
		if( $cell > 1 ){
			for($i=$cell;$i<=7;$i++){
				$output .= "\t<td class=\"pad\">&nbsp;</td>\n";
			}
			$output .= "</tr>\n";
		}

		//--------------------------------------------- close last row and table
		$output .= "</tbody>\n";
		$output .= "</table>\n";

		//--------------------------------------------------------------- return
		return $output;
	}
}

/* End of file availability.php */