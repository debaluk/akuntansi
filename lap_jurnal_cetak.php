<?php 
require "koneksi.php";
?>
<body onload="window.print()">
			<div align="center"><h3>"VIDAYA MART"</3></div>
			<div align="center"><h4>Jurnal Umum</h4></div>
			<div align="center"><?php echo $_GET[awal];?> - <?php echo $_GET[akhir];?> <?php echo $_GET[tahun];?> </div>
			<br>
		
		<table width="100%" cellpadding="3" cellspacing="0" border="1">
			<thead>
				
				<tr>	
				  <td align="center" width="150px">Tanggal</td>
				  <td align="center">Nomor Akun</td>
				  <td align="center">Nama  Akun</td>
				  <td align="center" width="150px">Debet</td>
				  <td align="center" width="150px">Kredit</td>
				  
				</tr>
			</thead>
			<?php
			
			$listjurnal=mysqli_query($con,"select * from tabel_jurnal where keterangan!='Saldo Awal' and tgl_jurnal between '$pilihanawal' and '$pilihanakhir' group by nomor_jurnal order by nomor_jurnal ASC");
			while ($datajurnal=mysqli_fetch_array($listjurnal))
			{
				//cari id_keterangan
				
				?>
				<tr>	
					<th colspan="3">
					<div style="height: 100%;width: 100%;display: flex;">
						<div style="width: 15%;">
							<?php echo $datajurnal[nomor_jurnal];?>
						</div>
						<div style="width: 50%;">
							<?php echo $datajurnal[keterangan];?>
						</div>
					</div>
				</tr>
				<?php
				
				//cari data detil jurnal
				$nn=0;
				$detiljurnal=mysqli_query($con,"select tabel_jurnal.*, tabel_akun.kode_akun, tabel_akun.nama_akun 
				from tabel_jurnal,tabel_akun where tabel_jurnal.id_akun=tabel_akun.id_akun and tabel_jurnal.nomor_jurnal='$datajurnal[nomor_jurnal]' order by tabel_jurnal.id_jurnal asc");
				$jmlrecord=mysqli_num_rows($detiljurnal);
				while ($datadetiljurnal=mysqli_fetch_array($detiljurnal))
				{
				
			?>
					
				<?php
					
					if ($nn==0)
					{
						
					?>
					<tr>
						<td rowspan="<?php echo $jmlrecord;?>" valign="middle"><?php echo $datajurnal[tgl_jurnal];?></td>
						<td><?php echo $datadetiljurnal[kode_akun];?></td>
						<td><?php echo $datadetiljurnal[nama_akun];?></td>						
						<td align="right"><?php echo number_format($datadetiljurnal[debet] ,0,',','.')?></td>
						<td align="right"><?php echo number_format($datadetiljurnal[kredit] ,0,',','.')?></td>
						
					</tr>
					<?php 
					} 
					else
					{ ?>
					<tr>
						<td><?php echo $datadetiljurnal[kode_akun];?></td>
						<td><?php echo $datadetiljurnal[nama_akun];?></td>						
						<td align="right"><?php echo number_format($datadetiljurnal[debet] ,0,',','.')?></td>
						<td align="right"><?php echo number_format($datadetiljurnal[kredit] ,0,',','.')?></td>
					  </tr>
					<?php } ?>
			
			<?php 
				$nn++;
				} 
			}
			$saldomutasi=mysqli_fetch_array(mysqli_query($con,"select sum(debet)as debet, sum(kredit) as kredit from tabel_jurnal where keterangan!='Saldo Awal' and tgl_jurnal between '$pilihanawal' and '$pilihanakhir'"));
			?>	
			<tr>	
				  <td colspan="3" align="center" width="150px">Total</td>
				 
				  <td align="right"><?php echo number_format($saldomutasi[debet] ,0,',','.')?></td>
				  <td align="right"><?php echo number_format($saldomutasi[kredit] ,0,',','.')?></td>
				  
				</tr>
		</table>
</body>