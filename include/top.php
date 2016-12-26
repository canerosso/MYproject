<?php
     @session_start();
  # include lib
  require_once 'Config.php';
  require_once 'DatabaseConnection.php';  
  require_once 'Controller.php';
  require_once 'Utils.php';
  require_once 'Security.php';
  require_once 'SendMail.php';
  
  class top extends Controller
  {
    var $tableName;
    
    function __construct($api_key)
    {
      
        parent::__construct($api_key);
      $this->tableName = TABLE_CAT;
      
    }

        function getAlltop($ids)
        {

         $whereClauseArray['parent_id'] =$ids;
   
         $orderBy['cat_id'] = "ASC";
        $eventsInfo =   parent::getDataFromTable(TABLE_CAT,"*",$whereClauseArray,$orderBy);
         
          try{
        
    
          return $this->convertAdminDataIntoResponse($eventsInfo);
        

      }catch(Exception $e){
        echo $e->getMessage();
        return TAG_RESPONSE_BAD;
      }

          }


 function getcatname_2($ids)
        {

         $fields= array('cat_id','cat_name' );
         $whereClauseArray['parent_id'] =$ids;
         $orderBy['cat_id'] = "ASC";
         return parent::getDataFromTable(TABLE_CAT,$fields,$whereClauseArray,$orderBy);
       }


               function getcatname($ids)
        {
           $fields= array('cat_id','cat_name' );

         $whereClauseArray['cat_id'] =$ids;
   
         $orderBy['cat_id'] = "ASC";
           return parent::getDataFromTable(TABLE_CAT,$fields,$whereClauseArray,$orderBy);
         
         
      }

         function convertAdminDataIntoResponse($data){

      $response = "";
 $i = 0;
      foreach ($data as $key => $value) {
         $i++;
          $response .= ' <tr>
                  <td>'.$i.'</td>
                   <td><a href="question.php?id='.$value->cat_id.'&prev='.$_GET['id'].'">'.$value->cat_name.'</a></td> 
                    
                      <td>';
                         if ($value->status == 'Y') {
                          # active class
                          $response .= '<div class="col-md-3"><a onclick=" return confirm(\' Are You Sure\' )" class="btn btn-danger" href="api/top/index.php/updatetopStatus/'.$value->cat_id.'/N/'.$value->parent_id.'">
                                          Deactive
                                      </a></div>
                                     ';
                         }else{
                         # deactive class
                        $response .= '<div class="col-md-3"><a onclick=" return confirm(\' Are You Sure\' )"
                         class="btn btn-info" href="api/top/index.php/updatetopStatus/'.$value->cat_id.'/Y/'.$value->parent_id.'">
                                         Active
                                      </a></div>
                                     ';
                        }  
  
                         $response .="
                             <div class='col-md-3'>
                             <input data-toggle='modal' data-target='#myModal$value->cat_id' type='button' class='btn btn-block btn-info' value='Update top'>
                   <div class='modal fade' id='myModal$value->cat_id' role='dialog'>
                    <div class='modal-dialog'>
               <div class='modal-content'>
                 <div class='modal-header'>
                   <button type='button' class='close' data-dismiss='modal'>&times;</button>
                   <h4 class='modal-title'>Update Topic</h4>
                 </div>
                 <div class='modal-body' >
                  <div class='row'> 
                   <form role='form' action='api/top/index.php/updatetop' method='post' >
                    <div class='box-body'>
                      <div class='form-group'>
                       <label for='exampleInputEmail1'>Topic Name</label></br>
                       <input type='text' class='form-control' id='exampleInputName' 
                       name='cat_name' value='$value->cat_name'  placeholder='biology' required>
                       <input type='hidden' name='id' value='$value->cat_id'>
                       <input type='hidden' name='parent_id' value='$value->parent_id'>
                      </div>
                    </div>
                    <div class='box-footer'>
                     <button type='submit' class='btn btn-primary'>Update</button>
                    </div>
                   </form>
                   </div>
                   </div>
                   </div>
                   </div>
                 
              </div>
                             </div>
                          
                               <div class='col-md-3'>
                               <a href='api/top/index.php/deletetop/$value->cat_id/$value->parent_id'><input type='button' class='btn btn-block btn-warning' onclick='return confirm(\"Are You Want \")' value='Delete'></a>
                               </div>".
                               '</td>';
               '</tr>';  

        }

        return $response;
        } 

  
  function add($params){
              
      $fields = array_keys($params);
      $values = array_values($params);
      return parent::insertData($this->tableName,$fields,$values);

    }

    function updatetop($params){
              
      $fields = array_keys($params);
      $values = array_values($params);
      //print_r($params);
      return parent::updateData($this->tableName,$fields,$values,1);

    }
      function updateStatus($params){
              
      $fields = array_keys($params);
      $values = array_values($params);
      //print_r($params);
      return parent::updateData($this->tableName,$fields,$values,1);

    }
  
function  deletetop($id){
  
   $myid= $id;
   $deleted = "delete FROM `category_management` where cat_id='".$myid."'";
    

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