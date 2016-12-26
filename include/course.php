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
  
  class Course extends Controller
  {
    var $tableName;
    
    function __construct($api_key)
    {
      
        parent::__construct($api_key);
     	$this->tableName = TABLE_COURSE;
		$this->databaseConnection = DatabaseConnection::getDatabaseInstance(SERVER_API_KEY);
      
    }

        function getAllCourse($page)
        {
			if($page!=0){
				if($page==1){

					$skip=0;
				}
				else{

					$page=$page-1;
					$skip=$page*10;
				}
				$limit=10;	
				//echo $page.">>>>".$skip.">>>>".$limit;die;
				$whereClauseArray['isEnabled'] = 1;
				$whereClauseArray['isDeleted'] = 0;
				//  $whereClauseArray['status'] = 1;
				$orderBy['course_id'] = "DESC";
				if($skip!=0)
					$selectQuery='Select * from course where isDeleted=0 ORDER BY course_id DESC LIMIT '.$limit.', '.$skip;
				else
					$selectQuery='Select * from course where isDeleted=0 ORDER BY course_id DESC LIMIT '.$limit;
				//echo $selectQuery;die;
				$eventsInfo =   parent::getDataFromTable($this->tableName,"*",$whereClauseArray,$orderBy);
				$selectStatement = $this->databaseConnection->prepare($selectQuery);
				$selectStatement->execute();
				return $selectStatement->fetchAll(PDO::FETCH_OBJ);
				//die;
				try{
					return $eventsInfo;
				}catch(Exception $e){
					echo $e->getMessage();
					return TAG_RESPONSE_BAD;
				}
			}else{
					
				//echo $page.">>>>".$skip.">>>>".$limit;die;
				$whereClauseArray['isEnabled'] = 1;
				$whereClauseArray['isDeleted'] = 0;
				//  $whereClauseArray['status'] = 1;
				$orderBy['course_id'] = "DESC";
				$selectQuery='Select * from course where isDeleted=0 ORDER BY course_id DESC';
				
				$eventsInfo =   parent::getDataFromTable($this->tableName,"*",$whereClauseArray,$orderBy);
				$selectStatement = $this->databaseConnection->prepare($selectQuery);
				$selectStatement->execute();
				return $selectStatement->fetchAll(PDO::FETCH_OBJ);
				//die;
				try{
					return $eventsInfo;
				}catch(Exception $e){
					echo $e->getMessage();
					return TAG_RESPONSE_BAD;
				}
			
			}
			

          }
		function GetCountOfCourse(){
			$selectQuery='Select * from course where isDeleted=0';
			$selectStatement = $this->databaseConnection->prepare($selectQuery);
			$selectStatement->execute();
			return count($selectStatement->fetchAll(PDO::FETCH_OBJ));
		}
	 	function getCourse($where)
        {
			$orderby="ASC";
	    	return parent::getData($this->tableName,'',$where,$orderby);
		}
      function getCourseId($where)
      {
          return parent::getData($this->tableName,array('course_id'),$where,"");
      }
	  function checkDuplicate($where)
        {
			$selectQuery='Select * from '.$this->tableName.' where field='.$where['field'].' and course_name LIKE "%'.$where['course_name'].'%" and isDeleted=0';
			//echo $selectQuery;
			$selectStatement = $this->databaseConnection->prepare($selectQuery);
			$selectStatement->execute();
			return count($selectStatement->fetchAll(PDO::FETCH_OBJ));
		}
		function checkDupEdit($where)
        {
			$selectQuery='Select COUNT(*) AS TOTAL from '.$this->tableName.' where field='.$where['field'].' and course_name="'.$where['course_name'].'" and NOT course_id='.$where['course_id'].' and isDeleted=0';
			
			$selectStatement = $this->databaseConnection->prepare($selectQuery);
			$selectStatement->execute();
			return $selectStatement->fetchAll(PDO::FETCH_OBJ);
		}
  function add($params){
              
      $fields = array_keys($params);
      $values = array_values($params);
      return parent::insertData($this->tableName,$fields,$values);

    }

    function updateCourse($params){
           //   echo $params['isEnabled'];die;
    	$selectQuery='UPDATE '.$this->tableName.' SET isEnabled='.$params['isEnabled'].' WHERE course_id='.$params['course_id'];
		$selectStatement = $this->databaseConnection->prepare($selectQuery);
		$selectStatement->execute();
      //return parent::updateData($this->tableName,$fields,$values,1);

    }
	  
  function updateCourses($params){
              
      $fields = array_keys($params);
      $values = array_values($params);
      //print_r($params);
      return parent::updateData($this->tableName,$fields,$values,1);

    }
  
function  deleteCourse($id){
  
  // $myid= $id['id'];
    $myid= $id;
    $deleted = "UPDATE ".$this->tableName." set isDeleted=1 where course_id=".$id;
    

      try{
                return parent::excuteQuery1($deleted);
        }
        catch(Exception $e)
        {
        echo $e->getMessage();
        return TAG_RESPONSE_BAD;
         }
     }
   function getCourseList($cours_ids){
   			$selectQuery='Select * from '.$this->tableName.' where course_id IN ('.$cours_ids.') and isDeleted=0';
			$selectStatement = $this->databaseConnection->prepare($selectQuery);
	//   echo $selectQuery;die;
			$selectStatement->execute();
			return $selectStatement->fetchAll(PDO::FETCH_OBJ);
   }
}