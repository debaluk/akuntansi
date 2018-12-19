<?php 
session_start();
error_reporting(3);
include "../koneksi.php";
$nofakturotomatis=rand(0,9999);



$saldok=str_replace(".", "", $_POST[sasp]);
$tgl = date("Y-m-d", strtotime($_POST[tglsp]));

if ($_POST[idlama])
{
	$idjurnal = $_POST[idjurnal];
	
	mysqli_query($con,"update tabel_supplier set  
	nama_supplier='$_POST[nmsp]',
	alamat_supplier='$_POST[almsp]',
	tanggal='$tgl',
	saldo_awal='$saldok',
	telepon_supplier='$_POST[telpsp]' where id_supplier='$_POST[idlama]'");
	
	//update jurnal
	mysqli_query($con,"update tabel_jurnal set  
	tgl_jurnal='$tgl',
	referensi='$_POST[kdsp]',
	keterangan='Saldo Awal',
	id_akun='39',
	debet='0',
	kredit='$saldok' where id_jurnal='$idjurnal'");
	
	echo"Update data supplier berhasil";
}
else {
	mysqli_query($con,"insert into tabel_supplier set  
	kode_supplier='$_POST[kdsp]',
	nama_supplier='$_POST[nmsp]',
	alamat_supplier='$_POST[almsp]',
	tanggal='$tgl',
	saldo_awal='$saldok',
	telepon_supplier='$_POST[telpsp]'");
	
	mysqli_query($con,"insert into tabel_jurnal set  
	tgl_jurnal='$tgl',
	nomor_jurnal='-',
	nomor_faktur='$nofakturotomatis',
	referensi='$_POST[kdsp]',
	keterangan='Saldo Awal',
	id_akun='39',
	debet='0',
	kredit='$saldok'");
	
	echo"Tambah data supplier berhasil"; 
}
?>