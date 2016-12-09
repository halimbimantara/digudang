<?php
class Penjualan extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                 $this->load->helper('date');
                 $this->load->model('Penjualan_model');
                 // session_start();
                if(empty($_SESSION['uname']) ){
                    redirect('/login/');
                }
                // $this->load->helper('url_helper');
        }
        public function index()
        {
          // $this->db->query("DELETE FROM trx_penjualan_tmp"); 
          $this->cart->destroy();
           if(empty($_SESSION['uname']) ){
                    redirect('/login/');
            }else{
                  $q_notaakhir=$this->db->query("SELECT masterpenjualan_id FROM master_penjualan 
                                    order by masterpenjualan_id desc limit 0,1")->row();
                  $data['notaakhir'] =$q_notaakhir->masterpenjualan_id;
                  $data['total_jual']=$this->Penjualan_model->total_jual()->total;
                  $data['produk']    =$this->Penjualan_model->getProduk_();
                  // $data['produk']    = $this->Penjualan_model->getProduk();
                  $data['ongkir']    = $this->Penjualan_model->getOngkir();
                  $data['pelanggan'] = $this->Penjualan_model->getPelanggan();
                  $data['petugas'] = $this->Penjualan_model->getPetugasDeliver();

                  $this->load->view('dashboard/header');
                  $this->load->view('dashboard/left_menu.php');
                  $this->load->view('penjualan/index', $data);
                  $this->load->view('dashboard/_js');
            }
                  
        }
        public function view($slug = NULL)
        {
                // $data['news_item'] = $this->news_model->get_news($slug);
        }

        //memproses data penjualan yang sudah di masukan di cart
        public function insertPenjualan(){
          $this->load->model('Penjualan_model');
          $this->load->model('pembelian_model');

          $getLastmID = $this->Penjualan_model->getLastIdMaster_penjualan();
          $getNoNota  = $this->Penjualan_model->getNomorNotaPenjualan();

          $id_masterpenjualan="";
          $tgl_now=date('Y-m-d');
          $_Thn=substr($tgl_now,2,2);
          $no_nota="";

           $user_id=$_SESSION['user_id'];
           $id_pelanggan =$this->input->post("id_pelanggan");
           $id_petugas   =$_SESSION['user_id'];
          
           $ut           =$this->input->post("ut"); 
           $dc           =$this->input->post("dc");
           $sc           =$this->input->post("sc");
           $km           =$this->input->post("km");
           $dckm         =$this->input->post("dckm");
           $bayar        =$this->input->post("bayar");
           $kembalian    =$this->input->post("kembali");

           $_inpenjualantemp=$this->db->query("SELECT * FROM trx_penjualan_tmp");

          if($getLastmID){
          foreach ($getLastmID as $key) {
            $id_masterpenjualan=$key->masterpenjualan_id;
          }

          foreach ($getNoNota as $key) {
            $no_nota=$key->no_nota;
          }

          $nota_gen=intval($no_nota)+1;
          $no_notas=strval($nota_gen);

          $no_mid=substr($id_masterpenjualan,4,7);
          $no_gen=intval($no_mid)+1;

          $_mpenjualan_id=$this->Penjualan_model->generateNonota($id_masterpenjualan);
          $_def_nota=$this->pembelian_model->GenerateNoNota($id_masterpenjualan,'');
          //insert produk
         
          foreach ($_inpenjualantemp->result() as $items){

              $laba=(($items->sub_total/$items->qty)-$items->harga_beli)*$items->qty;
                  $row = array(
                        'masterpenjualan_id'     =>$_mpenjualan_id,
                        'kode_produk'            =>$items->kode_produk,
                        'harga_beli'             =>$items->harga_beli,
                        'qty'                    =>$items->qty,
                        'sub_total'              =>$items->sub_total,
                        'laba'                   =>$laba,
                        'masterpembelian_id'     =>$items->masterpembelian_id,
                        'paket'                  =>$items->paket
                         );

$tmp_idpembelian=$items->id_detailpembelian;
//cek stok dari detail pembelian
$c_stok=$this->db->query("SELECT id_detailpembelian,kode_produk,qty,stok FROM trx_pembelian_detail 
                          WHERE id_detailpembelian='$tmp_idpembelian'");

//mengecek jumlah stok pada trx_penjualan_tmp
$tmp_stok=$this->db->query("SELECT kode_produk,qty FROM trx_penjualan_tmp 
                            WHERE id_detailpembelian='$tmp_idpembelian'");
$p_tmp_stok=$tmp_stok->row()->qty;


$astok=$c_stok->row()->stok - $p_tmp_stok;
$k_pdk=$c_stok->row()->kode_produk;
//mengupdate stok  trx_pembelian yang mana di kurangi oleh stok terjual di trx penjualan 
//$update_stok_terbaru=$this->db->query("UPDATE trx_pembelian_detail SET stok='$astok' 
                                       //WHERE id_detailpembelian='$tmp_idpembelian'");

//cek jumlah stok di table produk
$p_stok=$this->db->query("SELECT kode_produk,jumlah_stok FROM produk WHERE  kode_produk='$k_pdk'");

$pr_stok=$p_stok->row()->jumlah_stok - $c_stok->row()->stok;
//mengupadate jumlah stok yang berada di produk
//$update_stok_produk=$this->db->query("UPDATE produk SET jumlah_stok='$pr_stok' WHERE kode_produk='$k_pdk'");

$getJmlStok=$this->Penjualan_model->getStokBy($items->kode_produk);

                  $stok_a=$getJmlStok->jumlah_stok;
                  $stokakhir=$stok_a - $items->qty;

                  if($stokakhir < 0){
                      $stokakhir=0;
                  }
                  
//$update_stok= $this->db->query("UPDATE produk SET jumlah_Stok='".$stokakhir."' WHERE kode_produk='".$items->kode_produk."' ");
 $trx_pnj_insert =  $this->db->insert('trx_penjualan_detail',$row);

}
////================================TRANSAKSI TANGGAL LAIN===============================
  
  $_mpembelian_id="";
   $id_mbelilain="";
   $_no_nota="";
   $no_nota_lain="";

            if($ut == 1){
                    $getLastMdLain  =$this->pembelian_model->getLastIdMasterPembelianLain();
  $getLastNotaLain=$this->pembelian_model->getLastNotaMasterPembelianLain()->masterpemblain_id;

                  if($getLastMdLain){
                              
                            foreach ($getLastMdLain as $key) {
                                $id_mbelilain=$key->masterpemblain_id;
                              }

                            // foreach ($getLastNotaLain as $key) {
                            //       $_no_nota=$key->no_nota; 
                            //   }

                  $_no_nota=$getLastNotaLain; 
                  $_mpembelian_id=$this->pembelian_model->genMPembelianLain($id_mbelilain);
                  $no_nota_lain=$this->pembelian_model->GenerateNoNota($_no_nota,'L');
              }

                  $_def_sql_tmp="SELECT tp.id_detailpenjualan AS id,p.nama_produk,tp.kode_produk,tp.harga_beli h_beli,
                     (SUM(tp.sub_total)/SUM(tp.qty)) AS harga_jual,SUM(tp.qty) qty,SUM(tp.sub_total) sub_total 
                     FROM trx_penjualan_tmp tp
                     INNER JOIN produk p ON p.kode_produk=tp.kode_produk
                     GROUP BY p.kode_produk";
                  $_qr_result=$this->db->query($_def_sql_tmp);
                  
                  foreach ($_qr_result->result() as $key) {
                     $rowLain = array(
                        'masterpemblain_id'      =>$_mpembelian_id,
                        'nama_barang'            =>$key->nama_produk,
                        'harga_satuan'           =>$key->harga_jual,
                        'qty'                    =>$key->qty,
                        'subtotal'               =>$key->sub_total
                        );
                     $trx_belilain_insert =  $this->db->insert('trx_pembelianlain_detail',$rowLain);
                  }
                //END
               // masukan kedalam pembelian lain
               $m_pembelianlain = array('masterpemblain_id' => $_mpembelian_id,
                                'no_nota'           => $no_nota_lain,
                                'nama_pegawai'      => $_SESSION['uname'],
                                'tanggal'           => $tgl_now 
                                        );
               $insert_mpembelianlain =  $this->db->insert('master_beli_lain',$m_pembelianlain);
              }
  //=====================================END======================================

  //======================================DC==============================
                    $costDelivery=array('masterpenjualan_id' =>$_mpenjualan_id,
                                       'id_petugas'          =>$id_petugas,
                                       'SC'                  =>$sc,
                                       'DC'                  =>$dc,
                                       'km'                  =>$km,
                                       'DCKM'                =>$dckm);
                  $trx_DC_insert =  $this->db->insert('cost_delivery',$costDelivery);
                  // ==================================================
          $data_mj = array('masterpenjualan_id' => $_mpenjualan_id,
                           'no_nota'=>$_def_nota,
                           'tgl_penjualan'=>$tgl_now,
                           'user_id'=>$user_id,
                           'id_pelanggan'=>$id_pelanggan,
                           'uang_toko'=>$ut,
                           'cetak'=>'B');

         $insert_mpenjualan = $this->db->insert('master_penjualan',$data_mj);
         $this->db->query("DELETE FROM trx_penjualan_tmp");
          
        echo $_mpenjualan_id.$_mpembelian_id;
         }else{
          $_mpenjualan_id="PJ".$_Thn."00001";
          $no_notas="00001";
             //insert produk
           foreach ($_inpenjualantemp->result() as $items){

              $laba=(($items->sub_total/$items->qty)-$items->harga_beli)*$items->qty;
                  $row = array(
                        'masterpenjualan_id'     =>$_mpenjualan_id,
                        'kode_produk'            =>$items->kode_produk,
                        'harga_beli'             =>$items->harga_beli,
                        'qty'                    =>$items->qty,
                        'sub_total'              =>$items->sub_total,
                        'laba'                   =>$laba,
                        'masterpembelian_id'     =>$items->masterpembelian_id
                        );

$tmp_idpembelian=$items->id_detailpembelian;

//cek stok dari detail pembelian
$c_stok=$this->db->query("SELECT id_detailpembelian,qty,stok FROM trx_pembelian_detail 
                          WHERE id_detailpembelian='$tmp_idpembelian'");
$astok=$c_stok->row()->stok - $items->qty;
                  //update per stok
$update_stok_terbaru=$this->db->query("UPDATE trx_pembelian_detail SET stok='$astok' 
                                       WHERE id_detailpembelian='$tmp_idpembelian'");

                  $getJmlStok=$this->Penjualan_model->getStokBy($items->kode_produk);
                  $stok_a=$getJmlStok->jumlah_stok;
                  $stokakhir=$stok_a - $items->qty;
                  if($stokakhir < 0){
                      $stokakhir=0;
                  }
                  //update stok pada transaksi pembelian
                  
                  $update_stok    =  $this->db->query("UPDATE produk SET jumlah_Stok='".$stokakhir."' WHERE kode_produk='".$items->kode_produk."' ");
                  $trx_pnj_insert =  $this->db->insert('trx_penjualan_detail',$row);
          }
////===================================TRANSAKSI TANGGAL LAIN===============================
  
    $_mpembelian_id="";
   $id_mbelilain="";
   $_no_nota="";
   $no_nota_lain="";

            if($ut == 1){
                    $getLastMdLain  =$this->pembelian_model->getLastIdMasterPembelianLain();
                    $getLastNotaLain=$this->pembelian_model->getLastNotaMasterPembelianLain();
            if($getLastMdLain){
                              
                            foreach ($getLastMdLain as $key) {
                                $id_mbelilain=$key->masterpemblain_id;
                              }

                            foreach ($getLastNotaLain as $key) {
                                  $_no_nota=$key->no_nota; 
                              }
          
                  $_mpembelian_id=$this->pembelian_model->genMPembelianLain($id_mbelilain);
                  $no_nota_lain=$this->pembelian_model->GenerateNoNota($_no_nota,'L');
              }

                  $_def_sql_tmp="SELECT tp.id_detailpenjualan AS id,p.nama_produk,tp.kode_produk,tp.harga_beli h_beli,
                     (SUM(tp.sub_total)/SUM(tp.qty)) AS harga_jual,SUM(tp.qty) qty,SUM(tp.sub_total) sub_total 
                     FROM trx_penjualan_tmp tp
                     INNER JOIN produk p ON p.kode_produk=tp.kode_produk
                     GROUP BY p.kode_produk";
                  $_qr_result=$this->db->query($_def_sql_tmp);
                  
                  foreach ($_qr_result->result() as $key) {
                     $rowLain = array(
                        'masterpemblain_id'      =>$_mpembelian_id,
                        'nama_barang'            =>$key->nama_produk,
                        'harga_satuan'           =>$key->harga_jual,
                        'qty'                    =>$key->qty,
                        'subtotal'               =>$key->sub_total
                        );
                     $trx_belilain_insert =  $this->db->insert('trx_pembelianlain_detail',$rowLain);
                  }
                //END
               // masukan kedalam pembelian lain
               $m_pembelianlain = array('masterpemblain_id' => $_mpembelian_id,
                                        'no_nota'           => $no_nota_lain,
                                        'nama_pegawai'      => $_SESSION['uname'],
                                        'tanggal'           => $tgl_now 
                                        );
               $insert_mpembelianlain =  $this->db->insert('master_beli_lain',$m_pembelianlain);
              }

           //===================DC==============================
                  $costDelivery=array('masterpenjualan_id' =>$_mpenjualan_id,
                                       'id_petugas'          =>$id_petugas,
                                       'SC'                  =>$sc,
                                       'DC'                  =>$dc,
                                       'km'                  =>$km,
                                       'DCKM'                =>$dckm);
                  $trx_DC_insert =  $this->db->insert('cost_delivery',$costDelivery);
                  // ==================================================
                   $data_mj = array('masterpenjualan_id' => $_mpenjualan_id,
                    'no_nota'=>$_def_nota,
                    'tgl_penjualan'=>$tgl_now,
                    'user_id'=>$user_id,
                    'id_pelanggan'=>$id_pelanggan,
                    'uang_toko'=>$ut,
                    'cetak'=>'B');
            $insert_mpenjualan =  $this->db->insert('master_penjualan',$data_mj);
             $this->db->query("DELETE FROM trx_penjualan_tmp");
          echo $_mpenjualan_id;
         }
        }

        
public function cekStokBaru($id)
{
  $this->load->model('Penjualan_model');
    $produk=$this->Penjualan_model->getProdukById($id);    
    $produk_stok;  
   
   if($produk) {
      foreach ($produk as $key) {
          $produk_stok=$produk->kode_produk;
      } 
        $stok_diambil=$this->cekCart($produk_stok);
        $sisa=$produk->jumlah_stok-$stok_diambil;

        $cekStokTerbaru=$this->Penjualan_model->getAutoStokProduk($id);
      if($sisa <= 0  ) {
      if($cekStokTerbaru){
            $hbeli_baru=$cekStokTerbaru->harga_beli;
            $jml_stok_terbaru= $cekStokTerbaru->qty; 
            $this->db->query("UPDATE produk SET harga_beli='$hbeli_baru',jumlah_stok='$jml_stok_terbaru' 
                              WHERE kode_produk ='$id'");
            // update trx_pembelian_detail menjadi Y
            $this->db->query("UPDATE trx_pembelian_detail SET `update`='Y' 
                              WHERE kode_produk='$id'
                              AND `status_update`='N'");
       }else{
          echo "Habis"."</br>";
       }
          echo "Habis"."</br>";
         
         }else{
            echo $produk->jumlah_stok;
         }

      echo 'kode_produk :'.$produk_stok.'</br>'.
           'jumlah stok :'.$produk->jumlah_stok;
    }else{
        echo "Tidak Ada";
    }
}

  public function getProduk($id){
       $this->load->model('Penjualan_model');
       $produk = $this->Penjualan_model->getProdukById($id); 

       // Versi 1.8
       $stokpembelianSemua=$this->Penjualan_model->cekJumlahStok($id);
       $stokTerbaru       =$stokpembelianSemua->row()->stok_total;
       
       $produk_stok       =$produk->kode_produk;

      if ($produk) {
        
        $stok_diambil=$this->cekCart($produk_stok);
        $sisa=$stokTerbaru-$stok_diambil;
        
        $disabled='';
        $info_stok=''; 

      if ($sisa <= 0  || $stokTerbaru == '' || $sisa == '') {
        $disabled = 'disabled';
        $info_stok = '<span class="help-block badge reset" id="reset" 
                    style="background-color: #d9534f;">
                    stok habis</span>';
      }else{
        $disabled = '';
        $info_stok = '<span class="help-block badge reset" id="reset" 
                    style="background-color: #5cb85c;">stok : '
                    .$produk->stok.'</span><span class="help-block badge reset" id="reset" 
                    style="background-color: #5cb85c;">stok total : '
                    .$sisa.'</span>';
      }
      
    echo '
    <input type="hidden" name="id_pembelian" id="id_pembelian" value="'.$produk->id_detailpembelian.'">
    <input type="hidden" name="ids_produk"   id="ids_produk"   value="'.$produk->kode_produk.'">
    <input type="hidden" name="harga_beli"   id="harga_beli"   value="'.$produk->harga_beli.'">
    <input type="hidden" name="_stok"        id="_stok"        value="'.$stokTerbaru.'">
    <input type="hidden" name="stok_item"    id="stok_item"    value="'.$produk->stok.'"> 
    <input type="hidden" name="master_beli"  id="master_beli"  value="'.$produk->masterpembelian_id.'">
    <input type="hidden" name="harga_ori"    id="harga_ori"    value="'.$produk->harga_jual.'">

      <input type="hidden" name="qty_grosir"   id="qty_grosir"    value="'.$produk->qty_grosir.'"> 
      <input type="hidden" name="jual_grosir"  id="jual_grosir"   value="'.$produk->jual_grosir.'">
      <input type="hidden" name="paket_ecer" id="paket_ecer" value="0"> 
     
      <div class="col-md-10">
            <div class="form-group">
           <label class="control-label col-md-3" 
                for="nama_barang">Harga :</label>
              <div class="col-md-8">
                <input type="text" class="form-control reset" id="harga_barang" name="harga_barang" 
                  value="'.number_format( $produk->harga_jual, 0 ,'' , '.' ).'" readonly="readonly">
              </div>
          </div>
          </div>
            <div class="col-md-10">
            <div class="form-group">
           <label class="control-label col-md-3" for="nama_barang">Quantity :</label>
              <div class="col-md-5">
                 <input type="number" class="form-control reset" 
                  name="qty" placeholder="Isi qty..." autocomplete="off" 
                  id="qty" onchange="subTotal(this.value)" 
                  onkeyup="subTotal(this.value)" min="0"
                  max="'.$produk->stok.'" '.$disabled.' >
              </div>'.$info_stok.'
          </div>
          </div>
            </div>';
      }else{

        echo ' <div class="col-md-10">
            <div class="form-group">
           <label class="control-label col-md-3" 
                for="nama_barang">Nama Barang :</label>
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
              <div class="col-md-4">
                <input type="number" class="form-control reset" 
                  autocomplete="off" onchange="subTotal(this.value)" 
                  onkeyup="subTotal(this.value)" id="qty" min="0" 
                  name="qty" placeholder="Isi qty...">
              </div>
          </div>
          </div>';
      }


  }


public function getProdukNew($id){
   $this->load->model('Penjualan_model');
       $produk = $this->Penjualan_model->showProduk($id); 
       // Versi 1.9
       // mengecek jumlah semua stok
       $stokpembelianSemua = $this->Penjualan_model->cekStokByProduk($id);
       $stokTerbaru        = $stokpembelianSemua->sisa;

      if ($produk) {
        $stok_diambil=$this->cekCart($id);
        $sisa=$stokTerbaru-$stok_diambil;
        
        $disabled='';
        $info_stok=''; 

      if ($sisa <= 0  || $stokTerbaru == '' || $sisa == '') {
        $disabled = 'disabled';
        $info_stok = '<span class="help-block badge reset" id="reset" 
                    style="background-color: #d9534f;">
                    stok habis</span>';
      }else{
        $disabled = '';
        $info_stok = '<span class="help-block badge reset" id="reset" 
                    style="background-color: #5cb85c;">stok : '
                    .$stokTerbaru.'</span><span class="help-block badge reset" id="reset" 
                    style="background-color: #5cb85c;">stok total : '
                    .$sisa.'</span>';
      }
      
    echo '
  
    <input type="hidden" name="ids_produk"   id="ids_produk"   value="'.$produk->kode_produk.'">
    
    <input type="hidden" name="_stok"        id="_stok"        value="'.$stokTerbaru.'">
    <input type="hidden" name="stok_item"    id="stok_item"    value="'.$stokTerbaru.'"> 

    <input type="hidden" name="harga_ori"    id="harga_ori"    value="'.$produk->harga_jual.'">

      <input type="hidden" name="qty_grosir"   id="qty_grosir"    value="'.$produk->qty_grosir.'"> 
      <input type="hidden" name="jual_grosir"  id="jual_grosir"   value="'.$produk->jual_grosir.'">
       
      <input type="hidden" name="qty_grosir1"   id="qty_grosir1"    value="'.$produk->qty_banyak.'"> 
      <input type="hidden" name="jual_grosir1"  id="jual_grosir1"   value="'.$produk->hgrosir_banyak.'">
       

      <input type="hidden" name="paket_ecer" id="paket_ecer" value="0"> 
     
      <div class="col-md-10">
            <div class="form-group">
           <label class="control-label col-md-3" 
                for="nama_barang">Harga :</label>
              <div class="col-md-8">
                <input type="text" class="form-control reset" id="harga_barang" name="harga_barang" 
                  value="'.number_format( $produk->harga_jual, 0 ,'' , '.' ).'" readonly="readonly">
              </div>
          </div>
          </div>
            <div class="col-md-10">
            <div class="form-group">
           <label class="control-label col-md-3" for="nama_barang">Quantity :</label>
              <div class="col-md-5">
                 <input type="number" class="form-control reset" 
                  name="qty" placeholder="Isi qty..." autocomplete="off" 
                  id="qty" onchange="subTotal(this.value)" 
                  onkeyup="subTotal(this.value)" min="0"
                  max="'.$stokTerbaru.'" '.$disabled.' >
              </div>'.$info_stok.'
          </div>
          </div>
            </div>';
      }else{

        echo ' <div class="col-md-10">
            <div class="form-group">
           <label class="control-label col-md-3" 
                for="nama_barang">Nama Barang :</label>
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
              <div class="col-md-4">
                <input type="number" class="form-control reset" 
                  autocomplete="off" onchange="subTotal(this.value)" 
                  onkeyup="subTotal(this.value)" id="qty" min="0" 
                  name="qty" placeholder="Isi qty...">
              </div>
          </div>
          </div>';
      }
}

 public function getProdukGrosir($id){
       $this->load->model('Penjualan_model');
       $produk=$this->Penjualan_model->getProdukById($id); 

       $stokpembelianSemua=$this->Penjualan_model->cekJumlahStok($id);
       $stokTerbaru=$stokpembelianSemua->row()->stok_total;
       $produk_stok;
       $produk_stok=$produk->kode_produk;

      if ($produk) {
        
        $stok_diambil=$this->cekCart($produk_stok);
        $sisa=$stokTerbaru-$stok_diambil;
        
        $disabled='';
        $info_stok=''; 

      if ($sisa <= 0  || $stokTerbaru == '' || $sisa == '') {
        $disabled = 'disabled';
        $info_stok = '<span class="help-block badge reset" id="reset" 
                    style="background-color: #d9534f;">
                    stok habis</span>';
      }else{
        $disabled = '';
        $info_stok = '<span class="help-block badge reset" id="reset" 
                    style="background-color: #5cb85c;">stok : '
                    .$produk->stok.'</span><span class="help-block badge reset" id="reset" 
                    style="background-color: #5cb85c;">stok total : '
                    .$sisa.'</span>';
      }
      
      echo '
      <input type="hidden" name="g_id_pembelian" id="g_id_pembelian" value="'.$produk->id_detailpembelian.'">
      <input type="hidden" name="g_ids_produk"   id="g_ids_produk"   value="'.$produk->kode_produk.'">
      <input type="hidden" name="g_harga_beli"   id="g_harga_beli"   value="'.$produk->harga_beli.'">
      <input type="hidden" name="g_stok"         id="g_stok"         value="'.$stokTerbaru.'">
      <input type="hidden" name="g_stok_item"    id="g_stok_item"    value="'.$produk->stok.'"> 
      <input type="hidden" name="g_master_beli"  id="g_master_beli"  value="'.$produk->masterpembelian_id.'"> 
      <input type="hidden" name="paket" id="paket" value="1">
      <div class="col-md-10">
            <div class="form-group">
           <label class="control-label col-md-3" 
                for="nama_barang">Harga :</label>
              <div class="col-md-8">
                <input type="text" class="form-control reset" id="g_harga_barang" name="g_harga_barang" 
                  value="'.number_format( $produk->jual_grosir, 0 ,'' , '.' ).'" readonly="readonly">
              </div>
          </div>
          </div>

            <div class="col-md-10">
            <div class="form-group">
           <label class="control-label col-md-3">Quantity :</label>
              <div class="col-md-5">
                 <input type="number" class="form-control reset" 
                  name="g_qty" placeholder="Isi qty..." autocomplete="off" 
                    id="g_qty" onchange="GrosirSubtotal(this.value)" 
                  onkeyup="GrosirSubtotal(this.value)" min="0"  
                  max="'.$produk->stok.'" '.$disabled.' >
              </div>'.$info_stok.'
          </div>
          </div>
            </div>';
      }else{

        echo ' <div class="col-md-10">
            <div class="form-group">
           <label class="control-label col-md-3" 
                for="nama_barang">Nama Barang :</label>
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
              <div class="col-md-4">
                <input type="number" class="form-control reset" 
                  autocomplete="off" onchange="subTotal(this.value)" 
                  onkeyup="subTotal(this.value)" id="qty" min="0" 
                  name="qty" placeholder="Isi qty...">
              </div>
          </div>
          </div>';
      }


        }
public function getDeliveryCharge($id)
{
  $pelanggan = $this->Penjualan_model->getDeliveryPelanggan($id);
  $ongkir    = $this->Penjualan_model->getOngkir2();
  $total_penjualan=$this->Penjualan_model->total_jual()->total;

if ($pelanggan) {

    $biaya_krm = $ongkir->biaya_dckm;
    $jarak     = $pelanggan->jarak;
    $dckm_     = $biaya_krm*$jarak; 

    //untuk pelanggan yang sudah terdaftar
    echo '
    <input type="hidden" id="ids_pelanggan" name="ids_pelanggan" value="'.$id.'"> 
    <div class="col-md-12 padding-0">
                              <div class="panel box-v1">
                                 <div class="panel-body">
                                    <div class="col-md-12 padding-0">
                                  <h4>Delivery Charge</h4>
                            <div class="col-md-15">
                                <div class="form-group">
                               <label class="control-label col-md-7" for="Service Charge">Service Charge '.$ongkir->biaya_sc.'%</label>
                                  <div class="col-md-5">
                                   <input type="text" class="form-control input-small reset" 
                                    name="sc" id="sc" placeholder="0" id="sc" value="'.$total_penjualan*($ongkir->biaya_sc/100).'"
                                    readonly="readonly">
                                  </div>
                              </div>
                              </div>
                               <div class="col-md-15">
                                <div class="form-group">
                               <label class="control-label col-md-7" for="Delivery Charge">Delivery Charge</label>
                                  <div class="col-md-5">
                                   <input type="text" class="form-control input-small reset" 
                                    name="dc" id="dc" value="'.$ongkir->biaya_dc.'" 
                                    readonly="readonly"  >
                                  </div>
                              </div>
                              </div>

                              <div class="col-md-15">
                               <div class="col-md-3">
                                <input type="text" class="form-control input-small reset" 
                                    name="jarak" id="jarak" placeholder="0" value="'.$pelanggan->jarak.'" disabled>
                               </div>
                                <div class="form-group">
                               
                               <label class="control-label col-md-4" for="nama_barang">KM Jarak x '.$ongkir->biaya_dckm.'</label>
                                  <div class="col-md-5">
                                   <input type="text" class="form-control input-small reset" 
                                    name="dckm" id="dckm" placeholder="0"
                                    readonly="readonly" value="'.$dckm_.'" >
                                  </div>
                              </div>
                              </div>
                                </div>
                                </div>
                                
                              </div>
                            </div>';
  }else{
    //untuk pelanggan yang belum terdaftar
          echo '

          <div class="col-md-12 padding-0">
                              <div class="panel box-v1">
                                 <div class="panel-body">
                                    <div class="col-md-12 padding-0">
                                  <h4>Delivery Charge</h4>
                            <div class="col-md-15">
                                <div class="form-group">
                               <label class="control-label col-md-7" for="nama_barang">Service Charge '.$ongkir->biaya_sc.'%</label>
                                 <input type="hidden" id="ongkir_1" name="ongkir_1" value="'.$ongkir->biaya_sc.'">
                                  <div class="col-md-5">
                                   <input type="text" class="form-control input-small reset" 
                                    name="n_sc" id="sc" placeholder="0"  value="'.$total_penjualan*($ongkir->biaya_sc/100).'" 
                                    readonly="readonly"  >
                                  </div>
                              </div>
                              </div>
                               <div class="col-md-15">
                                <div class="form-group">
                               <label class="control-label col-md-7" for="nama_barang">Delivery Charge</label>
                                  <div class="col-md-5">
                                   <input type="text" class="form-control input-small reset" 
                                    name="n_dc" id="dc" value="'.$ongkir->biaya_dc.'" 
                                    readonly="readonly"  >
                                  </div>
                              </div>
                              </div>
                              </div>
                                </div>
                                </div>
                                
                              </div>
                            </div>';
  }

}




public function ajax_list_transaksi_db()
  {

    $data = array();
    $no = 1; 
    $sql="SELECT tp.id_detailpenjualan as id,p.nama_produk,tp.kode_produk,tp.harga_beli h_beli,
         (SUM(tp.sub_total)/SUM(tp.qty)) AS harga_jual,SUM(tp.qty) qty,SUM(tp.sub_total) sub_total 
         FROM trx_penjualan_tmp tp
         INNER JOIN produk p ON p.kode_produk=tp.kode_produk
         GROUP BY p.kode_produk";

  $res=$this->db->query($sql);
  foreach ($res->result() as $items){
          
      $row = array();
      $row[] = $no;
      // $row[] = $items["id"];
      $row[] = $items->nama_produk;
      $row[] = 'Rp. ' . number_format( $items->harga_jual, 0 , '' , '.' ) . ',-';
      $row[] = $items->qty;
      $row[] = 'Rp. ' . number_format( $items->sub_total, 0 , '' , '.' ) . ',-';

      //add html for action
      $row[] = '<a 
        href="javascript:void()" style="color:rgb(255,128,128);
        text-decoration:none" onclick="deletebarang('."'".$items->kode_produk."'".','."'".$items->sub_total.
          "'".')"> <i class="fa fa-close"></i> Delete</a>';
    
      $data[] = $row;
      $no++;
        }

    $output = array("data" => $data,
      );
    //output to json format
    echo json_encode($output);
  }


public function addbarang()
  {
    $this->load->model('Penjualan_model');

    $id_produk = $this->input->post('ids_produk');
    $_stok     = $this->input->post('_stok'); //stok db
    $qty       = $this->input->post('qty');
    
    //unused
    $id_pemb   = $this->input->post('id_pembelian');
    $m_beli    = $this->input->post('master_beli');

    $paket     = $this->input->post('paket_ecer');

    $cek       = $this->cekCart($id_produk);

    //harga jual item
    $hg_jual   = str_replace('.', '', $this->input->post('harga_barang'));
    $subTotal  = intval($hg_jual)*intval($qty);
   
    //insert
    $this->cekKolom($id_produk,$qty,$hg_jual);
    
    $total_stok = $qty+$cek;

    //perbandingan dengan data yang dipost qty+stokdiambil > stokawal
    if($cek != 0 && $total_stok > $_stok ){
      echo json_encode("1");
    }else{
      echo json_encode("0");
    }
  }

//GROSIR
public function addbarangGrosir()
  {
     $this->load->model('Penjualan_model');
    $id_produk = $this->input->post('g_ids_produk');
    $_stok     = $this->input->post('g_stok');//stok db
    $qty       = $this->input->post('g_qty');
    $id_pemb   = $this->input->post('g_id_pembelian');
    $m_beli    = $this->input->post('g_master_beli');

    $paket    = $this->input->post('paket');
    
    $cek  = $this->cekCart($id_produk);

    $hg_jual=str_replace('.', '', $this->input->post('g_harga_barang'));
    $subTotal=intval($hg_jual)*intval($qty);

    $db_insert=array(
                  'id_detailpembelian'=>$id_pemb,
                  'kode_produk' => $id_produk,
                  'harga_beli'  => $this->input->post('g_harga_beli'),
                  'qty'         => $qty,
                  'sub_total'    => $subTotal,
                  'masterpembelian_id'=>$m_beli,
                  'paket'       =>$paket
                 );
    $this->db->insert('trx_penjualan_tmp',$db_insert);

    $total_stok = $qty+$cek;

    //perbandingan dengan data yang dipost qty+stokdiambil > stokawal
    if($cek != 0 && $total_stok > $_stok ){
       // echo json_encode("data full:".$total_stok." stok diambil :".$cek);
      echo json_encode("1");
    }else{
     // $insert = $this->cart->insert($data);
      echo json_encode("0");
      // echo json_encode("data masuk :".$cek." total stok :".$total_stok);
    }
  }
  /**
   * [deletebarang temp penjualan dan update pembelian berdasarkan ]
   * @param  [type] $id [description]
   * @return [type]     [description]
   */
  public function deletebarang($kode_produk) 
  {
    /*
    * Cek PerRow
    */
    $cekRow=$this->db->where('kode_produk',$kode_produk)->get('trx_penjualan_tmp')->result(); 
    foreach ($cekRow as $key) {
        $this->updatePembelian($key->id_detailpembelian,$key->qty);
     }
    
    $this->db->where('kode_produk', $kode_produk);
    $this->db->delete('trx_penjualan_tmp');
    
    echo json_encode(array("status" => TRUE));
  }

  /**
   * [updatePembelian update pembelian setelah produk dihapus dari temp_penjualan]
   * @param  [type] $id_pembelian [description]
   * @return [type]               [description]
   */
  public function updatePembelian($id_pembelian,$stok_ambil){
    //cek dulu nilai stok sebelumnya
    $res_cstok=$this->db->where('id_detailpembelian',$id_pembelian)->get('trx_pembelian_detail');
    $_stok_sisa=$res_cstok->row()->stok;
    $stok_sisa = intval($_stok_sisa)+intval($stok_ambil);
    // echo "stok update :".$stok_sisa."</br>";
    // update stok
    $this->db->set('stok',$stok_sisa);
    $this->db->where('id_detailpembelian',$id_pembelian);
    $this->db->update('trx_pembelian_detail');

  }

 private function cekCart($post){
    $data = array();
    $benar=0;
    foreach ($this->cart->contents() as $cekItem) {
              $row=array('ids_produk'=>$cekItem['id'],'stok'=>$cekItem['qty']);
              $data[] = $row;
      }
      for ($i=0; $i < count($data); $i++) 
              {
                  if(($data[$i]['ids_produk'] == $post) == TRUE ){
                     // echo $data[$i]['stok']."</br>";
                     $benar=$data[$i]['stok'];
                  }
              }
      // echo $benar;
      return $benar;
  }


  private function cekStokItem($id_pembelian){
      $data = array();
      $benar=0;
      $cekStok=$this->db->query("SELECT id_detailpembelian,qty FROM trx_penjualan_tmp");
      foreach ($cekStok->row() as $key) {
          
      }
  }



public function Cetak($id){
      $this->load->model('Penjualan_model');
      $getLastmID=$this->Penjualan_model->cetaknota($id);
      
      if($getLastmID->row()){
          $getTotal=$this->db->query("SELECT sum(sub_total) as total from trx_penjualan_detail WHERE masterpenjualan_id='$id' ");
          $getNoNota=$this->db->query("SELECT mp.id_pelanggan,pelanggan.nama_pelanggan,pelanggan.alamat_pelanggan,
                                      pelanggan.no_tlpn,pelanggan.jarak,mp.no_nota FROM master_penjualan as mp LEFT OUTER  JOIN pelanggan on pelanggan.id_pelanggan=mp.id_pelanggan WHERE masterpenjualan_id='$id' ");
          //petugas delivery
          // $getSC=$this->db->query("SELECT petugas_delivery.nama_petugas,cd.SC,cd.DC,cd.km,cd.DCKM FROM cost_delivery cd INNER JOIN petugas_delivery on petugas_delivery.id_petugas=cd.id_petugas WHERE masterpenjualan_id='$id' ");
          $getSC=$this->db->query("SELECT IF((SELECT nama_petugas FROM petugas_delivery where id_petugas=cd.id_petugas) IS NULL,'-',(SELECT nama_petugas FROM petugas_delivery where id_petugas=cd.id_petugas)) as Nama,cd.SC,cd.DC
                  ,cd.km,cd.DCKM 
                  FROM cost_delivery cd 
                  INNER JOIN master_penjualan as mp on mp.masterpenjualan_id=cd.masterpenjualan_id
                  WHERE 
                  cd.masterpenjualan_id='$id' ");

          $tgl_now=date('Y-m-d');
          $nota=$getNoNota->row()->no_nota;
          $NamaPetugaskasir=$_SESSION['uname'];//session
          $NamaPelanggan=$getNoNota->row()->nama_pelanggan;
          $AlamatPelanggan=$getNoNota->row()->alamat_pelanggan;
          $NoPlnggan=$getNoNota->row()->no_tlpn;
          $total=$getTotal->row()->total;

          $SC=$getSC->row();
         
          $data['res']=$getLastmID;
          $data['tgl']=$tgl_now;
          $data['total']=$total;
          $data['no_nota']=$nota;
          $data['nama_pelanggan']=$NamaPelanggan;
          $data['alamat_pelanggan']=$AlamatPelanggan;
          $data['tlpn']=$NoPlnggan;
          $data['nama_kasir']=$NamaPetugaskasir;
              


          if($SC->Nama !== '-'){
              $NamaPetugasDelivery=$SC->Nama;
              $SerC=$SC->SC;
              $DC  =$SC->DC;
              $Km  =$SC->km;
              $DCKM=$SC->DCKM;
              $total_all=$SerC+$DC+$DCKM+$total;
              $data['sc']=$SerC;
              $data['dc']=$DC;
              $data['km']=$Km;
              $data['dckm']=$DCKM;
              $data['total_all']=$total_all;
              $data['nama_petugas']=$NamaPetugasDelivery;
              $this->load->view('penjualan/cetak',$data);
          }else{
              $NamaPetugasDelivery='';
              $SerC=$SC->SC;
              $DC  =$SC->DC;
              $Km  =$SC->km;
              $DCKM=$SC->DCKM;
              $total_all=$SerC+$DC+$DCKM+$total;
              $data['sc']=$SerC;
              $data['dc']=$DC;
              $data['km']=$Km;
              $data['dckm']=$DCKM;
              $data['total_all']=$total_all;
              $data['nama_petugas']=$NamaPetugasDelivery;
              $this->load->view('penjualan/cetak',$data);
          }
        }else{
           echo 'Maaf Permintaan Tidak dapat Di proses <a href="'.base_url().'index.php/penjualan">Kembali</a>';
        }

}

function reloadTable(){
  $cekRow=$this->db->count_all_results('trx_penjualan_tmp');
  echo '<input type="hidden" id="total_temps" value="'.$cekRow.'">' ;
}

 public function cekHapusJual(){
     $this->load->view('dashboard/header');
      $this->load->view('dashboard/left_menu.php');
      $this->load->view('penjualan/hapus_nj');
      $this->load->view('dashboard/_js');
  } 
   public function cekData($id){
      $this->load->model("Penjualan_model");
      $db=$this->db->query("SELECT * FROM `v_trx_penjualan`  WHERE masterpenjualan_id='$id'");
       $res=array();
       echo ' <div class="panel-body">
        <table id="table_transaksi" class="table table-striped table-bordered">
        <thead>
          <tr>
              <th>No</th>
              <th>Nama Barang</th>
              <th>Harga Jual</th>
              <th>Quantity</th>
              <th>Sub-Total</th>
          </tr>
        </thead>';
        $no=1;
      foreach ($db->result() as $key) {    
      $harga_jual=$key->sub_total/$key->qty;
        echo '
        <tbody>
          <td>'.$no.'</td>
          <td>'. $key->nama_produk .'</td>
         <td> '. $harga_jual. '</td>
         <td> '. $key->qty . '</td>
         <td> '. $key->sub_total .'</td>
        </tbody>';
      $no++;

      //mengupdate stok
      $getPmb=$this->Penjualan_model->getDetailStok($key->masterpembelian_id,$key->kode_produk);
      
      $stok_=$getPmb->row()->stok;
      $idbeli=$getPmb->row()->id_detailpembelian;
      
      //tambahkan dengan stok yang terjual
      $qty_=$key->qty;
      $total_qty=$stok_+$qty_;
     
      // $updateJual="UPDATE trx_pembelian_detail SET stok='$total_qty' WHERE id_detailpembelian='$idbeli'";
      // $r=$this->db->query($updateJual);
      // if($r == true){
      //   echo "Berhasil ";
      // }
      }
      echo '</table>
      <input type="hidden" id="masterbeli" value="'.$id.'">
      <div class="col-md-offset-8" style="margin-top:20px">
        <button type="button" class="btn btn-primary btn-lg" id="hapus" 
        onclick="deletebarang()">
        Hapus Nota <i class="fa fa-angle-double-right"></i></button>
      </div>
      </div>';
      //$output = array("data" => $res,);
      // echo json_encode($res);
   }

   /**
    * [deletenotajual description]
    * @param  [type] $id [description]
    * @return [type]     [description]
    */
   public function deletenotajual($id){
    $this->load->model("Penjualan_model");
    $db=$this->db->query("SELECT * FROM `v_trx_penjualan`  WHERE masterpenjualan_id='$id'");
     foreach ($db->result() as $key) {    
      $harga_jual=$key->sub_total/$key->qty;
      //mengupdate stok
      $getPmb=$this->Penjualan_model->getDetailStok($key->masterpembelian_id,$key->kode_produk);
      
      $stok_=$getPmb->row()->stok;
      $idbeli=$getPmb->row()->id_detailpembelian;
      
      //tambahkan dengan stok yang terjual
      $qty_=$key->qty;
      $total_qty=$stok_+$qty_;
     
    $updateJual="UPDATE trx_pembelian_detail SET stok='$total_qty'
                 WHERE id_detailpembelian='$idbeli'";

      $r=$this->db->query($updateJual);
      if($r == true){
      }else{
        echo "Gagal";
      }
      }

    $a=$this->db->where('masterpenjualan_id',$id);
    $b=$this->db->delete('master_penjualan');

    $c=$this->db->where('masterpenjualan_id', $id);
    $d=$this->db->delete('trx_penjualan_detail');
    
    $c= $this->db->where('masterpenjualan_id', $id);
    $d= $this->db->delete('cost_delivery');
    
    echo json_encode(array("status" => TRUE));
   }


/**
 * [cekKolom untuk eksekusi berurutan insert ]
 * @param  [type] $kode_produk [description]
 * @param  [type] $jumlah_beli [description]
 * @param  [type] $hjual       [description]
 * @return [type]              [description]
 */
   public function cekKolom($kode_produk,$jumlah_beli,$hjual){
    $this->load->model('pembelian_model');
      $sql_cek="SELECT id_detailpembelian,masterpembelian_id,kode_produk,stok,harga_beli 
                FROM trx_pembelian_detail WHERE kode_produk = ? AND stok !=0 ";
      $query_cek= $this->db->query($sql_cek,array($kode_produk));
      $ceking=$query_cek->num_rows();  

      if($ceking != 0){
          //cek jumlah stok yang tersedia di row yang pertama
          $result = $query_cek->row();

          $id_detailpemb =$result->id_detailpembelian;
          $st_tersedia   =$result->stok;
          $id_mpembelian =$result->masterpembelian_id;
          $hg_beli       =$result->harga_beli;
          $laba          =doubleval($hjual)-doubleval($hg_beli);
            //a=8,b=10
            //x=a-b
            //y=b-x
          if($st_tersedia){
           //mengembalikan nilai stok yang tersedia apakah minus atau sisa
           //kemudian update dulu berdasarkan id_detail pembelian
           //dan apabila return minus maka lakukan pengecekan lagi di row selanjutnya 
            $sisa = intval($st_tersedia) - intval($jumlah_beli);
            
            $x=0;
            $stotal=0;
            $temp_stok=0;
            $stokIntemp=0;
            $Totallaba=0;

              if($sisa < 0){
                 $temp_stok = 0;
                /**
                 * Old Version
                 * $x = intval($jumlah_beli) - ($this->hasilminus($sisa));
                 */
                 $x      = $this->hasilminus($sisa);
                 // $stotal = intval($hjual)*$x;
                 $stotal=intval($hjual)*$st_tersedia;
                 $stokIntemp =$st_tersedia;
                 $Totallaba=$laba*$st_tersedia;
                 // echo "Total Laba".$Totallaba;
                 /*
                echo "id : ".$id_detailpemb."</br>";
                echo "Stok Awal : ".$st_tersedia."</br>";
                echo "Stok Kurang : ".$this->hasilminus($sisa)."</br>";
                echo "Sub Total Rp.".$stotal."</br>";
                echo "Stok Qty Masuk Temp : ".$stokIntemp."</br>";
                echo "Stok Sisa : ".$temp_stok."</br>"."</br>";
                */
                  
               }else{ //jika stok = 0
                 $temp_stok=$sisa;
                 $x=$sisa;
                 $stotal=intval($hjual)*($st_tersedia-$x);
                 $stokIntemp = $st_tersedia-$x; 
                 $Totallaba=$laba*$stokIntemp;
                 // echo "Total Laba".$Totallaba;
                /*
                echo "id : ".$id_detailpemb."</br>";
                echo "Stok Awal : ".$st_tersedia."</br>";
                // echo "Stok Kurang : ".$this->hasilminus($sisa)."</br>";
                echo "Sub Total : Rp.".$stotal."</br>";
                echo "Stok Qty Masuk Temp : ".$stokIntemp."</br>";
                echo "Stok Sisa : ".$temp_stok."</br>"."</br>";
                */
               }


        //stok yang masuk ke temp
        //update pembelian =>mengurangi stok yang ada
        $update_s=$this->pembelian_model->uStokdetail($id_detailpemb,$temp_stok);
        // insert ke table tmp
        $this->add_toTmp($id_detailpemb,$kode_produk,$hg_beli,$stokIntemp,$stotal,$Totallaba,$id_mpembelian);
           //cek jika update berhasil lakukan cek lagi apabila sisa masih minus
            if($sisa < 0 ){
                $min_stok = $this->hasilminus($sisa);
                $this->cekKolom($kode_produk,$x,$hjual);
            }else{
               // echo "Update Selesai";
            }
            
          }else{
            //echo "wrong";
          }

      }else{
        //echo 0;
      }  
   }

   /*
      
    */
   private function hasilminus($jml){
        $s=0;
        $r=$s-$jml;
        return $r;
   }

   /*
       Menambahkan hasil ke tabel temp penjualan
    */
   private function add_toTmp($id_detailpembelian,$id_produk,$hbeli,$qty,$subTotal,$laba,$idmasterpembelian){
      $db_insert = array(
                  'id_detailpembelian'=> $id_detailpembelian,
                  'kode_produk'       => $id_produk,
                  'harga_beli'        => $hbeli,
                  'qty'               => $qty,
                  'sub_total'         => $subTotal,
                  'laba'              => $laba,
                  'masterpembelian_id'=> $idmasterpembelian
                 );
      $this->db->insert('trx_penjualan_tmp',$db_insert);
   }
   
   



}