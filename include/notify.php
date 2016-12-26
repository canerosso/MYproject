<?php
     @session_start();
  # include lib
  require_once 'Config.php';
  require_once 'DatabaseConnection.php';  
  require_once 'Controller.php';
  require_once 'Utils.php';
  require_once 'Security.php';
  require_once 'SendMail.php';
  
  class notify extends Controller
  {
    
    
    function __construct($api_key)
    {
      
        parent::__construct($api_key);
      
      
    }


    function send_push_notification($registration_ids ,$message) {
        
  //echo "In send_push_notification function";
  //while ($rowUsers = mysql_fetch_array($resultUsers)) {
  //echo $rowUsers['gcm_regid'];
        // Set POST variables

     
        $url = 'https://gcm-http.googleapis.com/gcm/send';

        $fields = array(
            'registration_ids' => $registration_ids ,
            'data' => $message,
        );
//echo '<pre>';print_r( $fields);die;
        $headers = array(
      'Content-Type:application/json',
            'Authorization:key=AIzaSyCE3rjQO8umeYNiOzTPHO8nMW8LWVviCTI'
             
        );
    //print_r($headers);
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
  // Close connection
        curl_close($ch);
        return $result;
      //}  
    }

      

}