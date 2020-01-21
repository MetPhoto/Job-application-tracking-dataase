<?php
/*
Author by: Mark E Taylor
Created: 22/02/2014
Last updated: 22/02/2014

Revision history: 
22/02/2014 - Initial creation.

Description: Sends out emails to remind the recipient to follow up on job applications that have the 'follup up' flag set.
*/

include_once("config.php");
include_once("open.php");

/* !Load some constants. Only define if they are not already defined. */
if(!defined('AAA_APPLICATION_CONSTANTS_DEFINED')){
	include_once("../load_config.php");
}

/* SEND_EMAIL_DAYS is a constant in the form: array("Sunday"=>"no","Monday"=>"no","Tuesday"=>"no","Wednesday"=>"no","Thursday"=>"no","Friday"=>"no","Saturday"=>"yes"); */

$unserialised_days = unserialize(SEND_EMAIL_DAYS);

/* Get the day name of the week, this will point to an item in the array $unserialised_days. */
$d = getdate(time());
$weekday = $d['weekday'];

/* $send_today will be set to 'yes' if the $weekday is set to 'yes' in the SEND_EMAIL_DAYS array. */
$send_today = $unserialised_days[$weekday];

/* Only send if $send_today=='yes'. */
if($send_today=='yes'){

/* FOLLOW_UP_EMAIL_ADDRESS is a constant. */
$to = FOLLOW_UP_EMAIL_ADDRESS;

/* Select the details of the emails to be sent out. */
$query = "SELECT id, role, date, agency, contact_email, first_name, last_name, salary_high FROM ".APP_TABLE." WHERE follow_up=1";
$result = $database_object->query($query);

while($line = $result->fetch_assoc()){
	$subject = "Follow up reminder for job application ID: $line[id] - $line[role]";
	$salary_high = "&pound;".number_format($line['salary_high'],0);
	
	$message = "
	<html>
	<head>
	  <title>Follow up reminder for job application ID: $line[id] - '$line[role]'.</title>
	</head>
	<body>
	  <h2>Time to follow up on this job application!</h2>
	  <p>Follow up on the job application with the ID: $line[id], '$line[role]'.</p>
	  <p>Click <a href='http://fastpi/jobs/edit_job.php?id=$line[id]' title='Link to the job application'>here</a> to see the application details.</p>
	  <p>Date applied: $line[date].</p>
	  <p>Agency: $line[agency].</p>
	  <p>Contact name: $line[first_name] $line[last_name].</p>
	  <p>Email: <a href='mailto:$line[contact_email]?subject=re:$line[role]'>here</a>.</p>
	  <p>High salary range: $salary_high.</p>
	</body>
	</html>";
	
	$headers  = "MIME-Version: 1.0'\r\n";
	$headers .= "Content-type: text/html; charset=UTF8\r\n";
	
/* 	$headers .= "To: $to\r\n"; */
	$headers .= "From: Job Application Follow Up robot <dummy@fastpi>\r\n";
		
	mail($to, $subject, $message, $headers);
}

} else {
	echo "No follow-up emails will be sent, as this is not a day to send out emails.\n";
	echo "Emails will sent out on the following days:\n";
	
	foreach($unserialised_days as $key => $value){
		if($value == 'yes'){
		echo $key."\n";
		}
	}
	echo "You can change which days follow up emails are sent out using the 'Configuration' page inside the application.\n";
}
?>