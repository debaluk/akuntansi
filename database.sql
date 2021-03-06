/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.7.17-log : Database - akuntansi_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`akuntansi_db` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `akuntansi_db`;

/*Table structure for table `tabel_akun` */

DROP TABLE IF EXISTS `tabel_akun`;

CREATE TABLE `tabel_akun` (
  `id_akun` int(11) NOT NULL AUTO_INCREMENT,
  `kode_akun` varchar(10) NOT NULL DEFAULT '',
  `nama_akun` varchar(100) NOT NULL,
  `tipe_akun` enum('Aktiva','Kewajiban','Modal','Pendapatan','HPP','Biaya') DEFAULT NULL,
  `tanggal_awal` date NOT NULL,
  `awal_debet` int(15) NOT NULL,
  `awal_kredit` int(15) NOT NULL,
  PRIMARY KEY (`id_akun`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;

/*Data for the table `tabel_akun` */

insert  into `tabel_akun`(`id_akun`,`kode_akun`,`nama_akun`,`tipe_akun`,`tanggal_awal`,`awal_debet`,`awal_kredit`) values (34,'1-0101','Bank BRI','Aktiva','2017-11-01',10000000,0),(33,'1-0100','Kas','Aktiva','2017-11-01',10000000,0),(35,'1-0103','Persediaan Barang','Aktiva','2017-11-01',50000000,0),(36,'1-0104','Perlengkapan Toko','Aktiva','2017-11-01',2000000,0),(37,'1-0110','Peralatan Toko','Aktiva','2017-11-01',10000000,0),(38,'1-0111','Akm. Peny. Peralatan','Aktiva','2017-11-01',0,1000000),(39,'2-0200','Hutang Dagang','Kewajiban','2017-11-01',0,0),(40,'3-0300','Modal Bos','Modal','2017-11-01',71000000,0),(41,'4-0400','Penjualan Barang','Pendapatan','2017-11-01',0,0),(42,'5-0500','HPP','HPP','2017-11-01',0,0),(43,'6-0512','Biaya Listrik','Biaya','2017-11-01',0,20000),(48,'6-0512','Gaji Pegawai','Biaya','0000-00-00',0,0);

/*Table structure for table `tabel_jurnal` */

DROP TABLE IF EXISTS `tabel_jurnal`;

CREATE TABLE `tabel_jurnal` (
  `id_jurnal` int(11) NOT NULL AUTO_INCREMENT,
  `nomor_faktur` varchar(50) DEFAULT NULL,
  `tgl_jurnal` date DEFAULT NULL,
  `nomor_jurnal` varchar(50) DEFAULT NULL,
  `referensi` varchar(10) DEFAULT NULL,
  `keterangan` varchar(200) DEFAULT NULL,
  `id_akun` int(4) DEFAULT NULL,
  `debet` double DEFAULT NULL,
  `kredit` double DEFAULT NULL,
  PRIMARY KEY (`id_jurnal`)
) ENGINE=MyISAM AUTO_INCREMENT=102 DEFAULT CHARSET=latin1;

/*Data for the table `tabel_jurnal` */

insert  into `tabel_jurnal`(`id_jurnal`,`nomor_faktur`,`tgl_jurnal`,`nomor_jurnal`,`referensi`,`keterangan`,`id_akun`,`debet`,`kredit`) values (99,'F002','2017-11-20','JU0004','-','Penjualan Barang',35,0,500000),(100,'F003','2017-11-30','JU0005','-','Biaya Pegawai',48,5000000,0),(101,'F003','2017-11-30','JU0005','-','Biaya Pegawai',33,0,5000000),(87,'-','2017-11-05','JU0001','S0001','Pembayaran Hutang',33,0,5000000),(98,'F002','2017-11-20','JU0004','-','Penjualan Barang',42,500000,0),(97,'F002','2017-11-20','JU0004','-','Penjualan Barang',41,0,20000000),(92,'F001','2017-12-03','JU0002','S0001','Pembelian Kredit',35,15000000,0),(93,'F001','2017-12-03','JU0002','S0001','Pembelian Kredit',39,0,15000000),(94,'F001','2017-12-20','JU0003','S0001','Pembayaran Hutang',39,10000000,0),(95,'F001','2017-12-20','JU0003','S0001','Pembayaran Hutang',33,0,10000000),(96,'F002','2017-11-20','JU0004','-','Penjualan Barang',33,20000000,0),(86,'-','2017-11-05','JU0001','S0001','Pembayaran Hutang',39,5000000,0),(85,'-','2017-11-01','-','S0001','Saldo Awal',39,0,10000000);

/*Table structure for table `tabel_keterangan` */

DROP TABLE IF EXISTS `tabel_keterangan`;

CREATE TABLE `tabel_keterangan` (
  `id_keterangan` int(11) NOT NULL AUTO_INCREMENT,
  `keterangan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_keterangan`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `tabel_keterangan` */

insert  into `tabel_keterangan`(`id_keterangan`,`keterangan`) values (1,'Penjualan Barang'),(2,'Biaya Listrik dan Air'),(3,'Pembelian Kredit'),(4,'Biaya Pegawai');

/*Table structure for table `tabel_neraca` */

DROP TABLE IF EXISTS `tabel_neraca`;

CREATE TABLE `tabel_neraca` (
  `id_neraca` int(11) NOT NULL AUTO_INCREMENT,
  `id_akun` int(10) DEFAULT NULL,
  `tanggal` date DEFAULT '0000-00-00',
  `awal_debet` int(15) DEFAULT '0',
  `awal_kredit` int(15) DEFAULT '0',
  `mut_debet` int(15) DEFAULT '0',
  `mut_kredit` int(15) DEFAULT '0',
  `sisa_debet` int(15) DEFAULT '0',
  `sisa_kredit` int(15) DEFAULT '0',
  PRIMARY KEY (`id_neraca`)
) ENGINE=MyISAM AUTO_INCREMENT=1610 DEFAULT CHARSET=latin1;

/*Data for the table `tabel_neraca` */

insert  into `tabel_neraca`(`id_neraca`,`id_akun`,`tanggal`,`awal_debet`,`awal_kredit`,`mut_debet`,`mut_kredit`,`sisa_debet`,`sisa_kredit`) values (1598,33,'0000-00-00',0,0,30000000,20000000,0,0),(1599,34,'0000-00-00',0,0,10000000,0,0,0),(1600,35,'0000-00-00',0,0,65000000,500000,0,0),(1601,36,'0000-00-00',0,0,2000000,0,0,0),(1602,37,'0000-00-00',0,0,10000000,0,0,0),(1603,38,'0000-00-00',0,0,0,1000000,0,0),(1604,39,'0000-00-00',0,0,15000000,25000000,0,0),(1605,40,'0000-00-00',0,0,71000000,0,0,0),(1606,41,'0000-00-00',0,0,0,20000000,0,0),(1607,42,'0000-00-00',0,0,500000,0,0,0),(1608,43,'0000-00-00',0,0,0,20000,0,0),(1609,48,'0000-00-00',0,0,5000000,0,0,0);

/*Table structure for table `tabel_operator` */

DROP TABLE IF EXISTS `tabel_operator`;

CREATE TABLE `tabel_operator` (
  `id_operator` int(4) NOT NULL AUTO_INCREMENT,
  `kode` varchar(4) NOT NULL,
  `level` enum('Administrator','Operator','Owner') NOT NULL DEFAULT 'Operator',
  `namalengkap` varchar(200) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `tanggal` varchar(20) NOT NULL,
  PRIMARY KEY (`id_operator`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `tabel_operator` */

insert  into `tabel_operator`(`id_operator`,`kode`,`level`,`namalengkap`,`username`,`password`,`tanggal`) values (1,'K001','Administrator','Agus Sumarna','agus','fdf169558242ee051cca1479770ebac3','2018-10-06 00:01:27'),(5,'K002','Operator','Budi','budi','00dfc53ee86af02e742515cdcf075ed3','');

/*Table structure for table `tabel_rugi_laba` */

DROP TABLE IF EXISTS `tabel_rugi_laba`;

CREATE TABLE `tabel_rugi_laba` (
  `id_labarugi` int(11) NOT NULL AUTO_INCREMENT,
  `id_akun` int(100) DEFAULT NULL,
  `tipe_akun` varchar(200) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `debet` int(15) DEFAULT NULL,
  `kredit` int(15) NOT NULL,
  PRIMARY KEY (`id_labarugi`)
) ENGINE=MyISAM AUTO_INCREMENT=281 DEFAULT CHARSET=latin1;

/*Data for the table `tabel_rugi_laba` */

insert  into `tabel_rugi_laba`(`id_labarugi`,`id_akun`,`tipe_akun`,`tanggal`,`debet`,`kredit`) values (277,41,'Pendapatan',NULL,0,20000000),(278,42,'HPP',NULL,500000,0),(279,43,'Biaya',NULL,0,20000),(280,48,'Biaya',NULL,5000000,0);

/*Table structure for table `tabel_setup` */

DROP TABLE IF EXISTS `tabel_setup`;

CREATE TABLE `tabel_setup` (
  `id_setup` int(11) NOT NULL AUTO_INCREMENT,
  `id_keterangan` int(11) DEFAULT NULL,
  `id_akun` int(11) DEFAULT NULL,
  `posisi_akun` enum('Debet','Kredit') DEFAULT NULL,
  PRIMARY KEY (`id_setup`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `tabel_setup` */

insert  into `tabel_setup`(`id_setup`,`id_keterangan`,`id_akun`,`posisi_akun`) values (1,1,33,'Debet'),(2,1,41,'Kredit'),(3,1,42,'Debet'),(4,1,35,'Kredit'),(5,2,43,'Debet'),(6,2,33,'Kredit'),(7,3,35,'Debet'),(8,3,39,'Kredit'),(9,4,48,'Debet'),(10,4,33,'Kredit');

/*Table structure for table `tabel_supplier` */

DROP TABLE IF EXISTS `tabel_supplier`;

CREATE TABLE `tabel_supplier` (
  `id_supplier` int(11) NOT NULL AUTO_INCREMENT,
  `kode_supplier` varchar(5) DEFAULT NULL,
  `nama_supplier` varchar(200) DEFAULT NULL,
  `alamat_supplier` text,
  `telepon_supplier` varchar(15) DEFAULT NULL,
  `tanggal` varchar(10) DEFAULT NULL,
  `saldo_awal` double DEFAULT NULL,
  PRIMARY KEY (`id_supplier`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `tabel_supplier` */

insert  into `tabel_supplier`(`id_supplier`,`kode_supplier`,`nama_supplier`,`alamat_supplier`,`telepon_supplier`,`tanggal`,`saldo_awal`) values (4,'S0001','Toko Bagus','Denpasar','087','2017-11-01',10000000);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
