<?php
set_time_limit(50);
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');

require_once '../../libs/Slim/Slim.php';
require_once '../../include/Config.php';
require_once '../../include/User.php';
require_once '../../include/Security.php';
require_once '../../include/Admin.php';
require_once '../../include/Superadmin.php';



\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();


############################### Username Authentication Admin Panel ############

####RESET PASSWORD
 $app->post('/resetPassword', function () use ($app) {
 
   $password = Security::encrypt($app->request->post('password'),PUBLIC_KEY);
   "Password: ".$password;
   $passstring=urldecode(stripslashes($app->request->post('id')));
   $decrypted_string= Security::encrypt_decrypt($passstring);
   $data = explode("_", $decrypted_string);
    //print_r($data);
   $userObject = new User(SERVER_API_KEY);
   
   $params = array('password'=>$password,'email' => $data[0]);
  // print_r($params);
   $resposne = $userObject->resetPasswordAPI($params);
   //print_r($resposne); 
   $app->redirect(URL.'index.php?success='.$resposne.'&t='.$app->request->post('id'));                          
  });


    # Forget Password API
    $app->post('/forget', function () use ($app) {
      // reading post params
        $user_email_id = $app->request->post('email');
        $api = SERVER_API_KEY;   
        
        $userObject = new User($api);
        $res = $userObject->forgetAPI($user_email_id); 

       // if($res==TAG_RESPONSE_SUCCESS)
          $app->redirect(URL.'forget.php?er='.$res);
       /* else
        $app->redirect(URL.'forget.php?er='.TAG_RESPONSE_BAD);              
     */
      });

 
	
	  # Sign In 
    $app->post('/signin', function () use ($app) {
	  
     $params['email'] 	 = $app->request->post('username');
     $params['password'] = $app->request->post('password');
 	 $ismobile			 = $app->request->post('ismobile');

      try{

	        $superadminObject = new Superadmin(SERVER_API_KEY);  
	        $result =$superadminObject->signInSuperAdmin($params);
			//print_r($result);
		  //print_r($_SESSION);die;
         // if ($result == TAG_RESPONSE_SUCCESS) {
          if (!empty($result)) {
            	if($ismobile==0){
           		 	$app->redirect(URL.'dashboard.php');
				}else{
					$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_SUCCESS ,'data' => $result);
					echo json_encode($mobileResponseArray);
				}
            }else{
		  	if($ismobile==0){
           		 	$app->redirect(URL.'index.php?er='.TAG_RESPONSE_BAD);
				}else{
					$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_BAD ,'data' => $result);	
					echo json_encode($mobileResponseArray);
				}
		  }
	
        }
        catch(Exception $e){
        	$app->redirect(URL.'index.php?er='.TAG_RESPONSE_BAD);
        }
    });


###ADD ADMIN 
$app->post('/inviteAdmin', function () use ($app) {
       $params= $app->request->post('email');
        $adminObject = new Admin(SERVER_API_KEY);
        $res = $adminObject->inviteAdmin($params); 
        // echo $res;
         $app->redirect(URL.'admin.php?invite='.$res);                
      });

###INSERT ADMIN DATA IN DB
 $app->post('/insert_admin', function () use ($app) {
      
        $password=$app->request->post('password');
        $data = Utils::getEncryptedPassword($password);
  
        $params = $app->request->post();
        $params['password']=$data;
      //print_r($_FILES['image']);
      if(isset($_FILES['image']['name']) && $_FILES['image']['name']!="")
        {
         
          $files = ($_FILES['image']);
          //print_r($_FILES);
           $uploadpath =  DOC_URL."api/admin/images/";
          $name = Utils::uploadFileToServer($uploadpath,$files);
        
        if($name == TAG_FILE_NOT_IMG || $name == TAG_ALREADY_EXISTS  || $name == TAG_TOO_LARGE  || $name == TAG_FILETYPE_NOT_ALLOW )
         {
            $error[] = "Image not uploaded";
           $error[] = $name;
           $errorFlag = 1;
        
          $app->redirect(URL.'admin_signup.php?status='.$status);
          }
         else
           {
          $params['image'] = URL."api/admin/images/".$name;
           }

         $adminObject = new Admin(SERVER_API_KEY);  
         $lastInsertId =  $adminObject->addAdmin($params);
        }
        else
        {
          
           $adminObject = new Admin(SERVER_API_KEY);  
         $lastInsertId =  $adminObject->addAdmin($params);
        }
        'lastInsertId: '.$lastInsertId.'<br/>';

        # return response
        $status = 200;
        $app->redirect(URL.'add_admin.php?status='.$status);
           });
    

    ####UPDATE ADMIN STATUS
     $app->get('/updateAdminStatus/:id/:status', function ($id,$status) use ($app) {

     $params['status'] = $status;
     $params['id'] = $id;
     $adminObject = new Admin(SERVER_API_KEY);
     $lastInsertId =  $adminObject->updateStatus($params);
     $app->redirect(URL.'admin.php');
});
  

####CHANGE PASSWORD
$app->post('/change_password', function () use ($app) {
      


        $params = $app->request->post();
        //print_r($params);
         $params['user_type']=$_SESSION['user_type'];
          $params['user']=$_SESSION['user'];
     
          $isCompared = strcasecmp(trim($params['password_1']), trim($params['password_2']));

      if (0 == $isCompared) {
          
          $db = new User(SERVER_API_KEY);
          $res = $db->authenticateAdmin($params['user'],$params['old_password'],$params['user_type']);
          

      if ($res == TAG_RESPONSE_SUCCESS) 
          {
              # Redirect to dashboard
              $data ['password'] = Utils::getEncryptedPassword($params['password_1']);
              $data ['email'] = $params['user'];
              if($db->changePassword($data) == TAG_RESPONSE_SUCCESS){
                echo TAG_RESPONSE_SUCCESS;
              }

              
              //$app->redirect('../../../profile.php');

          } else if ($res == TAG_RESPONSE_BAD) {
              # Redirect to index.php with error message
              //$app->redirect('../../../change_password.php?er='.TAG_RESPONSE_BAD);
            echo "Change Password Failed";
          }           
        }else{
              # Redirect to index.php with error message
              //$app->redirect('../../../change_password.php?er='.TAG_NOT_ACCEPTABLE);
          echo "Change Password Failed";
        }
    });


$app->post('/change_pwd', function () use ($app) {

        $params = $app->request->post();
       
       $params['user_type']=$_SESSION['user_type'];
       $params['user']=$_SESSION['user'];
        print_r($params);
     if (strcasecmp($params['password_1'], $params['password_2'])==0) {
          
          $db = new User(SERVER_API_KEY);
          $res = $db->authenticateAdmin($params['user'],$params['old_password'],$params['user_type']);

      if ($res == TAG_RESPONSE_SUCCESS) 
          {
              # Redirect to dashboard
              $data ['password'] = Utils::getEncryptedPassword($params['password_1']);
              $data ['email'] = $params['user'];
              print_r($db->changePassword($data));
              $app->redirect('../../../profile.php');

          } else if ($res == TAG_RESPONSE_BAD) {
              # Redirect to index.php with error message
              $app->redirect('../../../change_pwd.php?er='.TAG_RESPONSE_BAD);
          }           
        }else{
              # Redirect to index.php with error message
              $app->redirect('../../../change_pwd.php?er='.TAG_NOT_ACCEPTABLE);
        }
    });
####UPDATE PROFILE OF VENDOR/ADMIN/SUPERADMIN
$app->post('/updateProfile', function () use ($app) {
  $params = $app->request->post();
  $adminObject = new Admin(SERVER_API_KEY);
  $lastInsertId = $adminObject->updateprofile($params);
   $lastInsertId;


  # SET SESSION WITH UPDATED VALUE
  $_SESSION['name'] = $params['name'];
  $_SESSION['mobile'] = $params['mobile'];
 
if($lastInsertId=='200')
{
  $app->redirect(URL .'profile.php?pu='.TAG_RESPONSE_SUCCESS);
}
else
{
  $app->redirect(URL .'profile.php?pu='.TAG_RESPONSE_BAD);
 
}
});




############################### PRIVATE FUNCTION ############################### 


# Sign In 
   /* $app->get('/hello/:name', function ($name) use ($app) {
    	echo "Hello ".$name;
    });
*/
$app->run();

?>
