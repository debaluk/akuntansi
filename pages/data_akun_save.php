<?php 
session_start();
error_reporting(3);
include "../koneksi.php";

if ($_POST[saldoawal] > 0)
{
	$saldod=str_replace(".", "", $_POST[saldoawal]);
	$saldok=0;
}
else if ($_POST[saldoawal] < 0) 
{
	$saldod=0;
	$saldok=str_replace(".", "", abs($_POST[saldoawal]));
}
else
{
	$saldod=0;
	$saldok=0;
}

$kodeakun = $_POST[kd].'-'.$_POST[nomorakun];
$tgl = date("Y-m-d", strtotime($_POST[tgl]));



		
if ($_POST[idlama])
{
	
	mysqli_query($con,"update tabel_akun set 
	kode_akun='$kodeakun', 
	nama_akun='$_POST[namaakun]',
	tipe_akun='$_POST[tipe]',
	tanggal_awal='$tgl',
	awal_debet='$saldod',
	awal_kredit='$saldok' where id_akun='$_POST[idlama]'
	");
	
	echo"Update akun berhasil";
}
else {

	//cari kode dan nama
	$cariakun=mysqli_query($con, "select * from tabel_akun where kode_akun='$kodeakun' or nama_akun='$_POST[namaakun]'");
	$hasilcari=mysqli_fetch_array($cariakun);
	if (mysqli_num_rows($cariakun) > 0)
		{
			echo"Cek kembali kode atau nama akun yang sama sudah ada";
		}
	else
	{

			mysqli_query($con,"insert into tabel_akun set 
			kode_akun='$kodeakun', 
			nama_akun='$_POST[namaakun]',
			tipe_akun='$_POST[tipe]',
			tanggal_awal='$tgl',
			awal_debet='$saldod',
			awal_kredit='$saldok'
			");
			
			echo"Tambah Akun berhasi";			
		
	}

}




?>