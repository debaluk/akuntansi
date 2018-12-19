<?php 
require "koneksi.php";

//membuat kode supplier
$querykode=mysqli_query($con,"select * from tabel_supplier order by id_supplier desc limit 1");
$datakode=mysqli_fetch_array($querykode);
if (mysqli_num_rows($querykode) > 0)
{
	$kodemak=(int) substr($datakode[kode_supplier], 2, 4);
	$kodemak++;
	$kodesp = S . sprintf("%04s", $kodemak);
}
else
{
	$kodesp = "S0001";
}
if ($_GET[id])
{
	$cekdata=mysqli_query($con,"select * from tabel_supplier where id_supplier='$_GET[id]'");
	$dataada=mysqli_fetch_array($cekdata);	
	$kdsp = $dataada[kode_supplier];
	
	//cari jurnal terkair
	$cekdataj=mysqli_query($con,"select * from tabel_jurnal where referensi='$kdsp' and keterangan='Saldo Awal'");
	$dataadaj=mysqli_fetch_array($cekdataj);	
	$kdspj = $dataadaj[id_jurnal];
	$tgl=date("d-m-Y", strtotime($dataada[tanggal]));
	
}
else {
	$kdsp=$kodesp;
	$kdspj='';
	$tgl=date("d-m-Y");
}

?>
<link href="dist/css/jquery-ui.css" rel="stylesheet" type="text/css" />
<div class="box" style="min-height: 450px;">
    <div class="box-header">
      <h3 class="box-title">Data Supplier</h3>
    </div><!-- /.box-header -->
    <div class="box-body">

		<form id="simpanvac" name="simpanvac" method="post" action="?page=data_supplier" data-toggle="validator" role="form">
		<input type="hidden" name="idlama" value="<?php echo $_GET[id];?>">
		<input type="hidden" name="idjurnal" value="<?php echo $kdspj;?>">
		
		<table width="80%" border="0">
		  <tr>
		    <td>Kode Suppplier</td>
		    <td><input type="text" name="kdsp" id="kdsp" value="<?php echo $kdsp;?>" readonly="readonly" class="form-control" /></td>
			<td width="50"></td>
		    <td>Tanggal</td>
		    <td>
				<input type="text" name="tglsp" id="tglsp" value="<?php echo $tgl;?>" class="form-control" required />
			
			</td>
		  </tr>
		  <tr>
		    <td>Nama Supplier</td>
		    <td><input type="text" name="nmsp" id="nmsp" value="<?php echo $dataada[nama_supplier];?>" class="form-control" required  /></td>
			<td></td>
		    <td>Saldo Awal</td>
		    <td>
				<input type="text" name="sasp" id="sasp" class="form-control" value="<?php echo $dataada[saldo_awal];?>" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" onkeypress="javascript:tandaPemisahTitik(this);"  /></td>
		  </tr>
		  <tr>
		    <td>Alamat Supplier</td>
		    <td><input type="text" name="almsp" id="almsp" class="form-control" value="<?php echo $dataada[alamat_supplier];?>" class="form-control" /></td>
		    <td></td>
			<td>&nbsp;</td>
		    <td>
		    	
		    	<input type="submit" name="simpan" class="btn btn-sm btn-primary" value="Simpan">
			    <a href="?page=data_supplier"><input type="button" name="batal" class="btn btn-sm btn-primary" value="Batal"></a>
		  </tr>
		  <tr>
		    <td>Nomor Telepon</td>
		    <td><input type="text" name="telpsp" id="telpsp" class="form-control" value="<?php echo $dataada[telepon_supplier];?>" class="form-control" required   /></td>
		    <td></td>
			<td>&nbsp;</td>
		    <td>&nbsp;</td>
		  </tr>
		</table>
	</form>
		
		<div style="margin-top: 20px;">
		<table width="100%" class="table table-bordered" id="tabel">
		<thead>
			
		  <tr>
		    <th>Kode Supplier</th>
		    <th>Nama Supplier</th>
			<th>Alamat Supplier</th>
			<th>Nomor Telepon</th>
			<th>Tanggal</th>
		    <th>Saldo Awal</th>
			<th></th>
		  </tr>
		</thead>
		<tbody>
			<?php
			$query=mysqli_query($con,"select * from tabel_supplier order by kode_supplier asc");
		  	$no=1;
		  while($q=mysqli_fetch_array($query)){
		  ?>
		  <tr>
		    <td><?php echo $q['kode_supplier']?></td>           
		    <td><?php echo $q['nama_supplier']?></td>
			<td><?php echo $q['alamat_supplier']?></td>
			<td><?php echo $q['telepon_supplier']?></td>
		    
		   <td align="right" ><?php echo date('d-m-Y',strtotime($q['tanggal'])) ; ?></td>
		    <td align="right"><?php echo number_format($q['saldo_awal'],0,',','.')?></td>
		   <th>
		   	<a class="btn btn-sm btn-success" href="?page=data_supplier&id=<?php echo $q[id_supplier];?>">Edit</a>
		    	<!--<a class="btn btn-sm btn-danger" onclick="javascript: deldata('<?php echo $q['id_supplier'];?>')">Hapus</a>-->
		   </th>
		  </tr>
		  <?php
		  }
		  ?>
		</tbody>
		</table>
	</div></div>
</div>

<script>
	function deldata(id){
	        var status=confirm("Hapus data Supplier ?");
	        if(status){
	            $.ajax({
	                url:"pages/data_supplier_hapus.php",
	                type:"POST",
	                data:"id="+id,
	                success:function(msg){
	                    alert(msg);
	                    //loaddata();
	                    document.location.reload(); 
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
		
		$(function() {
			$("#tglsp").datepicker({
				dateFormat:'dd-mm-yy'
			});
		});
		
		$('[id^=sasp]').keypress(validateNumber);
		 
	 	$('#tabel').dataTable({
	          "bPaginate": true,
	          "bLengthChange": true,
	          "bFilter": true,
	          "bSort": false,
	          "bInfo": true,
	          "bAutoWidth": true
	    });
	    
	    
	    $("#simpanvac").on("submit", function(){
            $.ajax({
                type:"POST",
                url:"pages/data_supplier_simpan.php",
                data: $('#simpanvac').serialize(),
                success:function(msg){
                    alert(msg);
                    //$('#ajaxModal').modal('toggle'); 
					////$('modal').close();
                    //$(".ajaxModal").bind('ajax:complete', function() {$.modal.close();});
                    //window.location.reload();
					window.location.href = "?page=data_supplier";

                }

            });
        	return false;
    	});
    	
    	
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

// memformat angka ribuan
function formatAngka(angka) {
 if (typeof(angka) != 'string') angka = angka.toString();
 var reg = new RegExp('([0-9]+)([0-9]{3})');
 while(reg.test(angka)) angka = angka.replace(reg, '$1.$2');
 return angka;
}
 
// nilai total ditulis langsung, bisa dari hasil perhitungan lain
var total = 4500,
	bayar = 0,
	kembali = 0;

// masukkan angka total dari variabel
$('#input-total').val(formatAngka(total));

// tambah event keypress untuk input bayar
$('#input-bayar').on('keypress', function(e) {
 var c = e.keyCode || e.charCode;
 switch (c) {
  case 8: case 9: case 27: case 13: return;
  case 65:
   if (e.ctrlKey === true) return;
 }
 if (c < 48 || c > 57) e.preventDefault();
}).on('keyup', function() {
 var inp = $(this).val().replace(/\./g, '');
 
 // set nilai ke variabel bayar
 bayar = new Number(inp);
 $(this).val(formatAngka(inp));
 
 // set kembalian, validasi
 if (bayar > total) kembali = bayar - total;
 if (total > bayar) kembali = 0;
 $('#input-kembali').val(formatAngka(kembali));
});
</script>