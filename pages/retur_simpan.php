<?php 
session_start();
error_reporting(3);
include "../koneksi.php";


$saldok=str_replace(".", "", $_POST[jumlahbayar]);
$tgl = date("Y-m-d", strtotime($_POST[tglbayar]));
	
	mysqli_query($con,"insert into tabel_jurnal set  
	tgl_jurnal='$tgl',
	nomor_jurnal='$_POST[nojurnal]',
	nomor_faktur='$_POST[faktur]',
	referensi='$_POST[kdsp]',
	keterangan='Retur Pembelian',
	id_akun='39',
	debet='$saldok',
	kredit='0', nama_user='$_SESSION[username]'");
	
	mysqli_query($con,"insert into tabel_jurnal set  
	tgl_jurnal='$tgl',
	nomor_jurnal='$_POST[nojurnal]',
	nomor_faktur='$_POST[faktur]',
	referensi='$_POST[kdsp]',
	keterangan='Retur Pembelian',
	id_akun='35',
	debet='0',
	kredit='$saldok', nama_user='$_SESSION[username]'");
	
	
	echo"Retur berhasil disimpan"; 

?>