<?php
set_time_limit(50);
error_reporting(-1);
ini_set('display_errors', 'On');



require_once '../../libs/Slim/Slim.php';
require_once '../../include/Config.php';
require_once '../../include/Superadmin.php';
require_once '../../include/Security.php';
//include '../../include/Utils.php';




\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

//echo "in";
############################### Username Authentication Admin Panel ############

       ##### Add superadmin for mail send #### 
       $app->post('/inviteSuperadmin', function () use ($app) {

        $params = $app->request->post('email');
       // $msg="Thank You";
        
        $superadminObject = new Superadmin(SERVER_API_KEY);
        $res=$superadminObject->inviteSuperAdmin($params);
        //Utils::sendMessage("9665657370",$msg);
       

      });

     ###ADD SUPERADMIN TO DB####
     $app->post('/addSuperadmin', function () use ($app) {
         ##reading parameters
         $params=$app->request->post(); // $_POST
       
         $superadminObject = new Superadmin(SERVER_API_KEY); 
         $isMobile = @$params['isMobile'];


         $lastInsertId=$superadminObject->userSignUp($params['name'],$params['mobile'],$params['email'],$params['user_type']);
   
         if (!empty($lastInsertId)) 
         {
        
          $user['status']=array(TAG_RESPONSE_SUCCESS);
          $user['message']=array('Register Successfully"');
          $user['user']=array();
          array_push($user['user'],$params['name'],$params['mobile'],$params['email']);
          // echo json_encode($user);
          if (isset($isMobile) && !empty($isMobile)) 
          {
             echo json_encode($user);
             exit();
          }
        
            // $app->redirect(URL.'signup.php?status='.TAG_RESPONSE_SUCCESS);   
         }
             // $app->redirect(URL.'signup.php?status='.TAG_RESPONSE_BAD);
       }
       );


  # Change password for any user
  $app->post('/change_password_user', function () use ($app) {
      
    # Accept Data
    $password = $app->request->post('password_1');
    $user_id = $app->request->post('id');

    # Change password
     $superadminObject = new Superadmin(SERVER_API_KEY);  
    echo $superadminObject->updatePasswordByAdmin($password,$user_id);
  });

  # Change password for logged in user FROM PROFILE PAGE
  $app->post('/update_password', function () use ($app) {
      
    # Accept Data
    $password = $app->request->post('password_1');
    $old_password = $app->request->post('old_password');
    $user_id = $app->request->post('id');

    # Change password
    $superadminObject = new Superadmin(SERVER_API_KEY);  
    echo $superadminObject->updateUserPassword($old_password,$password,$user_id);

  });



	####UPDATE SUPERADMIN STATUS####
  $app->get('/updateSuperadminStatus/:id/:status', function ($id,$status) use ($app)
     {
      $params['status'] = $status;
      $params['id'] = $id;
      $superadminObject = new Superadmin(SERVER_API_KEY);
      $lastInsertId =  $superadminObject->updateStatus($params);
      $app->redirect(URL.'superadmin.php');
    });



	
############################### PRIVATE FUNCTION ############################### 
function isValidApiKey($api_key){

  if(empty($api_key)){
    # THROW ERROR
    return false; 
  }else{
    # SERVER_API_KEY
    if(SERVER_API_KEY != $api_key){
      # THRO ERROR
      return false;
    }else{
      return true;
    }
  }
}

# Sign In 
    $app->get('/hello/:name', function ($name) use ($app) {
    	echo "Hello ".$name;
	echo rand(1000,9999);
    });

$app->run();

?>
