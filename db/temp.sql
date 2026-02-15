/*
SQLyog Enterprise v10.42 
MySQL - 8.0.30 : Database - u1804486_escindonesia
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`u1804486_escindonesia` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `u1804486_escindonesia`;

/*Table structure for table `dcmember_progress` */

DROP TABLE IF EXISTS `dcmember_progress`;

CREATE TABLE `dcmember_progress` (
  `idprogress` int NOT NULL AUTO_INCREMENT,
  `iddcmember` char(10) DEFAULT NULL,
  `iddc` char(5) DEFAULT NULL,
  `tglprogress` datetime DEFAULT NULL,
  `idjemaatdm` char(10) DEFAULT NULL,
  `nilairatarata` decimal(3,2) DEFAULT '0.00',
  `tglinsert` datetime DEFAULT NULL,
  PRIMARY KEY (`idprogress`),
  KEY `iddcmember` (`iddcmember`),
  KEY `idjemaatdm` (`idjemaatdm`),
  CONSTRAINT `dcmember_progress_ibfk_1` FOREIGN KEY (`iddcmember`) REFERENCES `dcmember` (`iddcmember`),
  CONSTRAINT `dcmember_progress_ibfk_2` FOREIGN KEY (`idjemaatdm`) REFERENCES `jemaat` (`idjemaat`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

/*Data for the table `dcmember_progress` */

insert  into `dcmember_progress`(`idprogress`,`iddcmember`,`iddc`,`tglprogress`,`idjemaatdm`,`nilairatarata`,`tglinsert`) values (5,'Y6C0100002','Y6C01','2026-02-07 07:52:16','2310310025',0.00,'2026-02-07 07:52:16'),(6,'Y6C0100002','Y6C01','2026-02-07 07:53:27','2310310025',0.00,'2026-02-07 07:53:27'),(8,'Y6C0100002','Y6C01','2026-02-07 07:56:16','2310310025',2.00,'2026-02-07 07:56:16'),(9,'Y6C0100002','Y6C01','2026-02-07 08:46:28','2310310025',2.20,'2026-02-07 08:46:28'),(10,'Y6C0100002','Y6C01','2026-02-13 16:49:37','2310310025',0.00,'2026-02-13 16:49:37'),(11,'Y6C0100002','Y6C01','2026-02-13 17:06:32','2310310025',0.00,'2026-02-13 17:06:32'),(12,'Y6C0100002','Y6C01','2026-02-15 03:17:48','2310310025',0.00,'2026-02-15 03:17:48'),(13,'Y6C0100002','Y6C01','2026-02-15 03:25:29','2310310025',0.00,'2026-02-15 03:25:29'),(14,'Y6C0100002','Y6C01','2026-02-15 03:26:00','2310310025',0.00,'2026-02-15 03:26:00'),(15,'Y6C0100002','Y6C01','2026-02-15 03:28:11','2310310025',0.00,'2026-02-15 03:28:11'),(16,'Y6C0100002','Y6C01','2026-02-15 03:31:40','2310310025',4.00,'2026-02-15 03:31:40'),(17,'Y6C0100002','Y6C01','2026-02-15 04:01:12','2310310025',3.00,'2026-02-15 04:01:12'),(18,'Y6C0100002','Y6C01','2026-02-15 04:06:50','2310310025',3.20,'2026-02-15 04:06:50'),(19,'Y6C0100002','Y6C01','2026-02-15 04:07:07','2310310025',3.40,'2026-02-15 04:07:07'),(20,'Y6C0100002','Y6C01','2026-02-15 04:07:16','2310310025',3.60,'2026-02-15 04:07:16');

/*Table structure for table `dcmember_progress_det` */

DROP TABLE IF EXISTS `dcmember_progress_det`;

CREATE TABLE `dcmember_progress_det` (
  `id` int NOT NULL AUTO_INCREMENT,
  `idprogress` int DEFAULT NULL,
  `idpertanyaan` int DEFAULT NULL,
  `nilai` decimal(3,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idprogress` (`idprogress`),
  KEY `idpertanyaan` (`idpertanyaan`),
  CONSTRAINT `dcmember_progress_det_ibfk_1` FOREIGN KEY (`idprogress`) REFERENCES `dcmember_progress` (`idprogress`),
  CONSTRAINT `dcmember_progress_det_ibfk_2` FOREIGN KEY (`idpertanyaan`) REFERENCES `pertanyaanprogressdcm` (`idpertanyaan`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=latin1;

/*Data for the table `dcmember_progress_det` */

insert  into `dcmember_progress_det`(`id`,`idprogress`,`idpertanyaan`,`nilai`) values (1,6,1,2.00),(2,6,2,1.00),(3,6,3,3.00),(4,6,4,3.00),(5,6,5,3.00),(11,8,1,3.00),(12,8,2,3.00),(13,8,3,1.00),(14,8,4,3.00),(15,8,5,0.00),(16,9,1,4.00),(17,9,2,3.00),(18,9,3,4.00),(19,9,4,0.00),(20,9,5,0.00),(21,10,1,0.00),(22,10,2,0.00),(23,10,3,0.00),(24,10,4,0.00),(25,10,5,0.00),(26,11,1,0.00),(27,11,2,0.00),(28,11,3,0.00),(29,11,4,0.00),(30,11,5,0.00),(31,12,1,0.00),(32,12,2,0.00),(33,12,3,0.00),(34,12,4,0.00),(35,12,5,0.00),(36,13,1,0.00),(37,13,2,0.00),(38,13,3,0.00),(39,13,4,0.00),(40,13,5,0.00),(41,14,1,0.00),(42,14,2,0.00),(43,14,3,0.00),(44,14,4,0.00),(45,14,5,0.00),(46,15,1,0.00),(47,15,2,0.00),(48,15,3,0.00),(49,15,4,0.00),(50,15,5,0.00),(51,16,1,4.00),(52,16,2,4.00),(53,16,3,4.00),(54,16,4,4.00),(55,16,5,4.00),(56,17,1,3.00),(57,17,2,4.00),(58,17,3,2.00),(59,17,4,4.00),(60,17,5,2.00),(61,18,1,3.00),(62,18,2,3.00),(63,18,3,3.00),(64,18,4,3.00),(65,18,5,4.00),(66,19,1,3.00),(67,19,2,3.00),(68,19,3,3.00),(69,19,4,4.00),(70,19,5,4.00),(71,20,1,3.00),(72,20,2,3.00),(73,20,3,4.00),(74,20,4,4.00),(75,20,5,4.00);

/*Table structure for table `pertanyaanprogressdcm` */

DROP TABLE IF EXISTS `pertanyaanprogressdcm`;

CREATE TABLE `pertanyaanprogressdcm` (
  `idpertanyaan` int NOT NULL AUTO_INCREMENT,
  `idkategori` int DEFAULT NULL,
  `pertanyaan` varchar(255) DEFAULT NULL,
  `tglinsert` datetime DEFAULT NULL,
  `tglupdate` datetime DEFAULT NULL,
  `statusaktif` enum('Aktif','Tidak Aktif') DEFAULT NULL,
  PRIMARY KEY (`idpertanyaan`),
  KEY `idkategori` (`idkategori`),
  CONSTRAINT `pertanyaanprogressdcm_ibfk_1` FOREIGN KEY (`idkategori`) REFERENCES `pertanyaanprogresskategori` (`idkategori`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `pertanyaanprogressdcm` */

insert  into `pertanyaanprogressdcm`(`idpertanyaan`,`idkategori`,`pertanyaan`,`tglinsert`,`tglupdate`,`statusaktif`) values (1,1,'Sering bertanya tentang pertemuan DC','2026-02-07 13:27:10','2026-02-07 13:27:13','Aktif'),(2,1,'Izin saat tidak bisa hadir','2026-02-07 13:27:31','2026-02-07 13:27:34','Aktif'),(3,1,'Berusaha untuk on time di dalam pertemuan DC','2026-02-07 13:27:50','2026-02-07 13:27:52','Aktif'),(4,1,'Menanggapi saat sesi coaching','2026-02-07 13:28:21','2026-02-07 13:28:24','Aktif'),(5,1,'Bertanggung jawab atas tugas yang diberikan oleh DM','2026-02-07 13:29:09','2026-02-07 13:29:12','Aktif');

/*Table structure for table `pertanyaanprogresskategori` */

DROP TABLE IF EXISTS `pertanyaanprogresskategori`;

CREATE TABLE `pertanyaanprogresskategori` (
  `idkategori` int NOT NULL AUTO_INCREMENT,
  `namakategori` varchar(255) DEFAULT NULL,
  `statusaktif` enum('Aktif','Tidak Aktif') DEFAULT NULL,
  `tglinsert` datetime DEFAULT NULL,
  `tglupdate` datetime DEFAULT NULL,
  PRIMARY KEY (`idkategori`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `pertanyaanprogresskategori` */

insert  into `pertanyaanprogresskategori`(`idkategori`,`namakategori`,`statusaktif`,`tglinsert`,`tglupdate`) values (1,'Contoh perilaku peduli di dalam DC','Aktif','2026-02-07 13:26:44','2026-02-07 13:26:46');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
