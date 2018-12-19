<?php
error_reporting(3); 
include "../config/main.php";

$id = $_POST['id'];
$cek = mysql_query("select * from tb_boat_jadwal where id_boat='$id'");
if(mysql_num_rows($cek) > 0){
	echo "Data akun tidak dapat dihapus, sudah digunakan";
}
else{
	mysql_query("delete from tbl_akun where id_akun='$id'");
	echo "Data akun berhasil di hapus";
	
}