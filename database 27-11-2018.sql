/*
SQLyog Community v13.1.1 (64 bit)
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
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

/*Data for the table `tabel_akun` */

insert  into `tabel_akun`(`id_akun`,`kode_akun`,`nama_akun`,`tipe_akun`,`tanggal_awal`,`awal_debet`,`awal_kredit`) values 
(34,'1-0101','Bank BRI','Aktiva','2018-07-01',10000000,0),
(33,'1-0100','Kas','Aktiva','2018-07-01',3000000,0),
(35,'1-0103','Persediaan Barang','Aktiva','2018-07-01',50000000,0),
(36,'1-0104','Perlengkapan Toko','Aktiva','2018-07-01',2000000,0),
(37,'1-0110','Peralatan Toko','Aktiva','2018-07-01',10000000,0),
(38,'1-0111','Akm. Peny. Peralatan','Aktiva','2018-07-01',0,1000000),
(39,'2-0200','Hutang Dagang','Kewajiban','2018-07-01',0,0),
(40,'3-0300','Modal Bos','Modal','2018-07-01',71000000,0),
(41,'4-0400','Penjualan Barang','Pendapatan','2018-07-01',0,0),
(42,'5-0500','HPP','HPP','2018-07-01',0,0),
(43,'6-0512','Biaya Listrik','Biaya','2018-07-01',0,0),
(48,'6-0513','Gaji Pegawai','Biaya','2018-07-01',0,0);

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
  `nama_user` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_jurnal`)
) ENGINE=MyISAM AUTO_INCREMENT=120 DEFAULT CHARSET=latin1;

/*Data for the table `tabel_jurnal` */

insert  into `tabel_jurnal`(`id_jurnal`,`nomor_faktur`,`tgl_jurnal`,`nomor_jurnal`,`referensi`,`keterangan`,`id_akun`,`debet`,`kredit`,`nama_user`) values 
(105,'-','2018-11-26','-','S0002','Saldo Awal',39,0,0,NULL),
(104,'-','2018-11-26','-','S0001','Saldo Awal',39,0,0,NULL),
(103,'-','2018-11-26','-','S002','Saldo Awal',39,0,0,NULL),
(102,'-','2018-11-26','-','S0001','Saldo Awal',39,0,0,NULL),
(109,'F001','2018-11-26','JU0001','S0002','Pembelian Kredit',39,0,9000000,'agus'),
(108,'F001','2018-11-26','JU0001','S0002','Pembelian Kredit',35,9000000,0,NULL),
(110,'F002','2018-11-26','JU0002','S0002','Pembelian Kredit',35,9000000,0,NULL),
(111,'F002','2018-11-26','JU0002','S0002','Pembelian Kredit',39,0,9000000,'agus'),
(112,'F001','2018-11-26','JU0003','S0002','Pembayaran Hutang',39,8000000,0,'agus'),
(113,'F001','2018-11-26','JU0003','S0002','Pembayaran Hutang',33,0,8000000,'agus'),
(114,'F002','2018-11-27','JU0004','-','Penjualan Barang',33,90000,0,'agus'),
(115,'F002','2018-11-27','JU0004','-','Penjualan Barang',41,0,90000,'agus'),
(116,'F002','2018-11-27','JU0004','-','Penjualan Barang',42,20000,0,'agus'),
(117,'F002','2018-11-27','JU0004','-','Penjualan Barang',35,0,20000,'agus'),
(118,'F001','2018-11-27','JU0005','S0002','Retur Pembelian',39,50000,0,'agus'),
(119,'F001','2018-11-27','JU0005','S0002','Retur Pembelian',35,0,50000,'agus');

/*Table structure for table `tabel_keterangan` */

DROP TABLE IF EXISTS `tabel_keterangan`;

CREATE TABLE `tabel_keterangan` (
  `id_keterangan` int(11) NOT NULL AUTO_INCREMENT,
  `keterangan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_keterangan`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `tabel_keterangan` */

insert  into `tabel_keterangan`(`id_keterangan`,`keterangan`) values 
(1,'Penjualan Barang'),
(2,'Biaya Listrik dan Air'),
(3,'Pembelian Kredit'),
(4,'Biaya Pegawai'),
(5,'Retur Pembelian');

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
) ENGINE=MyISAM AUTO_INCREMENT=2426 DEFAULT CHARSET=latin1;

/*Data for the table `tabel_neraca` */

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

insert  into `tabel_operator`(`id_operator`,`kode`,`level`,`namalengkap`,`username`,`password`,`tanggal`) values 
(1,'K001','Administrator','Agus Sumarna','agus','fdf169558242ee051cca1479770ebac3','2018-10-06 00:01:27'),
(5,'K002','Operator','Budi','budi','00dfc53ee86af02e742515cdcf075ed3','');

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
) ENGINE=MyISAM AUTO_INCREMENT=357 DEFAULT CHARSET=latin1;

/*Data for the table `tabel_rugi_laba` */

insert  into `tabel_rugi_laba`(`id_labarugi`,`id_akun`,`tipe_akun`,`tanggal`,`debet`,`kredit`) values 
(353,41,'Pendapatan',NULL,0,0),
(354,42,'HPP',NULL,0,0),
(355,43,'Biaya',NULL,0,0),
(356,48,'Biaya',NULL,0,0);

/*Table structure for table `tabel_setup` */

DROP TABLE IF EXISTS `tabel_setup`;

CREATE TABLE `tabel_setup` (
  `id_setup` int(11) NOT NULL AUTO_INCREMENT,
  `id_keterangan` int(11) DEFAULT NULL,
  `id_akun` int(11) DEFAULT NULL,
  `posisi_akun` enum('Debet','Kredit') DEFAULT NULL,
  PRIMARY KEY (`id_setup`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `tabel_setup` */

insert  into `tabel_setup`(`id_setup`,`id_keterangan`,`id_akun`,`posisi_akun`) values 
(1,1,33,'Debet'),
(2,1,41,'Kredit'),
(3,1,42,'Debet'),
(4,1,35,'Kredit'),
(5,2,43,'Debet'),
(6,2,33,'Kredit'),
(7,3,35,'Debet'),
(8,3,39,'Kredit'),
(9,4,48,'Debet'),
(10,4,33,'Kredit'),
(11,5,39,'Debet'),
(12,5,35,'Kredit');

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

insert  into `tabel_supplier`(`id_supplier`,`kode_supplier`,`nama_supplier`,`alamat_supplier`,`telepon_supplier`,`tanggal`,`saldo_awal`) values 
(3,'S0001','dsds','','dsd','2018-11-26',0),
(4,'S0002','dsdsdsd','dsdsd','sdsdsdsd','2018-11-26',0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
