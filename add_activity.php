<?php 
/*
Author by: Mark E Taylor
Created: 25/04/2013
Last updated: 25/04/2013

Revision history: 
25/04/2013 - Initial creation.

Now using GIT.

Description: Adds an activity record to the MySQL database.
*/

$_GET = array();
$_GET['title'] = 'Add activity';
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

/* !Show the activities for this job application id. For activities not asscoiated with an application then $applicationid=0. */
if($applicationid>0){
	echo "<p>Existing activities for <a href='edit_job.php?id=$applicationid' target='_blank' title='Click to edit the application in a new window.'>application $applicationid</a>:</p>";

	$query = "SELECT date, DATE_FORMAT(TIMESTAMP,'%l:%i%p') AS time, eventdetails FROM ".ACTIVITY_TABLE." WHERE applicationid=$applicationid";
	$result = $database_object->query($query);
	$i = 1;

/* If activities exist then display them. */
	if($result->num_rows>0){
		echo "<table id='summary' class='clearfix'>\n";
		echo "<thead><tr><th>No.</th><th>Date</th><th>Time</th><th>Details</th></tr></thead><tbody>\n";
		
		while($line = $result->fetch_assoc()){
			echo "<tr>";
			echo "<td class='centre'>$i</td><td class='centre'>$line[date]</td><td>$line[time]</td><td>$line[eventdetails]</td>";
			echo "</tr>\n";
			$i++;
		}
		echo "<tbody>\n</table>\n";
	} else {
		echo "No activities recorded.";
	}
} /* End of section to show activities. */

$result->free_result();

date_default_timezone_set('Europe/London');
$date = date('Y-m-d');
$time = date('H:i:s');

print<<<END
<article>
<div class="content">

<p>Add new activity:</p>

<form action="save_activity.php" method="post" id="met-form">

<fieldset title="Details">
	<legend>Details</legend>
	<label>Job ID: <a href='edit_job.php?id=$applicationid' target='_blank' title='Click to edit the application in a new window.'>$applicationid</a></label>
	<input type="number" name="applicationid" value="$applicationid">
	
	<label>Date</label>
	<input type="date" name="date" value=$date>

	<label>Time</label>
	<input type="time" name="time" value=$time>
	
	<label>Activity description</label>
	<textarea name="eventdetails" cols="50" autofocus rows="5"></textarea>

<input type="submit" title="+ Add activity" value="+ Add event" class="clearfix">
</form>

</div> <!-- End of content. -->
</article>
END;

include_once("includes/footer.php");
?>