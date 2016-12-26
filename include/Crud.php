<?php

	require_once 'Config.php';
	require_once 'DatabaseConnection.php';

	/**
	* 
	*/
	class Crud 
	{

		var $databaseConnection;
		
		function __construct()
		{
			$this->databaseConnection = DatabaseConnection::getDatabaseInstance(SERVER_API_KEY);
		}

		/*
		* function : insert
		* @params : tablename - string 
		* @params : fields - array
		* @params : values - array
		* @return : boolean
		*/

		function insertData($table,$fields,$values){
                        
			$insertFields = '';

			# 1. Build fields
			if (is_array($fields)) {
				
				// loop 
				foreach ($fields as $key => $field) {
					# concatenation
					if ($key == 0) {
						# first value
						$insertFields .= $field;
					}else{
						# Remaining
					$insertFields .= ', '.$field;
					}
				}
			}else{
				# Only one value
				$insertFields .= $fields;
			}


			# 2. Build values

			$insertValues = '';

			if (is_array($values)) {
				# loop
				foreach ($values as $key => $value) {
					
					if($key == 0){
						# first
						$insertValues .= '?';
					}else{
						# remaining
						$insertValues .= ', ?';
					}
				}
			}else{

				$insertValues .= ':value';
			}
              // echo $table;
               //echo $insertFields;
               //echo $insertValues;
			# 3. Build Query
 $insertQuery = "INSERT INTO {$table} ( {$insertFields} ) VALUES ( {$insertValues})";
			//echo $insertQuery;
	   
			# 4. Prepared Statement
			$insertStatement = $this->databaseConnection->prepare($insertQuery);

			# 5. Execute
			if (is_array($values)) {
				$insertStatement->execute($values);
			}else{
				$insertStatement->execute(array(':value' => $values));
			}

			 $lastInsertId = $this->databaseConnection->lastInsertId();

			# 6. ErrorCheck
			$error = $insertStatement->errorInfo();
			
			if($error[1]){
				//print_r($error);
				return TAG_RESPONSE_FAIL;
			}else{
				//echo $lastInsertId;
				return $lastInsertId;
			}

		}



		/*
		* function : update
		* @params : tablename - string 
		* @params : fields - array
		* @params : values - array
		* @return : boolean
		*/

		function updateData($table,$fields,$values,$offset){

	 	$updateQuery = "UPDATE {$table} SET ";


			$to =  count($fields) - $offset;
			$from = 0;
			$where = array_slice($fields, $to, count($fields));
			$fields = array_slice($fields, $from, $to);


			$insertFields = '';

			# 1. Build fields
			if (is_array($fields)) {
				
				// loop 
				foreach ($fields as $key => $field) {
					# concatenation
					if ($key == 0) {
						# first value
						$insertFields .= $field.="=?";
					}else{
						# Remaining
						$insertFields .= ', '.$field.="=?";
					}
				}
			}else{
				# Only one value
				$insertFields .= $fields;
			}



			$whereClause = '';

			# 1. Build fields
			if (is_array($where)) {
				
				// loop 
				foreach ($where as $key => $clause) {
					# concatenation
					if ($key == 0) {
						# first value
						$whereClause .= $clause.="=?";
					}else{
						# Remaining
						$whereClause .= 'AND '.$clause.="=?";
					}
				}
			}else{
				# Only one value
				$whereClause .= $clause;
			}


			# 3. Build Query
		  $updateQuery .= $insertFields." WHERE ".$whereClause; 

		//echo "$updateQuery";
		//	exit();
			# 4. Prepared Statement
			$updateStatement = $this->databaseConnection->prepare($updateQuery);

			# 5. Execute
			if (is_array($values)) {
				$updateStatement->execute($values);
			}else{
				$updateStatement->execute(array(':value' => $values));
			}

			# 6. ErrorCheck
			$error = $updateStatement->errorInfo();
			if($error[1]){
				print_r($error);
				return TAG_RESPONSE_FAIL;
			}else{
				return TAG_RESPONSE_SUCCESS;
			}
			
		}

		/*
		* function : select
		* @params : tablename - string 
		* @params : fields - array or pass *
		* @params : values - array
		* @return : boolean
		*/

		function getData($table,$fields,$where,$orderBy){

			$selectQuery = "SELECT ";

			$selectFields = '';
			# 1. Build fields
			if (is_array($fields)) {
				
				// loop 
				foreach ($fields as $key => $field) {
					# concatenation
					if ($key == 0) {
						# first value
						$selectFields .= $field;
					}else{
						# Remaining
						$selectFields .= ', '.$field;
					}
				}
			}else{
				# Only one value
				$selectFields .= '*';
			}

			# Append Select Fields 
			$selectQuery .= $selectFields." FROM {$table} ";

			if (!empty($where)) {
				
				$whereClause = '';

				# 2. Build fields
				if (is_array($where)) {
					$isFlag = 0;
					// loop 
					foreach ($where as $key => $clause) {
						# concatenation
						if ($isFlag == 0) {
							# first value
							if (is_string($clause)) {
								$clause = '"'.$clause.'"';
							}
							$whereClause .= $key.="=$clause";
							$isFlag = 1;
						}else{
							# Remaining
							if (is_string($clause)) {
								$clause = '"'.$clause.'"';
							}
							$whereClause .= ' AND '.$key.="=$clause";
						}
					}
				}else{
					# Only one value
					if (is_string($clause)) {
						$clause = '"'.$clause.'"';
					}

					$whereClause .= $clause;
				}

				$selectQuery .= " WHERE ".$whereClause;
			}

			if (isset($orderBy) && is_array($orderBy)) {
				
				$selectQuery .= " ORDER BY ".key($orderBy)." ".$orderBy[key($orderBy)]; 
			}

 			//echo $selectQuery; die;
 			
			# 3. Prepared Statement
			$selectStatement = $this->databaseConnection->prepare($selectQuery);

			# 4. Execute
			$selectStatement->execute();
			
			# 5. ErrorCheck
			$error = $selectStatement->errorInfo();
			if($error[1]){
				print_r($error);
				return TAG_RESPONSE_FAIL;
			}else{
				return $selectStatement->fetchAll(PDO::FETCH_OBJ);
			}

		}
		public function excuteQuery($selectQuery){
			# 3. Prepared Statement
			//echo $selectQuery;


			$selectStatement = $this->databaseConnection->prepare($selectQuery);
			# 4. Execute
			
			$selectStatement->execute();
			# 5. ErrorCheck
			$error = $selectStatement->errorInfo();
			if($error[1]){
				print_r($error);
				return TAG_RESPONSE_FAIL;
			}else{
				return $selectStatement->fetchAll(PDO::FETCH_OBJ);
			}
		}

		public function excuteQuery1($selectQuery){
			# 3. Prepared Statement
			//echo $selectQuery;


			$selectStatement = $this->databaseConnection->prepare($selectQuery);
			# 4. Execute
			
			$selectStatement->execute();
			# 5. ErrorCheck
			//$error = $selectStatement->errorInfo();
			if($error[1]){
				print_r($error);
				return TAG_RESPONSE_FAIL;
			}else{
				return TAG_RESPONSE_SUCCESS;
			}
		}

		/*
		* function : update
		* @params : tablename - string 
		* @params : fields - array
		* @params : values - array
		* @params : where caluse - array
		* @return : boolean
		*/

		function updateData_Where($table,$fields,$values,$where,$offset){


	 	$updateQuery = "UPDATE {$table} SET ";


			$to =  count($fields) - $offset;
			$from = 0;
		//	$where = array_slice($fields, $to, count($fields));
			$fields = array_slice($fields, $from, $to);


			$insertFields = '';

			# 1. Build fields
			if (is_array($fields)) {
				
				// loop 
				foreach ($fields as $key => $field) {
					# concatenation
					if ($key == 0) {
						# first value
						$insertFields .= $field.="=?";
					}else{
						# Remaining
						$insertFields .= ', '.$field.="=?";
					}
				}
			}else{
				# Only one value
				$insertFields .= $fields;
			}


	if (!empty($where)) {
				
				$whereClause = '';

				# 2. Build fields
				if (is_array($where)) {
					$isFlag = 0;
					// loop 
					foreach ($where as $key => $clause) {
						# concatenation
						if ($isFlag == 0) {
							# first value
							if (is_string($clause)) {
								$clause = '"'.$clause.'"';
							}
							$whereClause .= $key.="=$clause";
							$isFlag = 1;
						}else{
							# Remaining
							if (is_string($clause)) {
								$clause = '"'.$clause.'"';
							}
							$whereClause .= ' AND '.$key.="=$clause";
						}
					}
				}else{
					# Only one value
					if (is_string($clause)) {
						$clause = '"'.$clause.'"';
					}

					$whereClause .= $clause;
				}

				$updateQuery .= $insertFields. " WHERE ".$whereClause;
			}
			else
			{
             
               $updateQuery .= $insertFields;  
            
			}


			# 3. Build Query
//		  $updateQuery .= $insertFields." WHERE ".$whereClause; 

			# 4. Prepared Statement
			$updateStatement = $this->databaseConnection->prepare($updateQuery);

			# 5. Execute
			if (is_array($values)) {
				$updateStatement->execute($values);
			}else{
				$updateStatement->execute(array(':value' => $values));
			
			}

		
		$error = $updateStatement->errorInfo();
		
			# 6. ErrorCheck
			
			if($error[1]){
				print_r($error);
				return TAG_RESPONSE_FAIL;
			}else{
				return TAG_RESPONSE_SUCCESS;
			}
			
		}


	}

?>
