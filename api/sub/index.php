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
		
         $subObject 			= new sub(SERVER_API_KEY);
		 $course				= implode(",",$app->request->post('course'));
	 	 $params['cat_name']	= $app->request->post('cat_name');
	 	 $params['course']		= $course;
	 	 //$params['syllabus']	= $filenames;
         $params['created_at']	 = Utils::getCurrentDateTime();
         $params['updated_at']	 = Utils::getCurrentDateTime();
         $params['isEnabled']	 = 1;
         $params['isDeleted']	 = 0;
		// print_r($params);
		 $lastInsertId =  $subObject->add($params); 
			$extensions = array("pdf");  
			$uploaddir 			= '../../uploads/syllabus/';
			$total = count($_FILES['files']['name']);
			$filenames=array();
			for($i=0; $i<$total; $i++) {
			  //Get the temp file path
				$filename				= rand(1000,100000)."-". basename(str_replace(' ', '_', $_FILES['files']['name'][$i]));
				$uploadfile 			= $uploaddir .$filename;

				  if ($uploadfile != ""){
					//Setup our new file path

					$file_ext=explode('.',$_FILES['files']['name'][$i])	;
					$file_ext=end($file_ext);  
					$file_ext=strtolower(end(explode('.',$_FILES['files']['name'][$i])));  
					if(in_array($file_ext,$extensions ) === false){
						$errors[]="extension not allowed";
					}
					//Upload the file into the temp dir
					if(empty($errors)){
						if(move_uploaded_file($_FILES['files']['tmp_name'][$i], $uploadfile)) {
							$paramsPDF['subject_id']	= $lastInsertId;
							$paramsPDF['file_name']		= $filename;
							$paramsPDF['syllabus']		= URL.'uploads/syllabus/'.$filename;
							$lastInsertIdPDF =  $subObject->addPDF($paramsPDF); 
						}
					}
				}
			}
			 //$filenames=implode(",",$filenames);
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
	 	
         $course				= implode(",",$app->request->post('course'));
	 	 $params['cat_name']	= $app->request->post('cat_name');
	 	 $params['course']		= $course;
         $params['updated_at']	= Utils::getCurrentDateTime();
         $params['cat_id']		= $app->request->post('id');
		 $page					= $app->request->post('page');
        
         $lastInsertId 			=  $subObject->updatesub($params);  
	 
	 	$extensions = array("pdf");  
		$uploaddir 			= '../../uploads/syllabus/';
		$total = count($_FILES['files']['name']);

		$filenames=array();
		 if($_FILES['files']['name'][0]!=''){
			//  $lastInsertId =  $subObject->deleteSubpdf($app->request->post('id'));
				for($i=0; $i<$total; $i++) {
				
				  //Get the temp file path
					$filename				= rand(1000,100000)."-". basename(str_replace(' ', '_', $_FILES['files']['name'][$i]));
					$uploadfile 			= $uploaddir .$filename;

					  if ($uploadfile != ""){
						//Setup our new file path

						$file_ext=explode('.',$_FILES['files']['name'][$i])	;
						$file_ext=end($file_ext);  
						$file_ext=strtolower(end(explode('.',$_FILES['files']['name'][$i])));  
						if(in_array($file_ext,$extensions ) === false){
							$errors[]="extension not allowed";
						}
						//Upload the file into the temp dir
						if(empty($errors)){
							if(move_uploaded_file($_FILES['files']['tmp_name'][$i], $uploadfile)) {
								$paramsPDF['subject_id']	= $app->request->post('id');
								$paramsPDF['file_name']		= $filename;
								$paramsPDF['syllabus']		= URL.'uploads/syllabus/'.$filename;
								$lastInsertIdPDF =  $subObject->addPDF($paramsPDF); 
							}
						}
					}
				}
		 }
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
$app->post('/getCourseSub2', function () use ($app) {
  		$course			= $app->request->post('course');
	 	$where['course']	= $course;
	 	$subObj = new sub(SERVER_API_KEY);
		$value=$subObj->getDepCourseSub2($where);

  });

 $app->post('/checkDuplicate', function () use ($app) {
		$catObj= new sub(SERVER_API_KEY);
  		$category = $app->request->post('cat');

	    $courses  = $app->request->post('course');
	 	$result = $catObj->getData(TABLE_CAT,'','','');
	    foreach ($result as $row)
		{

			if($row->cat_name==$category )
			{
				$subCoruses=@explode(",",$row->course);
				for($k=0;$k<count($courses);$k++)
				{
					if (in_array($courses[$k], $subCoruses))
					{
						echo 1;
						exit;
					}

				}
			}
		}

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
