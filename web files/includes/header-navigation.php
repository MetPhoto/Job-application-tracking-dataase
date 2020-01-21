<body>
<!--
Web page created by Mark Taylor.
For the Jobs project.
http://fastpi/jobs/

Created: 06/10/2012
Last updated: 01/01/2014

Revision history: 
06/10/2012 - Initial creation.
27/04/2013 - Updated with drop down menus.
29/09/2013 - Created a database driven repors system, so a lot of reports are now redundant.
01/01/2014 - Code futher updated to correctly report on job application from the last weeks of the previous year.
-->
<!-- <div class="content"> -->
<a href="../portal.php" title="Back to portal"><div class="portal">Portal</div></a>
<nav>
	<div>
	<div class="headline" title="Job Application System">Job Application System</div>
		<ul>
		<li><a href="index.php" title="Summary" <?php if(basename($_SERVER['SCRIPT_NAME'])=='index.php') {echo 'class="current"';} ?>>Summary</a></li>
		<li><a href="browse_applications.php" title="Browse applications" <?php if(basename($_SERVER['SCRIPT_NAME'])=='browse_applications.php') {echo 'class="current"';} ?>>Browse</a></li>
		
		<!-- Sub menu for the 'add' options. The regex in the first item will insert the CSS class 'current' whenever a page starting with 'add' is selected. -->
		<li><a href="#" title="Add records" <?php if(preg_match("/add/u",basename($_SERVER['SCRIPT_NAME']))) {echo 'class="current"';} ?>>Add</a>
			<ul>
				<li><a href="add_job.php" title="Add application">Add application</a></li>		
				<li><a href="add_activity.php" title="Add activity">Add activity</a></li>
				<li><a href="add_cv.php" title="Add CV">Add CV</a></li>
				<li><a href="add_file.php" title="Add file">Add file</a></li>
				<li><a href="add_reports.php" title="Add report">Add report</a></li>
				<li><a href="add_alarm.php" title="Add alarm">Add alarm</a></li>
			</ul>
		</li>
		
		<li><a href="search.php" title="Search"	<?php if(basename($_SERVER['SCRIPT_NAME'])=='search.php'||basename($_SERVER['SCRIPT_NAME'])=='search_job.php') {echo 'class="current"';} ?>>Search</a></li>

<!-- Sub menu for the preconfigured reporting options. The regex in the first item will insert the CSS class 'current' whenever a page ending in 'report.php' is selected. -->
		<li><a href="#" title="Preset reporting options" <?php if(preg_match("/report.php/u",basename($_SERVER['SCRIPT_NAME']))) {echo 'class="current"';} ?>>System reports</a>
			<ul>
			<li><a href="date_report.php" title="Date report">Date report</a></li>
			<li><a href="print_activity_report.php" title="Activity report">Activity report</a></li>
			<li><a href="print_duplicate_report.php" title="Duplicate report">Duplicate report</a></li>
<!-- 			<li><a href="print_report.php?reportnumber=3"	title="Contract roles">Contract roles report</a></li> -->
<!-- 			<li><a href="print_report.php?reportnumber=2"	title="Follow Up report">Follow Up report</a></li> -->
<!-- 			<li><a href="print_report.php?reportnumber=1"	title="In Progress report">In Progress report</a></li> -->
<!-- 			<li><a href="print_report.php?reportnumber=0"	title="Spoke to agency report">Spoke to agency report</a></li> -->
<!-- 			<li><a href="print_week_report.php"	title="Applications per week report">Applications per week</a></li> -->
<!-- 			<li><a href="show_files_report.php" title="Show files stored">Stored files</a></li> -->
			</ul>
		</li>

<!-- Sub menu for the 'user' created reports. The regex in the first item will insert the CSS class 'current' whenever a page ending in 'report.php' is selected. -->
		<li><a href="#" title="User reporting options" <?php if(preg_match("/user/u",basename($_SERVER['SCRIPT_NAME']))) {echo 'class="current"';} ?>>User reports</a>
			<ul>
			<?php
			/* !Connect to the MySQL database. */
			include_once("library/config.php");
			include_once("library/open.php");

			$query = "SELECT report_number,report_name FROM reports ORDER BY displayorder";
			$result = $database_object->query($query);
			while($line = $result->fetch_assoc()){
				$reportnumber = $line['report_number'];
				$report_name = $line['report_name'];
				echo "<li><a href='user_report_generic.php?reportnumber=$reportnumber'	title='$report_name - $reportnumber'>$report_name</a></li>";
				}
			?>
			</ul>
		</li>
				
		<li><a href="edit_config.php" title="Edit configuration" <?php if(basename($_SERVER['SCRIPT_NAME'])=='edit_config.php') {echo 'class="current"';} ?>>Configuration</a></li>
		</ul>
	</div>
</nav>

<canvas id="sparkline" class="spark" title="Job applications over the last five weeks." width="132" height="60"></canvas>

<?php
/* !Load some constants. Only define if they are not already defined. */
if(!defined('AAA_APPLICATION_CONSTANTS_DEFINED')){
	include_once("load_config.php");
}

/* !Populate the <div> with the ID 'appdata' with the nunber of applications made each week.

These values are later read by the JavaScript code to populate the sparkline like graph at the top of the page.

This code creates an array of 5 numbers. Each element of the array corrosponds to a week number.
Starting at the current week number and going back four further weeks.
For example for week 16 the array $week_number_array[] would contain the numbers, 12,13,14,15,16.

There are 4 special cases that accomadate the start of a new year, i.e. when week number is less than 5.
In these cases the $number_week_array is set manually to include the highest week numbers of the previous year.
Unsure if this works for leap years!

January 1st 2014
The code did not correctly take into account the fact that the year number was one less than the current year number for weeks greater than 48; i.e. the last few weeks of the previous year.
The code was updatd to subtract 1 from $year_number if the week being reported on was > 48
*/

$week_number = date('W');
$year_number = date('Y');
$week_data = array();

switch ($week_number) {
  case 1:
    $week_number_array = array(49, 50, 51, 52,  1);
    break;
  case 2:
    $week_number_array = array(50, 51, 52,  1,  2);
    break;
  case 3:
    $week_number_array = array(51, 52,  1,  2,  3);
    break;
  case 4:
    $week_number_array = array(52,  1,  2,  3,  4);
    break;
    /* The default array would be a list of week numbers starting at the current week and going back for 4 previous week numbers. */
  default:
    for($w=4;$w>=0;$w--){
      $week_number_array[$w]=$week_number;
      $week_number--;
	  }
}

/* !Place the total number jobs applied for in each week into the array $week_data[]. */
for($w=4; $w>=0; $w--){
	/* Set the year number to be last year if week number is less than 4. A kludge to make the report show last year's data. */
		if($week_number_array[$w]<=4){
			$yn = $year_number - 1;
		} else {
			$yn = $year_number;
		}
	$query = "SELECT count(id) FROM ".APP_TABLE." WHERE WEEKOFYEAR(DATE)=$week_number_array[$w] AND YEAR(DATE)=$yn";
// 	echo "Query $query\n";
	$result = $database_object->query($query);
	$row = $result->fetch_row();
	$week_data[$w] = $row[0];
}

/* The number of job applications stored in the data elements (data-weekN) is read by the JavaScript code that creates the sparkline style graph at the top of each page. */
echo "<div id='appdata' data-week0=$week_data[0] data-week1=$week_data[1] data-week2=$week_data[2] data-week3=$week_data[3] data-week4=$week_data[4]></div>\n";

?>