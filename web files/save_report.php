<?php
/*
Author by: Mark E Taylor
Created: 05/10/2013
Last updated: 07/10/2013

Revision history: 
05/10/2013 - Initial creation.
07/10/2013 - Added debug code to stop the reports table being updated when testing the code.

Description: Saves a new report and returns to the summary page (index.php).
*/

include_once("library/config.php");
include_once("library/open.php");
include_once("load_config.php");

/* Calculate the highest display order for the new menu item, i.e the place in the menu where the new report will go. */
$query = "SELECT max(displayorder) AS do FROM ".REPORTS_TABLE;
$result = $database_object->query($query);
$row = $result->fetch_assoc();
$nextdisplayorder = $row['do']+1;

/* Set the report name to a value if it arrives blank. */
if($_POST['reportname']==""){
	$newreportname = "New report ".$_POST['reportnumber'];
} else {
	$newreportname = $_POST['reportname'];
}

if(SAVE_REPORT){
	echo "<p>Debug turned on, so the new report will not be saved to the database.</p>";
	echo "New report name: $newreportname.<br/>";
	echo "New report number: $_POST[reportnumber].<br/>";
}

/* **** The reports table. **** */
$coded_select = htmlspecialchars($_POST['select']);
$reports_query = "INSERT INTO ".REPORTS_TABLE." (report_number, report_name, select_statement, select_parameter1, select_parameter2, select_parameter3, displayorder) VALUE ('$_POST[reportnumber]', '$newreportname', '$coded_select', '$_POST[parameter1]', '$_POST[parameter2]', '$_POST[parameter3]', '$nextdisplayorder')";

/* Insert into the reports table. Only if SAVE_REPORT=0. */
if(SAVE_REPORT){
		echo "<p>Reports table.</p>";
		echo $reports_query."<br/>";
		echo "The '".REPORTS_TABLE."' table was not updated.<br/>";
} else {
		$result = $database_object->query($reports_query);	
}

/* **** The headers table. **** */
$display_order = 1;
foreach($_POST['header'] as $value){
	$coded_value = htmlspecialchars($value);
	$headers_query = "INSERT INTO ".REPORT_HEADER_TABLE." (report_number, header_name, header_order, comment) VALUE('$_POST[reportnumber]', '$codedvalue', '$display_order', '$newreportname')";
	$display_order = $display_order + 1;
	
/* Insert into the report_header table. Only if SAVE_REPORT=0. */
	if(SAVE_REPORT){
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
	$cells_query = "INSERT INTO ".REPORT_CELLS_TABLE." (report_number, cell_format, cell_order, comment) VALUE('$_POST[reportnumber]', '$coded_value', '$cell_order', '$newreportname')";
	$cell_order = $cell_order + 1;
	
/* Insert into the report_cells table. Only if SAVE_REPORT=0. */
	if(SAVE_REPORT){
		echo "<p>Cells table.</p>";
		echo $cells_query."<br/>";
		echo "The '".REPORT_CELLS_TABLE."' table was not updated.<br/>";
	} else {
		$result = $database_object->query($cells_query);		
	}
}

/* Exit early if SAVE_REPORT=1. */
if(SAVE_REPORT){
		echo "<br/>Exiting early!";
		exit(99);
	} else {
		include_once("library/close.php");
		header('location: index.php');
	}
?>