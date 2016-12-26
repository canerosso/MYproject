<?php
//@session_start();
	require_once 'Config.php';
	require_once 'DatabaseConnection.php';	
	require_once 'Crud.php';
	require_once 'Utils.php';
	require_once 'Security.php';
	require_once 'SendMail.php';
	

	/**
	* 
	*/
	class Controller extends Crud
	{
		
		function __construct($api_key)
		{
			# super class constructor call
			parent::__construct($api_key);
		}



		/*
		* @param : email id
		* @param : password
		* @return : object 
		*/

		public function userAuthenticate($email,$password)
		{

			# Create QUERY
			$whereCaluseParams['email'] = $email; 
			$whereCaluseParams['status'] = 1; 	// Active Users
			$userInfo = parent::getData(TABLE_USER,"*", $whereCaluseParams,NULL);

             $dbpass=$userInfo[0]->password;
			# SET SESSION
			if(isset($userInfo[0])){

				     $userAccessLevel = $userInfo[0]->user_type;
                  	
                     $decrypted_password=Utils::decode($dbpass);


					//echo $decrypted_password.">>".$dbpass;die;

                     if(strcasecmp($password,$decrypted_password)==0)
                     {        
				      if ($userAccessLevel == SUPERADMINSTAR || $userAccessLevel == SUPERADMIN || $userAccessLevel == ADMIN ||$userAccessLevel == VENDOR)
				       {
						  $_SESSION['id'] = $userInfo[0]->id;
						  $_SESSION['name'] = $userInfo[0]->name;
						  $_SESSION['user'] = $userInfo[0]->email;
						  $_SESSION['user_type'] = $userAccessLevel;
						  $_SESSION['mobile'] = $userInfo[0]->mobile;
						  $_SESSION['address'] = $userInfo[0]->address;
						  $_SESSION['userAccessLevel'] = $userInfo[0]->user_type;
					  	  return $userInfo;
					  	 // return TAG_RESPONSE_SUCCESS;
				     }
			       }
			}
			return array();
		}

		/* Get Profile Information By ID
		* @param : user id
		* @return : object 
		*/

		public function getUserProfileInformationByID($id){

			$whereCaluseParams['id'] = $id; 
			$userInfo = parent::getData(TABLE_USER,"*", $whereCaluseParams,NULL);

			if (isset($userInfo[0])) {
				return $userInfo;
			}

			return TAG_RESPONSE_BAD;
		}

		/* Get Profile Information By Email
		* @param : user email id
		* @return : object 
		*/

		public function getUserProfileInformatioByEmail($email){

			$whereCaluseParams['email'] = $email; 
			$userInfo = parent::getData(TABLE_USER,"*", $whereCaluseParams,NULL);

			if (isset($userInfo[0])) {
				return $userInfo;
			}

			return TAG_RESPONSE_BAD;
		}

		/* Change Password
		* @param : user id
		* @return : object 
		*/
		public function changeUserProfilePassword($originalPassword,$newPassword,$id,$email){

			$userInfo = NULL;
			$param['password'] = Utils::getEncryptedPassword($newPassword);
			$offset = 1;



			if (isset($id)) {
				# code...
				$userInfo = $this->getUserProfileInformationByID($id);
				$param['id'] = $id;
			}elseif (isset($email)) {
				# code...
				$userInfo = $this->getProfileInformatioByEmail($email);
				$param['email'] = $email;
			}

			

			if (isset($userInfo[0])) {
				# code...
				$decryptedPassword = Utils::getDecryptedPassword($userInfo[0]->password);
				$isOriginalPasswordMatched = strcasecmp($decryptedPassword, $originalPassword);

				if ($isOriginalPasswordMatched == 0) {
					
					$fields = array_keys($param);
					$values = array_values($param);
					return parent::updateData(TABLE_USER,$fields,$values,$offset);

				}else{
					# ORGINAL PASSWORD DOSE NOT MATCH
					return TAG_RESPONSE_UNAUTHORIZED;
				}				
			}
			return TAG_RESPONSE_BAD;	
		}


		public function updateUserProfile($username,$mobile,$email){

			$userInfo = NULL;
			$param['name'] = $username;
			$param['mobile'] = $mobile;
			$param['email'] = $email;
			$offset = 1;

			$fields = array_keys($param);
			$values = array_values($param);
			return parent::updateData(TABLE_USER,$fields,$values,$offset);
		}


		public function userSignUp($username,$mobile,$email,$userType,$regid){
            $param['name'] = $username;
			$param['name'] = $username;
			$param['regId'] = $regid;
			$param['mobile'] = $mobile;
			$param['status'] = 1;
			$param['email'] = $email;
			$param['created_at'] = Utils::getCurrentDateTime();
			$param['user_type'] = $userType;

			$fields = array_keys($param);
			$values = array_values($param);
			 return parent::insertData(TABLE_USER,$fields,$values);
			

			//$whereCaluseParams['password'] = Utils::getEncryptedPassword($password); 
		/*	$whereCaluseParams['id'] = $id;
            $orderBy['id']='ASC'; 
        	$userInfo = parent::getData($this->tableName,"*", $whereCaluseParams,$orderBy);

				      $_SESSION['id'] = $userInfo[0]->id;
					  $_SESSION['name'] = $userInfo[0]->name;
					  $_SESSION['user'] = $userInfo[0]->email;
					  $_SESSION['mobile'] = $userInfo[0]->mobile;
          */
            //          return TAG_RESPONSE_SUCCESS;

		}


		public function inviteUserByEmail($email,$userType){
            
			$userInfo = $this->getUserProfileInformatioByEmail($email);
           
			if(!isset($userInfo[0])){

				$signUpURLContent = $email.'_'.$userType.'_'.time();
                
				$encryptedSignUpURLContent = Security::encrypt_decrypt($signUpURLContent);
				$encryptedSignUpURLContent=urlencode($encryptedSignUpURLContent);
				 
				$signupURL= URL.'signup.php?t='.$encryptedSignUpURLContent;
               
				$mailObject = new Mail();
				return $mailObject->sendMAil($signupURL,$email,"Sign Up For TFIN Admin Panel");
			}
			return TAG_RESPONSE_BAD;
		}

		public function userStatusUpdate($userId,$status){

			$param['status'] = $status;
			$param['id'] = $userId;
			$offset = 1;

			$fields = array_keys($param);
			$values = array_values($param);


			return parent::updateData(TABLE_USER,$fields,$values,$offset);
		}

		public function changeUserPasswordByAdmin($password,$user_id){

			# Accept Data
		 	$params['password'] = Utils::getEncryptedPassword($password);
			$params['id'] = $user_id;
			
			# Create a Data
		 	$fields = array_keys($params);
		    $values = array_values($params);

			return parent::updateData(TABLE_USER,$fields,$values,1);

		 }

		public function getDataFromTable($table,$fields,$where,$orderBy){

			return parent::getData($table,$fields,$where,$orderBy);
		}

		public function excuteQuery($selectQuery){
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

           public function json_responder()
		{
			# code...
		} 
		public function orderMeal($user_id,$tiffin_name,$address_of_delivery,$city,$geneated_at,$status){

			$param['user_id'] = $user_id;
			$param['tiffin_name']=$tiffin_name;
			$param['address_of_delivery']=$address_of_delivery;
			$param['city'] = $city;
			$param['geneated_at'] =$geneated_at;
			$param['status']=$status;
			//$param['email'] = $email;
			//$param['created_at'] = Utils::getCurrentDateTime();
			//$param['user_type'] = $userType;
             
			$fields = array_keys($param);
			$values = array_values($param);
			return parent::insertData(TABLE_ORDERS,$fields,$values);
		}


	}

?>
