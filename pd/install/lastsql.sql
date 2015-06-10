/*
SQLyog Ultimate v11.24 (32 bit)
MySQL - 5.5.32 : Database - tiandb
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`tiandb` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `tiandb`;

/*Table structure for table `tny_banedlist` */

DROP TABLE IF EXISTS `tny_banedlist`;

CREATE TABLE `tny_banedlist` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `banedlist_title` varchar(100) NOT NULL,
  `banedlist_types` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `banedlist_title` (`banedlist_title`),
  KEY `banedlist_title_2` (`banedlist_title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `tny_banedlist` */

/*Table structure for table `tny_delivery_cdk` */

DROP TABLE IF EXISTS `tny_delivery_cdk`;

CREATE TABLE `tny_delivery_cdk` (
  `_sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `phone` varchar(25) DEFAULT NULL,
  `eml` varchar(70) DEFAULT NULL,
  `yourrequire` text,
  PRIMARY KEY (`_sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `tny_delivery_cdk` */

/*Table structure for table `tny_delivery_gold` */

DROP TABLE IF EXISTS `tny_delivery_gold`;

CREATE TABLE `tny_delivery_gold` (
  `_sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `phone` varchar(25) DEFAULT NULL,
  `eml` varchar(70) DEFAULT NULL,
  `servername` varchar(30) DEFAULT NULL,
  `charactername` varchar(50) DEFAULT NULL,
  `yourrequire` text,
  PRIMARY KEY (`_sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `tny_delivery_gold` */

/*Table structure for table `tny_delivery_goldfa` */

DROP TABLE IF EXISTS `tny_delivery_goldfa`;

CREATE TABLE `tny_delivery_goldfa` (
  `_sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `phone` varchar(25) DEFAULT NULL,
  `eml` varchar(70) DEFAULT NULL,
  `servername` varchar(30) DEFAULT NULL,
  `charactername` varchar(50) DEFAULT NULL,
  `yourrequire` text,
  `faction` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`_sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `tny_delivery_goldfa` */

/*Table structure for table `tny_delivery_pl` */

DROP TABLE IF EXISTS `tny_delivery_pl`;

CREATE TABLE `tny_delivery_pl` (
  `_sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `accoutname` varchar(50) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `eml` varchar(70) DEFAULT NULL,
  `password` varchar(30) DEFAULT NULL,
  `servername` varchar(30) DEFAULT NULL,
  `charactername` varchar(50) DEFAULT NULL,
  `yourrequire` text,
  PRIMARY KEY (`_sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `tny_delivery_pl` */

/*Table structure for table `tny_delivery_plcode` */

DROP TABLE IF EXISTS `tny_delivery_plcode`;

CREATE TABLE `tny_delivery_plcode` (
  `_sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `accoutname` varchar(50) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `eml` varchar(70) DEFAULT NULL,
  `password` varchar(30) DEFAULT NULL,
  `servername` varchar(30) DEFAULT NULL,
  `charactername` varchar(50) DEFAULT NULL,
  `yourrequire` text,
  `pincode` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`_sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `tny_delivery_plcode` */

/*Table structure for table `tny_feedback` */

DROP TABLE IF EXISTS `tny_feedback`;

CREATE TABLE `tny_feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `contt` text COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ipars` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `pictt` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `reply` text COLLATE utf8_unicode_ci NOT NULL,
  `times` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `nname` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tny_feedback` */

insert  into `tny_feedback`(`id`,`title`,`contt`,`email`,`ipars`,`pictt`,`reply`,`times`,`nname`) values (2,'hi again','leave a message balabala','a@b.cc','127.0.0.1','face1','lol','2015-01-22 16:01:36','ui');

/*Table structure for table `tny_fs_conf_calc_22ap` */

DROP TABLE IF EXISTS `tny_fs_conf_calc_22ap`;

CREATE TABLE `tny_fs_conf_calc_22ap` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `csid` int(10) unsigned NOT NULL,
  `unit` varchar(20) NOT NULL,
  `cachejs` tinyint(1) NOT NULL,
  `comment` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`sid`),
  UNIQUE KEY `csid` (`csid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `tny_fs_conf_calc_22ap` */

insert  into `tny_fs_conf_calc_22ap`(`sid`,`csid`,`unit`,`cachejs`,`comment`) values (1,3,'1 g',0,''),(2,23,'1 k',1,''),(3,28,'1 m',1,''),(4,32,'1 liang',1,''),(5,35,'1 g',1,''),(6,40,'1 k',1,'');

/*Table structure for table `tny_fs_conf_hot` */

DROP TABLE IF EXISTS `tny_fs_conf_hot`;

CREATE TABLE `tny_fs_conf_hot` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `csid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`sid`),
  UNIQUE KEY `csid` (`csid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `tny_fs_conf_hot` */

/*Table structure for table `tny_fs_conf_html` */

DROP TABLE IF EXISTS `tny_fs_conf_html`;

CREATE TABLE `tny_fs_conf_html` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `csid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`sid`),
  UNIQUE KEY `csid` (`csid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `tny_fs_conf_html` */

/*Table structure for table `tny_fs_conf_spancalc_22ld` */

DROP TABLE IF EXISTS `tny_fs_conf_spancalc_22ld`;

CREATE TABLE `tny_fs_conf_spancalc_22ld` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `csid` int(10) unsigned NOT NULL,
  `cachejs` tinyint(1) NOT NULL,
  `unit` float NOT NULL,
  `comment` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`sid`),
  UNIQUE KEY `csid` (`csid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `tny_fs_conf_spancalc_22ld` */

insert  into `tny_fs_conf_spancalc_22ld`(`sid`,`csid`,`cachejs`,`unit`,`comment`) values (1,10,1,100,'');

/*Table structure for table `tny_fs_conf_spancalc_23ldp` */

DROP TABLE IF EXISTS `tny_fs_conf_spancalc_23ldp`;

CREATE TABLE `tny_fs_conf_spancalc_23ldp` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `csid` int(11) unsigned NOT NULL,
  `cachejs` tinyint(1) NOT NULL,
  `comment` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`sid`),
  UNIQUE KEY `csid` (`csid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `tny_fs_conf_spancalc_23ldp` */

insert  into `tny_fs_conf_spancalc_23ldp`(`sid`,`csid`,`cachejs`,`comment`) values (1,11,0,'');

/*Table structure for table `tny_fs_conf_table_22ap` */

DROP TABLE IF EXISTS `tny_fs_conf_table_22ap`;

CREATE TABLE `tny_fs_conf_table_22ap` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `csid` int(10) unsigned NOT NULL,
  `mutistyle` enum('auto','expand','collapse') DEFAULT 'auto',
  `unit` varchar(20) NOT NULL,
  `tableCaption` varchar(64) NOT NULL,
  `showType` varchar(10) NOT NULL,
  `gridCol` int(11) DEFAULT '3',
  `titleType` varchar(10) NOT NULL,
  `comment` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`sid`),
  UNIQUE KEY `csid` (`csid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `tny_fs_conf_table_22ap` */

insert  into `tny_fs_conf_table_22ap`(`sid`,`csid`,`mutistyle`,`unit`,`tableCaption`,`showType`,`gridCol`,`titleType`,`comment`) values (1,12,'auto','1 ks','tableCaption','grid',3,'text',''),(3,24,'auto','1 k','WOW Gold','grid',3,'text',''),(4,29,'auto','1 m','','table',3,'text',''),(5,31,'auto','1 liang','','grid',3,'text',''),(6,34,'auto','1 g','','grid',3,'text',''),(7,30,'auto','1 m','','grid',3,'text',''),(8,38,'auto','1 m','','grid',3,'text',''),(9,39,'auto','1 k','','grid',3,'text','');

/*Table structure for table `tny_fs_conf_table_22ld` */

DROP TABLE IF EXISTS `tny_fs_conf_table_22ld`;

CREATE TABLE `tny_fs_conf_table_22ld` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `csid` int(10) unsigned NOT NULL,
  `mutistyle` enum('auto','expand','collapse') DEFAULT 'auto',
  `unitprice` float NOT NULL,
  `showType` enum('grid','table') DEFAULT 'table',
  `gridCol` int(11) DEFAULT '3',
  `tableCaption` varchar(64) NOT NULL,
  `span` varchar(128) NOT NULL COMMENT '用逗号隔开',
  `spanNum` int(11) unsigned NOT NULL,
  `titleType` varchar(10) NOT NULL,
  `showCalcData` tinyint(1) NOT NULL,
  `showZero2End` tinyint(1) NOT NULL,
  `showA2B` tinyint(1) NOT NULL,
  `comment` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`sid`),
  UNIQUE KEY `csid` (`csid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `tny_fs_conf_table_22ld` */

insert  into `tny_fs_conf_table_22ld`(`sid`,`csid`,`mutistyle`,`unitprice`,`showType`,`gridCol`,`tableCaption`,`span`,`spanNum`,`titleType`,`showCalcData`,`showZero2End`,`showA2B`,`comment`) values (2,13,'auto',15,NULL,3,'tableCaption','',5,'text',1,1,0,'');

/*Table structure for table `tny_fs_conf_table_22tp` */

DROP TABLE IF EXISTS `tny_fs_conf_table_22tp`;

CREATE TABLE `tny_fs_conf_table_22tp` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `csid` int(10) unsigned NOT NULL,
  `mutistyle` enum('auto','expand','collapse') DEFAULT 'auto',
  `showType` enum('grid','table') DEFAULT 'table',
  `gridCol` int(11) DEFAULT '3',
  `tableCaption` varchar(64) NOT NULL,
  `titleType` varchar(10) NOT NULL,
  `comment` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`sid`),
  UNIQUE KEY `csid` (`csid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `tny_fs_conf_table_22tp` */

insert  into `tny_fs_conf_table_22tp`(`sid`,`csid`,`mutistyle`,`showType`,`gridCol`,`tableCaption`,`titleType`,`comment`) values (1,4,'auto','table',3,'asqw','text',NULL),(2,2,'auto','grid',3,'','text',''),(3,25,'auto','table',3,'','text','');

/*Table structure for table `tny_fs_conf_table_23ldp` */

DROP TABLE IF EXISTS `tny_fs_conf_table_23ldp`;

CREATE TABLE `tny_fs_conf_table_23ldp` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `csid` int(10) unsigned NOT NULL,
  `mutistyle` enum('auto','expand','collapse') DEFAULT 'auto',
  `tableCaption` varchar(64) NOT NULL,
  `showType` enum('grid','table') DEFAULT 'table',
  `gridCol` int(11) DEFAULT '3',
  `span` varchar(128) NOT NULL COMMENT '用逗号隔开',
  `spanNum` int(11) NOT NULL,
  `titleType` varchar(10) NOT NULL,
  `showCalcData` tinyint(1) NOT NULL,
  `showZero2End` tinyint(1) NOT NULL,
  `showA2B` tinyint(1) NOT NULL,
  `comment` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`sid`),
  UNIQUE KEY `csid` (`csid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `tny_fs_conf_table_23ldp` */

insert  into `tny_fs_conf_table_23ldp`(`sid`,`csid`,`mutistyle`,`tableCaption`,`showType`,`gridCol`,`span`,`spanNum`,`titleType`,`showCalcData`,`showZero2End`,`showA2B`,`comment`) values (2,33,'auto','','grid',3,'11,2',3,'text',1,0,0,''),(3,41,'auto','','table',3,'',3,'text',1,0,0,''),(4,42,'auto','','table',3,'',3,'text',1,0,0,'');

/*Table structure for table `tny_fs_conf_table_23tpe` */

DROP TABLE IF EXISTS `tny_fs_conf_table_23tpe`;

CREATE TABLE `tny_fs_conf_table_23tpe` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `csid` int(10) unsigned NOT NULL,
  `mutistyle` enum('auto','expand','collapse') DEFAULT 'auto',
  `tableCaption` varchar(64) NOT NULL,
  `showType` enum('grid','table') DEFAULT 'table',
  `gridCol` int(11) DEFAULT '3',
  `titleType` varchar(10) NOT NULL,
  `extraShowMode` varchar(10) NOT NULL,
  `iconPlaceHolder` varchar(2048) DEFAULT NULL,
  `extraShowMask` varchar(10) NOT NULL,
  `extraCaption` varchar(64) NOT NULL,
  `comment` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`sid`),
  UNIQUE KEY `csid` (`csid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `tny_fs_conf_table_23tpe` */

insert  into `tny_fs_conf_table_23tpe`(`sid`,`csid`,`mutistyle`,`tableCaption`,`showType`,`gridCol`,`titleType`,`extraShowMode`,`iconPlaceHolder`,`extraShowMask`,`extraCaption`,`comment`) values (2,21,'auto',' ','grid',3,'text','text','<span class=\"widget-table-icon\" {placeholder}><img src=\"/public/img/detail.gif\"></span>','tep','days',''),(3,22,'auto','','table',3,'text','text','<span class=\"widget-table-icon\" {placeholder}><img src=\"/public/img/detail.gif\"></span>','tep','',''),(4,27,'auto','','table',3,'text','text','<span class=\"widget-table-icon\" {placeholder}><img src=\"/public/img/detail.gif\"></span>','tep','Day',''),(5,36,'auto','','table',3,'text','text','<span class=\"widget-table-icon\" {placeholder}><img src=\"/public/img/detail.gif\"></span>','tpe','',''),(6,37,'auto','','table',3,'text','text','<span class=\"widget-table-icon\" {placeholder}><img src=\"/public/img/detail.gif\"></span>','tpe','','');

/*Table structure for table `tny_fs_conf_table_hot` */

DROP TABLE IF EXISTS `tny_fs_conf_table_hot`;

CREATE TABLE `tny_fs_conf_table_hot` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `csid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`sid`),
  UNIQUE KEY `csid` (`csid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `tny_fs_conf_table_hot` */

/*Table structure for table `tny_fs_confkey_struct` */

DROP TABLE IF EXISTS `tny_fs_confkey_struct`;

CREATE TABLE `tny_fs_confkey_struct` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nsid` int(10) unsigned NOT NULL,
  `key` varchar(20) NOT NULL,
  `typeid` varchar(20) NOT NULL,
  `comment` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`sid`),
  UNIQUE KEY `pk` (`nsid`,`key`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

/*Data for the table `tny_fs_confkey_struct` */

insert  into `tny_fs_confkey_struct`(`sid`,`nsid`,`key`,`typeid`,`comment`) values (2,12,'confkey','table_22tp','test'),(3,12,'xcx','calc_22ap','test'),(4,12,'xccx','table_22tp','test'),(10,12,'spancalc22ld','spancalc_22ld','test'),(11,12,'spancalc23ldp','spancalc_23ldp','test'),(12,12,'table22ap','table_22ap','test'),(13,12,'table22ld','table_22ld','test'),(17,12,'hotsales','table_hot',''),(21,47,'wowpl','table_23tpe','WOW代练表格'),(20,47,'plconf','spancalc_23ldp',''),(22,47,'wowpl1','table_23tpe',''),(23,84,'wowgold','calc_22ap',''),(24,84,'golda','table_22ap','表格'),(25,85,'wowcdk','table_22tp','CDK'),(26,88,'aionlv','spancalc_23ldp',''),(27,88,'aionlevel','table_23tpe',''),(28,89,'aiongold','calc_22ap',''),(29,89,'aiong1','table_22ap',''),(30,90,'aiong1','table_22ap',''),(31,127,'aowg1','table_22ap',''),(32,127,'aow2','calc_22ap',''),(33,130,'ar1','table_23ldp',''),(34,129,'aag1','table_22ap',''),(35,129,'aag2','calc_22ap',''),(36,130,'arlv1','table_23tpe',''),(37,164,'artk','table_23tpe',''),(38,165,'ar2','table_22ap',''),(39,166,'ak','table_22ap',''),(40,166,'ak2','calc_22ap',''),(41,130,'eee','table_23ldp',''),(42,130,'e','table_23ldp','');

/*Table structure for table `tny_fs_datakey_struct` */

DROP TABLE IF EXISTS `tny_fs_datakey_struct`;

CREATE TABLE `tny_fs_datakey_struct` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'sid',
  `nsid` int(10) unsigned NOT NULL COMMENT 'node path sid',
  `key` varchar(20) NOT NULL COMMENT 'path',
  `dstype` varchar(10) NOT NULL,
  `deco` varchar(1024) DEFAULT NULL COMMENT 'path1,path2,...',
  `comment` varchar(50) DEFAULT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`sid`),
  UNIQUE KEY `npsid` (`nsid`,`key`)
) ENGINE=MyISAM AUTO_INCREMENT=140 DEFAULT CHARSET=utf8;

/*Data for the table `tny_fs_datakey_struct` */

insert  into `tny_fs_datakey_struct`(`sid`,`nsid`,`key`,`dstype`,`deco`,`comment`,`date`) values (2,1,'svr','','j/k/l','eeee',NULL),(15,12,'xxoo','22tp','','test',NULL),(121,68,'wowgold','22ap','','','2015-05-02 12:27:36'),(114,47,'wowpl1','23tpe','/','','2015-04-12 08:16:58'),(16,12,'mm','22ap','/cate1,/cate1/sub','test',NULL),(113,47,'wowpl','23tpe','/','WOW代练表格','2015-04-12 08:06:41'),(102,12,'hotsales','23tpe','','热卖','2015-01-02 21:38:18'),(103,12,'hot','hot','','test','2015-01-04 10:22:37'),(104,12,'html','html','','test','2015-01-05 10:32:39'),(115,47,'wowpl2','23tpe','/','','2015-04-12 08:30:10'),(120,84,'wowgold','22ap','','','2015-05-02 11:47:28'),(112,47,'pldata','23ldp','/','WOW代练计算器','2015-04-12 07:34:31'),(117,47,'severus','ofhint','','','2015-05-02 10:39:43'),(118,48,'servername','ofhint','','','2015-05-02 10:43:38'),(119,68,'servername','ofhint','','','2015-05-02 10:45:11'),(122,85,'wowcdk','22tp','','','2015-05-02 15:29:32'),(123,88,'aionlv','23ldp','','','2015-05-02 15:41:48'),(124,88,'aionlv1','23tpe','','','2015-05-02 15:55:02'),(126,89,'servername','22ap','/server','','2015-05-02 17:00:15'),(128,90,'servername','22ap','sever','','2015-05-02 18:03:34'),(129,127,'servername','22ap','/server','','2015-05-03 13:24:13'),(136,129,'servername','22ap','/server','','2015-05-07 22:47:32'),(131,130,'arlv','23ldp','','代练计算器','2015-05-03 15:23:41'),(135,130,'arlv1','23tpe','','','2015-05-03 16:07:05'),(137,164,'ar1','23tpe','','表格','2015-05-31 14:26:51'),(138,165,'servername','22ap','/server','','2015-05-31 15:00:48'),(139,166,'servername','22ap','','','2015-05-31 15:21:31');

/*Table structure for table `tny_fs_datasrc_22ap` */

DROP TABLE IF EXISTS `tny_fs_datasrc_22ap`;

CREATE TABLE `tny_fs_datasrc_22ap` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'sid',
  `nssid` int(10) unsigned NOT NULL,
  `a` int(11) DEFAULT NULL COMMENT 'amount',
  `p` float DEFAULT NULL COMMENT 'price',
  PRIMARY KEY (`sid`),
  UNIQUE KEY `npsid` (`a`,`nssid`)
) ENGINE=MyISAM AUTO_INCREMENT=974 DEFAULT CHARSET=utf8;

/*Data for the table `tny_fs_datasrc_22ap` */

insert  into `tny_fs_datasrc_22ap`(`sid`,`nssid`,`a`,`p`) values (32,380,15,505),(27,380,5,100),(28,380,10,100),(33,39,5,10),(34,39,10,20),(35,39,15,29),(36,18,2,2),(37,18,5,10),(38,18,15,55),(39,51,2,15),(40,51,5,20),(41,51,7,28),(42,53,5,21),(43,53,10,122),(44,53,33,888),(45,54,5,10),(46,54,15,29),(47,59,5,10),(48,59,10,20),(49,59,15,29),(50,70,10,4.37),(51,70,20,8.74),(52,70,30,13.11),(53,70,40,17.48),(54,70,50,21.85),(55,70,60,26.22),(56,70,70,30.58),(57,70,80,34.95),(58,70,90,39.32),(59,70,100,43.69),(60,70,200,87.38),(61,70,500,218.46),(62,71,10,4.7),(63,71,20,9.39),(64,71,30,14.09),(65,71,40,18.79),(66,71,50,23.48),(67,71,60,28.18),(68,71,70,32.88),(69,71,80,37.58),(70,71,90,42.27),(71,71,100,46.97),(72,71,200,93.94),(73,71,500,234.84),(74,77,100,5.96),(75,77,200,11.92),(76,77,300,17.87),(77,77,400,23.83),(78,77,500,29.79),(79,77,600,35.75),(80,77,700,41.71),(81,77,800,47.66),(82,77,900,53.62),(83,77,1000,59.58),(84,77,2000,119.16),(85,77,5000,297.9),(86,78,100,5.96),(87,78,200,11.92),(88,78,300,17.87),(89,78,400,23.83),(90,78,500,29.79),(91,78,600,35.75),(92,78,700,41.71),(93,78,800,47.66),(94,78,900,53.62),(95,78,1000,59.58),(96,78,2000,119.16),(97,78,5000,297.9),(98,79,100,5.96),(99,79,200,11.92),(100,79,300,17.87),(101,79,400,23.83),(102,79,500,29.79),(103,79,600,35.75),(104,79,700,41.71),(105,79,800,47.66),(106,79,900,53.62),(107,79,1000,59.58),(108,79,2000,119.16),(109,79,5000,297.9),(110,80,100,5.96),(111,80,200,11.92),(112,80,300,17.87),(113,80,400,23.83),(114,80,500,29.79),(115,80,600,35.75),(116,80,700,41.71),(117,80,800,47.66),(118,80,900,53.62),(119,80,1000,59.58),(120,80,2000,119.16),(121,80,5000,297.9),(122,83,100,5.96),(123,83,200,11.92),(124,83,300,17.87),(125,83,400,23.83),(126,83,500,29.79),(127,83,600,35.75),(128,83,700,41.71),(129,83,800,47.66),(130,83,900,53.62),(131,83,1000,59.58),(132,83,2000,119.16),(133,83,5000,297.9),(134,84,100,5.96),(135,84,200,11.92),(136,84,300,17.87),(137,84,400,23.83),(138,84,500,29.79),(139,84,600,35.75),(140,84,700,41.71),(141,84,800,47.66),(142,84,900,53.62),(143,84,1000,59.58),(144,84,2000,119.16),(145,84,5000,297.9),(146,81,100,5.96),(147,81,200,11.92),(148,81,300,17.87),(149,81,400,23.83),(150,81,500,29.79),(151,81,600,35.75),(152,81,700,41.71),(153,81,800,47.66),(154,81,900,53.62),(155,81,1000,59.58),(156,81,2000,119.16),(157,81,5000,297.9),(158,82,100,5.96),(159,82,200,11.92),(160,82,300,17.87),(161,82,400,23.83),(162,82,500,29.79),(163,82,600,35.75),(164,82,700,41.71),(165,82,800,47.66),(166,82,900,53.62),(167,82,1000,59.58),(168,82,2000,119.16),(169,82,5000,297.9),(170,87,100,6.95),(171,87,200,13.9),(172,87,300,20.85),(173,87,400,27.8),(174,87,500,34.76),(175,87,600,41.71),(176,87,700,48.66),(177,87,800,55.61),(178,87,900,62.56),(179,87,1000,69.51),(180,87,2000,139.02),(181,87,5000,347.55),(182,88,100,6.95),(183,88,200,13.9),(184,88,300,20.85),(185,88,400,27.8),(186,88,500,34.76),(187,88,600,41.71),(188,88,700,48.66),(189,88,800,55.61),(190,88,900,62.56),(191,88,1000,69.51),(192,88,2000,139.02),(193,88,5000,347.55),(194,89,100,7.94),(195,89,200,15.89),(196,89,300,23.83),(197,89,400,31.78),(198,89,500,39.72),(199,89,600,47.66),(200,89,700,55.61),(201,89,800,63.55),(202,89,900,71.5),(203,89,1000,79.44),(204,89,2000,158.88),(205,89,5000,397.2),(206,90,100,7.94),(207,90,200,15.89),(208,90,300,23.83),(209,90,400,31.78),(210,90,500,39.72),(211,90,600,47.66),(212,90,700,55.61),(213,90,800,63.55),(214,90,900,71.5),(215,90,1000,79.44),(216,90,2000,158.88),(217,90,5000,397.2),(218,91,100,6.95),(219,91,200,13.9),(220,91,300,20.85),(221,91,400,27.8),(222,91,500,34.76),(223,91,600,41.71),(224,91,700,48.66),(225,91,800,55.61),(226,91,900,62.56),(227,91,1000,69.51),(228,91,2000,139.02),(229,91,5000,347.55),(230,92,100,8.94),(231,92,200,17.87),(232,92,300,26.81),(233,92,400,35.75),(234,92,500,44.69),(235,92,600,53.62),(236,92,700,62.56),(237,92,800,71.5),(238,92,900,80.43),(239,92,1000,89.37),(240,92,2000,178.74),(241,92,5000,446.85),(242,93,100,7.75),(243,93,200,15.49),(244,93,300,23.24),(245,93,400,30.98),(246,93,500,38.73),(247,93,600,46.47),(248,93,700,54.22),(249,93,800,61.96),(250,93,900,69.71),(251,93,1000,77.45),(252,93,2000,154.91),(253,93,5000,387.27),(254,94,100,7.75),(255,94,200,15.49),(256,94,300,23.24),(257,94,400,30.98),(258,94,500,38.73),(259,94,600,46.47),(260,94,700,54.22),(261,94,800,61.96),(262,94,900,69.71),(263,94,1000,77.45),(264,94,2000,154.91),(265,94,5000,387.27),(266,95,100,8.94),(267,95,200,17.87),(268,95,300,26.81),(269,95,400,35.75),(270,95,500,44.69),(271,95,600,53.62),(272,95,700,62.56),(273,95,800,71.5),(274,95,900,80.43),(275,95,1000,89.37),(276,95,2000,178.74),(277,95,5000,446.85),(278,96,100,8.94),(279,96,200,17.87),(280,96,300,26.81),(281,96,400,35.75),(282,96,500,44.69),(283,96,600,53.62),(284,96,700,62.56),(285,96,800,71.5),(286,96,900,80.43),(287,96,1000,89.37),(288,96,2000,178.74),(289,96,5000,446.85),(290,97,100,7.75),(291,97,200,15.49),(292,97,300,23.24),(293,97,400,30.98),(294,97,500,38.73),(295,97,600,46.47),(296,97,700,54.22),(297,97,800,61.96),(298,97,900,69.71),(299,97,1000,77.45),(300,97,2000,154.91),(301,97,5000,387.27),(302,98,100,7.75),(303,98,200,15.49),(304,98,300,23.24),(305,98,400,30.98),(306,98,500,38.73),(307,98,600,46.47),(308,98,700,54.22),(309,98,800,61.96),(310,98,900,69.71),(311,98,1000,77.45),(312,98,2000,154.91),(313,98,5000,387.27),(314,99,100,7.94),(315,99,200,15.89),(316,99,300,23.83),(317,99,400,31.78),(318,99,500,39.72),(319,99,600,47.66),(320,99,700,55.61),(321,99,800,63.55),(322,99,900,71.5),(323,99,1000,79.44),(324,99,2000,158.88),(325,99,5000,397.2),(326,100,100,7.94),(327,100,200,15.89),(328,100,300,23.83),(329,100,400,31.78),(330,100,500,39.72),(331,100,600,47.66),(332,100,700,55.61),(333,100,800,63.55),(334,100,900,71.5),(335,100,1000,79.44),(336,100,2000,158.88),(337,100,5000,397.2),(338,101,100,6.95),(339,101,200,13.9),(340,101,300,20.85),(341,101,400,27.8),(342,101,500,34.76),(343,101,600,41.71),(344,101,700,48.66),(345,101,800,55.61),(346,101,900,62.56),(347,101,1000,69.51),(348,101,2000,139.02),(349,101,5000,347.55),(350,102,100,6.95),(351,102,200,13.9),(352,102,300,20.85),(353,102,400,27.8),(354,102,500,34.76),(355,102,600,41.71),(356,102,700,48.66),(357,102,800,55.61),(358,102,900,62.56),(359,102,1000,69.51),(360,102,2000,139.02),(361,102,5000,347.55),(362,103,100,7.94),(363,103,200,15.89),(364,103,300,23.83),(365,103,400,31.78),(366,103,500,39.72),(367,103,600,47.66),(368,103,700,55.61),(369,103,800,63.55),(370,103,900,71.5),(371,103,1000,79.44),(372,103,2000,158.88),(373,103,5000,397.2),(374,104,100,7.94),(375,104,200,15.89),(376,104,300,23.83),(377,104,400,31.78),(378,104,500,39.72),(379,104,600,47.66),(380,104,700,55.61),(381,104,800,63.55),(382,104,900,71.5),(383,104,1000,79.44),(384,104,2000,158.88),(385,104,5000,397.2),(386,105,100,8.94),(387,105,200,17.87),(388,105,300,26.81),(389,105,400,35.75),(390,105,500,44.69),(391,105,600,53.62),(392,105,700,62.56),(393,105,800,71.5),(394,105,900,80.43),(395,105,1000,89.37),(396,105,2000,178.74),(397,105,5000,446.85),(398,106,100,9.63),(399,106,200,19.26),(400,106,300,28.9),(401,106,400,38.53),(402,106,500,48.16),(403,106,600,57.79),(404,106,700,67.42),(405,106,800,77.06),(406,106,900,86.69),(407,106,1000,96.32),(408,106,2000,192.64),(409,106,5000,481.61),(410,107,100,9.73),(411,107,200,19.46),(412,107,300,29.19),(413,107,400,38.93),(414,107,500,48.66),(415,107,600,58.39),(416,107,700,68.12),(417,107,800,77.85),(418,107,900,87.58),(419,107,1000,97.31),(420,107,2000,194.63),(421,107,5000,486.57),(422,108,100,9.73),(423,108,200,19.46),(424,108,300,29.19),(425,108,400,38.93),(426,108,500,48.66),(427,108,600,58.39),(428,108,700,68.12),(429,108,800,77.85),(430,108,900,87.58),(431,108,1000,97.31),(432,108,2000,194.63),(433,108,5000,486.57),(434,109,100,9.73),(435,109,200,19.46),(436,109,300,29.19),(437,109,400,38.93),(438,109,500,48.66),(439,109,600,58.39),(440,109,700,68.12),(441,109,800,77.85),(442,109,900,87.58),(443,109,1000,97.31),(444,109,2000,194.63),(445,109,5000,486.57),(446,110,100,8.94),(447,110,200,17.87),(448,110,300,26.81),(449,110,400,35.75),(450,110,500,44.69),(451,110,600,53.62),(452,110,700,62.56),(453,110,800,71.5),(454,110,900,80.43),(455,110,1000,89.37),(456,110,2000,178.74),(457,110,5000,446.85),(458,111,100,9.93),(459,111,200,19.86),(460,111,300,29.79),(461,111,400,39.72),(462,111,500,49.65),(463,111,600,59.58),(464,111,700,69.51),(465,111,800,79.44),(466,111,900,89.37),(467,111,1000,99.3),(468,111,2000,198.6),(469,111,5000,496.5),(470,112,100,7.75),(471,112,200,15.49),(472,112,300,23.24),(473,112,400,30.98),(474,112,500,38.73),(475,112,600,46.47),(476,112,700,54.22),(477,112,800,61.96),(478,112,900,69.71),(479,112,1000,77.45),(480,112,2000,154.91),(481,112,5000,387.27),(482,113,100,7.94),(483,113,200,15.89),(484,113,300,23.83),(485,113,400,31.78),(486,113,500,39.72),(487,113,600,47.66),(488,113,700,55.61),(489,113,800,63.55),(490,113,900,71.5),(491,113,1000,79.44),(492,113,2000,158.88),(493,113,5000,397.2),(494,114,100,7.94),(495,114,200,15.89),(496,114,300,23.83),(497,114,400,31.78),(498,114,500,39.72),(499,114,600,47.66),(500,114,700,55.61),(501,114,800,63.55),(502,114,900,71.5),(503,114,1000,79.44),(504,114,2000,158.88),(505,114,5000,397.2),(506,116,100,6.95),(507,116,200,13.9),(508,116,300,20.85),(509,116,400,27.8),(510,116,500,34.76),(511,116,600,41.71),(512,116,700,48.66),(513,116,800,55.61),(514,116,900,62.56),(515,116,1000,69.51),(516,116,2000,139.02),(517,116,5000,347.55),(518,115,100,6.95),(519,115,200,13.9),(520,115,300,20.85),(521,115,400,27.8),(522,115,500,34.76),(523,115,600,41.71),(524,115,700,48.66),(525,115,800,55.61),(526,115,900,62.56),(527,115,1000,69.51),(528,115,2000,139.02),(529,115,5000,347.55),(530,117,100,7.75),(531,117,200,15.49),(532,117,300,23.24),(533,117,400,30.98),(534,117,500,38.73),(535,117,600,46.47),(536,117,700,54.22),(537,117,800,61.96),(538,117,900,69.71),(539,117,1000,77.45),(540,117,2000,154.91),(541,117,5000,387.27),(542,118,100,7.75),(543,118,200,15.49),(544,118,300,23.24),(545,118,400,30.98),(546,118,500,38.73),(547,118,600,46.47),(548,118,700,54.22),(549,118,800,61.96),(550,118,900,69.71),(551,118,1000,77.45),(552,118,2000,154.91),(553,118,5000,387.27),(554,120,1000,14.9),(555,120,2000,29.79),(556,120,3000,44.69),(557,120,4000,59.58),(558,120,5000,74.48),(559,120,6000,89.37),(560,120,7000,104.27),(561,120,8000,119.16),(562,120,9000,134.06),(563,120,10000,148.95),(564,120,20000,297.9),(565,120,30000,446.85),(613,131,7000,277.2),(612,131,5000,198),(611,131,3000,118.8),(610,131,2000,79.2),(609,131,1000,39.6),(608,131,900,35.64),(607,131,800,31.68),(606,131,700,27.72),(605,131,600,23.76),(604,131,500,19.8),(603,131,400,15.84),(602,131,300,11.88),(601,130,7000,291.06),(600,130,5000,207.9),(599,130,3000,124.74),(598,130,2000,83.16),(597,130,1000,41.58),(596,130,900,37.42),(595,130,800,33.26),(594,130,700,29.11),(593,130,600,24.95),(592,130,500,20.79),(591,130,400,16.63),(590,130,300,12.47),(614,132,300,12.47),(615,132,400,16.63),(616,132,500,20.79),(617,132,600,24.95),(618,132,700,29.11),(619,132,800,33.26),(620,132,900,37.42),(621,132,1000,41.58),(622,132,2000,83.16),(623,132,3000,124.74),(624,132,5000,207.9),(625,132,7000,291.06),(626,133,300,11.88),(627,133,400,15.84),(628,133,500,19.8),(629,133,600,23.76),(630,133,700,27.72),(631,133,800,31.68),(632,133,900,35.64),(633,133,1000,39.6),(634,133,2000,79.2),(635,133,3000,118.8),(636,133,5000,198),(637,133,7000,277.2),(638,134,300,11.88),(639,134,400,15.84),(640,134,500,19.8),(641,134,600,23.76),(642,134,700,27.72),(643,134,800,31.68),(644,134,900,35.64),(645,134,1000,39.6),(646,134,2000,79.2),(647,134,3000,118.8),(648,134,5000,198),(649,134,7000,277.2),(650,135,300,12.47),(651,135,400,16.63),(652,135,500,20.79),(653,135,600,24.95),(654,135,700,29.11),(655,135,800,33.26),(656,135,900,37.42),(657,135,1000,41.58),(658,135,2000,83.16),(659,135,3000,124.74),(660,135,5000,207.9),(661,135,7000,291.06),(662,137,300,12.47),(663,137,400,16.63),(664,137,500,20.79),(665,137,600,24.95),(666,137,700,29.11),(667,137,800,33.26),(668,137,900,37.42),(669,137,1000,41.58),(670,137,2000,83.16),(671,137,3000,124.74),(672,137,5000,207.9),(673,137,7000,291.06),(674,138,300,11.88),(675,138,400,15.84),(676,138,500,19.8),(677,138,600,23.76),(678,138,700,27.72),(679,138,800,31.68),(680,138,900,35.64),(681,138,1000,39.6),(682,138,2000,79.2),(683,138,3000,118.8),(684,138,5000,198),(685,138,7000,277.2),(686,139,300,11.88),(687,139,400,15.84),(688,139,500,19.8),(689,139,600,23.76),(690,139,700,27.72),(691,139,800,31.68),(692,139,900,35.64),(693,139,1000,39.6),(694,139,2000,79.2),(695,139,3000,118.8),(696,139,5000,198),(697,139,7000,277.2),(698,140,300,12.47),(699,140,400,16.63),(700,140,500,20.79),(701,140,600,24.95),(702,140,700,29.11),(703,140,800,33.26),(704,140,900,37.42),(705,140,1000,41.58),(706,140,2000,83.16),(707,140,3000,124.74),(708,140,5000,207.9),(709,140,7000,291.06),(710,141,300,11.29),(711,141,400,15.05),(712,141,500,18.81),(713,141,600,22.57),(714,141,700,26.33),(715,141,800,30.1),(716,141,900,33.86),(717,141,1000,37.62),(718,141,2000,75.24),(719,141,3000,112.86),(720,141,5000,188.1),(721,141,7000,263.34),(722,142,300,10.84),(723,142,400,14.45),(724,142,500,18.07),(725,142,600,21.68),(726,142,700,25.29),(727,142,800,28.91),(728,142,900,32.52),(729,142,1000,36.14),(730,142,2000,72.27),(731,142,3000,108.41),(732,142,5000,180.68),(733,142,7000,252.94),(734,143,300,10.99),(735,143,400,14.65),(736,143,500,18.32),(737,143,600,21.98),(738,143,700,25.64),(739,143,800,29.3),(740,143,900,32.97),(741,143,1000,36.63),(742,143,2000,73.26),(743,143,3000,109.89),(744,143,5000,183.15),(745,143,7000,256.41),(746,144,300,9.5),(747,144,400,12.67),(748,144,500,15.84),(749,144,600,19.01),(750,144,700,22.18),(751,144,800,25.34),(752,144,900,28.51),(753,144,1000,31.68),(754,144,2000,63.36),(755,144,3000,95.04),(756,144,5000,158.4),(757,144,7000,221.76),(758,145,300,10.4),(759,145,400,13.86),(760,145,500,17.33),(761,145,600,20.79),(762,145,700,24.26),(763,145,800,27.72),(764,145,900,31.19),(765,145,1000,34.65),(766,145,2000,69.3),(767,145,3000,103.95),(768,145,5000,173.25),(769,145,7000,242.55),(770,146,300,10.84),(771,146,400,14.45),(772,146,500,18.07),(773,146,600,21.68),(774,146,700,25.29),(775,146,800,28.91),(776,146,900,32.52),(777,146,1000,36.14),(778,146,2000,72.27),(779,146,3000,108.41),(780,146,5000,180.68),(781,146,7000,252.94),(782,147,300,9.5),(783,147,400,12.67),(784,147,500,15.84),(785,147,600,19.01),(786,147,700,22.18),(787,147,800,25.34),(788,147,900,28.51),(789,147,1000,31.68),(790,147,2000,63.36),(791,147,3000,95.04),(792,147,5000,158.4),(793,147,7000,221.76),(794,148,300,9.5),(795,148,400,12.67),(796,148,500,15.84),(797,148,600,19.01),(798,148,700,22.18),(799,148,800,25.34),(800,148,900,28.51),(801,148,1000,31.68),(802,148,2000,63.36),(803,148,3000,95.04),(804,148,5000,158.4),(805,148,7000,221.76),(806,149,300,10.69),(807,149,400,14.26),(808,149,500,17.82),(809,149,600,21.38),(810,149,700,24.95),(811,149,800,28.51),(812,149,900,32.08),(813,149,1000,35.64),(814,149,2000,71.28),(815,149,3000,106.92),(816,149,5000,178.2),(817,149,7000,249.48),(818,151,300,12.47),(819,151,400,16.63),(820,151,500,20.79),(821,151,600,24.95),(822,151,700,29.11),(823,151,800,33.26),(824,151,900,37.42),(825,151,1000,41.58),(826,151,2000,83.16),(827,151,3000,124.74),(828,151,5000,207.9),(829,151,7000,291.06),(830,152,300,12.47),(831,152,400,16.63),(832,152,500,20.79),(833,152,600,24.95),(834,152,700,29.11),(835,152,800,33.26),(836,152,900,37.42),(837,152,1000,41.58),(838,152,2000,83.16),(839,152,3000,124.74),(840,152,5000,207.9),(841,152,7000,291.06),(842,155,2,5.09),(843,155,5,12.72),(844,155,10,25.44),(845,155,20,50.89),(846,155,30,76.33),(847,155,40,101.77),(848,155,50,127.22),(849,155,60,152.66),(850,155,70,178.1),(851,155,80,203.54),(852,155,90,228.99),(853,155,100,254.43),(854,156,2,5.09),(855,156,5,12.72),(856,156,10,25.44),(857,156,20,50.89),(858,156,30,76.33),(859,156,40,101.77),(860,156,50,127.22),(861,156,60,152.66),(862,156,70,178.1),(863,156,80,203.54),(864,156,90,228.99),(865,156,100,254.43),(866,157,2,5.09),(867,157,5,12.72),(868,157,10,25.44),(869,157,20,50.89),(870,157,30,76.33),(871,157,40,101.77),(872,157,50,127.22),(873,157,60,152.66),(874,157,70,178.1),(875,157,80,203.54),(876,157,90,228.99),(877,157,100,254.43),(878,158,2,5.09),(879,158,5,12.72),(880,158,10,25.44),(881,158,20,50.89),(882,158,30,76.33),(883,158,40,101.77),(884,158,50,127.22),(885,158,60,152.66),(886,158,70,178.1),(887,158,80,203.54),(888,158,90,228.99),(889,158,100,254.43),(890,160,3,8.91),(891,160,5,14.85),(892,160,10,29.7),(893,160,20,59.4),(894,160,30,89.1),(895,160,40,118.8),(896,160,50,148.5),(897,160,60,178.2),(898,160,70,207.9),(899,160,80,237.6),(900,160,90,267.3),(901,160,100,297),(902,161,3,8.91),(903,161,5,14.85),(904,161,10,29.7),(905,161,20,59.4),(906,161,30,89.1),(907,161,40,118.8),(908,161,50,148.5),(909,161,60,178.2),(910,161,70,207.9),(911,161,80,237.6),(912,161,90,267.3),(913,161,100,297),(914,162,3,8.91),(915,162,5,14.85),(916,162,10,29.7),(917,162,20,59.4),(918,162,30,89.1),(919,162,40,118.8),(920,162,50,148.5),(921,162,60,178.2),(922,162,70,207.9),(923,162,80,237.6),(924,162,90,267.3),(925,162,100,297),(926,163,3,8.61),(927,163,5,14.36),(928,163,10,28.71),(929,163,20,57.42),(930,163,30,86.13),(931,163,40,114.84),(932,163,50,143.55),(933,163,60,172.26),(934,163,70,200.97),(935,163,80,229.68),(936,163,90,258.39),(937,163,100,287.1),(938,164,3,8.61),(939,164,5,14.36),(940,164,10,28.71),(941,164,20,57.42),(942,164,30,86.13),(943,164,40,114.84),(944,164,50,143.55),(945,164,60,172.26),(946,164,70,200.97),(947,164,80,229.68),(948,164,90,258.39),(949,164,100,287.1),(950,165,3,8.61),(951,165,5,14.36),(952,165,10,28.71),(953,165,20,57.42),(954,165,30,86.13),(955,165,40,114.84),(956,165,50,143.55),(957,165,60,172.26),(958,165,70,200.97),(959,165,80,229.68),(960,165,90,258.39),(961,165,100,287.1),(962,166,3,19.9),(963,166,5,33.17),(964,166,10,66.33),(965,166,20,132.66),(966,166,30,198.99),(967,166,40,265.32),(968,166,50,331.65),(969,166,60,397.98),(970,166,70,464.31),(971,166,80,530.64),(972,166,90,596.97),(973,166,100,663.3);

/*Table structure for table `tny_fs_datasrc_22ld` */

DROP TABLE IF EXISTS `tny_fs_datasrc_22ld`;

CREATE TABLE `tny_fs_datasrc_22ld` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'sid',
  `nssid` int(10) unsigned NOT NULL,
  `l` int(11) DEFAULT NULL COMMENT 'level',
  `d` float DEFAULT NULL COMMENT 'day',
  PRIMARY KEY (`sid`),
  UNIQUE KEY `npsid` (`l`,`nssid`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

/*Data for the table `tny_fs_datasrc_22ld` */

insert  into `tny_fs_datasrc_22ld`(`sid`,`nssid`,`l`,`d`) values (17,22,10,100),(18,22,5,100),(19,22,15,505),(20,41,5,1),(21,41,10,2),(22,41,15,3),(28,48,15,3),(27,48,10,2),(26,48,5,1),(29,49,5,11),(30,49,11,21),(31,49,15,23);

/*Table structure for table `tny_fs_datasrc_22tp` */

DROP TABLE IF EXISTS `tny_fs_datasrc_22tp`;

CREATE TABLE `tny_fs_datasrc_22tp` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'sid',
  `nssid` int(10) unsigned NOT NULL,
  `t` varchar(128) DEFAULT NULL COMMENT 'title',
  `p` float DEFAULT NULL COMMENT 'price',
  `order` int(10) DEFAULT '0' COMMENT 'order',
  PRIMARY KEY (`sid`),
  UNIQUE KEY `npsid` (`t`,`nssid`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

/*Data for the table `tny_fs_datasrc_22tp` */

insert  into `tny_fs_datasrc_22tp`(`sid`,`nssid`,`t`,`p`,`order`) values (11,19,'edc',32,1),(12,19,'qaz',22,1),(13,19,'wsx',23,12),(14,20,'wow lv1-10',10,0),(15,20,'sample title',20,1),(16,20,'test title',29,2),(17,20,'aion gold 50',29,3),(18,72,'wow 60 Day Pre-Paid Game Time Card',32,0),(19,72,'WLK CDK',25,1),(20,72,'CTM CDK',28,2);

/*Table structure for table `tny_fs_datasrc_23ldp` */

DROP TABLE IF EXISTS `tny_fs_datasrc_23ldp`;

CREATE TABLE `tny_fs_datasrc_23ldp` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'sid',
  `nssid` int(10) unsigned NOT NULL,
  `l` int(11) DEFAULT NULL COMMENT 'level',
  `d` float DEFAULT NULL COMMENT 'day',
  `p` float DEFAULT NULL COMMENT 'price',
  PRIMARY KEY (`sid`),
  UNIQUE KEY `npsid` (`l`,`nssid`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

/*Data for the table `tny_fs_datasrc_23ldp` */

insert  into `tny_fs_datasrc_23ldp`(`sid`,`nssid`,`l`,`d`,`p`) values (9,56,5,1,10),(10,56,10,2,19),(11,56,15,3,28),(12,56,50,30,270),(13,60,30,1,21),(14,60,50,0.8,20),(15,60,65,0.8,20),(16,60,75,0.8,20),(26,60,100,0.3,25),(25,60,95,0.3,25),(24,60,90,0.5,30),(23,60,85,0.5,25),(22,60,80,0.6,15),(27,73,20,0.5,16),(28,73,30,1,25),(29,73,40,1,30),(30,73,50,2,60),(31,73,60,3,90),(32,73,65,3,90),(33,124,10,0.3,15),(34,124,20,0.5,25),(35,124,30,1,35),(36,124,40,1.5,60),(37,124,50,2,70);

/*Table structure for table `tny_fs_datasrc_23tpe` */

DROP TABLE IF EXISTS `tny_fs_datasrc_23tpe`;

CREATE TABLE `tny_fs_datasrc_23tpe` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'sid',
  `nssid` int(10) unsigned NOT NULL,
  `t` varchar(128) DEFAULT NULL COMMENT 'title',
  `p` float DEFAULT NULL COMMENT 'price',
  `e` varchar(1024) DEFAULT NULL COMMENT 'extra description',
  `order` int(11) DEFAULT '0' COMMENT 'order',
  PRIMARY KEY (`sid`),
  UNIQUE KEY `npsid` (`t`,`nssid`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

/*Data for the table `tny_fs_datasrc_23tpe` */

insert  into `tny_fs_datasrc_23tpe`(`sid`,`nssid`,`t`,`p`,`e`,`order`) values (6,42,'wow lv1-10',10,'require gold 50',0),(7,42,'sample title',20,'require level 5+',1),(8,42,'test title',29,'',2),(9,42,'aion gold 50',29,'require something',3),(10,43,'wow lv1-10',10,'require gold 50',0),(11,43,'sample title',20,'require level 5+',1),(12,43,'test title',29,'',2),(13,43,'aion gold 50',29,'require something',3),(14,55,'wow lv1-10',10,'require gold 50',0),(15,55,'sample title',20,'require level 5+',1),(16,55,'test title',29,'',2),(17,55,'aion gold 50',29,'require something',3),(18,61,'Green Fire Quest-Warlock',30,'0.5',0),(19,62,'WOD 90-100 basic package 1 Day',45,'Handworks only. U get get Free flight paths uncovered 90%, 500 Garrison Resources, Garrison lv 2, Free 5000g, 9/10 followers',0),(20,62,'WOD 90-100 package1 2 Day ',80,'Handworks only. Basic package, PVP Full Lv675 honor sets+ weapon',1),(21,62,'WOD 90-100 package1 3 Day ',120,'Handworks only. Basic package above, PVE Items average lvl 630',2),(22,62,'WOD 90-100 package1 6 Day ',200,'Handworks only. Basic package above, PVE Items average lvl 630, Legendary Ring quest 640-680',3),(23,63,'wow lv1-90',150,'6 Day',0),(24,63,'wow lv90-100',40,'1 Day',1),(25,63,'wow lv1-100',170,'5 Day',2),(26,74,'Aion lv1-20 handworks only, you take all obtained loots and kinah. skill learned ',15,'0.5',0),(27,74,'Aion lv1-30 handworks only, you take all obtained loots and kinah. skill learned',40,'1.5',1),(28,74,'Aion lv1-40 handworks only, you take all obtained loots and kinah. skill learned',90,'3',2),(29,74,'Aion lv1-50 handworks only, you take all obtained loots and kinah. skill learned',210,'7',3),(30,74,'Aion lv1-60 handworks only, you take all obtained loots and kinah. skill learned',300,'10',4),(31,74,'Aion lv1-65 handworks only, you take all obtained loots and kinah. skill learned',390,'13',5),(32,128,'ArcheAge leveling 1-20',35,'Guaranted handworks only, you get all loots&gold',0),(33,128,'ArcheAge leveling 1-30',70,'Guaranted handworks only, you get all loots&gold',1),(34,128,'ArcheAge leveling 1-40',130,'Guaranted handworks only, you get all loots&gold',2),(35,128,'ArcheAge leveling 1-50',170,'Guaranted handworks only, you get all loots&gold',3),(36,153,'ArcheAge hasla weapon',150,'150 tokens',0),(37,153,'ArcheAge Brilliant stage weapon',200,'200 tokens',1),(38,153,'ArcheAge Eternal stage',300,'300 tokens',2),(39,153,'ArcheAge faded honor token',25,'25 tokens',3),(40,153,'ArcheAge faded loyalty token',25,'25 tokens',4),(41,153,'ArcheAge faded conviction token',25,'25 tokens',5),(42,153,'ArcheAge faded courage token',25,'25 tokens',6),(43,153,'ArcheAge faded fortitude token',25,'25 tokens',7),(44,153,'ArcheAge faded sacrifice token',25,'25 tokens',8),(45,153,'ArcheAge faded compassionate token',25,'25 tokens',9);

/*Table structure for table `tny_fs_datasrc_hot` */

DROP TABLE IF EXISTS `tny_fs_datasrc_hot`;

CREATE TABLE `tny_fs_datasrc_hot` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'sid',
  `nssid` int(10) unsigned NOT NULL,
  `t` varchar(128) DEFAULT NULL COMMENT 'title',
  `op` float DEFAULT NULL COMMENT 'old price',
  `np` float DEFAULT NULL COMMENT 'new price',
  `ico` varchar(1024) DEFAULT NULL COMMENT 'ico path',
  `order` int(11) DEFAULT '0' COMMENT 'order',
  `otpl` varchar(20) NOT NULL,
  PRIMARY KEY (`sid`),
  UNIQUE KEY `npsid` (`t`,`nssid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `tny_fs_datasrc_hot` */

insert  into `tny_fs_datasrc_hot`(`sid`,`nssid`,`t`,`op`,`np`,`ico`,`order`,`otpl`) values (1,44,'ArcheAge 1-50',230,170,'ico3',2,''),(2,44,'World of tanks 1-10LV',500,400,'ico2',3,''),(3,44,'Diablo3 1-70 ',10,5,'ico1',0,''),(4,44,'League of Legend\'s 1-30',160,125,'ico3',4,''),(5,44,'Heros of the Storm 1-40',300,250,'ico2',1,'');

/*Table structure for table `tny_fs_datasrc_html` */

DROP TABLE IF EXISTS `tny_fs_datasrc_html`;

CREATE TABLE `tny_fs_datasrc_html` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'sid',
  `nssid` int(10) unsigned NOT NULL,
  `c` text COMMENT 'content',
  PRIMARY KEY (`sid`),
  UNIQUE KEY `npsid` (`nssid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `tny_fs_datasrc_html` */

insert  into `tny_fs_datasrc_html`(`sid`,`nssid`,`c`) values (1,45,'<i>hello.</i>'),(2,50,'<i>hi</i>');

/*Table structure for table `tny_fs_datasrc_ofhint` */

DROP TABLE IF EXISTS `tny_fs_datasrc_ofhint`;

CREATE TABLE `tny_fs_datasrc_ofhint` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'sid',
  `nssid` int(10) unsigned NOT NULL,
  `t` varchar(128) DEFAULT NULL COMMENT 'title',
  PRIMARY KEY (`sid`),
  UNIQUE KEY `npsid` (`t`,`nssid`)
) ENGINE=MyISAM AUTO_INCREMENT=771 DEFAULT CHARSET=utf8;

/*Data for the table `tny_fs_datasrc_ofhint` */

insert  into `tny_fs_datasrc_ofhint`(`sid`,`nssid`,`t`) values (6,67,'Aerie Peak'),(7,67,'Aggramar'),(8,67,'Alexstrasza'),(9,67,'Alleria'),(10,67,'Aman\'Thul'),(11,67,'Antonidas'),(12,67,'Anvilmar'),(13,67,'Arathor'),(14,67,'Area 52'),(15,67,'Arygos'),(16,67,'Azjol-Nerub'),(17,67,'Azuremyst'),(18,67,'Baelgun'),(19,67,'Blackhand'),(20,67,'Blade\'s Edge'),(21,67,'Bladefist'),(22,67,'Bloodhoof'),(23,67,'Borean Tundra'),(24,67,'Bronzebeard'),(25,67,'Caelestrasz'),(26,67,'Cairne'),(27,67,'Cenarius'),(28,67,'Dalaran'),(29,67,'Darrowmere'),(30,67,'Dath\'Remar'),(31,67,'Dawnbringer'),(32,67,'Dentarg'),(33,67,'Doomhammer'),(34,67,'Draenor'),(35,67,'Dragonblight'),(36,67,'Drak\'thul'),(37,67,'Draka'),(38,67,'Drenden'),(39,67,'Durotan'),(40,67,'Duskwood'),(41,67,'Echo Isles'),(42,67,'Eitrigg'),(43,67,'Eldre\'Thalas'),(44,67,'Elune'),(45,67,'Eonar'),(46,67,'Exodar'),(47,67,'Fenris'),(48,67,'Fizzcrank'),(49,67,'Galakrond'),(50,67,'Gallywix'),(51,67,'Garona'),(52,67,'Garrosh'),(53,67,'Ghostlands'),(54,67,'Gilneas'),(55,67,'Gnomeregan'),(56,67,'Goldrinn'),(57,67,'Greymane'),(58,67,'Grizzly Hills'),(59,67,'Hellscream'),(60,67,'Hydraxis'),(61,67,'Hyjal'),(62,67,'Icecrown'),(63,67,'Kael\'thas'),(64,67,'Kargath'),(65,67,'Khadgar'),(66,67,'Khaz Modan'),(67,67,'Khaz\'goroth'),(68,67,'Kilrogg'),(69,67,'Korialstrasz'),(70,67,'Kul Tiras'),(71,67,'Lightbringer'),(72,67,'Llane'),(73,67,'Lothar'),(74,67,'Madoran'),(75,67,'Malfurion'),(76,67,'Malygos'),(77,67,'Medivh'),(78,67,'Misha'),(79,67,'Mok\'Nathal'),(80,67,'Moonrunner'),(81,67,'Muradin'),(82,67,'Nagrand'),(83,67,'Nazgrel'),(84,67,'Nesingwary'),(85,67,'Nordrassil'),(86,67,'Norgannon'),(87,67,'Perenolde'),(88,67,'Proudmoore'),(89,67,'Quel\'dorei'),(90,67,'Quel\'Thalas'),(91,67,'Ravencrest'),(92,67,'Rexxar'),(93,67,'Runetotem'),(94,67,'Saurfang'),(95,67,'Sen\'jin'),(96,67,'Shadowsong'),(97,67,'Shandris'),(98,67,'Shu\'halo'),(99,67,'Silvermoon'),(100,67,'Skywall'),(101,67,'Staghelm'),(102,67,'Stormrage'),(103,67,'Suramar'),(104,67,'Tanaris'),(105,67,'Terenas'),(106,67,'Terokkar'),(107,67,'Thrall'),(108,67,'Thunderhorn'),(109,67,'Trollbane'),(110,67,'Turalyon'),(111,67,'Uldaman'),(112,67,'Uldum'),(113,67,'Undermine'),(114,67,'Uther'),(115,67,'Vek\'nilash'),(116,67,'Velen'),(117,67,'Whisperwind'),(118,67,'Windrunner'),(119,67,'Winterhoof'),(120,67,'Ysera'),(121,67,'Zangarmarsh'),(122,67,'Zul\'jin'),(123,67,'Aegwynn'),(124,67,'Agamaggan'),(125,67,'Akama'),(126,67,'Altar of Storms'),(127,67,'Alterac Mountains'),(128,67,'Andorhal'),(129,67,'Anetheron'),(130,67,'Anub\'arak'),(131,67,'Archimonde'),(132,67,'Arthas'),(133,67,'Auchindoun'),(134,67,'Azgalor'),(135,67,'Azralon'),(136,67,'Azshara'),(137,67,'Balnazzar'),(138,67,'Barthilas'),(139,67,'Black Dragonflight'),(140,67,'Blackrock'),(141,67,'Blackwing Lair'),(142,67,'Bleeding Hollow'),(143,67,'Blood Furnace'),(144,67,'Bloodscalp'),(145,67,'Bonechewer'),(146,67,'Boulderfist'),(147,67,'Burning Blade'),(148,67,'Burning Legion'),(149,67,'Cho\'gall'),(150,67,'Chromaggus'),(151,67,'Coilfang'),(152,67,'Crushridge'),(153,67,'Daggerspine'),(154,67,'Dalvengyr'),(155,67,'Dark Iron'),(156,67,'Darkspear'),(157,67,'Deathwing'),(158,67,'Demon Soul'),(159,67,'Destromath'),(160,67,'Dethecus'),(161,67,'Detheroc'),(162,67,'Dragonmaw'),(163,67,'Drak\'Tharon'),(164,67,'Drakkari'),(165,67,'Dreadmaul'),(166,67,'Dunemaul'),(167,67,'Eredar'),(168,67,'Executus'),(169,67,'Firetree'),(170,67,'Frostmane'),(171,67,'Frostmourne'),(172,67,'Frostwolf'),(173,67,'Garithos'),(174,67,'Gorefiend'),(175,67,'Gorgonnash'),(176,67,'Gul\'dan'),(177,67,'Gundrak'),(178,67,'Gurubashi'),(179,67,'Hakkar'),(180,67,'Haomarush'),(181,67,'Illidan'),(182,67,'Jaedenar'),(183,67,'Jubei\'Thos'),(184,67,'Kalecgos'),(185,67,'Kel\'Thuzad'),(186,67,'Kil\'jaeden'),(187,67,'Korgath'),(188,67,'Laughing Skull'),(189,67,'Lethon'),(190,67,'Lightning\'s Blade'),(191,67,'Magtheridon'),(192,67,'Maiev'),(193,67,'Mal\'Ganis'),(194,67,'Malorne'),(195,67,'Mannoroth'),(196,67,'Mug\'thol'),(197,67,'Nathrezim'),(198,67,'Nazjatar'),(199,67,'Nemesis'),(200,67,'Ner\'zhul'),(201,67,'Onyxia'),(202,67,'Ragnaros'),(203,67,'Rivendare'),(204,67,'Sargeras'),(205,67,'Scilla'),(206,67,'Shadowmoon'),(207,67,'Shattered Halls'),(208,67,'Shattered Hand'),(209,67,'Skullcrusher'),(210,67,'Smolderthorn'),(211,67,'Spinebreaker'),(212,67,'Spirestone'),(213,67,'Stonemaul'),(214,67,'Stormreaver'),(215,67,'Stormscale'),(216,67,'Thaurissan'),(217,67,'The Forgotten Coast'),(218,67,'The Underbog'),(219,67,'Thunderlord'),(220,67,'Tichondrius'),(221,67,'Tol Barad'),(222,67,'Tortheldrin'),(223,67,'Ursin'),(224,67,'Vashj'),(225,67,'Warsong'),(226,67,'Wildhammer'),(227,67,'Ysondre'),(228,67,'Zuluhed'),(229,67,'Argent Dawn'),(230,67,'Blackwater Raiders'),(231,67,'Cenarion Circle'),(232,67,'Earthen Ring'),(233,67,'Farstriders'),(234,67,'Feathermoon'),(235,67,'Kirin Tor'),(236,67,'Moon Guard'),(237,67,'Scarlet Crusade'),(238,67,'Sentinels'),(239,67,'Shadow Council'),(240,67,'Silver Hand'),(241,67,'Sisters of Elune'),(242,67,'Steamwheedle Cartel'),(243,67,'The Scryers'),(244,67,'Thorium Brotherhood'),(245,67,'Wyrmrest Accord'),(246,67,'Emerald Dream'),(247,67,'Lightninghoof'),(248,67,'Maelstrom'),(249,67,'Ravenholdt'),(250,67,'The Venture Co'),(251,67,'Twisting Nether'),(252,69,'Aegwynn'),(253,69,'Aerie Peak'),(254,69,'Agamaggan'),(255,69,'Aggra (Português)'),(256,69,'Aggramar'),(257,69,'Ahn\'Qiraj'),(258,69,'Al\'Akir'),(259,69,'Alexstrasza'),(260,69,'Alleria'),(261,69,'Alonsus'),(262,69,'Aman\'Thul'),(263,69,'Ambossar'),(264,69,'Anachronos'),(265,69,'Anetheron'),(266,69,'Antonidas'),(267,69,'Anub\'arak'),(268,69,'Arak-arahm'),(269,69,'Arathi'),(270,69,'Arathor'),(271,69,'Archimonde'),(272,69,'Area 52'),(273,69,'Argent Dawn'),(274,69,'Arthas'),(275,69,'Arygos'),(276,69,'Ashenvale'),(277,69,'Aszune'),(278,69,'Auchindoun'),(279,69,'Azjol-Nerub'),(280,69,'Azshara'),(281,69,'Azuregos'),(282,69,'Azuremyst'),(283,69,'Baelgun'),(284,69,'Balnazzar'),(285,69,'Blackhand'),(286,69,'Blackmoore'),(287,69,'Blackrock'),(288,69,'Blackscar'),(289,69,'Blade\'s Edge'),(290,69,'Bladefist'),(291,69,'Bloodfeather'),(292,69,'Bloodhoof'),(293,69,'Bloodscalp'),(294,69,'Blutkessel'),(295,69,'Booty Bay'),(296,69,'Borean Tundra'),(297,69,'Boulderfist'),(298,69,'Bronze Dragonflight'),(299,69,'Bronzebeard'),(300,69,'Burning Blade'),(301,69,'Burning Legion'),(302,69,'Burning Steppes'),(303,69,'C\'Thun'),(304,69,'Chamber of Aspects'),(305,69,'Chants ¨¦ternels'),(306,69,'Cho\'gall'),(307,69,'Chromaggus'),(308,69,'Colinas Pardas'),(309,69,'Confrérie du Thorium'),(310,69,'Conseil des Ombres'),(311,69,'Crushridge'),(312,69,'Culte de la Rive noire'),(313,69,'Daggerspine'),(314,69,'Dalaran'),(315,69,'Dalvengyr'),(316,69,'Darkmoon Faire'),(317,69,'Darksorrow'),(318,69,'Darkspear'),(319,69,'Das Konsortium'),(320,69,'Das Syndikat'),(321,69,'Deathguard'),(322,69,'Deathweaver'),(323,69,'Deathwing'),(324,69,'Deepholm'),(325,69,'Defias Brotherhood'),(326,69,'Dentarg'),(327,69,'Der abyssische Rat'),(328,69,'Der Mithrilorden'),(329,69,'Der Rat von Dalaran'),(330,69,'Destromath'),(331,69,'Dethecus'),(332,69,'Die Aldor'),(333,69,'Die Arguswacht'),(334,69,'Die ewige Wacht'),(335,69,'Die Nachtwache'),(336,69,'Die Silberne Hand'),(337,69,'Die Todeskrallen'),(338,69,'Doomhammer'),(339,69,'Draenor'),(340,69,'Dragonblight'),(341,69,'Dragonmaw'),(342,69,'Drak\'thul'),(343,69,'Drek\'Thar'),(344,69,'Dun Modr'),(345,69,'Dun Morogh'),(346,69,'Dunemaul'),(347,69,'Durotan'),(348,69,'Earthen Ring'),(349,69,'Echsenkessel'),(350,69,'Eitrigg'),(351,69,'Eldre\'Thalas'),(352,69,'Elune'),(353,69,'Emerald Dream'),(354,69,'Emeriss'),(355,69,'Eonar'),(356,69,'Eredar'),(357,69,'Eversong'),(358,69,'Executus'),(359,69,'Exodar'),(360,69,'Festung der Stürme'),(361,69,'Fordragon'),(362,69,'Forscherliga'),(363,69,'Frostmane'),(364,69,'Frostmourne'),(365,69,'Frostwhisper'),(366,69,'Frostwolf'),(367,69,'Galakrond'),(368,69,'Garona'),(369,69,'Garrosh'),(370,69,'Genjuros'),(371,69,'Ghostlands'),(372,69,'Gilneas'),(373,69,'Goldrinn'),(374,69,'Gordunni'),(375,69,'Gorgonnash'),(376,69,'Greymane'),(377,69,'Grim Batol'),(378,69,'Grom'),(379,69,'Gul\'dan'),(380,69,'Hakkar'),(381,69,'Haomarush'),(382,69,'Hellfire'),(383,69,'Hellscream'),(384,69,'Howling Fjord'),(385,69,'Hyjal'),(386,69,'Illidan'),(387,69,'Jaedenar'),(388,69,'Kael\'thas'),(389,69,'Karazhan'),(390,69,'Kargath'),(391,69,'Kazzak'),(392,69,'Kel\'Thuzad'),(393,69,'Khadgar'),(394,69,'Khaz Modan'),(395,69,'Khaz\'goroth'),(396,69,'Kil\'jaeden'),(397,69,'Kilrogg'),(398,69,'Kirin Tor'),(399,69,'Kor\'gall'),(400,69,'Krag\'jin'),(401,69,'Krasus'),(402,69,'Kul Tiras'),(403,69,'Kult der Verdammten'),(404,69,'La Croisade écarlate'),(405,69,'Laughing Skull'),(406,69,'Les Clairvoyants'),(407,69,'Les Sentinelles'),(408,69,'Lich King'),(409,69,'Lightbringer'),(410,69,'Lightning\'s Blade'),(411,69,'Lordaeron'),(412,69,'Los Errantes'),(413,69,'Lothar'),(414,69,'Madmortem'),(415,69,'Magtheridon'),(416,69,'Mal\'Ganis'),(417,69,'Malfurion'),(418,69,'Malorne'),(419,69,'Malygos'),(420,69,'Mannoroth'),(421,69,'Marécage de Zangar'),(422,69,'Mazrigos'),(423,69,'Medivh'),(424,69,'Minahonda'),(425,69,'Moonglade'),(426,69,'Mug\'thol'),(427,69,'Nagrand'),(428,69,'Nathrezim'),(429,69,'Naxxramas'),(430,69,'Nazjatar'),(431,69,'Nefarian'),(432,69,'Neptulon'),(433,69,'Ner\'zhul'),(434,69,'Nera\'thor'),(435,69,'Nethersturm'),(436,69,'Nordrassil'),(437,69,'Norgannon'),(438,69,'Nozdormu'),(439,69,'Onyxia'),(440,69,'Outland'),(441,69,'Perenolde'),(442,69,'Proudmoore'),(443,69,'Quel\'Thalas'),(444,69,'Ragnaros'),(445,69,'Rajaxx'),(446,69,'Rashgarroth'),(447,69,'Ravencrest'),(448,69,'Ravenholdt'),(449,69,'Razuvious'),(450,69,'Rexxar'),(451,69,'Runetotem'),(452,69,'Sanguino'),(453,69,'Sargeras'),(454,69,'Saurfang'),(455,69,'Scarshield Legion'),(456,69,'Sen\'jin'),(457,69,'Shadowsong'),(458,69,'Shattered Halls'),(459,69,'Shattered Hand'),(460,69,'Shattrath'),(461,69,'Shen\'dralar'),(462,69,'Silvermoon'),(463,69,'Sinstralis'),(464,69,'Skullcrusher'),(465,69,'Soulflayer'),(466,69,'Spinebreaker'),(467,69,'Sporeggar'),(468,69,'Steamwheedle Cartel'),(469,69,'Stormrage'),(470,69,'Stormreaver'),(471,69,'Stormscale'),(472,69,'Sunstrider'),(473,69,'Suramar'),(474,69,'Sylvanas'),(475,69,'Taerar'),(476,69,'Talnivarr'),(477,69,'Tarren Mill'),(478,69,'Teldrassil'),(479,69,'Temple noir'),(480,69,'Terenas'),(481,69,'Terokkar'),(482,69,'Terrordar'),(483,69,'The Maelstrom'),(484,69,'The Sha\'tar'),(485,69,'The Venture Co'),(486,69,'Theradras'),(487,69,'Thermaplugg'),(488,69,'Thrall'),(489,69,'Throk\'Feroth'),(490,69,'Thunderhorn'),(491,69,'Tichondrius'),(492,69,'Tirion'),(493,69,'Todeswache'),(494,69,'Trollbane'),(495,69,'Turalyon'),(496,69,'Twilight\'s Hammer'),(497,69,'Twisting Nether'),(498,69,'Tyrande'),(499,69,'Uldaman'),(500,69,'Ulduar'),(501,69,'Uldum'),(502,69,'Un\'Goro'),(503,69,'Varimathras'),(504,69,'Vashj'),(505,69,'Vek\'lor'),(506,69,'Vek\'nilash'),(507,69,'Vol\'jin'),(508,69,'Wildhammer'),(509,69,'Wrathbringer'),(510,69,'Xavius'),(511,69,'Ysera'),(512,69,'Ysondre'),(513,69,'Zenedar'),(514,69,'Zirkel des Cenarius'),(515,69,'Zul\'jin'),(516,69,'Zuluhed'),(517,68,'Aegwynn'),(518,68,'Aerie Peak'),(519,68,'Agamaggan'),(520,68,'Aggramar'),(521,68,'Akama'),(522,68,'Alexstrasza'),(523,68,'Alleria'),(524,68,'Altar of Storms'),(525,68,'Alterac Mountains'),(526,68,'Aman\'Thul'),(527,68,'Andorhal'),(528,68,'Anetheron'),(529,68,'Antonidas'),(530,68,'Anub\'arak'),(531,68,'Anvilmar'),(532,68,'Arathor'),(533,68,'Archimonde'),(534,68,'Area 52'),(535,68,'Argent Dawn'),(536,68,'Arthas'),(537,68,'Arygos'),(538,68,'Auchindoun'),(539,68,'Azgalor'),(540,68,'Azjol-Nerub'),(541,68,'Azralon'),(542,68,'Azshara'),(543,68,'Azuremyst'),(544,68,'Baelgun'),(545,68,'Balnazzar'),(546,68,'Barthilas'),(547,68,'Black Dragonflight'),(548,68,'Blackhand'),(549,68,'Blackrock'),(550,68,'Blackwater Raiders'),(551,68,'Blackwing Lair'),(552,68,'Blade\'s Edge'),(553,68,'Bladefist'),(554,68,'Bleeding Hollow'),(555,68,'Blood Furnace'),(556,68,'Bloodhoof'),(557,68,'Bloodscalp'),(558,68,'Bonechewer'),(559,68,'Borean Tundra'),(560,68,'Boulderfist'),(561,68,'Bronzebeard'),(562,68,'Burning Blade'),(563,68,'Burning Legion'),(564,68,'Caelestrasz'),(565,68,'Cairne'),(566,68,'Cenarion Circle'),(567,68,'Cenarius'),(568,68,'Cho\'gall'),(569,68,'Chromaggus'),(570,68,'Coilfang'),(571,68,'Crushridge'),(572,68,'Daggerspine'),(573,68,'Dalaran'),(574,68,'Dalvengyr'),(575,68,'Dark Iron'),(576,68,'Darkspear'),(577,68,'Darrowmere'),(578,68,'Dath\'Remar'),(579,68,'Dawnbringer'),(580,68,'Deathwing'),(581,68,'Demon Soul'),(582,68,'Dentarg'),(583,68,'Destromath'),(584,68,'Dethecus'),(585,68,'Detheroc'),(586,68,'Doomhammer'),(587,68,'Draenor'),(588,68,'Dragonblight'),(589,68,'Dragonmaw'),(590,68,'Drak\'Tharon'),(591,68,'Drak\'thul'),(592,68,'Draka'),(593,68,'Drakkari'),(594,68,'Dreadmaul'),(595,68,'Drenden'),(596,68,'Dunemaul'),(597,68,'Durotan'),(598,68,'Duskwood'),(599,68,'Earthen Ring'),(600,68,'Echo Isles'),(601,68,'Eitrigg'),(602,68,'Eldre\'Thalas'),(603,68,'Elune'),(604,68,'Emerald Dream'),(605,68,'Eonar'),(606,68,'Eredar'),(607,68,'Executus'),(608,68,'Exodar'),(609,68,'Farstriders'),(610,68,'Feathermoon'),(611,68,'Fenris'),(612,68,'Firetree'),(613,68,'Fizzcrank'),(614,68,'Frostmane'),(615,68,'Frostmourne'),(616,68,'Frostwolf'),(617,68,'Galakrond'),(618,68,'Gallywix'),(619,68,'Garithos'),(620,68,'Garona'),(621,68,'Garrosh'),(622,68,'Ghostlands'),(623,68,'Gilneas'),(624,68,'Gnomeregan'),(625,68,'Goldrinn'),(626,68,'Gorefiend'),(627,68,'Gorgonnash'),(628,68,'Greymane'),(629,68,'Grizzly Hills'),(630,68,'Gul\'dan'),(631,68,'Gundrak'),(632,68,'Gurubashi'),(633,68,'Hakkar'),(634,68,'Haomarush'),(635,68,'Hellscream'),(636,68,'Hydraxis'),(637,68,'Hyjal'),(638,68,'Icecrown'),(639,68,'Illidan'),(640,68,'Jaedenar'),(641,68,'Jubei\'Thos'),(642,68,'Kael\'thas'),(643,68,'Kalecgos'),(644,68,'Kargath'),(645,68,'Kel\'Thuzad'),(646,68,'Khadgar'),(647,68,'Khaz Modan'),(648,68,'Khaz\'goroth'),(649,68,'Kil\'jaeden'),(650,68,'Kilrogg'),(651,68,'Kirin Tor'),(652,68,'Korgath'),(653,68,'Korialstrasz'),(654,68,'Kul Tiras'),(655,68,'Laughing Skull'),(656,68,'Lethon'),(657,68,'Lightbringer'),(658,68,'Lightning\'s Blade'),(659,68,'Lightninghoof'),(660,68,'Llane'),(661,68,'Lothar'),(662,68,'Madoran'),(663,68,'Maelstrom'),(664,68,'Magtheridon'),(665,68,'Maiev'),(666,68,'Mal\'Ganis'),(667,68,'Malfurion'),(668,68,'Malorne'),(669,68,'Malygos'),(670,68,'Mannoroth'),(671,68,'Medivh'),(672,68,'Misha'),(673,68,'Mok\'Nathal'),(674,68,'Moon Guard'),(675,68,'Moonrunner'),(676,68,'Mug\'thol'),(677,68,'Muradin'),(678,68,'Nagrand'),(679,68,'Nathrezim'),(680,68,'Nazgrel'),(681,68,'Nazjatar'),(682,68,'Nemesis'),(683,68,'Ner\'zhul'),(684,68,'Nesingwary'),(685,68,'Nordrassil'),(686,68,'Norgannon'),(687,68,'Onyxia'),(688,68,'Perenolde'),(689,68,'Proudmoore'),(690,68,'Quel\'dorei'),(691,68,'Quel\'Thalas'),(692,68,'Ragnaros'),(693,68,'Ravencrest'),(694,68,'Ravenholdt'),(695,68,'Rexxar'),(696,68,'Rivendare'),(697,68,'Runetotem'),(698,68,'Sargeras'),(699,68,'Saurfang'),(700,68,'Scarlet Crusade'),(701,68,'Scilla'),(702,68,'Sen\'jin'),(703,68,'Sentinels'),(704,68,'Shadow Council'),(705,68,'Shadowmoon'),(706,68,'Shadowsong'),(707,68,'Shandris'),(708,68,'Shattered Halls'),(709,68,'Shattered Hand'),(710,68,'Shu\'halo'),(711,68,'Silver Hand'),(712,68,'Silvermoon'),(713,68,'Sisters of Elune'),(714,68,'Skullcrusher'),(715,68,'Skywall'),(716,68,'Smolderthorn'),(717,68,'Spinebreaker'),(718,68,'Spirestone'),(719,68,'Staghelm'),(720,68,'Steamwheedle Cartel'),(721,68,'Stonemaul'),(722,68,'Stormrage'),(723,68,'Stormreaver'),(724,68,'Stormscale'),(725,68,'Suramar'),(726,68,'Tanaris'),(727,68,'Terenas'),(728,68,'Terokkar'),(729,68,'Thaurissan'),(730,68,'The Forgotten Coast'),(731,68,'The Scryers'),(732,68,'The Underbog'),(733,68,'The Venture Co'),(734,68,'Thorium Brotherhood'),(735,68,'Thrall'),(736,68,'Thunderhorn'),(737,68,'Thunderlord'),(738,68,'Tichondrius'),(739,68,'Tol Barad'),(740,68,'Tortheldrin'),(741,68,'Trollbane'),(742,68,'Turalyon'),(743,68,'Twisting Nether'),(744,68,'Uldaman'),(745,68,'Uldum'),(746,68,'Undermine'),(747,68,'Ursin'),(748,68,'Uther'),(749,68,'Vashj'),(750,68,'Vek\'nilash'),(751,68,'Velen'),(752,68,'Warsong'),(753,68,'Whisperwind'),(754,68,'Wildhammer'),(755,68,'Windrunner'),(756,68,'Winterhoof'),(757,68,'Wyrmrest Accord'),(758,68,'Ysera'),(759,68,'Ysondre'),(760,68,'Zangarmarsh'),(761,68,'Zul\'jin'),(762,68,'Zuluhed'),(763,75,'Israphel-A'),(764,75,'Israphel-E'),(765,75,'Siel-A'),(766,75,'Siel-E'),(767,75,'Kahrun-A'),(768,75,'Kahrun-E'),(769,75,'Tiamat-A'),(770,75,'Tiamat-E');

/*Table structure for table `tny_fs_node_label` */

DROP TABLE IF EXISTS `tny_fs_node_label`;

CREATE TABLE `tny_fs_node_label` (
  `lk` int(10) unsigned NOT NULL,
  `lv` varchar(20) NOT NULL,
  `sys` enum('sys','usr') NOT NULL DEFAULT 'usr',
  PRIMARY KEY (`lk`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `tny_fs_node_label` */

insert  into `tny_fs_node_label`(`lk`,`lv`,`sys`) values (0,'label a','sys'),(1,'lable b','sys'),(2,'tiananwei','sys'),(3,'wow0','sys');

/*Table structure for table `tny_fs_node_struct` */

DROP TABLE IF EXISTS `tny_fs_node_struct`;

CREATE TABLE `tny_fs_node_struct` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'sid',
  `path` varchar(250) NOT NULL COMMENT 'path',
  `nt` enum('file','folder') NOT NULL DEFAULT 'folder' COMMENT 'node type',
  `order` int(10) DEFAULT '0',
  `type` int(11) DEFAULT '0',
  `label` int(10) unsigned DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`sid`),
  UNIQUE KEY `path` (`path`)
) ENGINE=MyISAM AUTO_INCREMENT=222 DEFAULT CHARSET=utf8;

/*Data for the table `tny_fs_node_struct` */

insert  into `tny_fs_node_struct`(`sid`,`path`,`nt`,`order`,`type`,`label`,`date`) values (48,'/world of warcraft/WOW(US)','folder',2,0,0,'2014-11-09 14:41:12'),(12,'/','folder',0,0,0,'2014-11-07 13:47:21'),(83,'/world of warcraft/WOW(US)/WOW leveling','file',100,1,1,'2015-04-05 14:31:44'),(47,'/world of warcraft','folder',163,0,1,'2014-11-09 14:41:03'),(86,'/world of warcraft/WOW(EU)/WOW Gold','file',100,2,0,'2015-05-02 12:36:58'),(87,'/world of warcraft/WOW(EU)/WOW Leveling','file',100,1,0,'2015-05-02 12:51:06'),(84,'/world of warcraft/WOW(US)/WOW Gold','file',100,2,0,'2015-04-05 14:32:10'),(93,'/Archlord2','folder',61,0,0,'2015-05-02 16:26:02'),(85,'/world of warcraft/WOW CDK','file',100,4,0,'2015-04-12 07:43:26'),(92,'/Aura Kingdom','folder',70,0,0,'2015-05-02 16:25:26'),(91,'/ArcheAge','folder',60,0,0,'2015-05-02 16:24:43'),(73,'/Aion','folder',50,0,1,'2015-01-11 16:38:43'),(68,'/world of warcraft/WOW(EU)','folder',3,0,0,'2014-11-23 09:58:20'),(94,'/Age of Wushu','folder',20,0,0,'2015-05-02 16:26:43'),(95,'/Age of Wulin','folder',20,0,0,'2015-05-02 16:26:57'),(90,'/Aion/AION Kinah(EU)','file',100,2,0,'2015-05-02 15:39:34'),(89,'/Aion/AION Kinah(US)','file',100,2,0,'2015-05-02 15:38:59'),(88,'/Aion/AION Leveling','file',100,1,0,'2015-05-02 15:38:05'),(96,'/Blade Soul(剑灵)','folder',80,0,0,'2015-05-02 16:28:53'),(97,'/Dofus','folder',91,0,0,'2015-05-02 16:32:07'),(98,'/Dragon Nest','folder',92,0,0,'2015-05-02 16:33:13'),(99,'/Dungeon Fighter Online','folder',93,0,0,'2015-05-02 16:33:40'),(100,'/Diablo III','folder',90,0,0,'2015-05-02 16:34:11'),(101,'/Destiny(PS4)','folder',0,0,0,'2015-05-02 16:36:44'),(102,'/Eden Eternal','folder',100,0,0,'2015-05-02 16:40:21'),(103,'/Eve','folder',101,0,0,'2015-05-02 16:42:46'),(104,'/Everquest2','folder',102,0,0,'2015-05-02 16:44:28'),(105,'/Final Fantasy XIV','folder',113,0,0,'2015-05-02 16:46:38'),(106,'/FIFA 15','folder',111,0,0,'2015-05-02 16:48:29'),(107,'/FIFA 14','folder',110,0,0,'2015-05-02 16:53:50'),(108,'/Lineage2','folder',121,0,0,'2015-05-02 17:27:31'),(109,'/League of Legends','folder',120,0,0,'2015-05-02 17:27:54'),(110,'/Lord of the rings online','folder',122,0,0,'2015-05-02 17:29:39'),(111,'/Maple story','folder',130,0,0,'2015-05-02 17:44:18'),(112,'/NeverWinter Online','folder',135,0,0,'2015-05-02 17:45:11'),(113,'/Final Fantasy XIV(PS4)','folder',0,0,0,'2015-05-02 17:46:49'),(114,'/Rift online','folder',140,0,0,'2015-05-02 17:47:33'),(115,'/GuildWar 2','folder',115,0,0,'2015-05-02 17:48:03'),(116,'/Runescape','folder',142,0,0,'2015-05-02 17:49:41'),(117,'/Star trek online','folder',145,0,0,'2015-05-02 17:50:48'),(118,'/Star Wars The Old Republic','folder',147,0,0,'2015-05-02 17:51:31'),(119,'/Swordsman online','folder',149,0,0,'2015-05-02 17:51:53'),(120,'/The Elder Scrolls Online','folder',155,0,0,'2015-05-02 17:53:39'),(121,'/TERA','folder',157,0,0,'2015-05-02 17:55:33'),(122,'/The Secret World','folder',159,0,0,'2015-05-02 17:56:10'),(123,'/Vindictus','folder',160,0,0,'2015-05-02 17:57:13'),(124,'/WildStar','folder',162,0,0,'2015-05-02 17:57:55'),(125,'/World of tanks','folder',165,0,0,'2015-05-02 18:00:22'),(126,'/World of warplanes','folder',170,0,0,'2015-05-02 18:01:22'),(127,'/Age of Wulin/Age of Wulin Gold','file',100,2,0,'2015-05-03 13:17:25'),(128,'/Age of Wushu/Age of Wushu','file',100,2,0,'2015-05-03 14:46:48'),(129,'/ArcheAge/ArcheAge Gold','file',100,2,0,'2015-05-03 14:51:18'),(130,'/ArcheAge/ArcheAge leveling ','file',100,1,0,'2015-05-03 14:51:50'),(131,'/ArcheAge/ArcheAge CDK','file',100,0,0,'2015-05-03 14:54:06'),(132,'/world of warcraft/WOW professions','file',100,1,0,'2015-05-04 09:51:17'),(133,'/world of warcraft/WOW Valor Points','file',100,4,0,'2015-05-04 09:52:33'),(134,'/world of warcraft/WOW Reputation','file',100,4,0,'2015-05-04 09:54:48'),(135,'/world of warcraft/WOW Battlefield','file',100,4,0,'2015-05-04 09:56:06'),(136,'/world of warcraft/Warlords of Draenor','file',100,4,0,'2015-05-04 09:58:24'),(137,'/world of warcraft/WOW Gold Challenge Mode','file',100,4,0,'2015-05-04 10:00:28'),(138,'/world of warcraft/WOW Raid Item','file',100,4,0,'2015-05-04 10:01:22'),(139,'/world of warcraft/WOW Achievement List','file',100,4,0,'2015-05-04 10:03:03'),(140,'/world of warcraft/WOW Arena Rating','file',100,4,0,'2015-05-04 10:04:05'),(141,'/Aion/Aion Craftskill','file',100,4,0,'2015-05-04 10:05:51'),(142,'/Star Wars The Old Republic/SWTOR Credits','file',100,2,0,'2015-05-04 10:13:22'),(143,'/Star Wars The Old Republic/SWTOR leveling','file',100,1,0,'2015-05-04 10:14:51'),(144,'/Star Wars The Old Republic/Valor Rank','file',100,1,0,'2015-05-04 10:16:02'),(145,'/Star Wars The Old Republic/SWTOR Commendations','file',100,4,0,'2015-05-04 10:17:27'),(146,'/Star Wars The Old Republic/SWTOR CDK','file',100,0,0,'2015-05-04 10:21:02'),(147,'/Diablo III/Diablo3 Paragon leveling','file',100,1,0,'2015-05-04 10:26:55'),(148,'/Diablo III/Diablo3 Season leveling','file',100,1,0,'2015-05-04 10:27:28'),(149,'/Diablo III/Diablo3 Hardcore leveling','file',100,1,0,'2015-05-04 10:28:35'),(150,'/Diablo III/Diablo III CDK','file',100,0,0,'2015-05-04 10:29:13'),(152,'/Diablo III/Diablo3 Gems leveling','file',100,4,0,'2015-05-04 10:31:48'),(153,'/Diablo III/Diablo III Legendary','file',100,4,0,'2015-05-04 10:33:47'),(154,'/Final Fantasy XIV/FFXIV Gil(NA)','file',100,2,0,'2015-05-04 10:36:02'),(155,'/Final Fantasy XIV/FFXIV Gil(EU)','file',100,2,0,'2015-05-04 10:36:24'),(156,'/Final Fantasy XIV/FFXIV Gil(JP)','file',100,2,0,'2015-05-04 10:36:47'),(157,'/Final Fantasy XIV/FFXIV leveling','file',100,1,0,'2015-05-04 10:37:09'),(158,'/Final Fantasy XIV/FFXIV Disciples of the hand','file',100,4,0,'2015-05-04 10:38:10'),(159,'/Final Fantasy XIV/FFXIV Disciples of the Land','file',100,4,0,'2015-05-04 10:38:34'),(160,'/Final Fantasy XIV/FFXIV Grand Company','file',100,4,0,'2015-05-04 10:39:37'),(161,'/Final Fantasy XIV/FFXIV CDK','file',100,0,0,'2015-05-04 10:39:57'),(162,'/Final Fantasy XIV(PS4)/FFXIV(PS4) leveling','file',100,1,0,'2015-05-04 10:41:22'),(163,'/Destiny(PS4)/Destiny(PS4) leveling','file',100,1,0,'2015-05-04 10:41:52'),(164,'/ArcheAge/ArcheAge Tokens','file',100,4,0,'2015-05-04 10:43:27'),(165,'/Archlord2/Archlord2 Gold','file',100,2,0,'2015-05-04 10:44:10'),(166,'/Aura Kingdom/Aura Kingdom Gold','file',100,2,0,'2015-05-04 10:44:36'),(167,'/Blade Soul(剑灵)/Blade Soul leveling','file',100,1,0,'2015-05-04 10:45:23'),(168,'/Blade Soul(剑灵)/Blade Soul PVP','file',100,4,0,'2015-05-04 10:45:51'),(169,'/Blade Soul(剑灵)/Blade Soul Gold','file',100,2,0,'2015-05-04 10:46:07'),(170,'/Dofus/Dofus Gold','file',100,2,0,'2015-05-04 10:46:34'),(171,'/Dragon Nest/Dragon Nest Gold','file',100,2,0,'2015-05-04 10:46:57'),(172,'/Dragon Nest/Dragon Nest leveling','file',100,1,0,'2015-05-04 10:47:13'),(173,'/Dungeon Fighter Online/DFO Gold','file',100,2,0,'2015-05-04 10:47:37'),(174,'/Dungeon Fighter Online/DFO leveling','file',100,0,0,'2015-05-04 10:47:52'),(175,'/Eden Eternal/Eden Eternal leveling','file',100,1,0,'2015-05-04 10:48:24'),(176,'/Eden Eternal/Eden Eternal Gold','file',100,2,0,'2015-05-04 10:48:42'),(177,'/Eve/EVE ISK','file',100,2,1,'2015-05-04 10:49:15'),(178,'/FIFA 14/FIFA 14 Coins','file',100,2,0,'2015-05-04 10:51:30'),(179,'/FIFA 15/FIFA 15 Coins','file',100,2,0,'2015-05-04 10:51:49'),(180,'/Everquest2/EQ2 leveling','file',100,1,0,'2015-05-04 10:52:28'),(181,'/Everquest2/EQ2 platinum','file',100,2,0,'2015-05-04 10:53:54'),(182,'/Everquest2/EQ2 AA Points','file',100,1,0,'2015-05-04 10:54:45'),(183,'/GuildWar 2/GuildWar 2 leveling','file',100,1,0,'2015-05-04 10:55:37'),(184,'/GuildWar 2/GuildWar 2 Gold','file',100,0,0,'2015-05-04 10:56:22'),(185,'/GuildWar 2/GuildWar 2 Crafting','file',100,4,0,'2015-05-04 10:57:17'),(186,'/GuildWar 2/GuildWar2 CDK','file',100,4,0,'2015-05-04 10:58:11'),(187,'/League of Legends/League of Legends leveling','file',100,1,0,'2015-05-04 11:00:03'),(188,'/League of Legends/League of Legends Rank leveling','file',100,4,0,'2015-05-04 11:00:43'),(189,'/League of Legends/LOL roit points','file',100,0,0,'2015-05-04 11:01:53'),(190,'/Lineage2/Lineage2 leveling','file',100,1,0,'2015-05-04 11:04:07'),(191,'/Lineage2/Lineage2 Adena','file',100,2,0,'2015-05-04 11:05:59'),(192,'/Lord of the rings online/Lotro leveling','file',100,1,0,'2015-05-04 11:08:24'),(193,'/Lord of the rings online/Lotro Gold','file',2,2,0,'2015-05-04 11:08:51'),(194,'/Maple story/Maple story leveling','file',100,1,0,'2015-05-04 11:09:18'),(195,'/Maple story/Maple story Gold','file',100,2,0,'2015-05-04 11:10:05'),(196,'/NeverWinter Online/Astral Diamond','file',100,2,0,'2015-05-04 11:12:56'),(197,'/NeverWinter Online/NeverWinter Online Gold','file',100,2,0,'2015-05-04 11:13:34'),(198,'/Rift online/Rift leveling','file',100,1,0,'2015-05-04 11:14:29'),(199,'/Rift online/Rift platinum','file',100,2,0,'2015-05-04 11:14:51'),(200,'/Runescape/Runescape3 Gold','file',100,2,0,'2015-05-04 11:17:30'),(201,'/Runescape/RS 2007 Gold','file',100,2,0,'2015-05-04 11:20:00'),(202,'/Star trek online/STO Gold','file',100,0,0,'2015-05-04 11:21:08'),(203,'/Swordsman online/Swordsman online leveling','file',100,1,0,'2015-05-04 11:22:15'),(204,'/Swordsman online/Swordsman online Gold','file',100,2,0,'2015-05-04 11:22:32'),(205,'/The Elder Scrolls Online/ESO leveling','file',100,1,0,'2015-05-04 20:15:03'),(206,'/The Elder Scrolls Online/ESO Gold','file',100,2,0,'2015-05-04 20:15:28'),(207,'/The Elder Scrolls Online/ESO Veteran Rank leveling','file',100,0,0,'2015-05-04 20:17:09'),(208,'/The Elder Scrolls Online/ESO Skill','file',100,4,0,'2015-05-04 20:18:07'),(209,'/The Elder Scrolls Online/ESO Discovery of Skyshards','file',100,4,0,'2015-05-04 20:18:59'),(210,'/The Elder Scrolls Online/The Elder Scrolls Online CDK','file',100,4,0,'2015-05-04 20:19:28'),(211,'/TERA/TERA Gold','file',100,2,0,'2015-05-04 20:38:07'),(212,'/TERA/TERA leveling','file',100,1,0,'2015-05-04 20:39:07'),(213,'/The Secret World/The Secret World leveling','file',100,1,0,'2015-05-04 20:43:13'),(214,'/The Secret World/The Secret World Gold','file',100,2,0,'2015-05-04 20:47:40'),(215,'/Vindictus/Vindictus Gold','file',100,2,0,'2015-05-04 20:48:34'),(216,'/Vindictus/Vindictus leveling','file',100,1,0,'2015-05-04 20:48:46'),(217,'/WildStar/WildStar leveling','file',100,1,0,'2015-05-04 20:49:26'),(218,'/WildStar/WildStar Gold','file',100,2,0,'2015-05-04 20:49:37'),(219,'/WildStar/WildStar CDK','file',100,4,0,'2015-05-04 20:49:50'),(220,'/World of tanks/World of tanks leveling','file',100,4,0,'2015-05-04 20:50:43'),(221,'/World of warplanes/World of warplanes leveling','file',100,4,0,'2015-05-04 20:51:11');

/*Table structure for table `tny_fs_node_type` */

DROP TABLE IF EXISTS `tny_fs_node_type`;

CREATE TABLE `tny_fs_node_type` (
  `tk` int(10) unsigned NOT NULL,
  `tv` varchar(20) NOT NULL,
  `sys` enum('sys','usr') NOT NULL DEFAULT 'usr',
  PRIMARY KEY (`tk`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `tny_fs_node_type` */

insert  into `tny_fs_node_type`(`tk`,`tv`,`sys`) values (0,'pl','sys'),(1,'gold','sys'),(2,'other','sys'),(3,'gn','sys');

/*Table structure for table `tny_fs_ns_struct` */

DROP TABLE IF EXISTS `tny_fs_ns_struct`;

CREATE TABLE `tny_fs_ns_struct` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dksid` int(10) unsigned NOT NULL,
  `path` varchar(250) NOT NULL,
  `da` varchar(15) DEFAULT NULL COMMENT 'delivery alias',
  `order` int(11) DEFAULT '0',
  `nt` enum('file','folder') DEFAULT 'folder' COMMENT 'data node type',
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`sid`),
  UNIQUE KEY `nsdsid` (`dksid`,`path`)
) ENGINE=MyISAM AUTO_INCREMENT=167 DEFAULT CHARSET=utf8;

/*Data for the table `tny_fs_ns_struct` */

insert  into `tny_fs_ns_struct`(`sid`,`dksid`,`path`,`da`,`order`,`nt`,`datetime`) values (18,16,'/nskey',NULL,2,'file','2014-11-07 13:51:59'),(17,16,'/',NULL,0,'folder','2014-11-07 13:51:59'),(19,15,'/',NULL,0,'folder','2014-11-07 13:51:59'),(20,15,'/jk',NULL,0,'file','2014-11-07 13:51:59'),(47,105,'/',NULL,0,'folder','2015-01-19 14:23:03'),(22,88,'/',NULL,0,'file','2014-11-07 13:51:59'),(60,112,'/',NULL,0,'file','2015-04-12 07:34:31'),(59,111,'/',NULL,0,'file','2015-04-05 14:07:12'),(29,98,'/',NULL,0,'folder','2014-11-23 11:12:56'),(28,97,'/',NULL,0,'folder','2014-11-23 11:10:49'),(37,98,'/ewwe/ac',NULL,88,'folder','2014-11-23 15:41:22'),(36,98,'/ewwe',NULL,88,'folder','2014-11-23 15:39:58'),(38,98,'/ddd',NULL,88,'file','2014-11-23 15:41:35'),(39,99,'/',NULL,0,'file','2015-01-01 14:42:55'),(40,100,'/',NULL,0,'folder','2015-01-01 14:45:16'),(41,100,'/ggkey','88',0,'file','2015-01-01 14:46:56'),(42,101,'/',NULL,0,'file','2015-01-02 21:33:00'),(43,102,'/',NULL,0,'file','2015-01-02 21:38:18'),(44,103,'/',NULL,0,'file','2015-01-04 10:22:37'),(45,104,'/',NULL,0,'file','2015-01-05 10:32:39'),(46,0,'/',NULL,0,'file','2015-01-19 13:05:45'),(48,105,'/a','',88,'file','2015-01-19 14:23:16'),(49,105,'/b','',88,'file','2015-01-19 14:23:21'),(50,106,'/',NULL,0,'file','2015-01-23 14:36:09'),(51,16,'/j','',88,'file','2015-01-27 15:15:39'),(52,16,'/fd','',88,'folder','2015-01-27 15:17:25'),(53,16,'/fd/a','',88,'file','2015-01-27 15:17:33'),(54,16,'/fd/b','',88,'file','2015-01-27 15:17:39'),(55,107,'/',NULL,0,'file','2015-02-12 14:00:59'),(56,108,'/',NULL,0,'file','2015-02-21 09:40:20'),(57,109,'/',NULL,0,'file','2015-02-21 09:47:56'),(58,110,'/',NULL,0,'file','2015-02-21 10:08:01'),(61,113,'/',NULL,0,'file','2015-04-12 08:06:41'),(62,114,'/',NULL,0,'file','2015-04-12 08:16:58'),(63,115,'/',NULL,0,'file','2015-04-12 08:30:10'),(64,116,'/',NULL,0,'folder','2015-04-12 08:45:52'),(66,116,'/ussvr','servername',88,'folder','2015-04-12 08:48:51'),(67,117,'/',NULL,0,'file','2015-05-02 10:39:43'),(68,118,'/',NULL,0,'file','2015-05-02 10:43:38'),(69,119,'/',NULL,0,'file','2015-05-02 10:45:11'),(70,120,'/',NULL,0,'file','2015-05-02 11:47:28'),(71,121,'/',NULL,0,'file','2015-05-02 12:27:36'),(72,122,'/',NULL,0,'file','2015-05-02 15:29:32'),(73,123,'/',NULL,0,'file','2015-05-02 15:41:48'),(74,124,'/',NULL,0,'file','2015-05-02 15:55:02'),(75,125,'/',NULL,0,'file','2015-05-02 16:08:10'),(76,126,'/',NULL,0,'folder','2015-05-02 17:00:15'),(77,126,'/Israphel-A','servername',1,'file','2015-05-02 17:01:10'),(78,126,'/Israphel-E','servername',2,'file','2015-05-02 17:03:41'),(79,126,'/Siel-A','servername',3,'file','2015-05-02 17:05:05'),(80,126,'/Siel-E','servername',4,'file','2015-05-02 17:05:40'),(81,126,'/Tiamat-A','servername',5,'file','2015-05-02 17:05:57'),(82,126,'/Tiamat-E','servername',6,'file','2015-05-02 17:06:16'),(83,126,'/Kahrun-Asmodians','servername',7,'file','2015-05-02 17:06:36'),(84,126,'/Kahrun-Elyos','servername',8,'file','2015-05-02 17:06:53'),(85,127,'/',NULL,0,'file','2015-05-02 17:11:42'),(86,128,'/',NULL,0,'folder','2015-05-02 18:03:34'),(87,128,'/Alquima-A','servername',1,'file','2015-05-02 18:05:34'),(88,128,'/Alquima-E','servername',2,'file','2015-05-02 18:07:46'),(89,128,'/Aunhart-Asmodians','servername',3,'file','2015-05-02 18:08:11'),(90,128,'/Aunhart-Elyos','servername',4,'file','2015-05-02 18:08:29'),(91,128,'/Balder-A','servername',5,'file','2015-05-02 18:08:52'),(92,128,'/Balder-E','servername',6,'file','2015-05-02 18:09:12'),(93,128,'/Barus-A','servername',7,'file','2015-05-02 18:09:50'),(94,128,'/Barus-E','servername',8,'file','2015-05-02 18:10:10'),(95,128,'/Calindi-Asmodians','servername',9,'file','2015-05-02 18:10:33'),(96,128,'/Calindi-Elyos','servername',10,'file','2015-05-02 18:10:59'),(97,128,'/Curatus-A','servername',11,'file','2015-05-02 18:11:38'),(98,128,'/Curatus-E','servername',12,'file','2015-05-02 18:12:40'),(99,128,'/Kromede-A','servername',13,'file','2015-05-02 18:12:59'),(100,128,'/Kromede-E','servername',14,'file','2015-05-02 18:13:21'),(101,128,'/Perento-A','servername',15,'file','2015-05-02 18:13:39'),(102,128,'/Perento-E','servername',16,'file','2015-05-02 18:13:55'),(103,128,'/Spatalos-A','servername',17,'file','2015-05-02 18:16:02'),(104,128,'/Spatalos-E','servername',17,'file','2015-05-02 18:18:40'),(105,128,'/Suthran-A','servername',18,'file','2015-05-02 18:21:11'),(106,128,'/Suthran-E','servername',19,'file','2015-05-02 18:22:24'),(107,128,'/Telemachus-A','servername',20,'file','2015-05-02 18:22:49'),(108,128,'/Telemachus-E','servername',20,'file','2015-05-02 18:23:07'),(109,128,'/Thor-A','charactername',21,'file','2015-05-02 18:23:41'),(110,128,'/Thor-E','servername',22,'file','2015-05-02 18:24:21'),(111,128,'/Urtem-A','servername',23,'file','2015-05-02 18:24:50'),(112,128,'/Urtem-E','servername',23,'file','2015-05-02 18:26:29'),(113,128,'/Vehalla-Asmodians','servername',24,'file','2015-05-02 18:27:00'),(114,128,'/Vehalla-Elyos','servername',25,'file','2015-05-02 18:27:16'),(115,128,'/Nexus-Asmodians','servername',26,'file','2015-05-02 18:27:39'),(116,128,'/Nexus-Elyos','servername',26,'file','2015-05-02 18:28:10'),(117,128,'/Zubaba-Asmodians','servername',27,'file','2015-05-02 18:28:36'),(118,128,'/Zubaba-Elyos','servername',28,'file','2015-05-02 18:28:56'),(119,129,'/',NULL,0,'folder','2015-05-03 13:24:13'),(120,129,'/EU-Golden Dynasty','servername',1,'file','2015-05-03 13:24:47'),(128,135,'/',NULL,0,'file','2015-05-03 16:07:05'),(127,134,'/',NULL,0,'file','2015-05-03 16:03:55'),(126,133,'/',NULL,0,'file','2015-05-03 15:57:48'),(124,131,'/',NULL,0,'file','2015-05-03 15:23:41'),(125,132,'/',NULL,0,'file','2015-05-03 15:43:28'),(129,136,'/',NULL,0,'folder','2015-05-07 22:47:32'),(130,136,'/NA-Aranzeb','servername',1,'file','2015-05-07 22:50:47'),(131,136,'/NA-Calleil','servername',2,'file','2015-05-07 22:51:03'),(132,136,'/NA-Enla','servername',3,'file','2015-05-07 22:51:16'),(133,136,'/NA-Ezi','servername',4,'file','2015-05-07 22:51:31'),(134,136,'/NA-Inoch','servername',5,'file','2015-05-07 22:51:47'),(135,136,'/NA-Kyrios','servername',6,'file','2015-05-07 22:52:03'),(151,136,'/NA-Lucius','servername',7,'file','2015-05-31 13:00:06'),(137,136,'/NA-Naima','servername',8,'file','2015-05-07 22:52:41'),(138,136,'/NA-Ollo','servername',9,'file','2015-05-07 22:52:56'),(139,136,'/NA-Salphira','servername',10,'file','2015-05-07 22:53:10'),(140,136,'/NA-Tahyang','servername',11,'file','2015-05-07 22:53:52'),(141,136,'/EU-Aier','servername',12,'file','2015-05-07 22:54:12'),(142,136,'/EU-Dahuta','servername',13,'file','2015-05-07 22:54:27'),(143,136,'/EU-Eanna','servername',14,'file','2015-05-07 22:54:43'),(144,136,'/EU-Janudar','servername',15,'file','2015-05-07 22:55:16'),(145,136,'/EU-Kyprosa','servername',16,'file','2015-05-07 22:55:34'),(146,136,'/EU-Melisara','servername',17,'file','2015-05-07 22:55:51'),(147,136,'/EU-Nebe','servername',18,'file','2015-05-07 22:56:06'),(148,136,'/EU-Nui','servername',19,'file','2015-05-07 22:56:21'),(149,136,'/EU-Orchidna','servername',20,'file','2015-05-07 22:56:36'),(152,136,'/EU-Shatigon','servername',21,'file','2015-05-31 13:00:48'),(153,137,'/',NULL,0,'file','2015-05-31 14:26:51'),(154,138,'/',NULL,0,'folder','2015-05-31 15:00:48'),(155,138,'/NA-Willowfire-Azuni','servername',1,'file','2015-05-31 15:01:49'),(156,138,'/NA-Willowfire-Crunn','servername',2,'file','2015-05-31 15:02:04'),(157,138,'/EU-Deimotik-Azuni','servername',3,'file','2015-05-31 15:02:21'),(158,138,'/EU-Deimotik-Crunn','servername',4,'file','2015-05-31 15:02:35'),(159,139,'/',NULL,0,'folder','2015-05-31 15:21:31'),(160,139,'/US-Chimera','servername',1,'file','2015-05-31 15:21:43'),(161,139,'/US-Hydra','servername',2,'file','2015-05-31 15:21:56'),(162,139,'/US-Siren','servername',3,'file','2015-05-31 15:22:11'),(163,139,'/DE-Aurora','servername',4,'file','2015-05-31 15:22:27'),(164,139,'/FR-Gaia','servername',5,'file','2015-05-31 15:22:59'),(165,139,'/PT-Genesis','servername',6,'file','2015-05-31 15:23:15'),(166,139,'/ES-Gaia','servername',5,'file','2015-05-31 15:41:21');

/*Table structure for table `tny_fs_widget_struct` */

DROP TABLE IF EXISTS `tny_fs_widget_struct`;

CREATE TABLE `tny_fs_widget_struct` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '组件实例ID',
  `nsid` int(10) unsigned NOT NULL COMMENT 'npsid & order决定这个组件属于哪个页面',
  `order` int(10) unsigned NOT NULL,
  `typeid` varchar(16) NOT NULL COMMENT '组件ID(table_22ld)',
  `dksid` int(10) unsigned NOT NULL COMMENT 'tny_fs_datakey_struct表的SID',
  `confid` int(10) unsigned NOT NULL COMMENT 'tny_fs_wdgconf_spancalc_23ldp表之类的SID',
  `ordertpl` varchar(20) NOT NULL,
  `comment` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`sid`),
  UNIQUE KEY `npsid` (`nsid`,`order`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

/*Data for the table `tny_fs_widget_struct` */

insert  into `tny_fs_widget_struct`(`sid`,`nsid`,`order`,`typeid`,`dksid`,`confid`,`ordertpl`,`comment`) values (5,12,2,'table_23tpe',103,17,'gg',NULL),(28,86,17,'table_22ap',121,24,'goldfa',''),(27,84,36,'table_22ap',120,24,'goldfa',''),(26,84,24,'calc_22ap',120,23,'goldfa','卖钱计算器'),(23,83,40,'table_23tpe',113,21,'pl',''),(24,83,51,'table_23tpe',114,22,'pl',''),(25,83,71,'table_23tpe',115,21,'pl',''),(22,83,17,'spancalc_23ldp',112,20,'pl',''),(29,86,10,'calc_22ap',121,23,'goldfa',''),(30,87,25,'spancalc_23ldp',112,20,'plcode',''),(31,87,36,'table_23tpe',113,21,'pl',''),(32,87,55,'table_23tpe',114,21,'gold',''),(33,87,66,'table_23tpe',115,21,'pl',''),(34,85,16,'table_22tp',122,25,'cdk',''),(35,88,20,'spancalc_23ldp',123,26,'plcode',''),(36,88,43,'table_23tpe',124,27,'plcode',''),(37,89,15,'calc_22ap',126,28,'gold',''),(38,89,39,'table_22ap',126,29,'gold',''),(39,90,13,'table_22ap',128,30,'goldfa',''),(40,90,1,'calc_22ap',128,28,'gold',''),(41,127,16,'calc_22ap',129,32,'gold',''),(42,127,35,'table_22ap',129,31,'gold',''),(43,128,17,'calc_22ap',130,32,'gold',''),(44,128,41,'table_22ap',130,31,'gold',''),(50,130,1,'spancalc_23ldp',131,26,'pl',''),(47,129,22,'table_22ap',136,34,'gold',''),(48,129,33,'calc_22ap',136,35,'gold',''),(49,130,36,'table_23tpe',135,36,'pl',''),(51,164,13,'table_23tpe',137,37,'pl',''),(52,165,14,'calc_22ap',138,35,'gold',''),(53,165,30,'table_22ap',121,38,'gold',''),(54,166,17,'table_22ap',139,39,'gold',''),(55,166,1,'calc_22ap',139,40,'gold',''),(56,130,55,'table_23ldp',131,33,'cdk','');

/*Table structure for table `tny_keyword` */

DROP TABLE IF EXISTS `tny_keyword`;

CREATE TABLE `tny_keyword` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ori` varchar(32) NOT NULL,
  `als` varchar(16) NOT NULL,
  PRIMARY KEY (`sid`),
  UNIQUE KEY `ori` (`ori`,`als`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `tny_keyword` */

/*Table structure for table `tny_member` */

DROP TABLE IF EXISTS `tny_member`;

CREATE TABLE `tny_member` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `member_email` varchar(120) NOT NULL,
  `member_nknme` varchar(20) DEFAULT NULL,
  `member_pswod` varchar(32) NOT NULL,
  `member_fname` varchar(15) DEFAULT NULL,
  `member_lname` varchar(20) DEFAULT NULL,
  `member_squst` varchar(150) NOT NULL,
  `member_sqkey` varchar(20) NOT NULL,
  `member_ranks` varchar(8) NOT NULL DEFAULT 'member',
  `member_vipid` varchar(8) DEFAULT NULL,
  `member_cnsum` float NOT NULL DEFAULT '0',
  `member_phone` varchar(20) DEFAULT NULL,
  `member_mssnn` varchar(50) DEFAULT NULL,
  `member_aimmm` varchar(25) DEFAULT NULL,
  `member_yahoo` varchar(25) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `member_email` (`member_email`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `tny_member` */

insert  into `tny_member`(`id`,`member_email`,`member_nknme`,`member_pswod`,`member_fname`,`member_lname`,`member_squst`,`member_sqkey`,`member_ranks`,`member_vipid`,`member_cnsum`,`member_phone`,`member_mssnn`,`member_aimmm`,`member_yahoo`,`time`) values (1,'a@b.c',NULL,'5396017a1afce83cd9145bcde1f04d75',NULL,NULL,'','','member',NULL,0,NULL,NULL,NULL,NULL,'2015-01-20 11:28:33'),(2,'ab@cd.ef','111','1111','1111','111','111','111','member',NULL,0,'111','111','111','','2015-01-23 09:25:24'),(3,'ab@cd.efg','111','1111','1111','111','111','111','member',NULL,0,'111','111','111','','2015-01-23 09:32:59'),(4,'ab@czd.efg','111','1111','1111','111','111','111','member',NULL,0,'111','111','111','','2015-01-23 09:45:22'),(5,'ab@czd.efgz','111','1111','1111','111','111','111','member',NULL,0,'111','111','111','','2015-01-23 09:45:57'),(6,'ab@czwd.efgz','111','1111','1111','111','111','111','member',NULL,0,'111','111','111','','2015-01-23 09:46:06'),(7,'acb@czwd.efgz','111','1111','1111','111','111','111','member',NULL,0,'111','111','111','','2015-01-23 09:48:02');

/*Table structure for table `tny_news` */

DROP TABLE IF EXISTS `tny_news`;

CREATE TABLE `tny_news` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `content` text,
  `lnk` varchar(256) DEFAULT NULL,
  `sldimg` varchar(32) DEFAULT NULL,
  `sldflg` tinyint(1) DEFAULT '0',
  `sldorder` int(11) DEFAULT '0',
  `date` date NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `tny_news` */

insert  into `tny_news`(`sid`,`title`,`content`,`lnk`,`sldimg`,`sldflg`,`sldorder`,`date`) values (1,'title11','content1','/ep/11','',1,1,'2015-01-26'),(2,'title','content','/ep/gh','jkl.jpg',1,2,'2015-01-26'),(3,'title','content','/ep/gh','qq.jpg',1,1,'2015-01-26'),(4,'awewe','csdfasdontent','/ep/gh','zz.jpg',1,4,'2015-01-26'),(5,'afw','csdfasdo nte asdfasdnt','/ep/gh','zz.jpg',1,4,'2015-01-26');

/*Table structure for table `tny_oplog` */

DROP TABLE IF EXISTS `tny_oplog`;

CREATE TABLE `tny_oplog` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `optype` varchar(16) NOT NULL,
  `ipaddr` varchar(15) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date` date NOT NULL,
  `opflag` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`sid`),
  KEY `optype` (`optype`,`ipaddr`,`date`,`opflag`)
) ENGINE=MyISAM AUTO_INCREMENT=86 DEFAULT CHARSET=utf8;

/*Data for the table `tny_oplog` */

insert  into `tny_oplog`(`sid`,`optype`,`ipaddr`,`datetime`,`date`,`opflag`) values (27,'member_auth','127.0.0.1','2015-01-21 13:24:01','2015-01-21',1),(26,'member_auth','127.0.0.1','2015-01-21 13:21:15','2015-01-21',1),(24,'member_auth','127.0.0.1','2015-01-21 13:15:02','2015-01-21',0),(25,'member_auth','127.0.0.1','2015-01-21 13:19:55','2015-01-21',1),(23,'member_auth','127.0.0.1','2015-01-21 13:13:18','2015-01-21',1),(22,'member_auth','127.0.0.1','2015-01-21 13:11:52','2015-01-21',1),(21,'member_auth','127.0.0.1','2015-01-21 13:02:48','2015-01-21',1),(20,'member_auth','127.0.0.1','2015-01-21 13:00:22','2015-01-21',1),(19,'member_auth','127.0.0.1','2015-01-21 11:56:25','2015-01-21',1),(18,'member_auth','127.0.0.1','2015-01-21 11:56:20','2015-01-21',1),(17,'member_auth','127.0.0.1','2015-01-21 11:56:06','2015-01-21',1),(16,'member_auth','127.0.0.1','2015-01-21 11:55:00','2015-01-21',0),(28,'member_auth','127.0.0.1','2015-01-21 13:29:48','2015-01-21',1),(29,'member_auth','127.0.0.1','2015-01-23 09:23:43','2015-01-23',1),(30,'member_auth','127.0.0.1','2015-01-23 09:24:23','2015-01-23',1),(31,'member_auth','127.0.0.1','2015-01-23 09:24:38','2015-01-23',1),(32,'member_auth','127.0.0.1','2015-01-23 09:24:39','2015-01-23',1),(33,'member_auth','127.0.0.1','2015-01-23 09:25:03','2015-01-23',1),(34,'member_auth','127.0.0.1','2015-01-23 09:25:13','2015-01-23',1),(35,'member_auth','127.0.0.1','2015-01-23 09:25:17','2015-01-23',1),(36,'member_auth','127.0.0.1','2015-01-23 09:25:24','2015-01-23',0),(37,'member_auth','127.0.0.1','2015-01-23 09:25:53','2015-01-23',1),(53,'member_register','127.0.0.1','2015-01-23 09:46:06','2015-01-23',0),(52,'member_register','127.0.0.1','2015-01-23 09:45:57','2015-01-23',0),(51,'member_register','127.0.0.1','2015-01-23 09:45:22','2015-01-23',0),(50,'member_register','127.0.0.1','2015-01-23 09:32:59','2015-01-23',0),(49,'member_register','127.0.0.1','2015-01-23 09:32:38','2015-01-23',1),(48,'member_register','127.0.0.1','2015-01-23 09:31:26','2015-01-23',1),(47,'member_register','127.0.0.1','2015-01-23 09:30:55','2015-01-23',1),(46,'member_register','127.0.0.1','2015-01-23 09:29:49','2015-01-23',1),(54,'member_register','127.0.0.1','2015-01-23 09:48:02','2015-01-23',0),(55,'privUsr_auth','117.57.41.194','2015-04-05 13:50:01','2015-04-05',1),(56,'privUsr_auth','117.57.41.194','2015-04-05 14:03:03','2015-04-05',1),(57,'privUsr_auth','58.39.58.132','2015-04-05 14:18:50','2015-04-05',1),(58,'privUsr_auth','117.57.41.194','2015-04-05 14:25:31','2015-04-05',1),(59,'privUsr_auth','117.57.41.194','2015-04-05 14:39:16','2015-04-05',1),(60,'privUsr_auth','117.57.41.148','2015-04-12 06:45:50','2015-04-12',1),(61,'privUsr_auth','58.39.58.132','2015-04-12 07:40:39','2015-04-12',1),(62,'privUsr_auth','116.226.48.151','2015-04-13 14:22:50','2015-04-13',1),(63,'privUsr_auth','117.57.41.148','2015-05-02 09:47:59','2015-05-02',1),(64,'privUsr_auth','58.39.58.132','2015-05-02 10:50:51','2015-05-02',1),(65,'privUsr_auth','117.57.41.148','2015-05-02 15:24:41','2015-05-02',1),(66,'privUsr_auth','117.57.41.148','2015-05-02 16:15:55','2015-05-02',1),(67,'privUsr_auth','58.39.58.132','2015-05-02 16:53:27','2015-05-02',1),(68,'privUsr_auth','117.57.41.148','2015-05-03 10:34:34','2015-05-03',1),(69,'privUsr_auth','117.57.41.148','2015-05-03 12:33:15','2015-05-03',1),(70,'privUsr_auth','117.57.41.148','2015-05-03 12:52:19','2015-05-03',1),(71,'privUsr_auth','117.57.41.148','2015-05-04 09:46:19','2015-05-04',1),(72,'privUsr_auth','116.226.48.151','2015-05-04 13:12:03','2015-05-04',0),(73,'privUsr_auth','116.226.48.151','2015-05-04 13:12:10','2015-05-04',1),(74,'privUsr_auth','117.57.41.148','2015-05-04 20:10:35','2015-05-04',1),(75,'privUsr_auth','58.39.58.132','2015-05-05 19:41:08','2015-05-05',1),(76,'privUsr_auth','117.57.41.148','2015-05-05 19:55:57','2015-05-05',1),(77,'privUsr_auth','117.57.41.148','2015-05-07 22:37:53','2015-05-07',1),(78,'privUsr_auth','117.57.41.148','2015-05-07 23:09:33','2015-05-07',1),(79,'privUsr_auth','116.226.48.151','2015-05-09 08:32:09','2015-05-09',1),(80,'privUsr_auth','117.57.41.148','2015-05-09 20:42:54','2015-05-09',1),(81,'privUsr_auth','117.57.47.59','2015-05-31 09:18:41','2015-05-31',1),(82,'privUsr_auth','61.172.52.34','2015-05-31 13:24:44','2015-05-31',1),(83,'privUsr_auth','117.57.47.59','2015-05-31 14:17:04','2015-05-31',1),(84,'privUsr_auth','117.57.47.59','2015-05-31 15:07:18','2015-05-31',1),(85,'privUsr_auth','127.0.0.1','2015-06-01 13:18:08','2015-06-01',1);

/*Table structure for table `tny_order_field` */

DROP TABLE IF EXISTS `tny_order_field`;

CREATE TABLE `tny_order_field` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(15) CHARACTER SET latin1 NOT NULL,
  `val` varchar(25) CHARACTER SET latin1 NOT NULL,
  `typ` enum('textarea','input_datetime','input_date','enum','set','input_file','input_str','input_num') CHARACTER SET latin1 DEFAULT 'input_str',
  `len` varchar(128) CHARACTER SET latin1 NOT NULL,
  `ept` enum('yes','no') CHARACTER SET latin1 NOT NULL,
  `comment` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`sid`),
  UNIQUE KEY `key` (`key`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

/*Data for the table `tny_order_field` */

insert  into `tny_order_field`(`sid`,`key`,`val`,`typ`,`len`,`ept`,`comment`) values (10,'accoutname','Accout name','input_str','50','no',''),(9,'phone','Your phone','input_str','25','no',''),(8,'eml','Your email','input_str','70','no',''),(11,'password','Password','input_str','30','no',''),(12,'servername','Server Name','input_str','30','no',''),(13,'charactername','Character Name','input_str','50','no',''),(14,'yourrequire','Your require (optional)','textarea','200','no',''),(16,'pincode','Pin code','input_str','25','no',''),(17,'faction','faction','input_str','25','no','??');

/*Table structure for table `tny_order_his` */

DROP TABLE IF EXISTS `tny_order_his`;

CREATE TABLE `tny_order_his` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pmtype` varchar(16) NOT NULL COMMENT 'payment type',
  `eml` varchar(48) NOT NULL,
  `dt` varchar(20) NOT NULL,
  `title` varchar(128) NOT NULL,
  `price` float DEFAULT NULL,
  `st` int(11) DEFAULT '0' COMMENT 'status 0未付款',
  `nsid` int(10) unsigned NOT NULL,
  `widord` int(11) NOT NULL,
  `locprice` varchar(128) NOT NULL COMMENT 'nsid+it = unique price',
  `dlvid` int(11) DEFAULT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `dtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf32;

/*Data for the table `tny_order_his` */

/*Table structure for table `tny_order_tpl` */

DROP TABLE IF EXISTS `tny_order_tpl`;

CREATE TABLE `tny_order_tpl` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ofsid` int(10) unsigned NOT NULL,
  `name` varchar(20) NOT NULL,
  `enable` enum('on','off') DEFAULT 'on',
  `order` int(11) NOT NULL,
  PRIMARY KEY (`sid`),
  UNIQUE KEY `ofsid` (`ofsid`,`name`)
) ENGINE=MyISAM AUTO_INCREMENT=102 DEFAULT CHARSET=latin1;

/*Data for the table `tny_order_tpl` */

insert  into `tny_order_tpl`(`sid`,`ofsid`,`name`,`enable`,`order`) values (67,12,'plcode','on',4),(65,8,'plcode','on',2),(64,9,'plcode','on',1),(66,11,'plcode','on',3),(63,10,'plcode','on',0),(68,13,'plcode','on',5),(69,14,'plcode','on',6),(70,16,'plcode','on',7),(71,10,'pl','on',0),(72,9,'pl','on',1),(73,8,'pl','on',2),(74,11,'pl','on',3),(75,12,'pl','on',4),(76,13,'pl','on',5),(77,14,'pl','on',6),(92,14,'gold','on',4),(91,13,'gold','on',3),(90,12,'gold','on',2),(89,8,'gold','on',1),(88,9,'gold','on',0),(95,12,'goldfa','on',2),(94,8,'goldfa','on',1),(93,9,'goldfa','on',0),(96,13,'goldfa','on',3),(97,14,'goldfa','on',4),(98,17,'goldfa','on',5),(99,9,'cdk','on',0),(100,8,'cdk','on',1),(101,14,'cdk','on',2);

/*Table structure for table `tny_priv` */

DROP TABLE IF EXISTS `tny_priv`;

CREATE TABLE `tny_priv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `privilege` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tny_priv` */

insert  into `tny_priv`(`id`,`name`,`pass`,`privilege`,`time`) values (7,'Apocalypse','5396017a1afce83cd9145bcde1f04d75','root','2010-06-29 20:54:12'),(17,'gh8448','8acb67faf82ab7550f83b8477310419d','root','2012-02-20 13:47:53'),(10,'tonypl','b531ae8907c00d3afce1e2cd6c9d0c77','orderViewor','2011-06-23 16:50:57'),(16,'qq','cce1ca683a0cab43337f3b2124339b43','root','2012-01-11 17:47:25'),(15,'tscs','0d0589cd78709802a64a9a4580ae6789','root','2011-12-26 10:33:11'),(14,'xc001','670b14728ad9902aecba32e22fa4f6bd','root','2011-12-16 10:37:24');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
