<?php
error_reporting(0); 
include "../koneksi.php";
$id = $_POST['id'];

$datakat=mysqli_query($con,"select * from tabel_operator where id_operator='$id'");
$recdata=mysqli_fetch_array($datakat);
if ($recdata[level]=='Administrator')
{
    echo "Gagal, Level user administrator";
}
else
{
    mysqli_query($con,"delete from tabel_operator where id_operator='$id'");
	
    echo "Berhasil, Data operator berhasil dihapus";
    
}