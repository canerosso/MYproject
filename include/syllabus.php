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
  
  class Syllabus extends Controller
  {
    var $tableName;
    
    function __construct($api_key)
    {
      
        parent::__construct($api_key);
      $this->tableName = TABLE_SYLLABUS;
      
    }
	function getAllSyllabus($page)
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
			if($skip!=0)
				$selectQuery='Select s.*,c.course_name from '.$this->tableName.' s, course c where s.course=c.course_id ORDER BY s.syllabus_id DESC LIMIT '.$limit.', '.$skip;
			else
				$selectQuery='Select s.*,c.course_name from '.$this->tableName.' s, course c where s.course=c.course_id ORDER BY s.syllabus_id DESC LIMIT '.$limit;
			
			$selectStatement = $this->databaseConnection->prepare($selectQuery);
			$selectStatement->execute();
			//print_r($selectStatement->fetchAll(PDO::FETCH_OBJ));
			return $selectStatement->fetchAll(PDO::FETCH_OBJ);
			
		}else{
			$selectQuery='Select * from '.$this->tableName.' ORDER BY syllabus_id DESC';
			$selectStatement = $this->databaseConnection->prepare($selectQuery);
			$selectStatement->execute();
			return $selectStatement->fetchAll(PDO::FETCH_OBJ);
			

		}


	  }

	
	function GetCountOfSyllabus(){
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
  function addSyllData($params){
              
      $fields = array_keys($params);
      $values = array_values($params);
      return parent::insertData(TABLE_SYLLABUS_DATA,$fields,$values);

    }
    function updateSyllabus($params){
              
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
    function getSyllabus($where)
	{
		$orderby="ASC";
		return parent::getData($this->tableName,'',$where,$orderby);
	}
	function getSyllabusData($where)
	{
		$orderby="ASC";
		return parent::getData(TABLE_SYLLABUS_DATA,'',$where,$orderby);
	}
function  deleteSyllabus($id){
	$where['syllabus_id']=$id;
 	$data=$this->getSyllabusData($where);
	for($i=0;$i<count($data);$i++){
		$file=$data[$i]->path;
		//	echo $file."<br>";
	   unlink($file);
	   
	}
//	die;
    $deletedsub = "DELETE from ".TABLE_SYLLABUS_DATA."  where syllabus_id=".$id;
	parent::excuteQuery1($deletedsub);
    $deletedmain = "DELETE from ".$this->tableName." where syllabus_id=".$id;
    

      try{
               return parent::excuteQuery1($deletedmain);
        }
        catch(Exception $e)
        {
        echo $e->getMessage();
        return TAG_RESPONSE_BAD;
         }
     }
 
  function  deleteSyllpdf($id){
		$deleted = "DELETE FROM ".TABLE_SYLLABUS_DATA." where id=".$id;
		try{
			return parent::excuteQuery1($deleted);
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
			return TAG_RESPONSE_BAD;
		}
  }
  function getPDF($syllabusids){
  		$selectQuery = "SELECT * from ".TABLE_SYLLABUS_DATA." where syllabus_id IN(".$syllabusids.") order by id desc";
    	$selectStatement = $this->databaseConnection->prepare($selectQuery);
		$selectStatement->execute();
		return $selectStatement->fetchAll(PDO::FETCH_OBJ);
  }

}