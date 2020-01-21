<?php 
/*
Author by: Mark E Taylor
Created: 06/10/2013
Last updated: 07/10/2013

Revision history: 
06/10/2013 - Initial creation.
07/10/2013 - Finished.

Description: Adds a new report to the MySQL database.
*/

$_GET = array();
$_GET['title'] = 'Add a new report';
include_once("includes/header-htmlhead.php");
include_once("includes/header-navigation.php");
include_once("includes/creatdropdopdown.php");

/* Load some constants. */
include_once("load_config.php");
include_once("library/config.php");
include_once("library/open.php");

/* Calculate the next report number. */
$query = "SELECT MAX(report_number) AS rn FROM ".REPORTS_TABLE;
$result = $database_object->query($query);
$row = $result->fetch_assoc();
$newreportnumber = $row['rn']+1;
include_once("library/close.php");

print<<<END
<article>
<div class="content">

<p>Basic guidence on how to create a new report.</p>
<p>
	<ul>
		<li>Type in a report name.</li>
		<li>Edit the select statement. The values of the placeholders will replace the tags %1\$s, %2\$s and %3\$s.</li>
		<li>Any unused select paramaters shoul be set to FALSE;</li>
		<li>Example parameters inlude the table name as a constant, e.g. APP_TABLE; or the current year DATE("Y");.</li>
		<li>Note that parameters should end in a semi-colomn (;).</li>
		<li>Parameters inside statement should be surrounded by double qoutes(") and not single quote(').</li>
		<li>Edit the headers. The first column in the report table will be an automatically incremented number.</li>
		<li>Edit the cells. These can include simple formating or more complex buttons or HTML links.</li>
		<li>The cell data will be placed where the %s appears. The cell data could appear more than once in a cell. Useful when creating links to edit records.</li>
	</ul>
</p>

<form action="save_report.php" method="post" id="met-form">

<!-- This section will get information for the reports table. -->
<fieldset>
<legend>Report name: ($newreportnumber)</legend>
	<input type='text' name='reportname' size=40 value='New report $newreportnumber'>
	<input type='hidden' name='reportnumber' value=$newreportnumber>
</fieldset>

<fieldset>
<legend>Select statement</legend>
<caption>Note: display order will be calculated automatically. Any new report will be added to the bottom of the 'User reports' menu.</caption>
<table id='summary' class='clearfix'>
<thead>
<tr><th>Select query</th><th>Paramater 1</th><th>Paramater 2<th>Paramater 3</th></tr>
</thead>
<tbody>
<tr>
<td><input type='text' name='select' value='SELECT id, applicationid, LEFT(filename,%1\$s), FORMAT(filesize/1024,0), description, dateuploaded FROM %2\$s' size=120></td>
<td><input type='text' name='parameter1' value='UPLOADS_TABLE;' size=20></td>
<td><input type='text' name='parameter2' value='FALSE;' size=20></td>
<td><input type='text' name='parameter3' value='FALSE;' size=20></td>
</tr>
</tbody>
</table>
</fieldset>

<!-- This section will get inforamtion for the report_header table. -->
<fieldset>
<legend>Table headers</legend>
<caption>Headers - there should be one header for every column retrieved in the select statement. Minimum two columns.</caption>
<table id='summary' class='clearfix'>
<thead>
<tr name='headerheaders'>
<th>No.</th>
<th>Header 2</th>
<th>Header 3</th>
</tr>
<tbody>
<tr name='headercells'>
<td><input type='text' name='header[]' value='No.' class='centre'></td>
<td><input type='text' name='header[]' value='Job ID'></td>
<td><input type='text' name='header[]' value='Description'></td>
</tr>
</tbody>
</table>
<input type='button' value='Add header' name='addheader'>
<input type='button' value='Remove header' name='removeheader'>
</fieldset>

<!-- This section will get inforamtion for the report_cells table. -->
<fieldset>
<legend>Table cells</legend>
<caption>Cells - there should be one cell for every column retrieved in the select statement. Minimum two cells.</caption>
<table id='summary' class='clearfix'>
<thead>
<tr name='cellheaders'>
<th>No.</th>
<th>Cell 2</th>
<th>Cell 3</th>
</tr>
<tbody>
<tr name='cellcells'>
<td class='centre'>No.</td>
<td><input type='text' name='cell[]' value='<td>%s</td>'></td>
<td><input type='text' name='cell[]' value="<td class='centre'><a href='edit_job.php?id=%s'>%s</a></td>" size='115'></td>
</tr>
</tbody>
</table>
<input type='button' value='Add cell' name='addcell'>
<input type='button' value='Remove cell' name='removecell'>
</fieldset>

<input type="submit" title="Add" value="+ Add report" class="clearfix">
</form>

</div> <!-- End of content. -->
</article>
END;

include_once("includes/footer.php");
?>