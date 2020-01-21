<?php 
/*
Author by: Mark E Taylor
Created: 13/11/2013
Last updated: 13/11/2013

Revision history: 
13/11/2013 - Initial creation.


Description: Allows a user to confirm the deletion of a job application before it happens.
*/

$_GET['title'] = 'Confirm application deletion';
include_once("includes/header-htmlhead.php");
/* The connection to the database is made in the HTML navigation file, 'header-navigation.php' . */
include_once("includes/header-navigation.php");

echo "<article>\n<div class='content'>\n";
echo "<p>Are you sure you want to delete this application?</p>\n";
echo "<p>This will also delete an associated 'activities' and uploaded files.</p>\n";

$id = $_REQUEST['applicationid'];

$query = "SELECT * FROM ".APP_TABLE." WHERE id=$id";
$result = $database_object->query($query);
$line = $result->fetch_assoc();

echo "<table id='summary'>\n";
echo "<thead><tr><th>Delete</th><th>Date</th><th>Role</th><th>Reference</th><th>Company</th><th>Agency</th><th>Job ID</th></tr></thead>\n";
echo "<tbody><tr>
			<td><form action='delete_application.php' method='post'><input name='id' type='hidden' value=$id><input type='submit' value='Delete'></form></td>
			<td>$line[date]</td>
			<td>$line[role]</td>
			<td>$line[reference]</td>
			<td>$line[company]</td>
			<td>$line[agency]</td>
			<td class='centre'>$line[id]</td>\n";
echo "</tr></tbody></table>\n";

$result->free_result();
include_once("library/close.php");

print<<<END
<form action='edit_job.php?id=$id' method='post'>
<input type='submit' value='Cancel'>
</form>
END;

echo "</div><!-- End of content. -->\n</article>\n";

include_once("includes/footer.php");
?>