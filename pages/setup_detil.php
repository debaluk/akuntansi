<?php 
session_start();
error_reporting(1);

include "../koneksi.php";

$query=mysqli_query($con,"select * from tabel_keterangan where id_keterangan='$_GET[id]'");
$data=mysqli_fetch_array($query);
//cari akun debetnya
$querydd=mysqli_query($con,"select tabel_setup.*, tabel_akun.nama_akun from tabel_setup, tabel_akun where tabel_setup.id_keterangan='$_GET[id]' and tabel_setup.posisi_akun='Debet' and tabel_setup.id_akun=tabel_akun.id_akun");
$datadd=mysqli_fetch_array($querydd);

//cari akun reditnya
$querykk=mysqli_query($con,"select tabel_setup.*, tabel_akun.nama_akun from tabel_setup, tabel_akun where tabel_setup.id_keterangan='$_GET[id]' and tabel_setup.posisi_akun='Kredit' and tabel_setup.id_akun=tabel_akun.id_akun");

$datakk=mysqli_fetch_array($querykk);



?>
<link href="dist/css/jquery-ui.css" rel="stylesheet" type="text/css" />
    <div class="modal-dialog" id="modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title" id="modalAddBrandLabel">Detail Setup Jurnal</h4>
            </div>
            <form id="simpanvac" name="simpanvac"  action="" method="post" data-toggle="validator" role="form">
       			
             	<div class="modal-body"> 
               		<input type="hidden" name="idlama" value="<?php echo $_GET[id];?>">
					
                   <table width="100%" cellpadding="5" cellspacing="5">
					  <tr>
					    <td>Keterangan</td>
					    <td><input class="form-control" type="text" name="keterangan" id="keterangan" value="<?php echo $data[keterangan];?>" required /></td>
					  </tr>
					  <tr>
					    <td>Akun Posisi Debet</td>
					    <td>
							<select name="debet" id="debet" class="form-control" required>
					    		<option value="<?php echo $datadd[id_akun];?>"><?php echo $datadd[nama_akun];?></option>
					    		<?php
								$queryd=mysqli_query($con,"select * from tabel_akun order by kode_akun asc ");
								while ($datad=mysqli_fetch_array($queryd))
								{ ?>
								
								<option value="<?php echo $datad[id_akun];?>"><?php echo $datad[nama_akun];?></option>
								
								<?php } ?>
							  </select>
						</td>
					  </tr>
					  <tr>
					    <td>Akun Posisi Kredit</td>
					    <td>
							<select name="kredit" id="kredit" class="form-control" required>
					    		<option value="<?php echo $datakk[id_akun];?>"><?php echo $datakk[nama_akun];?></option>
					    		<?php
								$queryk=mysqli_query($con,"select * from tabel_akun order by kode_akun asc ");
								while ($datak=mysqli_fetch_array($queryk))
								{ ?>
								
								<option value="<?php echo $datak[id_akun];?>"><?php echo $datak[nama_akun];?></option>
								
								<?php } ?>
							  </select>
						</td>
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
<script src="dist/js/jquery-ui.js" type="text/javascript"></script>

<script type="text/javascript">
	 $(document).ready(function() {
		$(function() {
			$("#tgl").datepicker({
				dateFormat:'dd-mm-yy'
			});
		});
		
	 });
	 
</script>
<script>
			
	$("#simpanvac").on("submit", function(){
            $.ajax({
                type:"POST",
                url:"pages/setup_akun_save.php",
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