<?php
class pembelian_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }
	 
	 	public function getAllProduk($num, $offset){
	 		 $query = $this->db->get("produk",$num, $offset);
	  		 return $query->result();
	 	}
	 	
		public function getProduk()
		{
			$query = $this->db->query("SELECT `kode_produk`, `nama_produk`FROM `produk`");
			return $query;
		}

		public function getProdukById($id){
			$this->db->where('kode_produk',$id); 
	  		return $this->db->get('produk')->row();
		}

		public function transaksiPembelian(){
			$sql="SELECT ";
			$query=$this->db->query($sql);	
		} 
		public function getLastIdMasterPembelian(){
			$query = $this->db->query("SELECT masterpembelian_id FROM master_pembelian order by masterpembelian_id asc ");
			return $query->result();
		}

		public function getLastIdMasterPembelianLain(){
			$query = $this->db->query("SELECT masterpemblain_id FROM master_beli_lain order by 	masterpemblain_id DESC LIMIT 1 ");
			return $query->result();
		}
		public function getLastNotaMasterPembelianLain(){
			$query = $this->db->query("SELECT masterpemblain_id FROM master_beli_lain order by no_nota DESC LIMIT 1 ");
			return $query->row();
		}



		public function LaporanPembelian(){
			$sql="  SELECT master_pembelian.no_nota,tb.kode_produk,produk.nama_produk,produk.harga_beli as hbeli,tb.qty,tb.harga_total as total,master_pembelian.tgl_pembelian as tanggal
					FROM trx_pembelian_detail as tb
					INNER JOIN produk on produk.kode_produk=tb.kode_produk
					INNER JOIN master_pembelian on master_pembelian.masterpembelian_id=tb.masterpembelian_id";
			$query = $this->db->query($sql);
			return $query;
		}

		//per nota tanpa nama
		public function getLaporanPembelian($tgl_start,$tgl_end){
			$sql="SELECT master_pembelian.no_nota,tb.kode_produk,produk.nama_produk,tb.harga_beli as hbeli,
			      sum(tb.qty) as qty,sum(tb.harga_total) as total,master_pembelian.tgl_pembelian as tanggal FROM trx_pembelian_detail as tb 
			      INNER JOIN produk on produk.kode_produk=tb.kode_produk 
			      INNER JOIN master_pembelian on master_pembelian.masterpembelian_id=tb.masterpembelian_id WHERE
			      master_pembelian.tgl_pembelian >= '$tgl_start' 
			      AND
			      master_pembelian.tgl_pembelian <= '$tgl_end'
			      AND master_pembelian.uang_kantor=0
			     GROUP BY master_pembelian.no_nota";
			$query = $this->db->query($sql);
			return $query;
		}

		public function getLaporanPembelianDetail($tgl_start,$tgl_end){
			$sql="SELECT master_pembelian.no_nota,tb.kode_produk,produk.nama_produk,tb.harga_beli as hbeli,
			      sum(tb.qty) as qty,sum(tb.harga_total) as total,master_pembelian.tgl_pembelian as tanggal FROM trx_pembelian_detail as tb 
			      INNER JOIN produk on produk.kode_produk=tb.kode_produk 
			      INNER JOIN master_pembelian on master_pembelian.masterpembelian_id=tb.masterpembelian_id WHERE
			      master_pembelian.tgl_pembelian >= '$tgl_start' 
			      AND
			      master_pembelian.tgl_pembelian <= '$tgl_end'
			      AND master_pembelian.uang_kantor=0
			     GROUP BY master_pembelian.no_nota,tb.kode_produk";
			$query = $this->db->query($sql);
			return $query;
		}
		
		public function getTotalPembelian($tgl_start,$tgl_end){
			$sql="SELECT master_pembelian.no_nota,tb.kode_produk,produk.nama_produk,tb.harga_beli as hbeli,
			      sum(tb.qty) as qty,sum(tb.harga_total) as total,master_pembelian.tgl_pembelian as tanggal FROM trx_pembelian_detail as tb 
			      INNER JOIN produk on produk.kode_produk=tb.kode_produk 
			      INNER JOIN master_pembelian on master_pembelian.masterpembelian_id=tb.masterpembelian_id WHERE
			      master_pembelian.tgl_pembelian >= '$tgl_start' 
			      AND
			      master_pembelian.tgl_pembelian <= '$tgl_end'
			      AND master_pembelian.uang_kantor=0";
			      $query = $this->db->query($sql);
			return $query;
		}




		public function getLaporanPembelianByNota($tgl_start,$tgl_end){
			$sql="SELECT master_pembelian.no_nota,tb.kode_produk,produk.nama_produk,produk.harga_beli as hbeli,
			      sum(tb.qty) as qty,sum(tb.harga_total) as total,master_pembelian.tgl_pembelian as tanggal FROM trx_pembelian_detail as tb 
			      INNER JOIN produk on produk.kode_produk=tb.kode_produk 
			      INNER JOIN master_pembelian on master_pembelian.masterpembelian_id=tb.masterpembelian_id WHERE
			      master_pembelian.tgl_pembelian >= '$tgl_start' 
			      AND
			      master_pembelian.tgl_pembelian <= '$tgl_end'
			      GROUP BY master_pembelian.no_nota";
			$query = $this->db->query($sql);
			return $query;
		}

		public function getLaporanPembelianLain($tgl_start,$tgl_end){
			$sql="SELECT master_beli_lain.no_nota,tb.nama_barang,tb.harga_satuan as hbeli,
			      sum(tb.qty) as qty,sum(tb.subtotal) as total,master_beli_lain.tanggal as tanggal 
			      FROM trx_pembelianlain_detail as tb 
			      INNER JOIN master_beli_lain on master_beli_lain.masterpemblain_id=tb.masterpemblain_id
			      WHERE
			      master_beli_lain.tanggal >= '$tgl_start' 
			      AND
			      master_beli_lain.tanggal <= '$tgl_end'
			      GROUP BY master_beli_lain.no_nota
			   ";
			   /*
			    UNION ALL
                SELECT master_penjualan.no_nota,produk.nama_produk,SUM(tb.sub_total)/qty  hargajual,
                tb.qty AS qty,SUM(tb.sub_total) AS total,
                master_penjualan.tgl_penjualan AS tanggal
				FROM trx_penjualan_detail AS tb 
				INNER JOIN produk ON produk.kode_produk=tb.kode_produk
				INNER JOIN master_penjualan ON master_penjualan.masterpenjualan_id=tb.masterpenjualan_id  
                WHERE 
                master_penjualan.tgl_penjualan >= '$tgl_start'
                AND
				master_penjualan.tgl_penjualan <= '$tgl_end'
				AND master_penjualan.uang_toko=1
                GROUP BY master_penjualan.masterpenjualan_id
                */
			$query = $this->db->query($sql);
			return $query;
		}

		public function getTotalPembelianLain($tgl_start,$tgl_end){
			$sql="SELECT master_beli_lain.no_nota,tb.nama_barang,tb.harga_satuan as hbeli,
			      sum(tb.qty) as qty,sum(tb.subtotal) as total,master_beli_lain.tanggal as tanggal 
			      FROM trx_pembelianlain_detail as tb 
			      INNER JOIN master_beli_lain on master_beli_lain.masterpemblain_id=tb.masterpemblain_id
			      WHERE
			      master_beli_lain.tanggal >= '$tgl_start' 
			      AND
			      master_beli_lain.tanggal <= '$tgl_end' ";
			$query = $this->db->query($sql);
			return $query;
		}

		public function getTotalPembelianUangtoko($tgl_start,$tgl_end){
			$sql="SELECT SUM(tb.sub_total) AS total,
                master_penjualan.tgl_penjualan AS tanggal
				FROM trx_penjualan_detail AS tb 
				INNER JOIN master_penjualan ON master_penjualan.masterpenjualan_id=tb.masterpenjualan_id  
		        WHERE 
		        master_penjualan.tgl_penjualan >= '$tgl_start' 
		        AND
				master_penjualan.tgl_penjualan <= '$tgl_end'
				AND master_penjualan.uang_toko=1";
			$query = $this->db->query($sql);
			return $query;
		}

		//Balance
		public function getLaporanBalance($tgl_start,$tgl_end){
			$sql="SELECT mp.no_nota,mp.tgl_pembelian AS tanggal ,tb.total_balance AS balance
			      FROM tb_balance AS tb 
			      INNER JOIN master_pembelian mp ON mp.masterpembelian_id=tb.masterpembelian_id
			      WHERE
			      mp.tgl_pembelian >= '$tgl_start' 
			      AND
			      mp.tgl_pembelian <= '$tgl_end'
			     GROUP BY mp.no_nota	
			     ";
			     $query = $this->db->query($sql);
			return $query;
		}

		public function getLaporanTotalBalance($tgl_start,$tgl_end){
				$sql=" SELECT SUM(tb.total_balance) AS balance
			      FROM tb_balance AS tb 
			      INNER JOIN master_pembelian mp ON mp.masterpembelian_id=tb.masterpembelian_id
			      WHERE
			      mp.tgl_pembelian >= '$tgl_start' 
			      AND
			      mp.tgl_pembelian <= '$tgl_end'
			      AND mp.uang_kantor=0";
			$query = $this->db->query($sql);
			return $query;
		}

		public function cetakNota($masterpembelian_id){
			$sql="SELECT master_pembelian.no_nota,tb.kode_produk,produk.nama_produk,tb.harga_beli hbeli,
			      sum(tb.qty) as qty,tb.bonus,tb.total_qty,sum(tb.harga_total) as total,master_pembelian.tgl_pembelian as tanggal,master_pembelian.petugas as petugas FROM trx_pembelian_detail as tb 
			      INNER JOIN produk on produk.kode_produk=tb.kode_produk 
			      INNER JOIN master_pembelian on master_pembelian.masterpembelian_id=tb.masterpembelian_id WHERE
			      tb.masterpembelian_id = '$masterpembelian_id'
			      GROUP BY tb.kode_produk ";
			$query = $this->db->query($sql);
			return $query;
		}
		public function cetakNotaTotal($masterpembelian_id){
			$sql="SELECT master_pembelian.no_nota,tb.kode_produk,produk.nama_produk,tb.harga_beli as hbeli,
			      sum(tb.qty) as qty,tb.bonus,tb.total_qty,sum(tb.harga_total) as total,master_pembelian.tgl_pembelian as tanggal,master_pembelian.petugas as petugas FROM trx_pembelian_detail as tb 
			      INNER JOIN produk on produk.kode_produk=tb.kode_produk 
			      INNER JOIN master_pembelian on master_pembelian.masterpembelian_id=tb.masterpembelian_id 
			      WHERE tb.masterpembelian_id = '$masterpembelian_id' ";
			$query = $this->db->query($sql);
			return $query;
		}
		
		public function cetakNotaLain($masterpembelian_id){
			$sql="SELECT mbl.no_nota,tb.nama_barang,tb.harga_satuan hbeli,tb.qty,tb.subtotal total,mbl.tanggal, mbl.nama_pegawai as petugas 
				FROM trx_pembelianlain_detail AS tb
				JOIN master_beli_lain mbl ON mbl.masterpemblain_id=tb.masterpemblain_id
				WHERE
				tb.masterpemblain_id = '$masterpembelian_id'
				GROUP BY tb.nama_barang";
				$query = $this->db->query($sql);
			return $query;
		}
		
		public function cetakNotaLainTotal($masterpembelian_id){
			$sql="SELECT mbl.no_nota,tb.nama_barang,tb.harga_satuan hbeli,tb.qty,SUM(tb.subtotal) total,mbl.tanggal 
				FROM trx_pembelianlain_detail AS tb
				JOIN master_beli_lain mbl ON mbl.masterpemblain_id=tb.masterpemblain_id
				WHERE
				tb.masterpemblain_id = '$masterpembelian_id'";
			$query = $this->db->query($sql);
			return $query;
		}

		public function getBalance($masterpembelian_id){
			$sql="SELECT total_balance AS total FROM tb_balance 
				  WHERE masterpembelian_id='$masterpembelian_id'";
				  $query = $this->db->query($sql);
			return $query->row();
		}

		public function getCekUtoko($masterpembelian_id){
			$sql="  SELECT masterpembelian_id,no_nota,uang_kantor as ut
				  FROM master_pembelian
				  WHERE masterpembelian_id='$masterpembelian_id'";
				  $query = $this->db->query($sql);
			return $query->row();
		}
	

	public function getTanggal($tgl){
        $hh = substr($tgl,0,2);
        $mm = substr($tgl,2,4);
        $yy = substr($tgl,6,6);
        return $yy.$mm.$hh;
    }

    public function genMPembelian($kode){
		$no_nota='';
		$no_nota=substr($kode,4,5)+1;
		switch (strlen($no_nota)) {
			case 1:$no_nota='PB'.date('y').'0000'.$no_nota;
				break;
			case 2:$no_nota='PB'.date('y').'000'.$no_nota;
				break;
			case 3:$no_nota='PB'.date('y').'00'.$no_nota;
				break;
			case 4:$no_nota='PB'.date('y').'0'.$no_nota;
				break;
			case 5:$no_nota='Pb'.date('y').''.$no_nota;
				break;
			default:
				# code...
				break;
		}
		return $no_nota;
	}

	 public function genMPembelianLain($kode){
		$no_nota='';
		$no_nota=substr($kode,4,5)+1;
		switch (strlen($no_nota)) {
			case 1:$no_nota='L'.date('y').'0000'.$no_nota;
				break;
			case 2:$no_nota='L'.date('y').'000'.$no_nota;
				break;
			case 3:$no_nota='L'.date('y').'00'.$no_nota;
				break;
			case 4:$no_nota='L'.date('y').'0'.$no_nota;
				break;
			case 5:$no_nota='L'.date('y').''.$no_nota;
				break;
			default:
				# code...
				break;
		}
		return $no_nota;
	}

	public function GenerateNoNota($kode,$tipe){
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
		return $no_nota;
	}

	public function getLaporanStok($tgl_start,$tgl_end){
		$this->db->query("SET @tgl1='$tgl_start'");
		$this->db->query("SET @tgl2='$tgl_end'");
		$sql=$this->db->query("SELECT '1' sort,#m.masterpembelian_id,m.tgl_pembelian,m.harga_beli,
	m.kode_produk,
	m.nama_produk,
	COALESCE(j.harga_jual,'') harga_jual,
	COALESCE(j.subjual,'') subjual,
	#coalesce(s.total_qty,'') semua,
	#(COALESCE(a.stok,0)+COALESCE(j.qty,0)) awal,
        (COALESCE(a.stok,0)+COALESCE(b.stok,0))-COALESCE(b.total_qty,'')+COALESCE(j2.qty,'') awal,
	COALESCE(b.total_qty,'') beli,
	COALESCE(j.qty,'') jual,
	(COALESCE(a.stok,0)+COALESCE(b.stok,0)) akhir,
	IF(COALESCE(j.paket,'')='1','paket','') paket
FROM (SELECT kode_produk,nama_produk FROM v_trx_pembelian GROUP BY kode_produk) m
LEFT OUTER JOIN (
	SELECT kode_produk,SUM(total_qty) total_qty,SUM(stok) stok
	FROM v_trx_pembelian
	WHERE tgl_pembelian < DATE_FORMAT(@tgl1,'%Y-%m-%d')
	GROUP BY kode_produk
	) a ON a.kode_produk=m.kode_produk
LEFT OUTER JOIN (
	SELECT kode_produk,SUM(total_qty) total_qty,SUM(stok) stok
	FROM v_trx_pembelian
	WHERE tgl_pembelian >= DATE_FORMAT(@tgl1,'%Y-%m-%d') AND tgl_pembelian <= DATE_FORMAT(@tgl2,'%Y-%m-%d')
	GROUP BY kode_produk
	) b ON b.kode_produk=m.kode_produk
LEFT OUTER JOIN (
	SELECT kode_produk,SUM(qty) qty,SUM(sub_total) subjual,sub_total/qty harga_jual,paket
	FROM v_trx_penjualan
	WHERE tgl_penjualan >= DATE_FORMAT(@tgl1,'%Y-%m-%d') AND tgl_penjualan <= DATE_FORMAT(@tgl2,'%Y-%m-%d')
	GROUP BY kode_produk,paket#,(sub_total/qty)
	) j ON j.kode_produk=m.kode_produk
LEFT OUTER JOIN (
	SELECT kode_produk,SUM(qty) qty,SUM(sub_total) subjual,sub_total/qty harga_jual
	FROM v_trx_penjualan
	WHERE tgl_penjualan >= DATE_FORMAT(@tgl1,'%Y-%m-%d') AND tgl_penjualan <= DATE_FORMAT(@tgl2,'%Y-%m-%d')
	GROUP BY kode_produk#,(sub_total/qty)
	) j2 ON j2.kode_produk=m.kode_produk
UNION ALL
#SELECT * FROM (
SELECT '2','','','JUMLAH',SUM(sub_total) subjual,'','',SUM(qty) qty,'',''
FROM v_trx_penjualan
WHERE tgl_penjualan >= DATE_FORMAT(@tgl1,'%Y-%m-%d') AND tgl_penjualan <= DATE_FORMAT(@tgl2,'%Y-%m-%d')
#) pjs
	
ORDER BY sort,kode_produk ASC");
		return $sql;
	}

	public function DeleteTrx($id,$table,$row){
    	$this->db->where($row, $id);
    	$this->db->delete($table);
	}

	/*
      @params  $id_detailpembelian -> where
               $stok -> nilai stok yang akan diupdate
   */
    public function uStokdetail($id,$stok){
    	$this->db->query("UPDATE trx_pembelian_detail SET stok='$stok' 
    				      WHERE id_detailpembelian='$id'");
    }

}

   

/*
SELECT '1' sort,#m.masterpembelian_id,m.tgl_pembelian,m.harga_beli,
	m.kode_produk,
	m.nama_produk,
	COALESCE(j.harga_jual,'') harga_jual,
	COALESCE(j.subjual,'') subjual,
	#coalesce(s.total_qty,'') semua,
	#(COALESCE(a.stok,0)+COALESCE(j.qty,0)) awal,
    (COALESCE(a.stok,0)+COALESCE(b.stok,0))-COALESCE(b.total_qty,'')+COALESCE(j.qty,'') awal,
	COALESCE(b.total_qty,'') beli,
	COALESCE(j.qty,'') jual,
	(COALESCE(a.stok,0)+COALESCE(b.stok,0)) akhir
FROM (SELECT kode_produk,nama_produk FROM v_trx_pembelian GROUP BY kode_produk) m
LEFT OUTER JOIN (
	SELECT kode_produk,SUM(total_qty) total_qty,SUM(stok) stok
	FROM v_trx_pembelian
	WHERE tgl_pembelian < DATE_FORMAT(@tgl1,'%Y-%m-%d')
	GROUP BY kode_produk
	) a ON a.kode_produk=m.kode_produk
LEFT OUTER JOIN (
	SELECT kode_produk,SUM(total_qty) total_qty,SUM(stok) stok
	FROM v_trx_pembelian
	WHERE tgl_pembelian >= DATE_FORMAT(@tgl1,'%Y-%m-%d') AND tgl_pembelian <= DATE_FORMAT(@tgl2,'%Y-%m-%d')
	GROUP BY kode_produk
	) b ON b.kode_produk=m.kode_produk
LEFT OUTER JOIN (
	SELECT kode_produk,SUM(qty) qty,SUM(sub_total) subjual,sub_total/qty harga_jual
	FROM v_trx_penjualan
	WHERE tgl_penjualan >= DATE_FORMAT(@tgl1,'%Y-%m-%d') AND tgl_penjualan <= DATE_FORMAT(@tgl2,'%Y-%m-%d')
	GROUP BY kode_produk#,(sub_total/qty)
	) j ON j.kode_produk=m.kode_produk
UNION ALL
#SELECT * FROM (
SELECT '2','','','JUMLAH',SUM(sub_total) subjual,'','',SUM(qty) qty,''
FROM v_trx_penjualan
WHERE tgl_penjualan >= DATE_FORMAT(@tgl1,'%Y-%m-%d') AND tgl_penjualan <= DATE_FORMAT(@tgl2,'%Y-%m-%d')
#) pjs
	
ORDER BY sort,kode_produk ASC	
*/