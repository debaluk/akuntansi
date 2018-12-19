<?php 
require "koneksi.php";

//cari data
$query=mysqli_query($con,"SELECT tabel_jurnal.*, tabel_supplier.nama_supplier,tabel_supplier.kode_supplier 
				FROM tabel_jurnal,tabel_supplier
				WHERE tabel_jurnal.referensi=tabel_supplier.kode_supplier AND tabel_jurnal.nomor_faktur='$_GET[no_faktur]'
				ORDER BY tabel_jurnal.id_jurnal asc");
$q=mysqli_fetch_array($query);

?>
<link href="dist/css/jquery-ui.css" rel="stylesheet" type="text/css" />
<div class="box" style="min-height: 450px;">
    <div class="box-header">
      <h3 class="box-title">Detail Hutang</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
		<a href="?page=buku_bantu_hutang" style="margin-bottom: 10px;" class="btn btn-md btn-primary"> <i class="fa fa-mail-reply-all"></i> Kembali Buku Hutang</a>
		<div style="margin-top: 20px;">
		
		<form id="simpanvac" name="simpanvac" method="post" action="">
			<div class="row">
				<div class="col-md-2">No. Faktur</div>
				<div class="col-md-2">
					<input type="text" name="faktur" id="faktur" class="form-control" value="<?php echo $_GET[no_faktur] ;?>" readonly />
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">Kode Supplier</div>
				<div class="col-md-2">
					<input name="namasp2" type="text" id="namasp2" size="6" maxlength="4" class="form-control" value="<?php echo $q[kode_supplier] ;?>" readonly />
				</div>
				<div class="col-md-4" style="margin-left:-20px;">
					 <input type="text" name="namasp" id="namasp" class="form-control" value="<?php echo $q[nama_supplier] ;?>"  readonly />
				</div>
			</div>
			
			</p>
			</p>
			
		  
		  		<a id="add" href="?page=bayar_hutang&no_faktur=<?php echo $_GET[no_faktur];?>" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Bayar Hutang</a>	
			    <a id="add" href="?page=retur&no_faktur=<?php echo $_GET[no_faktur];?>" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Reture Pembelian</a>	
				<a href="?page=buku_bantu_hutang"><button type="button" class="btn btn-sm btn-primary"> <i class="fa fa-power-off"></i> Keluar</button></a></td>
		    	
		  </p>
		  
				<table width="100%" cellpadding="5" cellspacing="0" border="1" class="table table-bordered" id="tabel">
					<thead>
						<tr>	
						  <th align="center">Tanggal</th>
						  <th align="center">Keterangan</th>
						  <th align="center">Debet</th>
						  <th align="center">Kredit</th>
						  <th align="center">Saldo</th>
						</tr>
					</thead>
					<?php
					$count=1;
					$datajurnal = mysqli_query($con,"SELECT tabel_jurnal.*, tabel_supplier.nama_supplier,tabel_supplier.kode_supplier 
								FROM tabel_jurnal,tabel_supplier
								WHERE tabel_jurnal.referensi=tabel_supplier.kode_supplier AND tabel_jurnal.nomor_faktur='$_GET[no_faktur]' and tabel_jurnal.id_akun='39'
								ORDER BY tabel_jurnal.id_jurnal asc");
					
					while($qj=mysqli_fetch_array($datajurnal))
					{ 
						
						if($count==1)
						{
							$saldo=$qj['kredit']
							?>	
							<tr>
							  <td><?php echo $qj[tgl_jurnal];?></td>
							  <td><?php echo $qj[keterangan];?></td>
							  <td align="right"><?php echo number_format($qj[debet] ,0,',','.')?></td>
							  <td align="right"><?php echo number_format($qj[kredit] ,0,',','.')?></td>
							  <td align="right"><?php echo number_format($saldo ,0,',','.')?></td>
							</tr>
							<?php
						}
						else
						{
							$saldo=$saldo-$qj['debet']
							?>	
							<tr>
							  <td><?php echo $qj[tgl_jurnal];?></td>
							  <td><?php echo $qj[keterangan];?></td>
							   <td align="right"><?php echo number_format($qj[debet] ,0,',','.')?></td>
							  <td align="right"><?php echo number_format($qj[kredit] ,0,',','.')?></td>
							  <td align="right"><?php echo number_format($saldo ,0,',','.')?></td>
							</tr>
							<?php
						}
						$count++;
					}
					
					?>
					
					
					
				   
				  </table>

		  
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

</script>

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