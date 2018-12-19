/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.25a : Database - akuntansi_db
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
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;

/*Data for the table `tabel_akun` */

insert  into `tabel_akun`(`id_akun`,`kode_akun`,`nama_akun`,`tipe_akun`,`tanggal_awal`,`awal_debet`,`awal_kredit`) values (34,'1-0101','Bank BRI','Aktiva','2018-07-01',10000000,0),(33,'1-0100','Kas','Aktiva','2018-07-01',3000000,0),(35,'1-0103','Persediaan Barang','Aktiva','2018-07-01',50000000,0),(36,'1-0104','Perlengkapan Toko','Aktiva','2018-07-01',2000000,0),(37,'1-0110','Peralatan Toko','Aktiva','2018-07-01',10000000,0),(38,'1-0111','Akm. Peny. Peralatan','Aktiva','2018-07-01',0,1000000),(39,'2-0200','Hutang Dagang','Kewajiban','2018-07-01',0,0),(40,'3-0300','Modal Bos','Modal','2018-07-01',0,71000000),(41,'4-0400','Penjualan Barang','Pendapatan','2018-07-01',0,0),(42,'5-0500','HPP','HPP','2018-07-01',0,0),(43,'6-0512','Biaya Listrik','Biaya','2018-07-01',0,0);

/*Table structure for table `tabel_grafik` */

DROP TABLE IF EXISTS `tabel_grafik`;

CREATE TABLE `tabel_grafik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bulan` varchar(100) DEFAULT NULL,
  `tahun` varchar(10) DEFAULT NULL,
  `labarugi` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1417 DEFAULT CHARSET=utf8;

/*Data for the table `tabel_grafik` */

insert  into `tabel_grafik`(`id`,`bulan`,`tahun`,`labarugi`) values (1405,'Januari','2018',0),(1406,'Februari','2018',0),(1407,'Maret','2018',0),(1408,'April','2018',0),(1409,'Mei','2018',0),(1410,'Juni','2018',0),(1411,'Juli','2018',0),(1412,'Agustus','2018',0),(1413,'September','2018',0),(1414,'Oktober','2018',0),(1415,'November','2018',0),(1416,'Desember','2018',1999934);

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
) ENGINE=MyISAM AUTO_INCREMENT=338 DEFAULT CHARSET=latin1;

/*Data for the table `tabel_jurnal` */

insert  into `tabel_jurnal`(`id_jurnal`,`nomor_faktur`,`tgl_jurnal`,`nomor_jurnal`,`referensi`,`keterangan`,`id_akun`,`debet`,`kredit`,`nama_user`) values (337,'F0010','2018-12-13','JU0005','-','Penjualan Barang',35,0,66,'gusti'),(331,'F003','2018-12-11','JU0004','-','Penjualan Barang',35,0,500000,'gusti'),(336,'F0010','2018-12-13','JU0005','-','Penjualan Barang',42,66,0,'gusti'),(334,'F0010','2018-12-13','JU0005','-','Penjualan Barang',33,12,0,'gusti'),(335,'F0010','2018-12-13','JU0005','-','Penjualan Barang',41,0,12,'gusti'),(330,'F003','2018-12-11','JU0004','-','Penjualan Barang',42,500000,0,'gusti'),(328,'F003','2018-12-11','JU0004','-','Penjualan Barang',33,1500000,0,'gusti'),(329,'F003','2018-12-11','JU0004','-','Penjualan Barang',41,0,1500000,'gusti'),(327,'F002','2018-12-11','JU0003','S0003','Retur Pembelian',35,0,500000,'gusti'),(326,'F002','2018-12-11','JU0003','S0003','Retur Pembelian',39,500000,0,'gusti'),(324,'F001','2018-12-11','JU0002','S0002','Pembayaran Hutang',39,2000000,0,'gusti'),(325,'F001','2018-12-11','JU0002','S0002','Pembayaran Hutang',33,0,2000000,'gusti'),(319,'F004','2018-12-05','JU0007','-','Biaya Listrik dan Air',33,0,500000,'gusti'),(318,'F004','2018-12-05','JU0007','-','Biaya Listrik dan Air',43,500000,0,'gusti'),(317,'F003','2018-12-01','JU0006','-','Penjualan Barang',35,0,12,'gusti'),(316,'F003','2018-12-01','JU0006','-','Penjualan Barang',42,12,0,'gusti'),(315,'F003','2018-12-01','JU0006','-','Penjualan Barang',41,0,0,'gusti'),(314,'F003','2018-12-01','JU0006','-','Penjualan Barang',33,0,0,'gusti'),(313,'F002','2018-12-03','JU0005','-','Penjualan Barang',35,0,1500000,'gusti'),(312,'F002','2018-12-03','JU0005','-','Penjualan Barang',42,1500000,0,'gusti'),(311,'F002','2018-12-03','JU0005','-','Penjualan Barang',41,0,3000000,'gusti'),(310,'F002','2018-12-03','JU0005','-','Penjualan Barang',33,3000000,0,'gusti'),(323,'F005','2018-12-11','JU0001','S0003','Pembelian Kredit',39,0,2500000,'gusti'),(322,'F005','2018-12-11','JU0001','S0003','Pembelian Kredit',35,2500000,0,NULL),(320,'-','2018-12-11','-','S0004','Saldo Awal',39,0,0,NULL),(321,'-','2018-12-11','-','S0005','Saldo Awal',39,0,0,NULL),(305,'F001','2018-12-02','JU0004','S0002','Retur Pembelian',35,0,500000,'gusti'),(304,'F001','2018-12-02','JU0004','S0002','Retur Pembelian',39,500000,0,'gusti'),(303,'F001','2018-12-01','JU0003','S0002','Pembayaran Hutang',33,0,2500000,'gusti'),(302,'F001','2018-12-01','JU0003','S0002','Pembayaran Hutang',39,2500000,0,'gusti'),(301,'F002','2018-12-01','JU0002','S0003','Pembelian Kredit',39,0,3000000,'gusti'),(299,'F001','2018-12-01','JU0001','S0002','Pembelian Kredit',39,0,3000000,'gusti'),(300,'F002','2018-12-01','JU0002','S0003','Pembelian Kredit',35,3000000,0,NULL),(298,'F001','2018-12-01','JU0001','S0002','Pembelian Kredit',35,3000000,0,NULL),(296,'-','2018-11-01','-','S0002','Saldo Awal',39,0,0,NULL),(297,'-','2018-11-01','-','S0003','Saldo Awal',39,0,0,NULL),(295,'-','2018-11-01','-','S0001','Saldo Awal',39,0,3000000,NULL);

/*Table structure for table `tabel_keterangan` */

DROP TABLE IF EXISTS `tabel_keterangan`;

CREATE TABLE `tabel_keterangan` (
  `id_keterangan` int(11) NOT NULL AUTO_INCREMENT,
  `keterangan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_keterangan`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `tabel_keterangan` */

insert  into `tabel_keterangan`(`id_keterangan`,`keterangan`) values (1,'Penjualan Barang'),(2,'Biaya Listrik dan Air'),(3,'Pembelian Kredit'),(9,'Penarikan BRI');

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
) ENGINE=MyISAM AUTO_INCREMENT=4871 DEFAULT CHARSET=latin1;

/*Data for the table `tabel_neraca` */

insert  into `tabel_neraca`(`id_neraca`,`id_akun`,`tanggal`,`awal_debet`,`awal_kredit`,`mut_debet`,`mut_kredit`,`sisa_debet`,`sisa_kredit`) values (4856,54,'0000-00-00',0,0,0,0,0,0),(4857,33,'0000-00-00',3000000,0,7500000,5000000,5500000,0),(4858,34,'0000-00-00',10000000,0,0,0,10000000,0),(4859,35,'0000-00-00',50000000,0,8500000,4500000,54000000,0),(4860,36,'0000-00-00',2000000,0,0,0,2000000,0),(4861,37,'0000-00-00',10000000,0,0,0,10000000,0),(4862,38,'0000-00-00',0,1000000,0,0,0,1000000),(4863,39,'0000-00-00',0,0,5500000,11500000,0,6000000),(4864,40,'0000-00-00',0,71000000,0,0,0,71000000),(4865,41,'0000-00-00',0,0,0,7500000,0,7500000),(4866,42,'0000-00-00',0,0,3500000,0,3500000,0),(4867,43,'0000-00-00',0,0,500000,0,500000,0),(4868,48,'0000-00-00',0,0,0,0,0,0),(4869,52,'0000-00-00',0,0,0,0,0,0),(4870,53,'0000-00-00',0,0,0,0,0,0);

/*Table structure for table `tabel_operator` */

DROP TABLE IF EXISTS `tabel_operator`;

CREATE TABLE `tabel_operator` (
  `id_operator` int(4) NOT NULL AUTO_INCREMENT,
  `kode` varchar(4) NOT NULL,
  `level` char(100) NOT NULL DEFAULT 'Operator',
  `namalengkap` varchar(200) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `tanggal` varchar(20) NOT NULL,
  PRIMARY KEY (`id_operator`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

/*Data for the table `tabel_operator` */

insert  into `tabel_operator`(`id_operator`,`kode`,`level`,`namalengkap`,`username`,`password`,`tanggal`) values (1,'K001','Super Admin','Agus Sumarna','agus','202cb962ac59075b964b07152d234b70','2018-10-06 00:01:27'),(14,'K002','Super Admin','Gusti Priandana','gusti','2c309021e3d4c0f9129d66e733825b48',''),(15,'K003','Admin','Putra Wirawan','putra','5e0c5a0bf82decdd43b2150b622c66c5',''),(18,'K004','Admin','Admin','admin','81dc9bdb52d04dc20036dbd8313ed055','');

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
) ENGINE=MyISAM AUTO_INCREMENT=926 DEFAULT CHARSET=latin1;

/*Data for the table `tabel_rugi_laba` */

insert  into `tabel_rugi_laba`(`id_labarugi`,`id_akun`,`tipe_akun`,`tanggal`,`debet`,`kredit`) values (923,41,'Pendapatan',NULL,0,7500000),(924,42,'HPP',NULL,3500000,0),(925,43,'Biaya',NULL,500000,0);

/*Table structure for table `tabel_setup` */

DROP TABLE IF EXISTS `tabel_setup`;

CREATE TABLE `tabel_setup` (
  `id_setup` int(11) NOT NULL AUTO_INCREMENT,
  `id_keterangan` int(11) DEFAULT NULL,
  `id_akun` int(11) DEFAULT NULL,
  `posisi_akun` enum('Debet','Kredit') DEFAULT NULL,
  PRIMARY KEY (`id_setup`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

/*Data for the table `tabel_setup` */

insert  into `tabel_setup`(`id_setup`,`id_keterangan`,`id_akun`,`posisi_akun`) values (1,1,33,'Debet'),(2,1,41,'Kredit'),(3,1,42,'Debet'),(4,1,35,'Kredit'),(5,2,43,'Debet'),(6,2,33,'Kredit'),(7,3,35,'Debet'),(8,3,39,'Kredit'),(11,5,39,'Debet'),(12,5,35,'Kredit'),(18,8,33,'Kredit'),(17,8,33,'Debet'),(19,9,33,'Debet'),(20,9,34,'Kredit');

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
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

/*Data for the table `tabel_supplier` */

insert  into `tabel_supplier`(`id_supplier`,`kode_supplier`,`nama_supplier`,`alamat_supplier`,`telepon_supplier`,`tanggal`,`saldo_awal`) values (32,'S0001','PT Bintang Bali Indah','Denpasar','087123456','2018-11-01',3000000),(33,'S0002','PT Tigaraksa','Denpasar','087321654','2018-11-01',0),(34,'S0003','PT Nusantara','Denpasar','087456123','2018-11-01',0),(35,'S0004','PT Delta','Denpasar','087654321','2018-12-11',0),(36,'S0005','PT Delta Jaya','Denpasar','087654321','2018-12-11',0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
