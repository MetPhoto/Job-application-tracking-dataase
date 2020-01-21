<?php
/*
Author by: Mark E Taylor
Created: 07/03/2014
Last updated: 07/03/2014

Revision history: 
07/03/2014 - Initial creation.

Description: Clears a specified alarm from the table and returns to the summary page (index.php).
*/

include_once("library/config.php");
include_once("library/open.php");

/* !Load some constants. Only define if they are not already defined. */
if(!defined('AAA_APPLICATION_CONSTANTS_DEFINED')){
	include_once("load_config.php");
}

$query = "DELETE FROM ".ALARMS_TABLE." WHERE applicationid=$_POST[applicationid]";
$result = $database_object->query($query);

header('location: index.php');
?>