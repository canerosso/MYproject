<?php
set_time_limit(50);
//session_start();
error_reporting(-1);
ini_set('display_errors', 'On');

require_once '../../libs/Slim/Slim.php';
require_once '../../include/Config.php';
require_once '../../include/flashcard.php';
require_once '../../include/Utils.php';


\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();


############################### Update sub status ########
 $app->get('/updateFlashStatus/:id/:status/:page', function ($id,$status,$page) use ($app) {

     $params['isEnabled']			= $status;
     $params['flashcard_id'] 		= $id;
     $flashObject 					= new  Flashcard(SERVER_API_KEY);
     $lastInsertId 					=  $flashObject->updateStatus($params);
	 $_SESSION["type"] = "success";
	 if($status==1)
		$_SESSION["msg"] = "Activated successfully.";
	 else
		$_SESSION["msg"] = "Deactivated successfully.";
 	 $app->redirect(URL.'flashcard.php?page='.$page);
});

   $app->get('/deleteFlashcard/:id/:page/', function ($id,$page) use ($app) {
     $flashObject					= new  Flashcard(SERVER_API_KEY);
     $lastInsertId					=  $flashObject->deleteFlashcard($id);
     $_SESSION["type"] 				= "success";
	 $_SESSION["msg"] 				= "Deleted successfully.";
     $app->redirect(URL.'flashcard.php?page='.$page);
});
         
    $app->post('/addFlashcard', function () use ($app) {
         $flashObject 				= new Flashcard(SERVER_API_KEY);
		 $uploaddir					= '../../uploads/Flashcard/';
		 //echo "size. ".$_FILES['file']['size'][0];die;
			 $params['title']			= $app->request->post('title');
			 $params['course']			= $app->request->post('course');
			 $params['created_at']		= Utils::getCurrentDateTime();
			 $params['updated_at']		= Utils::getCurrentDateTime();
			 $params['isEnabled']	 	= 1;
			 $lastInsertId 				=  $flashObject->add($params);  
			//print_r($params);die;
			 $total = count($_FILES['file']['name']);

				for($i=0; $i<$total; $i++)
				{
				  //Get the temp file path
					$filename				= rand(1000,100000)."-". basename(str_replace(' ', '_', $_FILES['file']['name'][$i]));

					$uploadfile 			= $uploaddir .$filename;

					 if ($uploadfile != "")
					 {
						if(empty($errors))
						{
							if(move_uploaded_file($_FILES['file']['tmp_name'][$i], $uploadfile))
							{
								$filetype="";
								if (strpos($_FILES['file']['type'][$i], 'audio') !== false) {
									$filetype="audio";
								} else if (strpos($_FILES['file']['type'][$i], 'video') !== false) {
									$filetype="video";
								}
								else if (strpos($_FILES['file']['type'][$i], 'pdf') !== false) {
									$filetype="pdf";
								}
								else if (strpos($_FILES['file']['type'][$i], 'powerpoint') !== false) {
									$filetype="ppt";
								}

								$paramsPDF['flashcard_id']	= $lastInsertId;
								$paramsPDF['file_name']		= $filename;
								$paramsPDF['file_type']= $filetype;
								$paramsPDF['path']			= 'uploads/Flashcard/'.$filename;
								$lastInsertIdPDF 			= $flashObject->addFlashData($paramsPDF); 
							}
						}
					}
				}

			 $_SESSION["type"] = "success";
			 $_SESSION["msg"] = "Flashcard uploaded successfully.";
		 
 		 
         $app->redirect(URL.'flashcard.php');     
   });

  
   
 $app->post('/updateFlashcard', function () use ($app) {
     	 $flashObject 				= new Flashcard(SERVER_API_KEY);
		 $uploaddir					= '../../uploads/Flashcard/';

		 $params['title']			= $app->request->post('title');
		 $params['course']			= $app->request->post('course');
		 $params['updated_at']		= Utils::getCurrentDateTime();
		 $params['flashcard_id']	= $app->request->post('id');
		 $page						= $app->request->post('page');
	 	 $lastInsertId 				= $flashObject->updateFlashcard($params); 
	 	 $total = count($_FILES['file']['name']);
	 	
		  if($_FILES['file']['name'][0]!=''){
				for($i=0; $i<$total; $i++) {
				  //Get the temp file path
					$filename				= rand(1000,100000)."-". basename(str_replace(' ', '_', $_FILES['file']['name'][$i]));
					$uploadfile 			= $uploaddir .$filename;
					 if ($uploadfile != ""){
						if(empty($errors)){
							if(move_uploaded_file($_FILES['file']['tmp_name'][$i], $uploadfile))
							{
								$filetype="";
								if (strpos($_FILES['file']['type'][$i], 'audio') !== false) {
									$filetype="audio";
								} else if (strpos($_FILES['file']['type'][$i], 'video') !== false) {
									$filetype="video";
								}
								else if (strpos($_FILES['file']['type'][$i], 'pdf') !== false) {
									$filetype="pdf";
								}
								else if (strpos($_FILES['file']['type'][$i], 'powerpoint') !== false) {
									$filetype="ppt";
								}
								$paramsPDF['flashcard_id']	= $params['flashcard_id'];
								$paramsPDF['file_name']		= $filename;
								$paramsPDF['path']			='uploads/Flashcard/'.$filename;
								$paramsPDF['file_type']= $filetype;
								$lastInsertIdPDF 			= $flashObject->addFlashData($paramsPDF); 
							}
						}
					}
				}
			}
	 	 $_SESSION["type"] = "success";
		 $_SESSION["msg"] = "Updated successfully.";
         $app->redirect(URL.'flashcard.php?page='.$page);     
   });  

$app->post('/deletePDF', function () use ($app) {
		$flashObject = new Flashcard();
  		$fileId			= $app->request->post('fileId');
  		$flasId			= $app->request->post('flasId');
		//echo $fileId.$flasId;
		$flashObject->deleteSubpdf($fileId);
		 $where['flashcard_id']=$flasId;
		$valueData=$flashObject->getFlashCardData($where);
		//print_r($valueData); ?>
		<table id="docs">
			<?php for($j=0;$j<count($valueData);$j++){?>
			   <tr><td>
					<?php echo $valueData[$j]->file_name;?> <input type="button" id="tr_<?php echo $j+1?>" value="-" onclick="deleteFile(<?php echo $flasId?>,<?php echo $valueData[$j]->id;?>)"/>
				   </td>
			   </tr>
			<?php }?>
		   </table>
	 <?php

  });
$app->post('/getFlashCardPdf', function () use ($app) {

		$ismobile            = $app->request->post('ismobile');
		$course_id           = $app->request->post('course');
			
		if($ismobile==1){
			$flashObj = new Flashcard(SERVER_API_KEY);
			$where['course'] = $course_id;
			$value=$flashObj->getFlashCard($where);
			$flashcardids=array();
			for($i=0;$i<count($value);$i++){
				array_push($flashcardids,$value[$i]->flashcard_id);
			}
			$flashcardids=implode(",",$flashcardids);
			$data=$flashObj->getPDF($flashcardids);
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
