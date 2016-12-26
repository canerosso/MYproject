<?php

error_reporting(-1);
ini_set('display_errors', 'On');


#define
define('ACTIVE_STATUS', 1);
define('DEACTIVE_STATUS', -1);

require_once '../../libs/Slim/Slim.php';
require_once '../../include/Config.php';
require_once '../../include/Users.php';
require_once '../../include/Security.php';
require_once '../../include/Utils.php';

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

//echo "in";
############################### Username Authentication Admin Panel ############    
 
      ##### Add Users for mail send #### 
        $app->post('/inviteUser', function () use ($app) {
        $params = $app->request->post('email');
        $usersObject = new Users(SERVER_API_KEY);
        $res=$usersObject->inviteUsers($params);
        $app->redirect(URL.'user.php?invite='.$res); 
      });
        #--API FOR USER REGISTRATION --#
      $app->post('/register', function () use ($app) {

	  if(isValidApiKey($app->request->post('api_key'))) {
		
		# get post request parameters
		$params['name'] = $app->request->post('name');
        $params['address']=$app->request->post('address');
		$params['mobile'] = $app->request->post('mobile');
		$params['email'] = $app->request->post('email');
		$params['password']= rand(1000,9999);   //Utils::getEncryptedPassword($app->request->post('password'));
        $params['user_type']=$app->request->post('user_type');
        $params['status'] =ACTIVE_STATUS;
		$params['created_at'] = Utils::getCurrentDateTime();
		$params['modified_at'] = Utils::getCurrentDateTime();
                
         //Send message to user       
        $res=Utils::sendMessage($params['mobile'],$params['password']);
        print_r($res);                 
		$userObject = new Users($app->request->post('api_key'));
		$result = $userObject->signUpUser($params);
		$result = toArray($result[0]);
                 
			if ($result>0) {
				# send valid response
				$response = array(TAG_STATUS => TAG_RESPONSE_OK, TAG_MESSAGE => TAG_RECORD_FOUND, "users" => $params);
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
		clean($result);		
	    }else{
		$response = array(TAG_STATUS => TAG_RESPONSE_UNAUTHORIZED, TAG_MESSAGE => TAG_API_ERROR_MESSAGE);
		echo json_encode($response);
	  }
      });

          ##API FOR SEARCH VENDORS FROM SEARCH BAR OF LANDING PAGE##
           $app->post('/searchVendors', function () use ($app) {

	       if (isValidApiKey($app->request->post('api_key'))) {
		    $params['location'] = $app->request->post('location');

            $usersObject = new Users($app->request->post('api_key'));
		    $result = $usersObject->getVendorsByLocation($params);
		// $result = toArray($result[0]);
		  
		    if (count($result)>0) 
                         {
				# send valid response
				$response = array(TAG_STATUS => TAG_RESPONSE_OK, TAG_MESSAGE => TAG_RECORD_FOUND, "users" => $result);
				echo json_encode($response);
			}else{
				# send bad response
				$response = array(TAG_STATUS => TAG_RESPONSE_BAD, TAG_MESSAGE => TAG_NO_RECORD_FOUND);
				echo json_encode($response);
			     
			}
	        }else{
		$response = array(TAG_STATUS => TAG_RESPONSE_UNAUTHORIZED, TAG_MESSAGE => TAG_API_ERROR_MESSAGE);
		echo json_encode($response);
	       }
           });
       
        ##API FOR DISPLAY MEAL BY LOCATION ON ORDERING PAGE##
        $app->post('/displayBrekfastByLocation', function () use ($app) {

	     if (isValidApiKey($app->request->post('api_key'))) {

		 $params['location'] = $app->request->post('location');
		 $params['tiffin_description'] = $app->request->post('tiffin_description');

         $usersObject = new Users($app->request->post('api_key'));
		 $result = $usersObject->displayBrekfastByLocation($params);
		
		 if (count($result)>0) 
                         {
				# send valid response
				$response = array(TAG_STATUS => TAG_RESPONSE_OK, TAG_MESSAGE => TAG_RECORD_FOUND, "vendors_tiffin" => $result);
				echo json_encode($response);
			}else{
				# send bad response
				$response = array(TAG_STATUS => TAG_RESPONSE_BAD, TAG_MESSAGE => TAG_NO_RECORD_FOUND);
				echo json_encode($response);
			     
			}
	        }else{
		$response = array(TAG_STATUS => TAG_RESPONSE_UNAUTHORIZED, TAG_MESSAGE => TAG_API_ERROR_MESSAGE);
		echo json_encode($response);
	       }
           });
           
	    ##API FOR ORDER NOW ON ORDERING PAGE##
         $app->post('/orderNow', function () use ($app) {

	     if (isValidApiKey($app->request->post('api_key'))) {

		 $params['user_id'] = $app->request->post('user_id');
		 $params['tiffin_name'] = $app->request->post('tiffin_name');
 		 $params['address_of_delivery'] = $app->request->post('address_of_delivery');
		 $params['city'] = $app->request->post('city');

         $params['geneated_at'] = Utils::getCurrentDateTime();
         $params['status']=1;
         $usersObject = new Users($app->request->post('api_key'));
		 $result = $usersObject->orderNow($params);
		
		 if (count($result)>0) 
                         {
				# send valid response
				$response = array(TAG_STATUS => TAG_RESPONSE_OK, TAG_MESSAGE => TAG_RECORD_FOUND, "orders" => $result);
				echo json_encode($response);
			}else{
				# send bad response
				$response = array(TAG_STATUS => TAG_RESPONSE_BAD, TAG_MESSAGE => TAG_NO_RECORD_FOUND);
				echo json_encode($response);
			     
			}
	        }else{
		$response = array(TAG_STATUS => TAG_RESPONSE_UNAUTHORIZED, TAG_MESSAGE => TAG_API_ERROR_MESSAGE);
		echo json_encode($response);
	       }
           });

         ##API FOR USERS ADDRESS FOR TIFFIN DELIVERY###
        $app->post('/userAddress', function () use ($app) {

	       if (isValidApiKey($app->request->post('api_key'))) {
		    $params['tiffin_name'] = $app->request->post('tiffin_name');

            $usersObject = new Users($app->request->post('api_key'));
		    $result = $usersObject->getUserAddress($params);
		// $result = toArray($result[0]);
		  
		    if (count($result)>0) 
                         {
				# send valid response
				$response = array(TAG_STATUS => TAG_RESPONSE_OK, TAG_MESSAGE => TAG_RECORD_FOUND, "orders" => $result);
				echo json_encode($response);
			}else{
				# send bad response
				$response = array(TAG_STATUS => TAG_RESPONSE_BAD, TAG_MESSAGE => TAG_NO_RECORD_FOUND);
				echo json_encode($response);
			     
			}
	        }else{
		$response = array(TAG_STATUS => TAG_RESPONSE_UNAUTHORIZED, TAG_MESSAGE => TAG_API_ERROR_MESSAGE);
		echo json_encode($response);
	       }
           });
       
           ##API FOR DISPLAY MEAL ON Calender PAGE by tiffin name##
        $app->post('/displayBreakfastMenu', function () use ($app) {

	     if (isValidApiKey($app->request->post('api_key'))) {

		 $params['tiffin_name'] = $app->request->post('tiffin_name');

         $usersObject = new Users($app->request->post('api_key'));
		 $result = $usersObject->displayBreakfastMenu($params);
		
		 if (count($result)>0) 
                         {
				# send valid response
				$response = array(TAG_STATUS => TAG_RESPONSE_OK, TAG_MESSAGE => TAG_RECORD_FOUND, "vendors_tiffin_content" => $result);
				echo json_encode($response);
			}else{
				# send bad response
				$response = array(TAG_STATUS => TAG_RESPONSE_BAD, TAG_MESSAGE => TAG_NO_RECORD_FOUND);
				echo json_encode($response);
			     
			}
	        }else{
		$response = array(TAG_STATUS => TAG_RESPONSE_UNAUTHORIZED, TAG_MESSAGE => TAG_API_ERROR_MESSAGE);
		echo json_encode($response);
	       }
           });
	
############################### PRIVATE FUNCTION ############################### 


# Sign In 
   /* $app->get('/hello/:name', function ($name) use ($app) {
    	echo "Hello ".$name;
    });
*/

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

function toArray( $object )
{
    if( !is_object( $object ) && !is_array( $object ) )
    {
        return $object;
    }
    if( is_object( $object ) )
    {
        $object = get_object_vars( $object );
    }
    return array_map( 'toArray', $object );
}

function clean($object){
	unset($object);
}
$app->run();

?>
