<?php
  class Pembelian extends CI_Controller {
    public
    function __construct()        {
      parent::__construct();

      $this->load->helper('date');
      $this->load->library('pagination');
      // $this->load->helper('url_helper');
      if(empty($_SESSION['uname']) ){
                    redirect('/login/');
         }
    }

    public
    function index(){
       $this->cart->destroy();
      $this->view();
    }

    public
    function view($offset=0) {
      $this->load->model('pembelian_model');
      $jml = $this->db->get('produk');
      $config['base_url'] = base_url().'index.php/pembelian/view';
      $config['total_rows'] = $jml->num_rows();
      $config['per_page'] = 4;
      /*Jumlah data yang dipanggil perhalaman*/
      $config['uri_segment'] = 3;
      /*data selanjutnya di parse diurisegmen 3*/
      /*Class bootstrap pagination yang digunakan*/
      $config['full_tag_open'] = "<ul class='pagination pagination-sm' style='position:relative; top:-25px;'>";
      $config['full_tag_close'] ="</ul>";
      $config['num_tag_open'] = '<li>';
      $config['num_tag_close'] = '</li>';
      $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
      $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
      $config['next_tag_open'] = "<li>";
      $config['next_tagl_close'] = "</li>";
      $config['prev_tag_open'] = "<li>";
      $config['prev_tagl_close'] = "</li>";
      $config['first_tag_open'] = "<li>";
      $config['first_tagl_close'] = "</li>";
      $config['last_tag_open'] = "<li>";
      $config['last_tagl_close'] = "</li>";
      $this->pagination->initialize($config);
      $data['halaman'] = $this->pagination->create_links();
      /*membuat variable halaman untuk dipanggil di view nantinya*/
      $data['offset'] = $offset;
      $data['produk']    = $this->pembelian_model->getProduk();
      $data['allbarang'] = $this->pembelian_model->getAllProduk($config['per_page'], $offset);
      $this->load->view('dashboard/header');
      $this->load->view('dashboard/left_menu.php');
      $this->load->view('pembelian/index', $data);
      $this->load->view('dashboard/_js');
      /*memanggil view pagination*/
    }

    public function pembelianlain(){
      $this->cart->destroy();
      $this->load->view('dashboard/header');
      $this->load->view('dashboard/left_menu.php');
      $this->load->view('pembelian/pembelian_lain');
      $this->load->view('dashboard/_js');
    }

    public
    function daftarpembelian(){
      $res['data']=$this->db->query("SELECT kode_produk,nama_produk,harga_jual,jual_grosir,qty_grosir,jumlah_stok FROM produk");
      $this->load->model('Penjualan_model');
      $this->load->view('dashboard/header');
      $this->load->view('dashboard/left_menu.php');
      $this->load->view('pembelian/daftar_pembelian',$res);
      $this->load->view('dashboard/_js');
    }

   
    public function pembelianbaru(){
      $this->cart->destroy();
      $this->load->view('dashboard/header');
      $this->load->view('dashboard/left_menu.php');
      $this->load->view('pembelian/register_barang');
      $this->load->view('dashboard/_js');
    }

    public
    function ajax_list_produk()  {
      $this->load->model('pembelian_model');
      $data = array();
      $no = 1;
      $datapembelian = $this->pembelian_model->getAllProduk();
      foreach ($datapembelian->result() as $items){
        $row = array();
        $row[] = $no;
        $row[] = $items->kode_produk;
        $row[] = $items->nama_produk;
        $row[] = 'Rp. ' . number_format( $items->harga_beli, 0 , '' , '.' ) . ',-';
        $row[] = $items["qty"];
        $row[] = 'Rp. ' . number_format( $items->harga_jual, 0 , '' , '.' ) . ',-';
        $row[] = $items->jumlah_stok;
        //add html for action
        $row[] = '<a href="javascript:void()" style="color:rgb(255,128,128);
        text-decoration:none" onclick="deletebarang('.$items->kode_produk.')"> <i class="fa fa-close"></i> Delete</a>';
        $data[] = $row;
        $no++;
      }

      $output = array("data" => $data,);
      //output to json format
      echo json_encode($output);
    }

    public
    function getProduk($id){
      $this->load->model('Penjualan_model');
      
      $produk=$this->Penjualan_model->getProdukPembelianById($id);
      
       $stokpembelianSemua=$this->Penjualan_model->cekJumlahStokPembelian($id);
       $stokTerbaru=$stokpembelianSemua->row()->stok;
      if ($produk) {
        
        if ($stokTerbaru == '0' || $stokTerbaru == ''  ) {
          $disabled = 'disabled';
          $info_stok = '<span class="help-block badge" id="reset" 
                        style="background-color: #d9534f;">
                        stok kosong</span>';
        } else {
          $disabled = '';
          $info_stok = '<span class="help-block badge" id="reset" 
                    style="background-color: #5cb85c;">stok tersedia : '.$stokTerbaru.'</span>';
        }

        if($_SESSION['acces'] == 1){
          $readonly='readonly';
        }else{
          $readonly='';
        }
        
        echo '
      <form  id="form_transaksi" role="form">
      <input type="hidden" id="ids_barang" name="ids_barang" value="'.$id.'">
      <input type="hidden" id="stok_awal"  name="stok_awal"  value="'.$stokTerbaru.'">
       <input type="hidden" name="Unama_barang" id="Unama_barang" value="'.$produk->nama_produk.'">
  
      <div class="col-md-12">
            <div class="form-group">
           <label class="control-label col-md-2-v1" 
                for="nama_barang">Harga Beli:</label>
              <div class="col-md-2">
                <input type="text" class="form-control reset" id="Uharga_beli" name="Uharga_beli" 
                  value="'.number_format( 0, 0 ,'' , '.' ).'" >
              </div>
              <label class="control-label col-md-2-v2" 
                for="nama_barang">Diskon 1:</label>
              <div class="col-md-2">
             <input type="text" class="form-control reset" id="diskon_1" name="diskon_1" value="0" placeholder="Rp.12000">
               
              </div><span class="help-block badge" id="reset" 
                    style="background-color: #5cb85c;">%</span>
                    <div class="col-md-2-diskon">        
          <input type="text" class="form-control reset" id="diskon" name="diskon" 
                  value="0" >
          </div>
                   </div>
          </div>

          <div class="col-md-12">
          <div class="form-group">
          <label class="control-label col-md-2-v1" 
                for="nama_barang">Tambah Stok :</label>
              <div class="col-md-2">
                 <input type="number" class="form-control reset" 
                  name="Uqty" placeholder="Isi qty..." autocomplete="off" 
                  id="Uqty" min="0"  
                  value="0" >
              </div> 

              <label class="control-label col-md-2-v2" 
                for="nama_barang">Diskon 2:</label>
              <div class="col-md-2">
             <input type="text" class="form-control reset" id="diskon_2" name="diskon_2" value="0" placeholder="Rp.12000">
              </div>
              <span class="help-block badge" id="reset" 
                    style="background-color: #5cb85c;">%</span>
                    <div class="col-md-2-diskon">        
          <input type="text" class="form-control reset" id="diskon1" name="diskon1" value="0" >
          </div>
          </div>
          </div>

            <div class="col-md-12">
            <div class="form-group">
           
           <label class="control-label col-md-2-v1" for="nama_barang">ISI DI ECER :</label>
              <div class="col-md-2">
                 <input type="number" class="form-control reset" 
                  name="isi" placeholder="Isi qty..." autocomplete="off" 
                  id="isi" min="0"  
                  value="0" >
              </div>

               <label class="control-label col-md-2-v2" for="nama_barang">Bonus Item:</label>
              <div class="col-md-2">
                <input class="form-control reset" id="bonus_item" min="0" value="0" name="bonus_item" type="number">
              </div>'.$info_stok.'
         </div>
         </div>

         <div class="col-md-12">
         <div class="form-group">
              <label class="control-label col-md-2" for="nama_barang">Harga Beli Eceran:</label>
              <div class="col-md-2">
             <input type="text" class="form-control reset" id="h_eceran" name="h_eceran" readonly>
              </div><button type="button" class="btn btn-primary" id="Update_brg" onclick="cekHargaBeli();">
                  <i class="fa fa-refresh"></i> Cek Harga Eceran</button>
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
         </div>
 </form>
          <div class="col-md-5">
             <button type="button" class="btn btn-primary" id="add_barang" onclick="updateBarang();">
                  <i class="fa fa-refresh"></i> Tambah</button>
          </div>
          </div>
            </div>';
      } else {
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


//===============================Barang baru======================================//**belum diperbarui
    public function registerBarang(){
      $this->load->model('pembelian_model');
      $tgl_now = date('Y-m-d');
       $kode_produk = $this->input->post('id');
       $nama_barang = $this->input->post('nama');
       

           $dataBarangBaru = array(
                      'kode_produk'  =>$kode_produk,
                      'nama_produk'  =>$nama_barang
                      );
            $trx_belilain_insert =  $this->db->insert('produk',$dataBarangBaru);
            echo "Berhasil";
    }


  public function addbarangbaru()
  { 
    $kode_produk = $this->input->post('kode_produk');
    $nama_barang = $this->input->post('nama_barang');
    $dataBarangBaru = array(
                      'id'    => $this->input->post('kode_produk'),
                      'name'  => $this->input->post('nama_barang'),
                      'qty'   => 101
                      );
    $insert_databarang=$this->cart->insert($dataBarangBaru);
    echo json_encode($dataBarangBaru);
  }



  public function ajax_list_transaksi_barangbaru()
  {

    $data = array();
    $no = 1; 
 
  foreach ($this->cart->contents() as $items){   
      $row = array();
      $row[] = $no;
      $row[] = $items["name"];
      //add html for action
      $row[] = '<a href="javascript:void()" style="color:rgb(255,128,128);
        text-decoration:none" onclick="deletebarang('."'".$items["rowid"]."'".')"> <i class="fa fa-close"></i> Delete</a>';
      $data[] = $row;
      $no++;
  }
    $output = array("data" => $data,);
    //output to json format
    echo json_encode($output);
  }


//==================================Beli lain-Lain ==============================
   public function prosespembelian(){
      $this->load->model('pembelian_model');
      $tgl_now        =  date('Y-m-d');
      
      $getLastMdLain  =$this->pembelian_model->getLastIdMasterPembelianLain();
      $getLastNotaLain=$this->pembelian_model->getLastNotaMasterPembelianLain();

      $id_mbelilain="";
      $_no_nota="";
      //select all data
      $_InBeliLaintemp=$this->db->query("SELECT * FROM trx_pembelianlain_tmp");
      
      $_Thn=substr($tgl_now,2,2);

       if($getLastMdLain){
          foreach ($getLastMdLain as $key) {
            $id_mbelilain=$key->masterpemblain_id;
          }
          $_no_nota=$getLastNotaLain->masterpemblain_id;
          // foreach ($getLastNotaLain as $key) {
          //     $_no_nota=$key->no_nota; 
          // }
          
          $_mpembelian_id=$this->pembelian_model->genMPembelianLain($id_mbelilain);
          $no_nota=$this->pembelian_model->GenerateNoNota($_no_nota,'L');

       foreach ($_InBeliLaintemp->result() as $items)
       {
           $row = array(
                        'masterpemblain_id'      =>$_mpembelian_id,
                        'nama_barang'            =>$items->nama_barang,
                        'harga_satuan'           =>$items->harga_satuan,
                        'qty'                    =>$items->qty,
                        'subtotal'               =>$items->subtotal,
                        'category'               =>$items->category
                        );
            $trx_belilain_insert =  $this->db->insert('trx_pembelianlain_detail',$row);
       }

       $m_pembelianlain = array('masterpemblain_id' => $_mpembelian_id,
                                'no_nota'           => $no_nota,
                                'nama_pegawai'      => $_SESSION['uname'],
                                'tanggal'           => $tgl_now
                                );

       $insert_mpembelianlain =  $this->db->insert('master_beli_lain',$m_pembelianlain);
    $this->db->query("DELETE FROM trx_pembelianlain_tmp");
       echo $_mpembelian_id;
    }else{
     $_mbelilain_id="L".$_Thn."00001";
     $no_notas="00001";

    foreach ($_InBeliLaintemp->result() as $items)
       {
           $row = array(
                        'masterpemblain_id'      =>$_mpembelian_id,
                        'nama_barang'            =>$items->nama_barang,
                        'harga_satuan'           =>$items->harga_satuan,
                        'qty'                    =>$items->qty,
                        'subtotal'               =>$items->subtotal,
                        'category'               =>$items->category
                        );
            $trx_belilain_insert =  $this->db->insert('trx_pembelianlain_detail',$row);
       }
     $m_pembelianlain =   array('masterpemblain_id' => $_mbelilain_id,
                                'no_nota'           => $no_nota,
                                'nama_pegawai'      => $_SESSION['uname'],
                                'tanggal'           => $tgl_now
                                );

      $insert_mpembelianlain =  $this->db->insert('master_beli_lain',$m_pembelianlain);
    $this->db->query("DELETE FROM trx_pembelianlain_tmp");
     echo "berhasil";
    }
       $this->db->query("DELETE FROM trx_pembelianlain_tmp");

    }

  public function addbaranglain()
  {
    $nama_barang = $this->input->post('nama_barang');
    $harga_beli  = $this->input->post('harga_beli');//stok db
    $qty         = $this->input->post('qty');
    $kategori    = $this->input->post('id_kategori');

    $hbeli=str_replace('.', '',$harga_beli);
    $subTotal=intval($hbeli)*intval($qty);
    
     $DB_dataBeli    = array(
                      'nama_barang'     => $this->input->post('nama_barang'),
                      'harga_satuan'    => str_replace('.', '',$harga_beli),
                      'qty'      => $qty,
                      'subtotal' => $subTotal,
                      'category' =>$kategori
                  );

     $this->db->insert('trx_pembelianlain_tmp',$DB_dataBeli);
    echo json_encode("Berhasil Ditambah");
  }
 public function deletebaranglain($rowid) 
  {
     $this->db->where('pembelianlaindetail_id',$rowid);
    $this->db->delete('trx_pembelianlain_tmp');
    echo json_encode(array("status" => TRUE));
  }

  
public function ajax_list_transaksi()
  {
    $data = array();
    $no = 1; 
  $sql="SELECT * FROM trx_pembelianlain_tmp";

  $res=$this->db->query($sql);
  foreach ($res->result() as $items){
          
      $row = array();
      $row[] = $no;
      // $row[] = $items["id"];
      $row[] = $items->nama_barang;
      $row[] = 'Rp. ' . number_format( $items->harga_satuan, 0 , '' , '.' ) . ',-';
      $row[] = $items->qty;
      $row[] = 'Rp. ' . number_format( $items->subtotal, 0 , '' , '.' ) . ',-';

      //add html for action
      $row[] = '<a 
        href="javascript:void()" style="color:rgb(255,128,128);
        text-decoration:none" onclick="deletebarang('."'".$items->pembelianlaindetail_id."'".','."'".$items->subtotal.
          "'".')"> <i class="fa fa-close"></i> Delete</a>';
    
      $data[] = $row;
      $no++;
        }

    $output = array("data" => $data,);
    //output to json format
    echo json_encode($output);
  }
public function cetakPembelianLain($no_nota)
  {
       $this->load->model('pembelian_model');
       $databeli['data']=$this->pembelian_model->cetakNotaLain($no_nota);
       $databeli['kode']=$no_nota;

       $databeli['totalnota']=$this->pembelian_model->cetakNotaLainTotal($no_nota);
       $this->load->view('pembelian/cetak_lain',$databeli);

  } 



  //============================AJAX TABLE UPDATE BARANG=========================================
  public function cetakPembelian($no_nota)
  {
       $this->load->model('pembelian_model');
       $databeli['data']=$this->pembelian_model->cetakNota($no_nota);

       $xx=$this->pembelian_model->getBalance($no_nota);
       $balance='';
       if (!$xx) {
          $balance=0;
       }else{
        $balance=$xx->total;
       }

       $uangtoko=$this->pembelian_model->getCekUtoko($no_nota)->ut;
       $databeli['ut']=$uangtoko;
       $databeli['balance']=$balance;
       $databeli['kode']=$no_nota;
       $databeli['totalnota']=$this->pembelian_model->cetakNotaTotal($no_nota);
       $this->load->view('pembelian/cetak',$databeli);

  } 

public function ajax_list_transaksi_updatebarang()
  {
    $data = array();
    $no = 1; 
  $sql="SELECT tp.id_detailpembelian AS id,p.nama_produk,tp.kode_produk,tp.harga_beli h_beli,SUM(tp.qty) qty,SUM(tp.sub_total) sub_total 
         FROM trx_pembelian_tmp tp
         INNER JOIN produk p ON p.kode_produk=tp.kode_produk
         GROUP BY p.kode_produk";
      $res=$this->db->query($sql);

         foreach ($res->result() as $items){
          
      $row = array();
      $row[] = $no;
      // $row[] = $items["id"];
      $row[] = $items->nama_produk;
      $row[] = 'Rp. ' . number_format( $items->h_beli, 0 , '' , '.' ) . ',-';
      // $row[] = 'Rp. ' . number_format( $items['sold'], 0 , '' , '.' ) . ',-';
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


//perubahan
public function addbarangupdate()
  { 
    $kode_produk = $this->input->post('ids_barang');
    $nama_barang = $this->input->post('Unama_barang');
    $h_beli      = $this->input->post('Uharga_beli');
    $qty         = $this->input->post('Uqty');
    $stok_awal   = $this->input->post('stok_awal');

    $bonus_item  = $this->input->post('bonus_item');
    $isi         = $this->input->post('isi');

    $diskon_perc_1 = $this->input->post("diskon");
    $diskon_perc_2 = $this->input->post("diskon1");

    $diskon1_nom   = $this->input->post("diskon_1");
    $diskon2_nom   = $this->input->post("diskon_2");

    $_isi=0;
   if (empty($isi) || $isi == 0){
        $_isi=1;
    }else{
      $_isi=$isi;
    }
    
    $harga_beli=str_replace(".", "",$h_beli);
    // $harga_jual=str_replace(".", "",$h_jual);
    $HB_S=intval($harga_beli)*intval($qty);
    $harga_pot_diskon1= (intval($HB_S)* (floatval($diskon_perc_1)/100)) + intval($diskon1_nom);
    $harga_pot_diskon2= (intval($HB_S)* (floatval($diskon_perc_2)/100)) + intval($diskon2_nom);

    $harga_beli_net3  = (intval($harga_beli) * intval($qty)) - ($harga_pot_diskon1+$harga_pot_diskon2);
    $_fixhargaeceran  = $harga_beli_net3 / (intval($qty)+intval($bonus_item));
    $baru_hargabeli   = $_fixhargaeceran / intval($_isi);

    $dataBeliBaru    = array(
                      'id'          => $kode_produk,
                      'name'        => $nama_barang,
                      'price'       => intval($baru_hargabeli),
                      'bonus'       => $bonus_item,
                      'stock'       => $stok_awal,
                      'qty'         => $qty* $_isi+$bonus_item
                   );

    $DB_dataBeliBaru = array(
                      'kode_produk'         => $kode_produk,
                      'qty'                 => $qty* $_isi+$bonus_item,
                      'bonus'               => $bonus_item,
                      'total_qty'           => $qty* $_isi+$bonus_item,
                      'stok'                => $qty* $_isi+$bonus_item,
                      'harga_beli'          => intval($baru_hargabeli),
                      'sub_total'           => intval($baru_hargabeli)*intval($qty* $_isi+$bonus_item)
                   );

    $this->db->insert('trx_pembelian_tmp',$DB_dataBeliBaru);
    $this->cart->insert($dataBeliBaru);
    echo json_encode($dataBeliBaru);
  }


   //mengupdate semua barang yang sudah di masukan kedalam cart
   public function updatebarang()
    {
      $slug= $this->input->post("id");
      $this->load->model('pembelian_model');
      $tgl_now      =  date('Y-m-d');
      $tanggal_buat =  $tgl_now;
      $petugas      =  $_SESSION['uname'];
      $ut           =  $this->input->post("ut");
      $balance      =  $this->input->post("balance");
      //apabila uang toko = 1 maka tambahkan satu baris data ke data pengeluaran uang kantor
    
      //----------------GENERATE NOMOR NOTA PEMBELIAN --------------------//
      $id_masterpembelian="";
      $id_master         =$this->pembelian_model->getLastIdMasterPembelian();
      

      if($id_master)
      {  
        foreach ($id_master as $key) 
        {
          $id_masterpembelian=$key->masterpembelian_id;
        }
        $_mpembelian_id=$this->pembelian_model->genMPembelian($id_masterpembelian);

       $m_insert = array('masterpembelian_id'=>$_mpembelian_id,
                         'no_nota'           =>$_mpembelian_id,
                         'tgl_pembelian'     =>$tgl_now,
                         'petugas'           =>$petugas,
                         'uang_kantor'       =>$ut
                         );

       $m_in= $this->db->insert('master_pembelian',$m_insert);

        $balance_insert = array('masterpembelian_id' =>$_mpembelian_id,
                                'total_balance'      =>$balance
                         );

       $bal_in= $this->db->insert('tb_balance',$balance_insert);

       $sql_tmpbeli="SELECT * FROM trx_pembelian_tmp";
       $q_tmp=$this->db->query($sql_tmpbeli);

       foreach ($q_tmp->result() as $items) {

          $detail_pembelian_t = array(
                            'masterpembelian_id'=>$_mpembelian_id,
                            'kode_produk'       =>$items->kode_produk,                
                            'qty'               =>$items->qty-$items->bonus,
                            'bonus'             =>$items->bonus,
                            'total_qty'         =>$items->total_qty,
                            'stok'              =>$items->qty,
                            'harga_beli'        =>$items->harga_beli,   
                            'harga_total'       =>intval($items->sub_total),
                            'status_update'     =>'N');
          $in_pemb_detail=$this->db->insert('trx_pembelian_detail',$detail_pembelian_t);
         }

   ////===================================TRANSAKSI TANGGAL LAIN===============================
   $_mpembelianlain_id="";
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

                  $_no_nota=$getLastNotaLain->masterpemblain_id;
                  $_mpembelianlain_id=$this->pembelian_model->genMPembelianLain($id_mbelilain);
                  $no_nota_lain=$this->pembelian_model->GenerateNoNota($_no_nota,'L');
              }

                  $_def_sql_tmp="SELECT tp.id_detailpembelian AS id,p.nama_produk,tp.kode_produk,tp.harga_beli h_beli,
                     SUM(tp.qty) qty,SUM(tp.bonus) bonus,SUM(tp.stok) stok,SUM(tp.sub_total) sub_total 
                     FROM trx_pembelian_tmp tp
                     INNER JOIN produk p ON p.kode_produk=tp.kode_produk
                     GROUP BY p.kode_produk
                     ";
                  $_qr_result=$this->db->query($_def_sql_tmp);
                  
                  foreach ($_qr_result->result() as $key) {
                     $rowLain = array(
                        'masterpemblain_id'      =>$_mpembelianlain_id,
                        'nama_barang'            =>$key->nama_produk,
                        'harga_satuan'           =>$key->h_beli,
                        'qty'                    =>$key->qty,
                        'subtotal'               =>$key->sub_total
                        );
                     $trx_belilain_insert =  $this->db->insert('trx_pembelianlain_detail',$rowLain);
                  }
                //END
               // masukan kedalam pembelian lain
               $m_pembelianlain = array('masterpemblain_id' => $_mpembelianlain_id,
                                'no_nota'           => $no_nota_lain,
                                'nama_pegawai'      => $_SESSION['uname'],
                                'tanggal'           => $tgl_now 
                                        );
               $insert_mpembelianlain =  $this->db->insert('master_beli_lain',$m_pembelianlain);
              }
  //=====================================END======================================


          $this->db->query("DELETE FROM trx_pembelian_tmp");
          
      echo $_mpembelian_id.$_mpembelianlain_id;
      }else{
       $_mpembelian_id="PB".date('y')."00001";
      $sql_tmpbeli="SELECT * FROM trx_pembelian_tmp";
       $q_tmp=$this->db->query($sql_tmpbeli);

       foreach ($q_tmp->result() as $items) {

          $detail_pembelian_t = array(
                            'masterpembelian_id'=>$_mpembelian_id,
                            'kode_produk'       =>$items->kode_produk,                
                            'qty'               =>$items->qty-$items->bonus,
                            'bonus'             =>$items->bonus,
                            'total_qty'         =>$items->total_qty,
                            'stok'              =>$items->qty,
                            'harga_beli'        =>$items->harga_beli,   
                            'harga_total'       =>intval($items->sub_total),
                            'status_update'     =>'N');
          $in_pemb_detail=$this->db->insert('trx_pembelian_detail',$detail_pembelian_t);
         }
          $this->db->query("DELETE FROM trx_pembelian_tmp");
     $m_insert =array(
                      'masterpembelian_id'=>$_mpembelian_id,
                      'no_nota'           =>$_mpembelian_id,
                      'tgl_pembelian'     =>$tgl_now,
                      'petugas'           =>$petugas,
                      'uang_kantor'       =>$ut);
           // $update = $this->db->query("UPDATE produk SET kode_produk='$kode_produk',nama_produk='$nama_produk',harga_beli='$harga_beli',harga_jual='$harga_jual',jumlah_Stok='$jumlah_stok',tanggal_buat='$tgl_now' WHERE kode_produk='$kode_produk' ");
      $m_in  =  $this->db->insert('master_pembelian',$m_insert);
       $balance_insert = array('masterpembelian_id' =>$_mpembelian_id,
                                'total_balance'      =>$balance
                         );

       $bal_in= $this->db->insert('tb_balance',$balance_insert);
             ////===================================TRANSAKSI TANGGAL LAIN===============================
  
   $_mpembelianlain_id="";
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

                            $_no_nota=$getLastNotaLain->masterpemblain_id;
          
                  $_mpembelianlain_id=$this->pembelian_model->genMPembelianLain($id_mbelilain);
                  $no_nota_lain=$this->pembelian_model->GenerateNoNota($_no_nota,'L');
              }

                  $_def_sql_tmp="SELECT tp.id_detailpembelian AS id,p.nama_produk,tp.kode_produk,tp.harga_beli h_beli,
                     SUM(tp.qty) qty,SUM(tp.bonus) bonus,SUM(tp.stok) stok,SUM(tp.sub_total) sub_total 
                     FROM trx_pembelian_tmp tp
                     INNER JOIN produk p ON p.kode_produk=tp.kode_produk
                     GROUP BY p.kode_produk
                     ";
                  $_qr_result=$this->db->query($_def_sql_tmp);
                  
                  foreach ($_qr_result->result() as $key) {
                     $rowLain = array(
                        'masterpemblain_id'      =>$_mpembelianlain_id,
                        'nama_barang'            =>$key->nama_produk,
                        'harga_satuan'           =>$key->h_beli,
                        'qty'                    =>$key->qty,
                        'subtotal'               =>$key->sub_total
                        );
                     $trx_belilain_insert =  $this->db->insert('trx_pembelianlain_detail',$rowLain);
                  }
                //END
               // masukan kedalam pembelian lain
               $m_pembelianlain = array('masterpemblain_id' => $_mpembelianlain_id,
                                'no_nota'           => $no_nota_lain,
                                'nama_pegawai'      => $_SESSION['uname'],
                                'tanggal'           => $tgl_now 
                                        );
               $insert_mpembelianlain =  $this->db->insert('master_beli_lain',$m_pembelianlain);
              }
  //=====================================END======================================
         echo $_mpembelian_id.$_mpembelianlain_id;
      }
    }//end function

    public function cekNota(){
      $this->load->model('pembelian_model');
      $getLastNotaLain=$this->pembelian_model->getLastNotaMasterPembelianLain();
      $kode="";
      foreach ($getLastNotaLain as $key) {
              $kode=$key->no_nota; 
          }
      $no_nota=$this->pembelian_model->GenerateNoNota($kode,'L');
      echo $no_nota;
    }
public function deletebarangupdate($rowid) 
  {
    $this->db->where('kode_produk', $rowid);
    $this->db->delete('trx_pembelian_tmp');
    echo json_encode(array("status" => TRUE));

    // $this->cart->update(array(
    //     'rowid'=>$rowid,
    //     'qty'=>0,));
    // echo json_encode(array("status" => TRUE));
  }


public function reloadTotal(){
   $cekRow=$this->db->query("SELECT SUM(sub_total) as total FROM trx_pembelian_tmp");
   $total=$cekRow->row()->total;
  echo '<input type="text"  class="form-control input-small" id="total" name="total" 
        value="'.$total.'" readonly="readonly">' ;
}
//==============================================END===================================================

//=========================================UPDATE HARGA JUAL KOMODITI==================================

public function updatehjualkomoditi(){

    $K_kode_produk=$this->input->post("kode_produk");
    $K_nm_produk  =$this->input->post("nama_produk");
    $K_hjual      =$this->input->post("harga_jual");
    $K_hgrosir    =$this->input->post("harga_grosir");  
    $K_qtygrosir  =$this->input->post("qty_grosir");

   $sql="UPDATE produk SET nama_produk='$K_nm_produk',harga_jual='$K_hjual',
                                        qty_grosir='$K_qtygrosir',jual_grosir='$K_hgrosir' 
                      WHERE kode_produk ='$K_kode_produk'";
    $this->db->query($sql);
    echo "Berhasil Diupdate";
}
//====================================================================================================
    public function cekIsi(){
      $content=$this->cart->contents();
      print_r($content);

}
public function cekMaster($no_nota){
          $id_masterpenjualan="L161020";
          $tgl_now=date('Y-m-d');

          $_Thn      = substr($tgl_now,2,2);
          $nota_num  = substr($no_nota,1,4);
          
          $nota_gen  = (int) $nota_num+1;
          $no_nota_1 = $nota_gen;

          $no_notas  = "L".$no_nota_1;
          
          $no_mid=substr($id_masterpenjualan,3,6);
          $no_gen=intval($no_mid)+1;

          $_mpenjualan_id="L".$_Thn.strval($no_gen);
          echo $_mpenjualan_id."</br>";
          echo $nota_gen."</br>";
}

public function GenerateNoNota($kode){
    $tipe="L";
    $no_nota='';
    $no_nota=substr($kode,4,5)+1;
    switch (strlen($no_nota)) {
      case 1:$no_nota=$tipe.'0000'.$no_nota;
        break;
      case 2:$no_nota=$tipe.'000'.$no_nota;
        break;
      case 3:$no_nota=$tipe.'00'.$no_nota;
        break;
      case 4:$no_nota=$tipe.'0'.$no_nota;
        break;
      case 5:$no_nota=$tipe.$no_nota;
        break;
      default:
        # code...
        break;
    }
    echo $no_nota;
  }

   public function deletenamaitem($id){
    $this->db->where('kode_produk', $id);
    $this->db->delete('produk');
    echo json_encode(array("status" => TRUE));
   }

   //hapus nota beli

  public function cekHapusBeli(){
     $this->load->view('dashboard/header');
      $this->load->view('dashboard/left_menu.php');
      $this->load->view('pembelian/hapus_nb');
      $this->load->view('dashboard/_js');
  } 
   public function delNotBeli($id){
       $this->load->model('pembelian_model');
       $MP=$this->pembelian_model->DeleteTrx($id,'master_pembelian','masterpembelian_id');
       $TP=$this->pembelian_model->DeleteTrx($id,'trx_pembelian_detail','masterpembelian_id'); 
       echo json_encode(array("status" => TRUE));  
   }

   public function cekData($id){
      $db=$this->db->query("SELECT * FROM `v_trx_pembelian`  WHERE masterpembelian_id='$id'");
       $res=array();
       echo ' <div class="panel-body">
        <table id="table_transaksi" class="table table-striped table-bordered">
        <thead>
          <tr>
              <th>No</th>
              <th>Nama Barang</th>
              <th>Harga Beli</th>
              <th>Quantity</th>
              <th>Bonus</th>
              <th>Sub-Total</th>
          </tr>
        </thead>';
        $no=1;
      foreach ($db->result() as $key) {   

        echo '
        <tbody>
         <td>'.$no.'</td>
         <td>' . $key->nama_produk .'</td>
         <td> '. $key->harga_beli. '</td>
         <td> '. $key->qty . '</td>
         <td> '. $key->bonus .'</td>
         <td> '. $key->harga_total .'</td>
        </tbody>';
      $no++;
        // $res[]=$data;
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


   public function deletenotabeli($id){
    
    $a=$this->db->where('masterpembelian_id', $id);
    $b=$this->db->delete('master_pembelian');

    $c=$this->db->where('masterpembelian_id', $id);
    $d=$this->db->delete('trx_pembelian_detail');
    
    $c=$this->db->where('masterpembelian_id', $id);
    $d=$this->db->delete('tb_balance');
    
    echo json_encode(array("status" => TRUE));
   }

   //Nota Lain
    public function cekDataLain($id){
      $db=$this->db->query("SELECT * FROM `v_trx_belilain`  WHERE masterpemblain_id='$id'");
       $res=array();
       echo ' <div class="panel-body">
        <table id="table_transaksi" class="table table-striped table-bordered">
        <thead>
          <tr>
              <th>No</th>
              <th>Nama Barang</th>
              <th>Harga Beli</th>
              <th>Quantity</th>
              <th>SubTotal</th>
          </tr>
        </thead>';
        $no=1;
      foreach ($db->result() as $key) {   

        echo '
        <tbody>
          <td>'.$no.'</td>
         <td>' . $key->nama_barang .'</td>
         <td> '. $key->harga_satuan. '</td>
         <td> '. $key->qty. '</td>
         <td> '. $key->subtotal.'</td>
        </tbody>';
      $no++;
        // $res[]=$data;
      }
      echo '</table>
      <input type="hidden" id="masterbelilain" value="'.$id.'">
      <div class="col-md-offset-8" style="margin-top:20px">
        <button type="button" class="btn btn-primary btn-lg" id="hapus" 
        onclick="deletebaranglain()">
        Hapus Nota Lain <i class="fa fa-angle-double-right"></i></button>
      </div>
      </div>';
      //$output = array("data" => $res,);
      // echo json_encode($res);
   }


    public function deletenotabelilain($id){
    
    $a=$this->db->where('masterpemblain_id', $id);
    $b=$this->db->delete('master_beli_lain');

    $c=$this->db->where('masterpemblain_id', $id);
    $d=$this->db->delete('trx_pembelianlain_detail');
        
    echo json_encode(array("status" => TRUE));
   }


  }
  /*
    Pembelian lain [pada waktu delete nilai pengurangan belum sesuai]
  */