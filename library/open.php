<?php
/*
Author by: Mark E Taylor
Created: 06/10/2012
Last updated: 10/03/2014

Revision history: 
06/10/2012 - Initial creation.
10/03/2014 - Added the line to set the character set used in the connection to the database.

Description: 
*/

$database_object = new mysqli($dbhost_MET, $dbuser_MET, $dbpass_MET, $dbname_MET);

if($database_object->connect_error){
    die("Error connecting to MySQL database, $dbname_MET. Error: ".$database_object->connect_error);
    exit(999);
}

/* http://stackoverflow.com/questions/4255022/mysql-storing-aaa-in-field http://uk3.php.net/manual/en/mysqli.set-charset.php */
$database_object->set_charset("utf8");
?>