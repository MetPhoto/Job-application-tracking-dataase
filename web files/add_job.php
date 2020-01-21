<?php 
/*
Author by: Mark E Taylor
Created: 06/10/2012
Last updated: 15/12/2019

Revision history: 
06/10/2012 - Initial creation.
07/10/2012 - Updated to create the drop down menu from data stored in the table 'dropdown'.
18/09/2013 - Updated to accomadate the newly added 'contract' field.
15/12/2019 - Small updates.

Description: Adds a job applicaiton record to the MySQL database.
*/

$_GET = array();
$_GET['title'] = 'Add application';
include_once("includes/header-htmlhead.php");
include_once("includes/header-navigation.php");
include_once("includes/creatdropdopdown.php");

/* Load some constants. */
include_once("load_config.php");
include_once("library/config.php");
include_once("library/open.php");

print<<<END
<article>
<div class="content">

<p>Add new application:</p>

<form action="save_job.php" method="post" id="met-form">

<fieldset title="Details">
	<legend>Details</legend>
	<label>Role</label>
	<input type="text" name="role" autofocus size="35">

	<label>Reference</label>
	<input type="text" name="reference" size="35">

	<label>Company</label>
	<input type="text" name="company" size="35">
	
	<label>Location</label>
	<input type="text" name="location" size="35">
	
	<label>URL</label>
	<input type="url" name="url" size="35">
</fieldset>

<fieldset title="Pay rates">
	<legend>Pay rates</legend>
	<label>Day rate</label>
	&pound;<input type="number" name="day_rate" min='0' max='2000'>
	
	<label>Contract?<input type='checkbox' name='contract' value='contract'></label>
	
	<label>Salary low</label>
	&pound;<input type="number" name="salary_low" min='0' max='200000'>

	<label>Salary high</label>
	&pound;<input type="number" name="salary_high" min='0' max='200000'>
</fieldset>

<fieldset title="Agency">
	<legend>Contact details</legend>
	<label>Via</label>
	<input type="text" list="via" name="via"><datalist id="via"><option value="TotalJobs"><option value="JobSite"><option value="BCS"><option value="LinkedIn"></datalist>	
	
	<label>Agency</label>
	<input type="text" name="agency">
		
	<label>First name</label>
	<input type="text" name="first_name">
	
	<label>Last name</label>
	<input type="text" name="last_name">
	
	<label>Contact email</label>
	<input type="email" name="contact_email">
	
	<label>Telephone</label>
	<input type="tel" name="telephone">
END;

/* Dynamically create the drop down menu. */
$menugroup = 1;
$default = "Submitted";
$label = "Status";
$menuname = "status";
$sucess = build_drop_down_menu($database_object, $menugroup, $default, $label, $menuname);

echo "<label>CV used</label>";
echo "<select name='cv'>";

/* Build the drop down menu for the list of CVs. */
$query = "SELECT location, file_name, number, name FROM ".CV_TABLE." ORDER BY number";
$result = $database_object->query($query);

while($line = $result->fetch_assoc()){
	echo "<option value='$line[number]'>$line[file_name]</option>";
}
$result->free_result();

echo "</select>";

print<<<END
	<label>Follow up?<input type="checkbox" name="follow_up" value="follow_up"></label>

</fieldset>

<fieldset title="Notes">
	<legend>Notes</legend>
	<textarea name="notes" cols="40" rows="5"></textarea>
</fieldset>

<input type="submit" title="Add" value="+ Add application" class="clearfix">
</form>

</div> <!-- End of content. -->
</article>
END;

include_once("includes/footer.php");
?>