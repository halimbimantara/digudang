<!DOCTYPE html>
<html>
<body>

<style type="text/css">

body{
      width:80mm;
      height: inherit;
} 
td{
  font-size: 8pt;
}

td-h{
   text-align: center;     
    }
.footer{
  font-size: 6pt;
}
</style>

<script>
myFunction();
function myFunction() {
    window.print();
}
</script>

<?php  $tgl_now=date('Y-m-d'); ?>
<p><b>Nota Pembelian</b></p>
<table border="0" width="100%">
  <tr>
    <td width="3%"><b>DIGUDANG Store & Delivery</b></td>
    <td width="2%"><b>Delivery :</b></td>
  </tr>
  <tr>
    <td width="2%">Jl.Jend Ahmad Yani No 87</td>
    <td width="2%">0354-683571</td> 
  </tr>
  <tr>
    <td width="2%">Kediri</td>
    <td >WA: 0888-999-2222</td> 
  </tr>
  <tr>
    <td width="2%"><?php echo $data->row()->tanggal; ?></td>
    <td></td> 
  </tr>
  <tr>
    <td width="2%">No Nota <?php echo $data->row()->no_nota; ?> </td>
  </tr>
</table>
  <div>
  <table border="0" width="90%">
   <tr>
   ----------------------------------------------------
  </tr>
  
  <?php foreach ($data->result() as $row) { ?>
  <tr>
  	<td align="left"> <?php   echo $row->total_qty; ?></td>
  	<td align="left"> <?php   echo $row->nama_produk; ?></td>
  	<td align="center"><?php echo number_format($row->hbeli, 0 ,'' , '.' ); ?></td>
    <td align="center"><?php echo $row->bonus; ?></td>
  	<td align="right"><?php  echo number_format($row->total, 0 ,'' , '.' ); ?></td>
  </tr>
  <?php } ?>

  </table>
  <table width="80%">
  <tr>
    -----------------------------------------------------
  	<td align="left"></td>
  	<td align="right">Total</td>
    
  	<td align="right"><?php echo number_format($totalnota->row()->total, 0 ,'' , '.' ); ?></td>

  </tr>

  <?php
  $total_B=doubleval($balance)+doubleval($totalnota->row()->total);
    
    if ($balance != 0) {
    echo '<td align="left">Balance</td>
    <td align="right">'.$balance.'</td>
    <td align="right"></td>
    <td align="left">'.number_format($total_B, 0 ,'' , '.' ).'</td>';
      }
  ?>

  <?php
    
    if ($ut != 0) {
    echo '<tr><td align="left">Menggunakan Uang Toko</td>
    <td align="right"></td><tr>';
      }
  ?>
    <!-- <td align="left">Menggunakan Uang Toko</td>
    <td align="right"><?php  ?></td>
     <td align="left"></td> -->
  <tr>

  </tr>
  </table>
  </div>

   <div class="total">
  <table border="0" width="80%">
   <tr>
   ------------------------------------------------------
  <td align="left">Kasir   : <?php echo $data->row()->petugas; ?></td>
  </tr>
  </table>
  </div>
  <div class="footer">
  <p></p>
  	<center><b>STRUK SEBAGAI BUKTI DATA SUDAH DI MASUKAN</b></center>
    <table border="0" width="100%">
    <td align="left"></td>
    <td align="center"><b>"UTAMAKAN PELAYANAN"</b></td>
  	<td align="right"></td>
 	</table>
 </div>

</body>
</html>
