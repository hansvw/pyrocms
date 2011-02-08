<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Availability extends Public_Controller
{
    public function __construct()
    {
    	parent::Public_Controller();
    	$this->load->model('availability_m');
    	$this->template->append_metadata( css('availability.css', 'availability') );
 	}
  
 	function index()
 	{
	/// The fourth segment will be used as timeid
		$timeid = $this->uri->segment(3);
		if($timeid==0)
			$time = time();
		else
			$time = $timeid;
	
	/// we call _date function 	
		$data = $this->_date($time);
		
        $this->template
                ->append_metadata( js('availability.js', 'availability') )
                ->build('availability', $this->data);
	}
  
	function reservations($day)
  	{
  		$this->data->dayreservations = $this->availability_m->getDayReservations($day);
  		$this->data->header = 'Reservations';
        $this->template->build('reservation', $this->data);
  	}

  	function create()
  	{
		$this->data->title = "Add Events to Calendar";
		if(isset($_POST['add']))
		{
		/// check for empty inputs
			if((isset($_POST['date']) && !empty($_POST['date'])) && (isset($_POST['eventTitle']) && !empty($_POST['eventTitle'])) && (isset($_POST['eventContent']) && !empty($_POST['eventContent'])))	
			{
            	$this->availability_m->addEvents();
                $this->session->set_flashdata(array('success'=> 'New event added!'));
                        redirect('admin/calendar/create');
			}
			else 
			{
            	$this->session->set_flashdata(array('error'=> 'No empty input please'));
                	redirect('admin/calendar/create');
			}
		}
		
        $this->template
        	->append_metadata( js('availability.js', 'availability') )
            ->build('admin/calendar_create', $this->data);

	}
		
	function edit($id=0)
	{
	  	$data['title'] = "Edit Events";
	
	  	if(isset($_POST['add']))
		{
		/// check for empty inputs
			  if((isset($_POST['date']) && !empty($_POST['date'])) && (isset($_POST['eventTitle']) && !empty($_POST['eventTitle'])) && (isset($_POST['eventContent']) && !empty($_POST['eventContent'])))	
			  {
				  //add new event to the database
				  $this->availability_m->addEvents();
	                          $this->session->set_flashdata(array('success'=> 'Event created!'));
				  redirect('admin/calendar/index');
			  }
			  else 
			  {
				  //alert message for empty input
				  $data['alert'] = "No empty input please";
			  }
		  }
		
	  	$this->data->event= $this->availability_m->getEventsById($id);
	
		$data['header'] = 'Calendar';
                $this->template
                    ->append_metadata( js('availability.js', 'availability') )
                    ->build('admin/calendar_edit', $this->data);
	}

	function update($id=0)
    {
		if(isset($_POST['add']))
		{
			//check for empty inputs
			if((isset($_POST['date']) && !empty($_POST['date'])) && (isset($_POST['eventTitle']) && !empty($_POST['eventTitle'])) && (isset($_POST['eventContent']) && !empty($_POST['eventContent'])))	
			{
				//update event to the database
				$this->availability_m->updateEvent();
                                $this->session->set_flashdata(array('success'=> 'Event updated!'));
				redirect('admin/calendar/index');
			}
			else 
			{
				//alert message for empty input
				$data['alert'] = "No empty input please";
			}
		}
		$this->session->set_flashdata('message', 'Please fill up the information');
		redirect('admin/calendar/update');
		
	}
	
	function delete($id=0)
    {
		$this->availability_m->deleteEvent($id);
		$this->session->set_flashdata('message', 'Event deleted successfully.');
		redirect('admin/calendar/index');
	}
 
    function _date($time)
    {
        $this->data->reservations=$this->availability_m->getReservations($time);

        $today = date("Y/n/j", time());
        $this->data->today= $today;
	
        $current_month = date("n", $time);
        $this->data->current_month = $current_month;
	
        $current_year = date("Y", $time);
        $this->data->current_year = $current_year;
	
        $current_month_text = date("F Y", $time);
        $this->data->current_month_text = $current_month_text;
	
        $total_days_of_current_month = date("t", $time);
        $this->data->total_days_of_current_month= $total_days_of_current_month;
	
        $first_day_of_month = mktime(0,0,0,$current_month,1,$current_year);
        $this->data->first_day_of_month = $first_day_of_month;
	
	/// geting Numeric representation of the day of the week for first day of
    /// the month. 0 (for Sunday) through 6 (for Saturday).
        $first_w_of_month = date("w", $first_day_of_month);
        $this->data->first_w_of_month = $first_w_of_month;
	
	/// how many rows will be in the calendar to show the dates
        $total_rows = ceil(($total_days_of_current_month + $first_w_of_month)/7);
        $this->data->total_rows= $total_rows;
	
	/// trick to show empty cell in the first row if the month doesn't start from Sunday
        $day = -$first_w_of_month;
        $this->data->day= $day;
	
        $next_month = mktime(0,0,0,$current_month+1,1,$current_year);
        $this->data->next_month= $next_month;
	
        $next_month_text = date("F \'y", $next_month);
        $this->data->next_month_text= $next_month_text;
	
        $previous_month = mktime(0,0,0,$current_month-1,1,$current_year);
        $this->data->previous_month= $previous_month;
	
        $previous_month_text = date("F \'y", $previous_month);
        $this->data->previous_month_text= $previous_month_text;
	
        $next_year = mktime(0,0,0,$current_month,1,$current_year+1);
        $this->data->next_year= $next_year;
	
        $next_year_text = date("F \'y", $next_year);
        $this->data->next_year_text= $next_year_text;
	
        $previous_year = mktime(0,0,0,$current_month,1,$current_year-1);
        $this->data->previous_year=$previous_year;
	
        $previous_year_text = date("F \'y", $previous_year);
        $this->data->previous_year_text= $previous_year_text;
	
        return $this->data;
    }
}//end class
?>