<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Map extends Public_Controller
{
	function __construct()
	{
		parent::Public_Controller();
		$this->lang->load('map');
        $this->template->append_metadata( '<meta name="keywords" content="Interactive Map, Pulia, Apulia, Italy, Map, Google Map, Martina Franca, Ostuni, Locorotondo, Ceglie Messapica, Cisternino, Bari, Brindisi, Trullove Trulli" />')
                       ->append_metadata( '<meta name="description" content="Interactive Map of Puglia, Italy with information about Martina Franca, Ostuni, Locorotondo, Ceglie Messapica, Cisternino, Bari, Brindisi and the Trullove Trulli" />')
                       ->append_metadata( '<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />')
                       ->append_metadata( css('map.css', 'map'))
                       ->append_metadata( js('http://maps.google.com/maps/api/js?sensor=false'))
                       ->append_metadata( js('infobubble.js','map'))
                       ->append_metadata( js('markerjson.js', 'map'))
                       ->append_metadata( js('trullovemap.js','map'));
	}

	function index()
	{
        $this->template->build('index');
	}
}

/* End of file map.php */