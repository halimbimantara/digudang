<?php
class PDF extends FPDF
{

   
	//Page header
	function Header()
	{

                $this->setFont('Arial','',10);
                $this->setFillColor(255,255,255);
                $this->cell(100,6,"Laporan Cost Delivery periode ".$_SESSION['tgl_awal']." s/d ".$_SESSION['tgl_akhir'],0,0,'L',1); 
                $this->cell(100,6,"Printed date : ".date('d/m/Y'),0,1,'R',1); 
                // $this->Image(base_url().'assets/dist/img/user7-128x128.jpg', 10, 25,'20','20','jpeg');
                
                $this->Ln(5);
                $this->setFont('Arial','',14);
                $this->setFillColor(255,255,255);
                $this->cell(80,6,'',0,0,'C',0); 
                $this->cell(10,6,'DIGUDANG ',0,1,'L',1); 

                $this->cell(44,6,'',0,0,'C',0); 
                $this->cell(100,6,'Laporan Cost Delivery',0,1,'C',1); 
                // $this->cell(25,6,'',0,0,'C',0); 
                // $this->cell(100,6,'Jl.Jend. Ahmad Yani No 87 Kediri',0,1,'L',1); 
                
                
                $this->Ln(6);
                $this->setFont('Arial','',10);
                $this->setFillColor('230,230,220');
                // $this->cell(10,6,'',0,0,'C',0); 
                $this->cell(10,6,'No.',1,0,'C',1);
                $this->cell(25,6,'Tanggal',1,0,'C',1);
                $this->cell(25,6,'No Nota',1,0,'C',1);
                $this->cell(35,6,'Nama Petugas',1,0,'C',1);
                $this->cell(20,6,'SC',1,0,'C',1);
                $this->cell(20,6,'DC',1,0,'C',1);
                $this->cell(20,6,'DCKM',1,0,'C',1);
                $this->cell(25,6,'Total',1,1,'C',1);
                
                
	}
 
	function Content($data)
	{
            $ya = 46;
            $rw = 6;
            $no = 1;
                foreach ($data->result() as $key) {
                        $this->setFont('Arial','',10);
                        $this->setFillColor(255,255,255);

                        // $this->cell(10,6,'',0,0,'C',0);
                        $this->cell(10,10,$no,1,0,'L',1);
                        $this->cell(25,10,$key->tanggal,1,0,'L',1);
                        $this->cell(25,10,$key->no_nota,1,0,'L',1);
                        $this->cell(35,10,$key->nama_petugas,1,0,'L',1);
                        $this->cell(20,10,$key->SC,1,0,'L',1);
                        $this->cell(20,10,$key->DC,1,0,'L',1);
                        $this->cell(20,10,$key->DCKM,1,0,'L',1);
                        $this->cell(25,10,$key->Total,1,0,'L',1);
                        $this->Ln();
                        // $this->cell(50,10,$key->kelamin,1,1,'L',1);
                        $ya = $ya + $rw;
                        $no++;
                }    
                // $this->cell(10,6,'',0,0,'C',0);         
                // $this->cell(123,5,'Total',1,0,'C',1);
                // $this->cell(20,5,$_SESSION['TOTAL'],1,0,'C',1);
	}
	function Footer()
	{
        // $this->cell(100,6,$tglawal,0,0,'L',1); 
		//atur posisi 1.5 cm dari bawah
		$this->SetY(-15);
		//buat garis horizontal
		$this->Line(10,$this->GetY(),210,$this->GetY());
		//Arial italic 9
		$this->SetFont('Arial','I',9);
       
        $this->Cell(0,10,'Copyright DIGUDANG STORE & Delivery ' . date('Y'),0,0,'L');
		//nomor halaman
		$this->Cell(0,10,'Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
	}
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($data);
$pdf->Output();