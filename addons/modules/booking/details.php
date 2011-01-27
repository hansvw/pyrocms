<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Booking extends Module {

	public $version = '1.0';

    public $table = array(
        "rsperson" =>   "
			CREATE TABLE `rsperson` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `firstname` varchar(255) NOT NULL,
			  `lastname` varchar(255) NOT NULL,
			  `email` varchar(255) NOT NULL,
              `country` varchar(255) NOT NULL,
              `language` varchar(255) NOT NULL,
			  `tel1` varchar(16),
			  `tel2` varchar(16),
			  PRIMARY KEY (`id`),
              UNIQUE KEY `email` (`email`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		",
        "rspricing" => "
			CREATE TABLE `rspricing` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`name` varchar(64) NOT NULL,
				`description` varchar(255) NOT NULL,
				`startdate` date,
				`enddate` date,
                `price` decimal(10,2) NOT NULL, 
				`disabled` boolean NOT NULL,
				PRIMARY KEY (`id`),
				UNIQUE KEY `name` (`name`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		",
        "rsdiscount" => "
			CREATE TABLE `rsdiscount` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`name` varchar(64) NOT NULL,
				`startdate` date,
				`enddate` date,
				`description` varchar(255) NOT NULL,
				`percentage` decimal(10,2),
				`fixeddiscount` decimal(10,2),
				PRIMARY KEY (`id`),
				UNIQUE KEY `name` (`name`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		",
        "rsreservationstatus" => "
			CREATE TABLE `rsreservationstatus` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` varchar(255) NOT NULL,
              `description` varchar(255) NOT NULL,
			  PRIMARY KEY (`id`),
			  UNIQUE KEY `name` (`name`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		",
		"rsreservation" => "
			CREATE TABLE `rsreservation` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `code` varchar(255) NOT NULL,
			  `person_id` int(11) NOT NULL,
              `dtreservation` DATETIME NOT NULL,
              `startdate` DATE NOT NULL,
              `enddate` DATE NOT NULL,
              `starttime` TIME DEFAULT NULL,
              `enddtime` TIME DEFAULT NULL,
              `message` varchar(2048) DEFAULT NULL,
			  `status` varchar(255) NOT NULL,
			  PRIMARY KEY (`id`),
			  UNIQUE KEY `code` (`code`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		",
        "rscalendar" => "
			CREATE TABLE `rscalendar` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `calendardate` date NOT NULL,
              `reservation_code` varchar(255) DEFAULT NULL,
			  `reservation_status` varchar(255) NOT NULL,
			  PRIMARY KEY (`id`),
			  UNIQUE KEY `calendarresource` (`calendardate`),
              KEY `reservation_code` (`reservation_code`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		"
    );

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Booking',
				'de' => 'Reservierung',
				'nl' => 'Reservaties',
				'fr' => 'Réservations',
				'zh' => '预订',
				'it' => 'Prenotazione',
				'ru' => 'Бронирование',
				'ar' => 'الحج',
				'pt' => 'Reservas',
				'cs' => 'Rezervace',
				'es' => 'Reservas'
			),
			'description' => array(
				'en' => 'The booking module manages reservations (e.g. of a property).',
				'de' => 'Die Buchung Modul verwaltet Reservierungen.',
				'nl' => 'De reservatie module beheert reservaties.',
				'fr' => 'Le module de réservation gère les réservations.',
				'zh' => '预定模块管理保留',
				'it' => 'Il modulo di prenotazione gestisce le prenotazioni.',
				'ru' => 'Бронирование модуль управляет оговорок.',
				'ar' => 'وحدة حجز تدير التحفظات.',
				'pt' => 'O módulo de reserva gerencia reservas.',
		    	'cs' => 'Modul spravuje rezervaci výhrady.',
				'es' => 'El módulo de reserva gestiona las reservas.'
			),
			'frontend' => TRUE,
			'backend' => TRUE,
			'menu' => 'content'
		);
	}

	public function install()
	{
        $this->dbforge->drop_table('rsperson');
		$this->dbforge->drop_table('rspricing');
		$this->dbforge->drop_table('rsdiscount');
		$this->dbforge->drop_table('rsreservationstatus');
		$this->dbforge->drop_table('rsreservation');
		$this->dbforge->drop_table('rscalendar');

		if(	$this->db->query($this->table['rsperson']) &&
			$this->db->query($this->table['rspricing']) &&
			$this->db->query($this->table['rsdiscount']) &&
			$this->db->query($this->table['rsreservationstatus']) &&
			$this->db->query($this->table['rsreservation']) &&
			$this->db->query($this->table['rscalendar']))
		{
            $reservationstatuscodes = array(
                array(   'name' => 'confirmed',
                    'description' => 'reservation is confirmed'),
                array(   'name' => 'cancelled',
                    'description' => 'reservation has been cancelled'),
                array(   'name' => 'pending',
                    'description' => 'reservation has not yet been confirmed')
            );

            foreach($reservationstatuscodes as $reservationstatus)
            {
                if(!$this->db->insert('rsreservationstatus', $reservationstatus))
                {
                    return FALSE;
                }
            }

			return TRUE;
		}
	}

	public function uninstall()
	{
		if( $this->dbforge->drop_table('rsperson') &&
			$this->dbforge->drop_table('rspricing') &&
			$this->dbforge->drop_table('rsdiscount') &&
			$this->dbforge->drop_table('rsreservationstatus') &&
			$this->dbforge->drop_table('rsreservation') &&
			$this->dbforge->drop_table('rscalendar'))
		{
			return TRUE;
		}
	}


	public function upgrade($old_version)
	{
    /// Upgrade Logic
		return TRUE;
	}

	public function help()
	{
    /// Help information in string format
        return "No documentation has been added for this module.<br/>Contact the module developer for assistance.";
	}
}
/* End of file details.php */
