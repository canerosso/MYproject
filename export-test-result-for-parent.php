<?php

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

require "include/Config.php";

require_once 'include/test.php';
require_once 'include/course.php';
require_once 'include/sub.php';
$testObject = new Test(SERVER_API_KEY);
$subjectObject = new sub(SERVER_API_KEY);
$courseObject = new Course(SERVER_API_KEY);


require_once 'classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
$sheet = $objPHPExcel->getActiveSheet();
$objWorkSheet = $objPHPExcel->createSheet(0);

$testResult=$testObject->getTestResultForParent1($_GET['Id']);


    if(count($testResult)>0) {


        $courseResult = $courseObject->getData(TABLE_COURSE, array('course_name'), array("course_id" => $testResult[0]->course), '');
        $subjectResult = $subjectObject->getData(TABLE_CAT, array('cat_name'), array("cat_id" => $testResult[0]->subject), '');
        $testdate= date('d/m/Y',strtotime($testResult[0]->created_at));

        $objWorkSheet->setCellValue("A1","Test Title" )
            ->setCellValue("A2", "Course")
            ->setCellValue("A3", "Subject")
            ->setCellValue("A4", "Date" )
            ->setCellValue("B1",$testResult[0]->title)
            ->setCellValue("B2",$courseResult[0]->course_name )
            ->setCellValue("B3",$subjectResult[0]->cat_name)
            ->setCellValue("B4", $testdate)
            ->setCellValue("A5", "Sr. No" )
            ->setCellValue("B5","Student Id" )
            ->setCellValue("C5","No. of correct ans" )
            ->setCellValue("D5","No. of incorrect ans" )
            ->setCellValue("E5","No. of unanswered questions" )
            ->setCellValue("F5","Total time taken" )
            ->setCellValue("G5","Total marks" )
            ->setCellValue("H5","Percentile" );
            $i=6;
            $j=1;

            foreach ($testResult as $row)
            {

                $timetaken=$testObject->getTotalTimeTaken($row->test_id,$row->id);
                $percentile= $testObject->getPercentile($row->test_id,$row->student_marks);

                $objWorkSheet->setCellValue("A$i", $j )
                    ->setCellValue("B$i", $row->student_id)
                    ->setCellValue("C$i", $row->correct_ans)
                    ->setCellValue("D$i", $row->wrong_ans)
                    ->setCellValue("E$i",$row->notAttempted_ans )
                    ->setCellValue("F$i", $timetaken )
                    ->setCellValue("G$i",$row->student_marks )
                    ->setCellValue("H$i",$percentile );
                $j++; $i++;
            }

    }
    else
    {
        $objWorkSheet->setCellValue('A1', 'The test is not yet conducted.');    }

//Start adding next sheets
$objWorkSheet->setTitle("Test Result");


$objWorkSheet = $objPHPExcel->createSheet(1);

$testResult2=$testObject->getTestResultForParent2($_GET['Id']);


if(count($testResult2)>0) {

    $courseResult = $courseObject->getData(TABLE_COURSE, array('course_name'), array("course_id" => $testResult[0]->course), '');
    $subjectResult = $subjectObject->getData(TABLE_CAT, array('cat_name'), array("cat_id" => $testResult[0]->subject), '');
    $testdate= date('d/m/Y',strtotime($testResult[0]->created_at));
    $objWorkSheet->setCellValue("A1","Test Title" )
        ->setCellValue("A2", "Course")
        ->setCellValue("A3", "Subject")
        ->setCellValue("A4", "Date" )
        ->setCellValue("B1",$testResult[0]->title)
        ->setCellValue("B2",$courseResult[0]->course_name )
        ->setCellValue("B3",$subjectResult[0]->cat_name)
        ->setCellValue("B4", $testdate)
        ->setCellValue("A5", "Sr. No" )
        ->setCellValue("B5","Student Id" )
        ->setCellValue("C5","Question no." )
        ->setCellValue("D5","Topic" )
        ->setCellValue("E5","Waiting time" )
        ->setCellValue("F5","Right/Wrong/Unanswered" );

    $i=6;
    $j=1;
    foreach ($testResult2 as $row)
    {

        $objWorkSheet->setCellValue("A$i", $j )
            ->setCellValue("B$i", $row->student_id)
            ->setCellValue("C$i", $row->questionNo)
            ->setCellValue("D$i", $row->name)
            ->setCellValue("E$i",$row->timetaken )
            ->setCellValue("F$i", $row->answerstatus );

        $j++; $i++;
    }

}
else
{
    $objWorkSheet->setCellValue('A1', 'The test is not yet conducted.');    }

//Start adding next sheets
$objWorkSheet->setTitle("Question Wise Test Result");


$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="test-result-for-parent.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
