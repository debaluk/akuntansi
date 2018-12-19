<?php 
require "koneksi.php";

?>
<div class="box">
    <div class="box-header">
       <h3 class="box-title">Data Operator</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
    <a id="add" href="pages/data_operator_detil.php" data-toggle="ajaxModal" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Operator</a>
    <br></p>
		<table class="table table-bordered" id="tabel">
		<thead>
			 <tr>
		    <th>NO</th>
		    <th>Kode Operator</th>
			<th>Nama Operator</th>
			<th>Level</th>
		    <th>User Name</th>
		   <th></th>
		  </tr>
		</thead>
		<tbody>
			<?php
			$data=mysqli_query($con,"select * from tabel_operator order by kode asc");
		  $no=1;
		  while($q=mysqli_fetch_array($data)){
		  ?>
		  <tr>
		    <td><?php echo $no++; ?></td>          
		    <td><?php echo $q['kode']?></td>
		    <td><?php echo $q['namalengkap']?></td>
			<td><?php echo $q['level']?></td>
			
		    <td><?php echo $q['username']?></td>
		    <?php if (isset($_SESSION['username'])): ?>
		    <td>
		    	<a class="btn btn-sm btn-success" id="add" href="pages/data_operator_detil.php?id=<?php echo $q[id_operator];?>" data-toggle="ajaxModal">Edit</a>
				<a class="btn btn-sm btn-success" id="add" href="pages/data_operator_ubah.php?id=<?php echo $q[id_operator];?>" data-toggle="ajaxModal">Ubah Password</a>
				<a class="btn btn-sm btn-success" id="add" href="pages/data_operator_reset.php?id=<?php echo $q[id_operator];?>" data-toggle="ajaxModal">Reset Password</a>
		    	<!--<a class="btn btn-sm btn-danger" onclick="javascript: deldata('<?php echo $q['id_operator'];?>')">Hapus</a>-->
		    </td>
			<?php endif; ?>
		  </tr>
		  <?php
		  }
		  ?>
		</tbody>
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
	          "bSort": false,
	          "bInfo": true,
	          "bAutoWidth": true
	    });
	 });
	 
	 function deldata(id){
        var status=confirm("Hapus data operator ?");
        if(status){
            $.ajax({
                url:"pages/data_operator_hapus.php",
                type:"POST",
                data:"id="+id,
                success:function(msg){
                    alert(msg);
                    //loaddata();
                    document.location.reload(); 
                }
            });
        }
    }
	
	 
	 
</script>