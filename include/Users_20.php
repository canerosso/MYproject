<?php
//session_start();
	# include lib
	require_once 'Config.php';
	require_once 'DatabaseConnection.php';	
	require_once 'Controller.php';
	require_once 'Utils.php';
	require_once 'Security.php';
	require_once 'SendMail.php';


	/**
	* 
	*/
	class Users extends Controller
	{
		var $tableName;
		//var $imageTableName;

		function __construct($api_key)
		{
			# code...
			parent::__construct($api_key);
			$this->tableName = TABLE_USER;
			//$this->imageTableName = TABLE_IMAGES;
		}

		public function inviteUsers($params){
			
			//echo 200;
			return parent::inviteUserByEmail($params,USER);
		}

        ##API METHOD FOR USERSIGNUP###
        public function signUpUser($params){
		    return parent::userSignUp($params['name'],$params['mobile'],$params['email'],$params['user_type'],$params['regId']);
		 }
                  
       //**API FOR DISPLAY VENDORS BY LOCATION FROM SEARCH BAR**//		
        public function getVendorsByLocation($params){			
		$searchVendors= "select a.name from users a,tiffin_place b where a.user_type='4' and 
				      b.place_name='".$params['location']."' and a.id=b.vendor_id ORDER BY a.created_at ASC ";
			try{
              		       return parent::excuteQuery($searchVendors);
			    }
				catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			  }
		 }


		    public function get_topper(){			
		$top= "SELECT ur.user_id, u.name, sum( score ) AS score
							FROM user_result ur
							INNER JOIN users u ON ur.user_id = u.id
							GROUP BY u.name, u.email, u.mobile
							ORDER BY score DESC
							LIMIT 0 , 5";
			try{
              		       return parent::excuteQuery($top);
			    }
				catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			  }
		 }
              public function user_score($id)
              {

              	$top= "SELECT sum(score) as score FROM `user_result` WHERE `user_id`=".$id;
			try{
              		       return parent::excuteQuery($top);
			    }
				catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			  }

              }
              public function getregid()
              {

              		$top= "SELECT regId FROM  users";
			  try{
              		       return parent::excuteQuery($top);
			    }
				catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			 

              }
          }


        //**API FOR DISPLAY BREAKFAST BY LOCATION ON ORDERING PAGE**//
		public function displayBrekfastByLocation($params){		
	    $displayBreakfastByLocation= "select a.id,a.tiffin_name,a.tiffin_cost,b.tiffin_place,b.tiffin_time,d.name from
	     vendors_tiffin a,vendor_tiffin_places b,vendors_tiffin_content c,meal_type_content d where 
	     a.id=b.vendor_tiffin_id and b.tiffin_place='".$params['location']."' and c.tiffin_content_id=a.id
	      and d.id=c.meal_type_content_id and a.tiffin_description='".$params['tiffin_description']."'";
			try{
              		       return parent::excuteQuery($displayBreakfastByLocation);
			    }
				catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			  }
		}
 		
         ##API METHOD FOR ORDERNOW OF ORDERING PAGE####
		 public function orderNow($params){
		    return parent::orderMeal($params['user_id'],$params['tiffin_name'],$params['address_of_delivery'],$params['city'],
			$params['geneated_at'],$params['status']);
		 }
         
         //**API FOR DISPLAY VENDORS BY LOCATION FROM SEARCH BAR**//		
        public function getUserAddress($params){	

		$getUserAddress="SELECT b.address_of_delivery FROM vendors_tiffin a,orders b where 
		b.tiffin_name='".$params['tiffin_name']."' and a.tiffin_name=b.tiffin_name ORDER BY a.created_at ASC ";
			try{
              	   return parent::excuteQuery($getUserAddress);
			    }
				catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			  }
		 }

		 ##API FOR DISPLAY MEAL ON Calender PAGE by tiffin name##	
        public function displayBreakfastMenu($params){	

		$displayBreakfastMenu="SELECT a.date, a.lunch,b.vendor_id, b.tiffin_name, c.meal_type_content_id, d.name
FROM tifin_menu a, vendors_tiffin b, vendors_tiffin_content c, meal_type_content d
WHERE a.breakfast = b.id
AND c.tiffin_content_id = a.breakfast
AND d.id = c.meal_type_content_id and b.tiffin_name='".$params['tiffin_name']."'
LIMIT 0 , 30ORDER BY a.created_at ASC ";
			try{
              	   return parent::excuteQuery($displayBreakfastMenu);
			    }
				catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			  }
		 }

	    /*   public function create_users($params){
		  
		#check if user email id is exist
		$response = $this->isUserEmailIdExist($params);
 		if(!empty($response)){
			//echo "Email is not registered";
			return TAG_RESPONSE_BAD;
		}	
		else
		{
			$url_param = $params.'_'.time();
			$encrypted_string=Security::encrypt_decrypt($url_param);
			$url_param=urlencode($encrypted_string);
           		// echo $url_param;
		   	$webURl = URL.'users_signup.php?t='.$url_param;
			echo "WEB URL: ".$webURl;
			$url=$webURl;
          		$emailid=$params;   
			$subject="signup Form";    

          		$dbMail = new Mail();
           		$response = $dbMail->sendMAil($url,$emailid,$subject);
          		return $response;
		}
              }
               function addUsers($params){
			$params['created_at'] = "".date('Y-m-d H:i:s',time());
			$params['status'] = -1;
			$params['user_type']=0;
			$fields = array_keys($params);
			$values = array_values($params);
			return parent::insertData($this->tableName,$fields,$values);
		}
		 #-------UPADTE USERS STATUS---#
		function updateStatus($params){
                       print_r($params);
			$fields = array_keys($params);
			$values = array_values($params);
			//print_r($params);
			return parent::updateData($this->tableName,$fields,$values,1);
		}*/



	function updateprofile($params){
            unset($params['api_key']);
            unset($params['isMobile']);
			$fields = array_keys($params);
			$values = array_values($params);
			$whereClause['id']=$params['id'];
			$where=array();
			$id=$params['id'];
		 	unset($params['id']);
	       $mob=$params['mobile'];
 		   $email=$params['email'];
 		
                  if($_FILES)
			{
			   $uploadPath='../../prof_img/';
			   $uploadPath2='prof_img/';
               $beforedata=$this->getimage($id);
               $bimg = $beforedata[0]->image; 
               $bimage = '../../'.$bimg;
               @unlink($bimage);
               $file =$_FILES['file'];
			   $path= 	Utils::uploadFileToServer($uploadPath,$file);
         
               if(($path!=TAG_FILE_NOT_IMG ) AND ($path!=TAG_ALREADY_EXISTS) AND ($path!=TAG_TOO_LARGE ) AND ($path!=TAG_FILETYPE_NOT_ALLOW ))
               { 	
               $prof_img =$uploadPath2.$path;
               $params['image']=$prof_img;
               $fields = array_keys($params);
			   $values = array_values($params);
	           return parent::updateData_Where($this->tableName,$fields,$values,$whereClause,0);
	            
	           }
	           else
	           {
	           	  

	           		return $path;
	           }
	        }
			else
			{
             $m =parent::updateData_Where($this->tableName,$fields,$values,$whereClause,0);
             
             return $m;
             
			}
	    
	     
	     {
	     	return TAG_RESPONSE_BAD;
	     
	     }

		}
		 ####DISPLAY ALL USERS FROM USERS PAGE###
		function getAllUsers($flag){
		$getAllUsers = "SELECT * FROM  `users` where `users`.`user_type`='0' and `users`.`status`=1
					 ORDER BY  `users`.`created_at` ASC ";
			try{
                   // $eventsInfo=$parent::excuteQuery($getAllUsers);
				$selectStatement = $this->databaseConnection->prepare($getAllUsers);
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
		}
           //**DISPLAY USERS DETAILS IN TABLE**//
            function convertUserDataIntoResponse($data){
 			$response = "";
 			foreach ($data as $key => $value) {
 					$response .= ' <tr>
                    <td>'.$value->name.'</td>
                    <td>'.$value->address.'</td>
                    <td>'.$value->mobile.'</td>
                    <td>'.$value->email.'</td>
                     ';
			'</tr>';  
 		       }
 		         return $response;
    		}	
	         
                 
            #---API METHOD FOR USER REGISTRATION--#
		    public function registerUser($params){

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
				//	print_r($this->getRegisteredStudentData($response));
					return $this->getRegisteredUserData($response);
				}
			}
		}

	         public function getRegisteredUserData($id){
			//$fields = "*";
			$fields = array('id','name','mobile','email','image');
			return parent::getData($this->tableName,$fields,array('id' => $id));
		}

	       public function getRegisteredUserDataFromEmailID($id){
			//$fields = "*";
			$fields = array('id','name','mobile','email');
			return parent::getData($this->tableName,$fields,array('id' => $id));
		}
######################################################################################	
	 private function isUserEmailIdExist($email){
		$fields = array('email','id');
	    return parent::getData($this->tableName,$fields,array('email' => $email));
	    
	 }

//	 getData($table,$fields,$where,$orderBy){
	 public function isUserExist($where){
		$fields = array('id','name','mobile','email');
		$orderBy['id']='ASC';
	    return parent::getData($this->tableName,$fields,$where,$orderBy);
	    
	 }
        
//	 getData($table,$fields,$where,$orderBy){
	 public function getprofile($where){
		$fields = array('id','name','mobile','email','image');
		$orderBy['id']='ASC';
	    return parent::getData($this->tableName,$fields,$where,$orderBy);
	    
	 }
	 	 public function getimage($id){
		$fields = array('image');
		
		$orderBy['id']='ASC';
	    return parent::getData($this->tableName,$fields,array('id' => $id),$orderBy);
	    
	 }
        

	}
?>
