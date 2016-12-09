 <style>
  .modal-header, h4-x, .close {
      background-color: #5cb85c;
      color:white !important;
      text-align: center;
      font-size: 30px;
  }
  .modal-footer {
      background-color: #f9f9f9;
  }
  .btn.btn-circle.btn-mn {
    width: 20px;
    height: 20px;
    padding: 0px;
    font-size: 1em;
}
  </style>
<div id="content">
           <div class="col-md-12" style="padding:20px;">
                    <div class="col-md-12 padding-0">
                            <div class="col-md-6">
                                <div class="panel box-v4">
                                    <div class="panel-heading bg-white border-none">
                                      <h4><span class="fa fa-cart-arrow-down"></span> Cetak Laporan Laba rugi</h4>
                                    </div>
                                    <div class="panel-body padding-0">
       <div class="col-md-9 col-xs-9 col-md-9 padding-0 box-v4-alert">
      <form method="post" action="<?= site_url('laporan/labaRugi')?>"> 
       <div>
         <div class="col-md-5"> 
      <p>Mulai Tanggal</p>
       <input type="text" class="form-control reset" 
                  name="lain_tglmulai" id="lain_tglmulai" required>
       </div>
     -
      <div class="col-md-5"> 
     <p>Sampai Tanggal</p>
       <input type="text" class="form-control reset" 
                  name="lain_tglakhir" id="lain_tglakhir" required>
       </div> <div class="col-md-6">
          <button type="submit" class="btn btn-primary"  >
                  <i class="icons icon-docs"></i> Process</button>
       
       </div>
       </div>
       </form>
<div class="panel-body">
        <!-- content -->
     </div>
     </div>
     </div>
     </div>
     </div>

  <div class="col-md-6">
                                <div class="panel box-v4">
                                    <div class="panel-heading bg-white border-none">
                                      <h4><span class="fa fa-cart-arrow-down"></span> Cetak Neraca Saldo</h4>
                                    </div>
                                    <div class="panel-body padding-0">
       <div class="col-md-9 col-xs-9 col-md-9 padding-0 box-v4-alert">
      <form method="post" action="<?= site_url('laporan/neracaSaldo')?>"> 
       <div>
         <div class="col-md-5"> 
      <p>Mulai Tanggal</p>
       <input type="text" class="form-control reset" 
                  name="Pemb_tglmulai" id="Pemb_tglmulai" required>
       </div>
     -
      <div class="col-md-5"> 
     <p>Sampai Tanggal</p>
       <input type="text" class="form-control reset" 
                  name="Pemb_tgl_akhir" id="Pemb_tgl_akhir" required>
       </div> <div class="col-md-6">
          <button type="submit" class="btn btn-primary"  id="proses_pemb">
                  <i class="icons icon-docs"></i> Process</button>
       
       </div>
       </div>
       </form>
<div class="panel-body">
        <!-- content -->
     </div>
     </div>
     </div>
     </div>
     </div>
     </div>


      <div class="col-md-12 padding-0">
              <div class="col-md-12">
                             <div class="col-md-6">
                                <div class="panel box-v4">
                                    <div class="panel-heading bg-white border-none">
                                      <h4><span class="fa fa-cart-arrow-down"></span> Cetak Nota Keperluan Toko</h4>
                                    </div>
                                    <div class="panel-body padding-0">
       <div class="col-md-12 col-xs-12 col-md-12 padding-0 box-v4-alert">
        <form> 
       <div>
         <div class="col-md-5"> 
      <p>No Nota Contoh : L1600001</p>
       <input type="text" class="form-control reset" 
                  name="nota_ll" id="nota_ll" >
                  <button type="submit" class="btn btn-primary" id="proses_ll"> 
                  <i class="icons icon-docs"></i> Process</button>
       </div>
     
       <div class= "col-md-6">
            <p> </p>
          
       </div>
       </div>
       </form>

<div class="panel-body">
      
     </div>
     </div>
     </div>
     </div>


    
     </div>
     
 <div class="col-md-12 padding-0">



     
     </div>

     </div>

     </div>

     </div>

     
    </div>
  </div>
     </div>


<script>
 var startDate = new Date('01/01/2016');
  var FromEndDate = new Date();
  var ToEndDate   = new Date();

ToEndDate.setDate(ToEndDate.getDate+365);

      $('#Pemb_tglmulai').datepicker({
           format:'dd-mm-yyyy',
           pickTime: false,
           autoclose:true
       }).on("changeDate",function(selected){
          startDate = new Date(selected.date.valueOf());
          startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
          // $('#Pemb_tgl_akhir').datepicker('setStartDate',startDate);
       });


       $('#Pemb_tgl_akhir').datepicker({
         format:'dd-mm-yyyy',
         weekStart: 1,
         startDate: startDate,
         endDate:ToEndDate,
         autoclose:true
         })
         .on("changeDate",function(selected){
          FromEndDate = new Date(selected.date.valueOf());
          FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));
          $('#Pemb_tglmulai').datepicker('setStartDate',FromEndDate);


        });
         //lain
          $('#lain_tglmulai').datepicker({
           format:'dd-mm-yyyy',
           pickTime: false,
           autoclose:true
       }).on("changeDate",function(selected){
          startDate = new Date(selected.date.valueOf());
          startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
          $('#lain_tglakhir').datepicker('setStartDate',startDate);
       });


       $('#lain_tglakhir').datepicker({
         format:'dd-mm-yyyy',
         weekStart: 1,
         startDate: startDate,
         endDate:ToEndDate,
         autoclose:true
         })
         .on("changeDate",function(selected){
          FromEndDate = new Date(selected.date.valueOf());
          FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));
          $('#lain_tglmulai').datepicker('setStartDate',FromEndDate);
        });
         //end

$(document).ready(function(){
    $("#n_jual").click(function(){
     var nota_jual=$("#nota_j").val();

      // location.reload(); 
          var win = window.open("<?= site_url('Penjualan/cetak/')?>"+"/"+nota_jual,'Print',
                                "width=640,height=455");
          win.focus();
          $("#nota_j").val('');
    });
});

$(document).ready(function(){
    $("#proses_pk").click(function(){
     var nota_pk=$("#nota_pk").val();

    
  var win = window.open("<?= site_url('pembelian/cetakPembelian/')?>"+"/"+nota_pk,'Print',"width=640,height=455");
          win.focus();
          $("#nota_pk").val('');
    });
});

$(document).ready(function(){
    $("#proses_ll").click(function(){
     var nota_ll=$("#nota_ll").val();

      // location.reload(); 
  var win = window.open("<?= site_url('pembelian/cetakPembelianLain/')?>"+"/"+nota_ll,'Print',"width=640,height=455");
          win.focus();
          $("#nota_ll").val('');
    });
});



</script>
