<?php 
/*
Author by: Mark E Taylor
Created: 06/10/2012
Last updated: 15/12/2019

Revision history: 
06/10/2012 - Initial creation.
26/04/2013 - Added a section to show the 'activities' for this apppliction.
30/04/2013 - Added an 'edit activity' button to the table that shows activities.
22/05/2013 - Added code to tidy up the email addresses.
22/06/2013 - Added a summary at the bottom of the page. Improved formatting of the date.
15/12/2019 - Small updates.

Description: Edits a job applicaiton record in the MySQL database.
*/

$_GET['title'] = 'Edit application';
include_once("includes/header-htmlhead.php");
/* The connection to the database is made in the HTML navigation file, 'header-navigation.php' . */
include_once("includes/header-navigation.php");
include_once("includes/creatdropdopdown.php");

/* This is the job ID, not an activity ID. */
$id = $_REQUEST['id'];

echo "<article><div class='content'>\n";

/* !Get the data for the application from the database. */
$query = "SELECT * from ".APP_TABLE." WHERE ID = '$id'";
$result = $database_object->query($query);
$row = $result->fetch_assoc();

$date = new DateTime($row['date']);
$date = $date->format('jS F Y');
$cv_used = $row['cv_used'];

/* !Tidy up the email address by removing any numbers before the @, eg. mark.taylor.123@me.com becomes mark.taylor@me.com. */
$edited_email = preg_replace("/.[0-9].*@/ui", "@", $row['contact_email']);

echo "<p>Edit the job application with the of ID = $id, submitted on $date.</p>";

/* !Put the word 'checked' into the <checkbox> element. This ensures that the checkbox is selected or not. */
switch($row['follow_up']){
    case TRUE:
        $follow_up = "checked";
        break;
    case FALSE:
        $follow_up = "";
        break;
}

/* !Put the word 'checked' into the <checkbox> element. This ensures that the checkbox is selected or not. */
switch($row['contract']){
    case TRUE:
        $contract = "checked";
        break;
    case FALSE:
        $contract = "";
        break;
}

print<<<END
<form action="save_job_edit.php" method="post" id="met-form">

<input type="hidden" name="id" value="$id">

<fieldset title="Details">
	<legend>Details</legend>
	<label>Role</label>
	<input type="text" name="role" autofocus size="35" value="$row[role]">

	<label>Reference</label>
	<input type="text" name="reference" size="35" value="$row[reference]">

	<label>Company</label>
	<input type="text" name="company" size="35" value="$row[company]">
	
	<label>Location</label>
	<input type="text" name="location" size="35" value="$row[location]">
	
	<label><a href="$row[url]" target="_blank" title="Open URL to job advert.">URL</a></label>
	<input type="url" name="url" size="35" value="$row[url]">
</fieldset>

<fieldset title="Pay rates">
	<legend>Pay rates</legend>
	<label>Day rate</label>
	&pound;<input type="number" name="day_rate" min='0' max='2000' value="$row[day_rate]">
	
	<label>Contract?</label>
	<input type='checkbox' name='contract' $contract>
	
	<label>Salary low</label>
	&pound;<input type="number" name="salary_low" min='0' max='200000' value="$row[salary_low]">

	<label>Salary high</label>
	&pound;<input type="number" name="salary_high" min='0' max='200000' value="$row[salary_high]">
</fieldset>

<fieldset tite="Agency">
	<legend>Contact details</legend>
	<label>Via</label>
	<input type="text" list="via" name="via" value="$row[via]"><datalist id="via"><option value="TotalJobs"><option value="JobSite"><option value="BCS"><option value="LinkedIn"></datalist>	
	
	<label>Agency</label>
	<input type="text" name="agency" value="$row[agency]">
	
	<label>First name</label>
	<input type="text" name="first_name" value="$row[first_name]">

	<label>Last name</label>
	<input type="text" name="last_name" value="$row[last_name]">
	
	<label><a href="mailto:$row[contact_email],$edited_email?subject=Reference:&nbsp;$row[reference] - $row[role]&amp;body=Dear&nbsp;$row[first_name]" title="Send an email the person">Contact email</a></label>
	<input type="email" name="contact_email" value="$row[contact_email]">
	
	<label>Telephone</label>
	<input type="tel" name="telephone" value="$row[telephone]">
END;

/* !Dynamically create the drop down menu. */
$menugroup = 1;
$default = $row['status'];
$label = "Submission status";
$menuname = "status";
$sucess = build_drop_down_menu($database_object, $menugroup, $default, $label, $menuname);

/* Build the drop down menu for the list of CVs. */
$query = "SELECT location, file_name, number, name FROM ".CV_TABLE." ORDER BY number";
$result = $database_object->query($query);
$cv_selected = "";

echo "<label>CV used:</label>";
echo "<select name='cv'>";

while($line = $result->fetch_assoc()){
	if($line['number']==$cv_used){
		$cv_selected = "selected='yes'";
	}
	echo "<option name='cv' value='$line[number]' $cv_selected>$line[file_name]</option>";
	$cv_selected = "";
}
$result->free_result();

echo "</select>";

if($row['company']==""){
	$company = "unknown";
} else {
	$company = $row['company'];
}

if($row['agency']==""){
	$agency = "unknown";
} else {
	$agency = $row['agency'];
}

if($row['location']==""){
	$location = "unknown location";
} else {
	$location = $row['location'];
}

if($row['reference']==""){
	$reference = "none";
} else {
	$reference = $row['reference'];
}

print<<<END
	<label>Follow up</label>
	<input type="checkbox" name="follow_up" value="follow_up" $follow_up>
</fieldset>

<fieldset title="Notes" class="clearfix">
	<legend>Notes</legend>
	<textarea name="notes" cols="40" rows="5">$row[notes]</textarea>
</fieldset>

<fieldset title="Summary" class="clearfix">
	<legend>Summary</legend>
  <textarea name="summary" cols="80" rows="4">On $date I applied for '$row[role]' based in $location. Reference: $reference. The agency is $agency via '$row[via]'. The company is $company.</textarea>
</fieldset>

<div class="buttons">
	<input type="submit" title="Save edit" value="Save edit" class="but_float">
	<input type="reset" title="Reset edit" value="Reset edit">
</div>

</form>

<div class="buttons">	
<form action="add_alarm.php?applicationid=$id" method="post" id="met-form">
	<input type="submit" title="Add alarm" value="Add alarm" class="but_float">
</form>

<form action="add_activity.php?applicationid=$id" method="post" id="met-form">
	<input type="submit" title="Add activity" value="Add activity" class="but_float">
</form>

<form action="add_file.php?applicationid=$id" method="post" id="met-form">
		<input type="submit" title="Add file" value="Add file" class="but_float">
</form>

<form action="confirm_delete_application.php?applicationid=$id" method="post" id="met-form">
	<input type="submit" title="Delete application" value="Delete application" class="but_float">
</form>
</div>
END;


/* !Show the alarms for this job application id. */
$query = "SELECT * FROM ".ALARMS_TABLE." WHERE applicationid=$id";
$result = $database_object->query($query);
$i = 1;

echo "<p class='clearfix'>Alarms for this application:</p>";
/* If alarms exist then display them. */
if($result->num_rows>0){
	echo "<table id='summary' class='clearfix'>\n";
	echo "<thead><tr><th>No.</th><th>Date</th><th>Alarm details</th><th>Edit</th></tr></thead><tbody>\n";
	
	while($line = $result->fetch_assoc()){
		echo "<tr>";
		echo "<td class='centre'>$i</td><td class='centre'>$line[alarmdate]</td><td>$line[alarmmessage]</td>";
	
		/* !Add a tiny form containing an 'edit' button. */
		echo "<td><form method='post' action='edit_alarm.php?alarmid=$line[id]'>";
		echo "<input name='id' type='hidden' value=$id>";
		echo "<input type='submit' value='Edit alarm'>";
		echo "</form></td>";
		echo "</tr>\n";
		$i++;
		}
		echo "<tbody>\n</table>\n";
} else {
		echo "No alarms for this application yet.";
}

/* !Show the activities for this job application id. */
$query = "SELECT id, date, DATE_FORMAT(TIMESTAMP,'%H:%i%p') AS time, eventdetails FROM ".ACTIVITY_TABLE." WHERE applicationid=$id";
$result = $database_object->query($query);
$i = 1;

echo "<p class='clearfix'>Activities for this application:</p>";
/* If activities exist then display them. */
if($result->num_rows>0){
	echo "<table id='summary' class='clearfix'>\n";
	echo "<thead><tr><th>No.</th><th>Date</th><th>Time</th><th>Details</th><th>Edit</th></tr></thead><tbody>\n";
	
	while($line = $result->fetch_assoc()){
		echo "<tr>";
		echo "<td class='centre'>$i</td><td class='centre'>$line[date]</td><td>$line[time]</td><td>$line[eventdetails]</td>";
	
		/* !Add a tiny form containing an 'edit' button. */
		echo "<td><form method='post' action='edit_activity.php?activityid=$line[id]'>";
		echo "<input name='id' type='hidden' value=$id>";
		echo "<input type='submit' value='Edit activity'>";
		echo "</form></td>";
		echo "</tr>\n";
		$i++;
		}
		echo "<tbody>\n</table>\n";
} else {
		echo "No activities for this application yet.";
}

/* !Show the files for this job application id. */
$query = "SELECT id, filename, DATE_FORMAT(dateuploaded,'%Y-%m-%d') AS date, DATE_FORMAT(dateuploaded,'%H:%i%p') AS time FROM ".UPLOADS_TABLE." WHERE applicationid=$id";
$result = $database_object->query($query);
$i = 1;

echo "<p>Files for this application:</p>";
/* If files exist then display them. */
if($result->num_rows>0){
	echo "<table id='summary' class='clearfix'>\n";
	echo "<thead><tr><th>No.</th><th>Date</th><th>Time</th><th>File name</th><th>Delete</th></tr></thead><tbody>\n";
	
	while($line = $result->fetch_assoc()){
		$filename = HTTP_UPLOADS_PATH.htmlspecialchars($line['filename']);
		echo "<tr>";
		echo "<td class='centre'>$i</td><td class='centre'>$line[date]</td><td>$line[time]</td><td><a href='$filename' target='_blank'>$line[filename]</a></td>";
	
		/* !Add a tiny form containing an 'edit' button. */
		echo "<td><form method='post' action='confirm_delete_file.php'>";
		echo "<input name='id' type='hidden' value=$line[id]>";
		echo "<input type='submit' value='Delete file'>";
		echo "</form></td>";
		echo "</tr>\n";
		$i++;
		}
		echo "<tbody>\n</table>\n";
} else {
		echo "No files for this application yet.";
}

$result->free_result();
include_once("library/close.php");

/* !End of content. */
echo "</div>";
echo "</article>";

include_once("includes/footer.php");
?>