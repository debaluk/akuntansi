<?php 
require "koneksi.php";

//kosongka datatabel
mysqli_query($con,"delete from tabel_rugi_laba");

$listakun = mysqli_query($con,"select * from tabel_akun where tipe_akun='Pendapatan' or tipe_akun='Biaya' or tipe_akun='HPP' order by kode_akun asc");
while ($dataakun=mysqli_fetch_array($listakun))
{
	//ambil saldo akun master sesuai periode
	$saldoakun = mysqli_query($con,"select * from tabel_akun where tanggal_awal between '$pilihanawal' and '$pilihanakhir' and id_akun='$dataakun[id_akun]'");
	$datasaldoakun=mysqli_fetch_array($saldoakun);
	$akundebet=$datasaldoakun[awal_debet];
	$akunkredit=$datasaldoakun[awal_kredit];
	
	//cari saldo periode berjalan
	$saldomutasi=mysqli_fetch_array(mysqli_query($con,"select sum(debet)as debet, sum(kredit) as kredit from tabel_jurnal where id_akun='$dataakun[id_akun]' and tgl_jurnal between '$pilihanawal' and '$pilihanakhir'"));
	
	$saldodebet=$saldomutasi[debet] + $akundebet;
	$saldokredit=$saldomutasi[kredit] + $akunkredit;
	
	
	if($dataakun[tipe_akun]=='Pendapatan')
	{
		mysqli_query($con,"insert into tabel_rugi_laba set id_akun='$dataakun[id_akun]', tipe_akun='$dataakun[tipe_akun]', debet='$saldodebet]', kredit='$saldokredit'");
	}
	if($dataakun[tipe_akun]=='HPP')
	{
		mysqli_query($con,"insert into tabel_rugi_laba set id_akun='$dataakun[id_akun]', tipe_akun='$dataakun[tipe_akun]', debet='$saldodebet]', kredit='$saldokredit'");
	}
	if($dataakun[tipe_akun]=='Biaya')
	{
		mysqli_query($con,"insert into tabel_rugi_laba set id_akun='$dataakun[id_akun]', tipe_akun='$dataakun[tipe_akun]', debet='$saldodebet]', kredit='$saldokredit'");
	}
	
}

$totallabarugi=mysqli_fetch_array(mysqli_query($con,"select sum(kredit-debet) as total from tabel_rugi_laba"));		

?>	
		
	
		<?php
		if ($_GET[awal] or  $_GET[akhir])
		{ ?>
			
			<body onload="window.print()">
			<div align="center"><h3>"VIDAYA MART"</3></div>
			<div align="center"><h4>Laba Rugi</h4></div>
			<div align="center"><?php echo $_GET[awal];?> - <?php echo $_GET[akhir];?> <?php echo $_GET[tahun];?> </div>
			<br>
			
			<table width="100%" border="1" cellpadding="5" cellspacing="0">
			  <tr>
				<td width="150" align="center">No Akun</td>
				<td align="center" width="250">Nama Akun</td>
				
				<td width="100" align="center">Nominal</td>
				<td width="100" align="center">Nominal</td>
				<td width="100" align="center">Total</td>
			  </tr>
			  <?php
			   
				//pendapatan
				$totalpendapatan=mysqli_fetch_array(mysqli_query($con,"select sum(debet-kredit) as total from tabel_rugi_laba where tipe_akun='Pendapatan'"));
				
				$listakunpendapatan = mysqli_query($con,"select tabel_rugi_laba.*, tabel_akun.nama_akun,tabel_akun.kode_akun from tabel_rugi_laba,tabel_akun
				where tabel_rugi_laba.id_akun=tabel_akun.id_akun and tabel_rugi_laba.tipe_akun='Pendapatan' order by tabel_akun.kode_akun asc");
				while ($dataakunpednapatan=mysqli_fetch_array($listakunpendapatan))
				{
			  ?>
				<tr>
					<td><?php echo $dataakunpednapatan[kode_akun];?></td>
					<td><?php echo $dataakunpednapatan[nama_akun];?></td>
					<td align="right"><?php echo number_format($dataakunpednapatan[debet] ,0,',','.')?></td>
					<td align="right"><?php echo number_format($dataakunpednapatan[kredit] ,0,',','.')?></td>
					
				</tr>
				<?php } ?>
			  <tr>
				<td colspan="2" align="center"><p>Total Pendapatan</p></td>
				<td align="right">&nbsp;</td>
				<td align="right">&nbsp;</td>
				<td align="right"><?php echo number_format(abs($totalpendapatan[total]) ,0,',','.')?></td>
			  </tr>
			   
			   <?php
			   //hhpp, biaya
				$totalbiaya=mysqli_fetch_array(mysqli_query($con,"select sum(debet-kredit) as total from tabel_rugi_laba where tipe_akun='HPP' or tipe_akun='Biaya'"));
				
				$listakunhpp = mysqli_query($con,"SELECT
					`tabel_rugi_laba`.*
					, `tabel_akun`.`kode_akun`
					, `tabel_akun`.`nama_akun`
				FROM
					`tabel_rugi_laba`
					INNER JOIN `tabel_akun` 
						ON (`tabel_rugi_laba`.`id_akun` = `tabel_akun`.`id_akun`) where `tabel_rugi_laba`.`tipe_akun`='HPP' or `tabel_rugi_laba`.`tipe_akun`='Biaya'");
				while ($dataakunhpp=mysqli_fetch_array($listakunhpp))
				{
			  ?>
				<tr>
					<td><?php echo $dataakunhpp[kode_akun];?></td>
					<td><?php echo $dataakunhpp[nama_akun];?></td>
					<td align="right"><?php echo number_format($dataakunhpp[debet] ,0,',','.')?></td>
					<td align="right"><?php echo number_format($dataakunhpp[kredit] ,0,',','.')?></td>
					
				</tr>
				<?php } ?>
			  <tr>
				<td colspan="2" align="center"><p>Total Biaya</p></td>
				<td align="right">&nbsp;</td>
				<td align="right">&nbsp;</td>
				<td align="right"><?php echo number_format($totalbiaya[total] ,0,',','.')?></td>
			  </tr>
			  <tr>
				<td colspan="2" align="center">Total Laba Rugi</td>
				<td align="right">&nbsp;</td>
				<td align="right">&nbsp;</td>
				<td align="right"><?php echo number_format($totallabarugi[total] ,0,',','.')?></td>
			  </tr>
		</table>
		</body>
		<?php } ?>					
