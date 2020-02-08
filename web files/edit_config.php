<?php 
/*
Author by: Mark E Taylor
Created: 10/10/2012
Last updated: 08/02/2020

Revision history: 
10/10/2012 - Initial creation.
28/04/2013 - Added new configuration item SUMMARY_REPORTING_DAYS.
07/12/2013 - Added new configuration item BROWSW_NUMBER.
24/02/2014 - Added section to define when email updates are sent out or not.
08/02/2020 - Added an option to set the numbers of daya after which the status of any application is automatically set to 'Submitted and ignored'. 

Description: Sets configutation items for the application.

If a new config item needs to be added then first add it to the database and then update this form. No other code changes need to be made to the application, i.e. save_config.php does not need to be updated.

NOTE: The 'name' of any input (i.e. configuration) item needs to be the same as the value used in the config table in the 'item' column.
This is because the save_config.php file makes use this value as the key to updating the config table.
*/

$_GET['title'] = 'Configuration';
include_once("includes/header-htmlhead.php");
include_once("includes/header-navigation.php");

print<<<END
<article>
<div class="content">

<p>Update application configuration:</p>

<form action="save_config.php" method="post" id="met-form">

<fieldset title="configuration">
	<legend>Configuration</legend>
END;

echo "<label>Number of items on the summary page:</label>\n";
echo "<input type='number' name='summary_number' min=1 max=35 value=".SUMMARY_NUMBER.">\n";

echo "<label>Number of items on the browse pages:</label>\n";
echo "<input type='number' name='browse_number' min=1 max=35 value=".BROWSE_NUMBER.">\n";

echo "<label>Width of the 'email' column on the summary page:</label>\n";
echo "<input type='number' name='col_width_email' min=1 max=35 value=".COL_WIDTH_EMAIL.">\n";

echo "<label>Width of the 'role' column on the summary page:</label>\n";
echo "<input type='number' name='col_width_role' min=1 max=35 value=".COL_WIDTH_ROLE.">\n";

echo "<label>Width of the 'agency' column on the summary page:</label>\n";
echo "<input type='number' name='col_width_agency' min=1 max=35 value=".COL_WIDTH_AGENCY.">\n";

echo "<label>Width of the 'reference' column on the summary page:</label>\n";
echo "<input type='number' name='col_width_reference' min=1 max=30 value=".COL_WIDTH_REFERENCE.">\n";
	
echo "<label>Number of days to summarise on the summary page:</label>\n";
echo "<input type='number' name='summary_reporting_days' min=1 max=30 value=".SUMMARY_REPORTING_DAYS.">\n";

echo "<label>Number of days to summarise on the activity report:</label>\n";
echo "<input type='number' name='activity_days' min=1 max=30 value=".ACTIVITY_DAYS.">\n";

echo "<label>Width of the 'filename' column on the show files report page:</label>\n";
echo "<input type='number' name='col_width_filename' min=1 max=160 value=".COL_WIDTH_FILENAME.">\n";

echo "<label>Maximum size of files (PDFs) that can be uploaded in bytes:</label>\n";
echo "<input type='number' name='max_uploaded_file_size' min=1 max=".MAX_UPLOADED_FILE_SIZE." value=".MAX_UPLOADED_FILE_SIZE.">\n";

echo "<label>Days after which the status of an application should be changed to 'Submitted and ignored'</label>\n";
echo "<input type='number' name='update_status_days' min=1 max=20 value=".UPDATE_STATUS_DAYS.">\n";

echo "<label>Email address for the follow up emails:</label>\n";
echo "<input type='text' name='follow_up_email_address' size='30' value=".FOLLOW_UP_EMAIL_ADDRESS.">\n";

echo "<label>Send out email reminders on the following days:</label>\n";
echo "<div>";

/* The constant SEND_EMAIL_DAYS is a 'serialised' array retrieved from the 'config' database. */
/* Loop through this array and display a series of checkboxes. */
foreach(unserialize(SEND_EMAIL_DAYS) as $key => $value){
	if($value == 'yes'){
		$days_checked = 'checked';
	} else {
		$days_checked = '';
	}
	echo "<label>$key<input type='checkbox' $days_checked value='$key' name='days[]'></label>\n";
}

print<<<END
</div>
</fieldset>

<input type="submit" title="Update configuration" value="Update configuration" class="clearfix">
</form>

<p>Purge alarms older than today, you will not be prompted to confirm this request:</p>

<form action="purge_alarms.php" method="post" id="met-form">
	<input type="submit" title="Purge old alarm" value="Purge alarms" class="clearfix">
</form>

</div> <!-- End of content. -->
</article>
END;

include_once("includes/footer.php");
?>