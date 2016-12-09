<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Laporan extends CI_Controller{
    //put your code here
     public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('fpdf');
        
    } 
    
    public function index() {
        unset($_SESSION['tgl_awal']);
        unset($_SESSION['tgl_akhir']);
        unset($_SESSION['TOTAL']);
        unset($_SESSION['DEBET']);
        unset($_SESSION['LABA']);
        unset($_SESSION['total']);
        unset($_SESSION['laba']);
        unset($_SESSION['SC']);
        unset($_SESSION['DC']);
        unset($_SESSION['DCKM']);

        $this->load->model('Penjualan_model');
        $res['data'] = $this->Penjualan_model->getProduk();
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/left_menu.php');
        $this->load->view('laporan/pembelian_penjualan',$res);
        $this->load->view('dashboard/_js');
    }

      public function Pembelian() {
        $this->load->model('pembelian_model');
        $res['data'] = $this->pembelian_model->LaporanPembelian();
        $this->load->view('laporan/laporan_pembelian',$res);
    }

    public function Delivery(){
        unset($_SESSION['tgl_awal']);
        unset($_SESSION['tgl_akhir']);
        
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/left_menu.php');
        $this->load->view('laporan/laporan_dc');
        $this->load->view('dashboard/_js');   
    }


    public function pdfAll(){
        $this->load->model('pembelian_model');
        $this->load->model('Penjualan_model');

        $tgl_awal = $this->input->post('pp_tglmulai');
        $tgl_akhir= $this->input->post('pp_tglakhir');

        $t_awal  =$this->pembelian_model->getTanggal($tgl_awal);
        $t_akhir =$this->pembelian_model->getTanggal($tgl_akhir);
        
        //--------------------------------------TOTAL PEMBELIAN--------------------------------//
        $res['data'] = $this->pembelian_model->getLaporanPembelian($t_awal,$t_akhir);
        $GetTotalPembelian=$this->pembelian_model->getTotalPembelian($t_awal,$t_akhir);
        $cekTotal=$GetTotalPembelian->row();
        $totalPembelian=$cekTotal->total;
        $res['totalpembelian']=$totalPembelian;
        //-------------------------------------------------------------------------------------//

        //-------------------------------Total Pembelian Lain------------------------------------//
        $res['databelilain'] = $this->pembelian_model->getLaporanPembelianLain($t_awal,$t_akhir);
        $GetTotalPembelianLain=$this->pembelian_model->getTotalPembelianLain($t_awal,$t_akhir);
        $GetTotalUangToko=$this->pembelian_model->getTotalPembelianUangtoko($t_awal,$t_akhir)->row();
        
        $cekTotalLain=$GetTotalPembelianLain->row();
        $totalPembelianLain=$cekTotalLain->total;
        $res['totalpembelianlain']=$totalPembelianLain+$GetTotalUangToko->total;  
        //----------------------------------------------------------------------------------------//

       
        //********************************** END PEMBELIAN ******************************************
         //-------------------------------------BALANCE------------------------------------------   
            // 
        $res['databalance'] = $this->pembelian_model->getLaporanBalance($t_awal,$t_akhir);
        
         $ttbl= $this->pembelian_model->getLaporanTotalBalance($t_awal,$t_akhir);
        $res['totalbalance']=$ttbl->row()->balance;
        //====================================START PENJUALAN========================================
        $t_awal=$this->Penjualan_model->getTanggal($tgl_awal);
        $t_akhir=$this->Penjualan_model->getTanggal($tgl_akhir);
        //==============================================================================================
        $res['datapenjualan'] = $this->Penjualan_model->getLaporanPenjualanByNota($t_awal,$t_akhir);

        $GetTotalJual=$this->Penjualan_model->getTotalPenjualanByNota($t_awal,$t_akhir);
        $defi_Delivery=$this->Penjualan_model->getTotalCD($t_awal,$t_akhir)->row();

        $cekTotalJual=$GetTotalJual->row();

        $totalNota =$cekTotalJual->total;
        $totalLaba =$cekTotalJual->laba;
        
        $totalSC  = $defi_Delivery->SC;
        $totalDC  = $defi_Delivery->DC;
        $totalDCKM= $defi_Delivery->DCKM;
        $totalDV  = $defi_Delivery->TOTAL;

        $_SESSION['total']= $totalNota+$totalDV;
        $_SESSION['laba'] = $totalLaba;
        $_SESSION['SC']= $totalSC;
        $_SESSION['DC'] = $totalDC;
        $_SESSION['DCKM']= $totalDCKM;

        $_SESSION['tgl_awal']=$tgl_awal;
        $_SESSION['tgl_akhir']=$tgl_akhir;

        $this->load->view('laporan/pdf_pembelian_penjualan',$res);  

    }


    public  function SaveToPdfPembelian()
    {
        $this->load->model('pembelian_model');
        $tgl_awal = $this->input->post('Pemb_tglmulai');
        $tgl_akhir= $this->input->post('Pemb_tgl_akhir');
        $res['oke'] = 1;
        
        $t_awal  =$this->pembelian_model->getTanggal($tgl_awal);
        $t_akhir =$this->pembelian_model->getTanggal($tgl_akhir);

        $res['data'] = $this->pembelian_model->getLaporanPembelianDetail($t_awal,$t_akhir);
        $res['datas'] = $this->pembelian_model->getLaporanPembelianLain($t_awal,$t_akhir);
        $res['total']="1000";

        $GetTotal=$this->pembelian_model->getTotalPembelian($t_awal,$t_akhir);
        $cekTotal=$GetTotal->row();
        $totalPembelian=$cekTotal->total;


         $res['databalance'] = $this->pembelian_model->getLaporanBalance($t_awal,$t_akhir);
         $ttbl= $this->pembelian_model->getLaporanTotalBalance($t_awal,$t_akhir);
         $res['totalbalance']=$ttbl->row()->balance;

        $_SESSION['TOTAL']= $totalPembelian;
        $_SESSION['tgl_awal']=$tgl_awal;
        $_SESSION['tgl_akhir']=$tgl_akhir;

        $this->load->view('laporan/pdf_pembelian',$res);
       
    }

 public  function NotaPdfPembelian()
    {
        $this->load->model('pembelian_model');
        $tgl_awal = $this->input->post('Pemb_tglmulai');
        $tgl_akhir= $this->input->post('Pemb_tgl_akhir');
       
        
        $t_awal  =$this->pembelian_model->getTanggal($tgl_awal);
        $t_akhir =$this->pembelian_model->getTanggal($tgl_akhir);

        $res['data']  = $this->pembelian_model->getLaporanPembelianByNota($t_awal,$t_akhir);
        $res['datas'] = $this->pembelian_model->getLaporanPembelianLain($t_awal,$t_akhir);

        $GetTotal=$this->pembelian_model->getTotalPembelian($t_awal,$t_akhir);
        $cekTotal=$GetTotal->row();
        $totalPembelian=$cekTotal->total;

        $_SESSION['TOTAL']= $totalPembelian;
        $_SESSION['tgl_awal']=$tgl_awal;
        $_SESSION['tgl_akhir']=$tgl_akhir;

        $this->load->view('laporan/pdf_pembelian',$res);
       
    }

     public  function SaveToPdfPenjualan(){
        $this->load->model('Penjualan_model');
        $tgl_awal = $this->input->post('penj_tglmulai');
        $tgl_akhir= $this->input->post('penj_tglakhir');
        
        $t_awal=$this->Penjualan_model->getTanggal($tgl_awal);
        $t_akhir=$this->Penjualan_model->getTanggal($tgl_akhir);

        $res['data'] = $this->Penjualan_model->getLaporanPenjualan($t_awal,$t_akhir);
        $GetTotal=$this->Penjualan_model->getTotalPenjualan($t_awal,$t_akhir);
        $cekTotal=$GetTotal->row();
        $totalDebet=$cekTotal->total;
        $totalLaba =$cekTotal->laba;

        $_SESSION['DEBET']= $totalDebet;
        $_SESSION['LABA'] = $totalLaba;

        $_SESSION['tgl_awal']=$tgl_awal;
        $_SESSION['tgl_akhir']=$tgl_akhir;
        $this->load->view('laporan/pdf_penjualan',$res);
    }

public  function NotaPdfPenjualan(){
        $this->load->model('Penjualan_model');
        $tgl_awal = $this->input->post('penj_tglmulai');
        $tgl_akhir= $this->input->post('penj_tglakhir');
        
        $t_awal=$this->Penjualan_model->getTanggal($tgl_awal);
        $t_akhir=$this->Penjualan_model->getTanggal($tgl_akhir);
        $res['data'] = $this->Penjualan_model->getLaporanPenjualanByNota($t_awal,$t_akhir);

        $GetTotalJual=$this->Penjualan_model->getTotalPenjualanByNota($t_awal,$t_akhir);
        $defi_Delivery=$this->Penjualan_model->getTotalCD($t_awal,$t_akhir)->row();

        $cekTotalJual=$GetTotalJual->row();

        $totalNota =$cekTotalJual->total;
        $totalLaba =$cekTotalJual->laba;
        
        $totalSC  = $defi_Delivery->SC;
        $totalDC  = $defi_Delivery->DC;
        $totalDCKM= $defi_Delivery->DCKM;
        $totalDV  = $defi_Delivery->TOTAL;

        $_SESSION['LPtotal']= $totalNota+$totalDV;
        $_SESSION['LPlaba'] = $totalLaba;
        $_SESSION['LPSC']= $totalSC;
        $_SESSION['LPDC'] = $totalDC;
        $_SESSION['LPDCKM']= $totalDCKM;

        $_SESSION['LPtgl_awal']=$tgl_awal;
        $_SESSION['LPtgl_akhir']=$tgl_akhir;
        $this->load->view('laporan/pdf_penjualan_nota',$res);
    }

    public function SaveToPdfCD(){
        $this->load->model('Penjualan_model');
        $tgl_awal = $this->input->post('Pemb_tglmulai');
        $tgl_akhir= $this->input->post('Pemb_tgl_akhir');

        $t_awal=$this->Penjualan_model->getTanggal($tgl_awal);
        $t_akhir=$this->Penjualan_model->getTanggal($tgl_akhir);

        $res['data']=$this->Penjualan_model->getCostDelivery($t_awal,$t_akhir);
        
        $_SESSION['tgl_awal']=$tgl_awal;
        $_SESSION['tgl_akhir']=$tgl_akhir;

        $this->load->view('laporan/pdf_cd',$res);
        
    }

    public function pdfbelilain(){
        $this->load->model('pembelian_model');
        $tgl_awal = $this->input->post('lain_tglmulai');
        $tgl_akhir= $this->input->post('lain_tglakhir');
        
        $t_awal  =$this->pembelian_model->getTanggal($tgl_awal);
        $t_akhir =$this->pembelian_model->getTanggal($tgl_akhir);
        // $GetTotalUangToko=$this->pembelian_model->getTotalPembelianUangtoko($t_awal,$t_akhir)->row();
        $res['data'] = $this->pembelian_model->getLaporanPembelianLain($t_awal,$t_akhir);

        $GetTotal=$this->pembelian_model->getTotalPembelianLain($t_awal,$t_akhir);
        $cekTotal=$GetTotal->row();
        $totalPembelian=$cekTotal->total;

        $res['total']= $totalPembelian;
        $_SESSION['tgl_awal']=$tgl_awal;
        $_SESSION['tgl_akhir']=$tgl_akhir;
        $this->load->view('laporan/laporan_pembelianlain',$res);
    }


 public function pdfStok(){  
        
        $this->load->model('pembelian_model');
        $tgl_awal = $this->input->post('ss_tglmulai');
        $tgl_akhir= $this->input->post('ss_tglakhir');
        
        $t_awal  =$this->pembelian_model->getTanggal($tgl_awal);
        $t_akhir =$this->pembelian_model->getTanggal($tgl_akhir);

        $res['data'] = $this->pembelian_model->getLaporanStok($t_awal,$t_akhir);
        $_SESSION['tgl_awal']=$tgl_awal;
        $_SESSION['tgl_akhir']=$tgl_akhir;
        $this->load->view('laporan/laporan_stok',$res);
    }

    public function jumlahstok(){
        $res['data'] = $this->db->query("SELECT nama_produk,jumlah_stok FROM produk");
        $this->load->view('laporan/stok_barang',$res);
    }
    public function cekStok(){
        $this->load->model('Penjualan_model');
        $tgl_awal = $this->input->post('Pemb_tglmulai');
        $tgl_akhir= $this->input->post('Pemb_tgl_akhir');
    }

/*
    Mencetak nota berdasarkan no nota yang di inputkan
*/
    public function cetakNota(){
         $this->load->view('dashboard/header');
         $this->load->view('dashboard/left_menu.php');
         $this->load->view('laporan/cetak_nota');
         $this->load->view('dashboard/_js');
    }


    public function neraca(){
         $this->load->view('dashboard/header');
         $this->load->view('dashboard/left_menu');
         $this->load->view('laporan/view_neraca');
         $this->load->view('dashboard/_js');
    }


    public function neracaSaldo(){
        $this->load->model('pembelian_model');
        $this->load->model('Retribusi');
        $tgl_awal = $this->input->post('Pemb_tglmulai');
        $tgl_akhir= $this->input->post('Pemb_tgl_akhir');
        
        $t_awal  =$this->pembelian_model->getTanggal($tgl_awal);
        $t_akhir =$this->pembelian_model->getTanggal($tgl_akhir);
    // $GetTotalUangToko=$this->pembelian_model->getTotalPembelianUangtoko($t_awal,$t_akhir)->row();
         
         $_SESSION['tgl_awal']=$tgl_awal;
         $_SESSION['tgl_akhir']=$tgl_akhir;

        $res['data'] = $this->Retribusi->getneracasaldo($t_awal,$t_akhir);
        $res['total']=$this->Retribusi->getneracasaldotot($t_awal,$t_akhir);
        // $res['stok'] =$this->Retribusi->getStokAssetBeli($t_awal,$t_akhir);
        $this->load->view('laporan/neraca_1',$res);
    }

    public function labaRugi(){
        $this->load->model('pembelian_model');

        $tgl_awal  = $this->input->post('lain_tglmulai');
        $tgl_akhir = $this->input->post('lain_tglakhir');
        
        $t_awal  = $this->pembelian_model->getTanggal($tgl_awal);
        $t_akhir = $this->pembelian_model->getTanggal($tgl_akhir);

        $this->load->model('Retribusi');
        $res['data']  = $this->Retribusi->labarugi($t_awal,$t_akhir);
        $res['total'] = $this->Retribusi->getTotalLabaRugi($t_awal,$t_akhir);
        $_SESSION['tgl_awal']=$tgl_awal;
        $_SESSION['tgl_akhir']=$tgl_akhir;
        $this->load->view('laporan/pdf_labarugi',$res);
    }

    public function gaji(){
         $this->load->view('dashboard/header');
         $this->load->view('dashboard/left_menu.php');
         $this->load->view('dashboard/_js');
         $pegawai=$this->db->query("SELECT * FROM pegawai WHERE status=1");
         $res['pegawai']=$pegawai;
          $this->load->view('laporan/gaji_pegawai',$res);
         
    }

    public function cetakgaji(){
        $id_pegawai=$this->input->post('nama_pegawai');
        $s_tanggal =$this->input->post('tgl_awal');
        $e_tanggal =$this->input->post('tgl_akhir');

        
        
    }
    
}    