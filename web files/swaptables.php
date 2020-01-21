<?
/*
Author by: Mark E Taylor
Created: 02/03/2014
Last updated: 05/03/2014

Revision history: 
02/03/2014 - Initial creation.
04/03/2014 - Updated for the new alarms table.

Description: To swap betwen the live and demo tables automatically.
*/

include_once("library/config.php");
include_once("library/open.php");

/* !Load some constants. Only define if they are not already defined. */
if(!defined('AAA_APPLICATION_CONSTANTS_DEFINED')){
	include_once("load_config.php");
}

$config_table = "config";

$query = "SELECT value FROM $config_table WHERE item = 'app_table'";
$result = $database_object->query($query);
$row = $result->fetch_assoc();

/* A very basic test. If the primary data table is set to a value then swap all the tables. */
if($row['value']=="applications"){
	echo "The current job applications table is '$row[value]'.\n";
	echo "Swapping to the demo tables.\n";
	$query = "UPDATE $config_table SET value='applications_dummy' WHERE item='app_table'";
	$result = $database_object->query($query);

	$query = "UPDATE $config_table SET value='activities_dummy' WHERE item='event_table'";
	$result = $database_object->query($query);
	
	$query = "UPDATE $config_table SET value='alarms_dummy' WHERE item='alarms_table'";
	$result = $database_object->query($query);
	
	$database_object->close();
	echo "Update now complete. The system should now be using the demo tables.\n";
	
} else {
	echo "The current job applications table is '$row[value]'.\n";
	echo "Swapping to the live tables.\n";
	$query = "UPDATE $config_table SET value='applications' WHERE item='app_table'";
	$result = $database_object->query($query);

	$query = "UPDATE $config_table SET value='activities' WHERE item='event_table'";
	$result = $database_object->query($query);

	$query = "UPDATE $config_table SET value='alarms' WHERE item='alarms_table'";
	$result = $database_object->query($query);
		
	$database_object->close();
	echo "Update now complete. The system should now be using the live tables.\n";
}
?>