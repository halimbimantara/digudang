<?php
class PDF extends FPDF
{
	//Page header
	function Header()
	{
                $this->setFont('Arial','',10);
                $this->setFillColor(255,255,255);
                $this->cell(100,6,"Laporan Penjualan periode ".$_SESSION['tgl_awal']." s/d ".$_SESSION['tgl_akhir'],0,0,'L',1); 
                $this->cell(100,6,"Printed date : " . date('d/m/Y'),0,1,'R',1); 
                // $this->Image(base_url().'assets/dist/img/user7-128x128.jpg', 10, 25,'20','20','jpeg');
                
                $this->Ln(5);
                $this->setFont('Arial','',14);
                $this->setFillColor(255,255,255);
                $this->cell(80,6,'',0,0,'C',0); 
                $this->cell(10,6,'DIGUDANG ',0,1,'L',1); 

                $this->cell(44,6,'',0,0,'C',0); 
                $this->cell(100,6,'Laporan Penjualan',0,1,'C',1); 
                // $this->cell(25,6,'',0,0,'C',0); 
                // $this->cell(100,6,'Jl.Jend. Ahmad Yani No 87 Kediri',0,1,'L',1); 
                
                
                $this->Ln(6);
                $this->setFont('Arial','',10);
                $this->setFillColor('230,230,220');
                $this->cell(7,9,'No.',1,0,'C',1);
                 $this->cell(18,9,'Tanggal',1,0,'C',1);
                $this->cell(15,9,'KN',1,0,'C',1);
                $this->cell(35,9,'Nama Barang',1,0,'C',1);
                $this->cell(8,9,'Qty',1,0,'C',1);
                $this->cell(20,9,'Harga Beli',1,0,'C',1);
                $this->cell(22,9,'Keuntungan',1,0,'C',1);
                $this->cell(23,9,'Harga Satuan',1,0,'C',1);
                $this->cell(20,9,'DEBET',1,0,'C',1);
                $this->cell(20,9,'LABA',1,1,'C',1);
                
	}
 
	function Content($data)
	{
            $ya = 46;
            $rw = 9;
            $no = 1;
                foreach ($data->result() as $key) {
                     $keuntungan=$key->hjual-$key->hbeli;
                        $this->setFont('Arial','',9);
                        $this->setFillColor(255,255,255);

                        $this->cell(7,10,$no,1,0,'L',1);
                        $this->cell(18,10,$key->tanggal,1,0,'L',1);
                        $this->cell(15,10,$key->kode_produk,1,0,'L',1);
                        $this->cell(35,10,$key->nama_produk,1,0,'L',1);
                        $this->cell(8,10,$key->qty,1,0,'L',1);
                        $this->cell(20,10,$key->hbeli,1,0,'L',1);
                        $this->cell(22,10,$keuntungan,1,0,'L',1);
                        $this->cell(23,10,$key->hjual,1,0,'L',1);
                        $this->cell(20,10,$key->total,1,0,'L',1);
                        $this->cell(20,10,$key->laba,1,0,'L',1);
                        $this->Ln();
                        $ya = $ya + $rw;
                        $no++;
                }            
                $this->cell(148,5,'Jumlah',1,0,'C',1);
                $this->cell(20,5,'Rp.'.$_SESSION['DEBET'],1,0,'C',1);
                $this->cell(20,5,'Rp.'.$_SESSION['LABA'],1,0,'C',1);
	}
	function Footer()
	{
		//atur posisi 1.5 cm dari bawah
		$this->SetY(-15);
		//buat garis horizontal
		$this->Line(10,$this->GetY(),210,$this->GetY());
		//Arial italic 9
		$this->SetFont('Arial','I',9);
                $this->Cell(0,10,'Copyright DIGUDANG STORE & Delivery ' . date('Y').'              Di Cetak Oleh :'. $_SESSION['uname'],0,0,'L');
		//nomor halaman
		$this->Cell(0,10,'Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
	}
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($data);
$pdf->Output();