<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="description" content="CV DIGUDANG STORE">
	<meta name="author" content="Mohamad Halim Bimantara">
	<meta name="keyword" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CV DIGUDANG STORE</title>
  <!-- start: Css -->
   <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/bootstrap-responsive.css">
     <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/bootstrap-responsive.min.css">
  <!-- plugins -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/plugins/font-awesome.min.css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/plugins/simple-line-icons.css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/plugins/animate.min.css"/>
  
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/timepicker/css/bootstrap-timepicker.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/timepicker/css/bootstrap-timepicker.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/choosen/chosen.css"/>
    <style type="text/css">
  .form-control {
    display: block;
    width: 100%;
    height: 35px;
  }
    </style>
    
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/plugins/fullcalendar.min.css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/plugins/datepicker.css"/>

  <link rel="stylesheet" href="<?= base_url('asset/datatables/css/dataTables.bootstrap.css') ?>">
  <link href="<?php echo base_url(); ?>asset/css/style.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>asset/css/plugins/select2.css" rel="stylesheet">
  <!-- end: Css -->
  <!-- start: Javascript -->
<script src="<?php echo base_url(); ?>asset/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>asset/css/plugins/select2.full.js"></script>
<script src="<?php echo base_url(); ?>asset/js/jquery.ui.min.js"></script>
<script src="<?php echo base_url(); ?>asset/js/bootstrap.min.js"></script>

<script src="<?= base_url('asset/datatables/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('asset/datatables/js/dataTables.bootstrap.js') ?>"></script>
 <script src="<?= base_url('asset/maskMoney/jquery.maskMoney.min.js') ?>"></script>

<!--<script src="<?php echo base_url(); ?>aasset/js/plugins/bootstrap-timepicker.js"></script>-->
<script src="<?php echo base_url(); ?>asset/js/plugins/bootstrap-datepicker.js"></script>

<link rel="shortcut icon" href="<?php echo base_url(); ?>asset/img/logomi.png">
</head>
<body id="mimin" class="dashboard">
      <!-- start: Header -->
        <nav class="navbar navbar-default header navbar-fixed-top">
          <div class="col-md-12 nav-wrapper">
            <div class="navbar-header" style="width:100%;">
              <div class="opener-left-menu is-open">
                <span class="top"></span>
                <span class="middle"></span>
                <span class="bottom"></span>
              </div>
                <a href="index.html" class="navbar-brand"> 
                 <b>DIGUDANG STORE</b>
                </a>
              <ul class="nav navbar-nav navbar-right user-nav">
                <li class="user-name"><span><?php echo $_SESSION['uname']; ?></span></li>
                  <li class="dropdown avatar-dropdown">
                   <img src="<?php echo base_url(); ?>asset/img/avatar.jpg" class="img-circle avatar" alt="user name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"/>
                   <ul class="dropdown-menu user-dropdown">
                     <li><a href="#"><span class="fa fa-user"></span> My Profile</a></li>
                     <li role="separator" class="divider"></li>
                     <li class="more">
                      <ul>
                        <li><a href="<?= site_url('login/logout')?> "><span class="fa fa-power-off "></span> Logout</a></li>
                      </ul>
                    </li>
                  </ul>
                </li>
             
              </ul>
            </div>
          </div>
        </nav>
      <!-- end: Header -->

      <div class="container-fluid mimin-wrapper">