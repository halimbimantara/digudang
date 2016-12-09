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
                            <div class="col-md-9">
                                <div class="panel box-v4">
                                    <div class="panel-heading bg-white border-none">
                                      <h4><span class="fa fa-cart-arrow-down"></span> Cetak Gaji Pegawai</h4>
                                    </div>
                                    <div class="panel-body padding-0">
       <div class="col-md-9 col-xs-9 col-md-9 padding-0 box-v4-alert">
      <form method="post" action="<?= site_url('laporan/cetakgaji')?>"> 
      <div>
      <div class="col-md-10"> 
      <p>Nama Pegawai</p>
      <select class ="col-md-8" id="nama_pegawai" name="nama_pegawai">
      <?php foreach ($pegawai->result() as $key){?>
        <option value="<?php echo $key->pegawai_id;?>"><?php echo $key->nama_pegawai ?></option>
        <?php }?>
      </select>      
       </div>
       </div>
       <div style="margin-top: 10px" class="col-md-9">
          <p>Mulai Tanggal</p>
          <input class="form-control reset"  type="text" name="tgl_awal" id="tgl_awal">
       </div>

        <div style="margin-top: 10px" class="col-md-9">
          <p>Sampai Tanggal</p>
          <input class="form-control reset"  type="text" name="tgl_akhir" id="tgl_akhir">
       </div>

        <!-- END BUTTON -->
        <div  style="margin-top: 10px" class="col-md-9">
          <button type="submit" class="btn btn-primary">
                  <i class="icons icon-docs"></i> Process</button>
        </div>
       </form>
<div class="panel-body">
        <!-- content -->
     </div>
     </div>
     </div>
     </div>
     </div>



<script>
$(document).ready(function(){
    $("#n_jual").click(function(){
     var nota_jual=$("#nota_j").val();
      // location.reload(); 
          var win = window.open("<?= site_url('Laporan/cetakgaji/')?>"+"/"+nota_jual,'Print',
                                "width=640,height=455");
          win.focus();
          $("#nota_j").val('');
    });
});

/**
 * Cetak Gaji
 */

setTanggal();
function setTanggal(){
  var startDate = new Date('01/01/2016');
  var FromEndDate = new Date();
  var ToEndDate   = new Date();

ToEndDate.setDate(ToEndDate.getDate+365);

      $('#tgl_awal').datepicker({
           format:'dd-mm-yyyy',
           pickTime: false,
           autoclose:true
       }).on("changeDate",function(selected){
          startDate = new Date(selected.date.valueOf());
          startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
          // $('#Pemb_tgl_akhir').datepicker('setStartDate',startDate);
       });


       $('#tgl_akhir').datepicker({
         format:'dd-mm-yyyy',
         weekStart: 1,
         startDate: startDate,
         endDate:ToEndDate,
         autoclose:true
         })
         .on("changeDate",function(selected){
          FromEndDate = new Date(selected.date.valueOf());
          FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));
          $('#tgl_awal').datepicker('setStartDate',FromEndDate);
        });
}
</script>
