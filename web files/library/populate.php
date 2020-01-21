<?php
/*
Author by: Mark E Taylor
Created: 22/02/2014
Last updated: 22/02/2014

Revision history: 
22/02/2014 - Initial creation.

Description: Creates a serialised array and stores it in the config table.
*** Only used ONCE to create the object.
Later used by the send_update_emails.php function to decide if an email should be sent on a particular day of the week.
*/

include_once("config.php");
include_once("open.php");

/* !Load some constants. Only define if they are not already defined. */
if(!defined('AAA_APPLICATION_CONSTANTS_DEFINED')){
	include_once("../load_config.php");
}

$days_of_the_week = array("Sunday"=>"no","Monday"=>"no","Tuesday"=>"no","Wednesday"=>"no","Thursday"=>"no","Friday"=>"no","Saturday"=>"no");

$s = serialize($days_of_the_week);

$query = "UPDATE config SET value='$s' WHERE item='send_email_days'";
$result = $database_object->query($query);


?>