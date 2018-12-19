<?php 
session_start();
error_reporting(3);
include "../koneksi.php";


$cariakun=mysqli_query($con, "select * from tabel_keterangan where keterangan='$_POST[keterangan]'");
$hasilcari=mysqli_fetch_array($cariakun);
if (mysqli_num_rows($cariakun) > 0)
{
	echo"Keterangan sudah ada, silahkan ganti";
}
else
{
	//update atau insert
	if ($_POST[idlama])
	{
		
		mysqli_query($con,"update tabel_keterangan set keterangan='$_POST[keterangan]' where id_keterangan='$_POST[idlama]'");

		mysqli_query($con, "delete from tabel_setup where id_keterangan='$_POST[idlama]'");
		//simpan detilnya
		mysqli_query($con,"insert into tabel_setup set id_keterangan='$_POST[idlama]', id_akun='$_POST[debet]', posisi_akun='Debet'");

		mysqli_query($con,"insert into tabel_setup set id_keterangan='$_POST[idlama]', id_akun='$_POST[kredit]', posisi_akun='Kredit'");

			echo"Ubah keterangan berhasil";
	}
	else {
			mysqli_query($con,"insert into tabel_keterangan set keterangan='$_POST[keterangan]'");
			
			$idakhir=mysqli_insert_id($con);
			//simpan detilnya
			mysqli_query($con,"insert into tabel_setup set id_keterangan='$idakhir', id_akun='$_POST[debet]', posisi_akun='Debet'");

			mysqli_query($con,"insert into tabel_setup set id_keterangan='$idakhir', id_akun='$_POST[kredit]', posisi_akun='Kredit'");

			echo"Tambah keterangan berhasil";
	}

}

?>