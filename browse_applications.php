<?php 
/*
Author by: Mark E Taylor
Created: 06/12/2013
Last updated: 06/12/2013

Revision history: 
06/12/2013 - Initial creation.

Description: Shows a 'page' of the applications stored in the database.
*/
session_start();

$_GET['title'] = 'Browse';
include_once("includes/header-htmlhead.php");
/* !The connection to the database is made in the HTML navigation file, 'header-navigation.php' . */
include_once("includes/header-navigation.php");

echo "<article>\n<div class='content'>";

/* !Calculate the total number of pages. */
/* The total number of applications, count(*) as some columns may be blank. */
$query = "SELECT count(*) AS count FROM ".APP_TABLE;
$result = $database_object->query($query);
$row = $result->fetch_assoc();
$number_of_jobs = $row['count'];
$total_pages = floor($number_of_jobs / BROWSE_NUMBER);

/* !Get the requested page number and calculate the 'skip' number. */
if(empty($_GET['page'])){
	$page = 0;
} else {
	$page = $_GET['page'];
}

if(!empty($_POST['page'])){
	$page = $_POST['page'];
}

$skip = $page * BROWSE_NUMBER;

$next_page = $page + 1;
$previous_page = $page - 1;

echo "<p>Page $page of $total_pages.</p>";

/* !Show the next page link only if the current page is < $total_pages. */
if($page < $total_pages){
	echo "<p><a href='browse_applications.php?page=$next_page'>Next page</a>.</p>";
}

/* !Show the previous page link only if the current page is > 0. */
if($page >0){
	echo "<p><a href='browse_applications.php?page=$previous_page'>Previous page</a>.</p>";
}

print<<<END
<p>
<form action='browse_applications.php' method='post' id='met-form'>
<input type='number' value='$page' max='$total_pages' min='0' name='page'>
<input type='submit' title='Goto page' value='Goto page'>
</form>
</p>
END;

/* !Start of the table that shows the page of applicaitons. Starting at $skip and limited by BROWSE_NUMBER.  */
$query = "SELECT id, DATE_FORMAT(date, '%d/%m/%y') AS date_formated, role, reference, via, company, contact_name, contact_email, url, agency, status, last_name, first_name FROM ".APP_TABLE." ORDER BY ID LIMIT $skip,".BROWSE_NUMBER;
$result = $database_object->query($query);

print<<<END
<table id='summary'>
<thead>
<tr><th>ID</th><th>Date</th><th>Role</th><th>Reference</th><th>Via</th><th>Company</th><th>Agency</th><th>Contact name</th><th>Contact email</th><th>Status</th></tr>
</thead>
<tbody>
END;

while($line = $result->fetch_assoc()){

/* !Tidy up the email address. Remove an spurious numbers in the middle of the email address. */
$edited_email = preg_replace("/.[0-9].*@/ui", "@", $line['contact_email']);

	echo "<tr>\n";
	echo "<td class='centre'><a href='edit_job.php?id=$line[id]'>$line[id]</a></td><td>$line[date_formated]</td><td>";
	
/* !Only add the URL link if one exists in the database. */
	if($line['url']!=""){
		echo "<a href='".htmlentities($line['url'])."' target='_blank'>".substr($line['role'],0,COL_WIDTH_ROLE)."</a>";
	} else {
		echo substr($line['role'],0,COL_WIDTH_ROLE);
	}
	
	echo "</td><td>".substr($line['reference'],0,COL_WIDTH_REFERENCE)."</td><td>$line[via]</td><td>$line[company]</td><td>".substr($line['agency'],0,COL_WIDTH_AGENCY)."</td><td>$line[first_name]&nbsp;$line[last_name]</td>";

	echo "<td><a href='mailto:$line[contact_email],$edited_email?subject=Reference:%20".htmlentities($line['reference'])."&amp;body=Dear%20$line[first_name]'>".substr($line['contact_email'],0,COL_WIDTH_EMAIL)."</a></td><td>$line[status]</td>\n";
	echo "</tr>\n\n";
}

echo "</tbody>\n</table>\n";
$result->free_result();

include_once("library/close.php");

echo "</div>\n"; /* Close the content <div>. */
echo "</article>\n";

include_once("includes/footer.php");
?>