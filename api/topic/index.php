<?php
set_time_limit(50);
//session_start();
//error_reporting(-1);
ini_set('display_errors',1);
error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once '../../libs/Slim/Slim.php';
require_once '../../include/Config.php';
require_once '../../include/User.php';
require_once '../../include/Security.php';
require_once '../../include/topic.php';
require_once '../../include/Superadmin.php';



\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();


############################### Update sub status ########

$app->post('/getSubjectTopics', function () use ($app) {
    $subject			= $app->request->post('subject');
    $where['subjectid']	= $subject;
    $topicObj = new Topic(SERVER_API_KEY);
    $value=$topicObj->getSubjectTopics($where);

});
$app->get('/delete/:id', function ($id) use ($app) {
     $fieldObject = new  Topic(SERVER_API_KEY);
     $lastInsertId =  $fieldObject->delete($id);
     $_SESSION["type"] 				= "success";
	 $_SESSION["msg"] 				= "Deleted successfully.";
       
     $app->redirect(URL.'topic.php');
});
         
    $app->post('/addtopic', function () use ($app) {
		
         $topicObject			= new Topic(SERVER_API_KEY);
		 $params['courseid']=    $app->request->post('course');
	 	 $params['subjectid']	= $app->request->post('subject');
	 	 $params['name']		= $app->request->post('topic_name');
	 	 $params['createdon']=	$params['updatedon'] = Utils::getCurrentDateTime();
         $params['isDeleted']	 = 0;
		// print_r($params);
		 $lastInsertId =  $topicObject->add($params);

		 $_SESSION["type"] = "success";
		 $_SESSION["msg"] = "Topic added successfully.";
         $app->redirect(URL.'topic.php');
   });

   $app->post('/getcat', function () use ($app) 
   {           $apikey = $app->request->post('api_key');
               $ismobile = $app->request->post('isMobile');
                if($apikey==SERVER_API_KEY)
                 {
                     $user['status']=TAG_RESPONSE_SUCCESS;
                     $user['message']='Category';
                     $subObject = new sub(SERVER_API_KEY);
                     $data = $subObject->getAllCat();
                     $user['category']=$data; 

          
                    //$m=    str_replace(array('[', ']'), '', htmlspecialchars(json_encode($user), ENT_NOQUOTES));
                 
                      $m=json_encode($user);
                   if(isset($ismobile))
                   {
                    
                    echo $m;
                   }
                 }
               else
               {

                    $user['status']=TAG_RESPONSE_BAD;
                     $user['message']='Invalid Apikey';
                     
                    if(isset($ismobile))
                     {
                       echo json_encode($user);
                     }

               }
                    
    });    
 $app->post('/UpdateTopic', function () use ($app) {
         $topicObject 			= new Topic(SERVER_API_KEY);


	 	 $params['courseid']	= $app->request->post('course');
         $params['subjectid']	= $app->request->post('subject');
         $params['name']	= $app->request->post('topic_name');
         $params['updatedon']	= Utils::getCurrentDateTime();
         $params['id']	= $app->request->post('id');
        
         $lastInsertId 			=  $topicObject->updateTopic($params);
	 	 $_SESSION["type"] = "success";
		 $_SESSION["msg"] = "Updated successfully.";
         $app->redirect(URL.'topic.php');
   });  
$app->get('/updateSubStatus/:id/:status/:page', function ($id,$status,$page) use ($app) {
         $fieldObject = new sub(SERVER_API_KEY);  
         $params['isEnabled']		= $status;
         $params['updated_at']	= Utils::getCurrentDateTime();
         $params['cat_id']	= $id;
         $lastInsertId =  $fieldObject->updateSubStatus($params);  
		 $_SESSION["type"] = "success";
		 if($status==1)
			$_SESSION["msg"] = "Activated successfully.";
		 else
			$_SESSION["msg"] = "Deactivated successfully.";
         $app->redirect(URL.'subject.php?page='.$page);     
   }); 

$app->post('/getCourseSub', function () use ($app) {
  		$course			= $app->request->post('course');
	 	$where['course']	= $course;
	 	$subObj = new sub(SERVER_API_KEY);
		$value=$subObj->getDepCourseSub($where);

  });  
$app->post('/getCourseSub2', function () use ($app) {
  		$course			= $app->request->post('course');
	 	$where['course']	= $course;
	 	$subObj = new sub(SERVER_API_KEY);
		$value=$subObj->getDepCourseSub2($where);

  });  
 $app->post('/checkDuplicate', function () use ($app) {

	 	$where['courseid']	=  $app->request->post('course');
	 	$where['subjectid']	=  $app->request->post('subject');
		$where['name']	=  $app->request->post('name');

	 	$field = new Topic(SERVER_API_KEY);
		$value=$field->checkDuplicate($where);

	  	if(!empty($value))
			echo 1;
	  	else
			echo 0;
  });    
	$app->post('/checkDuplicateEdit', function () use ($app) {
  		$category			= $app->request->post('cat');
  		$id					= $app->request->post('id');
	 	$where['cat_name']	= $category;
	 	$where['cat_id']	= $id;
	 	$field = new sub(SERVER_API_KEY);
		$value=$field->checkDuplicateEdit($where);

	  	if(!empty($value))
			echo 1;
	  	else
			echo 0;
  });



$app->run();

?>
