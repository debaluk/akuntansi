<?php 
require "koneksi.php";
?>
<div class="box" style="min-height: 450px;">
    <div class="box-header">
      <h3 class="box-title">Daftar Hutang</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
		<a href="?page=pembelian_kredit" style="margin-bottom: 10px;" class="btn btn-md btn-primary"> <i class="fa fa-plus"></i> Tambah Pembelian Kredit</a>
		<a href="cetak_buku_hutang.php" target="_new" style="margin-bottom: 10px;" class="btn btn-md btn-primary"> <i class="fa fa-plus"></i> Cetak Daftar Hutang</a>
		<div style="margin-top: 20px;">
		<table width="100%" class="table table-bordered" id="tabel">
			<thead>
				
			  <tr>
			    <th>No. Faktur</th>
			    <th>Kode Supplier</th>
				<th>Nama Supplier</th>
				<th>Tanggal</th>
				<th>Saldo</th>
				<th></th>
			    
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
					<td><a class="btn btn-sm btn-success" href="?page=data_detil_hutang&no_faktur=<?php echo $q[nomor_faktur];?>">Detail</a></td>
				  </tr>
			  <?php
				}
			  }
			  ?>
			</tbody>
		</table>
	</div></div>
</div>
<script>

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
	      
	          "bInfo": true,
	          "bAutoWidth": true
	    });
	 });
</script>