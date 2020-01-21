<?php
/*
Author by: Mark E Taylor
Created: 10/10/2012
Last updated: 22/02/2014

Revision history: 
10/10/2012 - Initial creation.
11/10/2012 - Updated so it becomes generalized.
22/02/2014 - Revised and made simpler.

Description: Updates the 'config' table with values past to it from 'config.php'.
A new config item can be added to config.php without having to amend this code.
*/

include_once("library/config.php");
include_once("library/open.php");

/* !Load some constants. Only define if they are not already defined. */
if(!defined('AAA_APPLICATION_CONSTANTS_DEFINED')){
	include_once("load_config.php");
}

$config_table = "config";
$days_of_the_week = array("Sunday"=>"no","Monday"=>"no","Tuesday"=>"no","Wednesday"=>"no","Thursday"=>"no","Friday"=>"no","Saturday"=>"no");

/*
The $_POST['days'] array will only contain the name of the days that we wish to send emails on.
The days we do not wish to send emails on will not be listed in the array.
If no days are ticked on the configuration page then the $_POST['days'] array will be empty.
*/

if(isset($_POST['days'])){

	foreach($_POST['days'] as $key => $value){
	$days_of_the_week[$value] = "yes";
	} 
/* If $_POST['days'] is not set then set it to the default of every day being 'no'. */
} else {
	$_POST_['days'] = $days_of_the_week;
}

/* Serialise the data before its is stored in the 'config' table. */
$_POST['send_email_days'] = serialize($days_of_the_week);

/*
Loop through the whole of the $_POST array. Dynamically create the SQL UPDATE command.
Example query: UPDATE config SET value='7' WHERE item='summary_reporting_days'
*/

foreach($_POST as $key => $value){
	$query = "UPDATE $config_table SET value='".$value."' WHERE item='".$key."'";
	if(DEBUG){
		echo "Query: $query<br/>";
	}
	$result = $database_object->query($query);
}

if($result){
	header ('location: index.php');
} else {
	echo "Updating the config database failed...<br/>";
	echo $database_object->error;
	$database_object->close();
	exit(99);
}
?>