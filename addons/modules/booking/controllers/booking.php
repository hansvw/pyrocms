<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Booking extends Public_Controller
{
    private $formfields = array();
    private $formvalues;
    
	function __construct()
	{
		parent::Public_Controller();
		$this->lang->load('booking');
        $this->load->model('availability_m');
	}

	function index()
	{
		$this->load->library('form_validation');
		$this->load->helper('form');
		
        $firstnamefield = array(
            'name' => 'firstname',
            'label' => 'lang:booking_first_name_label',
            'id' => 'firstname',
            'size' => '30'
        );

        $lastnamefield = array(
            'name' => 'lastname',
            'label' => 'lang:booking_last_name_label',
            'id' => 'lastname',
            'size' => '30'
        );

        $emailfield = array(
            'name' => 'email',
            'label' => 'lang:booking_email_label',
            'id'    => 'email',
            'size'  => '50'
        );

        $countryfield = array(
            'name'  => 'country',
            'label' => 'lang:booking_country_label',
            'id'    => 'country',
            'size'  => '50'
        );

        $languagefield = array(
            'name'  => 'language',
            'label' => 'lang:booking_language_label',
            'id'    => 'language',
            'size'  => '50'
        );

        $tel1field = array(
            'name' => 'tel1',
            'label' => 'lang_booking_tel1_label',
            'id'    => 'tel1',
            'size'  => '16'
        );

        $tel2field = array(
            'name' => 'tel2',
            'label' => 'lang_booking_tel2_label',
            'id'    => 'tel2',
            'size'  => '16'
        );

        $messagefield = array(
            'name'  => 'message',
            'label' => 'lang_booking_message_label',
            'id'    => 'message',
            'rows'  => '5',
            'cols'  => '160'
        );

        $arrivaldates = $this->availability_m->getDaysOfWeekDatesInYear("2011", 6);

        $lengthsofstay = array(
            '1' => '1 week',
            '2' => '2 weeks',
            '3' => '3 weeks',
            '4' => '4 weeks',
            '5' => '5 weeks',
            '6' => '6 weeks',
            '7' => '7 weeks',
            '8' => '8 weeks'
        );
       
        $this->formfields['firstname'] = $firstnamefield;
        $this->formfields['lastname'] = $lastnamefield;
        $this->formfields['email'] = $emailfield;
        $this->formfields['country'] = $countryfield;
        $this->formfields['language'] = $languagefield;
        $this->formfields['tel1'] = $tel1field;
        $this->formfields['tel2'] = $tel2field;
        $this->formfields['message'] = $messagefield;

        $this->form_validation->set_rules('firstname','First Name','required|trim|max_length[80]');
        $this->form_validation->set_rules('lastname','Last Name','required|trim|max_length[100]');
        $this->form_validation->set_rules('email','EMail Address','required|trim|valid_email|max_length[80]');
        $this->form_validation->set_rules('country','Country', 'required|trim|max_length[80]');
        $this->form_validation->set_rules('language','Preferred Language', 'trim|max_length[80]');
        $this->form_validation->set_rules('tel1','Telephone Number', 'required|trim|min_length[7]|max_length[16]');
        $this->form_validation->set_rules('tel2','Alternate Telephone Number','trim|min_length[7]|max_length[16]');
        $this->form_validation->set_rules('message','Special Requests, message to owner', 'trim|max_length[2048]');

        $this->formvalues->arrivaldates = $arrivaldates;
        $this->formvalues->lengthsofstay = $lengthsofstay;

	/// Validate form
		if($this->form_validation->run())
		{
        /// Update reservation database, if successful send confirmation email,
        /// otherwise send failure email.
            $reservationdata = $this->availability_m->createReservation(
                    $arrivaldates, $lengthsofstay);

            if($reservationdata)
            {
                if($this->_send_email($reservationdata))
                {
                    $this->_send_confirmation_email($reservationdata);

                    redirect('booking/sent');
                }
            }
		}
		
		$this->template
			->set('form_values', $this->formvalues)
            ->set('formfields', $this->formfields)
			->build('index');
	}


	function sent()
	{
		$this->template->build('sent');
	}
	
	function _send_email($reservationdata)
	{
		$this->load->library('email');
		$this->load->library('user_agent');

        $this->email->set_newline("\r\n");
		$this->email->from($this->input->post('email'), $this->input->post('firstname') . ' ' . $this->input->post('lastname'));

        $recipients = array(
            $this->settings->item('contact_email'),
            'reservations@trullove.com');

        $this->email->to($recipients);

		$subject = 'Reservation request';
		$this->email->subject($this->settings->item('site_name') .' - '.$subject);

	/// Loop through cleaning data and inputting to $data
		foreach(array_keys($_POST) as $field_name)
		{
			$data[$field_name] = $this->input->post($field_name, TRUE);
            $data['reservationcode'] = $reservationdata['code'];
            $data['startdate'] = $reservationdata['startdate'];
            $data['enddate'] = $reservationdata['enddate'];
		}

	/// Add in some extra details
		$data['sender_agent']	=	$this->agent->browser().' '.$this->agent->version();
		$data['sender_ip']		=	$this->input->ip_address();
		$data['sender_os']		=	$this->agent->platform();

		$this->email->message($this->load->view('email/reservation_html', $data, TRUE));
		$this->email->set_alt_message($this->load->view('email/reservation_plain', $data, TRUE));

	/// If the email has sent with no known erros, show the message
		return (bool) $this->email->send();
	}

    function _send_confirmation_email($reservationdata)
	{
		$this->load->library('email');
		$this->load->library('user_agent');

        $this->email->set_newline("\r\n");
		$this->email->from('reservations@trullove.com', 'Trullove Reservations');

        $recipients = array($this->input->post('email'));

        $this->email->to($recipients);

		$subject = 'reservation request confirmation: ' . $reservationdata['code'];
		$this->email->subject($this->settings->item('site_name') .' - '.$subject);

	/// Loop through cleaning data and inputting to $data
		foreach(array_keys($_POST) as $field_name)
		{
			$data[$field_name] = $this->input->post($field_name, TRUE);
		}

	/// Add in some extra details
		$data['sender_agent']	=	$this->agent->browser().' '.$this->agent->version();
		$data['sender_ip']		=	$this->input->ip_address();
		$data['sender_os']		=	$this->agent->platform();

		$this->email->message($this->load->view('email/customer_html', $data, TRUE));
		$this->email->set_alt_message($this->load->view('email/customer_plain', $data, TRUE));

	/// If the email has sent with no known erros, show the message
		return (bool) $this->email->send();
	}

    function checkTelephoneNumber($tel_no)
    {
        return (bool) preg_match('/\d|\+|\-/', (string) $tel_no);
    }
}

/* End of file booking.php */
