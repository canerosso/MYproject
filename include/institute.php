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
  
  class Institute extends Controller
  {
    var $tableName;
    
    function __construct($api_key)
    {
      
        parent::__construct($api_key);
      $this->tableName = TABLE_INSTITUTE;
      
    }
	function getAllInstitutes($page)
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
			//echo $page.">>>>".$skip.">>>>".$limit;
			$whereClauseArray['isEnabled'] = 1;
			$whereClauseArray['isDeleted'] = 0;
			//  $whereClauseArray['status'] = 1;
			$orderBy['institute_id'] = "DESC";
			if($skip!=0)
				$selectQuery='Select * from '.$this->tableName.' where isDeleted=0 ORDER BY institute_id DESC LIMIT '.$limit.', '.$skip;
			else
				$selectQuery='Select * from '.$this->tableName.' where isDeleted=0 ORDER BY institute_id DESC LIMIT '.$limit;
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
			$orderBy['field_id'] = "DESC";
			$selectQuery='Select * from '.$this->tableName.' where isDeleted=0 ORDER BY institute_id DESC';

			//$eventsInfo =   parent::getDataFromTable($this->tableName,"*",$whereClauseArray,$orderBy);
			$selectStatement = $this->databaseConnection->prepare($selectQuery);
			$selectStatement->execute();
			return $selectStatement->fetchAll(PDO::FETCH_OBJ);
			

		}


	  }

	
	function GetCountOfInstitute(){
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

    function updateInstitute($params){
              
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
  function getInstitute($where)
	{
		$orderby="ASC";
		return parent::getData($this->tableName,'',$where,$orderby);
	}
function  deleteInstitute($id){
 
    $deleted = "UPDATE ".$this->tableName." set isDeleted=1 where institute_id=".$id;
    

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

}