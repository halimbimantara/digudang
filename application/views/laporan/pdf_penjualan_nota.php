<?php
class PDF extends FPDF
{
	//Page header
	function Header()
	{
                $this->setFont('Arial','',10);
                $this->setFillColor(255,255,255);
                $this->cell(100,6,"Laporan Penjualan periode ".$_SESSION['LPtgl_awal']." s/d ".$_SESSION['LPtgl_akhir'],0,0,'L',1); 
                $this->cell(100,6,"Printed date : " . date('d/m/Y'),0,1,'R',1); 
                // $this->Image(base_url().'assets/dist/img/user7-128x128.jpg', 10, 25,'20','20','jpeg');
                
                $this->Ln(5);
                $this->setFont('Arial','',14);
                $this->setFillColor(255,255,255);
                $this->cell(80,6,'',0,0,'C',0); 
                $this->cell(10,6,'DIGUDANG ',0,1,'L',1); 

                $this->cell(44,6,'',0,0,'C',0); 
                $this->cell(100,6,'Laporan Penjualan',0,1,'C',1); 
                $this->Ln(6);
                $this->setFont('Arial','',10);
                $this->setFillColor('230,230,220');

                $this->cell(24,6,'',0,0,'C',0); 
                $this->cell(7,6,'No.',1,0,'C',1);
                $this->cell(18,6,'Tanggal',1,0,'C',1);
                $this->cell(15,6,'Nota',1,0,'C',1);
                $this->cell(25,6,'Total Nota',1,0,'C',1);
                $this->cell(22,6,'Keuntungan',1,0,'C',1);
                $this->cell(20,6,'Sc',1,0,'C',1);
                $this->cell(20,6,'Dc',1,0,'C',1);
                $this->cell(20,6,'Dckm',1,1,'C',1);
                
	}
 
	function Content($data)
	{
            $ya = 46;
            $rw = 7;
            $no = 1;
                foreach ($data->result() as $key) {
                    
                    $totalPenjualan=($key->total+$key->SC+$key->DC+$key->DCKM);
                        $this->setFont('Arial','',9);
                        $this->setFillColor(255,255,255);
                        $this->cell(24,5,'',0,0,'C',0); 
                        $this->cell(7,5,$no,1,0,'C',1);
                        $this->cell(18,5,$key->tanggal,1,0,'C',1);
                        $this->cell(15,5,$key->no_nota,1,0,'C',1);
                        $this->cell(25,5,number_format($totalPenjualan, 0 ,'' , '.' ),1,0,'R',1);
                        $this->cell(22,5,number_format($key->laba, 0 ,'' , '.' ),1,0,'R',1);
                        $this->cell(20,5,$key->SC,1,0,'C',1);
                        $this->cell(20,5,$key->DC,1,0,'C',1);
                        $this->cell(20,5,$key->DCKM,1,0,'C',1);
                        $this->Ln();
                        $ya = $ya + $rw;
                        $no++;
                }
                $this->setFont('Arial','',9);            
                $this->cell(24,5,'',0,0,'C',0); 
                $this->cell(40,5,'Jumlah',1,0,'C',1);
                $this->cell(25,5,number_format($_SESSION['LPtotal'], 0 ,'' , '.' ),1,0,'R',1);
                $this->cell(22,5,number_format($_SESSION['LPlaba'], 0 ,'' , '.' ),1,0,'R',1);
                $this->cell(20,5,number_format($_SESSION['LPSC'], 0 ,'' , '.' ),1,0,'R',1);
                $this->cell(20,5,number_format($_SESSION['LPDC'], 0 ,'' , '.' ),1,0,'R',1);
                $this->cell(20,5,number_format($_SESSION['LPDCKM'], 0 ,'' , '.' ),1,0,'R',1);
                $this->Ln();

                $totalscdc=$_SESSION['LPSC']+$_SESSION['LPDC']+$_SESSION['LPDCKM'];
                $totalAkhir=$_SESSION['LPtotal']-$totalscdc;
                $totalAll=$_SESSION['LPlaba']+$_SESSION['LPtotal']+$totalscdc;
                
                $this->cell(24,5,'',0,0,'C',0); 
                $this->cell(107,5,'Total Penjualan',1,0,'R',1);
                $this->cell(40,5,number_format( $totalAkhir, 0 ,'' , '.' ),1,0,'R',1);
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