<?php

error_reporting(-1);
ini_set('display_errors', 'On');

require_once '../../libs/Slim/Slim.php';
require_once '../../include/Config.php';
require_once '../../include/User.php';
require_once '../../include/Security.php';
require_once '../../include/Admin.php';
require_once '../../include/User.php';




\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();


############################### Username Authentication Admin Panel ############

###ADD ADMIN 
$app->post('/insert_mail', function () use ($app) {
      // reading post params
           $api = SERVER_API_KEY;   
        /
        $userObject= new User($api);
        $params = $app->request->post();
       //For single mail
        if(isset($params['receiver_id'])){  
        $params['subject']= $app->request->post('subject');
        $params['content']= $app->request->post('content');
        $receiver_id= $userObject->getID($app->request->post('receiver_id'));
         if(!empty($receiver_id))
          {
          $params['receiver_id']=$receiver_id[0]->id;
          }
          else
          {
            //echo "Please ender valid receiver id";
            $app->redirect(URL.'compose.php?status='.TAG_RESPONSE_BAD);
          } 
          $params['sender_id']= $app->request->post('sender_id');
          $lastInsertId= $userObject->insert_mail($params); 
         'lastInsertId: '.$lastInsertId.'<br/>';

        }
        //For Send to all
        elseif(isset($params['sendall']))
        {
          $mail=$userObject->mailReceiver();
          for($i=0;$i<count($mail);$i++)
          {
            $rid=$userObject->getID($mail[$i]->email);

            $param['receiver_id']=$rid[0]->id; 
            $param['subject']= $app->request->post('subject');
            $param['content']= $app->request->post('content');
            $param['sender_id']=$app->request->post('sender_id');
          
            $lastInsertId= $userObject->insert_mail($param); 
            'lastInsertId: '.$lastInsertId.'<br/>';
          }
        }
        
      # return response
      $status = 200;
       $app->redirect(URL.'mail.php?status='.$status);  
      });

$app->post('/reply_mail', function () use ($app) {
      // reading post params
   $api = SERVER_API_KEY;   
       // print_r($app->request->post());
         $userObject= new User($api);
        $params = $app->request->post();

        $params['subject']= $app->request->post('subject');
        $params['content']= $app->request->post('content');

        $receiver_id= $userObject->getID($app->request->post('receiver_id'));
       // print_r($receiver_id);exit;
        if(!empty($receiver_id))
        {
        $params['receiver_id']=$receiver_id[0]->id;
        }
        else
         {
          $app->redirect(URL.'compose.php?status='.TAG_RESPONSE_BAD);
         } 
        $params['sender_id']= $_SESSION['id'];

         $lastInsertId= $userObject->insert_mail($params); 
         'lastInsertId: '.$lastInsertId.'<br/>';

      # return response
      $status = 200;
       $app->redirect(URL.'mail.php?status='.$status);  
      });

 

############################### PRIVATE FUNCTION ############################### 


# Sign In 
   /* $app->get('/hello/:name', function ($name) use ($app) {
    	echo "Hello ".$name;
    });
*/
$app->run();

?>
