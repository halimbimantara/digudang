<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporanpenjualan". date('dmY_His').".xls" );
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
header("Pragma: public");

$workbook = new Workbook();
$worksheet1 =& $workbook->add_worksheet(date('dmY_His'));

$header =& $workbook->add_format();
$header->set_color('blue'); // set warna huruf
$header->set_border_color('red'); // set warna border

$header->set_size(14); // Set ukuran font 

$header->set_align("center"); // set align rata tengah

$header->set_top(2); // set ketebalan border bagian atas cell 0 = border tidak tampil
$header->set_bottom(2); // set ketebalan border bagian atas cell 0 = border tidak tampil
$header->set_left(2); // set ketebalan border bagian atas cell 0 = border tidak tampil
$header->set_right(2); // set ketebalan border bagian atas cell 0 = border tidak tampil

$worksheet1->write_string(0,3,'Periode X');  // Set Nama kolom
$worksheet1->write_string(1,0,'Tanggal '.date('d/m/Y').'');  // Set Nama kolom


$worksheet1->merge_cells(1,5,1,6);
$worksheet1->write_string(1,5,'Rp.xxxx');  // Set Nama kolom

$worksheet1->write_string(2,0,'No.',$header);  // Set Nama kolom
$worksheet1->set_column(2,0,5); // Set lebar kolom

$worksheet1->write_string(2,1,'KN',$header);  // Set Nama kolom
$worksheet1->set_column(2,1,18); // Set lebar kolom

$worksheet1->write_string(2,2,'Nama Barang',$header);  // Set Nama kolom
$worksheet1->set_column(2,2,15); // Set lebar kolom

$worksheet1->write_string(2,3,'Qty',$header);  // Set Nama kolom
$worksheet1->set_column(2,3,15); // Set lebar kolom

$worksheet1->write_string(2,4,'Harga Beli',$header);  // Set Nama kolom
$worksheet1->set_column(2,4,15); // Set lebar kolom

$worksheet1->write_string(2,5,'Keuntungan',$header);  // Set Nama kolom
$worksheet1->set_column(2,5,15); // Set lebar kolom

$worksheet1->write_string(2,6,'Harga Satuan',$header);  // Set Nama kolom
$worksheet1->set_column(2,6,15); // Set lebar kolom

$worksheet1->write_string(2,7,'DEBET',$header);  // Set Nama kolom
$worksheet1->set_column(2,7,15); // Set lebar kolom

$worksheet1->write_string(2,8,'LABA',$header);  // Set Nama kolom
$worksheet1->set_column(2,8,15); // Set lebar kolom


$content =& $workbook->add_format();
$content->set_size(11);

$content->set_top(1); // set ketebalan border bagian atas cell 0 = border tidak tampil
$content->set_bottom(1); // set ketebalan border bagian atas cell 0 = border tidak tampil
$content->set_left(1); // set ketebalan border bagian atas cell 0 = border tidak tampil
$content->set_right(1); // set ketebalan border bagian atas cell 0 = border tidak tampil

$row = 3;
$no = 1;

foreach ($data->result() as $key) {
    $keuntungan=$key->hjual-$key->hbeli;
    $worksheet1->write_string($row,0,  $no ,$content);
    $worksheet1->write_string($row,1,  $key->kode_produk ,$content);
    $worksheet1->write_string($row,2,  $key->nama_produk ,$content);
    $worksheet1->write_number($row,3,  $key->qty ,$content);
    $worksheet1->write_number($row,4,  $key->hbeli ,$content);
    $worksheet1->write_number($row,5,  $keuntungan,$content);
    $worksheet1->write_number($row,6,  $key->hjual ,$content);
    $worksheet1->write_number($row,7,  $key->total ,$content);
    $worksheet1->write_number($row,8,  $key->laba ,$content);


	// $worksheet1->set_column(1,6,15); // Set lebar kolom
    $no++;
    $row++;
}
$footer =& $workbook->add_format();
$footer->set_size(12); // Set ukuran font 
$footer->set_align("center"); // set align rata tengah

$worksheet1->write_string($row,6,'Total',$footer);  // Set Nama kolom
$worksheet1->write_formula($row,7,'=SUM(H4:H'.$row.')',$footer);
$worksheet1->write_formula($row,8,'=SUM(I4:I'.$row.')',$footer);

$workbook->close();

/* 
 * Created by Pudyasto Adi Wibowo
 * Email : mr.pudyasto@gmail.com
 */


