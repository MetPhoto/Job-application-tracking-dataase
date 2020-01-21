<?php
/*
Author by: Mark E Taylor
Created: 04/04/2014
Last updated: 04/04/2014 

Revision history: 
04/04/2014 - Initial creation.

Description: Saves an 'alarm' and returns to the summary page (index.php).
*/

$alarmdate = $_POST['alarmdate'];
$applicationid = $_POST['applicationid'];
$alarmmessage = $_POST['alarmmessage'];

include_once("library/config.php");
include_once("library/open.php");

/* !Load some constants. Only define if they are not already defined. */
if(!defined('AAA_APPLICATION_CONSTANTS_DEFINED')){
	include_once("load_config.php");
}

$query = "INSERT INTO ".ALARMS_TABLE." (alarmdate, applicationid, alarmmessage, timestamp) VALUE ('$alarmdate', '$applicationid','$alarmmessage', NOW())";


$result = $database_object->query($query);

if($result){
	header('location: index.php');
} else {
	echo "Failed to write to database.<br/>";
	echo "The query was : $query";
	exit(99);
}
?>