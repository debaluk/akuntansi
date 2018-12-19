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

$tgl=date("d-m-Y");



?>
<link href="dist/css/jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="dist/css/select2.css" rel="stylesheet" type="text/css" />

<div class="box" style="min-height: 450px;">
    <div class="box-header">
      <h3 class="box-title">Pembelian Kredit</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
		<a href="?page=buku_bantu_hutang" style="margin-bottom: 10px;" class="btn btn-md btn-primary"> <i class="fa fa-mail-reply-all"></i> Kembali Buku Hutang</a>
		<div style="margin-top: 20px;">
		
		<form id="simpanvac" name="simpanvac" method="post" action="">
			<table width="80%">
				<tr height="40">
				<td width="200">No. Faktur</td>
				<td>
					<input type="text" name="faktur" id="faktur" class="form-control" value="<?php echo $kodejurnalf ;?>" required />
				</td>
				<td width="50"></td>
				<td>Kode Supplier</td>
				<td>
					<select name="kdsp" id="kdsp" class="form-control select2" style="width:100%;" required>
						<option value="">-Pilih Supplier -</option>
						<?php
						$hasilsp  = mysqli_query($con, "SELECT * FROM tabel_supplier ORDER BY nama_supplier ASC");
						while($datasp= mysqli_fetch_array($hasilsp))
						{
							?>
							<option value="<?php echo $datasp[kode_supplier];?>"><?php echo $datasp[nama_supplier];?></option>
							<?php
						}
						?>
						
						
					</select>
					
				</td>
		    </tr>
		    <tr height="40">
		      <td>Keterangan</td>
		      <td><input type="text" name="keterangan" id="keterangan" value="Pembelian Kredit" class="form-control"  readonly required />
			  </td>
			  <td width="50"></td>
		      <td>Tanggal Pembelian</td>
		      <td><input type="text" name="tglbeli" id="tglbeli" value="<?php echo $tgl;?>" class="form-control" required /></td>
		    </tr>
		    <tr height="40">
		      <td>No. Jurnal</td>
		      <td><input type="text" name="nojurnal" id="nojurnal" class="form-control" value="<?php echo $kodejurnal ;?>" readonly required /></td>
		      <td width="50"></td>
			  <td>Jumlah Rp.</td>
		      <td><input type="text" name="jumlahbeli" id="jumlahbeli" value="" class="form-control" onkeydown="return numbersonly(this, event); ambilnilai();" onkeyup="javascript:tandaPemisahTitik(this); ambilnilai();" onkeypress="javascript:tandaPemisahTitik(this); ambilnilai();" required  /></td>
		    </tr>
			
			<tr height="40">
		      <td>Nama User</td>
		      <td><input type="text" name="namauser" id="namauser" value="<?php echo $_SESSION['username'];?>" class="form-control"  readonly required /></td>
		      <td width="50"></td>
			  <td></td>
		      <td>
					<button type="submit" name="simpan" id="simpan" class="btn btn-sm btn-primary"> <i class="fa fa-save"></i> Simpan</button>
					<button type="reset" class="btn btn-sm btn-primary"> <i class="fa fa-trash"></i> Batal</button>
					<a href="?page=buku_bantu_hutang"><button type="button" class="btn btn-sm btn-primary"> <i class="fa fa-power-off"></i> Keluar</button></a>
			  </td>
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
							      <td>1-0103</td>
							      <td>Persediaan Barang</td>
							      <td align="right"><div id="njmldebet" name="njmldebet"></div></td>
							      <td>&nbsp;</td>
							    </tr>
							    <tr>
							      <td>2-0200</td>
							      <td>Hutang Dagang</td>
							      <td>&nbsp;</td>
							      <td align="right"><div id="njmlkredit" name="njmlkredit"></div></td>
							    </tr>
							   
							  </table>

						</div>
					</div>
		  
		  
		  
		  
		  <p>&nbsp;</p>
		</form>
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
	function ambilnilai(){
		var $titleInput = $("#jumlahbeli");
		var titleValue = $titleInput.val(); 
		
		var $debebt = $("#njmldebet");
		$debebt.text(titleValue);
		
		var $kredit = $("#njmlkredit");
		$kredit.text(titleValue);

	}

</script>

<script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="dist/js/jquery-ui.js" type="text/javascript"></script>
<script src="dist/js/select2.js" type="text/javascript"></script>

<!--<script type="text/javascript">
    $(function(){
       $('.select2').select2({
           minimumInputLength: 3,
           allowClear: true,
           placeholder: 'Ketik kode supplier',
           ajax: {
              dataType: 'json',
              url: 'listsupplier.php',
              delay: 800,
              data: function(params) {
                return {
                  search: params.term
                }
              },
              processResults: function (data, page) {
              return {
                results: data
              };
            },
          }
      }).on('select2:select', function (evt) {
         var data = $(".select2 option:selected").text();
         alert("Data yang dipilih adalah "+data);
      });
 });
</script>
-->

 <script type="text/javascript">
	$(document).ready(function() {
		$("#kdsp").select2({
            placeholder: "Select Destination"
		});
		
		$(function() {
			$("#tglbeli").datepicker({
				dateFormat:'dd-mm-yy'
			});
			
			
		});
		
	 	
	});
	
	
	
	
	
	$("#simpanvac").on("submit", function(){
            $.ajax({
                type:"POST",
                url:"pages/pembelian_kredit_simpan.php",
                data: $('#simpanvac').serialize(),
                success:function(msg){
                    alert(msg);
					window.location.href = "?page=pembelian_kredit";

                }

            });
        	return false;
    });
		
	$('[id^=jumlahbeli]').keypress(validateNumber);
	
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