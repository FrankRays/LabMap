<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
	}
	
	/**
	 * return the API info object
	 */
	public function index(){}
	
	/**
	 * return the computer count in the requested lab.
	 * available
	 * used
	 * total
	 */
	public function computersInLab(){}
	
}
?>
