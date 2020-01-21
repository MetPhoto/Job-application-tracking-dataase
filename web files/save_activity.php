<?php
/*
Author by: Mark E Taylor
Created: 26/04/2013
Last updated: 26/04/2013

Revision history: 
26/04/2013 - Initial creation.
27/04/2013 - Updated to save the date and time.

Description: Saves an 'event' and returns to the summary page (index.php).
*/

$date = $_POST['date'];
$time = $_POST['time'];
$applicationid = $_POST['applicationid'];
$eventdetails = $_POST['eventdetails'];

include_once("library/config.php");
include_once("library/open.php");

/* !Load some constants. Only define if they are not already defined. */
if(!defined('AAA_APPLICATION_CONSTANTS_DEFINED')){
	include_once("load_config.php");
}

$query = "INSERT INTO ".ACTIVITY_TABLE." (date, time, applicationid, eventdetails, timestamp) VALUE ('$date', '$time','$applicationid','$eventdetails', NOW())";

$result = $database_object->query($query);

if($result){
	header('location: index.php');
} else {
	echo "Failed to write to database.";
	exit(99);
}
?>