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
  
  class sub extends Controller
  {
    var $tableName;
    
    function __construct($api_key)
    {
      
        parent::__construct($api_key);
        $this->tableName = TABLE_CAT;
      
    }
	function getAllSubjects($page)
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
			$orderBy['cat_id'] = "DESC";
			if($skip!=0)
				$selectQuery='Select * from '.$this->tableName.' where isDeleted=0 ORDER BY cat_id DESC LIMIT '.$limit.', '.$skip;
			else
				$selectQuery='Select * from '.$this->tableName.' where isDeleted=0 ORDER BY cat_id DESC LIMIT '.$limit;
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
			$orderBy['cat_id'] = "DESC";
			$selectQuery='Select * from '.$this->tableName.' where isDeleted=0 ORDER BY cat_id DESC';
			$selectStatement = $this->databaseConnection->prepare($selectQuery);
			$selectStatement->execute();
			return $selectStatement->fetchAll(PDO::FETCH_OBJ);
			

		}


	  }

	function GetCountOfSub(){
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
	 function addPDF($params){
              
      $fields = array_keys($params);
      $values = array_values($params);
      return parent::insertData(TABLE_SUBPDF,$fields,$values);

    }
    function updatesub($params){
              
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
  	function getSub($where)
	{
		$orderby="ASC";
		return parent::getData($this->tableName,'',$where,$orderby);
	}
  	function getSubjPdf($subject_id)
	{
		$selectQuery='Select * from '.TABLE_SUBPDF.' where subject_id='.$subject_id;
		$selectStatement = $this->databaseConnection->prepare($selectQuery);
		$selectStatement->execute();
		return $selectStatement->fetchAll(PDO::FETCH_OBJ);
	}
	function getSubjPdfIn($subject_ids)
	{
		$selectQuery='Select * from '.TABLE_SUBPDF.' where subject_id IN('.$subject_ids.')';
		$selectStatement = $this->databaseConnection->prepare($selectQuery);
		$selectStatement->execute();
		return $selectStatement->fetchAll(PDO::FETCH_OBJ);
	}
	function  deleteSub($id){
    	$deleted = "UPDATE ".$this->tableName." set isDeleted=1 where cat_id=".$id;
   	 	try{
					return parent::excuteQuery1($deleted);
			}
			catch(Exception $e)
			{
			echo $e->getMessage();
			return TAG_RESPONSE_BAD;
			 }
     }
  function  deleteSubpdf($id){
 
    $deleted = "DELETE FROM ".TABLE_SUBPDF." where pdf_id=".$id;
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
		$selectQuery='Select * from '.$this->tableName.' where cat_name LIKE "%'.$where['cat_name'].'%" and isDeleted=0';

		$selectStatement = $this->databaseConnection->prepare($selectQuery);
		$selectStatement->execute();
		return count($selectStatement->fetchAll(PDO::FETCH_OBJ));
	}
	  function checkDuplicateEdit($where)
        {
			$selectQuery='Select * from '.$this->tableName.' where cat_name LIKE "%'.$where['cat_name'].'%" and cat_id !='.$where['cat_id'].' and isDeleted=0';
			
			$selectStatement = $this->databaseConnection->prepare($selectQuery);
			$selectStatement->execute();
			return count($selectStatement->fetchAll(PDO::FETCH_OBJ));
		}
	  
		function getDepCourseSub($where)
        {
			 $fields= array('cat_id','cat_name','course');
			 $whereClauseArray['isEnabled'] =1;
			 $whereClauseArray['isDeleted'] =0;
			 $orderBy['cat_id'] = "ASC";
			 $subjects=parent::getDataFromTable($this->tableName,$fields,$whereClauseArray,$orderBy);
			 $catidArr=array();
			 $catidName=array();
         	 for($i=0;$i<count($subjects);$i++)
			 {
			 	$course=explode(",",$subjects[$i]->course);
				if(in_array($where['course'], $course)){
					array_push($catidArr,$subjects[$i]->cat_id);
					array_push($catidName,$subjects[$i]->cat_name);
				}
			}
    		$str='<label for="exampleInputEmail1">Subject</label>';
			$str.='<select name="subject" id="subject" class="form-control" onchange="getTopics(this.value)" required>';
			$str.='<option value="">Select Subject</option>';
			for($i=0;$i<count($catidName);$i++)
				$str.='<option value='.$catidArr[$i].'>'.$catidName[$i].'</option>';
			$str.='</select>';
			echo $str;
        }
		
	  function getDepCourseSub2($where)
        {
			 $fields= array('cat_id','cat_name','course');
			 $whereClauseArray['isEnabled'] =1;
			 $whereClauseArray['isDeleted'] =0;
			 $orderBy['cat_id'] = "ASC";
			 $subjects=parent::getDataFromTable($this->tableName,$fields,$whereClauseArray,$orderBy);
			 $catidArr=array();
			 $catidName=array();
         	 for($i=0;$i<count($subjects);$i++)
			 {
			 	$course=explode(",",$subjects[$i]->course);
				if(in_array($where['course'], $course)){
					array_push($catidArr,$subjects[$i]->cat_id);
					array_push($catidName,$subjects[$i]->cat_name);
				}
			}
    		
			$str='<select name="subject" id="subject" class="form-control" onchange="getSubReport()" required>';
			$str.='<option value="">Select Subject</option>';
			for($i=0;$i<count($catidName);$i++)
				$str.='<option value='.$catidArr[$i].'>'.$catidName[$i].'</option>';
			$str.='</select>';
			echo $str;
        }
	  function getCourseSub($where)
        {
			 $fields= array('cat_id','cat_name','course');
			 $whereClauseArray['isEnabled'] =1;
			 $whereClauseArray['isDeleted'] =0;
			 $orderBy['cat_id'] = "ASC";
			 $subjects=parent::getDataFromTable($this->tableName,$fields,$whereClauseArray,$orderBy);
			 $catidArr=array();
			 for($i=0;$i<count($subjects);$i++)
			 {
			 	$course=explode(",",$subjects[$i]->course);
				// print_r($course);echo "<br>";
				if(in_array($where['course'], $course)){
					array_push($catidArr,$subjects[$i]->cat_id);
				}
			}
		    if(empty($catidArr))
				$catidArr=array(0);
		  
		  	$selectQuery='Select * from '.$this->tableName.' where cat_id IN ('.implode(",",$catidArr).') and isDeleted=0';
			//echo $selectQuery;
			$selectStatement = $this->databaseConnection->prepare($selectQuery);
			$selectStatement->execute();
			return $selectStatement->fetchAll(PDO::FETCH_OBJ);
    		
        }

}