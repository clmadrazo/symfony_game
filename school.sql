/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.7.9 : Database - school
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`school` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `school`;

/*Table structure for table `customer` */

DROP TABLE IF EXISTS `customer`;

CREATE TABLE `customer` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `profile_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_81398E0992FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_81398E09A0D96FBF` (`email_canonical`),
  UNIQUE KEY `UNIQ_81398E09C05FB297` (`confirmation_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `customer` */

insert  into `customer`(`id`,`username`,`username_canonical`,`email`,`email_canonical`,`enabled`,`salt`,`password`,`last_login`,`confirmation_token`,`password_requested_at`,`roles`,`profile_id`) values ('5a28a468e711f','carlos','carlos','carlosmadrazo@gmx.com','carlosmadrazo@gmx.com',1,NULL,'$2y$13$imabyaVJutM7/G5lMGf4M.saKLBp9U7TALoadyymc0ovN87k6PGqC','2017-12-08 00:16:59',NULL,NULL,'a:0:{}',1),('5a29c77d3b64e','pedro','pedro','pedro@test.com','pedro@test.com',1,NULL,'$2y$13$zrmlSPZutLHp84Ku/yhFrOaGOKO/idSwgYI9dj3uPxkcLJS9VqmWy',NULL,NULL,NULL,'a:0:{}',2),('5a29c7874d3fe','juan','juan','juan@gmail.com','juan@gmail.com',1,NULL,'123456','2017-12-08 00:41:14',NULL,NULL,'a:0:{}',2);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
