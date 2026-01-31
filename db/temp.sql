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

/*Table structure for table `jemaatresetpassword` */

DROP TABLE IF EXISTS `jemaatresetpassword`;

CREATE TABLE `jemaatresetpassword` (
  `id` int NOT NULL AUTO_INCREMENT,
  `idjemaat` char(10) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `tokenlupapassword` char(6) DEFAULT NULL,
  `tgltokenlupapassword` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idjemaat` (`idjemaat`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `jemaatresetpassword` */

insert  into `jemaatresetpassword`(`id`,`idjemaat`,`email`,`tokenlupapassword`,`tgltokenlupapassword`) values (1,'2310310025','081254691909','969590','2026-01-31 23:44:47'),(2,'2310310025','081254691909','815963','2026-02-01 00:47:31'),(3,'2310310025','081254691909','887489','2026-02-01 01:04:20'),(4,'2310310025','081254691909','364200','2026-02-01 01:06:45'),(5,'2310310025','081254691909','713571','2026-02-01 01:08:20'),(6,'2310310025','081254691909','539336','2026-02-01 01:09:50'),(7,'2310310025','081254691909','750995','2026-02-01 01:15:10');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
