<?php 
/*
Author by: Mark E Taylor
Created: 17/10/2013
Last updated: 17/10/2013

Revision history: 
17/10/2013 - Initial creation.

Description: Edits an existing report.
*/


$_GET['title'] = 'Edit a report';
include_once("includes/header-htmlhead.php");
include_once("includes/header-navigation.php");
include_once("includes/creatdropdopdown.php");

/* Load some constants. */
include_once("load_config.php");
include_once("library/config.php");
include_once("library/open.php");

$report_number = $_GET['id'];

/* Get the base details about the report. */
$query = "SELECT * FROM ".REPORTS_TABLE." WHERE report_number=$report_number";
$result = $database_object->query($query);
$row = $result->fetch_assoc();

$report_name = $row['report_name'];
$select_statement = $row['select_statement'];
$select_parameter1 = $row['select_parameter1'];
$select_parameter2 = $row['select_parameter2'];
$select_parameter3 = $row['select_parameter3'];
$length1 = strlen($select_statement);

/* Get the details about the headers for the report. */
$query = "SELECT * FROM ".REPORT_HEADER_TABLE." WHERE report_number=$report_number ORDER BY header_order";
$result_headers = $database_object->query($query);

/* Get the details about the cells for the report. */
$query = "SELECT * FROM ".REPORT_CELLS_TABLE." WHERE report_number=$report_number ORDER BY cell_order";
$result_cells = $database_object->query($query);

include_once("library/close.php");

print<<<END
<article>
<div class="content">

<p>Basic guidence on how to edit an existing report.</p>
<p>
	<ul>
		<li>Type in a report name.</li>
		<li>Edit the select statement. The values of the placeholders will replace the tags %1\$s, %2\$s and %3\$s.</li>
		<li>Any unused select paramaters shoul be set to FALSE;</li>
		<li>Example parameters inlude the table name as a constant, e.g. APP_TABLE; or the current year DATE("Y");.</li>
		<li>Note that parameters should end in a semi-colomn (;).</li>
		<li>Note that parameters inside statements should be surrounded by double qoutes(") and not single quote(').</li>
		<li>Edit the headers. The first column in the report table will be an automatically incremented number.</li>
		<li>Edit the cells. These can include simple formating or more complex buttons or HTML links.</li>
		<li>The cell data will be placed where the %s appears. The cell data could appear more than once in a cell. Useful when creating links to edit records.</li>
	</ul>
</p>

<form action="save_report_edit.php" method="post" id="met-form">

<!-- This section will show information for the reports table. -->
<fieldset>
<legend>Report name: ($report_number)</legend>
	<input type='text' name='reportname' size=40 value='$report_name'>
	<input type='hidden' name='reportnumber' value=$report_number>
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
<td><input type='text' name='select' value="$select_statement" size='$length1'></td>
<td><input type='text' name='parameter1' value='$select_parameter1'></td>
<td><input type='text' name='parameter2' value='$select_parameter2'></td>
<td><input type='text' name='parameter3' value='$select_parameter3'></td>
</tr>
</tbody>
</table>
</fieldset>

<!-- This section will show inforamtion for the report_header table. -->
<fieldset>
<legend>Table headers</legend>
<caption>Headers - there should be one header for every column retrieved in the select statement. Minimum two columns.</caption>
<table id='summary' class='clearfix'>
<thead>
<tr name='headerheaders'>
END;

/* Loop through the results of the header table and create the cells to contain the results. */
for($i=1; $i<=$result_headers->num_rows; $i++){
	echo "<th>Header $i</th>";
}
echo "</tr>";
echo "<tbody>";
echo "<tr name='headercells'>";

while($row = $result_headers->fetch_assoc()){
	$length = strlen($row['header_name']);
/* 	If the length of the string is < 6 then set $length to 6. */
	$length<=6 ? $length=6 : $length=strlen($row['header_name']);
	echo "<td><input type='text' name='header[]' value='$row[header_name]' class='centre' size='$length'></td>";
}

print<<<END
</tr>
</tbody>
</table>
<input type='button' value='Add header' name='addheader'>
<input type='button' value='Remove header' name='removeheader'>
</fieldset>

<!-- This section will show inforamtion for the report_cells table. -->
<fieldset>
<legend>Table cells</legend>
<caption>Cells - there should be one cell for every column retrieved in the select statement. Minimum two cells.</caption>
<table id='summary' class='clearfix'>
<thead>
<tr name='cellheaders'>
END;

/* Loop through the results of the cells table and create the cells to contain the results. */
for($i=1; $i<=$result_cells->num_rows; $i++){
	echo "<th>Cell $i</th>";
}
echo "</tr>";
echo "<tbody>";
echo "<tr name='cellcells'>";

while($row = $result_cells->fetch_assoc()){
	$length = strlen($row['cell_format']);
	echo "<td><input type='text' name='cell[]' value='$row[cell_format]' size='$length' class='monospace'></td>";
}

print<<<END
</tr>
</tbody>
</table>
<input type='button' value='Add cell' name='addcell'>
<input type='button' value='Remove cell' name='removecell'>
</fieldset>

<input type="submit" title="Save report edit" value="Save report edit" class="clearfix">
</form>

</div> <!-- End of content. -->
</article>
END;

echo "<script src='js/setwidth.js' type='application/javascript'></script>";
include_once("includes/footer.php");
?>