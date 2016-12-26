<?php
set_time_limit(50);
//session_start();
error_reporting(-1);
ini_set('display_errors', 'On');

require_once '../../libs/Slim/Slim.php';
require_once '../../include/Config.php';
require_once '../../include/User.php';
require_once '../../include/Security.php';
require_once '../../include/course.php';
require_once '../../include/Superadmin.php';



\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();


############################### Update sub status ########

  $app->get('/deleteCourse/:id/:page/', function ($id,$page) use ($app) {
    // $params['cat_id'] = $id;
     $courseObject = new  Course(SERVER_API_KEY);
     $lastInsertId =  $courseObject->deleteCourse($id);
     $_SESSION["type"] 				= "success";
	 $_SESSION["msg"] 				= "Deleted successfully.";       
     $app->redirect(URL.'course.php?page='.$page);
});
         
    $app->post('/addCourse', function () use ($app) {
         $courseObject			 = new Course(SERVER_API_KEY);  
         $params['field']	 = $app->request->post('field');
         $params['course_name']	 = $app->request->post('course');
         $params['created_at']	 = Utils::getCurrentDateTime();
         $params['updated_at']	 = Utils::getCurrentDateTime();
         $params['isEnabled']	 = 1;
         $params['isDeleted']	 = 0;

         $lastInsertId =  $courseObject->add($params);     
		 $_SESSION["type"] = "success";
		 $_SESSION["msg"] = "Course added successfully.";
         $app->redirect(URL.'course.php');     
   });

   $app->post('/updateCourse', function () use ($app) {
	  	 $courseObject 			= new Course(SERVER_API_KEY);  
         $params['field']		= $app->request->post('field');
         $params['course_name']	= $app->request->post('course');
         $params['updated_at']	= Utils::getCurrentDateTime();
         $params['course_id']	= $app->request->post('id');
         $page					= $app->request->post('page');
         
         $lastInsertId =  $courseObject->updateCourses($params);
	  	 $_SESSION["type"] = "success";
		 $_SESSION["msg"] = "Updated added successfully.";
         $app->redirect(URL.'course.php?page='.$page);     
   });    
	$app->get('/updateCourseStatus/:id/:status/:page', function ($id,$status,$page) use ($app) {
         $courseObject = new Course(SERVER_API_KEY);  
         $params['isEnabled']		= $status;
         $params['updated_at']	= Utils::getCurrentDateTime();
         $params['course_id']	= $id;
         $lastInsertId =  $courseObject->updateCourse($params);   
		 $_SESSION["type"] = "success";
		 if($status==1)
			$_SESSION["msg"] = "Activated successfully.";
		 else
			$_SESSION["msg"] = "Deactivated successfully.";
         $app->redirect(URL.'course.php?page='.$page);     
   }); 
 $app->post('/checkDuplicate', function () use ($app) {
		$course					= $app->request->post('course');
  		$field					= $app->request->post('field');
	 	$where['course_name']	= $course;
	 	$where['field']			= $field;
	 	$courseObj 				= new Course(SERVER_API_KEY);
		$value					= $courseObj->checkDuplicate($where);

	  	if(!empty($value))
			echo 1;
	  	else
			echo 0;
  });    
	$app->post('/checkDuplicateEdit', function () use ($app) {
  		$course					= $app->request->post('course');
  		$field					= $app->request->post('field');
	 	$where['course_name']	= $course;
	 	$where['field']			= $field;
	 	$where['course_id']		= $app->request->post('id');
		
	 	$courseObj 					= new Course(SERVER_API_KEY);
		$value					= $courseObj->checkDupEdit($where);
		
	  	if($value[0]->TOTAL > 0)
			echo 1;
	  	else
			echo 0;
  });  
$app->run();

?>
