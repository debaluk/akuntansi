<?php
error_reporting(3); 
include "../koneksi.php";

$id = $_POST['id'];

$cek=mysqli_query($con,"select tabel_jurnal.*, tabel_supplier.* from tabel_jurnal,tabel_supplier
 where tabel_jurnal.referensi=tabel_supplier.kode_supplier and tabel_supplier.id_supplier='$id'");
$recdata=mysqli_fetch_array($cek);
if(mysqli_num_rows($cek) > 0)
{
   echo "Data supplier tidak dapat dihapus, sudah digunakan";
}
else
{
    mysqli_query($con,"delete from tabel_supplier where id_supplier='$id'");
	//cari data di jurnal
	//
	//mysqli_query($con,"delete from tabel_jurnal where id_supplier='$id'");
    echo "Berhasil, Data supplier berhasil dihapus";
    
}