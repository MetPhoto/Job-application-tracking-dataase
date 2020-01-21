<?php 
/*
Author by: Mark E Taylor
Created: 04/04/2014
Last updated: 04/04/2014

Revision history: 
04/04/2014 - Initial creation.

Description: Edits a job alarm record in the MySQL database.
*/

$_GET['title'] = 'Edit alarm';
include_once("includes/header-htmlhead.php");
/* The connection to the database is made in the HTML navigation file, 'header-navigation.php' . */
include_once("includes/header-navigation.php");
include_once("includes/creatdropdopdown.php");

/* This is the an alarm ID, not a job ID. */
$alarmid = $_REQUEST['alarmid'];

echo "<article><div class='content'>\n";

/* !Get the data for the alarm. */
$query = "SELECT * FROM ".ALARMS_TABLE." WHERE id=$alarmid";
if(DEBUG){
	echo "Debug mode on.<br/>";
	echo $query."<br/>";
	echo $alarmid."<br/>";
	echo "<br/>";
	}
$result = $database_object->query($query);
$line = $result->fetch_assoc();

echo "<p>Edit alarm associated with job application ID = $line[applicationid], alarm originally added on $line[timestamp].</p>";

print<<<END
<article>
<div class="content">

<form action="save_alarm_edit.php" method="post" id="met-form">

<fieldset title="Details">
	<legend>Details</legend>
	<label>Job ID: $line[applicationid]</label>
	<br/>
	<input type="hidden" name=alarmid value=$alarmid>
	
	<label>Date (YYYY-MM-DD)</label>
	<input type="date" name="alarmdate" value=$line[alarmdate]>
	
	<label>Alarm description</label>
	<textarea name="alarmmessage" cols="50" autofocus rows="5">$line[alarmmessage]</textarea>

<input type="submit" title="Save edit" value="Save edit" class="clearfix">
</form>

</div> <!-- End of content. -->
</article>
END;

$result->free_result();
include_once("library/close.php");

/* !End of content. */
echo "</div>";
echo "</article>";

include_once("includes/footer.php");
?>