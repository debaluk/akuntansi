<?php 
require "koneksi.php";

//buat nomor jurnal
$querykode=mysqli_query($con,"select * from tabel_jurnal order by id_jurnal desc limit 1");
$datakode=mysqli_fetch_array($querykode);
$kodemak=(int) substr($datakode[nomor_jurnal], 2, 4);
$kodemak++;
$kodejurnal = JU . sprintf("%04s", $kodemak);

$query=mysqli_query($con,"SELECT tabel_jurnal.*, ((SUM(tabel_jurnal.kredit))-(SUM(tabel_jurnal.debet))) AS saldo, tabel_supplier.nama_supplier,tabel_supplier.kode_supplier 
				FROM tabel_jurnal,tabel_supplier
				WHERE tabel_jurnal.referensi=tabel_supplier.kode_supplier AND tabel_jurnal.id_akun='39' and tabel_jurnal.nomor_faktur='$_GET[no_faktur]'");
$q=mysqli_fetch_array($query);
$tgl=date("d-m-Y");


?>
<link href="dist/css/jquery-ui.css" rel="stylesheet" type="text/css" />
<div class="box" style="min-height: 450px;">
    <div class="box-header">
      <h3 class="box-title">Bayar Hutang</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
		<a href="?page=buku_bantu_hutang" style="margin-bottom: 10px;" class="btn btn-md btn-primary"> <i class="fa fa-mail-reply-all"></i> Kembali Buku Hutang</a>
		<div style="margin-top: 20px;">
		
		<form id="simpanvac" name="simpanvac" method="post" action="">
		  <table width="80%">
			<tr height="40"> 
				<td width="200">No. Faktur</td>
				<td>
					<input type="text" name="faktur" id="faktur" style="width:350px;" class="form-control" value="<?php echo $_GET[no_faktur] ;?>" readonly required />
				</td>
				<td width="100"></td>
				<td width="300">Saldo Hutang</td>
				<td><input type="text" name="saldo" id="saldo" class="form-control" value="<?php echo number_format($q[saldo] ,0,',','.')?>"  style="width:250px;" readonly required /></td>
			  
		    </tr>
		    <tr height="40">
		      <td>Keterangan</td>
		      <td><input type="text" name="keterangan" id="keterangan" class="form-control" value="Pembayaran Hutang"  style="width:350px;" readonly required /></td>
			  <td width="100"></td>
			  <td>Tanggal Pembayaran</td>
		      <td><input type="text" name="tglbayar" id="tglbayar" style="width:250px;" class="form-control" value="<?php echo $tgl;?>" required /></td>
		     
		    </tr>
		    <tr height="40">
		      <td>No. Jurnal</td>
		      <td><input type="text" name="nojurnal" id="nojurnal" style="width:350px;" class="form-control" value="<?php echo $kodejurnal ;?>" readonly required /></td>
		      <td width="100"></td>
			  <td>Jumlah Bayar Rp.</td>
		      <td><input type="text" name="jumlahbayar" id="jumlahbayar" style="width:250px;" class="form-control" onkeydown="return numbersonly(this, event); ambilnilai();" onkeyup="javascript:tandaPemisahTitik(this); ambilnilai();" onkeypress="javascript:tandaPemisahTitik(this); ambilnilai();" required  /></td>
		    </tr>
		    <tr height="40">
		      <td>Nama Supplier</td>
				<td>
					<div class="col-md-4 row"><input name="kdsp" type="text" id="kdsp" size="6" maxlength="4" class="form-control" value="<?php echo $q[kode_supplier] ;?>" readonly /></div>
					<div class="col-md-2 row"><input type="text" name="namasp" id="namasp" value="<?php echo $q[nama_supplier] ;?>" class="form-control" style="width:263px;" readonly /></div>
		        </td>
				<td width="100"></td>
		      <td>
				
		      </td>
			  <td><button type="submit" name="simpan" id="simpan" class="btn btn-sm btn-primary"> <i class="fa fa-save"></i> Simpan</button>
			    <button type="reset" class="btn btn-sm btn-primary"> <i class="fa fa-trash"></i> Batal</button>
			    <a href="?page=data_detil_hutang&no_faktur=<?php echo $_GET[no_faktur];?>"><button type="button" class="btn btn-sm btn-primary"> <i class="fa fa-power-off"></i> Keluar</button></a></td>
		    </tr>
			<tr height="40">
		      <td>Nama User</td>
		      <td><input type="text" name="namauser" id="namauser" style="width:350px;" class="form-control" value="<?php echo $_SESSION['username'];?>" readonly required /></td>
		      <td width="100"></td>
			  <td></td>
		      <td></td>
		    </tr>
		  </table>
		  
		  </p>
		  <div class="panel panel-default">
						<div class="panel-heading"><i class="fa fa-file-text-o fa-fw"></i> Data Jurnal</div>
						<div class="panel-body">

							<table width="100%" cellpadding="5" cellspacing="0" border="1" class="table table-bordered" id="tabel">
							    <tr>	
							      <td align="center">No Akun</td>
							      <td align="center">Nama Akun</td>
							      <td align="center">Debet</td>
							      <td align="center">Kredit</td>
							    </tr>
								
							    <tr>
							      <td>2-0200</td>
							      <td>Hutang Dagang</td>
							      <td align="right"><div id="jmldebet" name="jmldebet"></div></td>
							      <td>&nbsp;</td>
							    </tr>
							    <tr>
							      <td>1-0100</td>
							      <td>Kas</td>
							      <td>&nbsp;</td>
							      <td align="right"><div id="jmlkredit" name="jmlkredit"></div></td>
							    </tr>
							   
							  </table>

						</div>
					</div>
		  
		  
		  
		  
		  <p>&nbsp;</p>
		</form>
	</div></div>
</div>


<script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="dist/js/jquery-ui.js" type="text/javascript"></script>
 <script type="text/javascript">
	$(document).ready(function() {
		
		$("#jumlahbeli").change(function(){
			$("#jmldebet").val($(this). Val());
			$("#jmlkredit").val($(this). Val());
			
			//var jmldebet = $("#jmldebet");
			//var jmlkredit = $("#jmlkredit");
			
			//jmldebet.val(jmldebet.val());
			//jmlkredit.val(jmldebet.val());
		}); 
		
		$(function() {
			$("#tglbayar").datepicker({
				dateFormat:'dd-mm-yy'
			});
			
			
		});
		
	 	
	});
	
	$("#simpanvac").on("submit", function(){
		/*var saldoawal, bayar;
		saldoawal = document.getElementById("saldo").value;
		bayar = document.getElementById("jumlahbayar").value;
		sa=saldoawal.replace(/\./g,'')
		br=bayar.replace(/\./g,'')
		
		if (number(br) > sa )
		{
			alert("Jumlah bayar lebih besar saldo");
			
			exit;
		}
		else
		{
			$.ajax({
				type:"POST",
				url:"pages/bayar_hutang_simpan.php",
				data: $('#simpanvac').serialize(),
				success:function(msg){
					alert(msg);
					window.location.href = "?page=data_detil_hutang&no_faktur=<?php echo $_GET[no_faktur];?>";

				}
			});
		}
		*/
		
		$.ajax({
			type:"POST",
			url:"pages/bayar_hutang_simpan.php",
			data: $('#simpanvac').serialize(),
			success:function(msg){
				alert(msg);
				window.location.href = "?page=data_detil_hutang&no_faktur=<?php echo $_GET[no_faktur];?>";

			}

		});
		return false;
    });
		
	$('[id^=jumlahbayar]').keypress(validateNumber);
	
	function ambilnilai(){
		var $titleInput = $("#jumlahbayar");
		var titleValue = $titleInput.val(); 
		
		var $debebt = $("#jmldebet");
		$debebt.text(titleValue);
		
		var $kredit = $("#jmlkredit");
		$kredit.text(titleValue);
		
		
	}
	
	
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