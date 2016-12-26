<?php
set_time_limit(50);
//session_start();
error_reporting(-1);
ini_set('display_errors', 'On');

require_once '../../libs/Slim/Slim.php';
require_once '../../include/Config.php';
require_once '../../include/institute.php';



\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();


############################### Update sub status ########
 $app->get('/updateInsStatus/:id/:status/:page', function ($id,$status,$page) use ($app) {

     $params['isEnabled']			= $status;
     $params['institute_id'] 		= $id;
     $insObject 					= new  Institute(SERVER_API_KEY);
     $lastInsertId 					=  $insObject->updateStatus($params);
	 $_SESSION["type"] = "success";
	 if($status==1)
		$_SESSION["msg"] = "Activated successfully.";
	 else
		$_SESSION["msg"] = "Deactivated successfully.";
     $app->redirect(URL.'institute.php?page='.$page);
});
   $app->get('/deleteInstitute/:id/:page/', function ($id,$page) use ($app) {
    // $params['cat_id'] = $id;
     $insObject						= new  Institute(SERVER_API_KEY);
     $lastInsertId					=  $insObject->deleteInstitute($id);
     $_SESSION["type"] 				= "success";
	 $_SESSION["msg"] 				= "Deleted successfully.";
       
     $app->redirect(URL.'institute.php?page='.$page);
});
         
    $app->post('/addInstitute', function () use ($app) {
         $subObject 				= new Institute(SERVER_API_KEY);
		 $uploaddir					= '../../uploads/Institute/';
		 $filename					= rand(1000,100000)."-". basename($_FILES['logo']['name']);
		 $uploadfile 				= $uploaddir .$filename;
 		 if (move_uploaded_file($_FILES['logo']['tmp_name'], $uploadfile)) {
			$params['logo']			= $_FILES['logo']['name'];
		 } else {
			$params['logo']			= '';
		 }
		 $course					= implode(",",$app->request->post('course'));
	 	 $params['institute_name']	= $app->request->post('institute');
	 	 $params['address']			= $app->request->post('address');
	 	 $params['email']			= $app->request->post('email');
	 	 $params['phone']			= $app->request->post('phone');
	 	 $params['course']			= $course;
         $params['created_at']		= Utils::getCurrentDateTime();
         $params['updated_at']		= Utils::getCurrentDateTime();
         $params['isEnabled']	 	= 1;
         $params['isDeleted']		= 0;
		 $lastInsertId 				=  $subObject->add($params);     
		 $_SESSION["type"] = "success";
		 $_SESSION["msg"] = "Institute added successfully.";
         $app->redirect(URL.'institute.php');     
   });

  
   
 $app->post('/updateInstitute', function () use ($app) {
         $uploaddir 				= '../../uploads/Institute/';
		 $filename					= rand(1000,100000)."-". basename($_FILES['logo']['name']);

		 $uploadfile				= $uploaddir .$filename;
 		 if (move_uploaded_file($_FILES['logo']['tmp_name'], $uploadfile)) {
			$params['logo']			= $_FILES['logo']['name'];
		 }
	 	 $insObject 				= new Institute(SERVER_API_KEY);  
         $course					= implode(",",$app->request->post('course'));
	 	 $params['institute_name']	= $app->request->post('institute');
	 	 $params['address']			= $app->request->post('address');
	 	 $params['email']			= $app->request->post('email');
	 	 $params['phone']			= $app->request->post('phone');
	 	 $params['course']			= $course;
         $params['updated_at']		= Utils::getCurrentDateTime();
         $params['institute_id']	= $app->request->post('id');
		 $page						= $app->request->post('page');
         $lastInsertId 				=  $insObject->updateInstitute($params);  
	 	 $_SESSION["type"] = "success";
		 $_SESSION["msg"] = "Updated successfully.";
         $app->redirect(URL.'institute.php?page='.$page);     
   });  


 $app->post('/checkDuplicate', function () use ($app) {
  		$institute					= $app->request->post('institute');
	 	$where['institute_name']	= $institute;
	 	$instituteObj 				= new Institute(SERVER_API_KEY);
		$value						= $instituteObj->checkDuplicate($where);

	  	if(!empty($value))
			echo 1;
	  	else
			echo 0;
  });    
	$app->post('/checkDuplicateEdit', function () use ($app) {
  		$institute					= $app->request->post('inst');
  		$id							= $app->request->post('id');
	 	$where['institute_name']	= $institute;
	 	$where['institute_id']		= $id;
	 	$instituteObj 				= new Institute(SERVER_API_KEY);
		$value						= $instituteObj->checkDuplicateEdit($where);

	  	if(!empty($value))
			echo 1;
	  	else
			echo 0;
  });  
$app->run();

?>
