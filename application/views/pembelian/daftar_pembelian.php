
<div id="content">
           <div class="col-md-12" style="padding:20px;">
                    <div class="col-md-12 padding-0">
                        <div class="col-md-12 padding-0">
                            <div class="col-md-12">
                                <div class="panel box-v4">
                                    <div class="panel-heading bg-white border-none">
                                      <h4><span class="fa fa-cart-arrow-down"></span> DAFTAR STOK KOMODITI</h4>
                                    </div>
                                    <div class="panel-body padding-0">
       <div class="col-md-12 col-xs-12 col-md-12 padding-0 box-v4-alert">
<div class="panel-body">
<form  action="<?= site_url('laporan/jumlahstok')?>">
<div class="col-md-8">
  <button type="submit" id="cetak" class="btn btn-primary"><i class="icons icon-docs"></i> Cetak Stok</button>
       </div>
       </form>
       <p></p>
        <table id="table_transaksi" class="table table-striped table-bordered">
        <thead>
          <tr>
              <th>No</th>
              <th>Nama Barang</th>
              <th>Harga Jual</th>
              <th>Harga Grosir</th>
              <th>Min Qty Grosir</th>
              <th>Total Stok</th>
              <th>Aksi</th>
          </tr>
        </thead>
        <tbody>

        <?php 
        $no=1;
                foreach ($data->result() as $key) { ?>
        <tr>
          <td><?php echo $no ?></td>
          <td><?php echo $key->nama_produk ?></td>
          <td><?php echo $key->harga_jual  ?></td>
          <td><?php echo $key->jual_grosir ?></td>
          <td><?php echo $key->qty_grosir ?></td>
          <td><?php echo $key->jumlah_stok ?></td>
        <?php 
          if ( $_SESSION['acces'] == 2) {
            echo '<td>
                 <a href="#" class="btn-sm btn-info" data-toggle="modal" data-target="#myModal" 
                 data-idproduk="'.$key->kode_produk.'"
                 data-namaproduk="'.$key->nama_produk.'" 
                 data-hargajual="'.$key->harga_jual.'" 
                 data-qgrosir="'.$key->qty_grosir.'" 
                 data-hgrosir="'.$key->jual_grosir.'">Detail</a>
                 </td>';
               }else{ echo "";}?>
               
          </tr>
        
        <?php $no++; }?>
        </tbody>
      </table>

<!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
      <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
      <div class="container">
        <h2>Detail Harga Jual Komoditi </h2>
      </div>
      </div>
      <div class="modal-body">
        
      <div class="form-group">
        <label>Kode Barang : </label>
        <input class="form-control" type="text" name="id_produk"  id="id_produk" value="" disabled="true">
      </div>
      <div class="form-group">
        <label>Nama Barang :</label>
        <input class="form-control" type="text" name="name" id="name" value="">
      </div>
      <div class="form-group">
        <label>Harga Jual :</label>
        <input class="form-control" type="text" name="h_jual" id="h_jual" value="">
      </div>
      <div class="form-group">
        <label>Harga Grosir</label>
        <input class="form-control" type="text" name="h_grosir" id="h_grosir" value="">
      </div>
      <div class="form-group">
        <label>Qty Minimum Grosir</label>
        <input class="form-control" type="text" name="q_grosir" id="q_grosir" value="">
      </div>

      <div class="modal-footer">
        <input class="btn btn-danger" type="submit"  value="Hapus" onclick="DeleteBarang();">
      <input class="btn btn-warning" type="submit"  value="Perbarui" onclick="updateKomoditi();">
        <a href="#" class="btn" data-dismiss="modal">Close</a>
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
     </div>
     </div>
     </div>
     </div>
<script type="text/javascript">
    $('#myModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);

      var id_produk   = button.data('idproduk');
      var nama_produk = button.data('namaproduk');
      var hargajual   = button.data('hargajual');
      var hargagrosir = button.data('hgrosir');
      var qtygrosir = button.data('qgrosir');

      var modal = $(this);
      //document.getElementById('photo_dosen').src = "/tadj/"+photo;
      document.getElementById('id_produk').value = id_produk;
      document.getElementById('name').value = nama_produk;
      document.getElementById('h_jual').value = hargajual;
      document.getElementById('h_grosir').value = hargagrosir;
      document.getElementById('q_grosir').value = qtygrosir;
      //document.getElementById('nidn').value = nidn;
    });



    function updateKomoditi(){

      var kode_produk=$("#id_produk").val();
      var namaproduk =$("#name").val();
      var hrjual     =$("#h_jual").val();
      var hrgrosir   =$("#h_grosir").val();
      var qtygrosir  =$("#q_grosir").val();

      if (kode_produk == '' || kode_produk == 0) {
          alert("Data Tidak Lengkap");
      }else if(namaproduk =='' || namaproduk == 0 ){
          alert("Nama Produk Tidak Boleh Kosong");
      }else{
      $.post("<?= site_url('pembelian/updatehjualkomoditi')?>", //Required URL of the page on server
            { // Data Sending With Request To Server
                kode_produk:kode_produk,
                nama_produk:namaproduk,
                harga_jual:hrjual,
                harga_grosir:hrgrosir,
                qty_grosir:qtygrosir
            },
            function(response,status){ // Required Callback Function
          alert("*----Received Data Pelanggan baru----*\n\nResponse : " + response+"\n\nStatus : " + status);
              $('#myModal').hide();
              location.reload();

            });
    }

    }


    function DeleteBarang(){
  
  var kode_produk=$("#id_produk").val();
  var r = confirm("Apakah Yakin Nama Item Akan di Hapus ?");

  if (r == true) {
      // ajax delete data to database
          $.ajax({
            url : "<?= site_url('pembelian/deletenamaitem')?>/"+kode_produk,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
               //
               alert("Berhasil Di Update");
                $('#myModal').hide();
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
</script>