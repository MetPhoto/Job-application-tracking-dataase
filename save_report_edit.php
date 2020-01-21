<?php
/*
Author by: Mark E Taylor
Created: 21/10/2013
Last updated: 21/10/2013

Revision history: 
21/10/2013 - Initial creation.

Description: Saves an edited report and returns to the summary page (index.php).
*/

include_once("library/config.php");
include_once("library/open.php");
include_once("load_config.php");

$newreportname = $_POST['reportname'];

/* Show debug information if DONT_SAVE_REPORT=1.  */
if(DONT_SAVE_REPORT){
	echo "<p>'Save report' turned on, so the edited report will not be saved to the database.</p>";
	echo "Edited report name: $newreportname.<br/>";
	echo "Edited report number: $_POST[reportnumber].<br/>";
}

/* **** The reports table. **** */
$reports_query = "UPDATE ".REPORTS_TABLE." SET report_name='$_POST[reportname]', select_statement='$_POST[select]', select_parameter1='$_POST[parameter1]', select_parameter2='$_POST[parameter2]', select_parameter3='$_POST[parameter3]' WHERE report_number='$_POST[reportnumber]'";

/* Update the reports table. Only if DONT_DONT_SAVE_REPORT=0. */
if(DONT_SAVE_REPORT){
		echo "<p>Reports table.</p>";
		echo $reports_query."<br/>";
		echo "The '".REPORTS_TABLE."' table was not updated.<br/>";
} else {
		$result = $database_object->query($reports_query);	
}

/* **** The headers table. **** */
$display_order = 1;
foreach($_POST['header'] as $value){
	$headers_query = "UPDATE ".REPORT_HEADER_TABLE." SET header_name='$value',comment='$_POST[reportname]' WHERE report_number='$_POST[reportnumber]' AND header_order='$display_order'";
	$display_order = $display_order + 1;
	
/* Update the report_header table. Only if DONT_SAVE_REPORT=0. */
	if(DONT_SAVE_REPORT){
		echo "<p>Headers table.</p>";
		echo $headers_query."<br/>";
		echo "The '".REPORT_HEADER_TABLE."' table was not updated.<br/>";
	} else {
		$result = $database_object->query($headers_query);		
	}
}

/* **** The cells table. **** */
$cell_order = 1;
foreach($_POST['cell'] as $value){
	$coded_value = htmlspecialchars($value);
	$cells_query = "UPDATE ".REPORT_CELLS_TABLE." SET cell_format='$coded_value' WHERE report_number='$_POST[reportnumber]' AND cell_order=$cell_order";
	$cell_order = $cell_order + 1;
	
/* Update the report_cells table. Only if DONT_SAVE_REPORT=0. */
	if(DONT_SAVE_REPORT){
		echo "<p>Cells table.</p>";
		echo $cells_query."<br/>";
		echo "The '".REPORT_CELLS_TABLE."' table was not updated.<br/>";
	} else {
		$result = $database_object->query($cells_query);		
	}
}

/* Exit early if DONT_SAVE_REPORT=1. */
if(DONT_SAVE_REPORT){
		echo "<br/>Exiting early!";
		exit(99);
	} else {
		include_once("library/close.php");
		header('location: index.php');
	}
?>