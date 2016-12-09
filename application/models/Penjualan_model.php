<?php
class Penjualan_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }

	 function getAllPenjualan_tmp()
		{
		$query = $this->db->query("SELECT `id_detailpenjualan`, `masterpenjualan_id`,
			`kode_produk`, `qty`, `harga`,harga*qty as total FROM trx_penjualan_detail_tmp");
			return $query;
		}
// =======================================================================================
		// Old Version
		public function getProduk_()
		{
			$query = $this->db->query("SELECT `kode_produk`, `nama_produk` FROM `produk`");
			return $query;
		}

		//tampilkan produk 
		public function showProduk($id){
			return $this->db->query("SELECT * FROM produk WHERE kode_produk='$id'")->row();
		}

		//cek jumlah stok berdasarkan kode produk
		//kembalian total stok
		/*
		* tb pembelian
		*/
		public function cekStokByProduk($id){
			return $this->db->query("SELECT SUM(stok) AS sisa FROM `trx_pembelian_detail` 
									WHERE kode_produk='$id'
									GROUP BY kode_produk")->row();	
		}
// ========================================================================================
		function v_getproduk(){
			return "SELECT id_detailpembelian,COALESCE(m.tgl_pembelian,'0000-00-00') tgl_pembelian,p.kode_produk,p.nama_produk,
					COALESCE(d.stok,0) stok,jstok.stok stok_total,p.harga_jual
				FROM trx_pembelian_detail d
				JOIN master_pembelian m ON m.masterpembelian_id=d.masterpembelian_id
				JOIN produk p ON p.kode_produk = d.kode_produk
				JOIN (SELECT p.kode_produk,p.nama_produk,SUM(d.stok) stok
					FROM trx_pembelian_detail d
					JOIN master_pembelian m ON m.masterpembelian_id=d.masterpembelian_id
					JOIN produk p ON p.kode_produk = d.kode_produk
					GROUP BY p.kode_produk) jstok ON jstok.kode_produk=d.kode_produk
				ORDER BY tgl_pembelian,id_detailpembelian ASC";
		}
		public function getProdukById($id){
		  return $this->db->query("SELECT * FROM (
				SELECT id_detailpembelian,d.masterpembelian_id,d.harga_beli,COALESCE(m.tgl_pembelian,'0000-00-00') tgl_pembelian,p.kode_produk,p.nama_produk,
					COALESCE(d.stok,0) stok,jstok.stok stok_total,p.harga_jual,p.jual_grosir,p.qty_grosir
				FROM trx_pembelian_detail d
				JOIN master_pembelian m ON m.masterpembelian_id=d.masterpembelian_id
				JOIN produk p ON p.kode_produk = d.kode_produk
				JOIN (SELECT p.kode_produk,p.nama_produk,SUM(d.stok) stok
					FROM trx_pembelian_detail d
					JOIN master_pembelian m ON m.masterpembelian_id=d.masterpembelian_id
					JOIN produk p ON p.kode_produk = d.kode_produk
					GROUP BY p.kode_produk) jstok ON jstok.kode_produk=d.kode_produk
				ORDER BY tgl_pembelian,id_detailpembelian ASC
				) a
				WHERE id_detailpembelian='$id'")->row();
		}

		public function getProduk(){
			$sql="SELECT id_detailpembelian,d.masterpembelian_id,COALESCE(m.tgl_pembelian,'0000-00-00') tgl_pembelian,p.kode_produk,p.nama_produk,
					COALESCE(d.stok,0) stok,jstok.stok stok_total,p.harga_jual
				FROM trx_pembelian_detail d
				JOIN master_pembelian m ON m.masterpembelian_id=d.masterpembelian_id
				JOIN produk p ON p.kode_produk = d.kode_produk
				JOIN (SELECT p.kode_produk,p.nama_produk,SUM(d.stok) stok
					FROM trx_pembelian_detail d
					JOIN master_pembelian m ON m.masterpembelian_id=d.masterpembelian_id
					JOIN produk p ON p.kode_produk = d.kode_produk
					GROUP BY p.kode_produk) jstok ON jstok.kode_produk=d.kode_produk
				where COALESCE(d.stok,0)!='0'
				ORDER BY nama_produk,tgl_pembelian,id_detailpembelian ASC";
		   return $this->db->query($sql);

		}

		public function transaksiPenjualan(){
			$query=$this->db->query("SELECT  FROM ongkir");
			return $query->result();
		} 

		public function getLastIdMaster_penjualan(){
				$query=$this->db->query("SELECT masterpenjualan_id FROM master_penjualan ORDER BY masterpenjualan_id desc LIMIT 0,1");
				return $query->result();
		}

		public function getOngkir(){
			$query=$this->db->query("SELECT * FROM ongkir");
			return $query->result();
		}
		public function getOngkir2(){
			$query=$this->db->query("SELECT * FROM ongkir");
			return $query->row();
		}

		public function getPelanggan(){
			$query = $this->db->query("SELECT id_pelanggan,nama_pelanggan FROM pelanggan");
			return $query;
		}

		public function getDeliveryPelanggan($id){
			$this->db->where('id_pelanggan',$id); 
	  		return $this->db->get('pelanggan')->row();
		}

		public function getPetugasDeliver(){
			$query = $this->db->query("SELECT id_petugas,nama_petugas FROM petugas_delivery");
			return $query;
		}

		//perlu di koreksi karena data stok diambil dari pembelian
		public function getStokBy($kode_produk){
			$query = $this->db->query("SELECT jumlah_stok FROM produk WHERE kode_produk='$kode_produk'");
			return $query->row();
		}

		public function getNomorNotaPenjualan(){
			$query = $this->db->query("SELECT no_nota from master_penjualan ORDER by no_nota desc LIMIT 0,1");
			return $query->result();
		}

		public function getLaporanPenjualan($tgl_awal,$tgl_akhir){
			$query=$this->db->query("SELECT master_penjualan.no_nota,tb.kode_produk,produk.nama_produk,produk.harga_beli as hbeli,produk.harga_jual as hjual,
					sum(tb.qty) as qty,sum(tb.sub_total) as total,sum(tb.laba) as laba,master_penjualan.tgl_penjualan as tanggal
					FROM trx_penjualan_detail as tb 
					INNER JOIN produk on produk.kode_produk=tb.kode_produk
					INNER JOIN master_penjualan on master_penjualan.masterpenjualan_id=tb.masterpenjualan_id   
                    WHERE 
                    master_penjualan.tgl_penjualan >= '$tgl_awal'
                    AND
                    master_penjualan.tgl_penjualan <= '$tgl_akhir'
                    GROUP BY produk.kode_produk,master_penjualan.tgl_penjualan 
                    ORDER BY master_penjualan.tgl_penjualan");
			 return $query;
		}
		public function getTotalPenjualan($tgl_awal,$tgl_akhir){
			$query=$this->db->query("SELECT produk.harga_beli as hbeli,produk.harga_jual as hjual,
					sum(tb.qty) as qty,sum(tb.sub_total) as total,sum(tb.laba) as laba,master_penjualan.tgl_penjualan as tanggal
					FROM trx_penjualan_detail as tb 
					INNER JOIN produk on produk.kode_produk=tb.kode_produk
					INNER JOIN master_penjualan on master_penjualan.masterpenjualan_id=tb.masterpenjualan_id   
                    WHERE 
                    master_penjualan.tgl_penjualan >= '$tgl_awal'
                    AND
                    master_penjualan.tgl_penjualan <= '$tgl_akhir'");
			 return $query;
		}

		public function cetaknota($id){
	$query=$this->db->query("SELECT trxpj.masterpenjualan_id,master_penjualan.no_nota,master_penjualan.tgl_penjualan,master_penjualan.id_pelanggan,produk.kode_produk,
 				produk.nama_produk,(trxpj.sub_total/trxpj.qty) as harga_jual,SUM(trxpj.qty) qty,trxpj.paket,SUM(trxpj.sub_total) AS total
			FROM trx_penjualan_detail AS trxpj
			INNER JOIN produk ON produk.kode_produk=trxpj.kode_produk
			INNER JOIN master_penjualan ON master_penjualan.masterpenjualan_id=trxpj.masterpenjualan_id
			WHERE trxpj.masterpenjualan_id='$id'
			GROUP BY produk.kode_produk");
			return $query;
		}

	public function getTanggal($tgl){
        $hh = substr($tgl,0,2);
        $mm = substr($tgl,2,4);
        $yy = substr($tgl,6,6);
        return $yy.$mm.$hh;
    }
    public function getAutoStokProduk($kode_produk){
			$sql="SELECT td.kode_produk,mp.tgl_pembelian,td.qty,(td.harga_total/td.qty) as harga_beli  
					FROM trx_pembelian_detail as td
					INNER JOIN master_pembelian as mp ON mp.masterpembelian_id=td.masterpembelian_id
					WHERE td.kode_produk='$kode_produk'
					AND   td.status_update='N'";
		    $query=$this->db->query($sql);
		    return $query->row();
		}

	public function getLaporanPenjualanByNota($tgl_awal,$tgl_akhir){
		$sql="SELECT master_penjualan.no_nota,sum(tb.sub_total) as total,sum(tb.laba) as laba,master_penjualan.tgl_penjualan as tanggal,cost_delivery.SC as SC,cost_delivery.DC as DC,
		    cost_delivery.DCKM as DCKM
				FROM trx_penjualan_detail as tb 
				INNER JOIN produk on produk.kode_produk=tb.kode_produk
		INNER JOIN master_penjualan on master_penjualan.masterpenjualan_id=tb.masterpenjualan_id
		INNER JOIN cost_delivery on master_penjualan.masterpenjualan_id=cost_delivery.masterpenjualan_id   
                    WHERE 
                    master_penjualan.tgl_penjualan >= '$tgl_awal'
                    AND
                    master_penjualan.tgl_penjualan <= '$tgl_akhir'
                    group by master_penjualan.masterpenjualan_id";
                    //tb.kode_produk

			$query=$this->db->query($sql);
		    return $query;
	}

	//menampilkan laporan penjualan dengan uang toko
	public function getLaporanPenjualanUangToko($tgl_awal,$tgl_akhir){
		$sql="SELECT master_penjualan.no_nota,sum(tb.sub_total) as total,sum(tb.laba) as laba,master_penjualan.tgl_penjualan as tanggal,cost_delivery.SC as SC,cost_delivery.DC as DC,
		    cost_delivery.DCKM as DCKM
				FROM trx_penjualan_detail as tb 
				INNER JOIN produk on produk.kode_produk=tb.kode_produk
		INNER JOIN master_penjualan on master_penjualan.masterpenjualan_id=tb.masterpenjualan_id
		INNER JOIN cost_delivery on master_penjualan.masterpenjualan_id=cost_delivery.masterpenjualan_id   
                    WHERE 
                    master_penjualan.tgl_penjualan >= '$tgl_awal'
                    AND
                    master_penjualan.tgl_penjualan <= '$tgl_akhir'
                    AND master_penjualan.uang_toko=1
                    group by master_penjualan.masterpenjualan_id";
			$query=$this->db->query($sql);
		    return $query;
	}


	public function getTotalPenjualanByNota($tgl_awal,$tgl_akhir){
		$sql=" SELECT SUM(tb.sub_total) AS total,SUM(tb.laba) AS laba,mp.tgl_penjualan AS tanggal,
				SUM(cb.SC) AS SC,SUM(cb.DC) AS DC,SUM(cb.DCKM) AS DCKM
				FROM trx_penjualan_detail AS tb 
				JOIN master_penjualan mp ON mp.masterpenjualan_id = tb.masterpenjualan_id
				JOIN cost_delivery cb    ON mp.masterpenjualan_id = cb.masterpenjualan_id
				WHERE
                mp.tgl_penjualan >= '$tgl_awal'
                AND
                mp.tgl_penjualan <= '$tgl_akhir'";

			$query=$this->db->query($sql);
		    return $query;
	}


	public function getTotalCD($tgl_awal,$tgl_akhir){
		$sql="SELECT SUM(cd.SC) AS SC,SUM(cd.DC )AS DC,SUM(cd.DCKM) AS DCKM,SUM(SC+DC+DCKM) AS TOTAL
				FROM cost_delivery cd
				JOIN master_penjualan mp ON mp.masterpenjualan_id = cd.masterpenjualan_id
				WHERE
                mp.tgl_penjualan >= '$tgl_awal'
				AND
				mp.tgl_penjualan <= '$tgl_akhir'";
		$query=$this->db->query($sql);
		return $query;
	}



	public function getCostDelivery($tgl_awal,$tgl_akhir){
		$sql="SELECT mp.no_nota,mp.tgl_penjualan as tanggal,pd.nama_petugas,cd.SC,cd.DC,cd.DCKM,
			  (cd.SC+cd.DC+cd.DCKM)as Total  
			FROM cost_delivery as cd
			INNER JOIN master_penjualan as mp on mp.masterpenjualan_id=cd.masterpenjualan_id
			INNER JOIN petugas_delivery as pd on pd.id_petugas = cd.id_petugas
			WHERE 
			mp.tgl_penjualan >= '$tgl_awal'
			AND
			mp.tgl_penjualan <= '$tgl_akhir'
			GROUP by mp.no_nota";
			$query=$this->db->query($sql);
		return $query;
	}

	public function cekHarga($kode_produk){
	    $sql="SELECT kode_produk,harga_beli,qty,tanggal FROM harga_beli WHERE kode_produk='$kode_produk' ";
		$query = $this->db->query($sql);
		return $query;
	}		

	public function cekJumlahStok($id){
	return $this->db->query("SELECT * FROM (
				SELECT id_detailpembelian,COALESCE(m.tgl_pembelian,'0000-00-00') tgl_pembelian,p.kode_produk,p.nama_produk,
					COALESCE(d.stok,0) stok,jstok.stok stok_total,p.harga_jual
				FROM trx_pembelian_detail d
				JOIN master_pembelian m ON m.masterpembelian_id=d.masterpembelian_id
				JOIN produk p ON p.kode_produk = d.kode_produk
				JOIN (SELECT p.kode_produk,p.nama_produk,SUM(d.stok) stok
					FROM trx_pembelian_detail d
					JOIN master_pembelian m ON m.masterpembelian_id=d.masterpembelian_id
					JOIN produk p ON p.kode_produk = d.kode_produk
					GROUP BY p.kode_produk) jstok ON jstok.kode_produk=d.kode_produk
				ORDER BY tgl_pembelian,id_detailpembelian ASC
				) a
				WHERE id_detailpembelian='$id'");
	}

	public function cekJumlahStokPembelian($id){
		   return  $this->db->query("SELECT sum(stok) as stok FROM trx_pembelian_detail WHERE kode_produk='$id'");
	}

	public function getProdukPembelianById($id){
		return $this->db->query("SELECT * FROM produk WHERE kode_produk='$id'")->row();
		}
	public function total_jual(){
		return $this->db->query("SELECT SUM(sub_total) AS total FROM trx_penjualan_tmp")->row();
	}

	public function generateNonota($kode){
		$no_nota='';
		$no_nota=substr($kode,4,5)+1;
		switch (strlen($no_nota)) {
			case 1:$no_nota='PJ'.date('y').'0000'.$no_nota;
				break;
			case 2:$no_nota='PJ'.date('y').'000'.$no_nota;
				break;
			case 3:$no_nota='PJ'.date('y').'00'.$no_nota;
				break;
			case 4:$no_nota='PJ'.date('y').'0'.$no_nota;
				break;
			case 5:$no_nota='PJ'.date('y').''.$no_nota;
				break;
			default:
				# code...
				break;
		}
		return $no_nota;
	}

	public function getDetailStok($mid,$kproduk){
		$sql="SELECT * FROM `trx_pembelian_detail` WHERE masterpembelian_id='$mid' 
			 AND kode_produk='$kproduk'";
	    return $this->db->query($sql);
	}
		
}


