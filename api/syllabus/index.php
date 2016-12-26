<?php
set_time_limit(50);
//session_start();
error_reporting(-1);
ini_set('display_errors', 'On');

require_once '../../libs/Slim/Slim.php';
require_once '../../include/Config.php';
require_once '../../include/syllabus.php';
require_once '../../include/Utils.php';


\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();


############################### Update sub status ########
 $app->get('/updateSyllabusStatus/:id/:status/:page', function ($id,$status,$page) use ($app) {

     $params['isEnabled']			= $status;
     $params['syllabus_id'] 		= $id;
     $syllabusObject 				= new  Syllabus(SERVER_API_KEY);
     $lastInsertId 					= $syllabusObject->updateStatus($params);
	 $_SESSION["type"] = "success";
	 if($status==1)
		$_SESSION["msg"] = "Activated successfully.";
	 else
		$_SESSION["msg"] = "Deactivated successfully.";
 	 $app->redirect(URL.'syllabus.php?page='.$page);
});

   $app->get('/deleteSyllabus/:id/:page/', function ($id,$page) use ($app) {
     $syllabusObject				= new  Syllabus(SERVER_API_KEY);
     $lastInsertId					= $syllabusObject->deleteSyllabus($id);
     $_SESSION["type"] 				= "success";
	 $_SESSION["msg"] 				= "Deleted successfully.";
     $app->redirect(URL.'syllabus.php?page='.$page);
});
         
    $app->post('/addSyllabus', function () use ($app) {
         $syllabusObject 				= new Syllabus(SERVER_API_KEY);
		 $uploaddir					= '../../uploads/syllabus/';
		
			 $params['title']			= $app->request->post('title');
			 $params['course']			= $app->request->post('course');
			 $params['created_at']		= Utils::getCurrentDateTime();
			 $params['updated_at']		= Utils::getCurrentDateTime();
			 $params['isEnabled']	 	= 1;
			 $lastInsertId 				=  $syllabusObject->add($params);  
			 $total = count($_FILES['file']['name']);
				for($i=0; $i<$total; $i++) {
				  //Get the temp file path
					$filename				= rand(1000,100000)."-". basename(str_replace(' ', '_',$_FILES['file']['name'][$i]));
					$uploadfile 			= $uploaddir .$filename;
					 if ($uploadfile != ""){
						if(empty($errors)){
							if(move_uploaded_file($_FILES['file']['tmp_name'][$i], $uploadfile)) {
								$paramsPDF['syllabus_id']	= $lastInsertId;
								$paramsPDF['file_name']		= $filename;
								$paramsPDF['path']			= URL.'uploads/syllabus/'.$filename;
								$lastInsertIdPDF 			= $syllabusObject->addSyllData($paramsPDF); 
							}
						}
					}
				}
			 $_SESSION["type"] = "success";
			 $_SESSION["msg"] = "Flashcard uploaded successfully.";
		 
 		 
         $app->redirect(URL.'syllabus.php');     
   });

  
   
 $app->post('/updateSyllabus', function () use ($app) {
     	 $syllabusObject 				= new Syllabus(SERVER_API_KEY);
		 $uploaddir					= '../../uploads/syllabus/';

		 $params['title']			= $app->request->post('title');
		 $params['course']			= $app->request->post('course');
		 $params['updated_at']		= Utils::getCurrentDateTime();
		 $params['syllabus_id']		= $app->request->post('id');
		 $page						= $app->request->post('page');
	 	 $lastInsertId 				= $syllabusObject->updateSyllabus($params); 
	 	 $total = count($_FILES['file']['name']);
	 	
		  if($_FILES['file']['name'][0]!=''){
				for($i=0; $i<$total; $i++) {
				  //Get the temp file path
					$filename				= rand(1000,100000)."-". basename(str_replace(' ', '_', $_FILES['file']['name'][$i]));
					$uploadfile 			= $uploaddir .$filename;
					 if ($uploadfile != ""){
						if(empty($errors)){
							if(move_uploaded_file($_FILES['file']['tmp_name'][$i], $uploadfile)) {
								$paramsPDF['syllabus_id']	= $params['syllabus_id'];
								$paramsPDF['file_name']		= $filename;
								$paramsPDF['path']			= URL.'uploads/syllabus/'.$filename;
								$lastInsertIdPDF 			= $syllabusObject->addSyllData($paramsPDF); 
							}
						}
					}
				}
			}
	 	 $_SESSION["type"] = "success";
		 $_SESSION["msg"] = "Updated successfully.";
         $app->redirect(URL.'syllabus.php?page='.$page);     
   });  

$app->post('/deletePDF', function () use ($app) {
		$syllObject = new Syllabus();
  		$fileId			= $app->request->post('fileId');
  		$syllId			= $app->request->post('syllId');
		//echo $fileId.$flasId;
		$syllObject->deleteSyllpdf($fileId);
		 $where['syllabus_id']=$syllId;
		$valueData=$syllObject->getSyllabusData($where);
		//print_r($valueData); ?>
		<table id="docs">
			<?php for($j=0;$j<count($valueData);$j++){?>
			   <tr><td>
					<?php echo $valueData[$j]->file_name;?> <input type="button" id="tr_<?php echo $j+1?>" value="-" onclick="deleteFile(<?php echo $syllId?>,<?php echo $valueData[$j]->id;?>)"/>
				   </td>
			   </tr>
			<?php }?>
		   </table>
	 <?php

  });

$app->post('/getSyllabusPdf', function () use ($app) {

		$ismobile            = $app->request->post('ismobile');
		$course_id           = $app->request->post('course');
			
		if($ismobile==1){
			$subObj = new Syllabus(SERVER_API_KEY);
			$where['course'] = $course_id;
			$value=$subObj->getSyllabus($where);
			$syllabusids=array();
			for($i=0;$i<count($value);$i++){
				array_push($syllabusids,$value[$i]->syllabus_id);
			}
			$syllabusids=implode(",",$syllabusids);
			$data=$subObj->getPDF($syllabusids);
			if(!empty($value))
				$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_OK ,'data' => $data);
			else
				$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_FAIL ,'data' => TAG_NO_RECORD_FOUND);
		}else{
			$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_BAD ,'data' =>TAG_API_ERROR_MESSAGE_MOBILE);
		}
		echo json_encode($mobileResponseArray); 
	});
$app->run();

?>
