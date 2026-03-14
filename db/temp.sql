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

/*Table structure for table `sharedfiles` */

DROP TABLE IF EXISTS `sharedfiles`;

CREATE TABLE `sharedfiles` (
  `idshared` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `fileshared` varchar(255) DEFAULT NULL,
  `idjemaatadmin` char(10) DEFAULT NULL,
  `deskripsi` text,
  `deskripsisingkat` varchar(255) DEFAULT NULL,
  `tglinsert` datetime DEFAULT NULL,
  `tglupdate` datetime DEFAULT NULL,
  `jlhdilihat` int DEFAULT NULL,
  `jumlahdownload` int DEFAULT NULL,
  `jenisshared` enum('DC Member','DC All','DC DM','DC DM/CT','Jemaat All','Admin') DEFAULT NULL,
  `tglpublish` datetime DEFAULT NULL,
  `status` enum('Draft','Publish') CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT 'Draft',
  PRIMARY KEY (`idshared`),
  KEY `idjemaatadmin` (`idjemaatadmin`),
  KEY `tglshared` (`tglpublish`),
  KEY `jenisshared` (`jenisshared`),
  CONSTRAINT `sharedfiles_ibfk_1` FOREIGN KEY (`idjemaatadmin`) REFERENCES `jemaat` (`idjemaat`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `sharedfiles` */

insert  into `sharedfiles`(`idshared`,`title`,`fileshared`,`idjemaatadmin`,`deskripsi`,`deskripsisingkat`,`tglinsert`,`tglupdate`,`jlhdilihat`,`jumlahdownload`,`jenisshared`,`tglpublish`,`status`) values (4,'Resume 14 Maret 2026','Invoice-5256984.pdf','2205280001',NULL,'Resume','2026-03-14 13:32:26','2026-03-14 13:32:55',NULL,NULL,'DC DM/CT','2026-03-14 13:32:55','Publish');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
