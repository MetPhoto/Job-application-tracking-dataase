<?php
/*
Author by: Mark E Taylor
Created: 06/10/2012
Last updated: 26/04/2013

Revision history: 
06/10/2012 - Initial creation.
26/04/2013 - Updated to print out 'events' as well as 'applications'.

Description: Prints job applications and 'events' over the given period.
*/

$_GET['title'] = 'Print date report';
include_once("includes/header-htmlhead.php");
include_once("includes/header-navigation.php");

echo "<article>\n<div class='content'>\n";

/* Get the dates stored in the $_POST array, submitted by 'report.php'. */
$date_from = $_POST['date_from'];
$date_to	 = $_POST['date_to'];

/* Convert the date to a date object */
$date_from = new DateTime($date_from);
$date_to   = new DateTime($date_to);

/* Calculate the difference between the two dates. */ 
$days = $date_from->diff($date_to);
/* See http://php.net/manual/en/dateinterval.format.php */
$days2 = $days->format('%a');

/* Print the applications. */
$query = "SELECT date,role,reference,location,via,agency,company FROM ".APP_TABLE." WHERE DATE >=(CURDATE() - INTERVAL $days2 DAY)";
$result = $database_object->query($query);
$i = 1;

echo "<p>Summary of the job applications from ".$date_from->format('d/m/Y')." to ".$date_to->format('d/m/Y').".</p>\n";
echo "<p>Reported printed on: ".date('l jS F').".</p>\n";

echo "<table id='summary'>\n";
echo "<tr><th>No.</th><th>Date</th><th>Role</th><th>Reference</th><th>Location</th><th>Via</th><th>Agency</th><th>Company</th></tr>\n";

while($line = $result->fetch_assoc()){
	echo "<tr>";
	echo "<td class='centre'>$i</td><td>$line[date]</td><td>".substr($line['role'],0,COL_WIDTH_ROLE)."</td><td>$line[reference]</td><td>$line[location]</td><td>$line[via]</td><td>$line[agency]</td><td>$line[company]</td>";
	echo "</tr>\n";
	$i++;
}
$result->free_result();

echo "</table>\n";

/* Print the 'events'. */
$query = "SELECT date, eventdetails FROM ".ACTIVITY_TABLE." WHERE DATE >=(CURDATE() - INTERVAL $days2 DAY)";
$result = $database_object->query($query);
$i = 1;

echo "<p>Summary of other activities from ".$date_from->format('d/m/Y')." to ".$date_to->format('d/m/Y').".</p>\n";

echo "<table id='summary'>\n";
echo "<tr><th>No.</th><th>Date</th><th>Activity</th></tr>\n";

while($line = $result->fetch_assoc()){
	echo "<tr>";
	echo "<td class='centre'>$i</td><td>$line[date]</td><td>".substr($line['eventdetails'],0,COL_WIDTH_ACTIVITY)."</td>";
	echo "</tr>\n";
	$i++;
}
$result->free_result();

echo "</table>\n";

echo "<input type='button' onClick='print()' value='Print report'>";

include_once("library/close.php");

echo "</div><!-- End of content. -->\n</article>\n";

include_once("includes/footer.php");
?>