<?php 
require "koneksi.php";

//buat nomor faktur
$querykodef=mysqli_query($con,"select * from tabel_jurnal where keterangan!='Saldo Awal' order by id_jurnal desc limit 1");
$datakodef=mysqli_fetch_array($querykodef);
$kodemakf=(int) substr($datakodef[nomor_faktur], 2, 3);
$kodemakf++;
$kodejurnalf = F . sprintf("%03s", $kodemakf);

//buat nomor jurnal
$querykode=mysqli_query($con,"select * from tabel_jurnal order by id_jurnal desc limit 1");
$datakode=mysqli_fetch_array($querykode);
$kodemak=(int) substr($datakode[nomor_jurnal], 2, 4);
$kodemak++;
$kodejurnal = JU . sprintf("%04s", $kodemak);

$harini = date("d-m-Y");
$idketerangan = $_GET[keterangan_id];

$querykodesetup=mysqli_query($con,"select * from tabel_keterangan where id_keterangan='$_GET[keterangan_id]'");
$dataketerangan=mysqli_fetch_array($querykodesetup);


?>
<link href="dist/css/jquery-ui.css" rel="stylesheet" type="text/css" />
<div class="box" style="min-height: 450px;">
    <div class="box-header">
      <h3 class="box-title">Jurnal Umum</h3>
    </div>
    <div class="box-body">
		<form id="simpanvac" name="simpanvac" method="post" action="">
		<input type="hidden" name="keteranganakun" id="keteranganakun" value="<?php echo $dataketerangan[keterangan];?>"  />
		
		<div style="margin-top: 20px;">
			<table width="80%" border="0">
			  <tr height="40">
			    <td>ID Jurnal</td>
			    <td><input type="text" name="nojurnal" id="nojurnal" value="<?php echo $kodejurnal;?>" class="form-control"  /></td>
				<td width="50"></td>
			   <td>Keterangan</td>
			    <td>
					<select name="keterangan" id="keterangan" class="form-control" required>
					<option value="<?php echo $dataketerangan[id_keterangan];?>"><?php echo $dataketerangan[keterangan];?></option>
					<?php
					$querys=mysqli_query($con,"select * from tabel_keterangan order by id_keterangan asc");
					while ($datas=mysqli_fetch_array($querys))
					{
						?>
						<option value="<?php echo $datas[id_keterangan];?>"><?php echo $datas[keterangan];?></option>
						
						<?php
					}
					?>
					</select>
				</td>
			  </tr>
			  <tr height="40">
			    <td>Nomor Bukti</td>
			    <td><input type="text" name="no_bukti" id="no_bukti" value="<?php echo $kodejurnalf;?>" class="form-control" /></td>
			    <td width="50"></td>
				<td>Jumlah Rp.</td>
			    <td><input type="text" name="jumlah" id="jumlah" class="form-control" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" onkeypress="javascript:tandaPemisahTitik(this);" required   /></td>
			  </tr>
			  <tr height="40">
			    <td>Tanggal</td>
			    <td><input type="text" name="tgljurnal" id="tgljurnal" class="form-control" value="<?php echo $harini;?>" /></td>
			    <td width="50"></td>
				<td>HPP</td>
			    <td>
				
				<?php if ($_GET[keterangan_id]=='1')
				{ ?>
					<input type="text" name="hpp" id="hpp" class="form-control" onkeydown="return numbersonly(this, event); ambilnilai();" onkeyup="javascript:tandaPemisahTitik(this); ambilnilai();" onkeypress="javascript:tandaPemisahTitik(this); " required />
				<?php }
				else
				{ ?> 
					<input type="text" name="hpp" id="hpp" class="form-control" value="0" readonly />
				<?php }
				
				?>
				
				</td>
			  </tr>
			  
			</table>
				
			<table width="250px" cellpadding="0" cellspacing="0" border="1" class="table table-bordered" id="">
				<head>
				<tr>	
				  <th align="center">No Akun</th>
				  <th align="center">Nama Akun</th>
				  <th align="center">Debet</th>
				  <th align="center">Kredit</th>
				</tr>
				<head>
				<?php
				//cari keterangan
				$queryss=mysqli_query($con,"select tabel_setup.*,tabel_akun.* from tabel_setup,tabel_akun 
				where  tabel_setup.id_akun=tabel_akun.id_akun and tabel_setup.id_keterangan='$_GET[keterangan_id]'");
				while ($dataakun=mysqli_fetch_array($queryss))
				{
				?>
				
				<tr>
				  <td width="150px"><?php echo $dataakun[kode_akun];?>
				  <input type="hidden" name="akun[]" value="<?php echo $dataakun[id_akun];?>">
				  <input type="hidden" name="posisi[]" value="<?php echo $dataakun[posisi_akun];?>">
				  </td>
				  <td>
				  <?php
					if ($dataakun[posisi_akun]=='Kredit')
					{ ?>
						<div style="margin-left:50px;"><?php echo $dataakun[nama_akun];?></div>
					<?php }
					else
					{ ?>
						<?php echo $dataakun[nama_akun];?>
					<?php } ?>
				  
				  </td>
				  <td align="right" width="150px">
				  <!--<?php
					if ($dataakun[posisi_akun]=='Debet')
					{
					  ?>
					  <input type="number" name="debet[]" value="" class="form-control">
					  <?php
					}
					if ($dataakun[posisi_akun]=='Kredit')
					{
					  ?>
					  <input type="number" name="debet[]" value="0" class="form-control" readonly>
					  <?php
					}
					?>
				  -->
				  <div id="njmldebet" name="njmldebet">
				  </td>
				  <td align="right" width="150px">
				  <!--<?php
				  if ($dataakun[posisi_akun]=='Debet')
					{
					  ?>
					  <input type="number" name="kredit[]" value="0" class="form-control" readonly>
					  <?php
					}
					if ($dataakun[posisi_akun]=='Kredit')
					{
					  ?>
					  <input type="number" name="kredit[]" value="" class="form-control" >
					  <?php
					}
					?>-->
					<div id="njmlkredit" name="njmlkredit">
				  </td>
				</tr>
				<?php } ?>
			  </table>
				<button type="submit" name="simpan" id="simpan" class="btn btn-sm btn-primary"> <i class="fa fa-save"></i> Simpan</button>			    
				<a href="?page=jurnal_umum"><button type="button" class="btn btn-sm btn-primary"> <i class="fa fa-power-off"></i> Batal</button></a>
		</div>
					
					
		</form>
	</div></div>
</div>

<script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="dist/js/jquery-ui.js" type="text/javascript"></script>
 <script type="text/javascript">
	
	function ambilnilai(){
		var $titleInput = $("#jumlahbeli");
		var titleValue = $titleInput.val(); 
		
		var $debebt = $("#njmldebet");
		$debebt.text(titleValue);
		
		var $kredit = $("#njmlkredit");
		$kredit.text(titleValue);

	}
	
	function ambilhpp(){
		var $titleInput = $("#jumlah");
		var titleValue = $titleInput.val(); 
		
		var $debebt = $("#njmldebet");
		$debebt.text(titleValue);
		
		var $kredit = $("#njmlkredit");
		$kredit.text(titleValue);

	}
	
	$(document).ready(function() {
		
		$('#keterangan').change(function() {
			window.location = "?page=jurnal_umum&keterangan_id=" + $(this).val();
		});
		
		$(function() {
			$("#tgljurnal").datepicker({
				dateFormat:'dd-mm-yy'
			});
			
			
		});
		
	 	
	});
	
	$("#simpanvac").on("submit", function(){
            $.ajax({
                type:"POST",
                url:"pages/jurnal_umum_simpan.php",
                data: $('#simpanvac').serialize(),
                success:function(msg){
                    alert(msg);
					window.location.href = "?page=jurnal_umum";

                }

            });
        	return false;
    });
		
	$('[id^=jumlah]').keypress(validateNumber);
	$('[id^=hpp]').keypress(validateNumber);
	
	function validateNumber(event) {
		var key = window.event ? event.keyCode : event.which;
		if (event.keyCode === 8 || event.keyCode === 46) {
			return true;
		} else if ( key < 48 || key > 57 ) {
			return false;
		} else {
			return true;
		}
	};
	
	
	function tandaPemisahTitik(b){
		var _minus = false;
		if (b<0) _minus = true;
		b = b.toString();
		b=b.replace(".","");
		
		c = "";
		panjang = b.length;
		j = 0;
		for (i = panjang; i > 0; i--){
			 j = j + 1;
			 if (((j % 3) == 1) && (j != 1)){
			   c = b.substr(i-1,1) + "." + c;
			 } else {
			   c = b.substr(i-1,1) + c;
			 }
		}
		if (_minus) c = "-" + c ;
		return c;
	}

	function numbersonly(ini, e){
		if (e.keyCode>=49){
			if(e.keyCode<=57){
			a = ini.value.toString().replace(".","");
			b = a.replace(/[^\d]/g,"");
			b = (b=="0")?String.fromCharCode(e.keyCode):b + String.fromCharCode(e.keyCode);
			ini.value = tandaPemisahTitik(b);
			return false;
			}
			else if(e.keyCode<=105){
				if(e.keyCode>=96){
					//e.keycode = e.keycode - 47;
					a = ini.value.toString().replace(".","");
					b = a.replace(/[^\d]/g,"");
					b = (b=="0")?String.fromCharCode(e.keyCode-48):b + String.fromCharCode(e.keyCode-48);
					ini.value = tandaPemisahTitik(b);
					//alert(e.keycode);
					return false;
					}
				else {return false;}
			}
			else {
				return false; }
		}else if (e.keyCode==48){
			a = ini.value.replace(".","") + String.fromCharCode(e.keyCode);
			b = a.replace(/[^\d]/g,"");
			if (parseFloat(b)!=0){
				ini.value = tandaPemisahTitik(b);
				return false;
			} else {
				return false;
			}
		}else if (e.keyCode==95){
			a = ini.value.replace(".","") + String.fromCharCode(e.keyCode-48);
			b = a.replace(/[^\d]/g,"");
			if (parseFloat(b)!=0){
				ini.value = tandaPemisahTitik(b);
				return false;
			} else {
				return false;
			}
		}else if (e.keyCode==8 || e.keycode==46){
			a = ini.value.replace(".","");
			b = a.replace(/[^\d]/g,"");
			b = b.substr(0,b.length -1);
			if (tandaPemisahTitik(b)!=""){
				ini.value = tandaPemisahTitik(b);
			} else {
				ini.value = "";
			}
			
			return false;
		} else if (e.keyCode==9){
			return true;
		} else if (e.keyCode==17){
			return true;
		} else {
			//alert (e.keyCode);
			return false;
		}

	}
	 
	 
</script>