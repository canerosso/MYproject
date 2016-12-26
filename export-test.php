<?php 
    //ENTER THE RELEVANT INFO BELOW

    require "include/Config.php";

    require_once 'include/test.php';
    require_once 'include/course.php';
    require_once 'include/sub.php';
    require_once 'include/Utils.php';
    $testObject = new Test(SERVER_API_KEY);
    $subjectObject = new sub(SERVER_API_KEY);
    $courseObject = new Course(SERVER_API_KEY);

    $exportdata = "";
    $orderby="s.first_name";
    $testResult=$testObject->getTestResult($_GET['Id'],$orderby);

    if(count($testResult)>0)
    {
        $testResult2=$testObject->getData(TABLE_TEST, array('created_at'), array("test_id" => $_GET['Id']), '');

        $testdate= date('d/m/Y',strtotime($testResult2[0]->created_at));

        $courseResult = $courseObject->getData(TABLE_COURSE, array('course_name'), array("course_id" => $testResult[0]->course), '');

        $subjectResult = $subjectObject->getData(TABLE_CAT, array('cat_name'), array("cat_id" => $testResult[0]->subject), '');

        $exportdata.= "Test title," . $testResult[0]->title . "\n";
        $exportdata .= "Course," . $courseResult[0]->course_name . "\n";
        $exportdata .= "Subject," . $subjectResult[0]->cat_name  . "\n";
        $exportdata .= "Date," . $testdate . "\n";
        $exportdata .= "Sr. No,Student Id,Student First Name,Student Last Name,Positive Marks, Negative Marks, Total Marks\n";
        $i=1;
        foreach ($testResult as $row)
        {

            $exportdata .= $i.",".$row->student_id . "," . $row->first_name . "," . $row->last_name . "," . $row->correct_ans . "," . $row->wrong_ans . "," . $row->student_marks . "\n";

        }
    }
    else
        {   $exportdata.= "The test is not yet conducted.\n";    }


        date_default_timezone_set('Asia/Kolkata');

        header('Content-Type: application/octet-stream');   
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=test-results.csv");
        echo $exportdata; exit;

?>