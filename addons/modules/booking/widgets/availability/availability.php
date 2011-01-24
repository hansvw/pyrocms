<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Widget_Availability extends Widgets
{
    public $title = 'Availability';
    public $description = 'Display a Calendar with availability of a resource on your site';
    public $author = 'Hans Van Wesenbeeck';
    public $website = 'http://www.aivolution.com';
    public $version = '1.0';
    
    public $fields = array(
        array(
            'field' => 'resource',
            'label' => 'Availability of what?',
            'rules' => 'required'
        ),
        array(
            'field' => 'width',
            'label' => 'Width',
            'rules' => 'required'
        ),
        array(
            'field' => 'height',
            'label' => 'Height',
            'rules' => 'required'
        ),
        array(
            'field' => 'description',
            'label' => 'Description'
        )
    );

/**
  * the $options param is passed by the core Widget class.  If you have
  * stored options in the database,  you must pass the paramater to access
  * them.
  */
	public function run($options)
	{
		return $options;
	}
        
/**
  * form() is used to prepare/pass data to the widget admin form
  * data returned from this method will be available to views/form.php
  */
	public function form()
	{
	}
    
}
?>