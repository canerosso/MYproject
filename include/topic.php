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
  
  class Topic extends Controller
  {
    var $tableName;
    
    function __construct($api_key)
    {
      
        parent::__construct($api_key);
        $this->tableName = TABLE_TOPIC;
      
    }

  function add($params){

      $fields = array_keys($params);
      $values = array_values($params);
      return parent::insertData($this->tableName,$fields,$values);

  }

  function getSubjectTopics($where)
  {
      $fields= array('id','name');
      $where['isDeleted']=0;

      $orderBy['name'] = "ASC";
      $topics=parent::getDataFromTable($this->tableName,$fields,$where,$orderBy);
      $topicidArr=array();
      $topicidName=array();
      $str='<label for="exampleInputEmail1">Topic</label>';
      $str.='<select name="topic" id="topic" class="form-control" >';
      $str.='<option value="">Select Topic</option>';
      for($i=0;$i<count($topics);$i++)
      {
          $str.='<option value='.$topics[$i]->id.'>'.$topics[$i]->name.'</option>';
      }
      $str.='</select>';
      echo $str;
  }

	function getList(){
			$selectQuery='Select t.id,t.name,c.course_name,s.cat_name from '.$this->tableName.' t INNER JOIN '.TABLE_COURSE.' c ON t.courseid=c.course_id INNER JOIN ' .TABLE_CAT.' s ON t.subjectid=s.cat_id WHERE  t.isdeleted=0';

			$selectStatement = $this->databaseConnection->prepare($selectQuery);
			$selectStatement->execute();
			return $selectStatement->fetchAll(PDO::FETCH_OBJ);
		}

      function updateTopic($params){

          $fields = array_keys($params);
          $values = array_values($params);
          //print_r($params);
          return parent::updateData($this->tableName,$fields,$values,1);

      }
	function  delete($id){
    	$deleted = "UPDATE ".$this->tableName." SET isDeleted=1 where id=".$id;
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
		$selectQuery='Select * from '.$this->tableName.' where name="'.$where['name'].'" AND subjectid="'.$where['subjectid'].'"  AND courseid="'.$where['courseid'].'" and isDeleted=0';

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
	  


}