<?php
class PDF extends FPDF
{
	//Page header
	function Header()
	{
                $this->setFont('Arial','',10);
                $this->setFillColor(255,255,255);
                $this->cell(100,6,"Neraca  Laporan ".$_SESSION['tgl_awal']." s/d ".$_SESSION['tgl_akhir'],0,0,'L',1); 
                $this->cell(100,6,"Printed date : " . date('d/m/Y'),0,1,'R',1); 
                // $this->Image(base_url().'assets/dist/img/user7-128x128.jpg', 10, 25,'20','20','jpeg');
                
                $this->Ln(5);
                $this->setFont('Arial','',14);
                $this->setFillColor(255,255,255);
                $this->cell(80,6,'',0,0,'C',0); 
                $this->cell(10,6,'DIGUDANG ',0,1,'L',1); 

                $this->cell(44,6,'',0,0,'C',0); 
                $this->cell(100,6,'NERACA SALDO',0,1,'C',1);
                
                
                $this->Ln(6);
                $this->cell(27,6,'',0,0,'C',0);
                $this->setFont('Arial','',10);
                $this->setFillColor('230,230,220');
                $this->cell(10,6,'No.',1,0,'C',1);
                $this->cell(80,6,'Akun',1,0,'C',1);
                $this->cell(35,6,'Debit',1,0,'C',1);
                $this->cell(35,6,'Kredit',1,1,'C',1);
                
	}
 
	function Content($data,$total)
	{
            $ya = 46;
            $rw = 4;
            $no = 1;
                foreach ($data as $key) {
                      
                        $this->setFont('Arial','',10);
                        $this->setFillColor(255,255,255);
                        $this->cell(27,6,'',0,0,'C',0); 
                        $this->cell(10,10,$no,1,0,'L',1);
                        $this->cell(80,10,$key->nama,1,0,'L',1);
                        if ($key->jns == 'debet') {
                        $this->cell(35,10,number_format($key->total, 0 ,'' , '.' ),1,0,'R',1);
                        $this->cell(35,10,'-',1,0,'C',1);
                        }else{
                        $this->cell(35,10,'-',1,0,'C',1);
                        $this->cell(35,10,number_format($key->total, 0 ,'' , '.' ),1,0,'R',1);
                        }

                        $this->Ln();
                        $ya = $ya + $rw;
                        $no++;
                } 

                 
                $this->cell(27,6,'',0,0,'C',0); 
                $this->cell(90,5,'Total',1,0,'C',1);

                $debet=$total->row(0)->total;
                $kredit=$total->row(1)->total;  
                $this->cell(35,5,number_format($debet, 0 ,'' , '.' ),1,0,'R',1);
                $this->cell(35,5,number_format($kredit, 0 ,'' , '.' ),1,0,'R',1);
             // }
                // $row = $query->row(0, 'User');
               
               
	}
	function Footer()
	{
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