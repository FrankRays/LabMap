<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Map extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model("map_model","map");
	}
	
	/**
	 * show the map list.
	 */
	public function index(){
		$this->load->view('components/header');
		$this->load->view('components/navBar',  $this->data);
		$this->load->view('components/footer');
	}
	
}

/* End of file map.php */
/* Location:  ./application/controllers/map.php*/