<?php
/*
Author by: Mark E Taylor
Created: 01/11/2012
Last updated: 21/12/2012

Revision history: 
01/11/2012 - Initial creation.
28/11/2012 - Updated so the text is all inside PHP. Added a date that is two weeks in the past to the 'from' date field.
21/12/2012 - Updated the date format in the input fields so they are no in the format YYYY-m-d.

Description: Allows the user to select a date range to create a report showing the jobs applied for over that range.
*/

$_GET['title'] = 'Date report';
include_once("includes/header-htmlhead.php");
include_once("includes/header-navigation.php");

date_default_timezone_set('Europe/London');
/* Subtract 14 days from today's date. */
/* See http://www.php.net/manual/en/class.dateinterval.php  */
$date 			= new DateTime();
$today			= $date->format('Y-m-d');
$date 			= $date->sub(new DateInterval('P14D'));
$two_weeks	= $date->format('Y-m-d');

print<<<END
<article>
<div class="content">

<p>Create a report over a date range:</p>

<form action="print_date_report.php" method="post" id="met-form">

<fieldset title="Date range">
	<legend>Date range - YYYY-MM-DD</legend>
	<label>From:</label>
	<input type="date" name="date_from" autofocus value=$two_weeks>

	<label>To:</label>
	<input type="date" name="date_to" value=$today>
</fieldset>

<input type="submit" title="Create report" value="Create report" class="clearfix">
</form>

</div> <!-- End of content. -->
</article>
END;

include_once("includes/footer.php");
?>