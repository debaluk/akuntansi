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

?>

		<?php
		if ($_GET[awal] or  $_GET[akhir])
		{ ?>
			<body onload="window.print()">
			<div align="center"><h3>VIDAYA MART</3></div>
			<div align="center"><h4>Neraca</h4></div>
			<div align="center"><?php echo $_GET[awal];?> - <?php echo $_GET[akhir];?> <?php echo $_GET[tahun];?> </div>
			<br>
			
			<table width="100%" border="1" cellpadding="5" cellspacing="0">
			  <tr height="40px">
				<td align="center" style="width:100px;">No Akun</td>
				<td align="center">Nama Akun</td>
				<td align="center" style="width:150px;">Saldo</td>
				<td align="center" style="width:100px;">No Akun</td>
				<td align="center">Nama Akun</td>
				<td align="center" style="width:150px;">Saldo</td>
			  </tr>
			  <tr>
				<td colspan="3">
				<table width="100%" border="1" cellpadding="5" cellspacing="0">
				 
				<?php
				//cari akun aktiva
				$akunaktifa=mysqli_query($con,"select * from tabel_akun where tipe_akun='Aktiva' order by id_akun asc");
				while ($listakunaktifa=mysqli_fetch_array($akunaktifa))
				{ 
					$saldomutasia=mysqli_fetch_array(mysqli_query($con,"select * from tabel_neraca where id_akun='$listakunaktifa[id_akun]'"));
					if ($listakunaktifa[id_akun]=='38')
					{
						$nilaidebet = -1 * $saldomutasia[sisa_kredit];
					}
					else
					{
						$nilaidebet = $saldomutasia[sisa_debet];
					}
					
					$saldoaktifa= $nilaidebet;
					$totalsaldoaktifa = $totalsaldoaktifa+$saldoaktifa;
					
				?>
					<tr height="30px">
						<td style="width:99px;">  <?php echo  $listakunaktifa[kode_akun];?></td>
						<td><?php echo  $listakunaktifa[nama_akun];?></td>
						<td align="right" style="width:150px;">						
							<?php echo number_format($nilaidebet ,0,',','.')?>
						</td>
						
					</tr>
				<?php }
					
				?>
				</table>
				
				</td>
				<td colspan="3" valign="top">
				<table width="100%" border="1" cellpadding="5" cellspacing="0">
				 
				<?php
				//cari akun aktiva
				$akunpasiva=mysqli_query($con,"select * from tabel_akun where tipe_akun='Modal' or tipe_akun='Kewajiban'");
				while ($listakunpasiva=mysqli_fetch_array($akunpasiva))
				{ 
					
					$saldomutasiv=mysqli_fetch_array(mysqli_query($con,"select * from tabel_neraca where id_akun='$listakunpasiva[id_akun]'"));
					$salddopasiva= $saldomutasiv[sisa_kredit];					
					$totalsaldopasiva= $totalsaldopasiva+$salddopasiva;
				?>
					<tr height="30px">
						<td style="width:99px;"><?php echo  $listakunpasiva[kode_akun];?></td>
						<td><?php echo  $listakunpasiva[nama_akun];?></td>
						<td align="right" style="width:150px;"><?php echo number_format($salddopasiva ,0,',','.')?></td>
					</tr>
				
				<?php 
				}
					//cari laba rugi
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
					<tr height="30px">
						<td style="width:99px;"></td>
						<td>Laba Rugi</td>
						<td align="right" style="width:150px;"><?php echo number_format($totallabarugi[total],0,',','.')?></td>
					</tr>
					
				
				</table>
				</td>
			  </tr>
			  <tr height="40px">
				<td colspan="2" align="center">Total</td>
				<td align="right" style="width:150px;"><?php echo number_format(abs($totalsaldoaktifa) ,0,',','.')?></td>
				<td colspan="2" align="center">Total</td>
				<td align="right" style="width:150px;"><?php echo number_format(abs($totalsaldopasiva + $totallabarugi[total] ) ,0,',','.')?></td>
			  </tr>
			</table>
			
			<?php } ?>			
	</body>
