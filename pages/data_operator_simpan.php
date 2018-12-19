<?php 
session_start();
error_reporting(3);
include "../koneksi.php";
$pwd=htmlentities(md5($_POST['pwd']));

if ($_POST['pwd']==$_POST['pwdualang'])
{
	if ($_POST['idlama'])
	{
		mysqli_query($con,"update tabel_operator set
		level='$_POST[tipe]', namalengkap='$_POST[namalengkap]' where id_operator='$_POST[idlama]'");
		echo"Ubah Akun Operator berhasil";
	}
	else
	{
		mysqli_query($con,"insert into tabel_operator set 
		kode='$_POST[kode]', 
		`level`='$_POST[tipe]',
		namalengkap='$_POST[namalengkap]',
		username='$_POST[namauser]', password ='$pwd'");
		echo"Tambah Akun Operator berhasil";
	}

	
}
else
{
	echo "Password harus sama dengan password ulang";
}


?>