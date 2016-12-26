<?php
set_time_limit(50000);
//session_start();
error_reporting(-1);
ini_set('display_errors', 'On');

require_once '../../libs/Slim/Slim.php';
require_once '../../include/Config.php';
require_once '../../include/student.php';
require_once '../../include/sub.php';
require_once '../../include/test.php';
require_once '../../include/course.php';
require_once '../../include/sub.php';
require_once '../../include/flashcard.php';
require_once '../../include/syllabus.php';
require_once '../../include/Utils.php';


\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();


############################### Update sub status ########
 $app->get('/updateStudStatus/:id/:status/:page/:course/:reff', function ($id,$status,$page,$course,$reff) use ($app) {

     $params['isEnabled']			= $status;
     $params['id'] 			= $id;
     $studObject 					= new  Student(SERVER_API_KEY);
     $lastInsertId 					=  $studObject->updateStatus($params);
	 $_SESSION["type"] = "success";
	 if($status==1)
		$_SESSION["msg"] = "Activated successfully.";
	 else
		$_SESSION["msg"] = "Deactivated successfully.";
	 if($reff==1)
 	 	$app->redirect(URL.'student.php?page='.$page.'&course='.$course);
	 else
		$app->redirect(URL.'courseStudent.php?page='.$page.'&course='.$course);
});

   $app->get('/deleteStudent/:id/:page/:course/:reff', function ($id,$page,$course,$reff) use ($app) {
     $studObject					= new  Student(SERVER_API_KEY);
     $lastInsertId					=  $studObject->deleteStudent($id);
     $_SESSION["type"] 				= "success";
	 $_SESSION["msg"] 				= "Deleted successfully.";
     
 	 $app->redirect(URL.'student.php?course='.$course);
	
});
         
    $app->post('/addStudent', function () use ($app) {
         $studObject 				= new Student(SERVER_API_KEY);
		 $uploaddir					= '../../uploads/Students/';

         $ext= pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
		 $filename					= md5(uniqid($app->request->post('student_id'),true)).".$ext";
		 $uploadfile 				= $uploaddir .$filename;

 		 if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile)) {
			$params['photo']			= $filename;
		 } else {
			$params['photo']			= '';
		 }
		$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	    $random_string_length=strlen($characters);
		$string = '';
	    $max = strlen($characters) - 1;
		for ($i = 0; $i < 6; $i++) {
			$string .= $characters[mt_rand(0, $max)];
		}

		$encrypted_password=Utils::encode($string);
		// echo Utils::decode($encrypted_password);
		 $params['student_id']		= $app->request->post('studentid');
		 $params['first_name']		= $app->request->post('firstName');
		 $params['last_name']		= $app->request->post('lastName');
	 	 $params['address']			= $app->request->post('address');
	 	 $params['email']			= $app->request->post('email');
	 	 $params['phone']			= $app->request->post('phone');
	 	 $params['course']			= $app->request->post('course');
	 	 $params['attendance']		= $app->request->post('attendance');
		 $params['password']		= $encrypted_password;
         $params['created_at']		= Utils::getCurrentDateTime();
         $params['updated_at']		= Utils::getCurrentDateTime();
         $params['isEnabled']	 	= 1;
         $params['isDeleted']		= 0;
		// print_r($params);die;
		 $lastInsertId 				=  $studObject->add($params);     
		 $_SESSION["type"] = "success";
		 $_SESSION["msg"] = "Student added successfully.";
         $app->redirect(URL.'student.php');
   });

$app->post('/addDiscussion', function () use ($app) {
	$studObject 				= new Student(SERVER_API_KEY);
	$params['studentid']		= $app->request->post('student');
	$params['discussion']		= $app->request->post('discussion');
	$params['createdon']		= Utils::getCurrentDateTime();

	$lastInsertId 				=  $studObject->adddiscussion($params);
	$_SESSION["type"] = "success";
	$_SESSION["msg"] = "Discussion added successfully.";
	$app->redirect(URL.'parent-discussion.php?Id='.$params['studentid']);
});

$app->post('/getTrending', function () use ($app)
{

        $studentid 	= $app->request->post('studentid');
		$studentObj=  new Student(SERVER_API_KEY);
        $studentdata= $studentObj->getStudent(array('id'=>$studentid));
        $studentdata=$studentdata[0];

		$data=array();

		$subobj = new sub(SERVER_API_KEY);

		$result=$subobj->getData(TABLE_CAT, array('cat_id','cat_name','course'), '', '');
		$data['subject']=array();
		$subarray=array();
		foreach($result as $row)
		{

            $row->course=@explode(",",$row->course);
           // print_r($row->course);
            if(in_array($studentdata->course,$row->course)) 
            {
            	array_push($subarray,$row->cat_id);
                array_push($data['subject'], array("name" => $row->cat_name, "id" => $row->cat_id));
            }
		}

		$result=$subobj->getData(TABLE_TEST, array('test_id','title'), array('isSpecial'=>1,'course'=>$studentdata->course), '');

		$data['specialtest']=array();
		foreach($result as $row)
		{
			array_push($data['specialtest'],array("name"=>$row->title,"id"=>$row->test_id));
		}
		
		$result=$subobj->getData(TABLE_TOPIC, array('id','name','subjectid'),'' , '');
		$data['topic']=array();
		foreach($result as $row)
		{
			if(in_array($row->subjectid,$subarray))
			{
				array_push($data['topic'],array("name"=>$row->name,"id"=>$row->id));
			}
		}
		echo json_encode(array('data' => $data));
		
   }); 

$app->post('/getStudentTrending', function () use ($app) {
	
        
		$student 	= $app->request->post('studentid');
		$subject 	= $app->request->post('subjectid');
		
		$testobj = new Test(SERVER_API_KEY);
		$data=array();
		$result=$testobj->getPercentageTrend($student,$subject,'NO');
		array_push($data,array('test_id'=>'0','student_id'=>$student,'test_date'=>'00/00/0000','test_title'=>'Initial','student_marks'=>'0','total_marks'=>'0',
			        'percentage'=>"0",'percentile'=>'0'));
		
		foreach($result as $row)
		{
			$percentile=$testobj->getPercentile($row->test_id, $row->student_marks);
			$row->percentile=strval($percentile);
			array_push($data,$row);
		}
		
		if(count($data)==1)
			$data=array();
		
		echo json_encode(array('data' => $data));
		
   }); 
   
   
$app->post('/importStudents', function () use ($app) {
	$studObject 				= new Student(SERVER_API_KEY);

	$uploaddir					= '../../uploads/Students/Excels/';
	$filename					= "Input".rand(1000,100000).".xls";
	$uploadfile 				= $uploaddir .$filename;
	move_uploaded_file($uploadfile);

	require_once '../../excelreader/reader.php';
	$data = new Spreadsheet_Excel_Reader();
	$data->setOutputEncoding('CP1251');
	$data->read($_FILES['excelfile']['tmp_name'],$uploadfile);
	$strerrors="Student Id,Course,First Name,Last Name,Address,Email Address,Phone Number,Error\n";
	//error_reporting(E_ALL ^ E_NOTICE);
	$errormsg="";
	if($data->sheets[0]['numRows']==1)
	{

		$errormsg="<div class=' alert-danger' style='padding:10px;margin-bottom:10px;'><strong>Error!</strong> no data found.</div>";
	}
	else if($data->sheets[0]['numCols']!=7)
	{
		$errormsg="<div class=' alert-danger' style='padding:10px;margin-bottom:10px;'><strong>Error!</strong> Invalid template format.</div>";

	}

	function IsAlphaNumeric($str,$size)
	{
		if(strlen($str)>$size)
			return false;
		else
			return preg_match('/^[a-zA-Z0-9 ]+$/', $str);
	}

	function maxlength($str,$size)
	{
		return (strlen($str)>=$size);
	}

	$errcount=0;
	$dupentries=0;
	$successcount=0;
	$studObject = new Student(SERVER_API_KEY);
	$courseObject = new Course(SERVER_API_KEY);

	if($errormsg=="")
	{
		for ($i = 2; $i < $data->sheets[0]['numRows']+1; $i++)
		{
			$courseresult = $courseObject->getCourseId(array('course_name' => trim($data->sheets[0]['cells'][$i][2])));
			if(!IsAlphaNumeric(trim($data->sheets[0]['cells'][$i][1]),100) || !IsAlphaNumeric(trim($data->sheets[0]['cells'][$i][2]),100) || !IsAlphaNumeric(trim($data->sheets[0]['cells'][$i][3]),100) || !IsAlphaNumeric(trim($data->sheets[0]['cells'][$i][4]),100) || !is_numeric(trim($data->sheets[0]['cells'][$i][7])) )
			{
				$strerrors.=trim($data->sheets[0]['cells'][$i][1]).",".trim($data->sheets[0]['cells'][$i][2]).",".trim($data->sheets[0]['cells'][$i][3]).",".trim($data->sheets[0]['cells'][$i][4]).",".trim($data->sheets[0]['cells'][$i][5]).",".trim($data->sheets[0]['cells'][$i][6]).",".trim($data->sheets[0]['cells'][$i][7]).",Data Validation Error\n";
				$errcount++;
			}
			else if($courseresult==array())
			{
				$strerrors.=trim($data->sheets[0]['cells'][$i][1]).",".trim($data->sheets[0]['cells'][$i][2]).",".trim($data->sheets[0]['cells'][$i][3]).",".trim($data->sheets[0]['cells'][$i][4]).",".trim($data->sheets[0]['cells'][$i][5]).",".trim($data->sheets[0]['cells'][$i][6]).",".trim($data->sheets[0]['cells'][$i][7]).",Course not found\n";
				$errcount++;
			}
			else
			{
				
				
				$dupcheckresult=$studObject->checkDuplicateById(trim($data->sheets[0]['cells'][$i][1]));
				if($dupcheckresult==0) {
					$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
					$random_string_length = strlen($characters);
					$string = '';
					$max = strlen($characters) - 1;
					for ($j = 0; $j < 6; $j++) {
						$string .= $characters[mt_rand(0, $max)];
					}
					$encrypted_password = Utils::encode($string);
					// echo Utils::decode($encrypted_password);
					//$courseresult = $courseObject->getCourseId(array('course_name' => trim($data->sheets[0]['cells'][$i][2])));

					$courseid = $courseresult[0]->course_id;
					$params['photo'] = '';
					$params['student_id'] = trim($data->sheets[0]['cells'][$i][1]);
					$params['course'] = $courseid;
					$params['first_name'] = trim($data->sheets[0]['cells'][$i][3]);
					$params['last_name'] = trim($data->sheets[0]['cells'][$i][4]);
					$params['address'] = trim($data->sheets[0]['cells'][$i][5]);
					$params['email'] = trim($data->sheets[0]['cells'][$i][6]);
					$params['phone'] = trim($data->sheets[0]['cells'][$i][7]);
					$params['attendance'] = '';
					$params['password'] = $encrypted_password;
					$params['created_at'] = Utils::getCurrentDateTime();
					$params['updated_at'] = Utils::getCurrentDateTime();
					$params['isEnabled'] = 1;
					$params['isDeleted'] = 0;
					//print_r($params);
					$lastInsertId = $studObject->add($params);
					$successcount++;
				}else { $dupentries++; }
			}
		}

		if($dupentries==0)
		{
			$errormsg .= "<div class=' alert-danger' style='padding:10px;margin-bottom:10px;'><strong>Duplicate! </strong> No duplicate entry found. </div>";
		}
		else
		{
			$errormsg .= "<div class=' alert-danger' style='padding:10px;margin-bottom:10px;'><strong>Duplicate! </strong> Skipped $dupentries duplicate entry.  </div>";
		}
		if($errcount>0)
		{
			$errorfile="errors-".rand(1000,100000).".csv";
			$myfile = fopen('../../uploads/Students/Excels/'.$errorfile, "w") or die("Unable to open file!");
			fwrite($myfile, $strerrors);
			fclose($myfile);

			$errormsg.="<div class=' alert-danger' style='padding:10px;margin-bottom:10px;'><strong>Error!</strong> Uploaded file has data errors. <a href='uploads/Students/Excels/$errorfile' style='color:#FFF; text-decoration: underline;'>click here to download error file.</a>  </div>";
		}
		else
		{
			$errormsg.="<div class=' alert-danger' style='padding:10px;margin-bottom:10px;'><strong>Error! </strong> no validation error found. </div>";
		}

	}
	$errormsg.="<div class='alert-success' style='padding:10px;margin-bottom:10px;'><strong>Success! </strong> $successcount record(s) uploaded successfuly. </div>";

	echo "<div style='padding:20px'>$errormsg</div>";

	/*$_SESSION["type"] = "success";
	$_SESSION["msg"] = "Student added successfully.";
	$app->redirect(URL.'student.php');*/
});
  
   
 $app->post('/updateStudent', function () use ($app) {
         $uploaddir 				= '../../uploads/Students/';

         $ext= pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
         $filename					= md5(uniqid($app->request->post('id'),true)).".$ext";
         $uploadfile 				= $uploaddir .$filename;


 		 if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile)) {
			$params['photo']			= $filename;
		 }
	 	 $studObject 				= new Student(SERVER_API_KEY);

         $encrypted_password=Utils::encode($app->request->post('password'));
		
		 $params['student_id']		= $app->request->post('studentid');
		 $params['first_name']		= $app->request->post('firstName');
		 $params['last_name']		= $app->request->post('lastName');
	 	 $params['address']			= $app->request->post('address');
	 	 $params['email']			= $app->request->post('email');
	 	 $params['phone']			= $app->request->post('phone');
	 	 $params['course']			= $app->request->post('course');
	 	 $params['attendance']		= $app->request->post('attendance');
		 $params['updated_at']		= Utils::getCurrentDateTime();
         $params['id']		= $app->request->post('id');
		 $page						= $app->request->post('page');
	 	 $lastInsertId 				= $studObject->updateStudent($params);   
		
	 	 $_SESSION["type"] = "success";
		 $_SESSION["msg"] = "Updated successfully.";
         $app->redirect(URL.'student.php');     
   });  

 $app->post('/checkDuplicate', function () use ($app) {
  		$email						= $app->request->post('email');
	 	$where['email']				= $email;
	 	$studObject					= new Student(SERVER_API_KEY);
		$value						= $studObject->checkDuplicate($where);

	  	if(!empty($value))
			echo 1;
	  	else
			echo 0;
  });    
	$app->post('/checkDuplicateEdit', function () use ($app) {
  		$email						= $app->request->post('email');
  		$id							= $app->request->post('id');
	 	$where['email']				= $email;
	 	$where['student_id']		= $id;
	 	$instituteObj 				= new Student(SERVER_API_KEY);
		$value						= $instituteObj->checkDuplicateEdit($where);

	  	if(!empty($value))
			echo 1;
	  	else
			echo 0;
  });  

###################### API INTEGRATION #####################################

 $app->post('/signIn', function () use ($app) {
  		$ismobile						= $app->request->post('ismobile');
	 	if($ismobile==1){
			$email						= $app->request->post('email');
			$password					= $app->request->post('password');
			$where['email']				= $email;
			$encrypted_password			= Utils::encode($password);
			$where['password']			= $encrypted_password;
			$where['isEnabled']			= 1;
			$where['isDeleted']			= 0;
			$studObj	 				= new Student(SERVER_API_KEY);
			$value					    = $studObj->getStudent($where);

            if($value==array())
            {
                    $mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_FAIL, 'data' => $value, 'message' => 'Invalid username or password');
            }
            else
            {
                /*** for getting suject and their pdf ***/
                $subObj = new sub(SERVER_API_KEY);
                $whereCat['course'] = $value[0]->course;
                $subData = $subObj->getCourseSub($whereCat);
                $catids = array();
                $subArray = array();
                for ($i = 0; $i < count($subData); $i++) {
                    $sub['cat_id'] = $subData[$i]->cat_id;
                    $subDetails = $subObj->getSub($sub);
                    $subjectArray['sub_id'] = $subDetails[0]->cat_id;
                    $subjectArray['subject_name'] = $subDetails[0]->cat_name;
                    $subjectArray['pdf'] = $subObj->getSubjPdf($subDetails[0]->cat_id);
                    array_push($subArray, $subjectArray);
                }

                $value[0]->subjects = $subArray;

                /*** for getting flashcard and their pdf ***/
                $flashObj = new Flashcard(SERVER_API_KEY);
                $whereFlash['course'] = $value[0]->course;
                $flashData = $flashObj->getFlashCard($whereFlash);
                $catids = array();
                $flashArray = array();
                if (!empty($flashData)) {
                    for ($i = 0; $i < count($flashData); $i++) {
                        //	echo $i.">>";
                        $flashId['flashcard_id'] = $flashData[$i]->flashcard_id;
                        $flashcardArray['flashcard_id'] = $flashData[$i]->flashcard_id;
                        $flashcardArray['title'] = $flashData[$i]->title;
                        $flashcardArray['pdf'] = $flashObj->getFlashCardData($flashId);
                        array_push($flashArray, $flashcardArray);
                    }
                } else
                    $flashArray = array();
                //die;
                $value[0]->flashcard = $flashArray;

                /*** for getting syllabus and their pdf ***/
                $syllObj = new Syllabus(SERVER_API_KEY);
                $whereSyll['course'] = $value[0]->course;
                $syllData = $syllObj->getSyllabus($whereSyll);
                $syllArray = array();
                //print_r($flashData);die;
                for ($i = 0; $i < count($syllData); $i++) {
                    $syllId['syllabus_id'] = $syllData[$i]->syllabus_id;
                    $syllabusArray['syllabus_id'] = $syllData[$i]->syllabus_id;
                    $syllabusArray['title'] = $syllData[$i]->title;
                    $syllabusArray['pdf'] = $syllObj->getSyllabusData($syllId);
                    array_push($syllArray, $syllabusArray);
                }
                $value[0]->syllabus = $syllArray;

                if (!empty($value)) {
                    $mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_SUCCESS, 'data' => $value);
                } else {
                    $mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_FAIL, 'data' => $value, 'message' => 'Invalid username or password');
                }
            }
		}else{
			$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_FAIL ,'data' => 'Invalid Data','message'=>'Invalid mobile');
		}
	 	echo json_encode($mobileResponseArray);
  });	
 $app->post('/syncPDF', function () use ($app) {
  		$ismobile						= $app->request->post('ismobile');
	 	if($ismobile==1){
			$course						= $app->request->post('course');
			$subObj						= new sub(SERVER_API_KEY);
			$whereCat['course']			= $course;
			$subData					= $subObj->getCourseSub($whereCat);						
			$catids						= array();
			$subArray					= array();
			for($i=0;$i<count($subData);$i++){
				$sub['cat_id']			= $subData[$i]->cat_id;
				$subDetails=$subObj->getSub($sub);
				$subjectArray['sub_id'] = $subDetails[0]->cat_id;
				$subjectArray['subject_name'] = $subDetails[0]->cat_name;
				$subjectArray['pdf'] = $subObj->getSubjPdf($subDetails[0]->cat_id);
				array_push($subArray,$subjectArray);
			}
			
			$value['subjects']			= $subArray;
			
			/*** for getting flashcard and their pdf ***/
			$flashObj					= new Flashcard(SERVER_API_KEY);
			$whereFlash['course']		= $course;
			$flashData					= $flashObj->getFlashCard($whereFlash);		
			$catids						= array();
			$flashArray					= array();
			if(!empty($flashData)){
				for($i=0;$i<count($flashData);$i++){
				//	echo $i.">>";
					$flashId['flashcard_id']	 = $flashData[$i]->flashcard_id;
					$flashcardArray['flashcard_id']  = $flashData[$i]->flashcard_id;
					$flashcardArray['title'] 		 = $flashData[$i]->title;
					$flashcardArray['pdf'] 		 	 = $flashObj->getFlashCardData($flashId);
					array_push($flashArray,$flashcardArray);
				}
			}else
				$flashArray=array();
			//die;
			$value['flashcard']     = $flashArray;
			
			/*** for getting syllabus and their pdf ***/
			$syllObj					= new Syllabus(SERVER_API_KEY);
			$whereSyll['course']		= $course;
			$syllData					= $syllObj->getSyllabus($whereSyll);		
			$syllArray					= array();
			//print_r($flashData);die;
			for($i=0;$i<count($syllData);$i++){
				$syllId['syllabus_id']	 = $syllData[$i]->syllabus_id;
				$syllabusArray['syllabus_id']  = $syllData[$i]->syllabus_id;
				$syllabusArray['title'] 		 = $syllData[$i]->title;
				$syllabusArray['pdf'] 		 	 = $syllObj->getSyllabusData($syllId);
				array_push($syllArray,$syllabusArray);
			}
			$value['syllabus']     = $syllArray;
			
			if(!empty($value)){
				$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_SUCCESS ,'data' => $value);
			}else{
				$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_FAIL ,'data' => $value,'message'=>'Invalid username or password');
			}
		}else{
			$mobileResponseArray = array(TAG_STATUS => TAG_RESPONSE_FAIL ,'data' => 'Invalid Data','message'=>'Invalid mobile');
		}
	 	echo json_encode($mobileResponseArray);
  });	
###################### API INTEGRATION #####################################
$app->post('/getCourseStudent', function () use ($app) {
        $course =  $app->request->post('course');
		$page 	=  $app->request->post('page');
		$app->redirect(URL.'student.php?course='.$course);     
   });
$app->run();

?>