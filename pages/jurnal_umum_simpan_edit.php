<?php 
session_start();
error_reporting(3);
include "../koneksi.php";

$jumlah=str_replace(".", "", $_POST[jumlah]);
$hpp=str_replace(".", "", $_POST[hpp]);
$tgl = date("Y-m-d", strtotime($_POST[tgljurnal]));

$idakun = $_POST['akun'];
$idjurnal = $_POST['idjurnal'];
$jumlah_akun = count($idjurnal);
//$debet = str_replace(".", "", $_POST['nilaidd']);
//$kredit = str_replace(".", "", $_POST['nilaikk']);
$debet = $_POST['nilaidd'];
$kredit = $_POST['nilaikk'];

for($x=0;$x<=$jumlah_akun;$x++){
	
	mysqli_query($con,"update tabel_jurnal set  
		debet='$debet[$x]', kredit='$kredit[$x]', tgl_jurnal='$tgl' where id_jurnal='$idjurnal[$x]'");	
}

echo"Transaksi Jurnal berhasil diedit"; 

?>