<?php 
    //ENTER THE RELEVANT INFO BELOW

    require "include/Config.php";

    require_once 'include/student.php';
    require_once 'include/course.php';
    require_once 'include/Utils.php';
    $studentObject = new Student(SERVER_API_KEY);
    $courseObject = new Course(SERVER_API_KEY);
    $data = $studentObject->getData(TABLE_STUDENT,'','','');

    $exportdata="Student id,Course,First Name,Last Name,Address,Email Address,Phone number,Password\n";
    foreach($data as $row)
    {
        $courseResult=$courseObject->getData(TABLE_COURSE,array('course_name'),array("course_id"=>$row->course),'');
        $row->password=Utils::decode($row->password);
        $exportdata.=$row->student_id.",".$courseResult[0]->course_name.",".$row->first_name.",".$row->last_name.",".$row->address.",".$row->email.",".$row->phone.",". $row->password."\n";

    }


        date_default_timezone_set('Asia/Kolkata');
        $backup_name = "student-list.csv";
        header('Content-Type: application/octet-stream');   
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"".$backup_name."\"");  
        echo $exportdata; exit;

?>