<?php
class PDF extends FPDF
{

   
	//Page header
	function Header()
	{

                $this->setFont('Arial','',10);
                $this->setFillColor(255,255,255);
                $this->cell(100,6,"Laporan Pembelian periode ".$_SESSION['tgl_awal']." s/d ".$_SESSION['tgl_akhir'],0,0,'L',1); 
                $this->cell(100,6,"Printed date : ".date('d/m/Y'),0,1,'R',1); 
                // $this->Image(base_url().'assets/dist/img/user7-128x128.jpg', 10, 25,'20','20','jpeg');
                
                $this->Ln(5);
                $this->setFont('Arial','',14);
                $this->setFillColor(255,255,255);
                $this->cell(80,6,'',0,0,'C',0); 
                $this->cell(10,6,'DIGUDANG ',0,1,'L',1); 

                $this->cell(44,6,'',0,0,'C',0); 
                $this->cell(100,6,'Laporan Pembelian Lain-Lain',0,1,'C',1); 
                // $this->cell(25,6,'',0,0,'C',0); 
                // $this->cell(100,6,'Jl.Jend. Ahmad Yani No 87 Kediri',0,1,'L',1); 
                
                
                $this->Ln(6);
                $this->setFont('Arial','',12);
                $this->setFillColor('230,230,220');
                $this->cell(5,6,'',0,0,'C',0); 
                $this->cell(10,6,'No.',1,0,'C',1);
                $this->cell(25,6,'Tanggal',1,0,'C',1);
                $this->cell(25,6,'No Nota',1,0,'C',1);
                $this->cell(80,6,'Keterangan',1,0,'C',1);
                $this->cell(18,6,'Nominal',1,0,'C',1);
                $this->cell(10,6,'Qty',1,0,'C',1);
                $this->cell(20,6,'Sub Total',1,1,'C',1);
                
                
	}
 
	function Content($data,$total)
	{
            $ya = 46;
            $rw = 6;
            $no = 1;
                foreach ($data->result() as $key) {
                        $this->setFont('Arial','',10);
                        $this->setFillColor(255,255,255);

                        $this->cell(5,6,'',0,0,'C',0);
                        $this->cell(10,10,$no,1,0,'L',1);
                        $this->cell(25,10,$key->tanggal,1,0,'L',1);
                        $this->cell(25,10,$key->no_nota,1,0,'L',1);
                        $this->cell(80,10,$key->nama_barang,1,0,'L',1);
                        $this->cell(18,10,number_format($key->hbeli, 0 ,'' , '.' ),1,0,'R',1);
                        $this->cell(10,10,$key->qty,1,0,'L',1);
                        $this->cell(20,10,number_format($key->total, 0 ,'' , '.' ),1,0,'R',1);
                        $this->Ln();
                        $ya = $ya + $rw;
                        $no++;
                }    
                $this->cell(5,6,'',0,0,'C',0);         
                $this->cell(168,5,'Total',1,0,'C',1);
                $this->cell(20,5,$total,1,0,'R',1);
                $this->Ln(5);

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
$pdf->Content($data,$total);
$pdf->Output();
