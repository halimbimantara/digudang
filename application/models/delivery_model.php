<?php
class delivery_model extends CI_Model {

        public function __construct()
        {
             $this->load->database();
        }

 		public function getDC($tgl_awal,$tgl_akhir){
	 		 $query=$this->db->query("SELECT master_penjualan.no_nota,pelanggan.nama_pelanggan,
	 		 						         cd.id_petugas,cd.dc,cd.km
									  FROM cost_delivery as cd master_penjualan.id_pelanggan");
	 		 
	 	}

	 	public function getSC($tgl_awal,$tgl_akhir){
	 		$query=$this->db->query("");
	 	}

	 	public function getDCKM($tgl_awal,$tgl_akhir){
	 		$query=$this->db->query("");
	 	}

	 	
}