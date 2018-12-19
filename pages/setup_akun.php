<?php 
require "koneksi.php";
?>
<div class="box" style="min-height: 450px;">
    <div class="box-header">
      <h3 class="box-title">Setup Akun Jurnal</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
<?php
?>	
		
		<div style="margin-top: 20px;">
		<a id="add" href="pages/setup_detil.php" data-toggle="ajaxModal" class="btn btn-primary"><i class="fa fa-plus"></i> Keterangan Baru</a>	
		</p>	
		<table width="100%" class="table table-bordered" id="tabel">
		<thead>
			
		  <tr>
		    <th>Keterangan Jurnal</th>
		    <th>Akun Posisi Debet</th>
			<th>Akun Posisi Kredit</th>
			<th></th>
			
		  </tr>
		</thead>
		<tbody>
			<?php
			$query=mysqli_query($con,"select * from tabel_keterangan where id_keterangan!=1 order by id_keterangan asc");
		  	$no=1;
			  while($q=mysqli_fetch_array($query)){
			  	//cari akun debetnya
				$querydd=mysqli_query($con,"select tabel_setup.*, tabel_akun.nama_akun from tabel_setup, tabel_akun where tabel_setup.id_keterangan='$q[id_keterangan]' and tabel_setup.posisi_akun='Debet' and tabel_setup.id_akun=tabel_akun.id_akun");
				$datadd=mysqli_fetch_array($querydd);

				//cari akun reditnya
				$querykk=mysqli_query($con,"select tabel_setup.*, tabel_akun.nama_akun from tabel_setup, tabel_akun where tabel_setup.id_keterangan='$q[id_keterangan]' and tabel_setup.posisi_akun='Kredit' and tabel_setup.id_akun=tabel_akun.id_akun");

				$datakk=mysqli_fetch_array($querykk);
			  ?>
				<tr>
					<td><?php echo $q['keterangan']?></td>           
					<td><?php echo $datadd['nama_akun']?></td>
					<td><?php echo $datakk['nama_akun']?></td>
				
				<td>
					<a class="btn btn-sm btn-success" id="add" href="pages/setup_detil.php?id=<?php echo $q['id_keterangan'];?>" data-toggle="ajaxModal" href="?page=<?php echo $_GET['page']; ?>&id=<?php echo $q['id_keterangan']; ?>">Edit</a>
					
					<!--<a class="btn btn-danger" href="javascript: hapusdata('<?php echo $q['id_akun'];?>')">Hapus</a>-->
				</td>
				
				</tr>
			  <?php
			  }
		  ?>
		</tbody>
		</table>
	</div></div>
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