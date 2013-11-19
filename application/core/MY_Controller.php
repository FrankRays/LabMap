<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of MY_Controller
 *
 * @author sjonnala
 */
class MY_Controller extends CI_Controller{
	
	public function __construct()
	{
		parent::__construct();
		$this->output->nocache();
		$this->output->enable_profiler(true);
		$this->load->library('Auth_AD');
		
		if(!$this->auth_ad->is_authenticated()){
			$this->session->sess_destroy();
			if($this->input->is_ajax_request()) {
				redirect('/login/unauth','location',401);
			}
			else{
				redirect('/login/unauth');
			}
		}
		$this->data=array(
			'appName'=>APPLICATION_NAME,
			'fullUserName'=> $this->session->userdata('username')
		);
	}
	
}

/* End of file MY_Controller.php */
/* Location: /application/core/MY_Controller.php */
