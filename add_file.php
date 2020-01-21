<?php 
/*
Author by: Mark E Taylor
Created: 09/07/2013
Last updated: 09/07/2013

Revision history: 
09/07/2013 - Initial creation.

Description: Allows files to be uploaded.

Note: The name 'userfile', used in the <input> statement will be the name of an array within $_FILES.
*/

$_GET['title'] = 'Add file';
include_once("includes/header-htmlhead.php");
/* The connection to the database is made in the HTML navigation file, 'header-navigation.php' . */
include_once("includes/header-navigation.php");

echo "<article>\n<div class='content'>\n";

/* Max file size in Kb. */
$max_file_size = MAX_UPLOADED_FILE_SIZE;
$max_file_size_display = $max_file_size / 1024;

if(isset($_REQUEST['applicationid'])){
	$applicationid = $_REQUEST['applicationid'];
} else {
	$applicationid = 0;
}

print<<<END
<form enctype="multipart/form-data" action="upload_file.php" method="post" id="met-form">
<input type="hidden" name="MAX_FILE_SIZE" value="$max_file_size" />
<fieldset>
<legend>Upload a new file, maximum size ${max_file_size_display}Kb</legend>

<label>Job ID:</label>
<input type='number' name='id' value='$applicationid' />

<input name="userfile" type="file" accept="pdf" />

<input type="submit" value="Upload File" />

<label>Description:</label>
<input name="description" type="text" size="41" value="Printed job advert." />
</fieldset>
</form>
END;

echo "</div><!-- End of content. -->\n</article>\n";

include_once("includes/footer.php");
?>