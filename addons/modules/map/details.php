<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Map extends Module
{
	public $version = '2011-1';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Trullove Map',

			),
			'description' => array(
				'en' => 'Shows the Trullove Villa and surrounding Towns on a Google Map',
				),
			'frontend' => TRUE,
			'backend' => FALSE,
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
		<p>The Map module shows Trullove and surrounding places on a Google Map</p>";
	}
}
/* End of file details.php */
