<?php
/*
Author by: Mark E Taylor
Created: 09/07/2013
Last updated: 10/09/2013

Revision history: 
09/07/2013 - Initial creation.
09/09/2013 - Updated to check the file type at upload.
10/10/2013 - Simplified the file type check, no longer uses REGEX.

Description: Uploads a file and stores it.

See http://www.php.net/manual/en/features.file-upload.post-method.php

Note: The array contained within $_FILES called 'userfile' is defined in the form that called this file. It can be any name.
*/

include_once("library/config.php");
include_once("library/open.php");

/* !Load some constants. Only define if they are not already defined. */
if(!defined('AAA_APPLICATION_CONSTANTS_DEFINED')){
	include_once("load_config.php");
}

/* The location of the folder the uploaded file will be moved to is defined by UPLOADS_FOLDER_ABSOLUTE_PATH. */
$uploadfile = UPLOADS_FOLDER_ABSOLUTE_PATH . basename($_FILES['userfile']['name']);
$id = $_POST['id'];
$filename = $_FILES['userfile']['name'];
$filesize = $_FILES['userfile']['size'];

/* The 'description' is passed to this routine by the form in add_file.php */
$description = $_REQUEST['description'];

/*
!Create an array containing the types of files that are allowed to be uploaded.
The array will contain values like 'application/msword'.
*/
$allowed_file_types = array();

/* !Get the valid file types from the database. */
$query = "SELECT type FROM ".FILETYPES_TABLE;
$result = $database_object->query($query);
while($row = $result->fetch_assoc()){
	$allowed_file_types[] = $row['type'];
}

/*
Use the finfo() function to get the MIME type of the uploaded file.
More reliable than using the file extension or $_FILES['userfile']['type'], which makes a guess of the MIME type based on the extension.
*/
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$filetype = finfo_file($finfo,$_FILES['userfile']['tmp_name']);

/* !Check if the file is valid, set a flag if it is. */
$valid_file = false;
/* Loop through each of valid types (stored in the $allowed_file_types array) and compare it to $filetype. */
foreach ($allowed_file_types as $key => $value) {
  if($filetype == $value){
    $valid_file = true;
    break;
  }
}

finfo_close($finfo);

/* !If the file type is allowed then... */
if($valid_file == true){
/* !Move the tempoary file to its final location. */
	if(move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)){

/* !Update the database with the information about the uploaded file. */
	$query = "INSERT INTO ".UPLOADS_TABLE." (applicationid, filename, filetype, filesize, description) VALUE('$id','$filename','$filetype','$filesize','$description')";
	$result = $database_object->query($query);

/* !Return to the upload page.*/
	header ('location: add_file.php');
	}
	
/* !If the file type is not allowed then display a message and exit. */
} else {
	echo "Not a valid file type!<br/>";
	echo "It is file type $filetype.";
	exit(1);
}

?>