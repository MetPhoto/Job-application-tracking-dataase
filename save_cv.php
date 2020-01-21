<?php
/*
Author by: Mark E Taylor
Created: 09/11/2012
Last updated: 09/11/2012

Revision history: 
09/11/2012 - Initial creation.

Description: Saves a CV entry.
*/

$name = $_POST['name'];
$file_name =  $_POST['file_name'];
$location = htmlentities($_POST['location'], ENT_QUOTES);
$number = $_POST['number'];

include_once("library/config.php");
include_once("library/open.php");

/* !Load some constants. Only define if they are not already defined. */
if(!defined('AAA_APPLICATION_CONSTANTS_DEFINED')){
	include_once("load_config.php");
}

$query = "INSERT INTO ".CV_TABLE." (number, name, file_name, location, date_last_saved) VALUE('$number', '$name', '$file_name', '$location', NOW())";
$result = $database_object->query($query);

$_GET = array();
if($result){
	$_GET['sucess'] = "TRUE";
	header ('location: add_cv.php');
}else{
	$_GET['sucess'] = "FALSE";
	header ('location: add_cv.php');
}

?>