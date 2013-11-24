<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Listener extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
	}
	
	/**
	 * takes the post data from the labMap-probe and stores it into the database.
	 */
	public function index(){
            
            //TODO : Encrytpted json object should be decoded
           if(isset($_POST['data'])){
            // Remove Padding
            $pad = "L@bM4P_p@66";
            $json = str_replace($pad, "", $_POST['data']);
            //converting into key, value pairs
            $json = str_replace(":", "=>", $json);
            // Decode JSON objects to PHP objects
            $djson = json_decode($json, true);
            echo "$djson";
            }
                // Validation for fields
                foreach($djson as $x=>$x_value){
                    if(is_string($x_value)&&(strlen($x_value)<=30)){
                        $username= mysql_real_escape_string( $x_value['username'] );
                        $system= mysql_real_escape_string( $x_value['system'] );
                        if(($x['function']=='login')&&($x['LoggedIn']=='true')){
                            //Insert Query
//                            $columns = implode(", ",array_keys($djson));
//                            $escaped_values = array_map('mysql_real_escape_string', array_values($djson));
//                            $values  = implode(", ", $escaped_values);
//                            $sql = "INSERT INTO `system`($columns) VALUES ($values)";
                            //{ “username”:”MyUname”, “system”:”MySysname”, “function”:”login/logout”, ”LoggedIn”:”true/false” }
                            $valuesArr[] ="('$username','$system','ok')";
                            $sql = "INSERT INTO 'system'(ninerNetUser, sysName, status) VALUES (implode(',', $valuesArr);)";
                            mysql_query($sql);
                            
                        }elseif(($x['function']=='logout')&&($x['LoggedIn']=='false')){
                            //Insert Query
//                            $columns = implode(", ",array_keys($djson));
//                            $escaped_values = array_map('mysql_real_escape_string', array_values($djson));
//                            $values  = implode(", ", $escaped_values);
//                            $sql = "INSERT INTO 'system'($columns) VALUES ($values)";
                            $valuesArr[] ="('$username','$system','fail')";
                            $sql = "INSERT INTO 'system'(ninerNetUser, sysName, status) VALUES (implode(',', $valuesArr);)";
                            mysql_query($sql);
                        }

                    }

                }
            }

            /*if(isset($djson)){
            $errors = array();
            $required_fields = array('username', 'system', 'function', 'logged_in');
            foreach($required_fields as $fieldname){
                if (!isset($djson) || (empty($djson) && ($djson!=0))){
                    $errors[] = $fieldname;
                }
            }
        
        $fields_with_length = array('username' => 30, 'system' => 30);
        foreach($fields_with_length as $fieldname => $maxlength){
            if(strlen(trim($djson))> $maxlength){
                $errors[] = $fieldname;
            }
        }
        
        if(empty($errors)){
        }

}*/
}

/* End of file listener.php */
/* Location:  ./application/controllers/listener.php*/