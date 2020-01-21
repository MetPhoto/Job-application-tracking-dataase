<?php
/*
Author by: Mark E Taylor
Created: 05/10/2012
Last updated: 05/10/2012
Revision history: 
09/10/2012 - Initial creation.

Description: Holds variables used by the applicaiton.
*/

/*
define("DATABASE", "enviro");
define("RANDOM_HIGH", 3333); 

$dummy_name = "hello";
$dummy_number = 12;
*/

setlocale(LC_MONETARY, 'en_GB');

/* The database table that holds the job application data. */
$table = "applications";

/* Number of applications to show on the front screen. */
$summary_number = 20;
?>