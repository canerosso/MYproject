<?php

	/**
	* 
	*/
	class DatabaseConnection 
	{

		public static function getDatabaseInstance($api_key){

			#Require 
			include_once dirname(__FILE__). '/Config.php';

			static $connection = null;
			if(null === $connection){

				 if (SERVER_API_KEY == $api_key){

					$host = "mysql:host=localhost;dbname=".SERVER_DB_NAME;
					$user = SERVER_DB_USERNAME;
				    $password = SERVER_DB_PASSWORD;
					$connection = new PDO($host, $user, $password);			
					$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$connection->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
					return $connection;
				}	

			}
			return $connection;	

		}
		
	}
?>