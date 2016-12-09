<?php
class Dashboard extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('Penjualan_model');
                // $this->load->helper('url_helper');
        }
        public function index()
        {
                  // $data['dashboard'] = $this->Penjualan_model->getAllPenjualan_tmp();
                  $this->load->view('dashboard/header');
                  $this->load->view('dashboard/left_menu.php');
                  $this->load->view('dashboard/index');
                  $this->load->view('dashboard/_js');
        }
        public function view($slug = NULL)
        {
                // $data['news_item'] = $this->news_model->get_news($slug);
        }

        public function insertPenjualan(){
          

        }
        public function Cetak(){
                $data['tgl']=date('Y-m-d');
                $this->load->view('penjualan/cetak',$data);
        }
}
