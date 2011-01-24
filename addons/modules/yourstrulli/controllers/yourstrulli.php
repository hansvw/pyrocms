<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Yourstrulli extends Public_Controller
{
	private $subjects = array();

	// Fields must match this certain criteria
	private $rules = array(
		array(
			'field'	=> 'contact_name',
			'label'	=> 'lang:contact_name_label',
			'rules'	=> 'required|trim|max_length[80]',
            'size' => '50'
		),
		array(
			'field'	=> 'contact_email',
			'label'	=> 'lang:contact_email_label',
			'rules'	=> 'required|trim|valid_email|max_length[100]',
            'size' => '80'
		),
		array(
			'field'	=> 'subject',
			'label'	=> 'lang:contact_subject_label',
			'rules'	=> 'required|trim'
		),
		array(
			'field'	=> 'message',
			'label'	=> 'lang:contact_message_label',
			'rules'	=> 'required'
		)
	);

	function __construct()
	{
		parent::Public_Controller();
		$this->lang->load('yourstrulli');

		$this->subjects = array(
            'availability'  => lang('subject_availability_question'),
			'reservations'  => lang('subject_reservation_question'),
			'website'       => lang('subject_website_feedback'),
            'property'      => lang('subject_property_feedback'),
			'suggestion'    => lang('subject_suggestion'),
			'business'      => lang('subject_other')
		);
	}

	function index()
	{
		$this->load->library('form_validation');
		$this->load->helper('form');
		
		$this->form_validation->set_rules($this->rules);

	/// If the user has provided valid information
		if($this->form_validation->run())
		{
			// The try to send the email
			if($this->_send_email())
			{
			/// Store this session to limit useage
				$this->session->set_flashdata('sent_contact_form', TRUE);

				redirect('yourstrulli/sent');
			}
		}

		// Set the values for the form inputs
		foreach($this->rules as $rule)
		{
			$form_values->{$rule['field']} = set_value($rule['field']);
		}
		
		$this->template
			->set('subjects', $this->subjects)
			->set('form_values', $form_values)
			->build('index');
	}


	function sent()
	{
		$this->template->build('sent');
	}


	function _send_email()
	{
		$this->load->library('email');
		$this->load->library('user_agent');
		
		$this->email->from($this->input->post('contact_email'), $this->input->post('contact_name'));
		$this->email->to($this->settings->item('contact_email'));

	/// If "other subject" exists then use it, if not then use the selected subject
		$subject = ($this->input->post('other_subject')) ? $this->input->post('other_subject') : $this->subjects[$this->input->post('subject')];
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

/* End of file contact.php */