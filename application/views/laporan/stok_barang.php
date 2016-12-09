<?php
class PDF extends FPDF
{
	//Page header
	function Header()
	{
                $this->setFont('Arial','',10);
                $this->setFillColor(255,255,255);
                $this->cell(100,6,"Laporan Stok ". date('d/m/Y'),0,0,'L',1); 
                $this->cell(100,6,"Printed date :". date('d/m/Y'),0,1,'R',1); 
                
                $this->Ln(5);
                $this->setFont('Arial','',14);
                $this->setFillColor(255,255,255);
                $this->cell(80,6,'',0,0,'C',0); 
                $this->cell(10,6,'DIGUDANG ',0,1,'L',1); 

                $this->cell(44,6,'',0,0,'C',0); 
                $this->cell(100,6,'Laporan Stok',0,1,'C',1); 
                
                $this->Ln(4);
                $this->setFont('Arial','',9);
                $this->setFillColor('230,230,220');
                $this->cell(27,6,'',0,0,'C',0);
                 
                $this->cell(7,9,'No.',1,0,'C',1);
                $this->cell(80,9,'KOMODITI',1,0,'C',1);
                $this->cell(30,9,'STOK TERSEDIA',1,0,'C',1);
	}
 
	function Content($data)
	{
            $ya = 50;
            $rw = 3;
            $no = 1;
                foreach ($data->result() as $key) {
                        $this->setFont('Arial','',9);
                        $this->setFillColor(255,255,255);
                        $this->cell(27,6,'',0,0,'C',0); 
                        $this->cell(7,7, $no,1,0,'L',1);
                        $this->cell(80,7,$key->nama_produk,1,0,'L',1);
                        $this->cell(30,7,$key->jumlah_stok,1,0,'L',1);
                        

                        $this->Ln();
                        $ya = $ya + $rw;
                        $no++;
                }            
                // $this->cell(148,5,'Jumlah',1,0,'C',1);
                // $this->cell(20,5,'Rp.'.$_SESSION['DEBET'],1,0,'C',1);
                // $this->cell(20,5,'Rp.'.$_SESSION['LABA'],1,0,'C',1);
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