<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Listener extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('system_model','system');
	}

	/**
	 * takes the post data from the labMap-probe and stores it into the database.
	 */
	public function index() {
		
		//TODO : Encrytpted json object should be decoded
		if (isset($_POST['data'])) {
			// Remove Padding
			dump($_POST);
			$pad = "L@bM4P_p@66";
			$json = str_replace($pad, "", $_POST['data']);
			// Decode JSON objects to PHP objects
			$obj = json_decode($json, true);
			dump($obj);
			
			
			$systemExists = $this->system->get_by('sysName',$obj["system"]);
			if($obj["function"]=="login" && $obj["LoggedIn"]==true){
				if($systemExists == true){
					$this->system->update($systemExists->sysId, array(
						'ninerNetUser'=>$obj["username"],
						'sysName'=>$obj["system"],
						'status'=>1
					));
				}
				else{
					$this->system->insert(array(
						'ninerNetUser'=>$obj["username"],
						'sysName'=>$obj["system"],
						'status'=>1
					));
				}
			}
			elseif($obj["LoggedIn"]==false || $obj["function"]=="logout"){
				if($systemExists == true){
					$this->system->update($systemExists->sysId, array(
						'ninerNetUser'=>"",
						'sysName'=>$obj["system"],
						'status'=>0
					));
				}
			}
		}
		
	}
	
	public function test(){
		echo "<form method='POST' action='".site_url('/listener')."'><textarea type='text' name='data' id='data'>L@bM4P_p@66{\"username\":\"MyUname\",\"system\":\"MySysname\",\"function\":\"login\",\"LoggedIn\":true}L@bM4P_p@66</textarea> <input type='submit' value='submit'></form>";
	}

}

/* End of file listener.php */
/* Location:  ./application/controllers/listener.php*/