<?php 
session_start();
error_reporting(3);
include "../koneksi.php";

$saldok=str_replace(".", "", $_POST[jumlahbayar]);
$sisahutang=str_replace(".", "", $_POST[saldo]);

if ($saldok > $sisahutang)
{
	echo"Gagal simpan, jumlah bayar lebih besar jumlah saldo hutang";
}
else
{
	
	$tgl = date("Y-m-d", strtotime($_POST[tglbayar]));
	mysqli_query($con,"insert into tabel_jurnal set  
	tgl_jurnal='$tgl',
	nomor_jurnal='$_POST[nojurnal]',
	nomor_faktur='$_POST[faktur]',
	referensi='$_POST[kdsp]',
	keterangan='Pembayaran Hutang',
	id_akun='39',
	debet='$saldok',
	kredit='0', nama_user='$_SESSION[username]'");
	
	mysqli_query($con,"insert into tabel_jurnal set  
	tgl_jurnal='$tgl',
	nomor_jurnal='$_POST[nojurnal]',
	nomor_faktur='$_POST[faktur]',
	referensi='$_POST[kdsp]',
	keterangan='Pembayaran Hutang',
	id_akun='33',
	debet='0',
	kredit='$saldok', nama_user='$_SESSION[username]'");
	
	
	echo"Pembayaran hutang berhasil"; 

}



?>