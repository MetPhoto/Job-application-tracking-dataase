<?php 
/*
Author by: Mark E Taylor
Created: 08/10/2012
Last updated: 08/10/2012
Revision history: 
08/10/2012 - Initial creation.

Description: Searches the job applicaiton database.
*/

$_GET['title'] = 'Search/Edit';
include_once("includes/header-htmlhead.php");
include_once("includes/header-navigation.php");

print<<<END
<article>
<div class="content">

<p>Search the job applications:</p>

<form action="search_job_results.php" method="post" id="met-form">

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
	&pound;<input type="number" name="day_rate" min='50' max='2000'>
	
	<label>Salary low</label>
	&pound;<input type="number" name="salary_low" min='10000' max='200000'>

	<label>Salary high</label>
	&pound;<input type="number" name="salary_high" min='10000' max='200000'>
</fieldset>

<fieldset title="Agency">
	<legend>Contact details</legend>
	<label>Via</label>
	<input type="text" list="via" name="via"><datalist id="via"><option value="TotalJobs"><option value="JobSite"><option value="BCS"></datalist>	

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
</fieldset>

<fieldset title="Notes">
	<legend>Notes</legend>
	<textarea name="notes" cols="40" rows="5"></textarea>
</fieldset>

<input type="submit" title="Search" value="Search records" class="clearfix">
</form>

</div> <!-- End of content. -->
</article>
END;

include_once("includes/footer.php");
?>