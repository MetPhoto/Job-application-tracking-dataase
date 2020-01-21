<?php
/*
Author by: Mark E Taylor
Created: 06/10/2012
Last updated: 18/09/2013

Revision history: 
06/10/2012 - Initial creation.
12/10/2012 - Updated to use first and last name rather than contact name.
18/09/2013 - Updated to accomadate the newly added 'contract' field.

Description: Saves job aplications and returns to the summary page (index.php).
*/

$date = date('Y-m-d');

$role = $_POST['role'];
$reference =  $_POST['reference'];
$company = $_POST['company'];
$location = $_POST['location'];
$url = $_POST['url'];

$day_rate = $_POST['day_rate'];
$contract = $_POST['contract'];

if($contract=="on"){
	$contract = 1;
} else {
	$contract = 0;
}

$salary_low = $_POST['salary_low'];
$salary_high = $_POST['salary_high'];

$via = $_POST['via'];
$agency = $_POST['agency'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$contact_email = $_POST['contact_email'];
$telephone = $_POST['telephone'];
$status = $_POST['status'];
$cv_used = $_POST['cv'];

if(isset($_POST['follow_up'])){
	$follow_up = TRUE;
} else {
	$follow_up = FALSE;
}

$notes = $_POST['notes'];

include_once("library/config.php");
include_once("library/open.php");

/* !Load some constants. Only define if they are not already defined. */
if(!defined('AAA_APPLICATION_CONSTANTS_DEFINED')){
	include_once("load_config.php");
}

$query = "INSERT INTO ".APP_TABLE." (date,role,reference,day_rate,contract,salary_low,salary_high,via,agency,company,location,first_name,last_name,contact_email,url,telephone,status,notes,follow_up,cv_used) VALUE ('$date','$role','$reference','$day_rate','$contract','$salary_low','$salary_high','$via','$agency','$company','$location','$first_name','$last_name','$contact_email','$url','$telephone','$status','$notes','$follow_up','$cv_used')";
$result = $database_object->query($query);

header('location: index.php');
?>