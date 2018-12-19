<?php 
require "koneksi.php";
?>
<body onload="window.print()">
<div class="box" style="min-height: 450px;">
    <div class="box-header">
      <h3 class="box-title">
	  <div align="center"><h3>VIDAYA MART</h3></div>
	  <div align="center"> Daftar Hutang</a></h3>
    </div><!-- /.box-header -->
    <div class="box-body">
		
		<div style="margin-top: 20px;">
		<table width="100%" class="table table-bordered" id="tabel" border="1" cellpadding="0" cellspacing="0">
			<thead>
				
			  <tr>
			    <th>No. Faktur</th>
			    <th>Kode Supplier</th>
				<th>Nama Supplier</th>
				<th>Tanggal</th>
				<th>Saldo</th>
				
			  </tr>
			</thead>
			<tbody>
				<?php
				
				//perkiraan Hutang Dagang=39
				
				$query=mysqli_query($con,"SELECT tabel_jurnal.*, ((SUM(tabel_jurnal.kredit))-(SUM(tabel_jurnal.debet))) AS saldo, tabel_supplier.nama_supplier,tabel_supplier.kode_supplier 
				FROM tabel_jurnal,tabel_supplier
				WHERE tabel_jurnal.referensi=tabel_supplier.kode_supplier AND tabel_jurnal.id_akun='39'
				GROUP BY 
				tabel_jurnal.nomor_faktur, 
				tabel_jurnal.referensi
				ORDER BY tabel_jurnal.id_jurnal DESC");
			  	$no=1;
			  while($q=mysqli_fetch_array($query)){
				//echo $q['keterangan'];
				if ($q[keterangan]=='Pembelian Kredit')
				{
					$nisaldo = $q[debet];
				}
				else
				{
					$nisaldo = $q[kredit];
				}
				if ($q[saldo] > 0)
				{
			  ?>
				  <tr>
					<td><?php echo $q['nomor_faktur']?></td>           
					<td><?php echo $q['kode_supplier']?></td>
					<td><?php echo $q['nama_supplier']?></td>
					<td><?php echo $q['tgl_jurnal']?></td>
					<td align="right"><?php echo number_format($q[saldo] ,0,',','.')?></td>
					
				  </tr>
			  <?php
				}
			  }
			  ?>
			</tbody>
		</table>
	</div></div>
</div>
</body>
