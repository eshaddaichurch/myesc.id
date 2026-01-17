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

/*Table structure for table `settings` */

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `prefix` char(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `values` text,
  `tglinsert` datetime DEFAULT NULL,
  `tglupdate` datetime DEFAULT NULL,
  `issystem` tinyint DEFAULT NULL,
  PRIMARY KEY (`prefix`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `settings` */

insert  into `settings`(`prefix`,`deskripsi`,`values`,`tglinsert`,`tglupdate`,`issystem`) values ('url_community','Alamat url domain community','http://localhost/myesc/myesc.id/community','2025-01-18 12:55:45','2025-01-18 12:55:48',0),('wa_nextstep_konfirmasi','','Shalom [[namalengkap]]. Pendaftaran Kelas anda sudah dikonfirmasi silahkan datang tepat waktu. Silahkan Bergabung dengan Grup WA Berikut:\r\n\r\nTahap New (FC1 & MC):\r\nbit.ly/newescnextstep\r\n\r\nTahap Plant – Foundation Class 2 (FC2):\r\nbit.ly/fc2escnextstep\r\n\r\nTahap Plant – Foundation Class 3 (FC3):\r\nbit.ly/fc3escnextstep\r\n\r\nTahap Grow – Marriage Class (MaC):\r\nbit.ly/macnextstep\r\n\r\nChannel ESC Next Step:\r\nbit.ly/channelescnextstep\r\n','2025-11-22 14:35:26','2025-11-22 15:32:33',1),('wa_nextstep_registrasi','','teset','2025-11-22 14:35:26','2025-11-22 15:32:33',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
