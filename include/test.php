<?php
     @session_start();
error_reporting(1);
  # include lib
  require_once 'Config.php';
  require_once 'DatabaseConnection.php';  
  require_once 'Controller.php';
  require_once 'Utils.php';
  require_once 'Security.php';
  require_once 'SendMail.php';
  
  class Test extends Controller
  {
    var $tableName;
    
    function __construct($api_key)
    {
      
        parent::__construct($api_key);
      $this->tableName = TABLE_TEST;
      
    }
	function getAlltests($page)
	{
		//echo ">>>".$page;
		if($page!=0){
			if($page==1){

				$skip=0;
			}
			else{

				$page=$page-1;
				$skip=$page*10;
			}
			$limit=10;	
			if($skip!=0)
				$selectQuery='Select * from '.$this->tableName.' where isDeleted=0 ORDER BY test_id DESC LIMIT '.$limit.', '.$skip;
			else
				$selectQuery='Select * from '.$this->tableName.' where isDeleted=0 ORDER BY test_id DESC LIMIT '.$limit;
			$selectStatement = $this->databaseConnection->prepare($selectQuery);
			$selectStatement->execute();
			return $selectStatement->fetchAll(PDO::FETCH_OBJ);
			
		}else{
			$selectQuery='Select * from '.$this->tableName.' where isDeleted=0 and isEnabled=1 ORDER BY test_id DESC';
			
			$selectStatement = $this->databaseConnection->prepare($selectQuery);
			$selectStatement->execute();
			return $selectStatement->fetchAll(PDO::FETCH_OBJ);
		}


	  }

	
	function GetCountOfTest(){
			$selectQuery='Select * from '.$this->tableName.' where isDeleted=0';
			$selectStatement = $this->databaseConnection->prepare($selectQuery);
			$selectStatement->execute();
			return count($selectStatement->fetchAll(PDO::FETCH_OBJ));
		}
   
  function add($params){
              
      $fields = array_keys($params);
      $values = array_values($params);
      return parent::insertData($this->tableName,$fields,$values);

    }
	function addTestResult($params){

		  $fields = array_keys($params);
		  $values = array_values($params);
		  return parent::insertData(TABLE_TESTRESULT,$fields,$values);

	}
	function addResultOptions($params){

		  $fields = array_keys($params);
		  $values = array_values($params);
		  return parent::insertData(TABLE_TESTRESULTOPT,$fields,$values);

	}
    function updateTest($params){
              
      $fields = array_keys($params);
      $values = array_values($params);
      //print_r($params); echo ">>>>>>>>>"; die;
      return parent::updateData($this->tableName,$fields,$values,1);

    }

      function updateTestScore($testid)
      {
          $selectStatement = $this->databaseConnection->prepare("CALL update_test_score_question_count(?)");
          $selectStatement->bindParam(1, $testid, PDO::PARAM_INT);
          $selectStatement->execute();
          return $selectStatement->fetchAll(PDO::FETCH_OBJ);

      }
  function updateQuestionCount($params){
      $selectQuery='UPDATE '.$this->tableName.' SET total_questions='.$params['total_questions'].',total_marks='.$params['total_marks'].' , updated_at="'.$params['updated_at'].'" WHERE test_id='.$params['test_id'];
	
		$selectStatement = $this->databaseConnection->prepare($selectQuery);
		$selectStatement->execute();

    }
  function updateSubStatus($params){
           //   echo $params['isEnabled'];die;
    	$selectQuery='UPDATE '.$this->tableName.' SET isEnabled='.$params['isEnabled'].' WHERE cat_id='.$params['cat_id'];
		$selectStatement = $this->databaseConnection->prepare($selectQuery);
		$selectStatement->execute();
      //return parent::updateData($this->tableName,$fields,$values,1);

    }
      function updateStatus($params){
              
      $fields = array_keys($params);
      $values = array_values($params);
      //print_r($params);
      return parent::updateData($this->tableName,$fields,$values,1);

    }
  function getTest($where)
	{
		$orderby="ASC";
		return parent::getData($this->tableName,'',$where,$orderby);
	}
function  deleteTest($id){
 
     $deleted = "DELETE FROM ".$this->tableName."WHERE test_id=".$id;
    

      try{
                return parent::excuteQuery1($deleted);
        }
        catch(Exception $e)
        {
        echo $e->getMessage();
        return TAG_RESPONSE_BAD;
         }
     }

      function DeleteQuestionLinkingForTest($testid)
      {
          try
          {
              $Query='DELETE FROM test_question WHERE testid='.$testid;

              return parent::excuteQuery1($Query);
          }
          catch(Exception $e)
          {
              echo $e->getMessage();
              return TAG_RESPONSE_BAD;
          }
      }
  function checkDuplicate($where)
	{
		$selectQuery='Select * from '.$this->tableName.' where institute_name LIKE "%'.$where['institute_name'].'%" and isDeleted=0';

		$selectStatement = $this->databaseConnection->prepare($selectQuery);
		$selectStatement->execute();
		return count($selectStatement->fetchAll(PDO::FETCH_OBJ));
	}
	  function checkDuplicateEdit($where)
        {
			$selectQuery='Select * from '.$this->tableName.' where institute_name LIKE "%'.$where['institute_name'].'%" and institute_id !='.$where['institute_id'].' and isDeleted=0';
			
			$selectStatement = $this->databaseConnection->prepare($selectQuery);
			$selectStatement->execute();
			return count($selectStatement->fetchAll(PDO::FETCH_OBJ));
		}

	function getCourseTest($course,$attempted_test){
		if($attempted_test=='')
			$selectQuery='Select * from '.$this->tableName.' where course='.$course.' and total_questions!=0  and isEnabled=1 and isDeleted=0';
		else
			$selectQuery='Select * from '.$this->tableName.' where course='.$course.' and test_id NOT IN ('.$attempted_test.') and total_questions!=0  and isEnabled=1 and isDeleted=0';
	//echo $selectQuery;die;
		/*if($attempted_test=='')
			$selectQuery='Select * from '.$this->tableName.' where course='.$course.' and total_questions!=0  and isEnabled=1 and isDeleted=0';
		else
			$selectQuery='Select t.*,q.* from '.$this->tableName.' t, '.TABLE_QUESTION.' q where t.test_id=q.test_id and course='.$course.' and t.test_id NOT IN ('.$attempted_test.') and t.total_questions!=0  and t.isEnabled=1 and t.isDeleted=0';*/
		//echo $selectQuery;die;
		$selectStatement = $this->databaseConnection->prepare($selectQuery);
		$selectStatement->execute();
		return $selectStatement->fetchAll(PDO::FETCH_OBJ);
	}
	function validateCode($code,$test_id){
	  	$selectQuery='Select * from '.$this->tableName.' where test_id='.$test_id.' and code="'.$code.'"';
		$selectStatement = $this->databaseConnection->prepare($selectQuery);
		$selectStatement->execute();
		return $selectStatement->fetchAll(PDO::FETCH_OBJ);
  }
   function getResultDetails($test_id,$student_id){
	    if($test_id!=0)
	 		$selectQuery='Select * from '.TABLE_TESTRESULT.' where test_id='.$test_id.' and student_id='.$student_id;
	    else
			$selectQuery='Select * from '.TABLE_TESTRESULT.' where student_id='.$student_id;
		$selectStatement = $this->databaseConnection->prepare($selectQuery);
		$selectStatement->execute();
		return $selectStatement->fetchAll(PDO::FETCH_OBJ);
	 }
	function getTestResult($test_id,$orderby=""){
	    $selectQuery='Select r.*,t.*,s.* from '.TABLE_TESTRESULT.' r, '.TABLE_TEST.' t, '.TABLE_STUDENT.' s where r.student_id=s.id and t.test_id=r.test_id and r.test_id='.$test_id;
        if($orderby!="")
        {
            $selectQuery.=" ORDER BY $orderby ASC";
        }
		//echo $selectQuery;
		$selectStatement = $this->databaseConnection->prepare($selectQuery);
		$selectStatement->execute();
		return $selectStatement->fetchAll(PDO::FETCH_OBJ);
	 }
      function getTestResultForParent1($test_id){
      $selectQuery='Select r.*,t.*,s.* from '.TABLE_TESTRESULT.' r, '.TABLE_TEST.' t, '.TABLE_STUDENT.' s where r.student_id=s.id and t.test_id=r.test_id and r.test_id='.$test_id.' ORDER BY s.student_id ASC';
      //echo $selectQuery;
      $selectStatement = $this->databaseConnection->prepare($selectQuery);
      $selectStatement->execute();
      return $selectStatement->fetchAll(PDO::FETCH_OBJ);
  }
      function getTestResultForParent2($test_id){
          $selectQuery='SELECT s.student_id,tro.questionNo,tp.name,tro.timetaken ,tro.user_choice,tro.correct_answer,
                        IF(tro.user_choice=NULL OR tro.user_choice=\'\',\'Unanswered\',IF(tro.user_choice=tro.correct_answer,\'Right\',\'Wrong\')) AS answerstatus
                        FROM '.TABLE_TESTRESULTOPT.' tro
                        INNER JOIN '.TABLE_TESTRESULT.' tr 
                        ON tro.test_resultId=tr.test_res_id
                        INNER JOIN '.TABLE_STUDENT.' s
                        ON s.id=tr.student_id
                        INNER JOIN '.TABLE_TEST.' t
                        ON tr.test_id=t.test_id
                        LEFT JOIN '.TABLE_TOPIC.' tp
                        ON t.topicid=tp.id
                        WHERE t.test_id='.$test_id;
         // echo $selectQuery;
          $selectStatement = $this->databaseConnection->prepare($selectQuery);
          $selectStatement->execute();
          return $selectStatement->fetchAll(PDO::FETCH_OBJ);
      }
      function getTotalTimeTaken($test_id,$student_id){
          $selectQuery='Select SEC_TO_TIME( SUM( TIME_TO_SEC( o.timetaken ) ) ) AS TOTALTIME from '.TABLE_TESTRESULT.' r INNER JOIN '.TABLE_TESTRESULTOPT.' o ON r.test_res_id=o.test_resultId WHERE r.student_id='.$student_id.' and r.test_id='.$test_id;

          $selectStatement = $this->databaseConnection->prepare($selectQuery);
          $selectStatement->execute();
          $obj=$selectStatement->fetchAll(PDO::FETCH_OBJ);
          return $obj[0]->TOTALTIME;
      }
      function getPercentile($test_id,$student_marks){
          $selectQuery='SELECT COUNT(*) AS TOTAL FROM '.TABLE_TESTRESULT.' WHERE test_res_id IN(SELECT test_res_id FROM '.TABLE_TESTRESULT.' WHERE test_id='.$test_id.' AND student_marks<='.$student_marks.')';
          //echo $selectQuery;
          $selectStatement = $this->databaseConnection->prepare($selectQuery);
          $selectStatement->execute();
          $obj1=$selectStatement->fetchAll(PDO::FETCH_OBJ);

          $selectQuery='SELECT COUNT(*) AS TOTAL FROM '.TABLE_TESTRESULT.' WHERE test_id='.$test_id;
          $selectStatement = $this->databaseConnection->prepare($selectQuery);
          $selectStatement->execute();
          $obj2=$selectStatement->fetchAll(PDO::FETCH_OBJ);
          //echo $selectQuery;
          
		  
          return ($obj1[0]->TOTAL/$obj2[0]->TOTAL*100);
      }
	 function getResult($res_id){
	    $selectQuery='Select res.*,t.* from '.TABLE_TESTRESULT.' res,'.TABLE_TEST.' t where t.test_id=res.test_id and test_res_id='.$res_id;
		// echo $selectQuery;
	    $selectStatement = $this->databaseConnection->prepare($selectQuery);
		$selectStatement->execute();
		return $selectStatement->fetchAll(PDO::FETCH_OBJ);
	 }
	 function getTopWaitingTime($test_res_id,$for){
		// echo $test_res_id;die;
		if($for==1)
	 		$selectQuery='Select * from '.TABLE_TESTRESULTOPT.' where test_resultId='.$test_res_id.' order by timetaken desc limit 5';
		 else
			$selectQuery='Select ro.*,q.question,t.title from '.TABLE_TESTRESULTOPT.' ro, '.TABLE_QUESTION.' q,'.TABLE_TEST.' t where ro.question_id=q.question_id and ro.test_resultId IN ('.$test_res_id.') and q.test_id=t.test_id and ro.timetaken<=( select max(timetaken) as timetaken from'.TABLE_TESTRESULTOPT.' where test_resultId IN ('.$test_res_id.') ) order by ro.timetaken desc limit 5';
	 	
		// echo $selectQuery;
		$selectStatement = $this->databaseConnection->prepare($selectQuery);
		$selectStatement->execute();
		return $selectStatement->fetchAll(PDO::FETCH_OBJ);
	 }
	function getAttemptedTest($attempted_test){
		$selectQuery='Select * from '.$this->tableName.' where test_id IN ('.$attempted_test.') and total_questions!=0  and isEnabled=1 and isDeleted=0';
	//	echo $selectQuery;die;
		$selectStatement = $this->databaseConnection->prepare($selectQuery);
		$selectStatement->execute();
		return $selectStatement->fetchAll(PDO::FETCH_OBJ);
	}
   function getResultIn($studIds){
	    $selectQuery='Select * from '.TABLE_TESTRESULT.' where student_id IN ('.$studIds.')';
	    echo $selectQuery;
		$selectStatement = $this->databaseConnection->prepare($selectQuery);
		$selectStatement->execute();
		return $selectStatement->fetchAll(PDO::FETCH_OBJ);
	 }
   function getStudentResult($stud_id){
	    $selectQuery='Select res.*,t.* from '.TABLE_TESTRESULT.' res,'.TABLE_TEST.' t where t.test_id=res.test_id and res.student_id='.$stud_id;
		 //echo $selectQuery;
	    $selectStatement = $this->databaseConnection->prepare($selectQuery);
		$selectStatement->execute();
		return $selectStatement->fetchAll(PDO::FETCH_OBJ);
	 }
  function getStudentSubWiseResult($stud_id,$subject){
	    $selectQuery='Select res.*,t.* from '.TABLE_TESTRESULT.' res,'.TABLE_TEST.' t where t.test_id=res.test_id and t.subject='.$subject.' and  res.student_id='.$stud_id;
		 //echo $selectQuery;
	    $selectStatement = $this->databaseConnection->prepare($selectQuery);
		$selectStatement->execute();
		return $selectStatement->fetchAll(PDO::FETCH_OBJ);
	 }
      function getTop25Scorers($test_id){
          $selectStatement = $this->databaseConnection->prepare("CALL top_scorers(?)");
          $selectStatement->bindParam(1, $test_id, PDO::PARAM_INT);
          $selectStatement->execute();
          return $selectStatement->fetchAll(PDO::FETCH_OBJ);
      }
	  function getBottom25Scorers($test_id){
          $selectStatement = $this->databaseConnection->prepare("CALL bottom_scorers(?)");
          $selectStatement->bindParam(1, $test_id, PDO::PARAM_INT);
          $selectStatement->execute();
          return $selectStatement->fetchAll(PDO::FETCH_OBJ);
      }
	  function getAverageScoreAndPecentage($course,$subject,$isspecial){
          $selectQuery="SELECT t.test_id,t.title as test_title,DATE_FORMAT(t.created_at,'%d/%m/%Y')AS test_date,ROUND(SUM(tr.student_marks)/COUNT(*),2)AS average_score,ROUND(SUM(tr.student_marks/t.total_marks*100)/COUNT(*),2) AS average_percentage FROM test_result tr INNER JOIN test t
						ON tr.test_id=t.test_id
						WHERE 1 ";
          if($course!="0")
          {
              $selectQuery.=" AND t.course=$course";
          }
          if($subject!="0")
          {
              $selectQuery.=" AND t.subject=$subject";
          }

          if($isspecial=="YES")
          {
              $selectQuery.=" AND t.isSpecial=1";
          }

          $selectQuery.=" GROUP BY t.test_id";
		  $selectStatement = $this->databaseConnection->prepare($selectQuery);
		  $selectStatement->execute();
		  return $selectStatement->fetchAll(PDO::FETCH_OBJ);
      }
	  function getMostIncorrectQuestions($test_id)
	  {
          $selectStatement = $this->databaseConnection->prepare("CALL most_incorrect_analysis(?)");
          $selectStatement->bindParam(1, $test_id, PDO::PARAM_INT);
          $selectStatement->execute();
          return $selectStatement->fetchAll(PDO::FETCH_OBJ);
	  }
	   function getMostTimeTakenQuestions($test_id)
	  {
          $selectStatement = $this->databaseConnection->prepare("CALL most_timetaken_analysis(?)");
          $selectStatement->bindParam(1, $test_id, PDO::PARAM_INT);
          $selectStatement->execute();
          return $selectStatement->fetchAll(PDO::FETCH_OBJ);
	  }
	   function getScoreAndPercentage($student_id,$test_id)
	  {
         $selectStatement = $this->databaseConnection->prepare("CALL student_wise_spp_report(?,?)");
          $selectStatement->bindParam(1, $student_id, PDO::PARAM_STR);
		  $selectStatement->bindParam(2, $test_id, PDO::PARAM_INT);
          $selectStatement->execute();
          return $selectStatement->fetchAll(PDO::FETCH_OBJ);
	  }
	  function getPercentageTrend($student_id,$subject_id,$onlymajortest)
	  {
         $selectStatement = $this->databaseConnection->prepare("CALL student_percentage_trend(?,?,?)");
          $selectStatement->bindParam(1, $student_id, PDO::PARAM_STR);
		  $selectStatement->bindParam(2, $subject_id, PDO::PARAM_INT);
		  $selectStatement->bindParam(3, $onlymajortest, PDO::PARAM_STR);
          $selectStatement->execute();
          return $selectStatement->fetchAll(PDO::FETCH_OBJ);
	  }
	  
	  function getAverageScoreAveragePercentageTrend($course_id,$subject_id,$onlymajortest)
	  {
         $selectStatement = $this->databaseConnection->prepare("CALL average_score_average_percentage_trend(?,?,?)");
          $selectStatement->bindParam(1, $course_id, PDO::PARAM_INT);
		  $selectStatement->bindParam(2, $subject_id, PDO::PARAM_INT);
		  $selectStatement->bindParam(3, $onlymajortest, PDO::PARAM_STR);
          $selectStatement->execute();
          return $selectStatement->fetchAll(PDO::FETCH_OBJ);
	  }
	  function getBestScorersTrend($subject_id,$onlymajortest)
	  {
         $selectStatement = $this->databaseConnection->prepare("CALL best_scorers(?,?)");
          $selectStatement->bindParam(1, $subject_id, PDO::PARAM_INT);
		  $selectStatement->bindParam(2, $onlymajortest, PDO::PARAM_STR);
          $selectStatement->execute();
          return $selectStatement->fetchAll(PDO::FETCH_OBJ);
	  }
	  function CopyTest($title,$code,$testid)
	  {
         $selectStatement = $this->databaseConnection->prepare("CALL create_test_from_existing(?,?,?)");
          $selectStatement->bindParam(1, $title, PDO::PARAM_STR);
		  $selectStatement->bindParam(2, $code, PDO::PARAM_STR);
		  $selectStatement->bindParam(3, $testid, PDO::PARAM_INT);
          $selectStatement->execute();
          return $selectStatement->fetchAll(PDO::FETCH_OBJ);
	  }

      function questionLinking($questionid,$testid)
      {
          $selectStatement = $this->databaseConnection->prepare("CALL test_question_linking(?,?)");
          $selectStatement->bindParam(1, $questionid, PDO::PARAM_INT);
          $selectStatement->bindParam(2, $testid, PDO::PARAM_INT);
          $selectStatement->execute();
          return $selectStatement->fetchAll(PDO::FETCH_OBJ);
      }
}
