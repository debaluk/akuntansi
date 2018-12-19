<?php 
require "koneksi.php";

$listjurnal=mysqli_query($con,"select * from tabel_jurnal where nomor_jurnal='$_GET[nojurnal]' order by id_jurnal asc");
$datajurnal=mysqli_fetch_array($listjurnal);
//cari id keterangan
$idket=mysqli_query($con,"select * from tabel_keterangan where keterangan='$datajurnal[keterangan]'");
$dataidketerangan=mysqli_fetch_array($idket);

?>
<link href="dist/css/jquery-ui.css" rel="stylesheet" type="text/css" />
<div class="box" style="min-height: 450px;">
    <div class="box-header">
      <h3 class="box-title">Edit Jurnal Umum</h3>
    </div>
    <div class="box-body">
		<form id="simpanvac" name="simpanvac" method="post" action="">
		
		<input type="hidden" name="keteranganakun" id="keteranganakun" value="<?php echo $dataidketerangan[id_keterangan];?>"  />
		<input type="hidden" name="nomorfaktur" id="nomorfaktur" value="<?php echo $datajurnal[nomor_jurnal];?>"  />
		
		<div style="margin-top: 20px;">
			<table width="80%" border="0">
			  <tr height="40">
			    <td>ID Jurnal</td>
			    <td><input type="text" name="nojurnal" id="nojurnal" value="<?php echo $datajurnal[nomor_jurnal];?>" class="form-control" readonly required   /></td>
				<td width="50"></td>
			   <td>Keterangan</td>
			    <td>
					<input type="text" name="keterangan" id="keterangan" value="<?php echo $datajurnal[keterangan];?>" class="form-control" readonly/>
					
				</td>
			  </tr>
			  <tr height="40">
			    <td>Nomor Bukti</td>
			    <td><input type="text" name="no_bukti" id="no_bukti" value="<?php echo $datajurnal[nomor_faktur];?>" class="form-control" readonly /></td>
			    <td width="50"></td>
				<td>Jumlah Rp.</td>
			    <td>
			    	<input type="number" min="1" name="jumlah" id="jumlah" value="<?php echo $datajurnal[debet];?>" class="form-control" onkeydown="ambilnilai();" onkeyup="ambilnilai();" onkeypress="ambilnilai();" required /></td>
			  </tr>
			  <tr height="40">
			    <td>Tanggal</td>
			    <td><input type="text" name="tgljurnal" id="tgljurnal" class="form-control" value="<?php echo $datajurnal[tgl_jurnal];?>" /></td>
			    <td width="50"></td>
				<td>HPP</td>
			    <td>
				
				<?php 
				$jurnalhpp=mysqli_query($con,"select * from tabel_jurnal where nomor_jurnal='$_GET[nojurnal]' and id_akun='42'");
				$datahpp=mysqli_fetch_array($jurnalhpp);
				
				if ($datahpp[debet])
				{ 
					
				?>
					<input type="number" min="1" name="hpp" id="hpp" value="<?php echo $datahpp[debet];?>" class="form-control" onkeydown="ambilhpp();" onkeyup="ambilhpp();" onkeypress="ambilhpp();" required />
				<?php }
				else
				{ ?> 
					<input type="number"  min="1" name="hpp" id="hpp" class="form-control" value=""  />
				<?php }
				
				?>
				
				</td>
			  </tr>
			  <tr height="40">
			    <td>Nama User</td>
			    <td><input type="text" name="namauser" id="namauser" class="form-control" value="<?php echo $_SESSION[username];?>" readonly /></td>
			    <td width="50"></td>
				<td></td>
			    <td>
				
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
				
				//ambil nilai jurnal sesuai dengan nomor jurnal dan id akun
				$carijurnal=mysqli_query($con,"select * from tabel_jurnal where nomor_jurnal='$_GET[nojurnal]' order by id_jurnal asc");
				while ($hasilcarijurnal=mysqli_fetch_array($carijurnal))
				{
					
					//cari akun
					$caridataakun=mysqli_query($con,"select * from tabel_akun where id_akun='$hasilcarijurnal[id_akun]'");
					$dataakun=mysqli_fetch_array($caridataakun);
					
				?>
					
					<tr>
					  <td width="150px"><?php echo $dataakun[kode_akun];?>
					  <input type="hidden" name="akun[]" value="<?php echo $dataakun[id_akun];?>">
					 <input type="hidden" name="idjurnal[]" value="<?php echo $hasilcarijurnal[id_jurnal];?>">
					  </td>
					  <td>
					  <?php
						if ($hasilcarijurnal[debet] > 0)
						{ ?>
							<div><?php echo $dataakun[nama_akun];?></div>
							
						<?php }
						else
						{ ?>
							<div style="margin-left:50px;"><?php echo $dataakun[nama_akun];?></div>
						<?php } ?>
					  
					  </td>
					  <td align="right" width="150px">
							<?php
							if ($hasilcarijurnal[debet] > 0)
							{ 
								
								if (($hasilcarijurnal[id_akun]=='35' or $hasilcarijurnal[id_akun]=='42') and $hasilcarijurnal[keterangan]=='Penjualan Barang')
								{
									?>
									<div id="njmldebethpp" name="njmldebethpp"><?php echo $hasilcarijurnal[debet];?></div> 
									<input type="hidden" name="nilaidd[]" id="ddhpp" value="<?php echo $hasilcarijurnal[debet];?>">
									<?php
								}
								
								else
								{
									?>
									<div id="njmldebet" name="njmldebet"><?php echo $hasilcarijurnal[debet];?></div>
									<input type="hidden" name="nilaidd[]" id="dd" value="<?php echo $hasilcarijurnal[debet];?>">
									<?php
								}
						
							} 
							else
							{
								?>
								<input type="hidden" name="nilaidd[]" id="ddf" value="<?php echo $hasilcarijurnal[debet];?>">
							<?php } 		?>
							
							
							
					  </td>
					  <td align="right" width="150px">
							<?php
							
							if ($hasilcarijurnal[kredit] > 0)
							{
								if (($hasilcarijurnal[id_akun]=='35' or $hasilcarijurnal[id_akun]=='42') and $hasilcarijurnal[keterangan]=='Penjualan Barang')
								{
									?>
									<div id="njmlkredithpp" name="njmlkredithpp"><?php echo $hasilcarijurnal[kredit];?></div> 
									<input type="hidden" name="nilaikk[]" id="kkhpp" value="<?php echo $hasilcarijurnal[kredit];?>">
									
									<?php
								}
								else
								{
									?>
									<div id="njmlkredit" name="njmlkredit"><?php echo $hasilcarijurnal[kredit];?></div> 
									<input type="hidden" name="nilaikk[]" id="kk" value="<?php echo $hasilcarijurnal[kredit];?>">
									
									<?php
								}
							  
							}
							else
							{
								?>
								<input type="hidden" name="nilaikk[]" id="kkf" value="<?php echo $hasilcarijurnal[kredit];?>">
							<?php } 		
							?>
							
							
							
						</td>
					</tr>
				<?php
				} ?>
				
			  </table>
				<button type="submit" name="simpan" id="simpan" class="btn btn-sm btn-primary"> <i class="fa fa-save"></i> Update</button>			    
				<a href="?page=lap_jurnal_umum&awal=<?php echo $_GET[awal];?>&akhir=<?php echo $_GET[akhir];?>&tahun=<?php echo $_GET[tahun];?>&view=Tampilkan"><button type="button" class="btn btn-sm btn-primary"> <i class="fa fa-power-off"></i> Batal</button></a>
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
		var $titleInput = $("#jumlah");
		var titleValue = $titleInput.val(); 
		
		var $debebt = $("#njmldebet");
		$debebt.text(titleValue);
		$("#dd").val(titleValue);
		
		var $kredit = $("#njmlkredit");
		$kredit.text(titleValue);
		$("#kk").val(titleValue);

	}
	
	function ambilhpp(){
		var $titleInput = $("#hpp");
		var titleValue = $titleInput.val(); 
		
		var $debebt = $("#njmldebethpp");
		$debebt.text(titleValue);
		$("#ddhpp").val(titleValue);
		
		var $kredit = $("#njmlkredithpp");
		$kredit.text(titleValue);
		$("#kkhpp").val(titleValue);

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
                url:"pages/jurnal_umum_simpan_edit.php",
                data: $('#simpanvac').serialize(),
                success:function(msg){
                    alert(msg);
					window.location.href ="?page=lap_jurnal_umum&awal=<?php echo $_GET[awal];?>&akhir=<?php echo $_GET[akhir];?>&tahun=<?php echo $_GET[tahun];?>&view=Tampilkan";
					//console.log(msg);
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