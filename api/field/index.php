<?php
set_time_limit(50);
//session_start();
error_reporting(-1);
ini_set('display_errors', 'On');

require_once '../../libs/Slim/Slim.php';
require_once '../../include/Config.php';
require_once '../../include/User.php';
require_once '../../include/Security.php';
require_once '../../include/field.php';
require_once '../../include/Superadmin.php';



\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();


############################### Update sub status ########
 $app->get('/updatesubStatus/:id/:status', function ($id,$status) use ($app) {

     $params['status'] = $status;
     $params['cat_id'] = $id;
     $subObject = new  sub(SERVER_API_KEY);
     $lastInsertId =  $subObject->updateStatus($params);
	  $_SESSION["type"] = "success";
	 if($status==1)
		$_SESSION["msg"] = "Activated successfully.";
	 else
		$_SESSION["msg"] = "Deactivated successfully.";
     $app->redirect(URL.'subject.php');
});
  $app->get('/deleteField/:id/:page/', function ($id,$page) use ($app) {
    // $params['cat_id'] = $id;
     $fieldObject = new  Field(SERVER_API_KEY);
     $lastInsertId =  $fieldObject->deleteFeild($id);
     $_SESSION["type"] 				= "success";
	 $_SESSION["msg"] 				= "Deleted added successfully.";
     $app->redirect(URL.'field.php?page='.$page);
});
         
    $app->post('/addField', function () use ($app) {
         $fieldObject			 = new Field(SERVER_API_KEY);  
         $params['field_name']	 = $app->request->post('field');
         $params['created_at']	 = Utils::getCurrentDateTime();
         $params['updated_at']	 = Utils::getCurrentDateTime();
         $params['isEnabled']	 = 1;
         $params['isDeleted']	 = 0;
		 $_SESSION["type"] = "success";
		 $_SESSION["msg"] = "Field added successfully.";
         $lastInsertId =  $fieldObject->add($params);     
         $app->redirect(URL.'field.php');     
   });

   $app->post('/updateField', function () use ($app) {
         $fieldObject 			= new Field(SERVER_API_KEY);  
         $params['field_name']	= $app->request->post('field');
         $params['updated_at']	= Utils::getCurrentDateTime();
         $params['field_id']	= $app->request->post('id');
         $page					= $app->request->post('page');
        
		$_SESSION["type"] = "success";
		 $_SESSION["msg"] = "Updated added successfully.";
         $lastInsertId =  $fieldObject->updateFields($params);     
         $app->redirect(URL.'field.php?page='.$page);     
   });    
	$app->get('/updateFieldStatus/:id/:status/:page', function ($id,$status,$page) use ($app) {
         $fieldObject = new Field(SERVER_API_KEY);  
         $params['isEnabled']		= $status;
         $params['updated_at']	= Utils::getCurrentDateTime();
         $params['field_id']	= $id;
         $lastInsertId =  $fieldObject->updateField($params);   
		 $_SESSION["type"] = "success";
		 if($status==1)
			$_SESSION["msg"] = "Activated successfully.";
		 else
			$_SESSION["msg"] = "Deactivated successfully.";
         $app->redirect(URL.'field.php?page='.$page);     
   }); 
 $app->post('/checkDuplicate', function () use ($app) {
  		$field			= $app->request->post('field');
	 	$where['field_name']	= $field;
	 	$field = new Field(SERVER_API_KEY);
		$value=$field->checkDuplicate($where);

	  	if($value>0)
			echo 1;
	  	else
			echo 0;
  });    
	$app->post('/checkDuplicateEdit', function () use ($app) {
  		$field			= $app->request->post('field');
	 	$where['field_name']	= $field;
	 	$where['field_id']		= $app->request->post('id');
		
	 	$field = new Field(SERVER_API_KEY);
		$value=$field->checkDupEdit($where);
	
	  	if(!empty($value))
			echo 1;
	  	else
			echo 0;
  });  
$app->run();

?>
