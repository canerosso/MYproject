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
require_once '../../include/notice.php';
require_once '../../include/Superadmin.php';



\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();


############################### Update sub status ########

   $app->get('/deleteNotice/:id/:page/', function ($id,$page) use ($app) {
     $notiObject  		 = new  Notice(SERVER_API_KEY);
     $lastInsertId 		 = $notiObject->deleteNotice($id);
     $_SESSION["type"] 	 = "success";
	 $_SESSION["msg"] 	 = "Deleted successfully.";
       
     $app->redirect(URL.'notice.php?page='.$page);
});
         
    $app->post('/addNotice', function () use ($app) {
		
         $notiObject 			= new Notice(SERVER_API_KEY);
		// $course				= implode(",",$app->request->post('course'));
	 	 $params['title']		= $app->request->post('title');
	 	// $params['course']		= $course;
	 	 $params['course']		= $app->request->post('course');
	 	 $params['notice']		= $app->request->post('notice');
         $params['created_at']	 = Utils::getCurrentDateTime();
         $params['updated_at']	 = Utils::getCurrentDateTime();
         $params['isEnabled']	 = 1;
		 $lastInsertId =  $notiObject->add($params); 
		 $_SESSION["type"] = "success";
		 $_SESSION["msg"] = "Notice added successfully.";
         $app->redirect(URL.'notice.php');     
   });

   
 $app->post('/updateNotice', function () use ($app) {
         $notiObject 			= new Notice(SERVER_API_KEY); 
        // $course				= implode(",",$app->request->post('course'));
	 	 $params['title']		= $app->request->post('title');
	 	 //$params['course']		= $course;
	 	 $params['course']		= $app->request->post('course');
		 $params['notice']		= $app->request->post('notice');
         $params['updated_at']	= Utils::getCurrentDateTime();
         $params['notice_id']	= $app->request->post('id');
		 $page					= $app->request->post('page');
        
         $lastInsertId 			=  $notiObject->updateNotice($params);  
	  	 $_SESSION["type"] = "success";
		 $_SESSION["msg"] = "Updated successfully.";//die;
         $app->redirect(URL.'notice.php?page='.$page);     
   });  
$app->get('/updateNoticeStatus/:id/:status/:page', function ($id,$status,$page) use ($app) {
         $notiObject = new Notice(SERVER_API_KEY);  
         $params['isEnabled']	= $status;
         $params['updated_at']	= Utils::getCurrentDateTime();
         $params['notice_id']	= $id;
         $lastInsertId =  $notiObject->updateNoticeStatus($params);  
		 $_SESSION["type"] = "success";
		 if($status==1)
			$_SESSION["msg"] = "Activated successfully.";
		 else
			$_SESSION["msg"] = "Deactivated successfully.";
         $app->redirect(URL.'notice.php?page='.$page);     
   }); 

$app->post('/getNotice', function () use ($app) {
  		$ismobile		= $app->request->post('ismobile');
  		$course			= $app->request->post('course');
		if($ismobile==1){
			$notiObj 		= new Notice(SERVER_API_KEY);
			$value 			= $notiObj->getNoticeForCourse($course);
			if(!empty($value))
				$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_OK ,'data' => $value);
			else
				$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_OK ,'data' => TAG_NO_RECORD_FOUND);
		}else{	
			$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_BAD ,'data' => TAG_API_ERROR_MESSAGE_MOBILE);
		}
		echo json_encode($mobileResponseArray); 
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


$app->post('/getCourseSubList', function () use ($app) {
		$ismobile       = $app->request->post('ismobile');
  		$course			= $app->request->post('course');
	 
		if($ismobile==1){
			$where['course']	= $course;
			$subObj = new sub(SERVER_API_KEY);
			$value=$subObj->getCourseSub($where);
			if(!empty($value))
				$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_OK ,'data' => $value);
			else
				$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_OK ,'data' => TAG_NO_RECORD_FOUND);
			
		}else{	
			$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_BAD ,'data' => TAG_API_ERROR_MESSAGE_MOBILE);
		}
		echo json_encode($mobileResponseArray); 
  });  
$app->post('/getSubjPdf', function () use ($app) {

		$ismobile            = $app->request->post('ismobile');
		$subject_id          = $app->request->post('subject');
			
		if($ismobile==1){
			$subObj = new sub(SERVER_API_KEY);
			$value=$subObj->getSubjPdf($subject_id);
//			print_r($value);die;
			//$value['url']=URL;
			if(!empty($value))
				$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_OK ,'data' => $value);
			else
				$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_FAIL ,'data' => TAG_NO_RECORD_FOUND);
		}else{
			$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_BAD ,'data' =>TAG_API_ERROR_MESSAGE_MOBILE);
		}
		echo json_encode($mobileResponseArray); 
	});
$app->post('/deletePDF', function () use ($app) {
		$subObj = new sub();
  		$pdfId			= $app->request->post('pdfId');
  		$subId			= $app->request->post('subId');
		
		$subObject 		= new sub(SERVER_API_KEY); 
		$subObject->deleteSubpdf($pdfId);
		$valueData=$subObj->getSubjPdf($subId);
		//print_r($valueData); ?>
		<table id="docs">
			<?php for($j=0;$j<count($valueData);$j++){?>
			   <tr><td>
					<?php echo $valueData[$j]->file_name;?> <input type="button" id="tr_<?php echo $j+1?>" value="-" onclick="deleteFile(<?php echo $subId?>,<?php echo $valueData[$j]->pdf_id;?>)"/>
				   </td>
			   </tr>
			<?php }?>
		   </table>
	 <?php

  });
$app->run();

?>
