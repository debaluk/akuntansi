<?php 
require "koneksi.php";
 ?>
<div class="col-lg-12 col-xs-12">
<h3>Selamat datang <?php echo $_SESSION['nama'];?> </h3><br>

<h4>Selamat datang di halaman administrator Sistem Informasi Akutansi. Silahkan klik menu pilihan yang berada di sebelah kiri untuk mengelola website</h4>
</div>
 
<div class="row">
	
    <div class="col-lg-12">
            <canvas id="myChart" width="90%" height="30"></canvas>
    
	<script src="Chart.bundle.js"></script>
		<?php
		
		//cari laba rugi
		mysqli_query($con,"delete from tabel_grafik");
		
		$bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		$jlh_bln=count($bulan);
		$bulanawal=0;
		for($bln=0; $bln<$jlh_bln; $bln+=1)
		{
			$bulanawal++;
			$bln_leng=strlen($bulanawal);
			if ($bln_leng==1)
			{
				$i="0".$bulanawal;
			}
			else
			{
				$i=$bulanawal;
			}
			
			
			$bulanini =$bulan[$bln];
			$tahunini = date('Y');
			$pilihanawal=$tahunini.'-'.$i.'-01';
			$pilihanakhir=$tahunini.'-'.$i.'-31';
			
			//cari pendapatan
			$datajurnalpendapatan=mysqli_query($con,"
				SELECT 	sum(tabel_jurnal.debet - tabel_jurnal.kredit) AS pendapatan, tabel_akun.tipe_akun 
			FROM 
				tabel_jurnal, tabel_akun
			WHERE 
				tabel_jurnal.id_akun=tabel_akun.id_akun 
				AND 
				tabel_akun.tipe_akun='Pendapatan'
				AND 
				tabel_jurnal.tgl_jurnal 
				BETWEEN '$pilihanawal' AND '$pilihanakhir'");
			$hasildatajurnalpendapatan=mysqli_fetch_array($datajurnalpendapatan);
			$nilaipendapatan=$hasildatajurnalpendapatan[pendapatan];
			
			//cari hpp
			$datajurnalhpp=mysqli_query($con,"
				SELECT 	sum(tabel_jurnal.debet - tabel_jurnal.kredit) AS hpp, tabel_akun.tipe_akun 
			FROM 
				tabel_jurnal, tabel_akun
			WHERE 
				tabel_jurnal.id_akun=tabel_akun.id_akun 
				AND 
				tabel_akun.tipe_akun='HPP'
				AND 
				tabel_jurnal.tgl_jurnal 
				BETWEEN '$pilihanawal' AND '$pilihanakhir'");
			$hasildatajurnalhpp=mysqli_fetch_array($datajurnalhpp);
			$nilaihpp=$hasildatajurnalhpp[hpp];
			
			//cari biaya
			$datajurnalbiaya=mysqli_query($con,"
				SELECT 	sum(tabel_jurnal.debet - tabel_jurnal.kredit) AS biaya, tabel_akun.tipe_akun 
			FROM 
				tabel_jurnal, tabel_akun
			WHERE 
				tabel_jurnal.id_akun=tabel_akun.id_akun 
				AND 
				tabel_akun.tipe_akun='Biaya'
				AND 
				tabel_jurnal.tgl_jurnal 
				BETWEEN '$pilihanawal' AND '$pilihanakhir'");
			$hasildatajurnalbiaya=mysqli_fetch_array($datajurnalbiaya);
			$nilaibiaya=$hasildatajurnalbiaya[biaya];
			
			$totallabarugi=abs($nilaipendapatan) - ($nilaihpp + $nilaibiaya);
			
			mysqli_query($con,"insert into tabel_grafik set bulan='$bulanini', tahun='$tahunini', labarugi='$totallabarugi'");

			
		}
		
		
		$bulan       = mysqli_query($con, "SELECT bulan FROM tabel_grafik WHERE tahun='$tahunini' order by id asc");
		$penghasilan = mysqli_query($con, "SELECT labarugi FROM tabel_grafik WHERE tahun='$tahunini' order by id asc");
		?>
        <script>
            var ctx = document.getElementById("myChart");
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [<?php while ($b = mysqli_fetch_array($bulan)) { echo '"' . $b['bulan'] . '",';}?>],
                    datasets: [{
                            label: '# Laba Rugi',
                            data: [<?php while ($p = mysqli_fetch_array($penghasilan)) { echo '"' . $p['labarugi'] . '",';}?>],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255,99,132,1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderWidth: 1
                        }]
                },
                options: {
                    scales: {
                        yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                    }
                }
            });
        </script>
		</div>
    </div><!-- ./col -->
  </div><!-- /.row -->
  <script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>
  <!--<script src="Chart.bundle.js"></script>-->
  