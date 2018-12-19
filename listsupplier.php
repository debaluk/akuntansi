<?php
error_reporting(0);
require "koneksi.php";

//$search='Budi';

$hasil  = mysqli_query($con, "SELECT * FROM tabel_supplier WHERE nama_supplier LIKE '%search%' ORDER BY nama_supplier ASC");
$data   = mysqli_fetch_array($hasil);

if (mysqli_num_rows($hasil) > 0) {
     $list = array();
     $key=0;
     while($row = mysqli_fetch_array($hasil)) 
	 {
         $list[$key]['id'] = $row['kode_supplier'];
         $list[$key]['text'] = $row['kode_supplier'].' '.$row['nama_supplier']; 
     $key++;
     }
     echo json_encode($list);
 } else {
     echo "hasil kosong";
 }
 
?>