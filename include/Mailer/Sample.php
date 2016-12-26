<?php

	require_once 'Config.php';
	require_once 'DatabaseConnection.php';	
	require_once 'Crud.php';


/**
* 
*/
class Sample extends Crud
{
	# instance variable
	var $databaseConnection;

	function __construct()
	{
		# database connection code
		$this->databaseConnection = DatabaseConnection::getDatabaseInstance(SERVER_API_KEY);


	}


}
?>