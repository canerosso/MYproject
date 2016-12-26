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
  
  class Field extends Controller
  {
    var $tableName;
    
    function __construct($api_key)
    {
      
        parent::__construct($api_key);
     	$this->tableName = TABLE_FIELD;
		$this->databaseConnection = DatabaseConnection::getDatabaseInstance(SERVER_API_KEY);
      
    }

        function getAllField($page)
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
				$orderBy['field_id'] = "DESC";
				if($skip!=0)
					$selectQuery='Select * from field where isDeleted=0 ORDER BY field_id DESC LIMIT '.$limit.', '.$skip;
				else
					$selectQuery='Select * from field where isDeleted=0 ORDER BY field_id DESC LIMIT '.$limit;
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
				$selectQuery='Select * from field where isDeleted=0 ORDER BY field_id DESC';
				
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
		function GetCountOfFields(){
			$selectQuery='Select * from field where isDeleted=0';
			$selectStatement = $this->databaseConnection->prepare($selectQuery);
			$selectStatement->execute();
			return count($selectStatement->fetchAll(PDO::FETCH_OBJ));
		}
	 	function getField($where)
        {
			$orderby="ASC";
	    	return parent::getData($this->tableName,'',$where,$orderby);
		}
	  function checkDuplicate($where)
        {
			$selectQuery='Select * from field where field_name LIKE "%'.$where['field_name'].'%" and isDeleted=0';
			//echo $selectQuery;
			$selectStatement = $this->databaseConnection->prepare($selectQuery);
			$selectStatement->execute();
			return count($selectStatement->fetchAll(PDO::FETCH_OBJ));
		}
		function checkDupEdit($where)
        {
			$selectQuery='Select * from field where field_name LIKE "%'.$where['field_name'].'%" and field_id !='.$where['field_id'].' and isDeleted=0';
			
			$selectStatement = $this->databaseConnection->prepare($selectQuery);
			$selectStatement->execute();
			return count($selectStatement->fetchAll(PDO::FETCH_OBJ));
		}
  function add($params){
              
      $fields = array_keys($params);
      $values = array_values($params);
      return parent::insertData($this->tableName,$fields,$values);

    }

    function updateField($params){
           //   echo $params['isEnabled'];die;
    	$selectQuery='UPDATE field SET isEnabled='.$params['isEnabled'].' WHERE field_id='.$params['field_id'];
		$selectStatement = $this->databaseConnection->prepare($selectQuery);
		$selectStatement->execute();
      //return parent::updateData($this->tableName,$fields,$values,1);

    }
	  
      function updateFields($params){
              
      $fields = array_keys($params);
      $values = array_values($params);
      //print_r($params);
      return parent::updateData($this->tableName,$fields,$values,1);

    }
  
function  deleteFeild($id){
  
  // $myid= $id['id'];
    $myid= $id;
    $deleted = "UPDATE field set isDeleted=1 where field_id=".$id;
    

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