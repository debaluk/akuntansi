<?php 
session_start();
error_reporting(1);

include "../koneksi.php";

//membuat kode operator
$querykode=mysqli_query($con,"select * from tabel_operator order by id_operator desc limit 1");
$datakode=mysqli_fetch_array($querykode);
$kodemak=(int) substr($datakode[kode], 2, 3);
$kodemak++;
$kodeoperator = K . sprintf("%03s", $kodemak);

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
                 <h4 class="modal-title" id="modalAddBrandLabel">Data Operator</h4>
            </div>
            <form id="simpanvac" name="simpanvac"  action="" method="post" data-toggle="validator" role="form">
       			
             	<div class="modal-body"> 
               		<input type="hidden" name="idlama" value="<?php echo $_GET[id];?>">
                   <table width="100%" cellpadding="5" cellspacing="5">
					  <tr>
					    <td>Kode Operator</td>
					    
					    <td><input class="form-control" type="text" name="kode" id="kode" value="<?php echo $kdoperator;?>" readonly="readonly"/></td>
					  </tr>
					  
					  <tr>
					    <td>Level Operator</td>
					    <td ><select name="tipe" id="tipe" class="form-control">
					    		<option value="<?php echo $data[level];?>"><?php echo $data[level];?></option>
							                    <option value="Admin">Admin</option>
							                    <option value="Super Admin">Super Admin</option>
							                    
							                  </select></td>
					  </tr>
					  <tr>
					    <td>Nama Lengkap</td>
					    
					    <td><input class="form-control" type="text" name="namalengkap" id="namalengkap" value="<?php echo $data[namalengkap];?>"/></td>
					  </tr>
					  <tr>
					    <td>Nama Login</td>
					    <td>
					    	<?php if ($_GET[id])
							{ ?>
								<input class="form-control" type="text" name="namauser" id="namauser"  value="<?php echo $data[username];?>" readonly="readonly"/></td>
							<?php }
							else { ?>
								<input class="form-control" type="text" name="namauser" id="namauser"  value="<?php echo $data[username];?>"/></td>
							<?php } ?>
					    	
					  </tr>
					  <?php
					  if ($_GET[id]=='')
					  {
						  ?>
					  <tr>
					    <td>Password</td>
					    <td><input class="form-control" type="password" id="pwd" name="pwd" value="<?php echo $data[password];?>" ></td>
					  </tr>
					  <tr>
					    <td>Password Ulang</td>
					    <td><input class="form-control" type="password" id="pwdualang" name="pwdualang" value="<?php echo $data[password];?>" ></td>
					  </tr>
					  <?php }
						

					  ?>
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
                url:"pages/data_operator_simpan.php",
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