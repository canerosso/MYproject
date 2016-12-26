<?php
    
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    require_once 'include/User.php';
    require_once 'include/Config.php';
    require_once 'include/DatabaseConnection.php';  
    require_once 'include/Crud.php';

try{
 if(isset($_POST['id']))
    { 
     $id=$_POST['id'];
      //echo $id;
        $msg = "";
        $api = 145236;
        $userObject = new User(SERVER_API_KEY);
        $resposne=  $userObject->approveUSer($id);
        $msg = $msg.$resposne; 
}
}
catch(Exception $e)
{
    echo $e->getMessage();
     return TAG_RESPONSE_BAD;
}
?>