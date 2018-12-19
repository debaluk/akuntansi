<?php 
session_start();
error_reporting(3);
include "../koneksi.php";
$pwd=htmlentities(md5($_POST['pwdlama']));
$pwdbaru=md5($_POST['passwordbaru']);

//cari user dengan password
$querykode=mysqli_query($con,"select * from tabel_operator where id_operator='$_POST[idlama]' and password='$pwd'");
if (mysqli_num_rows($querykode) > 0)
{
	if ($_POST['passwordbaru']==$_POST['passwordbaruu'])
	{
		//proses update
		mysqli_query($con,"update tabel_operator set password='$pwdbaru' where id_operator='$_POST[idlama]'");
		echo"Ubah Password berhasil";
	}
	else
	{
		echo "Password baru harus sama dengan password ulang";
	}
}
else
{
	echo "Password lama salah";
}

?>