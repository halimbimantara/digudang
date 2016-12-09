<?php
class User_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }

 		public function getAllUser($tablename,$num, $offset){
	 		 $query = $this->db->get($tablename,$num, $offset);
	  		 return $query->result();
	 	} 
	 	public function getSuplier($tablename){
	 		 $query = $this->db->get($tablename);
	 		 return $query->result();
	 	}

	 	

	 	
}