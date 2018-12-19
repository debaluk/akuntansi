<?php 
require "koneksi.php";
?>
<div class="box" style="min-height: 450px;">
    <div class="box-header">
      <h3 class="box-title">Detil Jurnal Umum</h3>
    </div>
    <div class="box-body">
		
		<div style="margin-top: 20px;">
			<table width="100%" border="0" class="table table-bordered">
			  <tr>
			    <td>ID Jurnal</td>
			    <td><input type="text" name="nojurnal" id="nojurnal" /></td>
			    <td>Keterangan</td>
			    <td><select name="keterangan" id="keterangan">
			    </select></td>
			  </tr>
			  <tr>
			    <td>Nomor Bukti</td>
			    <td><input type="text" name="no_bukti" id="no_bukti" /></td>
			    <td>Jumlah Rp.</td>
			    <td><input type="text" name="jumlah" id="jumlah" /></td>
			  </tr>
			  <tr>
			    <td>Tanggal</td>
			    <td><input type="text" name="tgljurnal" id="tgljurnal" /></td>
			    <td>HPP</td>
			    <td><input type="text" name="hpp" id="hpp" /></td>
			  </tr>
			</table>
			<button type="submit" name="simpan" id="simpan" class="btn btn-sm btn-primary"> <i class="fa fa-save"></i> Simpan</button>
			    <button type="reset" class="btn btn-sm btn-primary"> <i class="fa fa-trash"></i> Batal</button></td>
			    <a href="?page=jurnal_umum"><button type="button" class="btn btn-sm btn-primary"> <i class="fa fa-power-off"></i> Keluar</button></a></td>
		    	<br></p>
		
							<table width="100%" cellpadding="5" cellspacing="0" border="1" class="table table-bordered" id="tabel">
							    <tr>	
							      <td align="center">No Akun</td>
							      <td align="center">Nama Akun</td>
							      <td align="center">Debet</td>
							      <td align="center">Kredit</td>
							    </tr>
							    <tr>
							      <td>&nbsp;</td>
							      <td>Persediaan Barang</td>
							      <td align="right">a</td>
							      <td>&nbsp;</td>
							    </tr>
							    <tr>
							      <td>&nbsp;</td>
							      <td>Hutang Dagang</td>
							      <td>&nbsp;</td>
							      <td align="right">a</td>
							    </tr>
							   
							  </table>

						</div>
					</div>
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
