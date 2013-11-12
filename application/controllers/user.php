<?php

class User extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model', 'user');
		$this->load->library('form_validation');
		$config = array(
			'user/add' => array(
				array(
					'field' => 'uname',
					'label' => 'Username',
					'rules' => 'trim|required|min_length[4]|max_length[20]|is_unique[user.uname]|alpha_numeric|xss_clean'
				),
				array(
					'field' => 'utype',
					'label' => 'User Type',
					'rules' => 'trim|required|xss_clean|callback_utype_inarray'
				),
				array(
					'field' => 'ltype',
					'label' => 'Login Type',
					'rules' => 'trim|required|xss_clean|callback_ltype_inarray'
				),
				array(
					'field' => 'active',
					'label' => 'Active',
					'rules' => 'trim|xss_clean'
				),
				array(
					'field' => 'passwd',
					'label' => 'Password',
					'rules' => 'trim|required|min_length[8]|max_length[20]|xss_clean|callback_password_check'
				)
			)
		);
		$this->form_validation->set_rules($config["user/add"]);
		if (!in_array($this->session->userdata('utype'), array(UTYPE_ADMIN))) {
			redirect('/home');
		}
	}

	public function password_check($str)
	{
		if (preg_match('#[0-9]#', $str) && preg_match('#[a-zA-Z]#', $str)) {
			return TRUE;
		}
		$this->form_validation->set_message('password_check', 'The %s field needs to have atleast one alphabet and one number');
		return FALSE;
	}

	public function ltype_inarray($int)
	{
		if(!in_array(intval($int), array(LTYPE_AD,LTYPE_LOCAL))){
			$this->form_validation->set_message('ltype_inarray', 'The %s field was altered refresh and try again.');
			return false;
		}
		return true;
	}
	
	public function utype_inarray($int)
	{
		if(!in_array(intval($int), array(UTYPE_ADMIN,UTYPE_TA))){
			$this->form_validation->set_message('utype_inarray', 'The %s field was altered refresh and try again.');
			return false;
		}
		return true;
	}
	
	public function index($val_errors=null)
	{
		$this->data['obj_users']= $this->user->get_all();
		$this->data['val_errors']=$val_errors;
		$this->load->view('components/header');
		$this->load->view('components/navBar',  $this->data);
		
		$this->_load_user_list($this->session->userdata('utype'));
		
		$this->load->view('components/footer');
	}
	
	private function _load_user_list($current_utype)
	{
		$current_utype=intval($current_utype);
		if(in_array($current_utype, array(UTYPE_ADMIN))){
			$d["mode"]=$current_utype;
			$this->load->view('components/admin/userList',$d);
		}
	}
	
	public function add()
	{

		if ($this->form_validation->run() == TRUE) {
			$add_uname = strtolower($this->input->post('uname'));
			$add_utype = intval($this->input->post('utype'));
			
			$add_passwd= $this->input->post('passwd');
			$add_ltype = intval($this->input->post('ltype'));
			
			
			if ($this->input->post('active') == "on") {
				$add_active = 1;
			}
			else{
				$add_active=0;
			}
			
			$this->user->insert(array(
				'uname' => $add_uname,
				'utype' => $add_utype,
				'ltype' => $add_ltype,
				'active' => $add_active,
				'passwd' => $this->encrypt->sha1($add_passwd)
			));
			$this->index();
		}
		else {
			$this->index(validation_errors());
		}
	}

	public function edit()
	{

		dump($this->input->ip_address());
		dump($this->input->user_agent());
		dump($this->input->request_headers());
	}

	public function delete()
	{
		$id = intval($this->uri->segment(3));
		$this->user->delete($id);
		redirect("/user");
	}

	public function statuschange()
	{
		$id = intval($this->uri->segment(3));
		$row = $this->user->get($id);
		if ($row->active == 1) {
			$active = 0;
		}
		else {
			$active = 1;
		}
		$this->user->update($id, array('active' => $active));
		redirect("/user");
	}
}

/* End of file user.php */
/* Location:  */