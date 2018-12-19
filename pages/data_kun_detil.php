<?php 
session_start();
error_reporting(1);

include "../koneksi.php";

$query=mysqli_query($con,"select * from tabel_akun where id_akun='$_GET[idakun]'");
$data=mysqli_fetch_array($query);

if ($data[awal_debet] > 0)
{
	$saldoawal=$data[awal_debet];
	
}
else if ($data[awal_kredit] > 0) 
{
	$saldoawal="-".$data[awal_kredit];
}
else
{
	$saldoawal=0;
}

if ($_GET[idakun])
{
	$tgl = date("d-m-Y", strtotime($data[tanggal_awal]));
}
else
{
	$tgl = date("d-m-Y");
}
//cari jurnal jika ada saldo awal
$queryawal=mysqli_query($con,"select * from tabel_jurnal where id_akun='$_GET[idakun]' and keterangan='Saldo Awal'");
$dataawal=mysqli_fetch_array($queryawal);

?>
<link href="dist/css/jquery-ui.css" rel="stylesheet" type="text/css" />
    <div class="modal-dialog" id="modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title" id="modalAddBrandLabel">Akun Detail</h4>
            </div>
            <form id="simpanvac" name="simpanvac"  action="" method="post" data-toggle="validator" role="form">
       			
             	<div class="modal-body"> 
               		<input type="hidden" name="idlama" value="<?php echo $_GET[idakun];?>">
					<input type="hidden" name="jurnal" value="<?php echo $dataawal[id_jurnal];?>">
                   <table width="100%" cellpadding="5" cellspacing="5">
					  <tr>
					    <td>Jenis Akun</td>
					    <td colspan="2">
					    	<?php if ($_GET[idakun]) 
					    	{ ?>
					    		<select name="tipe" id="tipe" class="form-control" onchange="ambilkode()" required readonly >
					    			<option value="<?php echo $data[tipe_akun];?>"><?php echo $data[tipe_akun];?>
								</select>
					    	<?php }
					    	else
					    	{
					    		?>
					    		<select name="tipe" id="tipe" class="form-control" onchange="ambilkode()" required >
					    			<option value="<?php echo $data[tipe_akun];?>"><?php echo $data[tipe_akun];?></option>
							                    <option value="Aktiva">Aktiva</option>
							                    <option value="Kewajiban">Kewajiban</option>
							                    <option value="Modal">Modal</option>
							                    <option value="Pendapatan">Pendapatan</option>
							                    <option value="HPP">HPP</option>
							                    <option value="Biaya">Biaya</option>
								</select>
					    		<?php
					    	}
					    	?>

					    	
						</td>
					  </tr>
					  <tr>
					    <td>Kode Akun</td>
					    <td width="50">
					    	<input class="form-control" type="text" name="kd" id="kd" value="<?php echo substr($data[kode_akun],0, 1);?>" <?php if ($_GET[idakun]) { echo "readonly"; } ?> /></td>
					    <td><input class="form-control" type="text" name="nomorakun" id="nomorakun" value="<?php echo substr($data[kode_akun],2);?>" required <?php if ($_GET[idakun]) { echo "readonly"; } ?> /></td>
					  </tr>
					  <tr>
					    <td>Nama Akun</td>
					    <td colspan="2"><input class="form-control" type="text" name="namaakun" id="namaakun"  value="<?php echo $data[nama_akun];?>"/ required></td>
					  </tr>
					  <tr>
					    <td>Tanggal</td>
					    <td colspan="2"><input class="form-control" type="text" id="tgl" name="tgl" value="<?php echo $tgl;?>" required ></td>
					  </tr>
					  <tr>
					    <td>Saldo Awal</td>
					    <td width="60px"><select class="form-control" name="dk" id="dk" required>
					    	<option value="<?php echo $dk;?>"><?php echo $dk;?></option>
					      <option value="D">D</option>
					      <option value="K">K</option>
					    </select></td>
					    <td colspan="2"><input type="number" class="form-control" name="saldoawal" id="saldoawal" value="<?php echo $saldoawal;?>" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" onkeypress="javascript:tandaPemisahTitik(this);" /></td>
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
			url:"pages/data_akun_save.php",
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
	
	//ajak onclick combo jenis, hanya mengambil jenis saja
	
	function ambilkode()
	{
		var cbo = document.getElementById("tipe");
		if($("#tipe").val()=='Aktiva')
		{
			$("#kd").val('1');
		}
		else if ($("#tipe").val()=='Kewajiban')
		{
			$("#kd").val('2');
		}
		else if ($("#tipe").val()=='Modal')
		{
			$("#kd").val('3');
		}
		else if ($("#tipe").val()=='Pendapatan')
		{
			$("#kd").val('4');
		}
		else if ($("#tipe").val()=='HPP')
		{
			$("#kd").val('5');
		}
		else if ($("#tipe").val()=='Biaya')
		{
			$("#kd").val('6');
		}
		else
		{
			$("#kd").val('');
		}
		//alert("The selected value is " + cbo.options[cbo.selectedIndex].value);
	
	}
	
	
</script>