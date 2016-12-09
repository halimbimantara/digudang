<?php
class User extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('User_model');
                // $this->load->helper('url_helper');
        }
        public function index()
        {
                  $data['produk'] = $this->Penjualan_model->getProduk();
                  $this->load->view('dashboard/header');
                  $this->load->view('dashboard/left_menu.php');
                  $this->load->view('pembelian/index', $data);
                  $this->load->view('dashboard/_js');
        }
// ==============================data pelanggan=================================//
        public function datapelanggan(){
            $this->load->model('User_model');
            $data['pelanggan']=$this->User_model->getSuplier('pelanggan');
                  $this->load->view('dashboard/header');
                  $this->load->view('dashboard/left_menu.php');
                  $this->load->view('datauser/data_pelanggan',$data);
                  $this->load->view('dashboard/_js');
        }

        public function addPelanggan(){
           $nama_plgn=$this->input->post("nama");
           $alamat_plgn=$this->input->post("alamat");
           $no_tlpn=$this->input->post("no");
           $jarak=$this->input->post("jarak");

           $dataPelaggan= array('nama_pelanggan' =>$nama_plgn ,'alamat_pelanggan'=>$alamat_plgn,'no_tlpn'=>$no_tlpn,'jarak'=>$jarak);
           // $this->db->insert('mytable', $data);
            $q_insert=$this->db->insert('pelanggan', $dataPelaggan);
        }
         public function delPelanggan(){
            $id=$this->input->post("id");
            $this->load->model('User_model');
            
            $this->db->where('id_pelanggan',$id);
            $this->db->delete('pelanggan');
            echo "Berhasil";
        }
          public function updatePelanggan(){
            $id      =$this->input->post("id");
            $nama    =$this->input->post("nama");
            $alamat  =$this->input->post("alamat");
            $no_tlpn =$this->input->post("no_tlpn");
            $jarak =$this->input->post("jarak");
      $sql="UPDATE pelanggan SET nama_pelanggan= '$nama',
                                 alamat_pelanggan='$alamat',
                                 no_tlpn='$no_tlpn',
                                 jarak='$jarak' 
                            WHERE id_pelanggan = '$id'";
    $this->db->query($sql);
    echo "Berhasil Diupdate";

        }

//=============================end pelanggan===========================================//

// ==============================data petugas delivery=================================//
        public function datapetugasdelivery(){
          $this->load->model('User_model');
          $data['deliver']=$this->User_model->getSuplier('petugas_delivery');
          $data['cd'] =$this->User_model->getSuplier('ongkir');


                  $this->load->view('dashboard/header');
                  $this->load->view('dashboard/left_menu.php');
                  $this->load->view('datauser/data_petugasdeliver',$data);
                  $this->load->view('dashboard/_js');
        }

        public function addPetugasdelivery(){
           $nama_petugas    =$this->input->post("nama_petugas");
           $alamat_petugas  =$this->input->post("alamat");
           $no_tlpn         =$this->input->post("no");

           $dataPetDelivery = array('nama_petugas' =>$nama_petugas ,'alamat'=>$alamat_petugas,'no_tlpn'=>$no_tlpn);

           $q_insert=$this->db->insert('petugas_delivery', $dataPetDelivery);
           if ($q_insert == TRUE) {
              echo "Berhasi Ditambahkan";
           }else{
              echo "Gagal Ditambahkan Kontak Developer";
           }

        }

        public function delPetugasdelivery(){
            $id=$this->input->post("id");
            $this->load->model('User_model'); 

            $this->db->where('id_petugas',$id);
            $this->db->delete('petugas_delivery');
            echo "Berhasil";
        }

        public function updatePetugasdelivery(){
            $id      =$this->input->post("id");
            $nama    =$this->input->post("nama");
            $alamat  =$this->input->post("alamat");
            $no_tlpn =$this->input->post("no_tlpn");

      $sql="UPDATE petugas_delivery SET nama_petugas= '$nama',alamat='$alamat',no_tlpn='$no_tlpn' WHERE 
      `id_petugas` = '$id'";
    $this->db->query($sql);
    echo "Berhasil Diupdate";
        }

        public function updateOngkir(){
            $id   =$this->input->post("id");
            $sc   =$this->input->post("sc");
            $dc   =$this->input->post("dc");
            $dckm =$this->input->post("dckm");

      $sql="UPDATE ongkir SET biaya_sc= '$sc',biaya_dc='$dc',biaya_dckm='$dckm' 
      WHERE `id_delivery` = '$id'";
    $this->db->query($sql);
    echo "Berhasil Diupdate";
  }

//=============================End pet Delivery=====================================//

// ==============================data suplier=================================//
        public function datasuplier(){
            $this->load->model('User_model');
            $data['suplier']=$this->User_model->getSuplier('suplier');

            $this->load->view('dashboard/header');
            $this->load->view('dashboard/left_menu.php');
            $this->load->view('datauser/data_suplier',$data);
            $this->load->view('dashboard/_js');
        }

        public function addSuplier(){

           $nama_suplier=$this->input->post("nama");
           $alamat_suplier=$this->input->post("alamat");
           $no_tlpn=$this->input->post("no");

           $dataSuplier = array('nama' =>$nama_suplier ,'alamat'=>$alamat_suplier,'no_tlpn'=>$no_tlpn);

           $q_insert=$this->db->insert('suplier', $dataSuplier);
           if ($q_insert == TRUE) {
              echo "Berhasi Ditambahkan";
           }else{
              echo "Gagal Ditambahkan Kontak Developer";
           }

        }
        public function delSuplier(){
            $id=$this->input->post("id");
            $this->load->model('User_model');
            $this->db->where('kode_suplier',$id);
            $this->db->delete('suplier');
            echo "Berhasil";
        }

        public function updateSuplier(){
            $id      =$this->input->post("id");
            $nama    =$this->input->post("nama");
            $alamat  =$this->input->post("alamat");
            $no_tlpn =$this->input->post("no_tlpn");

      $sql="UPDATE suplier SET nama= '$nama',alamat='$alamat',no_tlpn='$no_tlpn' WHERE `kode_suplier` = '$id'";
    $this->db->query($sql);
    echo "Berhasil Diupdate";

        }
//============================= End suplier=====================================//

// ==============================data petugas kasir=================================//
//pegawai
        public function dataKasir(){
           $this->load->model('User_model');
            $data['pegawai']=$this->User_model->getSuplier('pegawai');
                  $this->load->view('dashboard/header');
                  $this->load->view('dashboard/left_menu.php');
                  $this->load->view('datauser/data_petugaskasir',$data);
                  $this->load->view('dashboard/_js');
        }

        public function addKasir(){
           $nama_plgn  =$this->input->post("nama");
           $alamat_plgn=$this->input->post("alamat");
           $no_tlpn    =$this->input->post("no");

           $dataPelaggan= array('nama_pegawai' =>$nama_plgn ,'alamat'=>$alamat_plgn,'no_tlpn'=>$no_tlpn);
           // $this->db->insert('mytable', $data);
            $q_insert=$this->db->insert('pegawai', $dataPelaggan);
          
        }
        public function delKasir(){
            $id=$this->input->post("id");
            $this->load->model('User_model');
            
            $this->db->where('id_pelanggan',$id);
            $this->db->delete('pelanggan');
            echo "Berhasil";
        }
        public function updateKasir(){
          $id      =$this->input->post("id");
          $nama    =$this->input->post("nama");
          $alamat  =$this->input->post("alamat");
          $no_tlpn =$this->input->post("no_tlpn");
          $status  =$this->input->post("jarak");

          $sql="UPDATE pelanggan SET 
                                 nama_pegawai='$nama',
                                 alamat='$alamat',
                                 no_tlpn='$no_tlpn',
                                 status='$jarak' 
                 WHERE pegawai_id = '$id'";
    $this->db->query($sql);
    echo "Berhasil Diupdate";
        }

        public function view_gaji(){
          
        }

        public function tambahGaji(){
           $nama_pegawai  =$this->input->post("nama");
           $alamat_plgn   =$this->input->post("alamat");
           $no_tlpn       =$this->input->post("no");
        }


  public function tesproduk(){
      $this->load->model('Penjualan_model');
      $produk=$this->db->query("SELECT kode_produk,nama_produk,harga_beli,harga_jual,grosir,jumlah_stok,tanggal_buat,status FROM produk WHERE nama_produk='Aqua 330 ML' ");     
      foreach($produk->result() as $row) {
        echo   $row->kode_produk;
      }    
  }

        // public function tambahGaji(){
          
        // }

//=============================end kasir=====================================//
        /*
        SET @tgl1='2016-06-18';
SET @tgl2='2016-06-20';
SET @tgl3='2016-06-21';
SET @tgl4='2016-06-22';
SET @tgl5='2016-06-23';
SET @tgl6='2016-06-24';



SET @NAMA3='ERMA';
INSERT INTO `tb_gaji` (nama_pegawai,salary,tanggal) VALUES (@NAMA3,'40000',@tgl1);
INSERT INTO `tb_gaji` (nama_pegawai,salary,tanggal) VALUES (@NAMA3,'40000',@tgl2);
INSERT INTO `tb_gaji` (nama_pegawai,salary,tanggal) VALUES (@NAMA3,'40000',@tgl3);
INSERT INTO `tb_gaji` (nama_pegawai,salary,tanggal) VALUES (@NAMA3,'40000',@tgl4);
INSERT INTO `tb_gaji` (nama_pegawai,salary,tanggal) VALUES (@NAMA3,'40000',@tgl5);
INSERT INTO `tb_gaji` (nama_pegawai,salary,tanggal) VALUES (@NAMA3,'40000',@tgl6);



SET @NAMA1='FAJAR';

INSERT INTO tb_gaji (nama_pegawai,salary,tanggal) VALUES (@NAMA1,'35000',@tgl1);
INSERT INTO tb_gaji (nama_pegawai,salary,tanggal) VALUES (@NAMA1,'35000',@tgl2);
INSERT INTO tb_gaji (nama_pegawai,salary,tanggal) VALUES (@NAMA1,'35000',@tgl3);
INSERT INTO tb_gaji (nama_pegawai,salary,tanggal) VALUES (@NAMA1,'35000',@tgl4);
INSERT INTO tb_gaji (nama_pegawai,salary,tanggal) VALUES (@NAMA1,'35000',@tgl5);
INSERT INTO tb_gaji (nama_pegawai,salary,tanggal) VALUES (@NAMA1,'35000',@tgl6);

        */
}
