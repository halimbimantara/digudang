<?php
class Login extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                // $this->load->model("login_model");
        }
        public function index()
        {
                  $this->load->view('login/index');
        }

        public function Logout(){
            session_destroy();
            redirect('/login');
        }
        
        public function cekLogin()
        {
              $this->load->model("login_model");

              $us = $this->input->post('unames');
              $pa = $this->input->post('passwd');
              $cek = $this->login_model->getLogin($us,$pa);
              if($cek){
              //session
               $id      =$cek->user_id;
               $username=$cek->username;
               $acces=$cek->acces;
               // session_start();
               $_SESSION['user_id']=$id;
               $_SESSION['uname']=$username;
               $_SESSION['acces']=$acces; 
                echo "1";
              }else{
                echo "0";
              }
            
        }
}