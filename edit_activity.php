<?php 
/*
Author by: Mark E Taylor
Created: 30/04/2013
Last updated: 30/04/2013

Revision history: 
30/04/2013 - Initial creation.

Description: Edits a job activity record in the MySQL database.
*/

$_GET['title'] = 'Edit activity';
include_once("includes/header-htmlhead.php");
/* The connection to the database is made in the HTML navigation file, 'header-navigation.php' . */
include_once("includes/header-navigation.php");
include_once("includes/creatdropdopdown.php");

/* This is the an activity ID, not a job ID. */
$activityidid = $_REQUEST['activityid'];

echo "<article><div class='content'>\n";

/* !Get the data for the activity. */
$query = "SELECT date, time, eventdetails, applicationid, timestamp FROM ".ACTIVITY_TABLE." WHERE id=$activityidid";
if(DEBUG){
	echo "Debug mode on.<br/>";
	echo $query."<br/>";
	echo $activityidid."<br/>";
	echo "<br/>";
	}
$result = $database_object->query($query);
$line = $result->fetch_assoc();

echo "<p>Edit activity associated with job application ID = $line[applicationid], activity originally added on $line[timestamp].</p>";

print<<<END
<article>
<div class="content">

<form action="save_activity_edit.php" method="post" id="met-form">

<fieldset title="Details">
	<legend>Details</legend>
	<label>Job ID</label>
	<input type="hidden" name=activityid value=$activityidid>
	<input type="number" name="applicationid" value=$line[applicationid]>
	
	<label>Date</label>
	<input type="date" name="date" value=$line[date]>

	<label>Time</label>
	<input type="time" name="time" value=$line[time]>
	
	<label>Activity description</label>
	<textarea name="eventdetails" cols="50" autofocus rows="5">$line[eventdetails]</textarea>

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