<?php
set_time_limit(50);
//session_start();
error_reporting(-1);
ini_set('display_errors', 'On');

require_once '../../libs/Slim/Slim.php';
require_once '../../include/Config.php';
require_once '../../include/question.php';
require_once '../../include/test.php';



\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();


############################### Update sub status ########
 $app->get('/updateQuesStatus/:id/:status', function ($id,$status) use ($app) {

     $params['isEnabled'] 		= $status;
     $params['question_id']	= $id;
     $quesObject 				= new  Question(SERVER_API_KEY);
     $lastInsertId				= $quesObject->updateStatus($params);
	 $_SESSION["type"] 			= "success";
	// $testWhere['test_id']		= $test;
	 
	     
	 /*
	  $testObj  = new Test(SERVER_API_KEY);
		   $value	= $testObj->getTest($testWhere);*/
	 
	  //print_r($value);
	  /*
	  $quesObj  = new Question(SERVER_API_KEY);
			$qsnValue	= $quesObj->getQuestion($qsnWhere);*/
	  
	// print_r($qsnValue);die;
		/*
		 $tests['updated_at']	= Utils::getCurrentDateTime();
				 $tests['test_id']		= $test;
				 $page					= $app->request->post('page');*/
		
		
	 if($status==1){
			 /*
			  $totalMarks				= $value[0]->total_marks+$qsnValue[0]->marks;
						   $totalQuest				= $value[0]->total_questions+1;
						   $tests['total_marks']		= $totalMarks;
						   $tests['total_questions']	= $totalQuest;*/
			 
			  $_SESSION["msg"] = "Question activated successfully.";
		  }else{
			/*
			  $totalMarks				= $value[0]->total_marks-$qsnValue[0]->marks;
						  $totalQuest				= $value[0]->total_questions-1;
						  $tests['total_marks']		= $totalMarks;
						  $tests['total_questions']	= $totalQuest; */
			
			  $_SESSION["msg"] = "Question deactivated successfully.";
		  }
	 
	// $lastInsertIds 			= $testObj->updateQuestionCount($tests);
	 
	// print_r($tests);
	//die;
     $app->redirect(URL.'question.php');
});


   $app->get('/deleteQuestion/:id', function ($id) use ($app) {
     $quesObject 				= new  Question(SERVER_API_KEY);
	 $testObj=new  Test(SERVER_API_KEY);

	 $testdata=$quesObject->getData('test_question',array('testid'),array('questionid'=>$id),'');

     $lastInsertId				= $quesObject->deleteQuestion($id);
	 
	 $rowaff=$quesObject->DeleteQuestionFromTest($id, 0);

       foreach ($testdata as $test)
       {
           $result=$testObj->updateTestScore($test->testid);

       }

	   
	 /*
	  $testWhere['test_id']		= $test;
		   $qsnWhere['question_id']	= $id;
		   $testObj 					= new Test(SERVER_API_KEY);
		   $value					= $testObj->getTest($testWhere);
		   $quesObj  				= new Question(SERVER_API_KEY);
		   $tests['updated_at']		= Utils::getCurrentDateTime();
		   $tests['test_id']			= $test;
		   $qsnValue					= $quesObj->getQuestion($qsnWhere);  			
		   $totalMarks				= $value[0]->total_marks-$qsnValue[0]->marks;	//updating total marks of test
		   $totalQuest				= $value[0]->total_questions-1;					//updating question count of test
		   $tests['total_marks']		= $totalMarks;
		   $tests['total_questions']	= $totalQuest; 
		   if($qsnValue[0]->isEnabled==1)
				   $lastInsertIds 			= $testObj->updateQuestionCount($tests);*/
	 
	   
	 $_SESSION["type"] 				= "success";
	 $_SESSION["msg"] 				= "Deleted successfully.";
     $app->redirect(URL.'question.php');     
});

 $app->get('/deleteQuestionFromTest/:qid/:testid', function ($qid,$testid) use ($app) {
     $quesObject 				= new  Question(SERVER_API_KEY);
    
	 
	 $rowaff=$quesObject->DeleteQuestionFromTest($qid, $testid);
     $testobj=new Test(SERVER_API_KEY);
     $result=$testobj->updateTestScore($testid);
	
	 $_SESSION["type"] 				= "success";
	 $_SESSION["msg"] 				= "Deleted successfully.";
     $app->redirect(URL.'testsQuestion.php?test='.$testid);     
});

$app->get('/deleteQuestionChoiceImage/:qid/:choiceid', function ($qid,$choiceid) use ($app) {
	$quesObject 				= new  Question(SERVER_API_KEY);
	$result=$quesObject->DeleteQuestionChoiceImage($choiceid);


	$_SESSION["type"] 				= "success";
	$_SESSION["msg"] 				= "Image deleted successfully.";
	$app->redirect(URL.'questionEdit.php?id='.$qid);
});

$app->get('/deleteQuestionImage/:qid', function ($qid) use ($app) {
	$quesObject 				= new  Question(SERVER_API_KEY);
	$result=$quesObject->DeleteQuestionImage($qid);


	$_SESSION["type"] 				= "success";
	$_SESSION["msg"] 				= "Image deleted successfully.";
	$app->redirect(URL.'questionEdit.php?id='.$qid);
});
         
    $app->post('/addQuestion', function () use ($app)
	{
		 $testid=$app->request->post('test');
		 $quesObject 			= new Question(SERVER_API_KEY);
		 $uploaddir 			= '../../uploads/Questions/';
		 $filename				= rand(1000,100000)."-". basename($_FILES['ques_file']['name']);
		 $uploadfile 			= $uploaddir .$filename;
		 $questions['topicid']		= $app->request->post('topic');

		 $testObj=new Test(SERVER_API_KEY);
		 $testresult=$testObj->getData(TABLE_TEST,'',array('test_id'=>$testid),'');
		 $questions['courseid']	= $testresult[0]->course;
		 $questions['subjectid'] = $testresult[0]->subject;

		 if($questions['topicid']=="")
		 {
			 $questions['topicid']=$testresult[0]->topicid;
		 }

 		 $questions['marks']		= $app->request->post('mark');
		 if (move_uploaded_file($_FILES['ques_file']['tmp_name'], $uploadfile)) {
			$questions['questionFile']	= $filename;
			 $questions['question']		= $app->request->post('question');
			$questions['quesIsFile']	= 1;
		 } else {
			$questions['question']		= $app->request->post('question');
			$questions['quesIsFile']	= 0;
		 }
		 $questions['difficultylevel']		= $app->request->post('difficultylevel');
		 $questions['created_at']		= Utils::getCurrentDateTime();
		 $questions['updated_at']		= Utils::getCurrentDateTime();
		 $questions['isEnabled']		= 1;
		 $questions['isDeleted']		= 0;
		 $questionId 				= $quesObject->add($questions);

		 for($i=1;$i<5;$i++){
			$ans					= array();
			$ans['question_id']		= $questionId;
		 	
			$fileans				= rand(1000,100000)."-". basename($_FILES['fileans'.$i]['name']);
			$uploadfileans 			= $uploaddir .$fileans;
			if (move_uploaded_file($_FILES['fileans'.$i]['tmp_name'], $uploadfileans)) {
				$ans['choice']			= $fileans;
				$ans['is_file']	= 1;
			 } else {
				$ans['choice']			= $app->request->post('ans'.$i);
				$ans['is_file']	= 0;
			 }
			if($app->request->post('correct_'.$i)==1)
				$ans['is_right']	= 1;
			else
				$ans['is_right']	= 0;
				
			 $ans['created_at']		= Utils::getCurrentDateTime();
			 $ans['updated_at']		= Utils::getCurrentDateTime();
			 $ans['isEnabled']		= 1;
			 $ans['isDeleted']		= 0;
			 $ansId 				= $quesObject->addAns($ans); 
			//print_r($ans); echo "<br>";
		 }

		$testObj = new Test(SERVER_API_KEY);


		$result=$testObj->questionLinking($questionId,$testid);
		$result=$testObj->updateTestScore($testid);

		
		 /*$test['test_id']			= $app->request->post('test');	//getting test details

 		 $value						= $testObj->getTest($test);
		 $totalMarks				= $app->request->post('mark')+$value[0]->total_marks;
		 $totalQuest				= $value[0]->total_questions+1;
		//echo $totalMarks;
	     $tests['total_marks']		= $totalMarks;
	     $tests['total_questions']	= $totalQuest;
	     $tests['updated_at']	= Utils::getCurrentDateTime();
         $tests['test_id']		= $test['test_id'];
		 $page					= $app->request->post('page');
         $lastInsertId 			= $testObj->updateTest($tests);*/
		 $_SESSION["type"] = "success";
		 $_SESSION["msg"] = "Question added successfully.";
		// $app->redirect(URL.'createQuestion.php');     
		 $app->redirect(URL.'question.php');     
   });


$app->post('/addQuestionToBank', function () use ($app)
{

	$quesObject 			= new Question(SERVER_API_KEY);
	$uploaddir 			= '../../uploads/Questions/';
	$filename				= rand(1000,100000)."-". basename($_FILES['ques_file']['name']);
	$uploadfile 			= $uploaddir .$filename;
	$questions['topicid']	= $app->request->post('topic');
	$questions['courseid']	= $app->request->post('course');
	$questions['subjectid'] = $app->request->post('subject');


	//print_r($app->request->post()); die;

	$questions['marks']		= $app->request->post('mark');
	if (move_uploaded_file($_FILES['ques_file']['tmp_name'], $uploadfile)) {
		$questions['questionFile']	= $filename;
		$questions['question']		= $app->request->post('question');
		$questions['quesIsFile']	= 1;
	} else {
		$questions['question']		= $app->request->post('question');
		$questions['quesIsFile']	= 0;
	}
	$questions['difficultylevel']		= $app->request->post('difficultylevel');
	$questions['created_at']		= Utils::getCurrentDateTime();
	$questions['updated_at']		= Utils::getCurrentDateTime();
	$questions['isEnabled']		= 1;
	$questions['isDeleted']		= 0;
	$questionId 				= $quesObject->add($questions);

	for($i=1;$i<5;$i++){
		$ans					= array();
		$ans['question_id']		= $questionId;

		$fileans				= rand(1000,100000)."-". basename($_FILES['fileans'.$i]['name']);
		$uploadfileans 			= $uploaddir .$fileans;
		if (move_uploaded_file($_FILES['fileans'.$i]['tmp_name'], $uploadfileans)) {
			$ans['choice']			= $fileans;
			$ans['is_file']	= 1;
		} else {
			$ans['choice']			= $app->request->post('ans'.$i);
			$ans['is_file']	= 0;
		}
		if($app->request->post('correct_'.$i)==1)
			$ans['is_right']	= 1;
		else
			$ans['is_right']	= 0;

		$ans['created_at']		= Utils::getCurrentDateTime();
		$ans['updated_at']		= Utils::getCurrentDateTime();
		$ans['isEnabled']		= 1;
		$ans['isDeleted']		= 0;
		$ansId 				= $quesObject->addAns($ans);
		//print_r($ans); echo "<br>";
	}




	/*$test['test_id']			= $app->request->post('test');	//getting test details

     $value						= $testObj->getTest($test);
    $totalMarks				= $app->request->post('mark')+$value[0]->total_marks;
    $totalQuest				= $value[0]->total_questions+1;
   //echo $totalMarks;
    $tests['total_marks']		= $totalMarks;
    $tests['total_questions']	= $totalQuest;
    $tests['updated_at']	= Utils::getCurrentDateTime();
    $tests['test_id']		= $test['test_id'];
    $page					= $app->request->post('page');
    $lastInsertId 			= $testObj->updateTest($tests);*/
	$_SESSION["type"] = "success";
	$_SESSION["msg"] = "Question added successfully.";
	// $app->redirect(URL.'createQuestion.php');
	$app->redirect(URL.'addQuestionToBank.php');
});

$app->post('/updateQuestion', function () use ($app) {
	 	
	 	 /*
		   //$whereTest['test_id']=$app->request->post('test');
					$testObj  = new Test();
					$value	= $testObj->getTest($whereTest);
					 $oriMarks = $value[0]->total_marks;
					 $updated_marks=$oriMarks-$app->request->post('testMarks');
					 $updated_marks=$updated_marks+$app->request->post('mark');
					$testData['total_marks']	= $updated_marks;
					$testData['test_id']		= $whereTest['test_id'];
										$lastInsertIdTest 		= $testObj->updateTest($testData);  */
		   	//updating test marks
		
      	 $quesObject 			= new Question(SERVER_API_KEY);
		 $uploaddir 			= '../../uploads/Questions/';
		 $filename				= rand(1000,100000)."-". basename($_FILES['ques_file']['name']);
		 $uploadfile 			= $uploaddir .$filename;
 		 //$questions['test_id']		= $app->request->post('test');
 		 $questions['marks']		= $app->request->post('mark');
	     $questions['difficultylevel']		= $app->request->post('difficultylevel');
		 if (move_uploaded_file($_FILES['ques_file']['tmp_name'], $uploadfile)) {
			$questions['questionFile']	= $filename;
			 $questions['question']		= $app->request->post('question');
			$questions['quesIsFile']	= 1;
		 } else {
			$questions['question']		= $app->request->post('question');
			//$questions['quesIsFile']	= 0;
		 }
		 $questions['updated_at']		= Utils::getCurrentDateTime();
		 $questions['question_id']		= $app->request->post('id');
	 	//print_r($questions);
		 $questionId 					= $quesObject->updateQuestion($questions); 
	 	//die;
	     //$ansId							= $quesObject->deleteQuestionAns($app->request->post('id'));
	
		 for($i=1;$i<5;$i++){
				$ans					= array();
				$ans['question_id']		= $app->request->post('id');
				$fileans				= rand(1000,100000)."-". basename($_FILES['fileans'.$i]['name']);
				$uploadfileans 			= $uploaddir .$fileans;
				if (move_uploaded_file($_FILES['fileans'.$i]['tmp_name'], $uploadfileans)) {
					$ans['choice']			= $fileans;
					$ans['is_file']	= 1;
				 } 
				elseif($app->request->post('ans'.$i)!=''){
					$ans['choice']			= $app->request->post('ans'.$i);
					$ans['is_file']	= 0;
				 }
				if($app->request->post('correct_'.$i)==1)
					$ans['is_right']	= 1;
				else
					$ans['is_right']	= 0;
				 $ans['created_at']		= Utils::getCurrentDateTime();
				 $ans['updated_at']		= Utils::getCurrentDateTime();
				 $ans['isEnabled']		= 1;
				 $ans['isDeleted']		= 0;
			 	 $ans['choice_id']		= $app->request->post('ans_id_'.$i);
				 $ansId 				= $quesObject->UpdateAns($ans); 
				//print_r($ans); echo "<br>";
			 }

			 $result=$quesObject->updateTestScore($app->request->post('id'));
         $app->redirect(URL.'question.php');     
   });  

$app->post('/getQuestionPost', function () use ($app) {
        $test =  $app->request->post('test');
		$page =  $app->request->post('page');
		$app->redirect(URL.'testsQuestion.php?test='.$test);     
   }); 

$app->post('/getQuestions', function () use ($app) {
        $isMobile 	= $app->request->post('ismobile');
		$test_id	= $app->request->post('test_id');
		if($isMobile==1){
			$quesObject = new Question(SERVER_API_KEY);  
			$data		= $quesObject->getTestQuestion($test_id);
			//print_r($data);
			$questionArr=array();
			$dataArr=array();
			for($i=0;$i<count($data);$i++){
				$questionArr['question_id']	= $data[$i]->question_id;
				$questionArr['test_id']		= $data[$i]->test_id;
				$questionArr['question']	= $data[$i]->question;
				$questionArr['questionFile']	= $data[$i]->questionFile;
				$questionArr['question_marks']	= $data[$i]->marks;
				$questionArr['is_file']		= $data[$i]->quesIsFile;
				$questionArr['questionNo']		= $i+1;
				$ansArr						= $quesObject->getQuestionsAns($data[$i]->question_id);
				$questionArr['options']		= $ansArr;
				
				
				array_push($dataArr,$questionArr);
			}
			//print_r($questionArr);
		//	die;
			
			if(!empty($data))
				$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_OK ,'data' => $dataArr);
			else
				$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_FAIL ,'data' => $dataArr);
			
		}else{
			$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_FAIL ,'data' => 'Invalid Data');
		}
		
		echo json_encode($mobileResponseArray);
   }); 

$app->run();

?>
