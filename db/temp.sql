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
CREATE DATABASE /*!32312 IF NOT EXISTS*/`u1804486_escindonesia` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `u1804486_escindonesia`;

/*Table structure for table `jemaatdokumen` */

DROP TABLE IF EXISTS `jemaatdokumen`;

CREATE TABLE `jemaatdokumen` (
  `idjemaat` char(10) NOT NULL,
  `kartukeluarga` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idjemaat`),
  CONSTRAINT `jemaatdokumen_ibfk_1` FOREIGN KEY (`idjemaat`) REFERENCES `jemaat` (`idjemaat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `jemaatdokumen` */

insert  into `jemaatdokumen`(`idjemaat`,`kartukeluarga`) values ('2308260001','500-1526-2-PB.pdf');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
