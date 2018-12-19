<?php
require "koneksi.php";
error_reporting(0);

$user 	= $_POST['tUser'];
$pwd=htmlentities(md5($_POST['tPwd']));

$hasil  = mysqli_query($con, "SELECT * FROM tabel_operator WHERE username='$user' AND password='$pwd'");
$hitung = mysqli_num_rows($hasil);
$data   = mysqli_fetch_array($hasil);

if ($hitung > 0){
	session_start();
	$_SESSION['username'] = $data['username'];
	$_SESSION['password'] = $data['password'];
	$_SESSION['nama'] = $data['namalengkap'];
	$_SESSION['leve'] = $data['level'];
	
	 
	header('Location:index.php');
}else{
   echo "<script>alert('GAGAL..!!!!!, Silakan Ulangi Lagi'); window.location = 'login.php'</script>";
}
?>