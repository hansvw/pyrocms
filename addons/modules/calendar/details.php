<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Calendar extends Module {

	public $version = '0.1';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Calendar',
				
			),
			'description' => array(
				'en' => 'Organize your schedule.',
				),
			'frontend' => TRUE,
			'backend' => TRUE,
			'menu' => 'content'
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('eventcal');
		
		
		$calendar = "
                    CREATE TABLE `eventcal` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                          `user` varchar(25) NOT NULL DEFAULT 'anonimous',
                          `user_id` int(25) NOT NULL,
                          `eventDate` date DEFAULT NULL,
                          `eventTitle` varchar(100) DEFAULT NULL,
                          `eventContent` text,
                          `privacy` enum('public','private') NOT NULL DEFAULT 'public',
                          PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;
		";
		
		
		
		if($this->db->query($calendar))
		{
			return TRUE;
		}
	}

	public function uninstall()
	{
		if($this->dbforge->drop_table('calendar'))
		{
			return TRUE;
		}
	}

	public function upgrade($old_version)
	{
		// Your Upgrade Logic
		return TRUE;
	}

	public function help()
	{
		// Return a string containing help info
		// You could include a file and return it here.
		return "<h4>Overview</h4>
		<p>Calendar will help you organize.</p>
		<p>Creating an event is easy. You can create more than events a day.</p>
                <p>In order to see detail of event of a day, you need to click a date.</p>
               <p>When you want to edit details of an event, click a pop-up.

                </p>";
	}
}
/* End of file details.php */
