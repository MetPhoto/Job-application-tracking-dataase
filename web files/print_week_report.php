<?php
/*
Author by: Mark E Taylor
Created: 25/09/2013
Last updated: 25/09/2013

Revision history: 
25/09/2013 - Initial creation.

Description: Prints the number of job applications per week for the current year.
*/

$_GET['title'] = 'Print date report';
include_once("includes/header-htmlhead.php");
include_once("includes/header-navigation.php");

echo "<article>\n<div class='content'>\n";

/* Print the applications. */
$year = date('Y');
$query = "SELECT WEEK(DATE,3) AS 'weekno', COUNT(1) AS 'applications', MONTHNAME(date) as 'month' FROM ".APP_TABLE." WHERE YEAR(DATE)=$year GROUP BY WEEK(DATE,3)";
$result = $database_object->query($query);

echo "<p>Summary of the job applications for each week in ${year}.</p>\n";
echo "<p>Reported printed on: ".date('l jS F').".</p>\n";

echo "<table id='summary'>\n";
echo "<tr><th>Week</th><th>Month</th><th>Number</th></tr>\n";

while($line = $result->fetch_assoc()){
	echo "<tr>";
	echo "<td class='centre'>$line[weekno]</td><td>$line[month]</td><td class='centre'>$line[applications]</td>";
	echo "</tr>\n";
}

$query = "SELECT count(id) as 'total' FROM ".APP_TABLE." WHERE YEAR(DATE)=2013";
$result = $database_object->query($query);
$line = $result->fetch_assoc();
echo "<tr><td>&nbsp;</td><td class='centre'>Total</td><td class='centre'>$line[total]</td></tr>";
$result->free_result();

echo "</table>\n";

echo "<input type='button' onClick='print()' value='Print report'>";

include_once("library/close.php");

echo "</div><!-- End of content. -->\n</article>\n";

include_once("includes/footer.php");
?>