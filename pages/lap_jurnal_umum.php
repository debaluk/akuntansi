<?php 
require "koneksi.php";
?>
<div class="box" style="min-height: 450px;">
    <div class="box-header">
      <h3 class="box-title">Laporan Jurnal Umum</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
<?php
?>	
		
	<div style="margin-top: 20px;">
		<div style="text-align: center">
		<form action="index.php?page=lap_jurnal_umum" method="GET" >
		<input type="hidden" value="lap_jurnal_umum" name="page" >
		Pilih bulan dan tahun untuk menampilkan Laporan Jurnal Umum.<p>	
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
		    <td width="250">
			<input type="submit" name="view" id="view" value="Tampilkan" class="btn btn-sm btn-success" />
			<?php
			if ($_GET[awal] or  $_GET[akhir])
			{ ?>
				<a href="lap_jurnal_cetak.php?awal=<?php echo $_GET[awal];?>&akhir=<?php echo $_GET[akhir];?>&tahun=<?php echo $_GET[tahun];?>" target="_new">
				<input type="button" name="Cetak" id="Cetak" value="Cetak Jurnal" class="btn btn-sm btn-success"/></a>
				
			<?php } ?> </td>
		  </tr>
		</table>
		
		</div>
		</p>
		
		<br>
			
			<div align="center"><h3>"VIDAYA MART"</3></div>
			<div align="center"><h4>Jurnal Umum</h4></div>
			<div align="center"><?php echo $_GET[awal];?> - <?php echo $_GET[akhir];?> <?php echo $_GET[tahun];?> </div>
			<br>
		
		<table width="100%" cellpadding="5" cellspacing="0" border="1" class="table table-bordered">
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
				$cariketerangan=mysqli_query($con,"select * from tabel_keterangan where keterangan='$datajurnal[keterangan]'");
				$hasilcariketerangan=mysqli_fetch_array($cariketerangan);
				?>
				<tr>	
					<th colspan="3">
					<div style="height: 100%;width: 100%;display: flex;">
						<div style="width: 15%;">
							<?php
							if ($_SESSION['leve']=='Super Admin')
							{ ?>
								<a href="?page=lap_jurnal_umum_edit&keterangan_id=<?php echo $hasilcariketerangan[id_keterangan];?>&nojurnal=<?php echo $datajurnal[nomor_jurnal];?>&awal=<?php echo $_GET[awal];?>&akhir=<?php echo $_GET[akhir];?>&tahun=<?php echo $_GET[tahun];?>&view=Tampilkan"><?php echo $datajurnal[nomor_jurnal];?> <i class="fa fa-edit"></i></a>
							<?php
							}
							else
							{ ?>
								<?php echo $datajurnal[nomor_jurnal];?>
							<?php
							}
							?>
														
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
		
		
	</div>
</div>


<script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
 <script type="text/javascript">
	 $(document).ready(function() {
	 	$('#tabel').dataTable({
	          "bPaginate": true,
	          "bLengthChange": true,
	          "bFilter": true,
	          "bSort": true,
	          "bInfo": true,
	          "bAutoWidth": false
	    });
	 });
</script>