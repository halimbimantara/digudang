<style type="text/css">
  .bg-white {
    background-color: #EC3446 !important;
}
h4{
      color: white;
}
.table > thead:first-child > tr:first-child > th {
    border-top: 0;
    background-color: #ec1c4f;
    color: white;
}
.panel-h >h4{
  color: #918C8C;
}
</style>
<div id="content">
           <div class="col-md-12" style="padding:20px;">
                    <div class="col-md-12 padding-0">
                        <div class="col-md-12 padding-0">
                            <div class="col-md-8">
                                <div class="panel box-v4">
                                    <div class="panel-heading bg-white border-none">
                                      <h4><span class="fa fa-cart-arrow-down"></span> Transaksi Pembelian Lain-Lain</h4>
                                    </div>
                                    <div class="panel-body padding-0">
       <div class="col-md-12 col-xs-12 col-md-12 padding-0 box-v4-alert">
<div class="panel-body">
          <!-- Start div barang -->
          <form id="form_transaksi" role="form">
          <div id="barang">
           <div class="col-md-8">
            <div class="form-group">
           <label class="control-label col-md-4" 
                for="nama_barang">Keterangan :</label>
              <div class="col-md-8">
                <input type="text" class="form-control reset" 
                  name="nama_barang" id="nama_barang" >
              </div>
          </div>
          </div>

           <div class="col-md-8">
            <div class="form-group">
           <label class="control-label col-md-4" 
                for="nama_barang">Cost :</label>
              <div class="col-md-5">
                <input type="text" class="form-control reset" 
                  name="harga_beli" id="harga_beli" class="form-control" >
              </div>
          </div>
          </div>
          <div class="col-md-8">
            <div class="form-group">
           <label class="control-label col-md-4" 
                for="nama_barang">Qty:</label>
              <div class="col-md-4">
                <input class="form-control reset" autocomplete="off"  
                onchange="subTotal(this.value)" 
                  onkeyup="subTotal(this.value)" id="qty" min="0" name="qty" placeholder="Isi qty..." type="number">
              </div>
          </div>
          </div>

           <div class="col-md-8">
            <div class="form-group">
           <label class="control-label col-md-4" 
                for="nama_barang">Sub Total:</label>
              <div class="col-md-5">
                <input type="text" class="form-control reset" 
                  name="sub_total" id="sub_total" class="form-control" readonly="readonly">
              </div>
          </div>
          </div>
           <div class="col-md-8">
           <div class="form-group">
           <label class="control-label col-md-4" 
                for="pelanggan">Kategori :</label>
              <div class="col-md-7">
               <select id="id_kategori" name="id_kategori" class="form-control" required  
               onchange="">
                     <option value="">Pilih Kategori Pengeluaran Toko</option>
                        <option  value="1">Keperluan toko</option><!--Kertas dll -->
                        <option  value="2">Inventaris</option><!--LCd Pallete dll -->
                        <option  value="3">Retribusi</option><!--Telpon dll -->
                        <option  value="4">Pajak</option>
                      
                      </select>
              </div>
          </div>
          </div>

          </div>
          </form><div class="col-md-1">
             <button type="button" class="btn btn-primary" id="tambah" onclick="addBarang()">
                  <i class="fa fa-cart-plus"></i> Tambah</button>
              </div>
              
     </div>
     </div>
     </div>
     </div>
     </div>
     <div class="col-md-4">
                            <div class="col-md-12 padding-0">
                              <div class="panel box-v1">
                                  
                                  <div class="panel-body">
                                    <div class="col-md-12 padding-0">
                                      <div class="panel-h"><h4>Customer : </h4></div>
              <div class="col-md-12">
            <div class="form-group">
           <label class="control-label col-md-4" 
                for="nama_barang">Total </label>
              <div class="col-md-8">
               <input type="text" class="form-control input-small" 
                name="total" id="total" placeholder="0"
                readonly="readonly"  value="<?= number_format($this->cart->total(), 0 , '' , '.' ); ?>">
              </div>
              <input type="hidden" id="total_temp" value="<?= number_format($this->cart->total(), 0 , '' , '.' ); ?>">
          </div>
          
          </div>          
          
                                  </div>
                              </div>
                            </div>
                           
                        </div>
                    </div>
      <div class="panel-body">
        <table id="table_transaksi" class="table table-striped table-bordered">
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
        <button type="button" class="btn btn-primary btn-lg" id="selesai" disabled="disabled" onclick="selesai();">
        Selesai <i class="fa fa-angle-double-right"></i></button>
      </div>
                    </div>
     </div>
     </div>
     </div>
     </div>
<script type="text/javascript">
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
            "url": "<?= site_url('pembelian/ajax_list_transaksi')?>",
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

function selesai(){
    var total     = $('#total').val().replace(".", "");
   if(total !== '')
   {
 
    $.post("<?= site_url('pembelian/prosespembelian')?>", //Required URL of the page on server
            { // Data Sending With Request To Server
              id:0
            },
            function(response,status){ // Required Callback Function
                alert("*----Received Data----*\n\nResponse : " + response+"\n\nStatus : " + status);
                 location.reload(); 
                 $('.reset').val('');
                 location.reload();
    var win = window.open("<?= site_url('pembelian/cetakPembelianLain/')?>"+"/"+response,'Print',"width=640,height=455");
    win.focus(); });
   }else{
        alert("Harap Isi data yang benar");
   }

  }

function subTotal(qty)
  {
    var harga = $('#harga_beli').val().replace(".", "").replace(".", "");
                $('#sub_total').val(convertToRupiah(harga*qty));
  }
 function reload_table()
    {

      table.ajax.reload(null,false); //reload datatable ajax 
    
    }
function convertToRupiah(angka)
  {

      var rupiah = '';    
      var angkarev = angka.toString().split('').reverse().join('');
      
      for(var i = 0; i < angkarev.length; i++) 
        if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
      
      return rupiah.split('',rupiah.length-1).reverse().join('');
  
  }
function addBarang(){

   var nama_barang = $('#nama_barang').val();
   var harga_beli  = $('#harga_beli').val();
   var qty         = $('#qty').val();
   var Kategori    = $('#id_kategori').val();

    if (nama_barang == '') {
          $('#nama_barang').focus();
        }else if(qty == ''){
          $('#qty').focus();
        }else if(harga_beli == ''){
          $('#harga_beli').focus();
        }else if(Kategori == ''){
          $('#id_kategori').focus();  
        }else{
       // ajax adding data to database
          $.ajax({
            url : "<?= site_url('pembelian/addbaranglain')?>",
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
            showTotal();
            $('#selesai').removeAttr("disabled");
            //mereset semua value setelah btn tambah ditekan
            $('.reset').val('');
        };
}
$('.uang').maskMoney({
    thousands:'.', 
    decimal:',', 
    precision:0
  });

 function showTotal()
    {
      var total     = $('#total').val().replace(".", "").replace(".", "");
      var sub_total = $('#sub_total').val().replace(".", "").replace(".", "");
      
      $('#total').val(convertToRupiah((Number(total)+Number(sub_total))));
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
            url : "<?= site_url('pembelian/deletebaranglain')?>/"+id,
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
            var ttl = $('#total').val().replace(".", "");
           $('#total').val(convertToRupiah(ttl-sub_total));
    }
</script>

<!-- 
pembelian lain-lain *
total nota {total nota + sc+dc} *
sc hny untk pngrimn *
invsti smpn sj {tabel*,form -}

Buku Besar
Stok juga ad prbhn hrg
plggn (foto)
-->
