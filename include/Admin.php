<?php
//session_start();
	# include lib
	require_once 'Config.php';
	require_once 'Controller.php';	
	


	/**
	* 
	*/
	class Admin extends Controller
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
         

	public function inviteAdmin($params)  //SEND INVITATION BY EMAIL
	{
	    return parent::inviteUserByEmail($params,ADMIN);
    }
		
     function addAdmin($params){	 //ADD ADMIN IN THE DB		
			$params['user_type']=3;		
			return parent::userSignUp($params['name'],$params['mobile'],$params['$email'],$params['$password'],$url_param['$userType']);
		}

      #-------UPADTE ADMIN STATUS---#
		function updateStatus($params){
              
			$fields = array_keys($params);
			$values = array_values($params);
			//print_r($params);
			return parent::updateData($this->tableName,$fields,$values,1);

		}
		function updatePassword($params){
              
			$fields = array_keys($params);
			$values = array_values($params);
			//print_r($params);
			return parent::updateData($this->tableName,$fields,$values,1);

		}

		 ####DISPLAY ALL ADMIN###
		function getAllAdmin($flag){

			$whereClauseArray['user_type'] ='3';
			$whereClauseArray['status'] = 1;
			$orderBy['created_at'] = "ASC";
			$eventsInfo = parent::getDataFromTable(TABLE_USER,"*",$whereClauseArray,$orderBy);
			
			try{
				
				if ($flag == 1) 
				{
					return $this->convertAdminDataIntoResponse($eventsInfo);
				}
				else
				{
					return $eventsInfo;
				}

			}catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			}
		}
         //**DISPLAY ADMIN DETAILS IN TABLE**//
        function convertAdminDataIntoResponse($data){

 			$response = "";

 			foreach ($data as $key => $value) {
 					$response .= ' <tr>
                  <td>'.$value->name.'</td>
                   <td>'.$value->mobile.'</td> 
                    <td>'.$value->email.'</td>
                      <td>';
                         if ($value->status == 1) {
                          # active class
                          $response .= '<div class="col-md-3"><a class="btn btn-danger" href="api/admin/index.php/updateAdminStatus/'.$value->id.'/-1">
                                          Deactive
                                      </a></div>
                                     ';
                         }else{
                         # deactive class
                        $response .= '<div class="col-md-3"><a class="btn btn-info" href="api/admin/index.php/updateAdminStatus/'.$value->id.'/1">
                                         Active
                                      </a></div>
                                     ';
                        }  
  
                         $response .="
                        	   <div class='col-md-3'><a href='view_profile.php?id=$value->id'><input type='button' class='btn btn-block btn-info' value='View Profile'></a></div>
                               <div class='col-md-3'><a href='change_pwd.php?id=$value->id'><input type='button' class='btn btn-block btn-warning' value='Change Password'></a></div>".'</td>';
			          '</tr>';  

 				}

 				return $response;
    		}	
 
          ####DISPLAY PROFILE 
    		function getAllDetails($flag){
	        $getAlldetails = "SELECT * 
							   FROM  `users` where `users`.`email`='".$_SESSION['user']."'
							   ORDER BY  `users`.`created_at` ASC ";
		   try{

				$selectStatement = $this->databaseConnection->prepare($getAlldetails);
				$selectStatement->execute();
				$eventsInfo = $selectStatement->fetchAll(PDO::FETCH_OBJ);
				if ($flag == 1) {
					
				 return $eventsInfo;
				}

			}catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			}
		}
	
			 ####DISPLAY PROFILE 
    		function getAllDetailsForProfile($id){
	   $getAlldetails = "SELECT * FROM  `users` where `users`.`id`=".$id."
							   ORDER BY  `users`.`created_at` ASC ";
		   try{

				$selectStatement = $this->databaseConnection->prepare($getAlldetails);
				$selectStatement->execute();
				$eventsInfo = $selectStatement->fetchAll(PDO::FETCH_OBJ);
				
				 return $eventsInfo;
				
			}catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			}
		}
		   ##UPDATE THE PROFILE OF VENDOR/SUPERADMIN/ADMIN/VENDOR##
	       function updateprofile($params){
			$fields = array_keys($params);
			$values = array_values($params);
			//print_r($params);
			return parent::updateData($this->tableName ,$fields,$values,1);
          }
           
######################################################################################	
	 private function isUserEmailIdExist($email){
		$fields = array('email','id');
	    return parent::getData($this->tableName,$fields,array('email' => $email));
	    
	 }

   }
?>
