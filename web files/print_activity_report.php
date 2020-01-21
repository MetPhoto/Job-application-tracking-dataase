<?php
/*
Author by: Mark E Taylor
Created: 29/05/2013
Last updated: 29/05/2013

Revision history: 
29/05/2013 - Initial creation.

Description: Prints 'events' over the last 'ACTIVITY_DAYS' days.
*/

$_GET['title'] = 'Print activity report';
include_once("includes/header-htmlhead.php");
include_once("includes/header-navigation.php");

echo "<article>\n<div class='content'>\n";

/* !Print the 'events'. */
$query = "SELECT date, eventdetails, DATE_FORMAT(TIMESTAMP,'%H:%i%p') AS time FROM ".ACTIVITY_TABLE." WHERE DATE >=(CURDATE() - INTERVAL ".ACTIVITY_DAYS." DAY)";
$result = $database_object->query($query);
$i = 1;

echo "<p>Summary of other activities from the last ".ACTIVITY_DAYS." days.</p>\n";

echo "<table id='summary'>\n";
echo "<tr><th>No.</th><th>Date</th><th>Time</th><th>Activity</th></tr>\n";

while($line = $result->fetch_assoc()){
	echo "<tr>";
	echo "<td class='centre'>$i</td><td>$line[date]</td><td>$line[time]</td><td>".substr($line['eventdetails'],0,COL_WIDTH_ACTIVITY)."</td>";
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