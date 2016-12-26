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
  
  class Student extends Controller
  {
    var $tableName;
    
    function __construct($api_key)
    {
      
        parent::__construct($api_key);
      $this->tableName = TABLE_STUDENT;
      
    }
	function getAllStudents($page)
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
				$selectQuery='Select s.*,c.course_name from '.$this->tableName.' s, course c where s.isDeleted=0 and s.course=c.course_id ORDER BY s.student_id DESC LIMIT '.$limit.', '.$skip;
			else
				$selectQuery='Select s.*,c.course_name from '.$this->tableName.' s, course c where s.isDeleted=0 and s.course=c.course_id ORDER BY s.student_id DESC LIMIT '.$limit;
			//echo $selectQuery;die;
			$selectStatement = $this->databaseConnection->prepare($selectQuery);
			$selectStatement->execute();
			return $selectStatement->fetchAll(PDO::FETCH_OBJ);
			
		}else{
			$selectQuery='Select * from '.$this->tableName.' where isDeleted=0 ORDER BY student_id DESC';
			$selectStatement = $this->databaseConnection->prepare($selectQuery);
			$selectStatement->execute();
			return $selectStatement->fetchAll(PDO::FETCH_OBJ);
			

		}


	  }
	function getCourseWiseStudentList($course)
	{
		
		    $selectQuery='Select s.*,c.course_name from '.$this->tableName.' s, course c where s.isDeleted=0 and s.course=c.course_id';
			if($course!="" && $course!=0)
			{
				$selectQuery.=' AND s.course='.$course;
			}
		  // echo $selectQuery;
			$selectStatement = $this->databaseConnection->prepare($selectQuery);
			$selectStatement->execute();
			return $selectStatement->fetchAll(PDO::FETCH_OBJ);
	}
	
	function getCourseWiseStud($course,$page)
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
			if($skip!=0){
				if($course!=0)
					$selectQuery='Select s.*,c.course_name from '.$this->tableName.' s, course c where s.course='.$course.' and s.isDeleted=0 and s.course=c.course_id ORDER BY s.student_id DESC LIMIT '.$limit.', '.$skip;
				else
					$selectQuery='Select s.*,c.course_name from '.$this->tableName.' s, course c where s.isDeleted=0 and s.course=c.course_id ORDER BY s.student_id DESC LIMIT '.$limit.', '.$skip;
			}else{
				if($course!=0)
					$selectQuery='Select s.*,c.course_name from '.$this->tableName.' s, course c where s.course='.$course.' and s.isDeleted=0 and s.course=c.course_id ORDER BY s.student_id DESC LIMIT '.$limit;
				else
					$selectQuery='Select s.*,c.course_name from '.$this->tableName.' s, course c where s.isDeleted=0 and s.course=c.course_id ORDER BY s.student_id DESC LIMIT '.$limit;
			//echo $selectQuery;die;
			}$selectStatement = $this->databaseConnection->prepare($selectQuery);
			$selectStatement->execute();
			return $selectStatement->fetchAll(PDO::FETCH_OBJ);
			
		}else{
			if($course!=0)
				$selectQuery='Select * from '.$this->tableName.' where course='.$course.' and isDeleted=0 ORDER BY student_id DESC';
			else
				$selectQuery='Select * from '.$this->tableName.' where isDeleted=0 ORDER BY student_id DESC';
			$selectStatement = $this->databaseConnection->prepare($selectQuery);
			$selectStatement->execute();
			return $selectStatement->fetchAll(PDO::FETCH_OBJ);
			

		}


	  }
	
	function GetCountOfStudents(){
			$selectQuery='Select * from '.$this->tableName.' where isDeleted=0';
			$selectStatement = $this->databaseConnection->prepare($selectQuery);
			$selectStatement->execute();
			return count($selectStatement->fetchAll(PDO::FETCH_OBJ));
		}
   function GetCoursewiseCount($course){
			$selectQuery='Select * from '.$this->tableName.' where course='.$course.' and isDeleted=0';
			$selectStatement = $this->databaseConnection->prepare($selectQuery);
			$selectStatement->execute();
			return count($selectStatement->fetchAll(PDO::FETCH_OBJ));
		}
  function add($params){
              
      $fields = array_keys($params);
      $values = array_values($params);
      return parent::insertData($this->tableName,$fields,$values);

    }

    function adddiscussion($params){

          $fields = array_keys($params);
          $values = array_values($params);
          return parent::insertData(TABLE_PARENT_DISCUSSION,$fields,$values);

      }
    function updateStudent($params){
              
      $fields = array_keys($params);
      $values = array_values($params);
      //print_r($params);
      return parent::updateData($this->tableName,$fields,$values,1);

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
  function isStudentExists($id)
  {
      $selectQuery='Select * from '.$this->tableName.' where student_id="'.$id.'" and isDeleted=0';

      $selectStatement = $this->databaseConnection->prepare($selectQuery);
      $selectStatement->execute();
      return count($selectStatement->fetchAll(PDO::FETCH_OBJ));
  }
    function getStudent($where)
	{
		$orderby="ASC";
		return parent::getData($this->tableName,'',$where,$orderby);
	}
      function getDiscussion($where)
      {

          return parent::getData(TABLE_PARENT_DISCUSSION,'',$where,array("createdon"=>"ASC"));
      }
function  deleteStudent($id){
 
    $deleted = "UPDATE ".$this->tableName." set isDeleted=1 where id=".$id;
    

      try{
                return parent::excuteQuery1($deleted);
        }
        catch(Exception $e)
        {
        echo $e->getMessage();
        return TAG_RESPONSE_BAD;
         }
     }
  function checkDuplicateById($id)
  {
      $selectQuery='Select * from '.$this->tableName.' where student_id="'.$id.'" and isDeleted=0';

      $selectStatement = $this->databaseConnection->prepare($selectQuery);
      $selectStatement->execute();
      return count($selectStatement->fetchAll(PDO::FETCH_OBJ));
  }
  function checkDuplicate($where)
	{
		$selectQuery='Select * from '.$this->tableName.' where email="'.$where['email'].'" and isDeleted=0';

		$selectStatement = $this->databaseConnection->prepare($selectQuery);
		$selectStatement->execute();
		return count($selectStatement->fetchAll(PDO::FETCH_OBJ));
	}
	  function checkDuplicateEdit($where)
        {
			$selectQuery='Select * from '.$this->tableName.' where email="'.$where['email'].'" and student_id !='.$where['student_id'].' and isDeleted=0';
			
			$selectStatement = $this->databaseConnection->prepare($selectQuery);
			$selectStatement->execute();
			return count($selectStatement->fetchAll(PDO::FETCH_OBJ));
		}

}