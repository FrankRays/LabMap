<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home
 *
 * @author sjonnala
 */
class Home extends MY_Controller {
	protected $data = array();
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$this->load->model('user_model', 'user');
		$this->data['obj_users']= $this->user->get_all();
		
		$this->load->view('components/header');
		$this->load->view('components/navBar',  $this->data);
		
		$this->load->view('components/footer');
	}
	
	public function test(){
		$this->load->view('components/header');
		$this->load->view('components/navBar',$this->data);
		$this->load->model('user_model','user');
		
		dump($this->user->get_all(),true);
		
		$this->load->view('components/footer');
	}
}

/* End of file home.php */
/* Location:  ./application/controllers/home.php*/
