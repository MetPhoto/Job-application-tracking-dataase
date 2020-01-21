<?php
/*
Author by: Mark E Taylor
Created: 30/04/2013
Last updated: 30/04/2013

Revision history: 
30/04/2013 - Initial creation.

Description: Saves an eidted activity and returns to the main page (index.php).
*/

$date = $_POST['date'];
$time = $_POST['time'];
$applicationid = $_POST['applicationid'];
$eventdetails = $_POST['eventdetails'];
$id = $_POST['activityid'];

include_once("library/config.php");
include_once("library/open.php");

/* !Load some constants. Only define if they are not already defined. */
if(!defined('AAA_APPLICATION_CONSTANTS_DEFINED')){
	include_once("load_config.php");
}

$query = "UPDATE ".ACTIVITY_TABLE." SET date='$date', time='$time', applicationid='$applicationid', eventdetails='$eventdetails' WHERE id='$id'";

$result = $database_object->query($query);

$_GET = array();
if($result){
	$_GET['success'] = "TRUE";
	header ('location: index.php');
}else{
	$_GET['success'] = "FALSE";
	header ('location: index.php');
}

?>