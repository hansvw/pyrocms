<?php defined('BASEPATH') or exit('No direct script access allowed');

class Countries_m extends MY_Model 
{
/**
  * Get all countries
  *
  * @author Hans Van Wesenbeeck
  * @access public
  * @return mixed
  */
	public function get_all()
	{
		$countries = parent::get_all();
		$results = array();
		
		foreach($countries as $country)
		{
			$results[] = $gallery;
		}

	/// Return the results
		return $results;
	}

}

?>
