<?php
$title = $_GET['title'];
date_default_timezone_set('Europe/London');
$date = date('Y');

print<<<END
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="utf-8" />

<meta name="keywords" content="jobs,database,applications" />

<meta name="description" content="A web based application to keep track of job applications." />
<meta name="author" content="Mark E. Taylor" />
<meta name="copyright" content="&copy; 1995&mdash;$date Mark E. Taylor" />

<link href="css/style.css" rel="stylesheet" media="screen" type="text/css" />
<link href="css/forms.css" rel="stylesheet" media="screen" type="text/css" />
<link href="css/table.css" rel="stylesheet" media="screen" type="text/css" />
<link href="css/print.css" rel="stylesheet" media="print" type="text/css" />

<!-- The jQuery library. -->
<script src="http://code.jquery.com/jquery-latest.js" type="application/javascript"></script>

<title>Job Application System &mdash; $title</title>

</head>
END;
?>