<?php 
/*
Author by: Mark E Taylor
Created: 06/10/2012
Last updated: 05/03/2014

Revision history: 
06/10/2012 - Initial creation.
09/10/2012 - Further tweeks.
19/12/2012 - Added 'In progress' status summary. Recreated the summary table so it does not need kneed to know in advance the names of each of the status messages.
29/12/2012 - Added debuging code. Just to test the system. Set debug to 1 in the database 'config' table to enable debug.
04/01/2013 - Added code to show when the last job application was added to the database.
07/03/2013 - Amended the main summary MySQL select code to select by date not by ID. Nescessary after I imported some older records.
28/04/2013 - Added a summary line at the top showing the total number of applications in the last SUMMARY_REPORTING_DAYS days.
08/05/2013 - Added code to remove some spurious characters from the email addresses. Makes use of preg_replace.
12/09/2013 - *** not yet finished *** Added some code to check for the status of the session *** not yet finished ***.
18/09/2013 - Updated to accomadate the newly added 'contract' field.
05/03/2014 - Added a section to display 'arlams'.
08/02/2020 - Added code to change the status of existing applications wih a status of submitted which are XX days old to 'submitted and ignored'.

Description: Shows a summary of the job applications made and stored in the database.
*/
session_start();

$_GET['title'] = 'Summary';
include_once("includes/header-htmlhead.php");
/* !The connection to the database is made in the HTML navigation file, 'header-navigation.php' . */
include_once("includes/header-navigation.php");

echo "<article>\n<div class='content'>";

/* Updates the status of an application to a new status if it is more than XX days old. */
/* UPDATE_STATUS_DAYS is a constant. */
$days = UPDATE_STATUS_DAYS;

/* UPDATE_STATUS_TO_ID is a contstant. The ID number of the status to update to. */
/* Get the new status name from the ID number. */
/* This is way to complex! It does allow the status descrption to be changed. */
$new_status_id = UPDATE_STATUS_TO_ID;
$query = "SELECT menutext from dropdown where id=".UPDATE_STATUS_TO_ID;
$result = $database_object->query($query);
$row = $result->fetch_row();
$new_status_name = $row[0];

/* Now update each of the applications to the new status. */
$query = "UPDATE ".APP_TABLE." SET status='$new_status_name' WHERE DATE(DATE) < (SELECT CURRENT_DATE - INTERVAL $days DAY) AND STATUS='submitted'";
$result = $database_object->query($query);
/* Get the number of applications which had their status changed. */
$rowcount = $database_object->affected_rows;

/* The alarms for today. */
$query = "SELECT * FROM ".ALARMS_TABLE." WHERE DATE(alarmdate)=DATE(NOW())";
$result = $database_object->query($query);

if($result->num_rows>0){
echo "<p>Alarms set for today:</p>";
	while($line = $result->fetch_assoc()){
		echo "<form action='clear_alarm.php' id='met-form' method='post'>";
		echo "<div class='alarm'>$line[alarmmessage] <a href='edit_job.php?id=$line[applicationid]'>Application ID: $line[applicationid].</a><button type='submit' name='applicationid' value='$line[applicationid]' title='Clear alarm'>Clear alarm</button></div>";
		echo "</form>";
	}
}

/* The total number of applications, count(*) as some columns may be blank. */
$query = "SELECT count(*) AS count FROM ".APP_TABLE;
$result = $database_object->query($query);
$row = $result->fetch_assoc();
$number_of_jobs = $row['count'];

/* The total number of applications in the last 7 days. */
$query = "SELECT count(*) AS count FROM ".APP_TABLE." WHERE date>CURDATE()-INTERVAL ".SUMMARY_REPORTING_DAYS." DAY";
$result = $database_object->query($query);
$row = $result->fetch_assoc();
$number_of_jobs_last_7_days = $row['count'];

/* The last time a job was added to the database. */
$query = "SELECT MAX(date) as date FROM ".APP_TABLE;
$result = $database_object->query($query);
$row = $result->fetch_assoc();
$last_update = $row['date'];

/* Convert the result to a date object. */
$date_of_last_update = new DateTime($last_update);

/* Get a date object for right now. */
$today = new DateTime('now');
/* Get the difference between today's date and the date of the last update. */
$interval = $date_of_last_update->diff($today);
/* Convert $interval to a number, not a date object. */
$interval_number = $interval->format('%a');

/* Create the date of the last update. Either as 'today' or the previous date. */
$plural = "";
if($interval_number==0){
	$date_formated = "today.";
} else {
	if($interval_number>1){
		$plural = "s";
	}
	$date_formated = "on ".$date_of_last_update->format('jS F Y')."; $interval_number day$plural ago.";
}

if(isset($_SESSION['userid'])){
	$name = ucfirst($_SESSION['userid']);
	echo "<p>Welcome back $name.</p>";
}

echo "<p>A total of $number_of_jobs_last_7_days applications were made in the last ".SUMMARY_REPORTING_DAYS." days, the last was made $date_formated</p>";

echo "<p>Applications which are $days days old have been updated to the status '$new_status_name'. The number updated today was $rowcount.</p>";

/* The total number of applications with a the 'follow up' flag set. */
$query = "SELECT count(follow_up) FROM ".APP_TABLE." WHERE follow_up=TRUE";
$result = $database_object->query($query);
$row = $result->fetch_row();
$follow_up_number = $row[0];

/* The total number of applications with a the 'contract' flag set. */
$query = "SELECT count(contract) FROM ".APP_TABLE." WHERE contract=TRUE";
$result = $database_object->query($query);
$row = $result->fetch_row();
$contract = $row[0];

/* Get the count of each status if it is > 0. Does not require you to know the name of the 'status' messages in advance.
Creates a result like this:
submitted	670
Sent follow up email	4
Rejected	53
*/
$query = "SELECT DISTINCT(status) as status_name, COUNT(status) as status_count FROM ".APP_TABLE." GROUP by status ORDER BY status DESC";
$result = $database_object->query($query);

/* Start of the summary table. */
echo "\n<table class='top-summary'>\n";
echo "<caption>Applications by status</caption>\n";

/* Start of top (heading) row. */
/* The first two are not really status, 'total' is simply a count of all application and 'follow up' is a flag against each application. */
echo "<thead><tr><th>Total</th><th>Follow up</th><th>Contract</th>";

/* Remainder of top (heading) row. A heading for each status, found by the query above. */
while($line = $result->fetch_assoc()){
	echo "<th>".ucfirst($line["status_name"])."</th>";
};

/* Go back to the start of the query result, now display the number of each status, one number for each heading. */
$result->data_seek(0);
echo "</tr></thead>\n<tbody>\n";
/* Start of the bottom row that holds the number of each status. The first two are not real status messages. */
echo "<tr>";
echo "<td>$number_of_jobs</td>";
echo "<td>$follow_up_number</td>";
echo "<td>$contract</td>";

/* Loop through the size (count) for each of the remaing status. */
while($line = $result->fetch_assoc()){
	echo "<td>$line[status_count]</td>";
};

/* End of the row that holds the data and the table. */
echo "</tr>\n</tbody>\n</table>\n";

$result->free_result();

/* Start of the table that shows the recent applicaitons. Limited by SUMMARY_NUMBER.  */
$query = "SELECT id, DATE_FORMAT(date, '%d/%m/%y') AS date_formated, role, reference, day_rate, salary_low, salary_high, via, company, contact_name, contact_email, url, agency, status, follow_up, last_name, first_name FROM ".APP_TABLE." ORDER BY ID DESC LIMIT ".SUMMARY_NUMBER;
$result = $database_object->query($query);

echo "<p>Summary of the last ".SUMMARY_NUMBER." of applications, newest first. Click on a column name to hide the column.</p>\n";

print<<<END
<table id='summary'>
<thead>
<tr><th>ID</th><th onclick='col_hide(2)'>Chase</th><th onclick='col_hide(3)'>Date</th><th onclick='col_hide(4)'>Role</th><th onclick='col_hide(5)'>Reference</th><th onclick='col_hide(6)'>Day rate</th><th onclick='col_hide(7)'>Low salary</th><th onclick='col_hide(8)'>High salary</th><th onclick='col_hide(9)'>Via</th><th onclick='col_hide(10)'>Company</th><th onclick='col_hide(11)'>Agency</th><th onclick='col_hide(12)'>Contact name</th><th onclick='col_hide(13)'>Contact email</th><th onclick='col_hide(14)'>Status</th></tr>
</thead>
<tbody>
END;

while($line = $result->fetch_assoc()){

/* Tidy up the email address. Remove an spurious numbers in the middle of the email address. */
$edited_email = preg_replace("/.[0-9].*@/ui", "@", $line['contact_email']);

	if($line['follow_up']==TRUE){
		$follow_up = "Yes";
	} else {
		$follow_up = "No";
	}

	echo "<tr>\n";
	echo "<td class='centre'><a href='edit_job.php?id=$line[id]'>$line[id]</a></td><td class='centre'>$follow_up</td><td>$line[date_formated]</td><td>";
	
/* Only add the URL link if one exists in the database. */
	if($line['url']!=""){
		echo "<a href='".htmlentities($line['url'])."' target='_blank'>".substr($line['role'],0,COL_WIDTH_ROLE)."</a>";
	} else {
		echo substr($line['role'],0,COL_WIDTH_ROLE);
	}
	
	echo "</td><td>".substr($line['reference'],0,COL_WIDTH_REFERENCE)."</td><td>&pound;".number_format($line['day_rate'])."</td><td>&pound;".number_format($line['salary_low'])."</td><td>&pound;".number_format($line['salary_high'])."</td><td>$line[via]</td><td>$line[company]</td><td>".substr($line['agency'],0,COL_WIDTH_AGENCY)."</td><td>$line[first_name]&nbsp;$line[last_name]</td>";

	echo "<td><a href='mailto:$line[contact_email],$edited_email?subject=Reference:%20".htmlentities($line['reference'])."&amp;body=Dear%20$line[first_name]'>".substr($line['contact_email'],0,COL_WIDTH_EMAIL)."</a></td><td>$line[status]</td>\n";
	echo "</tr>\n\n";
}

echo "</tbody>\n</table>\n";
$result->free_result();

include_once("library/close.php");

echo "</div>\n"; /* Close content <div>. */
echo "</article>\n";

include_once("includes/footer.php");
?>