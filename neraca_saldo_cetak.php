<?php 
require "koneksi.php";


//kosongka datatabel
mysqli_query($con,"delete from tabel_neraca");

$listakun = mysqli_query($con,"select * from tabel_akun order by kode_akun asc");
while ($dataakun=mysqli_fetch_array($listakun))
{
	//ambil saldo akun master
	$saldoakun = mysqli_query($con,"select * from tabel_akun where tanggal_awal between '$pilihanawal' and '$pilihanakhir' and id_akun='$dataakun[id_akun]'");
	$datasaldoakun=mysqli_fetch_array($saldoakun);
	
	$akundebet=$datasaldoakun[awal_debet];
	$akunkredit=$datasaldoakun[awal_kredit];
	//cari saldo periode sebelumnya
	$saldoawal=mysqli_fetch_array(mysqli_query($con,"select sum(debet)as debet, sum(kredit) as kredit from tabel_jurnal where id_akun='$dataakun[id_akun]' and tgl_jurnal < '$pilihanawal'"));
	
	$saldoawaldebet=$saldoawal[debet] +  $akundebet;
	$saldoawalkredit=$saldoawal[kredit]  + $akunkredit;
	
	//cari saldo periode
	$saldomutasi=mysqli_fetch_array(mysqli_query($con,"select sum(debet)as debet, sum(kredit) as kredit from tabel_jurnal where id_akun='$dataakun[id_akun]' and tgl_jurnal between '$pilihanawal' and '$pilihanakhir'"));
	
	$saldodebet=$saldomutasi[debet];
	$saldokredit=$saldomutasi[kredit];
	
	$totalmuatsi=$saldoawaldebet+$saldodebet-$saldoawalkredit-$saldokredit;
	
	if ($totalmuatsi < 0)
	{
		mysqli_query($con,"insert into tabel_neraca set id_akun='$dataakun[id_akun]', 
		awal_debet='$saldoawaldebet', 
		awal_kredit='$saldoawalkredit',
		mut_debet='$saldodebet]', 
		mut_kredit='$saldokredit',
		sisa_kredit=abs($totalmuatsi)");
	}
	else
	{
		mysqli_query($con,"insert into tabel_neraca set id_akun='$dataakun[id_akun]', 
		awal_debet='$saldoawaldebet', 
		awal_kredit='$saldoawalkredit',
		mut_debet='$saldodebet]', 
		mut_kredit='$saldokredit',
		sisa_debet='$totalmuatsi'");
	}
	
	
				
}
//ambil total saldoawal
$totalsaldo = mysqli_query($con,"select sum(sisa_debet) as debet, sum(sisa_kredit) as kredit  from tabel_neraca");
$nilaitotal=mysqli_fetch_array($totalsaldo);

?>
	
		<?php
		if ($_GET[awal] or  $_GET[akhir])
		{ ?>
		<br>
			<body onload="window.print()">
			<div align="center"><h3>"VIDAYA MART"</3></div>
			<div align="center"><h4>Neraca Saldo</h4></div>
			<div align="center"><?php echo $_GET[awal];?> - <?php echo $_GET[akhir];?> <?php echo $_GET[tahun];?> </div>
			<br>
		
		
		<table width="100%" border="1" cellpadding="5" cellspacing="0" class="table table-bordered">
			<tr>
				<td align="center">No. Akun</td>
				<td align="center">Nama Akun</td>
				<td align="center">Debet</td>
				<td align="center">Kredit</td>
			</tr>
			<?php
			//echo $pilihanakhir;
			$saldodebet=0;
			$saldokredit=0;
			$listakunn = mysqli_query($con,"select tabel_neraca.*,tabel_akun.nama_akun, tabel_akun.kode_akun from tabel_neraca,tabel_akun
			where tabel_neraca.id_akun=tabel_akun.id_akun order by tabel_akun.kode_akun asc");
			while ($dataakunn=mysqli_fetch_array($listakunn))
			{
				
			?>
		  
			<tr>
				<td><?php echo $dataakunn[kode_akun];?></td>
				<td><?php echo $dataakunn[nama_akun];?> </td>
				<td align="right"><?php echo number_format($dataakunn[sisa_debet] ,0,',','.')?></td>
				<td align="right"><?php echo number_format($dataakunn[sisa_kredit])?></td>
				
			</tr>
			<?php 
				
				
			} 
			
			?>
		  <tr>
			<td colspan="2" align="center">Total</td>
			<td align="right"><?php echo number_format($nilaitotal[debet] ,0,',','.')?></td>
			<td align="right"><?php echo number_format($nilaitotal[kredit] ,0,',','.')?></td>
		  </tr>
		</table>
		<?php } ?>					
	</body>