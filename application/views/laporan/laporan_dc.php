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
                                      <h4><span class="fa fa-cart-arrow-down"></span> Generate Laporan Cost Delivery</h4>
                                    </div>
                                    <div class="panel-body padding-0">
       <div class="col-md-9 col-xs-9 col-md-9 padding-0 box-v4-alert">
      <form method="post" action="<?= site_url('laporan/SaveToPdfCD')?>"> 
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
  <div class="col-md-6">
                                <div class="panel box-v4">
                                    <div class="panel-heading bg-white border-none">
                                      <h4><span class="fa fa-cart-arrow-down"></span> Generate Laporan Service Charge</h4>
                                    </div>
                                    <div class="panel-body padding-0">
       <div class="col-md-9 col-xs-9 col-md-9 padding-0 box-v4-alert">
      <form method="post" action="<?= site_url('laporan/SaveToPdfCD')?>"> 
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
     </div>


      <div class="col-md-12 padding-0">

                            <div class="col-md-6">
                                <div class="panel box-v4">
                                    <div class="panel-heading bg-white border-none">
                                      <h4><span class="fa fa-cart-arrow-down"></span> Generate Laporan Delivery Charge KM</h4>
                                    </div>
                                    <div class="panel-body padding-0">
       <div class="col-md-9 col-xs-9 col-md-9 padding-0 box-v4-alert">
      <form method="post" action="<?= site_url('laporan/SaveToExcelPembelian')?>"> 
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
  <div class="col-md-6">
                                <div class="panel box-v4">
                                    <div class="panel-heading bg-white border-none">
                                      <h4><span class="fa fa-cart-arrow-down"></span> Generate Laporan Service Charge</h4>
                                    </div>
                                    <div class="panel-body padding-0">
       <div class="col-md-9 col-xs-9 col-md-9 padding-0 box-v4-alert">
      <form method="post" action="<?= site_url('laporan/SaveToExcelPembelian')?>"> 
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
     </div>
     </div>

     
    </div>
  </div>
     </div>
<script>

setTanggal();
function setTanggal(){
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


         $('#lain_tglmulai').datepicker({
           format:'yyyy-mm-dd',
           pickTime: false,
           autoclose:true
       }).on("changeDate",function(selected){
          startDate = new Date(selected.date.valueOf());
          startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
          $('#lain_tglakhir').datepicker('setStartDate',startDate);
       });


       $('#lain_tglakhir').datepicker({
         format:'yyyy-mm-dd',
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



         $('#penj_tglmulai').datepicker({
           format:'yyyy-mm-dd',
           pickTime: false,
           autoclose:true
       }).on("changeDate",function(selected){
          startDate = new Date(selected.date.valueOf());
          startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
          // $('#lain_tglakhir').datepicker('setStartDate',startDate);
       });


       $('#penj_tglakhir').datepicker({
         format:'yyyy-mm-dd',
         weekStart: 1,
         startDate: startDate,
         endDate:ToEndDate,
         autoclose:true
         })
         .on("changeDate",function(selected){
          FromEndDate = new Date(selected.date.valueOf());
          FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));
          $('#penj_tglmulai').datepicker('setStartDate',FromEndDate);
        });

}
</script>


<script>
$(document).ready(function(){
    $("#prosesPembelian").click(function(){
      var tgl_mulai=$("#Pemb_tglmulai").val();
      var tgl_akhir=$("#Pemb_tgl_akhir").val();
     
  $.post("<?= site_url('laporan/SaveToExcel')?>", //Required URL of the page on server
            { // Data Sending With Request To Server
                tgl_mulai:tgl_mulai,
                tgl_akhir:tgl_akhir
            },
            function(rstatus){ // Required Callback Function
                alert("*----Received Data----*\n\nResponse : " + response+"\n\nStatus : " + status);//"response" receives - whatever written in echo of above PHP script.
                $("#myModal").modal('hide');
                // reload_table(); 
                location.reload(); 
             
            });
    });
});

var table;
function reload_table()
    {

      table.ajax.reload(null,false); //reload datatable ajax 
    
    }
function deleteDelivery(id){
  alert(id);
}
</script>
