<?php
     @session_start();
error_reporting(0);
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
 
    $deleted = "UPDATE ".$this->tableName." set isDeleted=1 where test_id=".$id;
    

      try{
                return parent::excuteQuery1($deleted);
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
	//	echo $selectQuery;die;
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
	 		$selectQuery='Select ro.*,q.question from '.TABLE_TESTRESULTOPT.' ro, '.TABLE_QUESTION.' q where ro.question_id=q.question_id and  ro.test_resultId='.$test_res_id.' and ro.timetaken<=( select max(timetaken) as timetaken from'.TABLE_TESTRESULTOPT.' where test_resultId='.$test_res_id.') order by ro.timetaken desc limit 5';
		 else
			$selectQuery='Select ro.*,q.question from '.TABLE_TESTRESULTOPT.' ro, '.TABLE_QUESTION.' q where ro.question_id=q.question_id and ro.test_resultId IN ('.$test_res_id.') and ro.timetaken<=( select max(timetaken) as timetaken from'.TABLE_TESTRESULTOPT.' where test_resultId IN ('.$test_res_id.') ) order by ro.timetaken desc limit 5';
	 	
		 echo $selectQuery;
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
}