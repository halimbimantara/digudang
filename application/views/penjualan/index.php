<style type="text/css">
  .form-group{
      margin-top: 5px;
  }
  .box-v4 .panel-heading {
    padding: 7px;
    margin-bottom: 0px;

}

th{
   background-color:#ff6656 !important;
}
table.dataTable thead > tr > th {
    padding-right: 30px;
    color: white;
}
.bg-yellow {
    background-color:#F49C16 !important;
}
.text-black.h4{
  color: inherit;
}
.text-white > h4{
 color: white; 
}
.box-v4 .panel-body .box-v4-alert {
    width: 100%;
    padding: 3px;
    }
.box-v1 .panel-body {
    padding-top: 0px;
}
.box-v3 {
    padding: 0px;
}
.panel {
    margin-bottom: 6px;
    }
.col-md-4{
      padding-left: 0px;
}
.select2-selection__choice__remove {
  display: none !important;
}

.select2-container--focus .select2-autocomplete .select2-selection__choice {
  display: none;
}


</style>
          <?php 
            foreach ($ongkir as $cost_ongkir) {
              $sc=$cost_ongkir->biaya_sc;
              $dc=$cost_ongkir->biaya_dc;
              $dckm=$cost_ongkir->biaya_dckm;
            }
          ?>

<script>
$.fn.select2.amd.require([
  'select2/selection/multiple',
  'select2/selection/search',
  'select2/dropdown',
  'select2/dropdown/attachBody',
  'select2/dropdown/closeOnSelect',
  'select2/compat/containerCss',
  'select2/utils'
], function (MultipleSelection, Search, Dropdown, AttachBody, CloseOnSelect, ContainerCss, Utils) {
  var SelectionAdapter = Utils.Decorate(
    MultipleSelection,
    Search
  );
  
  var DropdownAdapter = Utils.Decorate(
    Utils.Decorate(
      Dropdown,
      CloseOnSelect
    ),
    AttachBody
  );
  
  $('.inline-search').select2({
    dropdownAdapter: DropdownAdapter,
    selectionAdapter: SelectionAdapter
  });

   $('#id_barangs').focus();
   $('.dropdown-search').select2({
    selectionAdapter: MultipleSelection
  });

   $('#g_id_barangs').focus();
   $('.dropdown-search').select2({
    selectionAdapter: MultipleSelection
  });

  
  $('.autocomplete').select2({
    dropdownAdapter: DropdownAdapter,
    selectionAdapter: Utils.Decorate(SelectionAdapter, ContainerCss),
    containerCssClass: 'select2-autocomplete'
  });



});




          </script>
          <div id="content">
           <div class="col-md-12" style="padding:20px;">
                    <div class="col-md-12 padding-0">
                        <div class="col-md-8 padding-0">
                            <div class="col-md-12">
                                <div class="panel box-v4">
                                    <div class="panel-heading bg-yellow border-none text-white">
                                      <h4><span class="fa fa-cart-plus"></span> Transaksi Penjualan</h4>
                                    </div>
                                     
    <div class="panel-body padding-0">
    <ul id="tabs-demo" class="nav nav-tabs content-header-tab" role="tablist" style="padding-top:10px;">
                      <li role="presentation" class="active">
                      <a href="#tabs-area-demo" id="tabs2" data-toggle="tab">PENJUALAN</a>
                      </li>
                     
                    </ul>

<div class="col-md-12 tab-content">
      <div role="tabpanel" class="tab-pane fade active in" id="tabs-area-demo" aria-labelledby="tabs1">
      <div class="col-md-12 col-xs-12 col-md-12 padding-0 box-v4-alert">
       <form  id="form_transaksi" role="form">
          <div class="col-md-10">
            <div class="form-group">
            <label class="control-label col-md-3">Nama Barang :</label>
            <div class="col-md-8">

        <select class="inline-search reset" onchange="showBarang(this.value)" autocomplete="off" 
        id="id_barangs" name="id_barangs" required="true">
        <option value="">Pilih Barang</option>
        <?php foreach ($produk->result() as $b): ?>
<option value="<?= $b->kode_produk ?>">
 <?= $b->nama_produk ?> 
</option>
        <?php endforeach ?>
        </select>
            </div>
          </div>
          </div>

          <!-- Start div barang -->
          <div id="barang">
           <div class="col-md-10">
            <div class="form-group">
           <label class="control-label col-md-3" 
                for="nama_barang">Harga :</label>
              <div class="col-md-8">
                <input type="text" class="form-control reset" 
                  name="nama_barang" id="nama_barang" 
                  readonly="readonly">
              </div>
          </div>
          </div>

           <div class="col-md-10">
            <div class="form-group">
           <label class="control-label col-md-3" 
                for="nama_barang">Quantity :</label>
              <div class="col-md-5">
                <input type="number" class="form-control reset" 
                  autocomplete="off" onchange="subTotal(this.value)" 
                  onkeyup="subTotal(this.value)" id="qty" min="0"
                  name="qty" placeholder="Isi qty...">
              </div>
          </div>
          </div>
        </div>

        </form>
        <!-- End id barang -->
        <div class="col-md-10">
            <div class="form-group">
           <label class="control-label col-md-3" 
                for="nama_barang">Sub Total :</label>
              <div class="col-md-5">
                <input type="text" class="form-control reset" 
                name="sub_total" id="sub_total" 
                readonly="readonly">
              </div>
              <div class="col-md-1">
             <button type="button" class="btn btn-primary" 
                id="tambah" onclick="addbarang()">
                  <i class="fa fa-cart-plus"></i> Tambah</button>
              </div>
          </div>
          </div>

          <div class="col-md-10">
            <div class="form-group">
           <label class="control-label col-md-3" 
                for="pelanggan">Pelanggan :</label>
              <div class="col-md-5">
                     <select id="id_pelanggan" name="id_pelanggan" class="form-control" required  onchange="showDelivery(this.value)">
                     <option value="">Pilih Pelanggan</option>
                      <?php foreach ($pelanggan->result() as $key): ?>
                        <option  value="<?= $key->id_pelanggan ?>"><?= $key->nama_pelanggan ?></option>
                      <?php endforeach ?>
                      </select>
              </div>
           
          </div>
          </div>

            <div class="col-md-10">
            <div class="form-group">
           <label class="control-label col-md-5" 
                for="nama_barang">Menggunakan Uang Toko ?</label>
              <div class="col-md-1">
                <input class="checkbox" id="Cb_u_toko" type="checkbox">
            </div>
            </div>
          </div>
          <div class="col-md-10">
            <div class="form-group">
           <label class="control-label col-md-3" 
                for="nama_barang">Delivery :</label>
              <div class="col-md-1">
                <input class="checkbox" id="Cb_delivery" type="checkbox">
              </div>
              <div id="petugas_delivery"> 
              <label class="control-label col-md-4" for="nama_barang">Petugas Delivery :</label>
                <div class="col-md-4">
                     <select id="id_petugas" name="id_petugas" class="form-control" required>
                     <option value="">Pilih Petugas</option>
                     <?php foreach ($petugas->result() as $key): ?>
                        <option value="<?= $key->id_petugas ?>"><?= $key->nama_petugas ?></option>
                      <?php endforeach ?>
                      </select>
                    </div>
              </div>
              
          </div>
          </div>
          
        </div>
              </div>
                <!-- END -->
            
<!--/////////////////////// GROSIR //////////////////////////////////////////////////////////////-->
 
  
      </div>
                                    </div>
                                    <!-- END OF  -->
                                </div> 
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="col-md-12 padding-0">
                              <div class="panel box-v1">
                                  
                                  <div class="panel-body">
                                    <div class="col-md-12 padding-0">
                                      <h4>No Nota Terakhir  : <?php echo $notaakhir; ?></h4>
              <div class="col-md-12">
            <div class="form-group">
           <label class="control-label col-md-4" 
                for="nama_barang">Total </label>
              <div class="col-md-8">
               <input type="text" class="form-control input-small" name="total" id="total" placeholder="0"
               readonly="readonly">
              </div>
              <input type="hidden" id="total_temp" value="<?php echo $total_jual;?>">
          </div>
          </div>
           <div class="col-md-12">
            <div class="form-group">
           <label class="control-label col-md-4" 
                for="nama_barang">Bayar </label>
              <div class="col-md-8">
              <input type="text" class="form-control input-small uang" 
                  name="bayar" placeholder="0" autocomplete="off"
                  id="bayar" onkeyup="showKembali(this.value)">
              </div>
          </div>
          </div>
           <div class="col-md-12">
            <div class="form-group">
           <label class="control-label col-md-4" 
                for="nama_barang">Kembali </label>
              <div class="col-md-8">
              <input type="text" class="form-control input-small" 
                name="kembali" id="kembali" placeholder="0"
                readonly="readonly">
              </div>
          </div>
          </div>
                                  </div>
                              </div>
                            </div>

                          <div id="delivery">  
                            <div class="col-md-12 padding-0">
                              <div class="panel box-v1">
                                 <div class="panel-body">
                                    <div class="col-md-12 padding-0">
                                  <h4>Delivery Charge</h4>
                            <div class="col-md-15">
                                <div class="form-group">
                               <label class="control-label col-md-7" for="nama_barang">Service Charge <?php echo $sc?>%</label>
                                  <div class="col-md-5">
                                   <input type="text" class="form-control input-small reset" name="sc" 
                                    placeholder="0" id="sc" 
                                    readonly="readonly"  >
                                    <input type="hidden" id="n_sc" name="n_sc">
                                    <input type="hidden" id="n_dc" name="n_dc">
                                    <input type="hidden" id="dckm" name="dckm">
                                  </div>
                              </div>
                              </div>
                               <div class="col-md-15">
                                <div class="form-group">
                               <label class="control-label col-md-7" for="nama_barang">Delivery Charge</label>
                                  <div class="col-md-5">
                                   <input type="text" class="form-control input-small reset" 
                                    name="dc" id="dc" 
                                    readonly="readonly"  >
                                  </div>
                              </div>
                              </div>

                              <div class="col-md-15">
                               <div class="col-md-3">
                                <input type="text" class="form-control input-small reset" 
                                    name="jarak" id="jarak" placeholder="0">
                               </div>
                                <div class="form-group">
                               
                               <label class="control-label col-md-4" for="nama_barang">KM Jarak x <?php echo $dckm;?></label>
                                  <div class="col-md-5">
                                   <input type="text" class="form-control input-small reset" 
                                    name="dckm" id="dckm" placeholder="0"
                                    readonly="readonly"  >
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
     
<input type="hidden" id="total_hidden" value="<?php echo $total_jual;?>">

<div id="load_row">
  <input type="hidden" id="total_temps" >
</div>

  <div class="panel-body">
        <table id="table_transaksi" class="table table-striped 
            table-bordered">
        <thead>
          <tr>
              <th>No</th>
              <th>Nama Barang</th>
              <th>Harga</th>
              <th>Quantity</th>
              <th>Sub-Total</th>
              <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
      <div class="col-md-offset-8" style="margin-top:20px">
        <button type="button" class="btn btn-primary btn-lg" id="selesai" disabled="disabled" onclick="proses();">
        Selesai <i class="fa fa-angle-double-right"></i></button>
      </div>
                    </div>
                </div>
          </div>
          <!-- end: Content -->
      </div>
<!-- end: Javascript -->

      
<script>
//stok_item stok tersedia
// $(function () {
//    $( "#qty" ).change(function() {
//       var max = parseInt($(this).attr('max'));
//       var min = parseInt($(this).attr('min'));
//       if ($(this).val() > max)
//       {
//           $(this).val(max);
//       }
//       else if ($(this).val() <= min)
//       {
//           $(this).val(min);
//       }       
//     }); 
// });
//menampilkan barang apabila barang sudah dipilih
  function proseas(){
    var total  =$("#total").val().replace(".", "");
    if(total == '' ){
       alert("BERHASIL"+total);
    }else{
      alert("gagal"+total);
    }
  }
  function proses(){
      $('#selesai').attr("disabled","disabled");
      var total       =$("#total").val().replace(".", "");
      var id_petugas  =$("#id_petugas").val();
      var id_pelanggan=$("#id_pelanggan").val();
      var bayar       =$("#bayar").val();
      var kembali     =$("#kembali").val();
      
      var SC   =$("#sc").val();
      var DC   =$("#dc").val();
      var KM   =$("#jarak").val();
      var DCKM =$("#dckm").val();
      var delivery=document.getElementById("Cb_delivery").checked;
      var ut="";
      var u_toko=document.getElementById("Cb_u_toko").checked;

      $("#load_row").load("<?= base_url('index.php/penjualan/reloadTable') ?>");
      var temps =$('#total_temps').val();
      if(u_toko== true){
        ut=1;
      }else{
        ut=0;
      }


      if(delivery == true && total !== 0 &&  temps !== 0 ){
          // without delivery pelanggan baru
          if(id_pelanggan == 0 && id_pelanggan !== '' && id_petugas !== '' && total !== '0'){
           //new pelanggan
              $.post("<?= site_url('penjualan/insertPenjualan')?>", //Required URL of the page on server
            { // Data Sending With Request To Server
                id_pelanggan:id_pelanggan,
                id_petugas:id_petugas,
                bayar:bayar,
                kembali:kembali,
                sc:SC,
                dc:DC,
                km:0,
                dckm:0,
                ut:ut
            },
        function(response,status){ // Required Callback Function
         
          var nota_pnj="";
          var nota_ln ="";
          var message ="\n\n Nota Lain:";
          //PJ1600001
          nota_pnj = response.substring(0, 9);
          nota_ln  = response.substring(9, 18);
          
          console.log("slug"+response);

          if (nota_ln == '') {
          alert("*----Transaksi Berhasil----*\n\n Nota Jual : "+nota_pnj+" \n\n  \n\nStatus : " + status);
          location.reload(); 
          var win = window.open("<?= site_url('Penjualan/cetak/')?>"+"/"+nota_pnj,'Print',
                                "width=640,height=455");
          win.focus();

          }else{
          alert("*----Transaksi Berhasil----*\n\n Nota Jual : "+nota_pnj+" \n\n Nota Lain :"+nota_ln+"\n\nStatus : " + status);
          
          location.reload(); 
        window.open("<?= site_url('Penjualan/cetak/')?>"+"/"+nota_pnj,'Print',
                                "width=640,height=455");
          win.focus();

        window.open("<?= site_url('pembelian/cetakPembelianLain')?>"+"/"+nota_ln,'Print',
                                "width=640,height=455");
            }
            
            });

          }else if(id_pelanggan !== '' && id_petugas !== '' && total !== '0'){//with delivery
            // alert("kirim detail");
                $.post("<?= site_url('penjualan/insertPenjualan')?>", //Required URL of the page on server
            { // Data Sending With Request To Server
                id_pelanggan:id_pelanggan,
                id_petugas:id_petugas,
                bayar:bayar,
                kembali:kembali,
                sc:SC,
                dc:DC,
                km:KM,
                dckm:DCKM,
                ut:ut
            },
            function(response,status){ // Required Callback Function
          
          var nota_pnj="";
          var nota_ln ="";
          //PJ1600001
          nota_pnj = response.substring(0, 9);
          nota_ln  = response.substring(9, 18);
          
          console.log("slug"+response);

          if (nota_ln == '') {
          alert("*----Transaksi Berhasil----*\n\n Nota Jual : "+nota_pnj+" \n\n  \n\nStatus : " + status);
          location.reload(); 
          var win = window.open("<?= site_url('Penjualan/cetak/')?>"+"/"+nota_pnj,'Print',
                                "width=640,height=455");
          win.focus();
          }else{
          alert("*----Transaksi Berhasil----*\n\n Nota Jual : "+nota_pnj+" \n\n Nota Lain :"+nota_ln+"\n\nStatus : " + status);
          
          location.reload(); 
           window.open("<?= site_url('Penjualan/cetak/')?>"+"/"+nota_pnj,'Print Penjualan',
                                "width=640,height=455");
          // win.focus();

           window.open("<?= site_url('pembelian/cetakPembelianLain')?>"+"/"+nota_ln,'Print Lain',
                                "width=640,height=455");
         }
                
            });
          }else{
             alert("Mohon Isi Data Dengan Lengkap");
          }
      }else if(total !== 0 || total !== ' ' || total > 0){
            console.log("TES"+total);
          $.post("<?= site_url('penjualan/insertPenjualan')?>", //Required URL of the page on server
            { // Data Sending With Request To Server
                id_pelanggan:id_pelanggan,
                id_petugas:0,
                bayar:bayar,
                kembali:kembali,
                sc:0,
                dc:0,
                km:0,
                dckm:0,
                ut:ut
            },
            function(response,status){ 
          var nota_pnj="";
          var nota_ln ="";
          //PJ1600001
          nota_pnj = response.substring(0, 9);
          nota_ln  = response.substring(9, 18);
          
          console.log("slug"+response);

          if (nota_ln == '') {
          alert("*----Transaksi Berhasil----*\n\n Nota Jual : "+nota_pnj+" \n\n  \n\nStatus : " + status);
          location.reload(); 
          var win = window.open("<?= site_url('Penjualan/cetak/')?>"+"/"+nota_pnj,'Print',
                                "width=640,height=455");
          win.focus();
          }else{
          alert("*----Transaksi Berhasil----*\n\n Nota Jual : "+nota_pnj+" \n\n Nota Lain :"+nota_ln+"\n\nStatus : " + status);
          
          location.reload(); 
           window.open("<?= site_url('Penjualan/cetak/')?>"+"/"+nota_pnj,'Print Penjualan',
                                "width=640,height=455");
          // win.focus();

           window.open("<?= site_url('pembelian/cetakPembelianLain')?>"+"/"+nota_ln,'Print Lain',
                                "width=640,height=455");
          // lain.focus();


          }


            });
        }else{
          console.log(total);
          alert("Anda Belum Mengisi Data");
        }
      


    }

//menyembunyikan delivery
$("#delivery").hide();
$("#petugas_delivery").hide();
$("#Cb_delivery").change(function() {
var cekpelanggan=$('#id_pelanggan').val();
   if(this.checked) {
        if(cekpelanggan !== '')
        {
              if(cekpelanggan == '1' ){ 
                  $("#delivery").show();
                  $("#petugas_delivery").show();
                showServiceChargeNew();   
              }else{
                $("#delivery").show();
                $("#petugas_delivery").show();
                  resDC();
              }
        }else{
            alert('ID pelanggan tidak boleh Kosong');
            document.getElementById("Cb_delivery").checked = false;
        }
    }else{
      //kembalikan ke total awal
      var total_hid=$('#total_hidden').val();
      $('#total').val(total_hid);
      console.log(sub_total);
      $("#delivery").hide();
      $("#petugas_delivery").hide();
      
    }

});

function showBarang(str) 
  {

      if (str == "") {
          $('#nama_barang').val('');
          $('#harga_barang').val('');
          $('#qty').val('');
          $('#sub_total').val('');
          $('#reset').hide();
          return;
      } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
             xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
             if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("barang").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "<?= base_url('index.php/penjualan/getProdukNew') ?>/"+str,true);
        xmlhttp.send();
      }
  }

  function showBarangGrosir(str) 
  {

      if (str == "") {
          $('#g_nama_barang').val('');
          $('#g_harga_barang').val('');
          $('#g_qty').val('');
          $('#g_sub_total').val('');
          $('#reset').hide();
          return;
      } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
             xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
             if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("barang_grosir").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "<?= base_url('index.php/penjualan/getProdukGrosir') ?>/"+str,true);
        xmlhttp.send();
      }
  }
 
  function showDelivery(str) 
  {
      if (str == "") {
          $('#sc').val('');
          $('#dc').val('');
          $('#dckm').val('');
          $('#reset').hide();
          return;
      } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
             xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
             if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("delivery").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "<?= base_url('index.php/penjualan/getDeliveryCharge') ?>/"+str,true);
        xmlhttp.send();
       
      }
  }

  function showServiceChargeNew(){

     var total = $('#total_temp').val().replace(".", "").replace(".","");
     var sc = $('#sc').val();
     var dc = $('#dc').val();
      var jumlah     =parseInt(total)+parseInt(dc)+parseInt(sc); 
      console.log(total);
      console.log("Jumlah"+jumlah);
      console.log("DC"+jumlah);
      $('#total').val(convertToRupiah(jumlah));

  }

  function showServiceChargePbaru(){
    var total  = $('#total_temp').val().replace(".", "").replace(".","");
     var sc = $('#sc').val();
     var dc = $('#dc').val();
     var jumlah     =parseInt(sc)+parseInt(dc)+parseInt(total);
      console.log("DC"+dc);
      $('#total').val(convertToRupiah(jumlah));

  }
//ganti
  function resDC(){
     var total = $('#total_temp').val().replace(".", "").replace(".","");
     var sc = $('#sc').val();
     var dc = $('#dc').val();
     var dckm = $('#dckm').val();
     var jumlah=parseInt(sc)+parseInt(dc)+parseInt(dckm)+parseInt(total);
      $('#total').val(convertToRupiah(jumlah));
       $('#total').val(convertToRupiah(jumlah));

  }


  //harga * jumlah
  function subTotal(qty)
  {

    var _qty=parseInt(qty);
    var h_grosir=$('#jual_grosir').val();
    var gr_qty  =parseInt($('#qty_grosir').val());
    var harga = $('#harga_barang').val().replace(".", "").replace(".", "");
    var harga_ori=$('#harga_ori').val();
    var max=parseInt($('#stok_item').val());//stok tersediaS
    if(_qty <= max){
        $('#sub_total').val(convertToRupiah(harga*_qty));
    }else if(_qty > max){
        if(_qty >= gr_qty ){
          $('#qty').val(max);
          $('#sub_total').val(convertToRupiah(h_grosir*max));
          $('#harga_barang').val(convertToRupiah(h_grosir));
            console.log("Grosir Max");
         }else if(gr_qty > _qty){
          $('#qty').val(max);
          $('#sub_total').val(convertToRupiah(harga*max));
            console.log("Harga Normal max");
         }
    }

    if(_qty <= max &&  _qty >= gr_qty){
      $('#harga_barang').val(convertToRupiah(h_grosir));
      $('#sub_total').val(convertToRupiah(h_grosir*_qty));
      console.log("Grosir");
    }else if(gr_qty > _qty){
      $('#harga_barang').val(convertToRupiah(harga_ori));
      $('#sub_total').val(convertToRupiah(harga*_qty));
      console.log("Normal");
    }
}
    
  

  function GrosirSubtotal(qgrosir)
  {
    var harga_g = $('#g_harga_barang').val().replace(".", "").replace(".", "");
                  $('#g_sub_total').val(convertToRupiah(harga_g*qgrosir));
  }

function convertToRupiah(angka)
  {
      var rupiah = '';    
      var angkarev = angka.toString().split('').reverse().join('');
      
      for(var i = 0; i < angkarev.length; i++) 
        if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
      
      return rupiah.split('',rupiah.length-1).reverse().join('');
  
  }

  var table;
    $(document).ready(function() {
      showKembali($('#bayar').val());
      table = $('#table_transaksi').DataTable({ 
        paging: false,
        "info": false,
        "searching": false,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' 
        // server-side processing mode.
        
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?= site_url('penjualan/ajax_list_transaksi_db')?>",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
          "targets": [ 0,1,2,3,4,5 ], //last column
          "orderable": false, //set not orderable
        },
        ],

      });
    });

    function reload_table()
    {

      table.ajax.reload(null,false); //reload datatable ajax 
    
    }

    function addbarang()
    {
        var stok_item=$("#stok_item").val();
        var id_barang = $('#id_barangs').val();
        var qty = $('#qty').val();
        if (id_barang == '') {
          $('#id_barang').focus();
        }else if(qty == '' || qty == 0){
          $('#qty').focus();
        }else{

       // ajax adding data to database
          $.ajax({
            url : "<?= site_url('penjualan/addbarang')?>",
            type: "POST",
            data: $('#form_transaksi').serialize(),
            dataType: "JSON",
            success: function(response,data)
            {
              if(response == '1'){
                alert("Stok Habis");
              }else{
                //reload ajax table
                reload_table();  
              }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding data'+textStatus+jqXHR);
            }
        });
            showTotal();
            showKembali($('#bayar').val());
            //mereset semua value setelah btn tambah ditekan
            $('.reset').val('');
            $("#load_row").load("<?= base_url('index.php/penjualan/reloadTable') ?>");

        };
    }

    // Grosir
    function addbarangGrosir()
    {
        var stok_item = $("#g_stok_item").val();
        var id_barang = $('#g_id_barangs').val();
        var qty       = $('#g_qty').val();

        if (id_barang == '') {
          $('#g_id_barangs').focus();
        }else if(qty == '' || qty == 0){
          $('#g_qty').focus();
        }else{

       // ajax adding data to database
          $.ajax({
            url : "<?= site_url('penjualan/addbarangGrosir')?>",
            type: "POST",
            data: $('#form_transaksi_grosir').serialize(),
            dataType: "JSON",
            success: function(response,data)
            {
              if(response == '1'){
                alert("Stok Habis");
              }else{
                //reload ajax table
                reload_table();  
              }
              // alert(response,data);
              // console.log(response);
              
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding data'+textStatus+jqXHR);
            }
        });
            showTotalGrosir();
            showKembali($('#bayar').val());
            //mereset semua value setelah btn tambah ditekan
            $('.reset').val('');
             $("#load_row").load("<?= base_url('index.php/penjualan/reloadTable') ?>");
        };
    }

    function deletebarang(id,sub_total)
    {
        // ajax delete data to database
          $.ajax({
            url : "<?= site_url('penjualan/deletebarang')?>"+"/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
               reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });
          $("#load_row").load("<?= base_url('index.php/penjualan/reloadTable') ?>");

          var ttl_temp = $('#total_temp').val().replace(".", "").replace(".","");
          var ttl = $('#total').val().replace(".", "").replace(".","");
          console.log("Rupiah"+sub_total);

          if(ttl_temp == 0 || ttl == 0 ){
            $('#total_temp').val(0);
            $('#total').val(0);
          }else{
            var hasilTe=parseInt(ttl_temp)-parseInt(sub_total);
            var hasilTot=parseInt(ttl)-parseInt(sub_total);

            $('#total_temp').val(convertToRupiah(hasilTe));
            $('#total').val(convertToRupiah(hasilTot));
          }
          
          var skby=$('#bayar').val();
          showKembali(skby);
    }

     function showTotal()
    {
      var total = $('#total').val().replace(".", "").replace(".", "");
      
      var total_temp = $('#total_temp').val().replace(".", "").replace(".", "");

      var sub_total = $('#sub_total').val().replace(".", "").replace(".", "");

      $('#total').val(convertToRupiah((Number(total)+Number(sub_total))));
      $('#total_hidden').val(convertToRupiah((Number(total)+Number(sub_total))));
      $('#total_temp').val(convertToRupiah((Number(total_temp)+Number(sub_total))));
      
      console.log("Total Ori"+$('#total').val());
      console.log("Total temp Ori"+$('#total_temp').val());
    }

     function showTotalGrosir()
    {
      var total = $('#total').val().replace(".", "").replace(".", "");
      
      var total_temp = $('#total_temp').val().replace(".", "").replace(".", "");

      var sub_total = $('#g_sub_total').val().replace(".", "").replace(".", "");

      $('#total').val(convertToRupiah((Number(total)+Number(sub_total))));
      $('#total_hidden').val(convertToRupiah((Number(total)+Number(sub_total))));
      $('#total_temp').val(convertToRupiah((Number(total_temp)+Number(sub_total))));
      console.log("Total Gr"+$('#total').val());
      console.log("Total temp GR"+$('#total_temp').val());
    }


    //maskMoney
  $('.uang').maskMoney({
    thousands:'.', 
    decimal:',', 
    precision:0
  });

     function showKembali(str)
    {
      var total = $('#total').val().replace(".", "").replace(".", "");
      var temps =$('#total_temps').val();
      var bayar = str.replace(".", "").replace(".", "");
      var kembali = bayar-total;

      $('#kembali').val(convertToRupiah(kembali));
      if(temps == '') {
          $('#selesai').attr("disabled","disabled");
      }else{
          $('#selesai').removeAttr("disabled");
          if (kembali >= 0) {
            $('#selesai').removeAttr("disabled");
          }else{
            $('#selesai').attr("disabled","disabled");
          }
      }
}


</script>
