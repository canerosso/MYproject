<?php
     @session_start();
set_time_limit(50);
  # include lib
  require_once 'Config.php';
  require_once 'DatabaseConnection.php';  
  require_once 'Controller.php';
  require_once 'Utils.php';
  require_once 'Security.php';
  require_once 'SendMail.php';
  
  class Notice extends Controller
  {
    var $tableName;
    
    function __construct($api_key)
    {
      
        parent::__construct($api_key);
        $this->tableName = TABLE_NOTICE;
      
    }
	function getAllNotices($page){
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
				$selectQuery='Select * from '.$this->tableName.' ORDER BY notice_id DESC LIMIT '.$limit.', '.$skip;
			else
				$selectQuery='Select * from '.$this->tableName.' ORDER BY notice_id DESC LIMIT '.$limit;
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
			$selectQuery='Select * from '.$this->tableName.' ORDER BY notice_id DESC';
			$selectStatement = $this->databaseConnection->prepare($selectQuery);
			$selectStatement->execute();
			return $selectStatement->fetchAll(PDO::FETCH_OBJ);
			

		}


	  }

	function GetCountOfNotice(){
			$selectQuery='Select * from '.$this->tableName;
			$selectStatement = $this->databaseConnection->prepare($selectQuery);
			$selectStatement->execute();
			return count($selectStatement->fetchAll(PDO::FETCH_OBJ));
		}
   
  function add($params){
              
      $fields = array_keys($params);
      $values = array_values($params);
      return parent::insertData($this->tableName,$fields,$values);

    }

    function updateNotice($params){
              
      $fields = array_keys($params);
      $values = array_values($params);
      //print_r($params);
      return parent::updateData($this->tableName,$fields,$values,1);

    }
	  
  function updateNoticeStatus($params){
           //   echo $params['isEnabled'];die;
    	$selectQuery='UPDATE '.$this->tableName.' SET isEnabled='.$params['isEnabled'].' WHERE notice_id='.$params['notice_id'];
		$selectStatement = $this->databaseConnection->prepare($selectQuery);
		$selectStatement->execute();
      //return parent::updateData($this->tableName,$fields,$values,1);

    }
  
  function getNotice($where){
		$orderby="ASC";
		return parent::getData($this->tableName,'',$where,$orderby);
	}
  function getNoticeForCourse($course)
	{
		$selectQuery='Select * from '.$this->tableName.' where course IN (0,'.$course.') and isEnabled=1';
	  	$selectStatement = $this->databaseConnection->prepare($selectQuery);
		$selectStatement->execute();
		return $selectStatement->fetchAll(PDO::FETCH_OBJ);
	}
function  deleteNotice($id){
 
    $deleted = "DELETE FROM ".$this->tableName." where notice_id=".$id;
    try{
       return parent::excuteQuery1($deleted);
    }
    catch(Exception $e)
    {
  	    echo $e->getMessage();
        return TAG_RESPONSE_BAD;
     }
 }
 

}