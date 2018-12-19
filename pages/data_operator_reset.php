<?php 
session_start();
error_reporting(1);

include "../koneksi.php";


$query=mysqli_query($con,"select * from tabel_operator where id_operator='$_GET[id]'");
$data=mysqli_fetch_array($query);

if ($_GET[id])
{
	$kdoperator = $data[kode];
}
else {
	$kdoperator=$kodeoperator;
}
?>
    <div class="modal-dialog" id="modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title" id="modalAddBrandLabel">Ubah Password</h4>
            </div>
            <form id="simpanvac" name="simpanvac"  action="" method="post" data-toggle="validator" role="form">
       			
             	<div class="modal-body"> 
               		<input type="hidden" name="idlama" value="<?php echo $_GET[id];?>">
                   <table width="100%" cellpadding="5" cellspacing="5">
					  <tr>
					    <td>Kode Operator</td>
					    
					    <td><?php echo $kdoperator;?></td>
					  </tr>
					  
					  <tr>
					    <td>Level Operator</td>
					    <td ><?php echo $data[level];?></td>
					  </tr>
					  <tr>
					    <td>Nama Lengkap</td>
					    
					    <td><?php echo $data[namalengkap];?></td>
					  </tr>
					  <tr>
					    <td>Nama Login</td>
					    <td>
					    	<?php echo $data[username];?>
					  </tr>
					  <tr>
					    <td>Password Baru</td>
					    <td><input class="form-control" type="password" id="passwordbaru" name="passwordbaru" required></td>
					  </tr>
					  <tr>
					    <td>Ulang Password Baru</td>
					    <td><input class="form-control" type="password" id="passwordbaruu" name="passwordbaruu" required></td>
					  </tr>
					  
					</table>
					</div>
	            <div class="row"><br></div>
	            <div class="modal-footer">
	                <input type="submit" Value="Simpan" class="btn btn-primary">
	                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>              
	            </div>
            </form>
        </div>
    </div>
<script>
			
	$("#simpanvac").on("submit", function(){
            $.ajax({
                type:"POST",
                url:"pages/data_operator_simpan_reset_password.php",
                data: $('#simpanvac').serialize(),
                success:function(msg){
                    alert(msg);
                    $('#ajaxModal').modal('toggle'); 
                //    $('modal').close();
                    $(".ajaxModal").bind('ajax:complete', function() {$.modal.close();});
                    window.location.reload();
                }

            });
        return false;
    });
	
    
</script>