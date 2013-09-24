<?php
class Login extends CI_Controller{
	public $data = array(
		'login_title'=>APPLICATION_NAME,
		'msg'=>''
	);
	
	public function __construct()
	{
		parent::__construct();
		$this->output->nocache();
		$this->load->library('Auth_AD');
		if($this->auth_ad->is_authenticated())
		{
			redirect('/home');
		}
	}
	
	public function _remap($method){
		$this->data['msg']=$method;
		$this->index();
	}
	
	public function index(){
		$this->load->view('components/header');
		$this->load->view('login',$this->data);
		$this->load->view('components/footer');
	}
	
}
/* End of file login.php */
/* Location:  */