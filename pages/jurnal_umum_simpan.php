<?php 
session_start();
error_reporting(3);
include "../koneksi.php";

$jumlah=str_replace(".", "", $_POST[jumlah]);
$hpp=str_replace(".", "", $_POST[hpp]);
$tgl = date("Y-m-d", strtotime($_POST[tgljurnal]));

//cari nomor faktur sama
$nomorfaktur=mysqli_query($con,"select * from tabel_jurnal where nomor_faktur='$_POST[no_bukti]'");
if (mysqli_num_rows($nomorfaktur) > 0)
{
	echo"Nomor faktur sudah ada, silahkan diganti"; 
}
else
{
	//cari setup akun sesuai dengan keterangan
	$queryss=mysqli_query($con,"select tabel_setup.*,tabel_keterangan.* from tabel_setup,tabel_keterangan 
	where tabel_setup.id_keterangan=tabel_keterangan.id_keterangan and tabel_setup.id_keterangan='$_POST[keteranganakun]'");
	while ($dataakun=mysqli_fetch_array($queryss))
	{
		if ($dataakun[posisi_akun]=='Debet')
		{ 
			
			if ($dataakun['id_akun']=='35' or $dataakun['id_akun']=='42' and $dataakun['id_keterangan']=='1')
			{
				mysqli_query($con,"insert into tabel_jurnal set  
				tgl_jurnal='$tgl',
				nomor_jurnal='$_POST[nojurnal]',
				nomor_faktur='$_POST[no_bukti]',
				referensi='-',
				keterangan='$dataakun[keterangan]',
				id_akun='$dataakun[id_akun]',
				debet='$hpp', kredit='0', nama_user='$_SESSION[username]'");
			}
			else
			{
				mysqli_query($con,"insert into tabel_jurnal set  
				tgl_jurnal='$tgl',
				nomor_jurnal='$_POST[nojurnal]',
				nomor_faktur='$_POST[no_bukti]',
				referensi='-',
				keterangan='$dataakun[keterangan]',
				id_akun='$dataakun[id_akun]',
				debet='$jumlah', kredit='0', nama_user='$_SESSION[username]'");
			}

		}
		else
		{
			if ($dataakun['id_akun']=='35' or $dataakun['id_akun']=='42' and $dataakun['id_keterangan']=='1')
			{
				mysqli_query($con,"insert into tabel_jurnal set  
				tgl_jurnal='$tgl',
				nomor_jurnal='$_POST[nojurnal]',
				nomor_faktur='$_POST[no_bukti]',
				referensi='-',
				keterangan='$dataakun[keterangan]',
				id_akun='$dataakun[id_akun]',
				debet='0', kredit='$hpp', nama_user='$_SESSION[username]'");
			}
			else
			{
				mysqli_query($con,"insert into tabel_jurnal set  
				tgl_jurnal='$tgl',
				nomor_jurnal='$_POST[nojurnal]',
				nomor_faktur='$_POST[no_bukti]',
				referensi='-',
				keterangan='$dataakun[keterangan]',
				id_akun='$dataakun[id_akun]',
				debet='0', kredit='$jumlah', nama_user='$_SESSION[username]'");
			}
		}
		
	}
	echo"Transaksi Jurnal berhasil disimpan"; 


}




/*$idakun = $_POST['akun'];
$jumlah_akun = count($idakun);
$posisi = $_POST['posisi'];
$debet = $_POST['debet'];
$kredit = $_POST['kredit'];


for($x=0;$x<$jumlah_akun;$x++){
	mysqli_query($con,"insert into tabel_jurnal set  
	tgl_jurnal='$_POST[tgljurnal]',
	nomor_jurnal='$_POST[nojurnal]',
	nomor_faktur='$_POST[no_bukti]',
	referensi='-',
	keterangan='$_POST[keteranganakun]',
	id_akun='$idakun[$x]',
	debet='$debet[$x]',
	kredit='$kredit[$x]'");
	
}*/


?>