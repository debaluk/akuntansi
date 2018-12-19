<?php 
session_start();
error_reporting(0);

if ($_SESSION['username'] == "") {
    header ("Location: login.php");
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>"VIDAYA MART" - <?php require('get_title.php'); ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />    
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/fa/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
   
	<link href="dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="dist/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
	
  </head>
  <body class="skin-blue">
    <div class="wrapper">
      
      <header class="main-header">
        <!-- Logo -->
        <a href="index.php" class="logo"><b>"VIDAYA </b>MART"</a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
              <p>
<a id="add" href="pages/profile_ubah_password.php" data-toggle="ajaxModal">
                <?php echo $_SESSION['nama']; ?></a></p>

              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          
         <ul class="sidebar-menu list" id="menuSub">
         	<li class="header">MENU UTAMA</li>
                <li id="" class=""><a href="index.php" class="name"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
                
				<?php
				if ($_SESSION['leve']=='Super Admin')
				{
				?>
				
                <li class="treeview <?php if(isset($_GET['page']) && $_GET['page']=="data_akun" or $_GET['page']=="data_operator" or $_GET['page']=="data_supplier" or $_GET['page']=="setup_akun" ) { echo "active menu-open"; } ?>">
                    <a href="#"><i class="fa fa-bars"></i> <span>Kelola Data Master</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                                                                                                                                                                                                                                                                                                                                                                                                                                                            
                        <li id=""><a href="?page=data_akun" class="name"><i class="fa fa-circle-o"></i> Data Akun</a></li> 
						<li id=""><a href="?page=setup_akun" class="name"><i class="fa fa-circle-o"></i> Setup Akun</a></li>   						
                        <li id=""><a href="?page=data_operator" class="name"><i class="fa fa-circle-o"></i> Data Operator</a></li>                                                                                                                                                                                                                                                                                                                                                                                
                        <li id=""><a href="?page=data_supplier" class="name"><i class="fa fa-circle-o"></i> Data Supplier</a></li>                                                                                                                                                                                                                                                                                           
                        
                    </ul>
                </li>
                
                <li class="treeview <?php if(isset($_GET['page']) && $_GET['page']=="buku_bantu_hutang" or $_GET['page']=="jurnal_umum" or $_GET['page']=="data_jurnal_umum"  or $_GET['page']=="jurnal_penyesuaian" or $_GET['page']=="pembelian_kredit" or $_GET['page']=="data_detil_hutang"  or $_GET['page']=="bayar_hutang") { echo "active menu-open"; } ?>">
                    <a href="#"><i class="fa fa-bars"></i> <span>Kelola Transaksi</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                                                                                                                                                                                                                                                                                                                                                                                                                                                            
                        <li id=""><a href="?page=buku_bantu_hutang" class="name"><i class="fa fa-circle-o"></i> Buku Bantu Hutang</a></li>                                                                                                                                                                                                        
                        <li id=""><a href="?page=jurnal_umum" class="name"><i class="fa fa-circle-o"></i> Jurnal Umum</a></li>                                                                                                                                                                                                                                                                                                                                                                                
                        <!--<li id=""><a href="?page=jurnal_penyesuaian" class="name"><i class="fa fa-circle-o"></i> Jurnal Penyesuaian</a></li>-->                                                                                                                                                                                                                                                                                           
                        
                    </ul>
                </li> 
                <li class="treeview <?php if(isset($_GET['page']) && $_GET['page']=="buku_besar" or $_GET['page']=="neraca_saldo") { echo "active"; } ?>">
                    <a href="#"><i class="fa fa-bars"></i> <span>Proses SIA</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">                                                                                                                                                                                                                                                                                                                                                                                                                                                            
                        <li id=""><a href="?page=buku_besar" class="name"><i class="fa fa-circle-o"></i> Buku Besar</a></li>                                                                                                                                                                                                        
                        <li id=""><a href="?page=neraca_saldo" class="name"><i class="fa fa-circle-o"></i> Neraca Saldo</a></li>                                                                                                                                                                                                                                                                                                                                                                                
                        
                    </ul>
                </li> 
                <li class="treeview <?php if(isset($_GET['page']) && $_GET['page']=="lap_jurnal_umum" or $_GET['page']=="lap_jurnal_penyesuaian" or $_GET['page']=="lap_neraca" or $_GET['page']=="lap_laba_rugi") { echo "active"; } ?>">
                    <a href="#"><i class="fa fa-bars"></i> <span>Kelola Laporan</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                                                                                                                                                                                                                                                                                                                                                                                                                                                            
                        <li id=""><a href="?page=lap_jurnal_umum" class="name"><i class="fa fa-circle-o"></i> Lap. Jurnal Umum</a></li>                                                                                                                                                                                                        
                        <!--<li id=""><a href="./?page=lap_jurnal_penyesuaian" class="name"><i class="fa fa-circle-o"></i> Lap. Jurnal Penyesuaian</a></li>-->                                                                                                                                                                                                                                                                                                                                                                                
                        <li id=""><a href="?page=lap_neraca" class="name"><i class="fa fa-circle-o"></i> Lap. Neraca</a></li>   
                        <li id=""><a href="?page=lap_laba_rugi" class="name"><i class="fa fa-circle-o"></i> Lap. Laba Rugi</a></li>                                                                                                                                                                                                                                                                                        
                        
                    </ul>
                </li> 
				<?php 
				} 
				else
				{
					?>
					<li class="treeview <?php if(isset($_GET['page']) && $_GET['page']=="buku_bantu_hutang" or $_GET['page']=="jurnal_umum" or $_GET['page']=="data_jurnal_umum"  or $_GET['page']=="jurnal_penyesuaian" or $_GET['page']=="pembelian_kredit" or $_GET['page']=="data_detil_hutang"  or $_GET['page']=="bayar_hutang") { echo "active menu-open"; } ?>">
						<a href="#"><i class="fa fa-bars"></i> <span>Kelola Transaksi</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
																																																																																																																
							<li id=""><a href="?page=buku_bantu_hutang" class="name"><i class="fa fa-circle-o"></i> Buku Bantu Hutang</a></li>                                                                                                                                                                                                        
							<li id=""><a href="?page=jurnal_umum" class="name"><i class="fa fa-circle-o"></i> Jurnal Umum</a></li>                                                                                                                                                                                                                                                                                                                                                                                
							<!--<li id=""><a href="?page=jurnal_penyesuaian" class="name"><i class="fa fa-circle-o"></i> Jurnal Penyesuaian</a></li>-->                                                                                                                                                                                                                                                                                           
						</ul>
					</li> 
					<li class="treeview <?php if(isset($_GET['page']) && $_GET['page']=="lap_jurnal_umum" or $_GET['page']=="lap_jurnal_penyesuaian" or $_GET['page']=="lap_neraca" or $_GET['page']=="lap_laba_rugi") { echo "active"; } ?>">
						<a href="#"><i class="fa fa-bars"></i> <span>Kelola Laporan</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
																																																																																																																
							<li id=""><a href="?page=lap_jurnal_umum" class="name"><i class="fa fa-circle-o"></i> Lap. Jurnal Umum</a></li>                                                                                                                                                                                                        
							<!--<li id=""><a href="./?page=lap_jurnal_penyesuaian" class="name"><i class="fa fa-circle-o"></i> Lap. Jurnal Penyesuaian</a></li>-->                                                                                                                                                                                                                                                                                                                                                                                
							<li id=""><a href="?page=lap_neraca" class="name"><i class="fa fa-circle-o"></i> Lap. Neraca</a></li>   
							<li id=""><a href="?page=lap_laba_rugi" class="name"><i class="fa fa-circle-o"></i> Lap. Laba Rugi</a></li>                                                                                                                                                                                                                                                                                        
							
						</ul>
					</li>
					<?php
					
				} ?>
				
				<li id="" class=""><a href="logout.php" class="name"><i class="fa fa-dashboard"></i> <span>Log Out</span></a></li>
                 
        	</ul>
        </section>
        
      </aside>

      
      <div class="content-wrapper">
       <!--<section class="content-header">
      		<ol class="breadcrumb" style="text-align: left;">
        		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        		<li class="active"><?php 
        		$judulsubmenu = str_replace("_", " ",$_GET[page]);
        		echo strtoupper(ucfirst($judulsubmenu)); 
        		
        		?></li>
      		</ol>
    	</section>-->
        <section class="content-header">
          <h1>
            <?php require_once('get_title.php'); ?>
          </h1>
        </section>
        <section class="content" style="min-height: 300px;">
          <?php 
          if (!isset($_GET['page'])) {
            require_once('info.php');
          }
           ?>
          
          <div class="row">
            
            <section class="col-lg-12">
            <?php require_once('views.php'); ?>
            </section>
          </div>
        </section>
      </div>
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
        </div>
        <strong>Copyright &copy; <?php echo date('Y'); ?> <a href="#">"VIDAYA MART"</a></strong>
      </footer>
    </div><!-- ./wrapper -->

    <script src="plugins/jQueryUI/jquery-ui.min.js" type="text/javascript"></script>
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>    
    <script src="plugins/knob/jquery.knob.js" type="text/javascript"></script>
    <script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src='plugins/fastclick/fastclick.min.js'></script>
    <!--<script src='plugins/datepicker/bootstrap-datepicker.min.js'></script>-->
    <script src="dist/js/app.min.js" type="text/javascript"></script>
	<!--<script src="plugins/chart.js/Chart.min.js"></script>-->
    <script src="dist/js/pages/dashboard.js" type="text/javascript"></script>
    <script>
    	$("#add").click(function(){
		//	//bersihkan form
			$('.modal').on('hidden.bs.modal', function(){
				$(this).find('form')[0].reset();
			});
		});
		
		$('[data-toggle="ajaxModal"]').on('click',function(e){
				$('#ajaxModal').remove();
				e.preventDefault();
				var $this = $(this)
				  , $remote = $this.data('remote') || $this.attr('href')
				  , $modal = $('<div class="modal" id="ajaxModal"><div class="modal-body"></div></div>');
				$('body').append($modal);
				$modal.modal({backdrop: 'static', keyboard: false});
				$modal.load($remote);
			}
		);
    </script>
  </body>
</html>