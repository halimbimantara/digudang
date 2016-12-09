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
                        <div class="col-md-12 padding-0">
                            <div class="col-md-12">
                                <div class="panel box-v4">
                                    <div class="panel-heading bg-white border-none">
                                      <h4><span class="fa fa-cart-arrow-down"></span> Data Pegawai</h4>
                                    </div>
                                    <div class="panel-body padding-0">
       <div class="col-md-12 col-xs-12 col-md-12 padding-0 box-v4-alert">
       <div> 
          <button type="button" class="btn btn-primary" 
                id="tambah">
                  <i class="icons icon-user-follow"></i> Tambah Pegawai</button>
       </div>
<div class="panel-body">
        <table id="table_transaksi" class="table table-striped table-bordered">
        <thead>
          <tr>
              <th>No</th>
              <!-- <th>Id Pelanggan</th> -->
              <th>Nama</th>
              <th>Alamat</th>
              <th>No Telpon</th>
              <!-- <th>Jual</th> -->
             <?php if($_SESSION['acces'] == 2){ ?>
              <th>Aksi</th>
              <?php } ?>
          </tr>
        </thead>
        <?php 
        $no=1;
        foreach ($pegawai as $key) { ?>
        <tbody>
          <td><?php echo $no;  ?></td>
          <!-- <td><?php echo $key->id_pelanggan; ?></td> -->
          <td><b><?php echo $key->nama_pegawai;?></b></td>
          <td><?php echo $key->alamat; ?></td>
          <td><?php echo $key->no_tlpn?></td>
          <td>
             <?php
          if($_SESSION['acces'] == 2){

          ?>
          <button class=" btn btn-circle btn-mn btn-danger" onclick="deletePelanggan(<?php echo $key->pegawai_id  ?>)" value="primary">
                                <span class="fa fa-close"></span>
                              </button> Hapus  
                              <a href="#" class="oke btn btn-circle btn-mn btn-info" 
                              data-toggle="modal" data-target="#Modaledit"
                              data-id="<?php echo $key->pegawai_id; ?>" 
                              data-nama="<?php echo $key->nama_pegawai;?>"
                              data-alamat="<?php echo $key->alamat; ?>" 
                              data-tlpn="<?php echo $key->no_tlpn;?>"
                              data-status="<?php echo $key->status?>">
                                <span class="icons icon-note"></span>
                              </a> Edit</td>
          <?php }else{} ?>
        </tbody>
        <?php $no++; } ?>
      </table>
     </div>
     </div>
     </div>
     </div>
     </div>


    
     </div>
     </div>
     </div>
     <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4-x style="color:red;"><span class="glyphicon glyphicon-lock"></span> Data Pegawai</h4-x>
        </div>
        <div class="modal-body">
            <div class="form-group">
              <label for="usrname"><span class="glyphicon glyphicon-user"></span> Nama</label>
              <input type="text" class="form-control" id="nama_Pelanggan" name="nama_Pelanggan" placeholder="Masukan Nama">
            </div>
            <div class="form-group">
              <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Alamat</label>
              <textarea class="form-control" id="alamat_Pelanggan" name="alamat_Pelanggan"  placeholder="Masukan Alamat" ></textarea>
            </div>
             <div class="form-group">
              <label for="tlpn"><span class="fa fa-phone"></span> No Telepon</label>
              <input type="text" class="form-control" id="tlpn_Pelanggan" name="tlpn_Pelanggan" placeholder="Enter 0816212">
            </div>
          <!--    <div class="form-group">
              <label for="jarak"><span class="icons icon-location-pin"></span> Jarak Rumah</label>
              <input type="text" class="form-control" id="jarak_Pelanggan" name="Jarak_Pelanggan" placeholder="Enter 12">
            </div> -->
           
            <button type="submit" id="save" class="btn btn-round btn-success"><span class="fa fa-check"></span> Simpan</button>
        
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-default btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
        </div>
      </div>
    </div>
    </div>
     
   <!-- Modal -->
  <div class="modal fade" id="Modaledit" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4-x style="color:red;"><span class="glyphicon glyphicon-lock"></span> Edit Pegawai</h4-x>
        </div>
        <div class="modal-body">
            <div class="form-group">
            <input type="hidden" id="id_pelanggan" value="">
              <label for="usrname"><span class="glyphicon glyphicon-user"></span> Nama</label>
              <input type="text" class="form-control" id="name_Pelanggan" name="name_Pelanggan" placeholder="Masukan Nama">
            </div>
            <div class="form-group">
              <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Alamat</label>
              <textarea class="form-control" id="Ealamat_Pelanggan" name="alamat_Pelanggan"  placeholder="Masukan Alamat" ></textarea>
            </div>
             <div class="form-group">
              <label for="tlpn"><span class="fa fa-phone"></span> No Telepon</label>
              <input type="text" class="form-control" id="Etlpn_Pelanggan" name="tlpn_Pelanggan" placeholder="Enter 0816212">
            </div>
             <div class="form-group">
              <label for="jarak"><span class="icons icon-location-pin"></span> Status</label>
              <input type="number" class="form-control" id="Ejarak_Pelanggan" name="Jarak_Pelanggan" placeholder="Enter 12">
            </div>
          
            <input type="hidden" id="id_kode_pel" value="">
            <button type="submit" id="update" class="btn btn-round btn-success" onclick="editPelanggan()"><span class="fa fa-check"></span> Update</button>
        
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-default btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
        </div>
      </div>
    </div>
    </div>


<script>
$(document).ready(function(){
    $("#tambah").click(function(){
        $("#myModal").modal();
    });
});

$(document).ready(function(){
    $("#edit").click(function(){
        $("#Modaledit").modal();
          var id = $(this).data('id');
          var nama=$(this).data('nama');
          var alamat=$(this).data('alamat');
          var no_tlpn=$(this).data('tlp');
          var jarak = $(this).data('jarak');
          
          document.getElementById("id_pelanggan").value=id;
           $(".modal-body #e_Pelanggan").val(name);
          // console.log(name);

    });
});


function deletePelanggan(id){

  $.post("<?= site_url('user/delKasir')?>", //Required URL of the page on server
            { // Data Sending With Request To Server
                id:id
            },
            function(response,status){ // Required Callback Function
                alert("*----Received Data----*\n\nResponse : " + response+"\n\nStatus : " + status);//"response" receives - whatever written in echo of above PHP script.
                location.reload(); 
               
            });

}


 $(function() {
 $("button#save").click(function(){

 var nama=   $("#nama_Pelanggan").val();
 var alamat= $("#alamat_Pelanggan").val();
 var no_tlpn= $("#tlpn_Pelanggan").val();
 var jarak= $("#jarak_Pelanggan").val();

  $.post("<?= site_url('user/addKasir')?>", //Required URL of the page on server
            { // Data Sending With Request To Server
                nama:nama,
                alamat:alamat,
                no:no_tlpn
            },
            function(response,status){ // Required Callback Function
                alert("*----Received Data----*\n\nResponse : " + response+"\n\nStatus : " + status);//"response" receives - whatever written in echo of above PHP script.
                $("#myModal").modal('hide'); 
                location.reload(); 
                // window.location="#";
                 // $('#reset').hide();
            });
 });
});


function editPelanggan(){
  var id     = $("#id_kode_pel").val();
  var nama   = $("#name_Pelanggan").val();
  var alamat = $("#Ealamat_Pelanggan").val();
  var no_tlpn= $("#Etlpn_Pelanggan").val();
  var jarak  = $("#Ejarak_Pelanggan").val();

  if (id == '' || id == 0) {
          alert("Data Tidak Lengkap");
      }else if(nama =='' || nama == 0 ){
          alert("Nama  Tidak Boleh Kosong");
      }else{
      $.post("<?= site_url('User/updateKasir')?>", //Required URL of the page on server
            { // Data Sending With Request To Server
                id:id,
                nama:nama,
                alamat:alamat,
                jarak:jarak,
                no_tlpn:no_tlpn
            },
            function(response,status){ // Required Callback Function
          alert("*----Received Data Pelanggan baru----*\n\nResponse : " + response+"\n\nStatus : " + status);
              $('#Modaledit').hide();
              location.reload();

            });
    }
  
  
}

$('#Modaledit').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);
        var id       =button.data('id');
        var nama     =button.data('nama');
        var alamat   =button.data('alamat');
        var no_tlpn  =button.data('tlpn');
        var jarak    =button.data('status');

      var modal = $(this);
      document.getElementById('id_kode_pel').value = id;
      document.getElementById('name_Pelanggan').value = nama;
      document.getElementById('Ealamat_Pelanggan').value = alamat;
      document.getElementById('Etlpn_Pelanggan').value = no_tlpn;
        document.getElementById('Ejarak_Pelanggan').value = jarak;
    });
</script>
