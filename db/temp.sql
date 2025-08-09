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

/*Table structure for table `carekematian` */

DROP TABLE IF EXISTS `carekematian`;

CREATE TABLE `carekematian` (
  `idkematian` int NOT NULL AUTO_INCREMENT,
  `tglpermohonan` date DEFAULT NULL,
  `namapemohon` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `jeniskelaminpemohon` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `nohppemohon` char(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `namayangmeninggal` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `tglmeninggal` date DEFAULT NULL,
  `jeniskelaminyangmeninggal` enum('Laki-laki','Perempuan') CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `hubungankeluarga` enum('Ayah/ Ibu','Anak','Kakak/ Adik','Lainnya') CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `idpenanggungjawab` char(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `keterangan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `status` enum('Permohonan','Disetujui','Ditolak') CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `tglstatus` datetime DEFAULT NULL,
  `idadmin` char(10) DEFAULT NULL,
  `keteranganadmin` varchar(255) DEFAULT NULL,
  `umuryangmeninggal` int DEFAULT NULL,
  PRIMARY KEY (`idkematian`),
  KEY `idadmin` (`idadmin`),
  KEY `idjemaat` (`namapemohon`),
  KEY `idpenanggungjawab` (`idpenanggungjawab`),
  CONSTRAINT `carekematian_ibfk_1` FOREIGN KEY (`idadmin`) REFERENCES `jemaat` (`idjemaat`),
  CONSTRAINT `carekematian_ibfk_3` FOREIGN KEY (`idpenanggungjawab`) REFERENCES `jemaat` (`idjemaat`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `carekematian` */

insert  into `carekematian`(`idkematian`,`tglpermohonan`,`namapemohon`,`jeniskelaminpemohon`,`nohppemohon`,`namayangmeninggal`,`tglmeninggal`,`jeniskelaminyangmeninggal`,`hubungankeluarga`,`idpenanggungjawab`,`keterangan`,`status`,`tglstatus`,`idadmin`,`keteranganadmin`,`umuryangmeninggal`) values (3,'2025-08-09','Test1','Perempuan','2344343','Test2','2025-08-09','Laki-laki','Kakak/ Adik','2307250001',NULL,'Disetujui','2025-08-09 15:59:39','2205280001','Test aja',111);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
