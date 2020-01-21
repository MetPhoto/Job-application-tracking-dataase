<?php
/*
Author by: Mark E Taylor
Created: 08/10/2012
Last updated: 01/11/2012

Revision history: 
08/10/2012 - Initial creation.
12/10/2012 - Updated to use first and last name rather than contact name.
01/11/2012 - Changed code to decode either $_GET or $_POST.

Description: Displays the results of the search and allows the results to be edited.
*/

$_GET['title'] = 'Search results';
include_once("includes/header-htmlhead.php");
/* The connection to the database is made in the HTML navigation file, 'header-navigation.php' . */
include_once("includes/header-navigation.php");

$search_fields = array();

/* !Decode $_GET. The page 'print_duplicate_report.php' will always call this page in the form search_job?reference=reference_number. */
if($_SERVER['REQUEST_METHOD']=='GET'){
	$search_fields = array('reference' => $_GET['reference']);
}

/* !Decode $_POST. The page 'print_date_report.php' will always $_POST a series of search terms.  */
/* Create a new array that contains only the valid search columns and the terms themselevs. */
if($_SERVER['REQUEST_METHOD']=='POST'){
	foreach($_POST as $column => $term){
		if($term<>""){
			$search_fields = $search_fields + array($column => $term);
		}
	}
}

/* !Loop through each of the search terms supplied in turn and perform the search and show the result. */
foreach($search_fields as $column => $term){
	echo "<p>The search term used: ".ucfirst($column)." = %$term%.</p>";

	$query = "SELECT * FROM ".APP_TABLE." WHERE $column LIKE UPPER(('%$term%'))";
	
	echo "<table id='summary'>";
echo "<thead><tr><th>Date</th><th>Role</th><th>Reference</th><th>Day rate</th><th>Low salary</th><th>High salary</th><th>Via</th><th>Company</th><th>First name</th><th>Last name</th><th>Contact email</th><th>Edit</th></tr><thead>\n<tbody>\n";
	$result = $database_object->query($query);
	while($line = $result->fetch_assoc()){

	echo "<tr>\n";
	echo "<td>".$line['date']."</td><td>";
	
/* !Only add the URL link if one exists in the database. */
	if($line['url']!=""){
		echo "<a href='$line[url]' target='_blank'>$line[role]</a></td>";
	} else {
		echo $line['role'];
	}
	
	echo "</td><td>$line[reference]</td><td>&pound;".number_format($line['day_rate'])."</td><td>&pound;".number_format($line['salary_low'])."</td><td>&pound;".number_format($line['salary_high'])."</td><td>$line[via]</td><td>$line[company]</td><td>$line[first_name]</td><td>$line[last_name]</td><td>";
	
	echo "<a href='mailto:$line[contact_email]?subject=Reference: $line[reference]&body=Dear $line[first_name],'>$line[contact_email]</a></td>\n";
	
/* !Add a tiny form containing an 'edit' button. */
	echo "<td><form method='post' action='edit_job.php'>";
	echo "<input name='id' type='hidden' value='$line[id]'>";
	echo "<input type='submit' value='Edit'>";
	echo "</form></td>";
	
	echo "</tr>\n";
}

echo "</tbody></table>\n";

} /* End of foreach loop. */
$result->free_result();

include_once("includes/footer.php");
?>