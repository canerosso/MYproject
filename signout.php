<?php

	
	error_reporting(-1);
	ini_set('display_errors', 'On');
	session_start();
	// Unset all of the session variables.
	$_SESSION = array();
	header("Location: index.php");	

?>