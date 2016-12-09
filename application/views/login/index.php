<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="utf-8">
<meta name="description" content="Miminium Admin Template v.1">
<meta name="author" content="Mohamad Halim Bimantara">
<meta name="keyword" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login</title>

<!-- start: Css -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/bootstrap.min.css">

<!-- plugins -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/plugins/font-awesome.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/plugins/animate.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/plugins/icheck/skins/flat/aero.css"/>
<link href="<?php echo base_url(); ?>asset/css/style.css" rel="stylesheet">
<!-- end: Css -->
<link rel="shortcut icon" href="asset/img/logo.png">
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body id="mimin" class="dashboard form-signin-wrapper">

<div class="container">

<div class="form-signin" >
<div class="panel periodic-login">
  <!-- <span class="atomic-number">datetime</span> -->
<center><p>Selamat Datang Di GUDANG STORE</p></center>
<div class="panel-body text-center">
<img src="<?php echo base_url(); ?>asset/img/cleo.jpg">

<i class="icons icon-arrow-down"></i>
<div class="form-group form-animate-text" style="margin-top:40px !important;">
<input type="text" class="form-text" name="username" id="username" required>
<span class="bar"></span>
<label>Username</label>
<!-- <input type="text" class="form-text" name="username" id="username" required> -->
</div>

<div class="form-group form-animate-text" style="margin-top:40px !important;">
<input type="password" class="form-text" name="password" id="password" required>
<span class="bar"></span>
<label>Password</label>
</div>

<button type="submit" class="btn ripple btn-3d btn-danger" onclick="prosesLogin()" id="BtnLogin">
                                      <div>
                                        <span>MASUK</span>
                                      <span class="ink animate" style="height: 72px; width: 52px; top: -24px; left: 12px;"></span></div>
                                    </button>
<!-- <input type="submit" class="btn btn-gradient btn-danger" value="SignIn"/> -->
</div>

</div>
</div>

</div>

<!-- end: Content -->
<!-- start: Javascript -->
<script src="<?php echo base_url(); ?>asset/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>asset/js/jquery.ui.min.js"></script>
<script src="<?php echo base_url(); ?>asset/js/bootstrap.min.js"></script>

<script src="<?php echo base_url(); ?>asset/js/plugins/moment.min.js"></script>
<script src="<?php echo base_url(); ?>asset/js/plugins/icheck.min.js"></script>

<!-- custom -->
<script src="<?php echo base_url(); ?>asset/js/main.js"></script>
<script type="text/javascript">

function prosesLogin(){

      var uname= $("#username").val();
      var pwd  = $("#password").val();

      if(uname == '' || pwd ==''){
        alert("Isi data anda dengan benar");
      }else{
        $.post("<?= site_url('login/cekLogin')?>", //Required URL of the page on server
            { // Data Sending With Request To Server
                unames:uname,
                passwd:pwd
            },
        function(response,status){ // Required Callback Function
                // alert("*----Received Data----*\n\nResponse : " + response+"\n\nStatus : " + status);
              //"response" receives - whatever written in echo of above PHP script.
              if(response == 0){
                  alert("Cek Username dan Password");
              }else if(response == 1){
                window.location="<?= site_url('penjualan')?>";
                // alert("ADA");
              }else{
                alert("Ada Kesalahan Hubungi Pengembang");
              }

            });
	     }
 }


</script>
<!-- end: Javascript -->
</body>
</html>
