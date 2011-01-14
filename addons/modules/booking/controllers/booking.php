<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Booking extends Public_Controller
{
    private $formfields = array();
    
	private $rules = array(
		array(
			'field'	=> 'booking_email',
			'label'	=> 'lang:booking_email_label',
			'rules'	=> 'required|trim|valid_email|max_length[80]'
		),
		array(
			'field'	=> 'booking_message',
			'label'	=> 'lang:booking_message_label',
			'rules'	=> 'required'
		)
	);

	function __construct()
	{
		parent::Public_Controller();
		$this->lang->load('booking');
	}

	function index()
	{
		$this->load->library('form_validation');
		$this->load->helper('form');
		
		$this->form_validation->set_rules($this->rules);

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

        $tel1field = array(
            'name' => 'tel1',
            'label' => 'lang_booking_tel1_label',
            'id'    => 'tel1',
            'size'  => '16'
        );

        $tel2field = array(
            'name' => 'tel1',
            'label' => 'lang_booking_tel2_label',
            'id'    => 'tel2',
            'size'  => '16'
        );

        $urlarray = array(
            '1' => 'www.aivolution.com',
            '2' => 'www.spatialmachines.net'
        );

        $formfields['firstname'] = $firstnamefield;
        $formfields['lastname'] = $lastnamefield;
        $formfields['email'] = $emailfield;
        $formfields['tel1'] = $tel1field;
        $formfields['tel2'] = $tel2field;

        $this->form_validation->set_rules('firstname','First Name','required|trim|max_length[80]');
        $this->form_validation->set_rules('lastname','Last Name','required|trim|max_length[100]');
        $this->form_validation->set_rules('email','EMail Address','required|trim|valid_email|max_length[80]');
        $this->form_validation->set_rules('tel1','Telephone Number', 'required|trim|min_length[7]|max_length[16]');
        $this->form_validation->set_rules('tel2','Alternate Telephone Number','trim|max_length[16]');

        $form_values->urlarray = $urlarray;

	/// Validate form
		if($this->form_validation->run())
		{
        /// Update reservation database, if successful send confirmation email,
        /// otherwise send failure email.
        	if($this->_create_reservation())
        	{	
			/// The try to send the email
				if($this->_send_email())
				{
				/// Store this session to limit useage
					$this->session->set_flashdata('sent_reservation_form', TRUE);
	
					redirect('booking/sent');
				}
        	}
        	else
        	{
        	}
		}
        else
        {
        }

    /// Set the values for the form inputs
		foreach($this->rules as $rule)
		{
			$form_values->{$rule['field']} = set_value($rule['field']);
		}
		
		$this->template
			->set('form_values', $form_values)
            ->set('formfields', $formfields)
			->build('index');
	}


	function sent()
	{
		$this->template->build('sent');
	}

	function _create_reservation()
	{
		return TRUE;
	}
	
	function _send_email()
	{
		$this->load->library('email');
		$this->load->library('user_agent');
		
		$this->email->from($this->input->post('booking_email'), $this->input->post('booking_first_name') . $this->input->post('booking_last_name'));
		$this->email->to($this->settings->item('booking_email'));

		$subject = 'Reservation';
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

		$this->email->message($this->load->view('email/contact_html', $data, TRUE));
		$this->email->set_alt_message($this->load->view('email/contact_plain', $data, TRUE));

	/// If the email has sent with no known erros, show the message
		return (bool) $this->email->send();
	}

}

/* End of file booking.php */
