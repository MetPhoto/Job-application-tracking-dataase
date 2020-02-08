# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: fastpi.local (MySQL 5.5.62-0+deb8u1)
# Database: jobs
# Generation Time: 2020-02-08 21:57:01 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table config
# ------------------------------------------------------------

DROP TABLE IF EXISTS `config`;

CREATE TABLE `config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `item` text NOT NULL,
  `value` blob NOT NULL,
  `comment` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='A table that defines a set of variables to be used by the application.';

LOCK TABLES `config` WRITE;
/*!40000 ALTER TABLE `config` DISABLE KEYS */;

INSERT INTO `config` (`id`, `item`, `value`, `comment`)
VALUES
	(1,'app_table','applications','The table used to hold the data for each job application.'),
	(3,'summary_number','35','The number of items show on the front page.'),
	(4,'col_width_email','15','The width of the email column on the front page.'),
	(5,'col_width_role','30','The width of the role column on the front page.'),
	(6,'col_width_agency','15','The width of the agency column on the front page.'),
	(7,'agency_table','agencies','The table used to store information on job agencies.'),
	(8,'dropdown_table','dropdown','This table stores the items in the drop down menus.'),
	(9,'cv_table','cv','This table stores details of the CVs stored.'),
	(10,'default_cv_location','Some local folder name.','The default folder that CVs are located in.'),
	(11,'col_width_reference','15','The width of the reference column on the front page.'),
	(12,'debug','0','Turns on or off debug code. Set/unset with 0 or 1.'),
	(13,'activity_table','activities','The table used to store \'activities\'.'),
	(14,'col_width_activity','90','The width of the column that displays the text of the activity.'),
	(15,'summary_reporting_days','7','The number of days to report for the summary page.'),
	(16,'activity_days','14','The number of days to report activities against.'),
	(17,'uploads_folder_absolute_path','/var/www/jobs/uploads/','The absolute path to the uploaded files.'),
	(18,'uploads_table','uploads','Details about the files being uploaded.'),
	(19,'col_width_filename','55','The width of the filename column on the confirm file delete and show files report pages.'),
	(20,'http_uploads_path','uploads/','The path used by HTTP to find an uploaded file.'),
	(21,'max_uploaded_file_size','512000','The maximum allowed size of file that could be uploaded, in bytes.'),
	(22,'aaaa_application_constants_defined','1','Used to detect if the constants are set or not.'),
	(23,'filetypes_table','filetypes','Table used to store the extensions of the files that can be updated.'),
	(24,'users_table','users','Table that holds details of authorised users.'),
	(25,'logon_code_expiration_period','600','The number of seconds before the login code will expire.'),
	(26,'reports_table','reports','The table with the information about the reports available.'),
	(27,'report_header_table','report_header','The table that contains information about the headers used for any report.'),
	(28,'report_cells_table','report_cells','The table that contains information about the cells used for any report.'),
	(29,'dont_save_report','0','Only save a new report if set to zero (0).'),
	(30,'browse_number','25','The number of applications to show on each page of the \'browse\' pages.'),
	(31,'follow_up_email_address','name@example.com','The email address to which follow up emails will be sent.'),
	(33,'send_email_days','a:7:{s:6:"Sunday";s:2:"no";s:6:"Monday";s:3:"yes";s:7:"Tuesday";s:3:"yes";s:9:"Wednesday";s:3:"yes";s:8:"Thursday";s:3:"yes";s:6:"Friday";s:3:"yes";s:8:"Saturday";s:2:"no";}','Days of the week to send out the emails.'),
	(34,'alarms_table','alarms','The table that holds details of alarms set for applications.'),
	(35,'update_status_days','10','Days in the past when to set the status to a new value, proably \'submitted and ignored\'.'),
	(36,'update_status_to_id','10','The ID number of the status messages to set for applications which are update_status_days old.');

/*!40000 ALTER TABLE `config` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
