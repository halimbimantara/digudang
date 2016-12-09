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
                                      <h4><span class="fa fa-cart-arrow-down"></span> Data Petugas Delivery</h4>
                                    </div>
                                    <div class="panel-body padding-0">
       <div class="col-md-12 col-xs-12 col-md-12 padding-0 box-v4-alert">
       <div>
        
          <button type="button" class="btn btn-primary" id="tambah">
                  <i class="icons icon-user-follow"></i> Tambah Data Petugas Delivery</button>
       </div>
<div class="panel-body">
        <table id="table_transaksi" class="table table-striped table-bordered">
        <thead>
          <tr>
              <th>No</th>
              <!-- <th>Id</th> -->
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
        foreach ($deliver as $key) { ?>
        <tbody>
          <td><?php echo $no;  ?></td><!-- 
          <td><?php echo $key->id_petugas; ?></td> -->
          <td><b><?php echo $key->nama_petugas ?></b></td>
          <td><?php echo $key->alamat; ?></td>
          <td><?php echo $key->no_tlpn?></td>
          <td>

          <?php
          if($_SESSION['acces'] == 2){
          ?>
          <button class=" btn btn-circle btn-mn btn-danger" value="primary" 
          onclick="deleteDelivery(<?php echo $key->id_petugas  ?>)">
                                <span class="fa fa-close"></span>
                              </button> Hapus <a href="#" class="oke btn btn-circle btn-mn btn-info" 
                              data-toggle="modal" data-target="#Modaledit"
                              data-id="<?php echo $key->id_petugas; ?>" 
                              data-nama="<?php echo $key->nama_petugas;?>"
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
    

    <!-- COST SCDC -->
  <div class="col-md-12">
                                <div class="panel box-v4">
                                    <div class="panel-heading bg-white border-none">
                                      <h4><span class="fa fa-cart-arrow-down"></span> Data Cost Delivery</h4>
                                    </div>
                                    <div class="panel-body padding-0"></div>
<div class="panel-body">
        <table id="table_transaksi" class="table table-striped table-bordered">
        <thead>
          <tr>
              
              <!-- <th>Id</th> -->
              <th>Biaya Service Charge %</th>
              <th>Biaya Delivery Charge</th>
              <th>Biaya Delivery Per KM</th>
              <!-- <th>Jual</th> -->
            <?php if($_SESSION['acces'] == 2){ ?>
              <th>Aksi</th>
              <?php } ?>
          </tr>
        </thead>
        <?php 
        $no=1;
        foreach ($cd as $key) { ?>
        <tbody>
          <td><b><?php echo $key->biaya_sc ?></b></td>
          <td><?php echo $key->biaya_dc; ?></td>
          <td><?php echo $key->biaya_dckm;   ?></td>
          <td>

          <?php
          if($_SESSION['acces'] == 2){
          ?>
          <a href="#" class="oke btn btn-circle btn-mn btn-info" 
                              data-toggle="modal" data-target="#ModalOngkir"
                              data-id="<?php echo $key->id_delivery; ?>" 
                              data-sc="<?php echo $key->biaya_sc;?>"
                              data-dc="<?php echo $key->biaya_dc;?>" 
                              data-dckm="<?php echo $key->biaya_dckm;?>" >
                                <span class="icons icon-note"></span>
                              </a> Edit</td>
          <?php }else{} ?>
        </tbody>
        <?php  } ?>
      </table>
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
          <h4-x style="color:red;"><span class="glyphicon glyphicon-lock"></span> Data Delivery</h4>
        </div>
        <div class="modal-body">

            <div class="form-group">
              <label for="usrname"><span class="glyphicon glyphicon-user"></span> Nama Delivery</label>
              <input type="text" class="form-control" id="nama_Delivery" name="nama_Delivery" placeholder="Masukan Nama">
            </div>
            <div class="form-group">
              <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Alamat</label>
              <textarea class="form-control" id="alamat_Delivery" name="alamat_Delivery"  placeholder="Masukan Alamat" ></textarea>
            </div>
             <div class="form-group">
              <label for="tlpn"><span class="fa fa-phone"></span> No Telepon</label>
              <input type="text" class="form-control" id="tlpn_Delivery" name="tlpn_Delivery" placeholder="Enter 0816212">
            </div>
           
            <button type="submit" id="simpan" class="btn btn-round btn-success"><span class="fa fa-check"></span> Tambah</button>
        
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
          <h4-x style="color:red;"><span class="glyphicon glyphicon-lock"></span> Update Petugas Delivery</h4-x>
        </div>
        <div class="modal-body">
            <div class="form-group">
              <label for="usrname"><span class="glyphicon glyphicon-user"></span> Nama </label>
              <input type="text" class="form-control" id="Enama_Del" name="Enama_Del" placeholder="Masukan Nama">
            </div>
            <div class="form-group">
              <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Alamat</label>
              <textarea class="form-control" id="Ealamat_Del" name="Ealamat_Del"  placeholder="Masukan Alamat" ></textarea>
            </div>
             <div class="form-group">
              <label for="tlpn"><span class="fa fa-phone"></span> No Telepon</label>
              <input type="text" class="form-control" id="Etlpn_Del" name="Etlpn_Del" placeholder="Enter 0816212">
            </div>
             <input type="hidden" id="id_kode_del" value="">
            <button type="submit" id="Edit" onclick="editDelivery();" class="btn btn-round btn-success"><span class="fa fa-check"></span> Edit</button>
        
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-default btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
        </div>
      </div>
    </div>
    </div>
    <!-- End Modal Edit -->

    <!-- Start Modal Ongkir -->
      <div class="modal fade" id="ModalOngkir" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4-x style="color:red;"><span class="glyphicon glyphicon-lock"></span> Update Ongkos Delivery</h4-x>
        </div>
        <div class="modal-body">
            <div class="form-group">
              <label for="usrname"><span class="glyphicon glyphicon-user"></span> Service Charge % </label>
              <input type="text" class="form-control" id="E_SC" name="E_SC" placeholder="Masukan 0.3">
            </div>
            <div class="form-group">
              <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Delivery Charge</label>
              <textarea class="form-control" id="E_DC" name="E_DC"  placeholder="Masukan 3000" ></textarea>
            </div>
             <div class="form-group">
              <label for="tlpn"><span class="fa fa-phone"></span> Delivery Charge Per KM</label>
              <input type="text" class="form-control" id="E_DCKM" name="E_DCKM" placeholder="Masukan 2000">
            </div>
             <input type="hidden" id="id_ongkir" value="">
            <button type="submit" id="Edit" onclick="editOngkir();" class="btn btn-round btn-success"><span class="fa fa-check"></span> Edit</button>
        
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-default btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
        </div>
      </div>
    </div>
    </div>
    <!-- END -->
     </div>

<script>
$(document).ready(function(){
    $("#tambah").click(function(){
        $("#myModal").modal();
    });
});

var table;
function reload_table()
    {

      table.ajax.reload(null,false); //reload datatable ajax 
    
    }
function deleteDelivery(id){
 $.post("<?= site_url('user/delPetugasdelivery')?>", //Required URL of the page on server
            { // Data Sending With Request To Server
                id:id
            },
            function(response,status){ // Required Callback Function
                alert("*----Received Data----*\n\nResponse : " + response+"\n\nStatus : " + status);//"response" receives - whatever written in echo of above PHP script.
                location.reload(); 
               
            });

}

 $(function() {
 $("button#simpan").click(function(){

 var nama   = $("#nama_Delivery").val();
 var alamat = $("#alamat_Delivery").val();
 var no_tlpn= $("#tlpn_Delivery").val();

  $.post("<?= site_url('user/addPetugasdelivery')?>", //Required URL of the page on server
            { // Data Sending With Request To Server
                nama_petugas:nama,
                alamat:alamat,
                no:no_tlpn
            },
            function(response,status){ // Required Callback Function
                alert("*----Received Data----*\n\nResponse : " + response+"\n\nStatus : " + status);//"response" receives - whatever written in echo of above PHP script.
                $("#myModal").modal('hide');
                // reload_table(); 
                location.reload(); 
             
            });
 });
});

function editDelivery(){
  var id=$("#id_kode_del").val();
  var nama=$("#Enama_Del").val();
  var alamat=$("#Ealamat_Del").val();
  var no_tlpn=$("#Etlpn_Del").val();

  if (id == '' || id == 0) {
          alert("Data Tidak Lengkap");
      }else if(nama =='' || nama == 0 ){
          alert("Nama  Tidak Boleh Kosong");
      }else{
      $.post("<?= site_url('User/updatePetugasdelivery')?>", //Required URL of the page on server
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

function editOngkir(){
  var id  =$("#id_ongkir").val();
  var sc  =$("#E_SC").val();
  var dc  =$("#E_DC").val();
  var dckm=$("#E_DCKM").val();

  if (id == '' || id == 0) {
          alert("Data Tidak Lengkap");
      }else if(sc =='' || sc == 0 || dc == '' || dckm == ''){
          alert("Data Tidak Boleh Kosong");
      }else{
      $.post("<?= site_url('User/updateOngkir')?>", //Required URL of the page on server
            { // Data Sending With Request To Server
                id:id,
                sc:sc,
                dc:dc,
                dckm:dckm
            },
            function(response,status){ // Required Callback Function
          alert("*----Received Data Pelanggan baru----*\n\nResponse : " + response+"\n\nStatus : " + status);
              $('#ModalOngkir').hide();
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
      document.getElementById('id_kode_del').value = id;
      document.getElementById('Enama_Del').value = nama;
      document.getElementById('Ealamat_Del').value = alamat;
      document.getElementById('Etlpn_Del').value = no_tlpn;
    });


$('#ModalOngkir').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);

        var id   =button.data('id');
        var sc   =button.data('sc');
        var dc   =button.data('dc');
        var dckm =button.data('dckm');

      var modal = $(this);
      document.getElementById('id_ongkir').value = id;
      document.getElementById('E_SC').value = sc;
      document.getElementById('E_DC').value = dc;
      document.getElementById('E_DCKM').value = dckm;
    });


</script>
