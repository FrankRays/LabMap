<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Map extends MY_Controller {

	private $upload_config = array();

	public function __construct() {
		parent::__construct();
		$this->load->model("map_model", "map");
		$this->load->model('building_model','building');
		
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
		$this->data['mapId'] =  intval($this->uri->segment(3));
		$buildings = $this->building->get_many_by('mapId_fk',$this->data['mapId']);
		
		$res = $this->map->get($this->data['mapId']);
		if($res == null){
			redirect('/map');
		}
		
		$this->data['building_object']=$buildings;
		
		$this->data['map_object']=$res;
		$this->load->view('components/header');
		$this->load->view('components/navBar', $this->data);
		if($res->mType == MTYPE_CAMPUS){
			$this->load->view('components/buildCampusMap',$this->data);
		}
		else{
			$this->load->view('components/buildLabMap',$this->data);
		}
		$this->load->view('components/footer');
	}

	public function createBuilding(){
		$return["error"]="";
		$return["status"]=false;
		$return["id"]="";
		$mapId = $this->input->post('mapId');
		$bname=$this->input->post('bname');
		$x1 = $this->input->post('x1');
		$y1 = $this->input->post('y1');
		$x2 = $this->input->post('x2');
		$y2 = $this->input->post('y2');
		$insertId=$this->building->insert(array(
			'building'=>$bname,
			'x1'=>$x1,
			'y1'=>$y1,
			'x2'=>$x2,
			'y2'=>$y2,
			'mapId_fk'=>$mapId
		));
		if($insertId !== FALSE){
			$return["id"]=$insertId;
			$return["status"]=true;
		}
		else{
			$return["error"]="Try again or contact helpdesk.";
		}
		$return["id"]=$insertId;
		$this->output->set_content_type('application/json')->set_output(json_encode($return));
	}
}

/* End of file map.php */
/* Location:  ./application/controllers/map.php*/