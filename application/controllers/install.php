<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Install extends CI_Controller {
	public function index(){
		$this->load->view('installer/header.php');
		$this->load->view('installer/welcome.php');
		$this->load->view('installer/footer.php');
	}
	
	
	
}

/* End of file install.php */
/* Location: ./application/controllers/install.php */
