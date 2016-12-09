<?php
class PDF extends FPDF
{

   
	//Page header
	function Header()
	{
                $this->setFont('Arial','',10);
                $this->setFillColor(255,255,255);
$this->cell(100,6,"Laporan Pembelian & Penjualan ".$_SESSION['tgl_awal']." s/d ".$_SESSION['tgl_akhir'],0,0,'L',1); 
                $this->cell(100,6,"Printed date : ".date('d/m/Y'),0,1,'R',1); 
                // $this->Image(base_url().'assets/dist/img/user7-128x128.jpg', 10, 25,'20','20','jpeg');
                
                $this->Ln(5);
                $this->setFont('Arial','',14);
                $this->setFillColor(255,255,255);
                $this->cell(80,6,'',0,0,'C',0); 
                $this->cell(10,6,'DIGUDANG ',0,1,'L',1); 

                $this->cell(44,6,'',0,0,'C',0); 
                $this->cell(100,6,'Laporan Pembelian Dan Penjualan',0,1,'C',1); 
                // $this->cell(25,6,'',0,0,'C',0); 
                // $this->cell(100,6,'Jl.Jend. Ahmad Yani No 87 Kediri',0,1,'L',1); 
                
                
                $this->Ln(6);
                $this->setFont('Arial','',14);
                $this->cell(44,6,'',0,0,'C',0); 
                $this->cell(100,6,'Laporan Pembelian [Uang Kantor]',0,1,'C',1); 
                $this->setFont('Arial','',12);
                $this->setFillColor('230,230,220');
                $this->cell(5,6,'',0,0,'C',0); 
                $this->cell(10,6,'No.',1,0,'C',1);
                $this->cell(25,6,'Tanggal',1,0,'C',1);
                $this->cell(28,6,'No Nota',1,0,'C',1);
                // $this->cell(50,6,'Komoditi',1,0,'C',1);
                // $this->cell(25,6,'Harga Beli',1,0,'C',1);
                // $this->cell(13,6,'Qty',1,0,'C',1);
                $this->cell(115,6,'Sub Total',1,1,'C',1);
                
	}
 
	function Content($data,$totalpembelian,$totalbalance)
	{
            $ya = 46;
            $rw = 6;
            $no = 1;
                foreach ($data->result() as $key) {
                        $this->setFont('Arial','',11);
                        $this->setFillColor(255,255,255);

                        $this->cell(5,6,'',0,0,'C',0);
                        $this->cell(10,5,$no,1,0,'L',1);
                        $this->cell(25,5,$key->tanggal,1,0,'L',1);
                        $this->cell(28,5,$key->no_nota,1,0,'L',1);
                        // $this->cell(50,5,$key->nama_produk,1,0,'L',1);
                        // $this->cell(25,5,number_format($key->hbeli, 0 ,'' , '.' ),1,0,'L',1);
                        // $this->cell(13,5,$key->qty,1,0,'L',1);
                        $this->cell(115,5,number_format($key->total, 0 ,'' , '.' ),1,0,'R',1);
                        $this->Ln();
                        // $this->cell(50,10,$key->kelamin,1,1,'L',1);
                        $ya = $ya + $rw;
                        $no++;
                }    
                $this->cell(5,6,'',0,0,'C',0);         
                $this->cell(148,5,'Total',1,0,'C',1);
                $this->cell(30,5,number_format($totalpembelian, 0 ,'' , '.' ),1,0,'R',1);
                $this->Ln(5);
                $this->cell(5,6,'',0,0,'C',0);         
                $this->cell(148,5,'Total + Balance',1,0,'R',1);
                $this->cell(30,5,number_format($totalpembelian+$totalbalance, 0 ,'' , '.' ),1,0,'R',1);
                $this->Ln(5);

	}
  //Balance
    // function HeaderBalance(){
    //     $this->Ln(4);
    //     $this->setFont('Arial','',14);
    //     $this->cell(44,6,'',0,0,'C',0); 
    //     $this->cell(100,6,'Laporan Balance Pembelian',0,1,'C',1); 

    //             $this->setFont('Arial','',12);
    //             $this->setFillColor('230,230,220');
    //             $this->cell(50,6,'',0,0,'C',0); 
    //             $this->cell(10,6,'No.',1,0,'C',1);
    //             $this->cell(25,6,'No Nota',1,0,'C',1);
    //             $this->cell(25,6,'Tanggal',1,0,'C',1);
    //             $this->cell(30,6,'Nominal',1,0,'C',1);

    // }

    // function Balance($databalance,$totalbalance)
    // {
    //         $ya = 46;
    //         $rw = 4;
    //         $no = 1;
    //         $this->Ln();
    //             foreach ($databalance->result() as $key) {
    //                     $this->setFont('Arial','',11);
    //                     $this->setFillColor(255,255,255);

    //                     $this->cell(50,6,'',0,0,'C',0);
    //                     $this->cell(10,6,$no,1,0,'L',1);
    //                     $this->cell(25,6,$key->no_nota,1,0,'L',1);
    //                     $this->cell(25,6,$key->tanggal,1,0,'L',1);
    //                     $this->cell(30,6,number_format($key->balance, 0 ,'' , '.' ),1,0,'R',1);
    //                     $this->Ln();
    //                     $ya = $ya + $rw;
    //                     $no++;
    //             }

    //             $this->cell(50,6,'',0,0,'C',0);         
    //             $this->cell(60,5,'Total',1,0,'C',1);
    //             $this->cell(30,5,number_format($totalbalance, 0 ,'' , '.' ),1,0,'R',1);
    //             $this->Ln(5);  
    // }
    //END
    function HeaderPembelian(){
        $this->Ln(4);
         $this->setFont('Arial','',14);
        $this->cell(44,6,'',0,0,'C',0); 
        $this->cell(100,6,'Laporan Pembelian Lain-Lain [Uang Toko]',0,1,'C',1); 

                $this->setFont('Arial','',12);
                $this->setFillColor('230,230,220');
                $this->cell(5,6,'',0,0,'C',0); 
                $this->cell(10,6,'No.',1,0,'C',1);
                $this->cell(25,6,'Tanggal',1,0,'C',1);
                $this->cell(25,6,'No Nota',1,0,'C',1);
                $this->cell(60,6,'Nama Item',1,0,'C',1);
                $this->cell(20,6,'Nominal',1,0,'C',1);
                $this->cell(10,6,'Qty',1,0,'C',1);
                $this->cell(30,6,'Sub Total',1,1,'C',1);
    }

    function Pembelian($databelilain,$totalpembelianlain)
    {
            $ya = 46;
            $rw = 6;
            $no = 1;

                foreach ($databelilain->result() as $key) {
                        $this->setFont('Arial','',11);
                        $this->setFillColor(255,255,255);

                        $this->cell(5,6,'',0,0,'C',0);
                        $this->cell(10,6,$no,1,0,'L',1);
                        $this->cell(25,6,$key->tanggal,1,0,'L',1);
                        $this->cell(25,6,$key->no_nota,1,0,'L',1);
                        $this->cell(60,6,$key->nama_barang,1,0,'L',1);
                        $this->cell(20,6,number_format($key->hbeli, 0 ,'' , '.' ),1,0,'R',1);
                        $this->cell(10,6,$key->qty,1,0,'R',1);
                        $this->cell(30,6,number_format($key->total, 0 ,'' , '.' ),1,0,'R',1);
                        $this->Ln();
                        // $this->cell(50,10,$key->kelamin,1,1,'L',1);
                        $ya = $ya + $rw;
                        $no++;
                }    
                $this->cell(5,6,'',0,0,'C',0);         
                $this->cell(150,5,'Total',1,0,'C',1);
                $this->cell(30,5,number_format($totalpembelianlain, 0 ,'' , '.' ),1,0,'R',1);
                $this->Ln(5);
    }

  

    function HeaderPenjualan(){

                $this->Ln(4);
                $this->setFont('Arial','',14);
                $this->cell(44,6,'',0,0,'C',0); 
                $this->cell(100,6,'Laporan Penjualan',0,1,'C',1); 
                $this->setFont('Arial','',12);
                $this->setFillColor('230,230,220');

                $this->cell(5,6,'',0,0,'C',0); 
                $this->cell(7,6,'No.',1,0,'C',1);
                $this->cell(25,6,'Tanggal',1,0,'C',1);
                $this->cell(15,6,'Nota',1,0,'C',1);
                $this->cell(35,6,'Total Nota',1,0,'C',1);
                $this->cell(35,6,'Keuntungan',1,0,'C',1);
                $this->cell(20,6,'Sc',1,0,'C',1);
                $this->cell(20,6,'Dc',1,0,'C',1);
                $this->cell(20,6,'Dckm',1,1,'C',1);
    }

    function Penjualan($datapenjualan)
    {
            $ya = 46;
            $rw = 7;
            $no = 1;
                foreach ($datapenjualan->result() as $key) {
                    
                    $totalPenjualan=($key->total+$key->SC+$key->DC+$key->DCKM);
                        $this->setFont('Arial','',11);
                        $this->setFillColor(255,255,255);
                        $this->cell(5,5,'',0,0,'C',0); 
                        $this->cell(7,5,$no,1,0,'C',1);
                        $this->cell(25,5,$key->tanggal,1,0,'C',1);
                        $this->cell(15,5,$key->no_nota,1,0,'C',1);
                        $this->cell(35,5,number_format($totalPenjualan, 0 ,'' , '.' ),1,0,'R',1);
                        $this->cell(35,5,number_format($key->laba, 0 ,'' , '.' ),1,0,'R',1);
                        $this->cell(20,5,$key->SC,1,0,'R',1);
                        $this->cell(20,5,$key->DC,1,0,'C',1);
                        $this->cell(20,5,$key->DCKM,1,0,'C',1);
                        $this->Ln();
                        $ya = $ya + $rw;
                        $no++;
                }
                $this->setFont('Arial','',11);            
                $this->cell(5,5,'',0,0,'C',0); 
                $this->cell(47,5,'Jumlah',1,0,'C',1);
                $this->cell(35,5,number_format($_SESSION['total'], 0 ,'' , '.' ),1,0,'R',1);
                $this->cell(35,5,number_format($_SESSION['laba'], 0 ,'' , '.' ),1,0,'R',1);
                $this->cell(20,5,number_format($_SESSION['SC'], 0 ,'' , '.' ),1,0,'R',1);
                $this->cell(20,5,number_format($_SESSION['DC'], 0 ,'' , '.' ),1,0,'R',1);
                $this->cell(20,5,number_format($_SESSION['DCKM'], 0 ,'' , '.' ),1,0,'R',1);
                $this->Ln();
                
                $totalscdc=$_SESSION['SC']+$_SESSION['DC']+$_SESSION['DCKM'];
                $totalAkhir=$_SESSION['total']-$totalscdc;
                $totalAll=$_SESSION['laba']+$_SESSION['total']+$totalscdc;
                
                $this->cell(5,5,'',0,0,'C',0); 
                $this->cell(117,5,'Total Penjualan',1,0,'C',1);
                $this->cell(60,5,number_format($totalAkhir, 0 ,'' , '.' ),1,0,'R',1);
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
$pdf->Content($data,$totalpembelian,$totalbalance);
//balance
// $pdf->HeaderBalance();
// $pdf->Balance($databalance,$totalbalance);
//pembelianlain
$pdf->HeaderPembelian();
$pdf->Pembelian($databelilain,$totalpembelianlain);

//penjualan
$pdf->HeaderPenjualan();
$pdf->Penjualan($datapenjualan);
$pdf->Output();
