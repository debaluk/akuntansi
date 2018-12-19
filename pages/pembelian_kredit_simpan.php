<?php 
session_start();
error_reporting(3);
include "../koneksi.php";

$saldok=str_replace(".", "", $_POST[jumlahbeli]);
$tgl = date("Y-m-d", strtotime($_POST[tglbeli]));

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
	nomor_jurnal='-',
	nomor_faktur='-',
	referensi='$_POST[kdsp]',
	keterangan='Saldo Awal',
	id_akun='39',
	debet='0',
	kredit='$saldok', nama_user='$_SESSION[username]' where id_jurnal='$idjurnal'");
	
	
	
	echo"Update data supplier berhasil";
}
else {
	
	//cari nomor faktur sama
	$nomorfaktur=mysqli_query($con,"select * from tabel_jurnal where nomor_faktur='$_POST[faktur]'");
	if (mysqli_num_rows($nomorfaktur) > 0)
	{
		echo"Nomor faktur sudah ada, silahkan diganti"; 
	}
	else
	{
		mysqli_query($con,"insert into tabel_jurnal set  
		tgl_jurnal='$tgl',
		nomor_jurnal='$_POST[nojurnal]',
		nomor_faktur='$_POST[faktur]',
		referensi='$_POST[kdsp]',
		keterangan='Pembelian Kredit',
		id_akun='35',
		debet='$saldok',
		kredit='0'");
		
		mysqli_query($con,"insert into tabel_jurnal set  
		tgl_jurnal='$tgl',
		nomor_jurnal='$_POST[nojurnal]',
		nomor_faktur='$_POST[faktur]',
		referensi='$_POST[kdsp]',
		keterangan='Pembelian Kredit',
		id_akun='39',
		debet='0',
		kredit='$saldok', nama_user='$_SESSION[username]'");
		
		
		echo"Tambah data pembelian kredit berhasil"; 
	}

	
}
?>