<?php
  class Pembeliannew extends CI_Controller {
    public
    function __construct()        {
      parent::__construct();

      $this->load->helper('date');
      $this->load->library('cart');
      $this->load->library('pagination');
     
     
    }

    public
    function index(){
       $this->cart->destroy();
      
    }

    public 
    function getPembelian(){
       $this->load->model('pembelian_model');
       $tgl_now = date('Y-m-d');       
       
       $kode_produk = $this->input->post('id');
       $nama_barang = $this->input->post('nama');
       $harga_beli  = $this->input->post('harga_beli');
       $qty         = $this->input->post('qty');
       
       //cek terlebih dahulu jumlah qty berdasarkan produk list harga
       $cekJumlahHarga=$this->db->query("SELECT kode_produk,harga_beli,qty,tanggal FROM harga_beli WHERE kode_produk='AQGL19' ");
       $cekJumlahStok =$this->db->query("SELECT sum(qty) as jumlah FROM harga_beli WHERE kode_produk='AQGL19' ");

    if($cekJumlahHarga)
       {
        $stok=0;
        $jumlahStok =$cekJumlahStok->row()->jumlah;
        $jumlahRow  =$cekJumlahHarga->num_rows();

          foreach ($cekJumlahHarga->row_array($jumlahRow) as $key) {
            // echo $key->kode_produk." harga :".$key->harga_beli." qty :".$key->qty."</br>";
          }
          echo $jumlahStok."</br>";
          print_r($cekJumlahHarga->row_array($jumlahRow));
          // print_r($cekJumlahHarga->first_row());
         
        }//end if
    }

    public function Isidata(){
    
     $this->load->model('Penjualan_model');
     foreach ($this->cart->contents() as $items)
      {
        $kode_produk=$items['id'];

        $listHarga =$this->Penjualan_model->cekHarga($kode_produk);
        $getStok   =$this->Penjualan_model->cekJumlahStok($kode_produk);
        $getRow    =$listHarga->num_rows();
        
        foreach ($listHarga->row_array() as $key) {
           
        }
        
      } 
    }

    public function insertSample(){
        $row = array('id'    =>'AQGL19',
                     'name'  =>'OKE',
                     'price' =>0,
                     'qty'   =>'5');
        $this->cart->insert($row);
    }


}