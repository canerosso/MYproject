<?php
//session_start();
//error_reporting(-1);
ini_set('display_errors',1);
error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once '../../libs/Slim/Slim.php';
require_once '../../include/Config.php';
require_once '../../include/User.php';
require_once '../../include/Security.php';
require_once '../../include/sub.php';
require_once '../../include/Superadmin.php';



\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();


############################### Update sub status ########

   $app->get('/deleteSub/:id/:page/', function ($id,$page) use ($app) {
     $fieldObject = new  sub(SERVER_API_KEY);
     $lastInsertId =  $fieldObject->deleteSub($id);
     $_SESSION["type"] 				= "success";
	 $_SESSION["msg"] 				= "Deleted successfully.";
       
     $app->redirect(URL.'subject.php?page='.$page);
});
         
    $app->post('/addsub', function () use ($app) {
		$extensions = array("pdf");  
		$uploaddir 			= '../../uploads/syllabus/';
		$filename				= rand(1000,100000)."-". basename($_FILES['files']['name']);
		$uploadfile 			= $uploaddir .$filename;
		$filenames=array();
		$file_ext=explode('.',$_FILES['files']['name'][$key])	;
		$file_ext=end($file_ext);  
		$file_ext=strtolower(end(explode('.',$_FILES['files']['name'])));  
		if(in_array($file_ext,$extensions ) === false){
			$errors[]="extension not allowed";
		}else{
			if (move_uploaded_file($_FILES['files']['tmp_name'], $uploadfile)) {
				array_push($filenames,$filename);
			 }
		}
		//print_r($filenames);die;
		 $filenames=implode(",",$filenames);
         $subObject 			= new sub(SERVER_API_KEY);
		 $course				= implode(",",$app->request->post('course'));
	 	 $params['cat_name']	= $app->request->post('cat_name');
	 	 $params['course']		= $course;
	 	 $params['syllabus']	= $filenames;
         $params['created_at']	 = Utils::getCurrentDateTime();
         $params['updated_at']	 = Utils::getCurrentDateTime();
         $params['isEnabled']	 = 1;
         $params['isDeleted']	 = 0;

         $lastInsertId =  $subObject->add($params);     
		 $_SESSION["type"] = "success";
		 $_SESSION["msg"] = "Student added successfully.";
         $app->redirect(URL.'subject.php');     
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
 $app->post('/updateSub', function () use ($app) {
         $subObject 			= new sub(SERVER_API_KEY); 
	 	 $extensions = array("pdf");  
		$uploaddir 			= '../../uploads/syllabus/';
		$filename				= rand(1000,100000)."-". basename($_FILES['files']['name']);
		$uploadfile 			= $uploaddir .$filename;
		$filenames=array();
		$file_ext=explode('.',$_FILES['files']['name'][$key])	;
		$file_ext=end($file_ext);  
		$file_ext=strtolower(end(explode('.',$_FILES['files']['name'])));  
		if(in_array($file_ext,$extensions ) === false){
			$errors[]="extension not allowed";
		}else{
			if (move_uploaded_file($_FILES['files']['tmp_name'], $uploadfile)) {
				array_push($filenames,$filename);
			 }
			 $fileToDelete = $uploaddir.$app->request->post('oldfile');
			 unlink($fileToDelete);
			 $params['syllabus']	= implode(",",$filenames);
		}
         $course				= implode(",",$app->request->post('course'));
	 	 $params['cat_name']	= $app->request->post('cat_name');
	 	 $params['course']		= $course;
         $params['updated_at']	= Utils::getCurrentDateTime();
         $params['cat_id']		= $app->request->post('id');
		 $page					= $app->request->post('page');
         //print_r($params);die;
         $lastInsertId 			=  $subObject->updatesub($params);     
	 	 $_SESSION["type"] = "success";
		 $_SESSION["msg"] = "Updated successfully.";//die;
         $app->redirect(URL.'subject.php?page='.$page);     
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
 $app->post('/checkDuplicate', function () use ($app) {
  		$category			= $app->request->post('cat');
	 	$where['cat_name']	= $category;
	 	$field = new sub(SERVER_API_KEY);
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
