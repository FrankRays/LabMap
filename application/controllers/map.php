<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Map extends MY_Controller {

	private $upload_config = array();

	public function __construct() {
		parent::__construct();
		$this->load->model("map_model", "map");
		$this->load->library('form_validation');
		if($this->session->userdata('utype')==UTYPE_ADMIN){
			$this->data['mode']=UTYPE_ADMIN;
		}
		$config = array(
			'map/add' => array(
				array(
					'field' => 'mname',
					'label' => 'Map Name',
					'rules' => 'trim|required|min_length[2]|max_length[50]|is_unique[map.mname]|alpha_numeric|xss_clean'
				),
				array(
					'field' => 'mtype',
					'label' => 'Map Type',
					'rules' => 'trim|required|xss_clean|callback_mtype_inarray'
				),
				array(
					'field' => 'mwidth',
					'label' => 'Map Width',
					'rules' => 'trim|required|numeric|xss_clean'
				),
				array(
					'field' => 'mheight',
					'label' => 'Map Height',
					'rules' => 'trim|required|numeric|xss_clean'
				),
				array(
					'field' => 'mBg',
					'label' => 'Map Background',
					'rules' => 'trim|xss_clean'
				)
			)
		);
		$this->upload_config['upload_path'] = './bgImages/';
		$this->upload_config['allowed_types'] = 'gif|jpg|png';
		$this->upload_config['encrypt_name'] = true;
		$this->upload_config['remove_spaces'] = true;

		$this->form_validation->set_rules($config["map/add"]);
	}

	//call back function for mtype input check.
	public function mtype_inarray($int) {
		if (!in_array(intval($int), array(MTYPE_CAMPUS, MTYPE_LAB))) {
			$this->form_validation->set_message('mtype_inarray', 'The %s field was altered refresh and try again.');
			return false;
		}
		return true;
	}

	/**
	 * show the map list.
	 */
	public function index($val_errors = null) {
		$this->data["obj_maps"] = $this->map->get_all();
		$this->data["val_errors"] = $val_errors;
		$this->load->view('components/header');
		$this->load->view('components/navBar', $this->data);
		$this->load->view('components/mapList', $this->data);
		$this->load->view('components/footer');
	}

	public function add() {
		if ($this->form_validation->run() == TRUE) {
			$map_name = $this->input->post('mname');
			$map_type = intval($this->input->post('mtype'));
			$map_width = intval($this->input->post('mwidth'));
			$map_height = intval($this->input->post('mheight'));

			$this->load->library('upload', $this->upload_config);

			if (!$this->upload->do_upload('mBg')) {
				$error = $this->upload->display_errors();
				$this->index($error);
			} else {
				$map_upload_data = $this->upload->data();
				$this->_create_thumbs($map_upload_data);
				$this->map->insert(array(
					'mname' => $map_name,
					'bgImage' => $map_upload_data['file_name'],
					'mWidth' => $map_width,
					'mHeight' => $map_height,
					'mType' => $map_type
				));
				redirect('/map');
			}
		} else {
			$this->index(validation_errors());
		}
	}

	private function _create_thumbs($data) {
		$this->load->helper('path');
		$config['image_library'] = 'gd2';
		$config['source_image'] = $data['full_path'];
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = 100;
		$config['height'] = 75;
		$config['new_image'] = $data['file_path'] . "thumbs/" . $data['file_name'];
		$config['thumb_marker'] = "";
		$this->load->library('image_lib', $config);
		$this->image_lib->resize();
	}

	public function build() {
		
	}

}

/* End of file map.php */
/* Location:  ./application/controllers/map.php*/