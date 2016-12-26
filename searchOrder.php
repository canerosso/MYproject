<?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    require_once 'include/Order.php';
    require_once 'include/Config.php';
    require_once 'include/DatabaseConnection.php';  
    require_once 'include/Crud.php';

   if(isset($_POST['search_text'], $_POST['option']))
    { 
      // $arr=$_POST['question_id'];
       //$exam_id=$_POST['exam_id'];
        $search_text=$_POST['search_text'];
        $option=$_POST['option'];

        $msg = "";
        $api = 145236;
        $userObject = new Order(SERVER_API_KEY);
        $resposne= $userObject->searchOrder($search_text,$option);
       // print_r($resposne);
        $msg = $msg.$resposne;    
       
    }  

?>
