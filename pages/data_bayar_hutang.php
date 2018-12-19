<?php 
session_start();
error_reporting(1);

include "../koneksi.php";

$query=mysqli_query($con,"select * from tabel_akun where id_akun='$_GET[idakun]'");
$data=mysqli_fetch_array($query);

if ($data[awal_debet] > $data[awal_kredit])
{
	$saldoawal = $data[awal_debet];
	$dk ='D';
}
else
{
	$saldoawal = $data[awal_kredit];
	$dk ='K';
}

?>
<link href="dist/css/jquery-ui.css" rel="stylesheet" type="text/css" />
    <div class="modal-dialog" id="modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title" id="modalAddBrandLabel">Bayar Hutang</h4>
            </div>
            <form id="simpanvac" name="simpanvac"  action="" method="post" data-toggle="validator" role="form">
       			
             	<div class="modal-body"> 
               		<input type="hidden" name="idlama" value="<?php echo $_GET[idakun];?>">
                   <table width="100%" cellpadding="5" cellspacing="5">
					  <tr>
					    <td>Jenis Akun</td>
					    <td colspan="2"><select name="tipe" id="tipe" class="form-control">
					    		<option value="<?php echo $data[tipe_akun];?>"><?php echo $data[tipe_akun];?></option>
							                    <option value="Aktiva">Aktiva</option>
							                    <option value="Kewajiban">Kewajiban</option>
							                    <option value="Modal">Modal</option>
							                    <option value="Pendapatan">Pendapatan</option>
							                    <option value="HPP">HPP</option>
							                    <option value="Biaya">Biaya</option>
							                  </select></td>
					  </tr>
					  <tr>
					    <td>Kode Akun</td>
					    <td width="50"><input class="form-control" type="text" name="kd" id="kd" value="<?php echo substr($data[kode_akun],0, 1);?>" /></td>
					    <td><input class="form-control" type="text" name="nomorakun" id="nomorakun" value="<?php echo substr($data[kode_akun],2);?>"/></td>
					  </tr>
					  <tr>
					    <td>Nama Akun</td>
					    <td colspan="2"><input class="form-control" type="text" name="namaakun" id="namaakun"  value="<?php echo $data[nama_akun];?>"/></td>
					  </tr>
					  <tr>
					    <td>Tanggal</td>
					    <td colspan="2"><input class="form-control" type="text" id="tgl" name="tgl" value="<?php echo $data[tanggal_awal];?>" ></td>
					  </tr>
					  <tr>
					    <td>Saldo Awal</td>
					    <td width="60px"><select class="form-control" name="dk" id="dk">
					    	<option value="<?php echo $dk;?>"><?php echo $dk;?></option>
					      <option value="D">D</option>
					      <option value="K">K</option>
					    </select></td>
					    <td><input type="text" class="form-control" name="saldoawal" id="saldoawal" value="<?php echo $saldoawal;?>" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" onkeypress="javascript:tandaPemisahTitik(this);" required /></td>
					  </tr>
					</table>
					</div>
	            <div class="row"><br></div>
	            <div class="modal-footer">
	                <input type="submit" Value="Simpan" class="btn btn-primary">
	                <a href="?page=data_detil_hutang&no_faktur=<?php echo $_GET[no_faktur];?>" style="margin-bottom: 10px;" class="btn btn-md btn-primary"> <i class="fa fa-mail-reply-all"></i> Batal</a>            
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
		
		$('[id^=saldoawal]').keypress(validateNumber);
		 
	 	
	 });
	 
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
	
	
</script>