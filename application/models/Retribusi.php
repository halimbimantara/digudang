<?php
class Retribusi extends CI_Model {

 public function __construct()
        {
                $this->load->database();
        }


 public function getDataRetribusiBy($num){
		$query = $this->db->query("SELECT nama_barang,qty,subtotal total,category
								FROM `trx_pembelianlain_detail`
								WHERE category='$num' ");
	  		 return $query->result();
	 	}

 public function getTotalRetribusiBy($num){
		$query = $this->db->query("SELECT nama_barang,qty,sum(subtotal) total,category
								FROM `trx_pembelianlain_detail`
								WHERE category='$num' ");
	  		 return $query->result();
	 	}

public function totalLainlain(){
	$query=$this->db->query("SELECT cat.nama,qty,SUM(subtotal) total
							FROM `trx_pembelianlain_detail` tb
							JOIN category_ret cat ON cat.id_category=tb.category
							GROUP BY category");
	 return $query->result();
}

public function getBeban($tglawal,$tglakhir){
	 $this->db->query("SET @tgl1='$tglawal'");
	 $this->db->query("SET @tgl2='$tglakhir'");
	 $query=$this->db->query("SELECT cat.nama,qty,SUM(subtotal) total
							FROM `v_trx_belilain` tb
							JOIN category_ret cat ON cat.id_category=tb.category
							WHERE category != 2 
							AND tb.tanggal >= DATE_FORMAT(@tgl1,'%Y-%m-%d') 
							AND tanggal <= DATE_FORMAT(@tgl2,'%Y-%m-%d')
							GROUP BY category");
	 return $query->result();
}

public function getneracasaldo($tglawal,$tglakhir){
	 $this->db->query("SET @tgl1='$tglawal'");
	 $this->db->query("SET @tgl2='$tglakhir'");
	 $query=$this->db->query("SELECT nama,jns,tb.* FROM (
	SELECT category,SUM(subtotal) total,tanggal FROM (
		SELECT category,subtotal,tanggal FROM v_trx_belilain
		UNION ALL
		SELECT category,salary,tanggal FROM tb_gaji
		UNION ALL
		SELECT 7,sub_total,tgl_penjualan FROM v_trx_penjualan
		UNION ALL
		SELECT 8,harga_total,tgl_pembelian FROM v_trx_pembelian
	) a
	WHERE tanggal >= DATE_FORMAT(@tgl1,'%Y-%m-%d') AND tanggal <= DATE_FORMAT(@tgl2,'%Y-%m-%d')
	GROUP BY category 
) tb
JOIN category_ret cat ON cat.id_category=tb.category

UNION ALL
SELECT nama,jns,tb1.* FROM (
	SELECT category,SUM(subtotal) total,tanggal FROM (
		SELECT category,subtotal,tanggal FROM v_trx_belilain
		UNION ALL
		SELECT 9,(harga_beli*stok) harga_total,tgl_pembelian FROM v_trx_pembelian

	) b
	#WHERE tanggal >= DATE_FORMAT(@tgl1,'%Y-%m-%d') AND tanggal <= DATE_FORMAT(@tgl2,'%Y-%m-%d')
	WHERE category=9
	GROUP BY category 
) tb1
JOIN category_ret cat ON cat.id_category=tb1.category


UNION ALL
SELECT * FROM (
	SELECT nama,jns,category,nominal,tanggal FROM tb_modal tb 
	JOIN category_ret cat ON cat.id_category=tb.category
	ORDER BY tanggal DESC LIMIT 1
) tb2

UNION ALL
SELECT nama,jns,tb3.* FROM (
	SELECT category,SUM(subtotal) total,tanggal FROM (
		SELECT category,subtotal,tanggal FROM v_trx_belilain
		UNION ALL
		SELECT 12,DC,tgl_penjualan FROM v_trx_dckm
		UNION ALL
		SELECT 11,DCKM,tgl_penjualan FROM v_trx_dckm
	) c
	WHERE category = 11 OR category = 12 
        AND tanggal >= DATE_FORMAT(@tgl1,'%Y-%m-%d') AND tanggal <= DATE_FORMAT(@tgl2,'%Y-%m-%d')
	GROUP BY category 
) tb3
JOIN category_ret cat ON cat.id_category=tb3.category
ORDER BY jns DESC");

	  return $query->result();
} 

public function getneracasaldotot($tglawal,$tglakhir){
	 $this->db->query("SET @tgl1='$tglawal'");
	 $this->db->query("SET @tgl2='$tglakhir'");
	 $query=$this->db->query("SELECT jns,SUM(total) total  FROM (
						SELECT nama,jns,tb.* FROM (
							SELECT category,SUM(subtotal) total,tanggal FROM (
								SELECT category,subtotal,tanggal FROM v_trx_belilain
								UNION ALL
								SELECT category,salary,tanggal FROM tb_gaji
								UNION ALL
								SELECT 7,sub_total,tgl_penjualan FROM v_trx_penjualan
								UNION ALL
								SELECT 8,harga_total,tgl_pembelian FROM v_trx_pembelian
							) a
							WHERE tanggal >= DATE_FORMAT(@tgl1,'%Y-%m-%d') AND tanggal <= DATE_FORMAT(@tgl2,'%Y-%m-%d')
							GROUP BY category 
						) tb
						JOIN category_ret cat ON cat.id_category=tb.category
						
						UNION ALL
						SELECT nama,jns,tb1.* FROM (
						SELECT category,SUM(subtotal) total,tanggal FROM (
							SELECT category,subtotal,tanggal FROM v_trx_belilain
							UNION ALL
							SELECT 9,(harga_beli*stok) harga_total,tgl_pembelian FROM v_trx_pembelian

						) b
						WHERE tanggal >= DATE_FORMAT(@tgl1,'%Y-%m-%d') AND tanggal <= DATE_FORMAT(@tgl2,'%Y-%m-%d')
						AND category=9
						GROUP BY category 
					   ) tb1
					   JOIN category_ret cat ON cat.id_category=tb1.category


						UNION ALL
						SELECT * FROM (
							SELECT nama,jns,category,nominal,tanggal FROM tb_modal tb 
							JOIN category_ret cat ON cat.id_category=tb.category
							ORDER BY tanggal DESC LIMIT 1
						) tb2
						UNION ALL
						SELECT nama,jns,tb3.* FROM (
							SELECT category,SUM(subtotal) total,tanggal FROM (
								SELECT category,subtotal,tanggal FROM v_trx_belilain
								UNION ALL
								SELECT 12,DC,tgl_penjualan FROM v_trx_dckm
								UNION ALL
								SELECT 11,DCKM,tgl_penjualan FROM v_trx_dckm
							) c
							WHERE category = 11 OR category = 12 
						        AND tanggal >= DATE_FORMAT(@tgl1,'%Y-%m-%d') AND tanggal <= DATE_FORMAT(@tgl2,'%Y-%m-%d')
							GROUP BY category 
						) tb3
						JOIN category_ret cat ON cat.id_category=tb3.category
						) b
						GROUP BY jns");
	 return $query;
}
public function labarugi($tglawal,$tglakhir){
	 $this->db->query("SET @tgl1='$tglawal'");
	 $this->db->query("SET @tgl2='$tglakhir'");
	 $query=$this->db->query("SELECT nama,jns,tb.* FROM (
	SELECT category,SUM(subtotal) total,tanggal FROM (
		SELECT category,subtotal,tanggal FROM v_trx_belilain
		UNION ALL
		SELECT category,salary,tanggal FROM tb_gaji
	) a
	WHERE tanggal >= DATE_FORMAT(@tgl1,'%Y-%m-%d') AND tanggal <= DATE_FORMAT(@tgl2,'%Y-%m-%d')
	AND category !=2
	GROUP BY category 
) tb
JOIN category_ret cat ON cat.id_category=tb.category
UNION ALL
SELECT nama,jns,tb1.* FROM (
	SELECT category,SUM(subtotal) total,tanggal FROM  (
		SELECT category,subtotal,tanggal FROM v_trx_belilain
		UNION ALL
		SELECT 10,laba,tgl_penjualan FROM v_trx_penjualan
	) b
	WHERE tanggal >= DATE_FORMAT(@tgl1,'%Y-%m-%d') AND tanggal <= DATE_FORMAT(@tgl2,'%Y-%m-%d')
	AND category=10
	GROUP BY category 
) tb1
JOIN category_ret cat ON cat.id_category=tb1.category
ORDER BY jns DESC");
	 return $query;	 
}

public function getTotalLabaRugi($tglawal,$tglakhir){
	 $this->db->query("SET @tgl1='$tglawal'");
	 $this->db->query("SET @tgl2='$tglakhir'");
	 $query=$this->db->query("SELECT jns,SUM(total) total  FROM (
SELECT nama,jns,tb.* FROM (
	SELECT category,SUM(subtotal) total,tanggal FROM (
		SELECT category,subtotal,tanggal FROM v_trx_belilain
		UNION ALL
		SELECT category,salary,tanggal FROM tb_gaji
	) a
	WHERE tanggal >= DATE_FORMAT(@tgl1,'%Y-%m-%d') AND tanggal <= DATE_FORMAT(@tgl2,'%Y-%m-%d')
	AND category !=2
	GROUP BY category 
) tb
JOIN category_ret cat ON cat.id_category=tb.category
UNION ALL
SELECT nama,jns,tb1.* FROM (
	SELECT category,SUM(subtotal) total,tanggal FROM  (
		SELECT category,subtotal,tanggal FROM v_trx_belilain
		UNION ALL
		SELECT 10,laba,tgl_penjualan FROM v_trx_penjualan
	) b
	WHERE tanggal >= DATE_FORMAT(@tgl1,'%Y-%m-%d') AND tanggal <= DATE_FORMAT(@tgl2,'%Y-%m-%d')
	AND category=10
	GROUP BY category 
) tb1
JOIN category_ret cat ON cat.id_category=tb1.category
) b
GROUP BY jns");
	 return $query;	

}

/*
//masuk neraca saldo sebagai beban
SET @tgl1='2016-06-18';
SET @tgl2='2016-06-24';

SELECT cat.nama,qty,SUM(subtotal) total
FROM `v_trx_belilain` tb
JOIN category_ret cat ON cat.id_category=tb.category
WHERE category != 2 AND tb.tanggal >= DATE_FORMAT(@tgl1,'%Y-%m-%d') AND tanggal <= DATE_FORMAT(@tgl2,'%Y-%m-%d')
GROUP BY category 
			
*/
//-------------------------------------------------------------


/*
SET @tgl1='2016-06-16';
SET @tgl2='2016-06-24';

SELECT nama,jns,tb.* FROM (
	SELECT category,SUM(subtotal) total,tanggal FROM (
		SELECT category,subtotal,tanggal FROM v_trx_belilain
		UNION ALL
		SELECT category,salary,tanggal FROM tb_gaji
		UNION ALL
		SELECT 7,sub_total,tgl_penjualan FROM v_trx_penjualan
		UNION ALL
		SELECT 8,harga_total,tgl_pembelian FROM v_trx_pembelian
	) a
	WHERE tanggal >= DATE_FORMAT(@tgl1,'%Y-%m-%d') AND tanggal <= DATE_FORMAT(@tgl2,'%Y-%m-%d')
	GROUP BY category 
) tb
JOIN category_ret cat ON cat.id_category=tb.category
UNION ALL
SELECT * FROM (
	SELECT nama,jns,category,nominal,tanggal FROM tb_modal tb 
	JOIN category_ret cat ON cat.id_category=tb.category
	ORDER BY tanggal DESC LIMIT 1
) tb2
ORDER BY category ASC

#--------------------------------------------------------------------------------------------------

SELECT jns,SUM(total) total  FROM (
	SELECT nama,jns,tb.* FROM (
		SELECT category,SUM(subtotal) total,tanggal FROM (
			SELECT category,subtotal,tanggal FROM v_trx_belilain
			UNION ALL
			SELECT category,salary,tanggal FROM tb_gaji
			UNION ALL
			SELECT 7,sub_total,tgl_penjualan FROM v_trx_penjualan
			UNION ALL
			SELECT 8,harga_total,tgl_pembelian FROM v_trx_pembelian
		) a
		WHERE tanggal >= DATE_FORMAT(@tgl1,'%Y-%m-%d') AND tanggal <= DATE_FORMAT(@tgl2,'%Y-%m-%d')
		GROUP BY category 
	) tb
	JOIN category_ret cat ON cat.id_category=tb.category
	UNION ALL
	SELECT * FROM (
		SELECT nama,jns,category,nominal,tanggal FROM tb_modal tb 
		JOIN category_ret cat ON cat.id_category=tb.category
		ORDER BY tanggal DESC LIMIT 1
	) tb2
) b
GROUP BY jns

								
*/
//stok asset
/*
SET @tgl1='2016-06-18';
SET @tgl2='2016-06-24';

SELECT nama_produk,qty,stok,harga_beli,(harga_beli*stok) AS total
FROM v_trx_pembelian
WHERE stok !=0
AND tgl_pembelian >= DATE_FORMAT(@tgl1,'%Y-%m-%d') AND tgl_pembelian <= DATE_FORMAT(@tgl2,'%Y-%m-%d')
GROUP BY kode_produk
UNION ALL
SELECT 'TOTAL','',SUM(stok) allitem,'',SUM(harga_beli*stok) AS total
FROM `v_trx_pembelian`
WHERE stok !=0
AND tgl_pembelian >= DATE_FORMAT(@tgl1,'%Y-%m-%d') AND tgl_pembelian <= DATE_FORMAT(@tgl2,'%Y-%m-%d')


*/
}