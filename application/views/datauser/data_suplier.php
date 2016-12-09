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
                                      <h4><span class="fa fa-cart-arrow-down"></span> Daftar Suplier</h4>
                                    </div>
                                    <div class="panel-body padding-0">
       <div class="col-md-12 col-xs-12 col-md-12 padding-0 box-v4-alert">
       <div> 
          <button type="button" class="btn btn-primary" 
                id="tambah">
                  <i class="icons icon-user-follow"></i> Tambah Suplier</button>
       </div>
<div class="panel-body">
        <table id="table_transaksi" class="table table-striped table-bordered">
        <thead>
          <tr>
              <th>No</th>
              <th>Id Suplier</th>
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
        foreach ($suplier as $key) { ?>
        <tbody>
          <td><?php echo $no;  ?></td>
          <td><?php echo $key->kode_suplier; ?></td>
          <td><b><?php echo $key->nama;?></b></td>
          <td><?php echo $key->alamat; ?></td>
          <td><?php echo $key->no_tlpn?></td>
          <td>
               <?php
          if($_SESSION['acces'] == 2){

          ?>
          <button class=" btn btn-circle btn-mn btn-danger" value="primary" 
          onclick="deleteSuplier(<?php echo $key->kode_suplier  ?>)">
                                <span class="fa fa-close"></span>
                              </button> Hapus <a href="#" class="oke btn btn-circle btn-mn btn-info" 
                              data-toggle="modal" data-target="#Modaledit"
                              data-id="<?php echo $key->kode_suplier; ?>" 
                              data-nama="<?php echo $key->nama;?>"
                              data-alamat="<?php echo $key->alamat; ?>" 
                              data-tlpn="<?php echo $key->no_tlpn?>" >
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
          <h4-x style="color:red;"><span class="glyphicon glyphicon-lock"></span> Data Suplier</h4>
        </div>
        <div class="modal-body">

            <div class="form-group">
              <label for="usrname"><span class="glyphicon glyphicon-user"></span> Nama Suplier</label>
              <input type="text" class="form-control" id="nama_Suplier" name="nama_Suplier" placeholder="Masukan Nama">
            </div>
            <div class="form-group">
              <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Alamat</label>
              <textarea class="form-control" id="alamat_Suplier" name="alamat_Suplier"  placeholder="Masukan Alamat" ></textarea>
            </div>
             <div class="form-group">
              <label for="tlpn"><span class="fa fa-phone"></span> No Telepon</label>
              <input type="text" class="form-control" id="tlpn_Suplier" name="tlpn_Suplier" placeholder="Enter 0816212">
            </div>
           
            <button type="submit" id="save" class="btn btn-round btn-success"><span class="fa fa-check"></span> Tambah</button>
        
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
          <h4-x style="color:red;"><span class="glyphicon glyphicon-lock"></span> Data Suplier</h4-x>
        </div>
        <div class="modal-body">
            <div class="form-group">
              <label for="usrname"><span class="glyphicon glyphicon-user"></span> Nama Suplier</label>
              <input type="text" class="form-control" id="Enama_Suplier" name="nama_Suplier" placeholder="Masukan Nama">
            </div>
            <div class="form-group">
              <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Alamat</label>
              <textarea class="form-control" id="Ealamat_Suplier" name="alamat_Suplier"  placeholder="Masukan Alamat" ></textarea>
            </div>
             <div class="form-group">
              <label for="tlpn"><span class="fa fa-phone"></span> No Telepon</label>
              <input type="text" class="form-control" id="Etlpn_Suplier" name="tlpn_Suplier" placeholder="Enter 0816212">
            </div>
             <input type="hidden" id="id_kode_suplier" value="">
            <button type="submit" id="Edit" onclick="editSuplier();" class="btn btn-round btn-success"><span class="fa fa-check"></span> Edit</button>
        
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-default btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
        </div>
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


function deleteSuplier(id){
 $.post("<?= site_url('user/delSuplier')?>", //Required URL of the page on server
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

 var nama=   $("#nama_Suplier").val();
 var alamat= $("#alamat_Suplier").val();
 var no_tlpn= $("#tlpn_Suplier").val();

  $.post("<?= site_url('user/addSuplier')?>", //Required URL of the page on server
            { // Data Sending With Request To Server
                nama:nama,
                alamat:alamat,
                no:no_tlpn
            },
            function(response,status){ // Required Callback Function
                alert("*----Received Data----*\n\nResponse : " + response+"\n\nStatus : " + status);//"response" receives - whatever written in echo of above PHP script.
                $("#myModal").modal('hide'); 
                location.reload(); 
              
            });
 });
});


function editSuplier(){
  var id=$("#id_kode_suplier").val();
  var nama=$("#Enama_Suplier").val();
  var alamat=$("#Ealamat_Suplier").val();
  var no_tlpn=$("#Etlpn_Suplier").val();

  if (id == '' || id == 0) {
          alert("Data Tidak Lengkap");
      }else if(nama =='' || nama == 0 ){
          alert("Nama  Tidak Boleh Kosong");
      }else{
      $.post("<?= site_url('User/updateSuplier')?>", //Required URL of the page on server
            { // Data Sending With Request To Server
                id:id,
                nama:nama,
                alamat:alamat,
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

      var modal = $(this);
      document.getElementById('id_kode_suplier').value = id;
      document.getElementById('Enama_Suplier').value = nama;
      document.getElementById('Ealamat_Suplier').value = alamat;
      document.getElementById('Etlpn_Suplier').value = no_tlpn;
    });


</script>
