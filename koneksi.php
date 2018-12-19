<?php
error_reporting(0);

$_host = "localhost"; 	//nama server
$_name = "root"; 		// username 
$_pass = ""; 	//  standarnya kosong
$_db = "akuntansi_db";	// buat nama database harus sama 

$con = mysqli_connect($_host,$_name,$_pass);
if($con){
	$buka =mysqli_select_db($con,$_db);
	 if(!$buka){
		die("Oops! Database Down..."); 
	 }
}else{
	die("Oops! Server Down..., Mohon maaf kami sedang upgrade hardware.");	
}

if ($_GET[awal]=='Januari')
{
	$bulanawal='01';
}
elseif ($_GET[awal]=='Februari')
{
	$bulanawal='02';
}
elseif ($_GET[awal]=='Maret')
{
	$bulanawal='03';
}
elseif ($_GET[awal]=='April')
{
	$bulanawal='04';
}
elseif ($_GET[awal]=='Mei')
{
	$bulanawal='05';
}
elseif ($_GET[awal]=='Juni')
{
	$bulanawal='06';
}
elseif ($_GET[awal]=='Juli')
{
	$bulanawal='07';
}
elseif ($_GET[awal]=='Agustus')
{
	$bulanawal='08';
}
elseif ($_GET[awal]=='September')
{
	$bulanawal='09';
}
elseif ($_GET[awal]=='Oktober')
{
	$bulanawal='10';
}
elseif ($_GET[awal]=='November')
{
	$bulanawal='11';
}
elseif ($_GET[awal]=='Desember')
{
	$bulanawal='12';
}
else
{
	$bulanawal='00';
}
$pilihanawal = $_GET[tahun].'-'.$bulanawal.'-01';





if ($_GET[akhir]=='Januari')
{
	$bulanakhir='01';
}
elseif ($_GET[akhir]=='Februari')
{
	$bulanakhir='02';
}
elseif ($_GET[akhir]=='Maret')
{
	$bulanakhir='03';
}
elseif ($_GET[akhir]=='April')
{
	$bulanakhir='04';
}
elseif ($_GET[akhir]=='Mei')
{
	$bulanakhir='05';
}
elseif ($_GET[akhir]=='Juni')
{
	$bulanakhir='06';
}
elseif ($_GET[akhir]=='Juli')
{
	$bulanakhir='07';
}
elseif ($_GET[akhir]=='Agustus')
{
	$bulanakhir='08';
}
elseif ($_GET[akhir]=='September')
{
	$bulanakhir='09';
}
elseif ($_GET[akhir]=='Oktober')
{
	$bulanakhir='10';
}
elseif ($_GET[akhir]=='November')
{
	$bulanakhir='11';
}
elseif ($_GET[akhir]=='Desember')
{
	$bulanakhir='12';
}
else
{
	$bulanawal='00';
}
//$pilihanakhir = '31-'.$bulanakhir.'-'.$_GET[tahun];
$pilihanakhir = $_GET[tahun].'-'.$bulanakhir.'-31';


 
?>