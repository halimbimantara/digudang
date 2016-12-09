 <style type="text/css">
.form-group{
      margin-top: 5px;
}
.box-v4 .panel-heading {
    padding: 7px;
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

 .box-v4 .panel-body .box-v4-alert{
    width: 100%;
    padding: 0px;
  }
  .table.table-bordered thead th, table.table-bordered thead td {
    border-left-width: 0;
    border-top-width: 0;
    background-color: #ff001b;
    color: #fff;
}

  .col-md-2-v1{
    position: relative;
    min-height: 1px;
    padding-right: 10px;
    padding-left: 10px;
    width: 17%;
    float: left;
  }
   .col-md-2-v2{
    position: relative;
    min-height: 1px;
    padding-right: 10px;
    padding-left: 10px;
    width: 11%;
    float: left;
  }

  .col-md-2-diskon {
    position: relative;
    min-height: 1px;
    padding-right: 10px;
    padding-left: 10px;
    width: 10%;
    float: left;
}
</style>
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
        <div class="col-md-9 padding-0">
                            <div class="col-md-12">
                                <div class="panel box-v4">
                                    <div class="panel-heading bg-white border-none">
                                      <h4><span class="fa fa-cart-arrow-down"></span> Pembelian Barang</h4>
                                    </div>
                                    <div class="panel-body padding-0">
       <div class="col-md-12 col-xs-12 col-md-12 padding-0 box-v4-alert">

        <div class="col-md-12">
            <div class="form-group">
            <label class="control-label col-md-2" 
              for="id_barang">Nama Barang :</label>
            <div class="col-md-3">
        <select class="inline-search reset" onchange="showBarang(this.value)" autocomplete="off" id="id_barang" name="id_barang" required="true">
        <option value="">Pilih Barang</option>
        <?php foreach ($produk->result() as $b): ?>
        <option value="<?= $b->kode_produk ?>"><?= $b->nama_produk ?></option>
        <?php endforeach ?>
        </select>
            </div>
           
           
          </div>
          </div>

           <div id="update_barang"></div>
       </div>
      
       </div>
       </div>
       <!--  -->
        <div class="col-md-5">
                            <div class="col-md-12 padding-0">
                              <div class="panel box-v4">
                                  <div class="panel-body">
                                    <div class="col-md-12 padding-0">
              <div class="col-md-12">
            <div class="form-group">
           <label class="control-label col-md-4" 
                for="nama_barang">Total </label>
              <div class="col-md-8">
              <div id="load_row">
<input type="text" class="form-control input-small" name="total" id="total" readonly="readonly">
              </div>

              </div>
              
              <input type="hidden" id="total_temp" value="">
          </div>
           <div class="form-group">
           <label class="control-label col-md-4" 
                for="nama_barang">Balance</label>
              <div class="col-md-8">

              <div id="load_row">
<input type="text" class="form-control input-small" name="balance" id="balance">
              </div>

              </div>
              
              <input type="hidden" id="total_temp" value="">
          </div>
          </div>
          </div>
          </div>
          </div>
          </div>
          </div>
       <!--  -->
       </div>

       </div>
       <!--  -->
                </div>

      <div class="panel-body">
        <table id="table_transaksi" class="table table-striped table-bordered">
        <thead>
          <tr>
              <th>No</th>
              <th>Nama Barang</th>
              <th>Harga Beli</th>
              <th>Quantity</th>
              <th>Sub-Total</th>
              <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
      <div class="col-md-offset-8" style="margin-top:20px">
        <button type="button" class="btn btn-primary btn-lg" id="selesai" disabled="disabled" onclick="selesai();">
        Selesai <i class="fa fa-angle-double-right"></i></button>
      </div>
    
       </div>
       </div>
       </div>
       </div>

<script type="text/javascript">
//mengeksekusi semua data cart ke table database
function selesai()
{  
  var ut="";
      var u_toko=document.getElementById("Cb_u_toko").checked;
      var balance=$("#balance").val();
      if(u_toko== true){
        ut=1;
      }else{
        ut=0;
      }

    var r = confirm("Apakah Yakin Data Yang Akan Anda Proses Sudah Benar ?");
    if (r == true) {
    $.post("<?= site_url('pembelian/updatebarang')?>", //Required URL of the page on server
            { // Data Sending With Request To Server
              id:2,
              ut:ut,
              balance:balance
            },
    function(response,status){ // Required Callback Function
          var nota_beli="";
          var nota_ln ="";
          //PJ1600001
          nota_beli= response.substring(0,9);
          nota_ln  = response.substring(9,18);
          
          console.log("slug"+response);
          if (nota_ln == '') {
            alert("*----Received Data----*\n\nResponse : " + response+"\n\nStatus : " + status);
            $('#selesai').attr("disabled","disabled");
            location.reload();
            var win = window.open("<?= site_url('pembelian/cetakPembelian/')?>"+"/"+nota_beli,'Print',"width=640,height=455");
            win.focus(); 
            }else{
      alert("*----Transaksi Berhasil----*\n\n Nota Jual : "+nota_beli+" \n\n Nota Lain :"+nota_ln+"\n\nStatus : " + status);    
        
     window.open("<?= site_url('pembelian/cetakPembelian/')?>"+"/"+nota_beli,'Print',"width=640,height=455");
     window.open("<?= site_url('pembelian/cetakPembelianLain')?>"+"/"+nota_ln,'Print',
                               "width=640,height=455");
             location.reload(); 
            }
  });
  }else{
     r.close();
  }


  }


var table;
    $(document).ready(function() {
      table = $('#table_transaksi').DataTable({ 
        paging: false,
        "info": false,
        "searching": false,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' 
        // server-side processing mode.
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?= site_url('pembelian/ajax_list_transaksi_updatebarang')?>",
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

//
function updateBarang()
{
  var id_barang   = $("#ids_barang").val();
  var nama_barang = $("#Unama_barang").val();
  var harga_beli  = $("#Uharga_beli").val().replace(".","");
  var stok        = $("#Uqty").val();
  var no_nota     = $("#Unota_pembelian").val();
  var stok_awal   = $("#stok_awal").val();

  var bonus_item  = $("#bonus_item").val();
  var isi         = $("#isi").val();
  
  var diskon_item  = $("#diskon").val();
  var diskon_paket = $("#diskon1").val();

  var diskon1_nominal = $("#diskon_1").val();
  var diskon2_nominal = $("#diskon_2").val();


  if(nama_barang == '' || harga_beli == ''){
    alert("harus diisi ");
  }else if (stok == '' || stok == 0 ){
    alert("Harap isi Stok Yang ingin ditambahkan");
  }else{
    var txt;
    var r = confirm("Apakah Yakin Data Yang Anda Masukan Sudah Benar ?");
    if (r == true) {
          $.ajax({
            url : "<?= site_url('pembelian/addbarangupdate')?>",
            type: "POST",
            data: $('#form_transaksi').serialize(),
            dataType: "JSON",
            success: function(response,data)
            {
              reload_table();  
              console.log(response);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding data'+textStatus+jqXHR);
            }
        });
             $('#selesai').removeAttr("disabled");
            // showTotal();
            //mereset semua value setelah btn tambah ditekan
            $('.reset').val('');
            $("#load_row").load("<?= base_url('index.php/pembelian/reloadTotal') ?>");
    }else{
       r.close();
    }
        }
}

function showBarang(str) 
  {
      if (str == "") {
          $('#nama_barang').val('');
          $('#harga_barang').val('');
          $('#qty').val('');
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
                document.getElementById("update_barang").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "<?= base_url('index.php/pembelian/getProduk') ?>/"+str,true);
        xmlhttp.send();
         $("#load_row").load("<?= base_url('index.php/pembelian/reloadTotal') ?>");
      }
  }

  
function showSelesai(str){
  if(str !== ''){
    $('#selesai').removeAttr("disabled");
  }else{
    $('#selesai').attr("disabled","disabled");
  }
}

function deletebarang(id,sub_total)
    {
    // ajax delete data to database
          $.ajax({
            url : "<?= site_url('pembelian/deletebarangupdate')?>/"+id,
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
            var ttl = $('#total').val();
            if(ttl ==0){
              $('#total').val(0);   
            }else{
              $('#total').val(ttl-sub_total);
            }
            $("#load_row").load("<?= base_url('index.php/pembelian/reloadTotal') ?>");
    }

function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax 
       $("#load_row").load("<?= base_url('index.php/pembelian/reloadTotal') ?>");
    
    }

    
function cekHargaBeli(){
  var harga_beli = $("#Uharga_beli").val();
  var stok        = $("#Uqty").val();
  var bonus_item  = $("#bonus_item").val();

  var diskon_item_percent  = $("#diskon").val();
  var diskon_paket_percent = $("#diskon1").val();

  var diskon1_nominal = $("#diskon_1").val();
  var diskon2_nominal = $("#diskon_2").val();
  var isi =$("#isi").val();

  if(harga_beli == '' && harga_jual == '' && bonus_item == '' && diskon_item_percent == '' && diskon1_nominal == '' && diskon2_nominal == '' && diskon_paket_percent){
    alert("Harap di isi dengan lengkap");
  }else{
    var temp_qty;
    if(stok == "" || stok == 0){
      stok=1;
    }else{
      stok=stok;
    }
      var _isi;
      if(isi == 0 || isi == ''){
        _isi=1;
      }else{
        _isi=isi;
      }

    var HB_S=harga_beli*stok;
    var P_Diskon1 =(HB_S*(parseFloat(diskon_item_percent)/100))+parseFloat(diskon1_nominal);
    var P_Diskon2 =(HB_S*(parseFloat(diskon_paket_percent)/100))+parseFloat(diskon2_nominal);

    var harga_eceran=(HB_S-(P_Diskon1+P_Diskon2))/(parseFloat(stok)+parseFloat(bonus_item));
    
    var harga_eceran_bersih=harga_eceran/_isi;
    // console.log(_isi);
    $("#h_eceran").val(parseInt(harga_eceran_bersih));
     $("#load_row").load("<?= base_url('index.php/pembelian/reloadTotal') ?>");

  }
}
  </script>
