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
					'rules' => 'trim|required|xss_clean'
				),
				array(
					'field' => 'active',
					'label' => 'Active',
					'rules' => 'trim|xss_clean'
				)
			)
		);
		$this->form_validation->set_rules($config["user/add"]);
		$this->output->enable_profiler(false);
		if (!in_array($this->session->userdata('utype'), array(UTYPE_SU_ADMIN, UTYPE_ADMIN))) {
			redirect('/home');
		}
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
	
	private function _load_user_list($current_utype){
		$current_utype=intval($current_utype);
		if(in_array($current_utype, array(UTYPE_SU_ADMIN,UTYPE_ADMIN))){
			$d["mode"]=$current_utype;
			$this->load->view('components/admin/userList',$d);
		}
	}
	
	public function add()
	{

		if ($this->form_validation->run() == TRUE) {
			$add_uname = strtolower($this->input->post('uname'));
			$add_utype = intval($this->input->post('utype'));

			if ($this->input->post('active') == "on") {
				$add_active = 1;
			}
			else{
				$add_active=0;
			}

			if ($add_utype == UTYPE_SU_ADMIN && $this->session->userdata('utype') != UTYPE_SU_ADMIN) {
				$this->index("No Privilages: Admin cant add SUadmin");
			}
			else {
				$this->user->insert(array(
					'uname' => $add_uname,
					'utype' => $add_utype,
					'ltype' => 1,
					'active' => $add_active
				));
				$this->index();
			}
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