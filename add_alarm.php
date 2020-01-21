<?php 
/*
Author by: Mark E Taylor
Created: 04/04/2014
Last updated: 04/04/2014 

Revision history: 
04/04/2014 - Initial creation.

Description: Adds an alarm for a job application. For example to show a date to call someone back.
*/

$_GET = array();
$_GET['title'] = 'Add alarm';
include_once("includes/header-htmlhead.php");
include_once("includes/header-navigation.php");
include_once("includes/creatdropdopdown.php");

/* Load some constants. */
include_once("load_config.php");
include_once("library/config.php");
include_once("library/open.php");

if(isset($_REQUEST['applicationid'])){
	$applicationid = $_REQUEST['applicationid'];
} else {
	$applicationid = 0;
}

/* !Show the alarms for this job application id. */
if($applicationid>0){
	echo "<p>Existing alarms for <a href='edit_job.php?id=$applicationid' target='_blank' title='Click to edit the application in a new window.'>application $applicationid</a>:</p>";

	$query = "SELECT alarmdate,alarmmessage FROM ".ALARMS_TABLE." WHERE applicationid=$applicationid";
	$result = $database_object->query($query);
	$i = 1;

/* If alarms exist then display them. */
	if($result->num_rows>0){
		echo "<table id='summary' class='clearfix'>\n";
		echo "<thead><tr><th>No.</th><th>Date</th><th>Alarm message</th></tr></thead><tbody>\n";
		
		while($line = $result->fetch_assoc()){
			echo "<tr>";
			echo "<td class='centre'>$i</td><td class='centre'>$line[alarmdate]</td><td>$line[alarmmessage]</td>";
			echo "</tr>\n";
			$i++;
		}
		echo "<tbody>\n</table>\n";
	} else {
		echo "No alarms recorded.";
	}
} /* End of section to show exoisting alarms. */

$result->free_result();
include_once("library/close.php");

date_default_timezone_set('Europe/London');
$date = date('Y-m-d');

print<<<END
<article>
<div class="content">

<p>Add new alarm - alarms are sent out at 9am on the date set:</p>

<form action="save_alarm.php" method="post" id="met-form">

<fieldset title="Details">
	<legend>Details</legend>
	<label>Job ID: <a href='edit_job.php?id=$applicationid' target='_blank' title='Click to edit the application in a new window.'>$applicationid</a></label>
	<input type="number" name="applicationid" value="$applicationid">
	
	<label>Date (YYYY-MM-DD)</label>
	<input type="date" name="alarmdate" value=$date>
	
	<label>Alarm description</label>
	<textarea name="alarmmessage" cols="50" autofocus rows="4"></textarea>

<input type="submit" title="+ Add alarm" value="+ Add alarm" class="clearfix">
</form>

</div> <!-- End of content. -->
</article>
END;

include_once("includes/footer.php");
?>