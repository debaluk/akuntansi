<?php 
require "koneksi.php";
?>
<div class="box" style="min-height: 450px;">
    <div class="box-header">
      <h3 class="box-title">Data Akun</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
<?php
?>	
		
		<div style="margin-top: 20px;">
		<a id="add" href="pages/data_kun_detil.php" data-toggle="ajaxModal" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Akun</a>	
		</p>	
		<table width="100%" class="table table-bordered" id="tabel">
		<thead>
			
		  <tr>
		    <th>No. Akun</th>
		    <th>Nama Akun</th>
			<th>Tipe Akun</th>
			<th>Tanggal</th>
		    
			<th>Saldo Awal</th>
			<?php if (isset($_SESSION['username'])): ?>
			<th></th>
		    <?php endif; ?>
		  </tr>
		</thead>
		<tbody>
			<?php
			$query=mysqli_query($con,"select * from tabel_akun order by kode_akun desc");
		  	$no=1;
		  while($q=mysqli_fetch_array($query)){
		  ?>
		  <tr>
		    <td><?php echo $q['kode_akun']?></td>           
		    <td><?php echo $q['nama_akun']?></td>
			<td><?php echo $q['tipe_akun']?></td>
			<td align="right" ><?php echo date('d-m-Y',strtotime($q['tanggal_awal'])) ; ?></td>
		    <td align="right">
			<?php
			if ($q['awal_debet'] > 0)
			{
				echo number_format($q['awal_debet'],0,',','.');
			}
			elseif ($q['awal_kredit'] > 0)
			{ ?>
				(<?php echo number_format($q['awal_kredit'],0,',','.'); ?>)
			<?php }
			else
			{ 
				echo number_format(0,0,',','.');
		
			}
			 ?>
			</td>
			<?php if (isset($_SESSION['username'])): ?>
			<td>
				<a class="btn btn-sm btn-success" id="add" href="pages/data_kun_detil.php?idakun=<?php echo $q['id_akun'];?>" data-toggle="ajaxModal" href="?page=<?php echo $_GET['page']; ?>&idakun=<?php echo $q['id_akun']; ?>">Edit</a>
				
				<!--<a class="btn btn-danger" href="javascript: hapusdata('<?php echo $q['id_akun'];?>')">Hapus</a>-->
			</td>
			<?php endif; ?>
		  </tr>
		  <?php
		  }
		  ?>
		</tbody>
		</table>
	</div></div>
</div>
<script>
//Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })
function hapusdata(id){
    var status=confirm("Hapus data akun ?");
    if(status){
        $.ajax({
            url:"pages/data_akun_hapus.php",
            type:"POST",
            data:"id="+id,
            success:function(msg){
                alert(msg);
                document.location.reload(); 
                return false;

            }

        });

    }

}

</script>

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