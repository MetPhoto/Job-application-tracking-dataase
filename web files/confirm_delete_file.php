<?php 
/*
Author by: Mark E Taylor
Created: 12/07/2013
Last updated: 12/07/2013

Revision history: 
12/07/2013 - Initial creation.

Description: Allows a user to confirm the deletion of a file before it happens.
*/

$_GET['title'] = 'Confirm file deletion';
include_once("includes/header-htmlhead.php");
/* The connection to the database is made in the HTML navigation file, 'header-navigation.php' . */
include_once("includes/header-navigation.php");

echo "<article>\n<div class='content'>\n";
echo "<p>Are you sure you want to delete this file?</p>\n";

$id = $_REQUEST['id'];

$query = "SELECT * FROM ".UPLOADS_TABLE." WHERE id=$id";
$result = $database_object->query($query);
$line = $result->fetch_assoc();

$filesize = number_format($line['filesize']/1024,0);
$filename = substr($line['filename'],0,COL_WIDTH_FILENAME);

echo "<table id='summary'>\n";
echo "<thead><tr><th>Delete</th><th>Filename</th><th>File size</th><th>Date</th><th>Job ID</th></tr></thead>\n";
echo "<tbody><tr>
			<td><form action='delete_file.php' method='post'><input name='id' type='hidden' value=$id><input type='submit' value='Delete'></form></td>
			<td>$filename</td>
			<td>${filesize}Kb</td>
			<td>$line[dateuploaded]</td>
			<td class='centre'>$line[applicationid]</td>\n";
echo "</tr></tbody></table>\n";

$result->free_result();
include_once("library/close.php");

print<<<END
<form action='show_files_report.php' method='post'>
<input type='submit' value='Cancel'>
</form>
END;

echo "</div><!-- End of content. -->\n</article>\n";

include_once("includes/footer.php");
?>