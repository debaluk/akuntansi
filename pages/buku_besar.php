<?php 
require "koneksi.php";
?>
<div class="box" style="min-height: 450px;">
    <div class="box-header">
      <h3 class="box-title">Buku Besar</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
<?php
?>	
		
	<div style="margin-top: 20px;">
		<div style="text-align: center">
		<form action="index.php?page=buku_besar" method="GET" >
		<input type="hidden" value="buku_besar" name="page" >
		Pilih bulan dan tahun untuk menampilkan Buku Besar.<p>	
		<table width="80%" border="0">
		  <tr>
		    <td width="100">Bulan</td>
		    <td>
		    	<select name="awal" id="awal" class="form-control" required>
					<option value="<?php echo $_GET[awal]; ?>"> <?php echo $_GET[awal]; ?> </option>
					<?php
					$bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
					$jlh_bln=count($bulan);
					for($c=0; $c<$jlh_bln; $c+=1){
						?>
						<option value="<?php echo $bulan[$c] ?>"> <?php echo $bulan[$c]; ?> </option>
						<?php
					}
					?>
		  		
		  </select>
		    </select>
		    </td>
		    <td width="100">s.d/ Bulan</td>
		    <td><select name="akhir" id="akhir" class="form-control" required>
		  		 
					<option value="<?php echo $_GET[akhir]; ?>"><?php echo $_GET[akhir]; ?> </option>
					<?php
					$bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
					$jlh_bln=count($bulan);
					for($c=0; $c<$jlh_bln; $c+=1){
					?>
						<option value="<?php echo $bulan[$c] ?>"> <?php echo $bulan[$c]; ?> </option>
						<?php
					}
					?>
		  		
		  </select></td>
		    <td width="100">Tahun</td>
		    <td><select name="tahun" id="tahun" class="form-control" required>
				<option value="<?php echo $_GET[tahun]; ?>"> <?php echo $_GET[tahun]; ?> </option>
				<?php
				$tahunini = date('Y');
				
				for($i=$tahunini; $i>=2016; $i-=1){
				?>	
					<option value="<?php echo $i;?>"> <?php echo $i;?> </option>
				
				<?php }
				?>
			</select></td>
		    <td width="250"><input type="submit" name="view" id="view" value="Tampilkan" class="btn btn-sm btn-success" />
			<?php
			if ($_GET[awal] or  $_GET[akhir])
			{ ?>
				<a href="buku_besar_cetak.php?awal=<?php echo $_GET[awal];?>&akhir=<?php echo $_GET[akhir];?>&tahun=<?php echo $_GET[tahun];?>" target="_new">
				<input type="button" name="Cetak" id="Cetak" value="Cetak Buku Besar" class="btn btn-sm btn-success"/></a>
			<?php } ?> </td>
		  </tr>
		</table>
		
		</div>
		</p>
		<div align="center"><h3>"VIDAYA MART"</3></div>
			<div align="center"><h4>Buku Besar</h4></div>
			<div align="center"><?php echo $_GET[awal];?> - <?php echo $_GET[akhir];?> <?php echo $_GET[tahun];?> </div>
			<br>
		<?php
		if ($_GET[awal] or  $_GET[akhir])
		{ ?>
			<?php
			$queryakun=mysqli_query($con,"select * from tabel_akun order by id_akun asc");
			while ($dataakun=mysqli_fetch_array($queryakun))
			{
				//ambil saldo akun master
				if ($dataakun[awal_debet]!='' or $dataakun[awal_kredit]!='')
				{
					$akundebet=$dataakun[awal_debet];
					$akunkredit=$dataakun[awal_kredit];
				}
				else
				{
					$akundebet=0;
					$akunkredit=0;
				}
				
				$jmlrow=mysqli_num_rows(mysqli_query($con,"select sum(debet)as debet, sum(kredit) as kredit from tabel_jurnal where id_akun='$dataakun[id_akun]' and tgl_jurnal < '$pilihanawal'"));
				if ($jmlrow > 0)
				{
					$saldoawal=mysqli_fetch_array(mysqli_query($con,"select sum(debet)as debet, sum(kredit) as kredit from tabel_jurnal where id_akun='$dataakun[id_akun]' and tgl_jurnal < '$pilihanawal'"));
				
					if ($saldoawal[debet]!='' or $saldoawal[kredit]!='') 
					{
						$nilaiawaldebet=$saldoawal[debet];
						$nilaiawalkredit=$saldoawal[kredit];
					}
					else
					{
						$nilaiawaldebet=0;
						$nilaiawalkredit=0;
					}
				}
				else
				{
					$nilaiawaldebet=0;
					$nilaiawalkredit=0;
				}
				
				
				$saldoawaldebet=$nilaiawaldebet + $akundebet;
				$saldoawalkredit=$nilaiawalkredit + $akunkredit;
				$sisasaldoawal=$saldoawaldebet - $saldoawalkredit;
				
				
				$saldoawal=mysqli_fetch_array(mysqli_query($con,"select sum(debet)as debet, sum(kredit) as kredit from tabel_jurnal where id_akun='$dataakun[id_akun]' and tgl_jurnal < '$pilihanawal'"));
				$saldomutasi=mysqli_fetch_array(mysqli_query($con,"select sum(debet)as debet, sum(kredit) as kredit from tabel_jurnal where id_akun='$dataakun[id_akun]' and tgl_jurnal between '$pilihanawal' and '$pilihanakhir'"));
				
				$saldodebet=$saldoawal[debet] + $saldomutasi[debet] + $akundebet;
				$saldokredit=$saldoawal[kredit] + $saldomutasi[kredit] + $akunkredit;
				$sisasaldo=$saldodebet - $saldokredit;
				
			?>
			<br>
			
			
			<table width="100%" cellpadding="5" cellspacing="0" border="1" class="table table-bordered" id="tabel">
					<thead>
						<tr>	
						  <th align="center"><?php echo $dataakun[kode_akun];?> </th>
						  <th colspan="3"><?php echo $dataakun[nama_akun];?>  </th>
						 
						</tr>
						<tr>	
						  <td align="center" width="150px">Tanggal</td>
						  <td align="center">Keterangan</td>
						  <td align="center" width="150px">Debet</td>
						  <td align="center" width="150px">Kredit</td>
						  
						</tr>
					</thead>
						<tr>	
						  <td align="center" width="150px"></td>
						  <td align="left">Saldo Awal</td>
						  <td align="right"> 
							<?php 
								if ($sisasaldoawal > 0)
								{
									echo number_format($sisasaldoawal ,0,',','.');
								}
							 ?>
						  </td>
						  <td align="right">
							<?php 
								if ($sisasaldoawal < 0)
								{
									
									echo number_format(abs($sisasaldoawal) ,0,',','.');
								}
								
								
							 ?>
						  </td>
						  
						</tr>
					
					<?php
					$count=1;
					
					$datajurnal = mysqli_query($con,"SELECT * FROM tabel_jurnal WHERE id_akun='$dataakun[id_akun]' and tgl_jurnal between '$pilihanawal' and '$pilihanakhir' ORDER BY tgl_jurnal asc");
					while($qj=mysqli_fetch_array($datajurnal))
					{ 
						?>
						<tr>
						  <td><?php echo $qj[tgl_jurnal];?></td>
						  <td><?php echo $qj[keterangan];?></td>
						  <td align="right"><?php echo number_format($qj[debet] ,0,',','.')?></td>
						  <td align="right"><?php echo number_format($qj[kredit] ,0,',','.')?></td>
						 
						</tr>
						<?php
						
					}
					
					?>
					<tr>	
						  <td colspan="2" align="center">Saldo </td>
						  <td align="right"> 
							<?php 
								if ($sisasaldo > 0)
								{
									echo number_format($sisasaldo ,0,',','.');
								}
							 ?>
						  </td>
						  <td align="right">
							<?php 
								if ($sisasaldo < 0)
								{
									$num = abs($sisasaldo);
									echo number_format($num ,0,',','.');
								}
								
								
							 ?>
						  </td>
						 
					</tr>
				  </table>
				  
			<?php } ?>
			
		<?php } ?>
	</div>
</div>
<script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
