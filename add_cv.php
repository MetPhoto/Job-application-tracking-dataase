<?php 
/*
Author by: Mark E Taylor
Created: 09/11/2012
Last updated: 09/11/2012

Revision history: 
09/11/2012 - Initial creation.

Description: Allows details of CVs to be saved.
*/

$_GET['title'] = 'Add CV';
include_once("includes/header-htmlhead.php");
/* The connection to the database is made in the HTML navigation file, 'header-navigation.php' . */
include_once("includes/header-navigation.php");

echo "<article>\n<div class='content'>\n";
echo "<p>Existing CVs in the database:</p>\n";

/* Get the highest existing CV number. */
$query = "SELECT MAX(number) AS number FROM ".CV_TABLE;
$result = $database_object->query($query);
$row = $result->fetch_array(MYSQLI_ASSOC);
$max_number = $row['number'] + 1;

$result->free_result();

$query = "SELECT * FROM ".CV_TABLE." ORDER BY number";
$result = $database_object->query($query);

echo "<table id='summary'><tbody>\n";
echo "<tr><th>No.</th><th>Name</th><th>Location</th><th>File name</th><th>Date added</th></tr>\n";

while($line = $result->fetch_array(MYSQLI_ASSOC)){
	$location = htmlspecialchars_decode($line['location'], ENT_QUOTES);
	echo "<tr><td class='centre'>$line[number]</td><td>$line[name]</td><td>$location</td><td>$line[file_name]</td><td>$line[date_last_saved]</td></tr>\n";
}
$result->free_result();

echo "</tbody></table>\n";
include_once("library/close.php");

print<<<END
<p>Add a new CV:</p>

<form action="save_cv.php" method="post" id="met-form">
<input type='hidden' name='number' value=$max_number>
<fieldset>
<legend>Add details for CV number $max_number:</legend>

<label>Name</label>
<input type='text' name='name' size='75'>

<label>File name</label>
<input type='text' name='file_name' size='75'>

<label>Location</label>

<input type="text" name="location" value="$location" size="75">

<input type='submit' value='+ Add CV'>
</fieldset>
</form>
END;

echo "</div><!-- End of content. -->\n</article>\n";

include_once("includes/footer.php");
?>