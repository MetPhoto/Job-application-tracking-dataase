<?php
/*
Author by: Mark E Taylor
Created: 04/04/2014
Last updated: 04/04/2014

Revision history: 
04/04/2014 - Initial creation.

Description: Sends out emails to remind the recipient to take some action when an alarm is set against an application.
*/

include_once("config.php");
include_once("open.php");

/* !Load some constants. Only define if they are not already defined. */
if(!defined('AAA_APPLICATION_CONSTANTS_DEFINED')){
	include_once("../load_config.php");
}

/* FOLLOW_UP_EMAIL_ADDRESS is a constant. */
$to = FOLLOW_UP_EMAIL_ADDRESS;

/* Select the details of the alarm emails to be sent out. */
$query1 = "SELECT * FROM ".ALARMS_TABLE." WHERE alarmdate=DATE(now())";
$result1 = $database_object->query($query1);

/* If there are any alarms set for today then send out the emails. */
if($result1->num_rows > 0){
while($line1 = $result1->fetch_assoc()){

	$query2 = "SELECT role, company FROM ".APP_TABLE." WHERE id=$line1[applicationid]";
	$result2 = $database_object->query($query2);
	$line2 = $result2->fetch_assoc();
	
	if($line2['company']==NULL){
		$company = "an unknown company";	
	} else {
		$company = $line2['company'];	
	}	
	
	$subject = "Alarm set for job application ID: $line1[applicationid] - $line2[role]";
	
	$message = "
	<html>
	<head>
	  <title>Alarm set for job application ID: $line1[applicationid], '$line2[role]' at $company.</title>
	</head>
	<body>
	  <h2>Time to follow up on this job application!</h2>
	  <p>Perform some action on the job application with the ID: $line1[applicationid] at $company.</p>
	  <p>Click <a href='http://fastpi/jobs/edit_job.php?id=$line1[applicationid]' title='Link to the job application'>here</a> to see the application details.</p>
	  <p>The message is: '$line1[alarmmessage]'.</p>
	</body>
	</html>";
	
	$headers  = "MIME-Version: 1.0'\r\n";
	$headers .= "Content-type: text/html; charset=UTF8\r\n";
	
/* 	$headers .= "To: $to\r\n"; */
	$headers .= "From: Job Application Alarm robot <dummy@fastpi>\r\n";
		
	mail($to, $subject, $message, $headers);
}

} else {
	echo "No alarm emails will be sent, as there are no alarms set for today.\n";
}
?>