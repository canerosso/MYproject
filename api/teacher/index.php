<?php
set_time_limit(50);
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');

require_once '../../libs/Slim/Slim.php';
require_once '../../include/Config.php';
require_once '../../include/teacher.php';



\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();


############################### Update sub status ########
 $app->get('/updateTeacStatus/:id/:status/:page', function ($id,$status,$page) use ($app) {

     $params['isEnabled'] 		= $status;
     $params['teacher_id'] 		= $id;
     $teacherObject 			= new  Teacher(SERVER_API_KEY);
     $lastInsertId				= $teacherObject->updateStatus($params);
	 $_SESSION["type"] = "success";
	 if($status==1)
		$_SESSION["msg"] = "Activated successfully.";
	 else
		$_SESSION["msg"] = "Deactivated successfully.";
     $app->redirect(URL.'teacher.php?page='.$page);
});
   $app->get('/deleteTeacher/:id/:page/', function ($id,$page) use ($app) {
     $teacherObject 			= new  Teacher(SERVER_API_KEY);
     $lastInsertId				= $teacherObject->deleteTeacher($id);
     $_SESSION["type"] 				= "success";
	 $_SESSION["msg"] 				= "Deleted successfully.";
       
     $app->redirect(URL.'teacher.php?page='.$page);
});
         
    $app->post('/addTeacher', function () use ($app) {
		 $teacherObject 		= new Teacher(SERVER_API_KEY);
		 $uploaddir 			= '../../uploads/Teacher/';
		 $filename				= rand(1000,100000)."-". basename($_FILES['photo']['name']);

		 $uploadfile 			= $uploaddir .$filename;
 		 
		if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile)) {
			$params['photo']	=$_FILES['photo']['name'];
		 } else {
			$params['photo']	='';
		 }
		 $params['first_name']	= $app->request->post('firstName');
	 	 $params['last_name']	= $app->request->post('lastName');
	 	 $params['address']		= $app->request->post('address');
	 	 $params['email']		= $app->request->post('email');
	 	 $params['phone']		= $app->request->post('phone');
	 	// $params['institute']	= $app->request->post('institute');
	 	 $params['subject']		= $app->request->post('subject');
         $params['created_at']	= Utils::getCurrentDateTime();
         $params['updated_at']	= Utils::getCurrentDateTime();
         $params['isEnabled']	= 1;
         $params['isDeleted']	= 0;
         $lastInsertId 			= $teacherObject->add($params);    
		 $_SESSION["type"] = "success";
		 $_SESSION["msg"] = "Student added successfully.";
         $app->redirect(URL.'teacher.php');     
   });
   

   
 $app->post('/updateTeacher', function () use ($app) {
         $uploaddir 			= '../../uploads/Teacher/';
		 $filename				= rand(1000,100000)."-". basename($_FILES['photo']['name']);

		 $uploadfile			= $uploaddir .$filename;
 		 if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile)) {
			$params['photo']	= $_FILES['photo']['name'];
		 }
	 	 $teacherObject 		= new Teacher(SERVER_API_KEY);  
         $params['first_name']	= $app->request->post('firstName');
	 	 $params['last_name']	= $app->request->post('lastName');
	 	 $params['address']		= $app->request->post('address');
	 	 $params['email']		= $app->request->post('email');
	 	 $params['phone']		= $app->request->post('phone');
	 //	 $params['institute']	= $app->request->post('institute');
	 	 $params['subject']		= $app->request->post('subject');
         $params['updated_at']	= Utils::getCurrentDateTime();
         $params['teacher_id']	= $app->request->post('id');
		 $page					= $app->request->post('page');
         $lastInsertId 			=  $teacherObject->updateTeacher($params);     
	 	 $_SESSION["type"] = "success";
		 $_SESSION["msg"] = "Updated successfully.";
         $app->redirect(URL.'teacher.php?page='.$page);     
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
