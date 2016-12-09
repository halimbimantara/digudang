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
.col-md-2{
  position: relative;
min-height: 1px;
padding-right: 15px;
padding-left: 9px;
}
  .col-md-2-v1{
    position: relative;
    min-height: 1px;
    padding-right: 10px;
    padding-left: 10px;
    width: 14%;
    float: left;
  }
   .col-md-2-v2{
    position: relative;
    min-height: 1px;
    padding-right: 10px;
    padding-left: 10px;
    width: 9%;
    float: left;
  }

  .label-v1 {
    display: inline-block;
    max-width: 100%;
    margin-bottom: 5px;
    font-weight: 700;
    margin-left: 20px;
}
</style>


<div id="content">
           <div class="col-md-12" style="padding:20px;">
                    <div class="col-md-12 padding-0">
<div class="col-md-12 padding-0">
                            <div class="col-md-12">
                                <div class="panel box-v4">
                                    <div class="panel-heading bg-white border-none">
              <h4><span class="fa fa-cart-arrow-down"></span> Register Barang Baru</h4>
                                    </div>
                                    <div class="panel-body padding-0">
       <div class="col-md-12 col-xs-12 col-md-12 padding-0 box-v4-alert">

        <form  id="form_transaksi" role="form">
          <div class="col-md-10">
            <div class="form-group">
           <label class="control-label col-md-2" >Kode Barang :</label>
              <div class="col-md-2">
                <input type="text" class="form-control reset" name="kode_produk" id="kode_produk" required placeholder="Max 12 Kombinasi">
              </div>
             <!--  <label class="control-label col-md-2-v1" for="nama_barang">Nota Penjuala :</label>
              <div class="col-md-4">
                <input type="text" class="form-control reset" name="nama_barang" id="nama_barang">
              </div> -->
          </div>
          </div>
        </form>

<div class="col-md-5">
   <button type="button" class="btn btn-primary" id="tambah" onclick="showSelesai()">
          <i class="fa fa-cart-plus"></i> Hapus</button>
        </div>
    </div>

</div>
</div>
</div>
</div>
</div>
   <div id="update_barang">
   
 </div>
       </div>
       </div>
       </div>
       </div>

       </div>
       </div>
       </div>



<script type="text/javascript">

function showSelesai(){
var nota_beli=$('#kode_produk').val();

if(nota_beli == ''){
  nota_beli.focus();
}else{
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
        xmlhttp.open("GET", "<?= base_url('index.php/penjualan/cekData') ?>/"+nota_beli,true);
        xmlhttp.send();
}
       
}


function deletebarang(str)
    {
      var id=$("#masterbeli").val();
      var x=confirm("Apakah Anda Yakin Akan Menghapus Nota "+id);
      if(x ==  true){
        $.ajax({
            url : "<?= site_url('penjualan/deletenotajual')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
              alert("Berhasil Dihapus");
               location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });
      }
       
    }
</script>