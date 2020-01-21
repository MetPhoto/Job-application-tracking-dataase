# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 192.168.1.65 (MySQL 5.5.62-0+deb8u1)
# Database: jobs
# Generation Time: 2020-01-21 11:34:08 +0000
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='A table that defines a set of variables to be used by the application.';

LOCK TABLES `config` WRITE;
/*!40000 ALTER TABLE `config` DISABLE KEYS */;

INSERT INTO `config` (`id`, `item`, `value`, `comment`)
VALUES
	(1,'app_table',X'6170706C69636174696F6E73','The table used to hold the data for each job application.'),
	(3,'summary_number',X'3335','The number of items show on the front page.'),
	(4,'col_width_email',X'3135','The width of the email column on the front page.'),
	(5,'col_width_role',X'3330','The width of the role column on the front page.'),
	(6,'col_width_agency',X'3135','The width of the agency column on the front page.'),
	(7,'agency_table',X'6167656E63696573','The table used to store information on job agencies.'),
	(8,'dropdown_table',X'64726F70646F776E','This table stores the items in the drop down menus.'),
	(9,'cv_table',X'6376','This table stores details of the CVs stored.'),
	(10,'default_cv_location',X'536F6D65206C6F63616C20666F6C646572206E616D652E','The default folder that CVs are located in.'),
	(11,'col_width_reference',X'3135','The width of the reference column on the front page.'),
	(12,'debug',X'30','Turns on or off debug code. Set/unset with 0 or 1.'),
	(13,'activity_table',X'61637469766974696573','The table used to store \'activities\'.'),
	(14,'col_width_activity',X'3930','The width of the column that displays the text of the activity.'),
	(15,'summary_reporting_days',X'37','The number of days to report for the summary page.'),
	(16,'activity_days',X'3134','The number of days to report activities against.'),
	(17,'uploads_folder_absolute_path',X'2F7661722F7777772F6A6F62732F75706C6F6164732F','The absolute path to the uploaded files.'),
	(18,'uploads_table',X'75706C6F616473','Details about the files being uploaded.'),
	(19,'col_width_filename',X'3535','The width of the filename column on the confirm file delete and show files report pages.'),
	(20,'http_uploads_path',X'75706C6F6164732F','The path used by HTTP to find an uploaded file.'),
	(21,'max_uploaded_file_size',X'353132303030','The maximum allowed size of file that could be uploaded, in bytes.'),
	(22,'aaaa_application_constants_defined',X'31','Used to detect if the constants are set or not.'),
	(23,'filetypes_table',X'66696C657479706573','Table used to store the extensions of the files that can be updated.'),
	(24,'users_table',X'7573657273','Table that holds details of authorised users.'),
	(25,'logon_code_expiration_period',X'363030','The number of seconds before the login code will expire.'),
	(26,'reports_table',X'7265706F727473','The table with the information about the reports available.'),
	(27,'report_header_table',X'7265706F72745F686561646572','The table that contains information about the headers used for any report.'),
	(28,'report_cells_table',X'7265706F72745F63656C6C73','The table that contains information about the cells used for any report.'),
	(29,'dont_save_report',X'30','Only save a new report if set to zero (0).'),
	(30,'browse_number',X'3235','The number of applications to show on each page of the \'browse\' pages.'),
	(31,'follow_up_email_address',X'736F6D6520656D61696C20616464726573732E','The email address to which follow up emails will be sent.'),
	(33,'send_email_days',X'613A373A7B733A363A2253756E646179223B733A323A226E6F223B733A363A224D6F6E646179223B733A333A22796573223B733A373A2254756573646179223B733A333A22796573223B733A393A225765646E6573646179223B733A333A22796573223B733A383A225468757273646179223B733A333A22796573223B733A363A22467269646179223B733A333A22796573223B733A383A225361747572646179223B733A323A226E6F223B7D','Days of the week to send out the emails.'),
	(34,'alarms_table',X'616C61726D73','The table that holds details of alarms set for applications.');

/*!40000 ALTER TABLE `config` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
