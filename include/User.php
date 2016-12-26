<?php
@session_start();
	# include lib
	require_once 'Config.php';
	require_once 'DatabaseConnection.php';	
	require_once 'Crud.php';
	require_once 'Utils.php';
	require_once 'Security.php';
	require_once 'SendMail.php';

	class User extends Crud
	{
		var $tableName;
		var $imageTableName;

		function __construct($api_key)
		{
			# code...
			parent::__construct($api_key);
			$this->tableName = TABLE_USER;
			//$this->imageTableName = TABLE_IMAGES;
		}

		/*
		* User registration 
		* @params : array [email, name, contact, imei, facebook_profile_url, status, created_at, modified_at]
		* @return : array [email, name, contact, imei, facebook_profile_url, status, created_at, modified_at]
		*/
         
         public function authenticateUser($emailid,$password){
         
        	$this->createSuperAdminStarProfile();
			$result_password_hash = "";
			$whereCaluseParams['email'] = $emailid; 
			//$whereCaluseParams['password'] = Utils::getEncryptedPassword($password); 
			$whereCaluseParams['status'] = 1; 
        	$userInfo = parent::getData($this->tableName,"*", $whereCaluseParams);

			# SET SESSION
			if(isset($userInfo[0])){

				     $userAccessLevel = $userInfo[0]->user_type;
                     $decrypted_password=Utils::getDecryptedPassword($userInfo[0]->password);
                  
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
					  return TAG_RESPONSE_SUCCESS;
				     }
			       }
			}
			return TAG_RESPONSE_BAD;
		 }

       ####CHANGE PASSWORD####
        public function changePassword($params){

		$fields = array_keys($params);
		$values = array_values($params);
		//print_r($params);
		return parent::updateData(TABLE_USER,$fields,$values,1);
	    }
	    public function forgetAPI($params){
		#check if user email id is exist
		$response = $this->isUserEmailIdExist($params);

		if(!empty($response)){

			$url_param = $response[0]->email.'_'.$response[0]->id.'_'.time();
			//echo $url_param;
			$encrypted_string=Security::encrypt_decrypt($url_param);
			$url_param=urlencode($encrypted_string);

			$webURl = URL.'reset_password.php?t='.$url_param;
			
			$url=$webURl;
            $emailid=$response[0]->email;   
			$subject="Forget Password";    

            $dbMail = new Mail();
            $response = $dbMail->sendMAil($url,$emailid,$subject);
            return $response;
		}
		else
		{
			//echo "Email is not registered";
			return TAG_RESPONSE_BAD;
		}
	}
	function isUserEmailIdExist($email){
		$fields = array('email','id');
                $orderby="ASC";
	    return parent::getData($this->tableName,$fields,array('email' => $email),$orderby);
	    
	  }


	   public function resetPasswordAPI($params){
       //print_r($params);
		$fields = array_keys($params);
		$values = array_values($params);
		return parent::updateData($this->tableName,$fields,$values,1);
	   }
		public function registerUser($params){

			$params['name'] = utf8_encode (htmlspecialchars($params['name']));
			
			$response = $this->getRegisteredUserDataFromEmailID($params['email']);
			# check if already registered 
			if (!empty($response)) {
				return $response;
			}else{

				$fields = array_keys($params);
				$values = array_values($params);
				$response = parent::insertData($this->tableName,$fields,$values);

				if (TAG_RESPONSE_FAIL == $response) {
					return TAG_RESPONSE_BAD;
				}else{
					# get register student data
					return $this->getRegisteredUserDataFromEmailID($params['email']);
				}
			}
		}
		public function getRegisteredUserDataFromEmailID($user_email_id){
			$fields = "*";
			//$fields = array('student_id','student_name','mobile','city','state','dob','email','profile_url','coaching','school' );
			$empty = "";
			return parent::getData($this->tableName,$fields,array('email' => $user_email_id),$empty,$empty);
		}

     	public function uploadImageToCategory($params){

			$fields = array_keys($params);
			$values = array_values($params);
			$response = parent::insertData($this->imageTableName,$fields,$values);

			if (TAG_RESPONSE_FAIL == $response) {
				return TAG_RESPONSE_BAD;
			}else{
				# get register student data
				// return $this->getImageFromImageId($response);
				return TAG_RESPONSE_SUCCESS;
			}
		}   
        /*   ###DISPLAY ALL USERS####    
            function getAlluser($flag){

			$getAllUser = "SELECT * 
							   FROM  `user` 
							   ORDER BY  `user`.`created_at` ASC ";
			try{

				$selectStatement = $this->databaseConnection->prepare($getAllUser);
				$selectStatement->execute();
				$eventsInfo = $selectStatement->fetchAll(PDO::FETCH_OBJ);
				if ($flag == 1) {
					return $this->convertUserDataIntoResponse($eventsInfo);
				}else{

					return $eventsInfo;
				}

			}catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			}
		}*/
         //**DISPLAY USER DETAILS IN TABLE**//
        /*function convertUserDataIntoResponse($data){

 			$response = "";

 			foreach ($data as $key => $value) {
 					$response .= ' <tr>
                  <td>'.$value->email.'</td>
                  <td>'.$value->name.'</td>
                  <td>'.$value->contact.'</td>
                  
                  <td class="center">
                     ';

                     if ($value->status == 1) {
                 		# active Exam
                 		$response .= '<a class="btn btn-danger" href="api/user/index.php/updateStatusFlag/'.$value->email.'/-1">
                 					  <i class="glyphicon glyphicon-edit icon-white"></i>
                 					  Deactive
                 					  </a>
              						 </td>';
                     }else{
                 		# deactive Exam
                 		$response .= '<a class="btn btn-info" href="api/user/index.php/updateStatusFlag/'.$value->email.'/1">
                 					  <i class="glyphicon glyphicon-edit icon-white"></i>
                 					  Active
                 					  </a>
              						 </td>';
                     }	

                	 '
               </tr>';  
 				}

 				return $response;
    		}	
    		
            function updateStatus($params){
 
			$fields = array_keys($params);
			$values = array_values($params);
			//print_r($params);
			return parent::updateData($this->tableName ,$fields,$values,1);

		}*/
         #####INSERT MAIL INTO THE TABLE####3
         function insert_mail($params){
			
			$params['send_at']="".date('Y-m-d H:i:s',time());
			$params['view']=0;
			$fields = array_keys($params);
			$values = array_values($params);	
			return parent::insertData(TABLE_USERS_MAIL,$fields,$values);
		}
		########RETURNS THE ID FROM THE EMAILID########
		function getID($data)
        {
          $query="SELECT id FROM `users` where email='".$data."'";
              //$getUsersStatement$this->excuteQuery($search_query);
          $getUsersStatement = $this->databaseConnection->prepare($query);
          $getUsersStatement->bindParam(":sss",$data,PDO::PARAM_STR);
          $uid=$getUsersStatement->execute();
          $row=$getUsersStatement->fetchAll(PDO::FETCH_OBJ);
		  return $row;
        } 

        ########RETURNS THE EMAILID FROM ID########
        function getMail($data)
        {
          $query="SELECT email FROM `users` where id=".$data."";
              //$getUsersStatement$this->excuteQuery($search_query);
         $getUsersStatement = $this->databaseConnection->prepare($query);
         $getUsersStatement->bindParam(":sss",$data,PDO::PARAM_INT);
         $uid=$getUsersStatement->execute();
          $row=$getUsersStatement->fetchAll(PDO::FETCH_OBJ);
          return $row;
        } 

        #########DISPLAY ALL EMAIL IN THE MAILBOX##############
         function getAllMail($flag){
		 $getAllMail = "SELECT `id`,`subject`,`sender_id`,`receiver_id`,`send_at` FROM 
			 `users_mail` where `users_mail`.`receiver_id`='".$_SESSION['id']."'
			 ORDER BY  `users_mail`.`send_at` DESC ";
			try{
				return parent::excuteQuery($getAllMail);
				}
				catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			}
		}
		###########DELETE MESSAGE ###########
		 function  deleteMsg($sid){
		 $deleteQuery = "delete FROM  `users_mail` where `users_mail`.`id`=".$sid." ";
			try{
				$selectStatement = $this->databaseConnection->prepare($deleteQuery);
			     $eventsInfo=$selectStatement->execute();
				//$eventsInfo = $selectStatement->fetchAll(PDO::FETCH_OBJ);
					return $eventsInfo;
				}catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			   }
		 }

		  #########DISPLAY ALL SENT EMAIL IN THE MAILBOX##############
         function getAllSendMail($flag){
        $getSendMail = "SELECT `id`,`subject`,`sender_id`,`receiver_id`,`send_at` FROM 
        `users_mail` where `users_mail`.`sender_id`='".$_SESSION['id']."'
	        ORDER BY  `users_mail`.`send_at` DESC ";
			try{
				return parent::excuteQuery($getSendMail);
				}
				catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			}
		}
        
		##############DISPLAY MAIL TO READ##############
        function getAllReadMail($id){

			 $getAllReadMail = "SELECT `id`,`subject`,`content`,`sender_id`,`receiver_id`,`send_at`,`view`
							   FROM  `users_mail` where `users_mail`.`id`=".$id."
							   ORDER BY  `users_mail`.`send_at` DESC ";
			try{
                 return parent::excuteQuery($getAllReadMail);
				}
				catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			  }
		 }
		  #####UPDATE VIEW AFTER VIEW########
		 function updateView($id){

			$updateView= "update `users_mail` set `users_mail`.`view`=1 where `users_mail`.`id`=".$id."";
			try{

				$selectStatement = $this->databaseConnection->prepare($updateView);
				$selectStatement->execute();
				//$eventsInfo = $selectStatement->fetchAll(PDO::FETCH_OBJ);
					return TAG_RESPONSE_SUCCESS;
						//return $eventsInfo;
				}
				catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			    }
		   }

		   #######NOTIFICATION#######
		   function notifyMsg(){
      $getmail="SELECT u.name,subject FROM `users_mail` um JOIN `users` u ON um.sender_id = u.id AND receiver_id ='".$_SESSION['id']."' and um.view=0";							   
			try{

				$selectStatement = $this->databaseConnection->prepare($getmail);
				$selectStatement->execute();
				$eventsInfo = $selectStatement->fetchAll(PDO::FETCH_OBJ);
									
						return $eventsInfo;
				}
				catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			 }
		  }
         #######REQUEST#######
		   function request(){
      $getRequest="SELECT id,email FROM `users` where `users`.`status`=-1";							   
			try{

				$selectStatement = $this->databaseConnection->prepare($getRequest);
				$selectStatement->execute();
				$eventsInfo = $selectStatement->fetchAll(PDO::FETCH_OBJ);
									
						return $eventsInfo;
				}
				catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			 }
		  }
		 function approveUSer($id){

		 $approveUser= "update `users` set `users`.`status`=1 where `users`.`id`=".$id."";
			try{

				$selectStatement = $this->databaseConnection->prepare($approveUser);
				$selectStatement->execute();
				//$eventsInfo = $selectStatement->fetchAll(PDO::FETCH_OBJ);
					return TAG_RESPONSE_SUCCESS;
						//return $eventsInfo;
				}
				catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			    }
		   }
		   #########DISPLAY ALL MAIL Receiver from particular vendor##############
         function mailReceiver(){
		 $getMailReceiver="SELECT c.email FROM orders a,vendors_tiffin b,users c where
		  a.tiffin_name=b.tiffin_name and c.id=a.user_id and b.vendor_id='".$_SESSION['id']."'";
			try{
				return parent::excuteQuery($getMailReceiver);
				}
				catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			}
		}
	}
#---------------------------------------------------------------------------------------------#

?>
