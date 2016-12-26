<?php

error_reporting(-1);
ini_set('display_errors', 'On');

require_once '../../libs/Slim/Slim.php';
require_once '../../include/Config.php';
require_once '../../include/Superadmin.php';
require_once '../../include/Security.php';
require_once '../../include/Utils.php';




\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

//echo "in";
############################### Username Authentication Admin Panel ############

       ##### Add superadmin for mail send #### 
       $app->post('/inviteSuperadmin', function () use ($app) {
        
       
        $params = $app->request->post('email');
        $msg="this is test sms";
       // $superadminObject = new Superadmin(SERVER_API_KEY);
        //$res=$superadminObject->inviteSuperAdmin($params);
        //Utils::sendMessage($number,$msg);
       // echo $res;
        // return $res;
echo $params;
      });

     ###ADD SUPERADMIN TO DB####
     $app->post('/addSuperadmin', function () use ($app) {
         ##reading parameters
         $params=$app->request->post();
         $superadminObject = new Superadmin(SERVER_API_KEY); 
         $lastInsertId=$superadminObject->userSignUp($params['name'],$params['mobile'],$params['email'],$params['password']
         ,$params['user_type']);
   
         if (!empty($lastInsertId)) {
           $app->redirect(URL.'signup.php?status='.TAG_RESPONSE_SUCCESS);   
         }
        $app->redirect(URL.'signup.php?status='.TAG_RESPONSE_BAD);
       });


  # Change password for any user
  $app->post('/change_password_user', function () use ($app) {
      
    # Accept Data
    $password = $app->request->post('password_1');
    $user_id = $app->request->post('id');

    # Change password
     $superadminObject = new Superadmin(SERVER_API_KEY);  
    echo $superadminObject->updatePasswordByAdmin($password,$user_id);
  });

  # Change password for logged in user
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

	#--API FOR USER REGISTRATION --#
    $app->post('/register', function () use ($app) {

    if (isValidApiKey($app->request->post('api_key'))) {
    
    # get post request parameters
    $params['name'] = $app->request->post('name');
    $params['mobile'] = $app->request->post('mobile');
    $params['email'] = $app->request->post('email');
    //$params['password'] = Utils::getEncryptedPassword($app->request->post('password'));
 
    $params['status'] = STUDENT_ACTIVE_STATUS;
    $params['created_at'] = Utils::getCurrentDateTime();
    $params['modify_at'] = Utils::getCurrentDateTime();
    $params['user_type'] = $app->request->post('user_type');
    $superadminObject = new Superadmin($app->request->post('api_key'));
    $result = $superadminObject->registerUser($params);
    $result = toArray($result[0]);
    # ENCODE 
  //  $result['id'] = base64_encode($result['id']);
    # ENCODE 
      if (is_array($result)) {
        # send valid response
        $response = array(TAG_STATUS => TAG_RESPONSE_OK, TAG_MESSAGE => TAG_RECORD_FOUND, "users" => $result);
        echo json_encode($response);
      }else{

        switch ($result) {
          case TAG_RESPONSE_BAD :
            # send bad response
            $response = array(TAG_STATUS => TAG_RESPONSE_BAD, TAG_MESSAGE => TAG_API_ERROR_MESSAGE);
            echo json_encode($response);
            break;
          
          default:
            # code...
            break;
        }
      }

    # clean memory
    clean($params); 
    //clean($studentObject);
    clean($result);
    
  }else{
    $response = array(TAG_STATUS => TAG_RESPONSE_UNAUTHORIZED, TAG_MESSAGE => TAG_API_ERROR_MESSAGE);
    echo json_encode($response);
  }

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
   /* $app->get('/hello/:name', function ($name) use ($app) {
    	echo "Hello ".$name;
    });
*/
$app->run();

?>
