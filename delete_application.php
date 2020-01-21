<?php
/*
Author by: Mark E Taylor
Created: 14/11/2013
Last updated: 14/11/2013

Revision history: 
14/11/2013 - Initial creation.

Description: Deletes an application from the database and any associated files and activities.
If debug is turned on then the quries are shown and the deletions from the tables are not actioned.
*/

$id = $_REQUEST['id'];

include_once("library/config.php");
include_once("library/open.php");

/* !Load some constants. Only define if they are not already defined. */
if(!defined('AAA_APPLICATION_CONSTANTS_DEFINED')){
	include_once("load_config.php");
}

/* !Delete the entry from the database. */
$query = "DELETE FROM ".APP_TABLE." WHERE id=$id";
if(DEBUG){
	echo "Application deletion query: $query <br/>";
} else {
	$result = $database_object->query($query);
}

/* !Delete any associated activities */
$query = "DELETE FROM ".ACTIVITY_TABLE." WHERE applicationid=$id";
if(DEBUG){
	echo "Activities deletion query: $query <br/>";
} else {
	$result = $database_object->query($query);
}

/* !Delete any associated files.  */
$query = "DELETE FROM ".UPLOADS_TABLE." WHERE applicationid=$id";
if(DEBUG){
	echo "Files deletion query: $query <br/>";
} else {
	$result = $database_object->query($query);
}

if(DEBUG){
	exit(99);
}

/* !Return to the index page. */
header('location: index.php');
?>