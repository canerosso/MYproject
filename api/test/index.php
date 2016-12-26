<?php
session_start();
set_time_limit(50);
error_reporting(-1);
ini_set('display_errors', 'On');

require_once '../../libs/Slim/Slim.php';
require_once '../../include/Config.php';
require_once '../../include/test.php';
require_once '../../include/question.php';
require_once '../../include/student.php';


\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();


############################### Update sub status ########
 $app->get('/updateTestStatus/:id/:status/:page', function ($id,$status,$page) use ($app) {

     $params['isEnabled'] 		= $status;
     $params['test_id'] 		= $id;
     $testObject 				= new  Test(SERVER_API_KEY);
     $lastInsertId				= $testObject->updateStatus($params);
	 $_SESSION["type"] = "success";
	 if($status==1)
		$_SESSION["msg"] = "Activated successfully.";
	 else
		$_SESSION["msg"] = "Deactivated successfully.";
     $app->redirect(URL.'test.php?page='.$page);
});
   $app->get('/deleteTest/:id/:page/', function ($id,$page) use ($app) {
     $testObject 			= new  Test(SERVER_API_KEY);

     $lastInsertId				= $testObject->deleteTest($id);
	 $rowaff=$testObject->DeleteQuestionLinkingForTest($id);

     $_SESSION["type"] 				= "success";
	 $_SESSION["msg"] 				= "Deleted successfully.";
       
     $app->redirect(URL.'test.php?page='.$page);
});
         
    $app->post('/addTest', function () use ($app) {
		 $testObject 		= new Test(SERVER_API_KEY);

		 $params['title']	= $app->request->post('title');
	 	 $params['course']		= $app->request->post('course');
	 	 $params['subject']		= $app->request->post('subject');
	 	 $params['test_time']		= $app->request->post('time');
	 	 $params['isSpecial']		= $app->request->post('isSpecial');
		 $params['topicid']		= $app->request->post('topic');
		 $params['testtype']		= $app->request->post('testtype');
		 $params['allquestionsfromsametopic']		= $app->request->post('allquestionsfromsametopic');
		 $params['allquestioncarriesequalmarks']		= $app->request->post('equalmarking');
		 $params['positivemarks']		= $app->request->post('equalmarks');
		 $params['negativemarking']		= $app->request->post('negativemarking');
		 if($app->request->post('negativemarks')>0)
		 {
		 	$params['negativemarks']		= -floatval($app->request->post('negativemarks'));
		 }
		 else 
		 {
			 $params['negativemarks']		= $app->request->post('negativemarks');
		 }
		 

         $params['created_at']	= Utils::getCurrentDateTime();
         $params['updated_at']	= Utils::getCurrentDateTime();
         $params['isEnabled']	= 1;
         $params['isDeleted']	= 0;
		 $chars = 'bcdfghjklmnprstvwxzaeiou';
   		 $result='';
		 for ($p = 0; $p < 6; $p++)
		 {
			$result .= ($p%2) ? $chars[mt_rand(19, 23)] : $chars[mt_rand(0, 18)];
		 }

		 $params['code']	= $result;
         $lastInsertId 			= $testObject->add($params);
		 $_SESSION["type"] = "success";
		 $_SESSION["msg"] = "Test added successfully.";
         $app->redirect(URL.'test.php');     
   });

$app->post('/CreateTest', function () use ($app) {
		 $testObject 		= new Test(SERVER_API_KEY);
		
		 $params['title']	= $app->request->post('title');
	 	 $params['course']		= $app->request->post('course');
	 	 $params['subject']		= $app->request->post('subject');
	 	 $params['test_time']		= $app->request->post('time');
	 	 $params['isSpecial']		= $app->request->post('isSpecial');
		 $params['topicid']		= $app->request->post('topic');
		 $params['testtype']		= $app->request->post('testtype');
		 $params['allquestionsfromsametopic']		= $app->request->post('allquestionsfromsametopic');
		 $params['allquestioncarriesequalmarks']		= $app->request->post('equalmarking');
		 $params['positivemarks']		= $app->request->post('equalmarks');
		 $params['negativemarking']		= $app->request->post('negativemarking');
		 if($app->request->post('negativemarks')>0)
		 {
		 	$params['negativemarks']		= -floatval($app->request->post('negativemarks'));
		 }
		 else 
		 {
			 $params['negativemarks']		= $app->request->post('negativemarks');
		 }
		 
         $params['created_at']	= Utils::getCurrentDateTime();
         $params['updated_at']	= Utils::getCurrentDateTime();
         $params['isEnabled']	= 1;
         $params['isDeleted']	= 0;
		 $chars = 'bcdfghjklmnprstvwxzaeiou';
   		 $result='';
		 for ($p = 0; $p < 6; $p++)
		 {
			$result .= ($p%2) ? $chars[mt_rand(19, 23)] : $chars[mt_rand(0, 18)];
		 }

		 $params['code']	= $result;
         $testid 			= $testObject->add($params);
		
		 $questions=@explode(",",$app->request->post('questionids'));
		 foreach($questions as $questionid)
		 {
		 	$result=$testObject->questionLinking($questionid, $testid);
		 }
		
		 $_SESSION["type"] = "success";
		 $_SESSION["msg"] = "Test created successfully. ".count($questions)." question(s) were added.";
		 
         $app->redirect(URL.'questionbank.php?course='.$app->request->post('qbcourse').'&subject='.$app->request->post('qbsubject').'&topic='.$app->request->post('qbtopic'));
		      
   });
   
   $app->post('/addQuestionsToTest', function () use ($app) {
		 $testObject 		= new Test(SERVER_API_KEY);
		 
		 $testid=$app->request->post('test');
		 $questions=@explode(",",$app->request->post('questionids'));
		 $successcount=0;
		 $duplicatecount=0;
		 foreach($questions as $questionid)
		 {
		 	$result=$testObject->getData('test_question','',array('testid'=>$testid,'questionid'=>$questionid),'');
			if(count($result)==0)
			{
				$result=$testObject->questionLinking($questionid, $testid);
				$successcount++;
			}
			else {
				$duplicatecount++;
			}
			echo count($result);
		 	//$result=$testObject->questionLinking($questionid, $testid);
		 }
		
		
		 $_SESSION["type"] = "success";
		 $_SESSION["msg"] = $successcount." question(s) were added. Skipped $duplicatecount duplicate question(s).";
		 
         $app->redirect(URL.'questionbank.php?course='.$app->request->post('qbcourse').'&subject='.$app->request->post('qbsubject').'&topic='.$app->request->post('qbtopic'));
		      
   });
   
$app->post('/copyTest', function () use ($app) {
		
	$testObject 		= new Test(SERVER_API_KEY);
	$title	= $app->request->post('title');
	$testid= $app->request->post('test');
	$chars = 'bcdfghjklmnprstvwxzaeiou';
	$code="";
	for ($p = 0; $p < 6; $p++)
	{
		$code .= ($p%2) ? $chars[mt_rand(19, 23)] : $chars[mt_rand(0, 18)];
	}
	
	$result=$testObject->CopyTest($title,$code,$testid);

	$_SESSION["type"] = "success";
	$_SESSION["msg"] = "Test created successfully.";
	$app->redirect(URL.'test.php');
});
   
 $app->post('/updateTest', function () use ($app) {
	 	 $testObject 			= new Test(SERVER_API_KEY);
         $params['title']		= $app->request->post('title');
	 	 $params['course']		= $app->request->post('course');
	 	 $params['subject']		= $app->request->post('subject');
	   	 $params['isSpecial']		= $app->request->post('isSpecial');
	 	 $params['test_time']	= $app->request->post('time');
         $params['updated_at']	= Utils::getCurrentDateTime();

		 $params['topicid']		= $app->request->post('topic');
		 $params['testtype']		= $app->request->post('testtype');
		 $params['allquestioncarriesequalmarks']		= $app->request->post('equalmarking');
		 $params['allquestionsfromsametopic']		= $app->request->post('allquestionsfromsametopic');
		 $params['positivemarks']		= $app->request->post('equalmarks');
		 $params['negativemarking']		= $app->request->post('negativemarking');

	 	 if($app->request->post('negativemarks')>0)
		 {
		 	$params['negativemarks']		= -floatval($app->request->post('negativemarks'));
		 }
		 else 
		 {
			 $params['negativemarks']		= $app->request->post('negativemarks');
		 }
		 $params['test_id']		= $app->request->post('id');

         $lastInsertId 			= $testObject->updateTest($params);
	 	 $result=$testObject->updateTestScore($params['test_id']) ;
	     $_SESSION["type"] = "success";
		 $_SESSION["msg"] = "Updated successfully.";
         $app->redirect(URL.'test.php');
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
$app->post('/getAllTest', function () use ($app) {
	
        $isMobile 	= $app->request->post('ismobile');
		$course 	= $app->request->post('course');
		$userid 	= $app->request->post('userid');
		
		if($isMobile==1){
			$where['id']=$userid;
			$studObj	 = new Student();
			$quesObject = new Question(SERVER_API_KEY);  
			$studentDet	 = $studObj->getStudent($where);
			$attempted_test = $studentDet[0]->attempted_test;
			$testObject = new Test(SERVER_API_KEY);  
			$data		= $testObject->getCourseTest($course,$attempted_test);
			$testArr	= array();
			$dataArr	= array();
			for($i=0;$i<count($data);$i++)
			{
				  $testArr['test_id']= $data[$i]->test_id;
				  $testArr['title']= $data[$i]->title;
				  $testArr['course']= $data[$i]->course;
				  $testArr['subject']= $data[$i]->subject;
				  $testArr['test_time']= $data[$i]->test_time;
				  $testArr['code']= $data[$i]->code;
				  $testArr['total_marks']= $data[$i]->total_marks;
				  $testArr['total_questions']= $data[$i]->total_questions;
				  $testArr['isSpecial']= $data[$i]->isSpecial;
				  $testArr['created_at']= $data[$i]->created_at;
				  $testArr['updated_at']= $data[$i]->updated_at;
				  $testArr['isEnabled']= $data[$i]->isEnabled;
				  $testArr['isDeleted']= $data[$i]->isDeleted;
				  $questionArr= $quesObject->getTestQuestion($data[$i]->test_id);
				  
				  $testQsn	= array();
				  for($j=0;$j<count($questionArr);$j++){
				  	//print_r($questionArr[$j]); die;
				  	  $questions["question_id"]=$questionArr[$j]->question_id;
					  $questions['questionNo']		= $j+1;
				  	  $questions["test_id"]=$questionArr[$j]->test_id;
				  	  $questions["question"]=$questionArr[$j]->question;
				  	  $questions["questionFile"]=$questionArr[$j]->questionFile;
				  	  $questions["is_file"]=$questionArr[$j]->quesIsFile;
				  	  $questions["question_marks"]=$questionArr[$j]->marks;
				  	  $questions["created_at"]=$questionArr[$j]->created_at;
				  	  $questions["updated_at"]=$questionArr[$j]->updated_at;
				  	  $questions["isEnabled"]=$questionArr[$j]->isEnabled;
				  	  $questions["isDeleted"]=$questionArr[$j]->isDeleted;
					  $ansArr						= $quesObject->getQuestionsAns($questionArr[$j]->question_id);
					  $questions['options']		= $ansArr;
					 array_push($testQsn,$questions);
				  }
				 $testArr['questions']=$testQsn;
				  array_push($dataArr,$testArr);
			}
			if(!empty($data))
				$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_OK ,'data' => $dataArr);
			else
				$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_FAIL ,'data' => $dataArr);
		
		}else{
			$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_FAIL ,'data' => 'Invalid Data');
		}
		echo json_encode($mobileResponseArray);
		
   }); 
$app->post('/validateCode', function () use ($app) {
        $isMobile 	= $app->request->post('ismobile');
		$code 		= $app->request->post('code');
		$test_id 		= $app->request->post('test_id');
		if($isMobile==1){
			$testObject = new Test(SERVER_API_KEY);  
			$data		= $testObject->validateCode($code,$test_id);
			if(!empty($data))
				$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_OK ,TAG_MESSAGE => 'Code validated');
			else
				$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_FAIL ,TAG_MESSAGE => 'Invalid code');
			
		}else{
			$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_FAIL ,TAG_MESSAGE => 'Invalid Data');
		}
		
		echo json_encode($mobileResponseArray);
   }); 

 
 $app->post('/submitTest', function () use ($app) {
	 
		$testObject 		 = new Test(SERVER_API_KEY);
		$studentObject 		 = new Student(SERVER_API_KEY);
		
		$ismobile            = $app->request->post('ismobile');
		$test_id             = $app->request->post('test_id');
		$user_id             = $app->request->post('userid');
		$data             	 = json_decode($app->request->post('data'));

		/*$studentdata=$studentObject->getData(TABLE_STUDENT, '', array('student_id'=>$user_id),'');
		$params['attempted_test']='';
		$params['id']=$user_id;
		if($studentdata[0]->attempted_test=="")
		{
			$params['attempted_test']=$test_id;
		}
		else 
		{
			$params['attempted_test']=$studentdata[0]->attempted_test.",".$test_id;
		}
		$result=$studentObject->updateStudent($params);*/
		
		$testdata=$testObject->getData(TABLE_TEST, '', array('test_id'=>$test_id),'');
		$testdata=$testdata[0];
		
		
	 	if($ismobile==1)
	 	{
			$correctCount=0;
			$wrongCount=0;
			$notAttempt=0;
			$marksAttempt=0;
			foreach($data as $d)
			{
				if($d->user_choice=='')
					$notAttempt=$notAttempt+1;
				else{
						$corransArr=explode(",",$d->correct_answer);
						$choiceArr=explode(",",$d->user_choice);
						sort($corransArr);
						sort($choiceArr);
						
						if ($corransArr==$choiceArr)
						{ 
							$correctCount=$correctCount+1;
							
							if($testdata->allquestioncarriesequalmarks=="NO")
							{
								$marksAttempt=$marksAttempt+$d->question_marks;
							}else
							{
								$marksAttempt=$marksAttempt+$testdata->positivemarks;
							}
						}
						else
						{
							$wrongCount=$wrongCount+1;
						}	
				}

			}
			//echo "Attemted marks= ".$marksAttempt;die;
			 $testResultArr['test_id']	 			= $test_id;
			 $testResultArr['student_id']	 		= $user_id;
			 $testResultArr['totalQuestion']	 	= count($data);
			 $testResultArr['correct_ans']	 		= $correctCount;
			 $testResultArr['notAttempted_ans']	 	= $notAttempt;
			 $testResultArr['wrong_ans']	 		= $wrongCount;
			 
			 if($testdata->negativemarking=="YES")
			 {
			 	 $testResultArr['student_marks']= $marksAttempt+ ($wrongCount * floatval($testdata->negativemarks));
			 }
			 else 
			 {
				 $testResultArr['student_marks']= $marksAttempt;
			 }
			
			 $testResultArr['created_at']			= Utils::getCurrentDateTime();
			 $lastInsertId 			= $testObject->addTestResult($testResultArr);  
			 //print_r($lastInsertId);die;

			 foreach($data as $d)
			 {
				$optArr['test_resultId']	= $lastInsertId;
				$optArr['question_id']		= $d->question_id;
				$optArr['questionNo']		= $d->questionNo;
				$optArr['user_choice']		= $d->user_choice;
				$optArr['correct_answer']	= $d->correct_answer;
				$optArr['timetaken']		= $d->time_taken;
				$optArr['question_marks']	= $d->question_marks;
				$lastOptInsertId 			= $testObject->addResultOptions($optArr);  
			}

			 $studObject 				= new Student(SERVER_API_KEY);
			 $studWhere['id']=$app->request->post('userid');

			 $studDetails				= $studObject->getStudent($studWhere);
			 if($studDetails[0]->attempted_test==''){
				$studeDet['attempted_test'] = $test_id;
			 }else{
				 $explodArr					= @explode(",",$studDetails[0]->attempted_test);
				 array_push($explodArr,$test_id);
				 $studeDet['attempted_test'] = @implode(",",$explodArr);
			 }

			  $studeDet['id']		= $user_id;
			  $lastInsertId 				= $studObject->updateStudent($studeDet);  
			if($lastOptInsertId!='')
			{
				    $quesObject = new Question(SERVER_API_KEY); 
					$questionArr= $quesObject->getSubmittedTestQuestion($test_id,$user_id);
					
					$testQsn	= array();
					for($j=0;$j<count($questionArr);$j++)
					{
							$questions["question_id"]=$questionArr[$j]->question_id;
						    $questions['questionNo']		= $j+1;
							//$questions["test_id"]=$test_id;
							$questions["question"]=$questionArr[$j]->question;
							$questions["questionFile"]=$questionArr[$j]->questionFile;
							$questions["is_file"]=$questionArr[$j]->quesIsFile;
							$questions["question_marks"]=$questionArr[$j]->marks;
							$questions["created_at"]=$questionArr[$j]->created_at;
							$questions["updated_at"]=$questionArr[$j]->updated_at;
							$questions["isEnabled"]=$questionArr[$j]->isEnabled;
							$questions["isDeleted"]=$questionArr[$j]->isDeleted;
							$questions["flag"]=$questionArr[$j]->flag;
						    $ansArr						= $quesObject->getQuestionsAns($questionArr[$j]->question_id);
						    $questions['options']		= $ansArr;
						 array_push($testQsn,$questions);
					 }
					
					
				  
					$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_OK ,'data'=>$testQsn,TAG_MESSAGE => 'Test submited successfully.');
			}
				
				else
					$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_FAIL ,'data'=>array(),TAG_MESSAGE => 'Test submittion fail');
			  
		}else{
			$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_FAIL ,'data'=>array(),TAG_MESSAGE => 'Test submittion fail');
		}	
	 	echo json_encode($mobileResponseArray); 
		
   });  

	$app->post('/getAnalytics', function () use ($app) {
		$test_id             = $app->request->post('test_id');
		$student_id          = $app->request->post('userid');
		$testObject 		 = new Test(SERVER_API_KEY); 
		$quesObject 		 = new Question(SERVER_API_KEY); 
		if($test_id!=0){
			$where['test_id']	 = $test_id;
			$test_details	     = $testObject->getTest($where);
			//print_r($test_details);die;
			$questionDetails	 = $quesObject->getAnalyticsQuestion($test_id);		//collection all questions of test for sequence of questions
			$resultDetails	 	 = $testObject->getResultDetails($test_id,$student_id);	//getting result details of student for test
			/*
			$topWaitingDetails	 = $testObject->getTopWaitingTime($resultDetails[0]->test_res_id,1);//calculating top time taken for specific question
			//print_r($topWaitingDetails);die;
			$resultArr		 = $testObject->getResult($topWaitingDetails[0]->test_resultId);	//getting result details of student for test
			//print_r($resultArr);die;
			$questionNo			 = 0;
			for($i=0;$i<count($questionDetails);$i++){
				$questionNo++;
				if($questionDetails[$i]->question_id==$topWaitingDetails[0]->question_id)
					break;
			}

			//$finalArr['QuestionNo']  = "Q-".$questionNo." of ".$resultArr[0]->title;;
			//$finalArr['timetaken']	 = $topWaitingDetails[0]->timetaken;
			//$finalArr['topWaiting']	 = json_encode($topWaitingDetails);
			//print_r($questionDetails);*/
			$perCorrectQuestions = ($resultDetails[0]->correct_ans/$resultDetails[0]->totalQuestion)*100;	//calculate correct question percentage
			$perWrongQuestions   = ($resultDetails[0]->wrong_ans/$resultDetails[0]->totalQuestion)*100;	//calculate correct question percentage
			$notAttemptQuestions = ($resultDetails[0]->notAttempted_ans/$resultDetails[0]->totalQuestion)*100;	//calculate correct question percentage
			$studentMarksPer     = ($resultDetails[0]->student_marks/$test_details[0]->total_marks)*100;	//calculate correct question percentage
			//echo $studentMarksPer;die;
			$finalArr['correctAns']	= $resultDetails[0]->correct_ans;
			$finalArr['wrongAns']	= $resultDetails[0]->wrong_ans;
			$finalArr['notAttempt']	= $resultDetails[0]->notAttempted_ans;
			$finalArr['aggregateCorrect']	= $studentMarksPer;
			$finalArr['aggregateWrong']	= 100-$studentMarksPer;

		//	print_r($finalArr);die;
			$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_OK ,'data' => $finalArr);
		}else{
			$resultDetails	 	 = $testObject->getResultDetails($test_id,$student_id);	//getting result details of student for test
			$totalQues			 = 0;
			$correct_ans		 = 0;
			$notAttempted_ans	 = 0;
			$wrong_ans			 = 0;
			$student_marks		 = 0;
			$test_marks			 = 0;
			$resids				= array();
			for($i=0;$i<count($resultDetails);$i++){
				$where['test_id']	 = $resultDetails[$i]->test_id;
				$test_details	     = $testObject->getTest($where);
				$totalQues			= $totalQues 		+ $resultDetails[$i]->totalQuestion;
				$correct_ans		= $correct_ans		+ $resultDetails[$i]->correct_ans;
				$notAttempted_ans	= $notAttempted_ans	+ $resultDetails[$i]->notAttempted_ans;
				$wrong_ans			= $wrong_ans		+ $resultDetails[$i]->wrong_ans;
				$student_marks		= $student_marks	+ $resultDetails[$i]->student_marks;
				$test_marks			= $test_marks		+ $test_details[0]->total_marks;
				array_push($resids,$resultDetails[$i]->test_res_id);
				//print_r($topWaitingDetails);
			}
			$resids = implode(",",$resids);
			$testids = implode(",",$testids);
			
			$topWaitingDetails		= $testObject->getTopWaitingTime($resids,0);	//calculating top time taken for specific question
			
			//print_r($topWaitingDetails);
			$resultArr		 = $testObject->getResult($topWaitingDetails[0]->test_resultId);	//getting result details of student for test
			//print_r($resultArr);die;
			$finalArr['timetaken']	= $topWaitingDetails[0]->timetaken;
			$whereTest['test_id']	= $resultArr[0]->test_id;
			$questionDetails	 = $quesObject->getQuestion($whereTest);
			$questionNo			 = 0;
			for($j=0;$j<count($questionDetails);$j++){
				$questionNo++;
				if($questionDetails[$j]->question_id==$topWaitingDetails[0]->question_id)
					break;
			}
			//print_r($questionNo);die;
			
			$perCorrectQuestions	= ($correct_ans/$totalQues)*100;	//calculate correct question 
			$perWrongQuestions 		= ($wrong_ans/$totalQues)*100;	//calculate correct question 
			$notAttemptQuestions	= ($notAttempted_ans/$totalQues)*100;	//calculate correct question 
			$studentMarksPer		= ($student_marks/$test_marks)*100;	//calculate correct question 
			
			$finalArr['QuestionNo'] = "Q-".$questionNo." of ".$resultArr[0]->title;
			//$finalArr['correctAns']	= $perCorrectQuestions;
			//$finalArr['wrongAns']	= $perWrongQuestions;
			//$finalArr['notAttempt']	= $notAttemptQuestions;
			$finalArr['correctAns']	= $correct_ans;
			$finalArr['wrongAns']	= $wrong_ans;
			$finalArr['notAttempt']	= $notAttempted_ans;
			$finalArr['aggregateCorrect']	= $studentMarksPer;
			$finalArr['aggregateWrong']	= 100-$studentMarksPer;
			$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_OK ,'data' => $finalArr);
		}
		
		echo json_encode($mobileResponseArray); 
	});
	$app->post('/getTopWaiting', function () use ($app) {
		$test_id             = $app->request->post('test_id');
		$student_id          = $app->request->post('userid');
		$ismobile            = $app->request->post('ismobile');
		if($ismobile==1){
			$testObject 		 = new Test(SERVER_API_KEY); 
			$quesObject 		 = new Question(SERVER_API_KEY); 
			if($test_id!=0){
				$where['test_id']	 = $test_id;
				$test_details	     = $testObject->getTest($where);
				$questionDetails	 = $quesObject->getTestQuestion($test_id);		//collection all questions of test for sequence of questions
				$resultDetails	 	 = $testObject->getResultDetails($test_id,$student_id);	//getting result details of student for test
				$topWaitingDetails	 = $testObject->getTopWaitingTime($resultDetails[0]->test_res_id,1);//calculating top time taken for specific question	
				$mostwaitedArr		 = array();
				for($i=0;$i<count($topWaitingDetails);$i++){
					$strArr['question']	 = "Q-".$topWaitingDetails[$i]->questionNo;
					$strArr['timetaken'] = $topWaitingDetails[$i]->timetaken;
					array_push($mostwaitedArr,$strArr);
				}
				$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_OK ,'data' => $mostwaitedArr);
			}else{
				$resultDetails	 	 = $testObject->getResultDetails($test_id,$student_id);	//getting result details of student for test
				$resids				= array();
				for($i=0;$i<count($resultDetails);$i++){
					$where['test_id']	 = $resultDetails[$i]->test_id;
					$test_details	     = $testObject->getTest($where);
					array_push($resids,$resultDetails[$i]->test_res_id);
					//print_r($topWaitingDetails);
				}
				$resids = implode(",",$resids);

				$topWaitingDetails		= $testObject->getTopWaitingTime($resids,0);	//calculating top time taken for specific question
				$mostwaitedArr			= array();
				for($i=0;$i<count($topWaitingDetails);$i++){
					$strArr['question']	 = "Test-".$topWaitingDetails[$i]->title." : Q-".$topWaitingDetails[$i]->questionNo;
					$strArr['timetaken'] = $topWaitingDetails[$i]->timetaken;
					array_push($mostwaitedArr,$strArr);
				}
				$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_OK ,'data' => $mostwaitedArr);
			}
		}else{
			$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_FAIL ,TAG_MESSAGE => 'fail');
		}
		
		
		echo json_encode($mobileResponseArray); 
	});

	$app->post('/studentAttemptedTest', function () use ($app) {
		$ismobile            = $app->request->post('ismobile');
		$student_id          = $app->request->post('userid');
		
		if($ismobile==1){
			$where['student_id']=$student_id;
			$studObj	 = new Student();
			$testObj	 = new Test();
			$studentDet	 = $studObj->getStudent($where);
			$data		 = $testObj->getAttemptedTest($studentDet[0]->attempted_test);
			//print_r($testDet);die;
			if(!empty($data))
				$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_OK ,'data' => $data);
			else
				$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_FAIL ,'data' => $data);
		}else{
			$mobileResponseArray	 = array(TAG_STATUS => TAG_RESPONSE_BAD ,'data' => array());
		}
		echo json_encode($mobileResponseArray); 
	});
	
	$app->post('/getCourseReport', function () use ($app) {
		$course     = $app->request->post('course');
		$testObj	= new Test();
		$studObj	= new Student();
		$whereStud['course']=$course;
		//$testData	= $testObj->getCourseTest($course,'');
		$studData	= $studObj->getStudent($whereStud);
		$studIds	= array();
		for($i=0;$i<count($studData);$i++){
			array_push($studIds,$studData[$i]->student_id);
		}
		if(!empty($studIds)){
			for($i=0;$i<count($studIds);$i++){
				$resultData=$testObj->getStudentResult($studIds[$i]);
				if(!empty($resultData)){
					$totalMarks = 0;
					$studMarks	= 0;
					for($j=0;$j<count($resultData);$j++){
						$totalMarks = $totalMarks+$resultData[$j]->total_marks;
						$studMarks  = $studMarks+$resultData[$j]->student_marks;
					
					}
					$aggregate=($studMarks/$totalMarks)*100;
					$studAggr[$studIds[$i]]=$aggregate;
				}else
				{
					/*echo '<a href="#" class="list-group-item">   
					No Data Available
					<span class="pull-right text-muted small"><em></em>
					</span></a>~<a href="#" class="list-group-item">   
					No Data Available
					<span class="pull-right text-muted small"><em></em>
					</span></a>';
					exit();*/
				}
				
			}
			arsort($studAggr);
			$topStr='';
			$counter=0;
			foreach($studAggr as $key=>$value){
				$counter++;
				if($counter<=10){
					$whereStud['student_id'] = $key;
					$studDetails=$studObj->getStudent($whereStud);
					$topStr.='<a href="#" class="list-group-item">   
					'.$counter.'.   '.$studDetails[0]->first_name.' '.$studDetails[0]->last_name.'
					<span class="pull-right text-muted small"><em>'.round($value,2).' %</em>
					</span></a>';
				}
			}
			asort($studAggr);
			//echo $topStr;
			$counter=0;
			$topStr.="~";
			foreach($studAggr as $key=>$value){
				$counter++;
				if($counter<=10){
					$whereStud['student_id'] = $key;
					$studDetails=$studObj->getStudent($whereStud);
					$topStr.='<a href="#" class="list-group-item">  
					'.$counter.'.   '.$studDetails[0]->first_name.' '.$studDetails[0]->last_name.'
					<span class="pull-right text-muted small"><em>'.round($value,2).' %</em>
					</span></a>';
				}
			}
			echo $topStr;
		}

	});

	$app->post('/getSubWiseReport', function () use ($app) {
			$course     = $app->request->post('course');
			$subject    = $app->request->post('subject');
			$testObj	= new Test();
			$studObj	= new Student();
			$whereStud['course']=$course;
			//$testData	= $testObj->getCourseTest($course,'');
			$studData	= $studObj->getStudent($whereStud);
			$studIds	= array();
			for($i=0;$i<count($studData);$i++){
				array_push($studIds,$studData[$i]->student_id);
			}
			if(!empty($studIds)){
				for($i=0;$i<count($studIds);$i++){
					$resultData=$testObj->getStudentSubWiseResult($studIds[$i],$subject);
					//print_r($resultData);
					if(!empty($resultData)){
						$totalMarks = 0;
						$studMarks	= 0;
						for($j=0;$j<count($resultData);$j++){
							$totalMarks = $totalMarks+$resultData[$j]->total_marks;
							$studMarks  = $studMarks+$resultData[$j]->student_marks;

						}
						$aggregate=($studMarks/$totalMarks)*100;
						$studAggr[$studIds[$i]]=$aggregate;
					}else
					{
						/*echo '<a href="#" class="list-group-item">   
						No Data Available
						<span class="pull-right text-muted small"><em></em>
						</span></a>~<a href="#" class="list-group-item">   
						No Data Available
						<span class="pull-right text-muted small"><em></em>
						</span></a>';
						exit();*/
					}

				}
				//die;
				arsort($studAggr);
			
				$topStr='';
				$counter=0;
				foreach($studAggr as $key=>$value){
					$counter++;
					if($counter<=10){
						$whereStud['student_id'] = $key;
						$studDetails=$studObj->getStudent($whereStud);
						$topStr.='<a href="#" class="list-group-item">   
						'.$counter.'.   '.$studDetails[0]->first_name.' '.$studDetails[0]->last_name.'
						<span class="pull-right text-muted small"><em>'.round($value,2).' %</em>
						</span></a>';
					}
				}
				asort($studAggr);
				//echo $topStr;
				$counter=0;
				$topStr.="~";
				foreach($studAggr as $key=>$value){
					$counter++;
					if($counter<=10){
						$whereStud['student_id'] = $key;
						$studDetails=$studObj->getStudent($whereStud);
						$topStr.='<a href="#" class="list-group-item">  
						'.$counter.'.   '.$studDetails[0]->first_name.' '.$studDetails[0]->last_name.'
						<span class="pull-right text-muted small"><em>'.round($value,2).' %</em>
						</span></a>';
					}
				}
				echo $topStr;
			}

		});
	$app->post('/getTestResult', function () use ($app) {
		
			$test_id    = $app->request->post('test_id');
			$pdfFlag    = $app->request->post('pdf');
			if($pdfFlag==0){
				$testObj	= new Test(SERVER_API_KEY);
				//$studObj	= new Student();
				$testRes	=$testObj->getTestResult($test_id);
				$str= '<div class="box-footer">
						 <input type="button" class="btn btn-primary" value="Generate PDF" onclick="getPdf('.$test_id.')"> 
						</div><table class="table table-bordered table-hover " ><thead><tr><th>Sr No</th><th>Student Name</th><th>Test</th><th>Marks (In %) </th>
						</tr></thead><tbody>';
				for($i=0;$i<count($testRes);$i++){
					$studentMarksPer = ($testRes[$i]->student_marks/$testRes[$i]->total_marks)*100;	//calculate correct question
					$str.='<tr><td>'.($i+1).'</td><td>'.$testRes[$i]->first_name.' '.$testRes[$i]->last_name.'</td><td>'.$testRes[$i]->title.'</td><td>'.round($studentMarksPer,2).' % </td></tr>';
				}
				$str.='</tbody></table>';
				echo $str;
			}else{
				$testObj	= new Test(SERVER_API_KEY);
				//$studObj	= new Student();
				$testRes	=$testObj->getTestResult($test_id);
				$str= '<html><style>
table, td, th {
    border: 1px solid black;
	padding: 15px;
    text-align: center;
}

table {
    border-collapse: collapse;
    width: 100%;
}

th {
    height: 50px;
}
</style><table style="border:1 px solid"; ><thead><tr><th>Sr No</th><th>Student Name</th><th>Test</th><th>Marks (In %) </th>
						</tr></thead><tbody>';
				for($i=0;$i<count($testRes);$i++){
					$studentMarksPer		= ($testRes[$i]->student_marks/$testRes[$i]->total_marks)*100;	//calculate correct question 
					$str.='<tr><td>'.($i+1).'</td><td>'.$testRes[$i]->first_name.' '.$testRes[$i]->last_name.'</td><td>'.$testRes[$i]->title.'</td><td>'.round($studentMarksPer,2).' % </td></tr>';
					$title=$testRes[$i]->title;
				}
				$str.='</tbody></table></html>';
				 date_default_timezone_set("Asia/Kolkata");
    			$filename = $title.'_Result';
				$filename=$filename.date('d-m-Y-H-i-s').'.pdf';
				require('../../libs/phpToPDF/phpToPDF.php');
				$pdf_options = array(
				  "source_type" => 'html',
				  "source" => $str,
				  "action" => 'save',
				  "save_directory" => '../../reports/',
				  "file_name" => $filename);

				//Code to generate PDF file from options above
				 phptopdf($pdf_options);
				echo $filename;
			}
			//die;
	});
$app->run();

?>
