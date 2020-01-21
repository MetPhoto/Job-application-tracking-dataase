<?php
/*
Author by: Mark E Taylor
Created: 12/09/2013
Last updated: 12/09/2013

Revision history: 
12/09/2013 - Initial creation.

Description: Some common functions of the two factor authentication code.
*/

/* This function from here: http://uk3.php.net/manual/en/function.header.php */
function Redirect($Str_Location, $Bln_Replace = 1, $Int_HRC = NULL)
{
	if(!headers_sent())
	{
	  header('location: '.urldecode($Str_Location), $Bln_Replace, $Int_HRC);
	  exit;
	}	
		exit('<meta http-equiv="refresh" content="0; url='.urldecode($Str_Location).'"/>');
		return;
}

/* This function from here http://uk3.php.net/session_destroy */
function KillSession(){
/* Unset all of the session variables. See http://uk3.php.net/session_destroy */
$_SESSION = array();

/*
If it's desired to kill the session, also delete the session cookie.
Note: This will destroy the session, and not just the session data!
*/
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

/* Finally, destroy the session. */
session_destroy();
}

?>