<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Monthcalendar extends Module
{
	public $version = '2011-1';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Availability - Monthly Calendar',
				
			),
			'description' => array(
				'en' => 'Display availability of a single resource on a monthly interactive calendar.',
				),
			'frontend' => TRUE,
			'backend' => TRUE,
			'menu' => 'content'
		);
	}

	public function install()
	{
		return TRUE;
	}

	public function uninstall()
	{
		return TRUE;
	}

	public function upgrade($old_version)
	{
		return TRUE;
	}

	public function help()
	{
		// Return a string containing help info
		// You could include a file and return it here.
		return "<h4>Overview</h4>
		<p>Availability shows the availability of a resource on a monthly interactive calendar.</p>";
	}
}
/* End of file details.php */