<?php
class login_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }

 	public function getLogin($username,$password){
 	// $data=array('username'=>$username,'password'=>$password);
 	$query = $this->db->query("SELECT * FROM user WHERE username='".$username."' AND password='".$password."'");
 	return $query->row();
 	}

	 	
}