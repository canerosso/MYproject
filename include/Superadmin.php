 <?php
//session_start();
	# include lib
	require_once 'Config.php';
	require_once 'Controller.php';


	/**
	* 
	*/
	class Superadmin extends Controller
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

		public function inviteSuperAdmin($params){
			//print_r($params);
			//echo 200;
			
			return parent::inviteUserByEmail($params,SUPERADMIN);
		}
        //UPDATE USER PASSWORD WHO LOGGED IN FROM PROFILE PAGE 
		public function updateUserPassword($old_password,$password,$user_id){
			return parent::changeUserProfilePassword($old_password,$password,$user_id,NULL);
		}
		
   		public function updatePasswordByAdmin($password,$user_id){
			return parent::changeUserPasswordByAdmin($password,$user_id);
		}

	    public function signUpSuperAdmin($params){
			return parent::userSignUp($params['name'],$params['mobile'],$params['email'],$params['user_type']);
		}

		public function signInSuperAdmin($params){
			return parent::userAuthenticate($params['email'],$params['password']);
		}

		
		public function updateStatus($params){
			return parent::userStatusUpdate($params['id'],$params['status']);
		}

		public function getAllSuperadmin($flag){
               
			$whereClauseArray['user_type'] ='2';
			$whereClauseArray['status'] = 1;
			$orderBy['created_at'] = "ASC";
			//print_r($whereClauseArray);
			$eventsInfo = parent::getDataFromTable(TABLE_USER,"*",$whereClauseArray,$orderBy);
			//print_r($eventsInfo);
		
			try{
				
				if ($flag == 1) 
				{
					return $this->convertSuperAdminDataIntoResponse($eventsInfo);
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

         //**DISPLAY SUPERADMIN DETAILS IN TABLE**//
        function convertSuperAdminDataIntoResponse($data){
 			$response = "";

 			foreach ($data as $key => $value) {
 					$response .= ' <tr>
                   <td>'.$value->name.'</td>
                   <td>'.$value->mobile.'</td>
                    <td>'.$value->email.'</td>
                     
                      <td>';
                         if ($value->status == 1) {
                          # active class
                          $response .= '<div class="col-md-3"><a class="btn btn-danger" href="api/superadmin/index.php/updateSuperadminStatus/'.$value->id.'/-1">
                                          Deactive
                                      </a></div>
                                     ';
                         }else{
                         # deactive class
                        $response .= '<div class="col-md-3"><a class="btn btn-info" href="api/superadmin/index.php/updateSuperadminStatus/'.$value->id.'/1">
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

		private function createSuperAdminStarProfile(){

	 	$superAdminCreationArray = array();

	 	$superAdminCreationArray['name']= "Super Admin Star";
	 	$superAdminCreationArray['address']= "NA";
	 	$superAdminCreationArray['city']= "NA";
	 	$superAdminCreationArray['mobile']= "NA";
	 	$superAdminCreationArray['created_at']= Utils::getCurrentDateTime();
	 	$superAdminCreationArray['modify_at']= Utils::getCurrentDateTime();
	 	$superAdminCreationArray['status']= 1;
	 	$superAdminCreationArray['user_type']= 1;
	 	$superAdminCreationArray['email']= "superadmin@tfin.com";
	 	$superAdminCreationArray['password']= Utils::getEncryptedPassword("123");
	 	$superAdminCreationArray['image']= "NA";

	 	if (parent::getUserProfileInformatioByEmail($superAdminCreationArray['email']) == TAG_RESPONSE_BAD) {

			$fields = array_keys($superAdminCreationArray);
			$values = array_values($superAdminCreationArray);
	 		if (parent::insertData($this->tableName,$fields,$values)) {
	 			# code...
	 			return true;
	 		}
	 	}

	 	return false;
	 }

	}
	      
?>
