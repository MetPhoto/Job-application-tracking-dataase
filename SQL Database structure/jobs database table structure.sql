# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 192.168.1.65 (MySQL 5.5.62-0+deb8u1)
# Database: jobs
# Generation Time: 2020-01-21 09:33:12 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table activities
# ------------------------------------------------------------

DROP TABLE IF EXISTS `activities`;

CREATE TABLE `activities` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `eventdetails` text,
  `applicationid` int(11) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  `time` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table activities_dummy
# ------------------------------------------------------------

DROP TABLE IF EXISTS `activities_dummy`;

CREATE TABLE `activities_dummy` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `eventdetails` text,
  `applicationid` int(11) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  `time` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='A dummy table used when the config item debug is set to 1.';



# Dump of table agencies
# ------------------------------------------------------------

DROP TABLE IF EXISTS `agencies`;

CREATE TABLE `agencies` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT '',
  `website` varchar(100) DEFAULT '',
  `location` varchar(50) DEFAULT NULL,
  `contact_first_name` varchar(20) DEFAULT NULL,
  `contact_secon_naem` varchar(20) DEFAULT NULL,
  `contact_phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table alarms
# ------------------------------------------------------------

DROP TABLE IF EXISTS `alarms`;

CREATE TABLE `alarms` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `alarmdate` date DEFAULT NULL,
  `applicationid` int(11) DEFAULT NULL,
  `alarmmessage` text,
  `timestamp` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table alarms_dummy
# ------------------------------------------------------------

DROP TABLE IF EXISTS `alarms_dummy`;

CREATE TABLE `alarms_dummy` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `alarmdate` date DEFAULT NULL,
  `applicationid` int(11) DEFAULT NULL,
  `alarmmessage` text,
  `timestamp` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='A dummy table used when the config item debug is set to 1.';



# Dump of table applications
# ------------------------------------------------------------

DROP TABLE IF EXISTS `applications`;

CREATE TABLE `applications` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `role` text NOT NULL,
  `reference` text,
  `day_rate` int(11) DEFAULT NULL,
  `salary_low` int(11) DEFAULT NULL,
  `salary_high` int(11) DEFAULT NULL,
  `via` text,
  `company` text,
  `contact_name` text,
  `contact_email` text,
  `url` text,
  `status` text NOT NULL,
  `telephone` text,
  `notes` longtext,
  `agency` text,
  `location` text,
  `follow_up` tinyint(1) DEFAULT '0',
  `first_name` text,
  `last_name` text,
  `cv_used` int(11) DEFAULT NULL,
  `contract` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `followup` (`follow_up`),
  KEY `date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Stores job application data.';



# Dump of table applications_dummy
# ------------------------------------------------------------

DROP TABLE IF EXISTS `applications_dummy`;

CREATE TABLE `applications_dummy` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `role` text NOT NULL,
  `reference` text,
  `day_rate` int(11) DEFAULT NULL,
  `salary_low` int(11) DEFAULT NULL,
  `salary_high` int(11) DEFAULT NULL,
  `via` text,
  `company` text,
  `contact_name` text,
  `contact_email` text,
  `url` text,
  `status` text NOT NULL,
  `telephone` text,
  `notes` longtext,
  `agency` text,
  `location` text,
  `follow_up` tinyint(1) DEFAULT NULL,
  `first_name` text,
  `last_name` text,
  `cv_used` int(11) DEFAULT NULL,
  `contract` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='A dummy table used when the config item debug is set to 1.';



# Dump of table config
# ------------------------------------------------------------

DROP TABLE IF EXISTS `config`;

CREATE TABLE `config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `item` text NOT NULL,
  `value` blob NOT NULL,
  `comment` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='A table that defines a set of variables to be used by the application.';



# Dump of table cv
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cv`;

CREATE TABLE `cv` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `number` int(11) NOT NULL,
  `location` varchar(256) NOT NULL DEFAULT '',
  `file_name` varchar(120) NOT NULL DEFAULT '',
  `date_last_saved` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='A table to track the name of the CV being used to apply for a job.';



# Dump of table dropdown
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dropdown`;

CREATE TABLE `dropdown` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `menuid` int(11) NOT NULL,
  `menutext` varchar(30) NOT NULL DEFAULT '',
  `menuname` varchar(30) NOT NULL DEFAULT '',
  `comment` varchar(50) NOT NULL DEFAULT '',
  `menugroup` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table filetypes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `filetypes`;

CREATE TABLE `filetypes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinytext NOT NULL,
  `description` text,
  `extension` tinytext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='A table of MIME types that are allowed to be uploaded to the Jobs database.';



# Dump of table report_cells
# ------------------------------------------------------------

DROP TABLE IF EXISTS `report_cells`;

CREATE TABLE `report_cells` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `report_number` int(11) DEFAULT NULL,
  `cell_format` varchar(512) DEFAULT NULL,
  `cell_order` int(11) DEFAULT NULL,
  `comment` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table report_header
# ------------------------------------------------------------

DROP TABLE IF EXISTS `report_header`;

CREATE TABLE `report_header` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `report_number` int(11) DEFAULT NULL,
  `header_name` varchar(50) DEFAULT NULL,
  `header_order` int(11) DEFAULT NULL,
  `comment` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table reports
# ------------------------------------------------------------

DROP TABLE IF EXISTS `reports`;

CREATE TABLE `reports` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `report_number` int(11) DEFAULT NULL,
  `report_name` varchar(100) DEFAULT '',
  `select_statement` text,
  `select_parameter1` varchar(100) DEFAULT NULL,
  `select_parameter2` varchar(100) DEFAULT NULL,
  `select_parameter3` varchar(100) DEFAULT NULL,
  `displayorder` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table uploads
# ------------------------------------------------------------

DROP TABLE IF EXISTS `uploads`;

CREATE TABLE `uploads` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `applicationid` int(11) unsigned NOT NULL,
  `filename` text NOT NULL,
  `filesize` int(11) NOT NULL,
  `filetype` text NOT NULL,
  `dateuploaded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table that keeps track of uploaded files.';



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userid` tinytext NOT NULL,
  `password` blob NOT NULL,
  `code` int(11) DEFAULT NULL,
  `expired` timestamp NULL DEFAULT NULL,
  `email` tinytext NOT NULL,
  `uuid` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
