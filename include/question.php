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
  
  class Question extends Controller
  {
    var $tableName;
    
    function __construct($api_key)
    {
      
        parent::__construct($api_key);
        $this->tableName = TABLE_QUESTION;
      
    }
	function getAllQuestions($test,$page)
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
				$selectQuery='Select * from '.$this->tableName.' where test_id='.$test.' and isDeleted=0 ORDER BY question_id ASC LIMIT '.$limit.', '.$skip;
			else
				$selectQuery='Select * from '.$this->tableName.' where test_id='.$test.' and isDeleted=0 ORDER BY question_id ASC LIMIT '.$limit;
			$selectStatement = $this->databaseConnection->prepare($selectQuery);
			$selectStatement->execute();
			return $selectStatement->fetchAll(PDO::FETCH_OBJ);
			
		}else{
			$selectQuery='Select * from '.$this->tableName.' where test_id='.$test.' and isDeleted=0 ORDER BY question_id ASC';
			$selectStatement = $this->databaseConnection->prepare($selectQuery);
			$selectStatement->execute();
			return $selectStatement->fetchAll(PDO::FETCH_OBJ);
		}


	  }

	
	function GetCountOfQuestion($test){
			$selectQuery='Select * from '.$this->tableName.' where test_id='.$test.' and isDeleted=0';
			//echo $selectQuery;
			$selectStatement = $this->databaseConnection->prepare($selectQuery);
			$selectStatement->execute();
			return count($selectStatement->fetchAll(PDO::FETCH_OBJ));
		}
   
  function add($params){
              
      $fields = array_keys($params);
      $values = array_values($params);
      return parent::insertData($this->tableName,$fields,$values);

    }
	function addAns($params){
              
      $fields = array_keys($params);
      $values = array_values($params);
      return parent::insertData(TABLE_CHOICE,$fields,$values);

    }
    function updateTestScore($questionid)
     {

      $selectStatement = $this->databaseConnection->prepare("CALL recalculate_score_and_question_count(?)");
      $selectStatement->bindParam(1, $questionid, PDO::PARAM_INT);
      $selectStatement->execute();
      return $selectStatement->fetchAll(PDO::FETCH_OBJ);

    }
    function updateQuestion($params){
              
      $fields = array_keys($params);
      $values = array_values($params);
      //print_r($params);
      return parent::updateData($this->tableName,$fields,$values,1);
    }
  function UpdateAns($params){
              
      $fields = array_keys($params);
      $values = array_values($params);
      //print_r($params);
      return parent::updateData(TABLE_CHOICE,$fields,$values,1);
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
	
	function getQuestionListByTopic($course,$subject,$topic)
	{
		$selectQuery='SELECT t.title,c.course_name,cm.cat_name,tp.name AS topic_name,q.* 
                      FROM question q 
                      INNER JOIN test_question tq ON q.question_id=tq.questionid
                      INNER JOIN test t ON tq.testid=t.test_id 
                      INNER JOIN course c ON q.courseid=c.course_id 
                      INNER JOIN category_management cm ON q.subjectid=cm.cat_id 
                      INNER JOIN topic tp ON q.topicid=tp.id 
                      WHERE q.isDeleted=0  ';
        $selectQuery2="SELECT IFNULL(t.title,'NO TEST ASSIGNED')as title,c.course_name,cm.cat_name,tp.name AS topic_name,q.* 
                      FROM question q 
                      LEFT JOIN test_question tq ON q.question_id=tq.questionid
                      LEFT JOIN test t ON tq.testid=t.test_id 
                      INNER JOIN course c ON q.courseid=c.course_id 
                      INNER JOIN category_management cm ON q.subjectid=cm.cat_id 
                      INNER JOIN topic tp ON q.topicid=tp.id 
                      WHERE q.isDeleted=0 AND tq.id IS NULL  ";
		if($course!=0)
		{
			$selectQuery.=" AND c.course_id=$course";
            $selectQuery2.=" AND c.course_id=$course";
        }
		if($subject!=0)
		{
			$selectQuery.=" AND cm.cat_id=$subject";
            $selectQuery2.=" AND cm.cat_id=$subject";
		}
		if($topic!=0)
		{
			$selectQuery.=" AND q.topicid=$topic";
            $selectQuery2.=" AND q.topicid=$topic";
        }
        $selectQuery.=" ORDER BY t.title ASC";
        $selectQuery=" SELECT * FROM (($selectQuery2) UNION ($selectQuery))d";
        //echo $selectQuery;
		$selectStatement = $this->databaseConnection->prepare($selectQuery);
		$selectStatement->execute();
		return $selectStatement->fetchAll(PDO::FETCH_OBJ);
	}
	  
	 function getAnalyticsQuestion($testid)
	{
		$selectQuery='Select q.* from '.$this->tableName.' q INNER JOIN test_question tq ON q.question_id=tq.questionid WHERE tq.testid='.$testid;
	//	echo $selectQuery;die;
		$selectStatement = $this->databaseConnection->prepare($selectQuery);
		$selectStatement->execute();
		return $selectStatement->fetchAll(PDO::FETCH_OBJ);
	}
  function getQuestion($where)
	{
		$orderby="ASC";
		return parent::getData($this->tableName,'',$where,$orderby);
	}

  function getQuestionAns($where)
	{
		$orderby="ASC";
		return parent::getData(TABLE_QUE_CH,'',$where,$orderby);
	}
  function getQuestionIn($testids)
	{
		$selectQuery='Select * from '.$this->tableName.' where test_id IN ('.$testids.') and isEnabled=1 and isDeleted=0';
	//	echo $selectQuery;die;
		$selectStatement = $this->databaseConnection->prepare($selectQuery);
		$selectStatement->execute();
		return $selectStatement->fetchAll(PDO::FETCH_OBJ);
	}
	function getAllQuestionList()
	{
		$selectQuery='Select q.* from question q WHERE q.isDeleted=0';
		//echo $selectQuery;die;
		$selectStatement = $this->databaseConnection->prepare($selectQuery);
		$selectStatement->execute();
		return $selectStatement->fetchAll(PDO::FETCH_OBJ);
	}
	function getQuestionList($testid)
	{
		$selectQuery='Select q.* from question q INNER JOIN test_question tq ON q.question_id=tq.questionid WHERE tq.testid='.$testid.' and isEnabled=1 and isDeleted=0';
		//echo $selectQuery;die;
		$selectStatement = $this->databaseConnection->prepare($selectQuery);
		$selectStatement->execute();
		return $selectStatement->fetchAll(PDO::FETCH_OBJ);
	}
	function DeleteQuestionFromTest($questionid,$testid)
	{
		try
		{
			$Query='DELETE FROM test_question WHERE questionid='.$questionid;
			if($testid!=0)
			{
				$Query.=' AND testid='.$testid;
			}
			
			return parent::excuteQuery1($Query);
		 }
        catch(Exception $e)
        {
	        echo $e->getMessage();
	        return TAG_RESPONSE_BAD;
        }
	}
      function DeleteQuestionChoiceImage($choiceid)
      {
          try
          {
              $Query='UPDATE question_choices SET choice="", is_file=0 WHERE choice_id='.$choiceid;

              return parent::excuteQuery1($Query);
          }
          catch(Exception $e)
          {
              echo $e->getMessage();
              return TAG_RESPONSE_BAD;
          }
      }
      function DeleteQuestionImage($questionid)
      {
          try
          {
              $Query='UPDATE question SET questionFile="", quesIsFile=0 WHERE question_id='.$questionid;

              return parent::excuteQuery1($Query);
          }
          catch(Exception $e)
          {
              echo $e->getMessage();
              return TAG_RESPONSE_BAD;
          }
      }
function  deleteQuestion($id){
 
    $deleted = "UPDATE ".$this->tableName." set isDeleted=1 where question_id=".$id;
    

      try{
                return parent::excuteQuery1($deleted);
        }
        catch(Exception $e)
        {
        echo $e->getMessage();
        return TAG_RESPONSE_BAD;
         }
     }
function  deleteQuestionAns($id){

    $deleted = "DELETE FROM ".TABLE_CHOICE." where question_id=".$id;
    
	
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
	
	function getTestQuestion($testid){
		$selectQuery='Select q.*,tq.testid as test_id from '.$this->tableName.' q INNER JOIN test_question tq ON q.question_id=tq.questionid  WHERE tq.testid='.$testid.' AND q.isEnabled=1 and q.isDeleted=0';
		$selectStatement = $this->databaseConnection->prepare($selectQuery);
		$selectStatement->execute();
		return $selectStatement->fetchAll(PDO::FETCH_OBJ);
	}
	
	function getSubmittedTestQuestion($testid,$studentid)
	{
		$selectQuery='Select q.*, IF(tro.user_choice=\'\',2,IF(tro.user_choice=tro.correct_answer,1,0))AS flag from '.$this->tableName.' q INNER JOIN test_result_options tro ON q.question_id=tro.question_id  INNER JOIN
					 test_result tr ON tro.test_resultId=tr.test_res_id where tr.test_id='.$testid.' AND tr.student_id='.$studentid;
				
		$selectStatement = $this->databaseConnection->prepare($selectQuery);
		$selectStatement->execute();
		return $selectStatement->fetchAll(PDO::FETCH_OBJ);
	}
	function getQuestionsAns($questionId){
		$selectQuery='Select `choice_id`,`choice`,`is_file`,`is_right` from '.TABLE_CHOICE.' where question_id='.$questionId;
		$selectStatement = $this->databaseConnection->prepare($selectQuery);
		$selectStatement->execute();
		return $selectStatement->fetchAll(PDO::FETCH_OBJ);
	}
}
