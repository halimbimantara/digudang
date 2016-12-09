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
                                      <h4><span class="fa fa-cart-arrow-down"></span> Cetak Nota Penjualan</h4>
                                    </div>
                                    <div class="panel-body padding-0">
       <div class="col-md-9 col-xs-9 col-md-9 padding-0 box-v4-alert">
      <form> 
       <div>
         <div class="col-md-5"> 
      <p>No Nota Contoh :PJ1600001</p>
       <input type="text" class="form-control reset" 
                  name="nota_j" id="nota_j" required>
                  <button type="submit" class="btn btn-primary"  id="n_jual">
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
                                      <h4><span class="fa fa-cart-arrow-down"></span> Cetak Nota Pembelian Komoditi</h4>
                                    </div>
                                    <div class="panel-body padding-0">
       <div class="col-md-9 col-xs-9 col-md-9 padding-0 box-v4-alert">
      <form> 
       <div>
         <div class="col-md-5"> 
      <p>No Nota Contoh :PB1600001</p>
       <input type="text" class="form-control reset" 
                  name="nota_pk" id="nota_pk" required><button type="submit" class="btn btn-primary" id="proses_pk" >
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
