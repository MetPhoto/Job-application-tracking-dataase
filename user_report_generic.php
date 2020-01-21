<?php
/*
Author by: Mark E Taylor
Created: 26/09/2013
Last updated: 06/10/2013

Revision history: 
26/09/2013 - Initial creation.
06/10/2013 - Small tweeks and documentation updates.

Description: A generalised reporting page. Based on the old reporting page, but made further generic with the select statements and header information stored in the database.
Usage: user_report_generic.php?reportnumber=nnn
*/

/* If the reportnumber is blank then set reportnumber to 999, which will cause the error message to be shown. */
if(!empty($_GET) && key($_GET)=='reportnumber'){
	$report_number = $_GET['reportnumber'];
} else {
	$report_number = 999;
}

$_GET['title'] = "Print report number ".$report_number;

include_once("includes/header-htmlhead.php");
include_once("includes/header-navigation.php");

/* !Get the maximum report number. */
$query = "SELECT MAX(report_number) AS 'report_number' from ".REPORTS_TABLE;
$result = $database_object->query($query);
$line = $result->fetch_assoc();
$maxreportnumber = $line['report_number']+1;
$result->free_result();

/* !If the report number is valid then display the report. Report numbers are in the range 101 to highest current report number. */
if($report_number > 100 && $report_number < $maxreportnumber){
	$_GET['title'] = "Print report number ".$report_number;

	echo "<article>\n<div class='content'>\n";
	$i=1;
	
/* !Get the 'report name'. 'select' statement  and 'parameters' for the selected report. */
	$query = "SELECT report_name, select_statement, select_parameter1, select_parameter2, select_parameter3 FROM ".REPORTS_TABLE." WHERE report_number=$report_number";
	$result = $database_object->query($query);
	$line = $result->fetch_assoc();
	$base_select_query = $line['select_statement'];
	$report_name = $line['report_name'];

/*
!Build the MySQL select statment by adding parameters to the base SELECT statement.	
The reason for doing this is to allow parameters to be set at run time.
For example the current year could be calculated at run time. $select_parameter2 = date('Y');
Other parameters could be constants, for example the name of the table to be interogated.

If a parameter is not needed then FALSE; needs to be stored in the MySQL database for that parameter.
NOTE: The parameter ends with a semicolon (;). This terminates the eval() statement.

Example 1: base SELECT statement, note the %s where the table name would normally be. $parameter1 = APP_TABLE;
$base_select_query = SELECT id,role,company,reference,date, FORMAT(salary_high,0),FORMAT(salary_low,0) FROM %s WHERE follow_up=TRUE

Example 2: base SELECT statement, note the %s where the table name would normally be. $parameter1 = UPLOADS_TABLE; AND $parameter2 = COL_WIDTH_FILENAME;
NOTE: Parameter2 is placed BEFORE Parameter1 in the combined SELECT statement.
$base_select_query = SELECT id, applicationid, LEFT(filename,%2$s), FORMAT(filesize/1024,0), description, dateuploaded FROM %1$s

The sprintf() function then merges $select_parameter1,2 and 3 into the $base_select_query.
For example a constant that is already defined as the name of a MySQL database table:
$line[select_parameter1] = APP_TABLE;

The three SELECT parameters that were retrieved from the database are now evaluated.
*/
	eval("\$select_parameter1 = $line[select_parameter1]");
	eval("\$select_parameter2 = $line[select_parameter2]");
	eval("\$select_parameter3 = $line[select_parameter3]");

/* !The base SELECT statement is combined with the three evaluated parameters. */
	$select_query = sprintf($base_select_query, $select_parameter1, $select_parameter2, $select_parameter3);

/* !Get information about the header for the requested report.  */
	$header_query = "SELECT header_name FROM ".REPORT_HEADER_TABLE." WHERE report_number=$report_number ORDER by header_order";
	$header_result = $database_object->query($header_query);

/* !Get the information about the cell formatting for the requested report. */
	$cell_query = "SELECT cell_format FROM ".REPORT_CELLS_TABLE." WHERE report_number=$report_number ORDER by cell_order";
	$cell_format_result = $database_object->query($cell_query);
			
/* !Get the actual data from the applications table. */
	$select_result = $database_object->query($select_query);
	
	if(DEBUG){
		echo "<p>Select statement for the select statement: <span class='debug'>$select_query</span></p>";
		echo "<p>Select statement for the cell statement: <span class='debug'>$cell_query</span></p>";
		echo "<p>Select parameters: <span class='debug'>1 = '$select_parameter1' 2 = '$select_parameter2' 3 = '$select_parameter3'</span></p>";
	}
		
	if($select_result->num_rows){
		echo "<p>Results for the report '$report_name' ($report_number). Click <a href='edit_report.php?id=$report_number' title='Edit this report'>here to edit</a> the format of this report.</p>\n";
	
		echo "<table id='summary'>\n";
		echo "<thead>\n";
		echo "<tr>";
		
/* Fetch each row of data from the header_row table and place the header name in the header row of the table. */
		while($row = $header_result->fetch_assoc()){
			echo "<th>$row[header_name]</th>";
		}
		echo "</tr>";
		echo "</thead>\n";
		echo "<tbody>\n";
		
/* Fetch each row of data from the table in the select statement and place the data in cells. */
		while($line = $select_result->fetch_assoc()){
/* First column is always the index column, an incremented number. */
			echo "<tr><td class='centre'>$i</td>";
/* Loop through the columns of data. */			
			foreach($line as $cell_data){
/* Get the format of the next cell. */
				$get_formatted_cell = $cell_format_result->fetch_assoc();

/* Combine the cell data (columns) with the cell formating information and display it. Two examples:
Example 1. Salary cell: $get_formatted_cell['cell_format']='<td>&pound;%s</td>' PLUS $cell_data='60,000' EQUALS <td>£60,000</td>
Example 2. Link to the job edit page: $get_formatted_cell['cell_format']=<td class='centre'><a href='edit_job.php?id=%1$s'>%1$s</a></td> PLUS $cell_data='1022' EQUALS <td class='centre'><a href='edit_job.php?id=1022'>1022</a></td>

NOTE: If only two items of infomation were retrieved by the SELECT statment BUT there were three headers and cells then NO data would be placed in the third cell.
*/
			/* The base cell statement is combined with the evaluated parameters. */
				echo sprintf(htmlspecialchars_decode($get_formatted_cell['cell_format']), $cell_data);
			}
			
/* At the end of the row of data then go back to the first item in the cell formatting result, i.e. the fist format. */
			$cell_format_result->data_seek(0);
			echo "</tr>\n";
			$i++;
		}
		echo "</tbody>\n</table>\n";
		} else {
			echo "<p>No data for the report '$report_name' ($report_number) at this time.</p>\n";
		}
	$result->free_result();
	} else {
	$_GET['title'] = "Invalid report number selected";
	include_once("includes/header-htmlhead.php");
	include_once("includes/header-navigation.php");

	echo "<article>\n<div class='content'>\n";
	echo "<p>Incorrect report number provided. Reports available are:</p>";
	/* Show the valid report names and numbers. */
	$query = "SELECT report_number,report_name FROM ".REPORTS_TABLE;
	$result = $database_object->query($query);
	while($line = $result->fetch_assoc()){
		echo "<p>$line[report_number] - $line[report_name]</p>";
	}
	$result->free_result();
}

include_once("library/close.php");

echo "</div><!-- End of content. -->\n</article>\n";

include_once("includes/footer.php");
?>