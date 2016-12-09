<?php
class PDF extends FPDF
{
	//Page header
	function Header()
	{
                $this->setFont('Arial','',10);
                $this->setFillColor(255,255,255);
                $this->cell(100,6,"Laporan Stok periode ".$_SESSION['tgl_awal']." s/d ".$_SESSION['tgl_akhir'],0,0,'L',1); 
                $this->cell(100,6,"Printed date : " . date('d/m/Y'),0,1,'R',1); 
                // $this->Image(base_url().'assets/dist/img/user7-128x128.jpg', 10, 25,'20','20','jpeg');
                
                $this->Ln(5);
                $this->setFont('Arial','',14);
                $this->setFillColor(255,255,255);
                $this->cell(80,6,'',0,0,'C',0); 
                $this->cell(10,6,'DIGUDANG ',0,1,'L',1); 

                $this->cell(44,6,'',0,0,'C',0); 
                $this->cell(100,6,'Laporan Stok',0,1,'C',1); 
                // $this->cell(25,6,'',0,0,'C',0); 
                // $this->cell(100,6,'Jl.Jend. Ahmad Yani No 87 Kediri',0,1,'L',1); 
                
                
                $this->Ln(6);
                $this->setFont('Arial','',10);
                $this->setFillColor('230,230,220');
                $this->cell(15,10,'',0,0,'C',0); 
                $this->cell(7,10,'No.',1,0,'C',1);
                $this->cell(50,10,'KOMODITI',1,0,'C',1);
                $this->cell(25,10,'HARGA JUAL',1,0,'C',1);
                $this->cell(20,10,'SUBJUAL',1,0,'C',1);
                $this->cell(12,10,'AWAL',1,0,'C',1);
                $this->cell(12,10,'BELI',1,0,'C',1);
                $this->cell(12,10,'JUAL',1,0,'C',1);
                $this->cell(12,10,'AKHIR',1,0,'C',1);
                $this->cell(12,10,'PAKET',1,1,'C',1);
                
	}
 
	function Content($data)
	{
            $ya = 46;
            $rw = 9;
            $no = 1;
                foreach ($data->result() as $key) {
                        $this->setFont('Arial','',9);
                        $this->setFillColor(255,255,255);
                        $this->cell(15,10,'',0,0,'C',0); 
                        $this->cell(7,10,$no,1,0,'L',1);
                        // $this->cell(18,10,$key->tgl_pembelian,1,0,'L',1);
                        $this->cell(50,10,$key->nama_produk,1,0,'L',1);
                        $this->cell(25,10,number_format(doubleval($key->harga_jual), 0 ,'' , '.' ),1,0,'L',1);
                        $this->cell(20,10,number_format(doubleval($key->subjual), 0 ,'' , '.' ),1,0,'L',1);
                        $this->cell(12,10,$key->awal,1,0,'C',1);
                        $this->cell(12,10,$key->beli,1,0,'C',1);
                        $this->cell(12,10,$key->jual,1,0,'C',1);
                        $this->cell(12,10,$key->akhir,1,0,'C',1);
                        $this->cell(12,10,$key->paket,1,0,'C',1);
                        $this->Ln();
                        $ya = $ya + $rw;
                        $no++;
                }            
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