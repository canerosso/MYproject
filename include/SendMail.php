<?php
 
 require_once('class.phpmailer.php');
 require 'PHPMailerAutoload.php';
 //require_once 'contents.html';


class Mail{

	/* function sendMAil
	 * @params: integer employee_id		
	 * @return: String */

	public static function sendMAil($url,$emailid,$subject){
        
        
       $mail = new PHPMailer;

		//$mail->SMTPDebug = 3;                               // Enable verbose debug output

		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'bh-46.webhostbox.net';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'reply@testifymobintia.com';                 // SMTP username
		$mail->Password = '1@dministr2';                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;                                    // TCP port to connect to

		$mail->From = 'reply@testifymobintia.com';
		$mail->FromName = 'Mailer';
		$mail->addAddress($emailid, ''); // Add a recipient
		              
		$mail->addReplyTo('info@example.com', 'Information');
		$mail->addCC('abhinayphuke@gmail.com');
		$mail->addBCC('bcc@example.com');		
		$mail->isHTML(true);                                  // Set email format to HTML

		$mail->Subject =$subject;
		$mail->Body    = 'Please follow the link below:-<br>' 
                          .$url;
		$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		if(!$mail->send()) {
		   // echo 'Message could not be sent.';
		   // echo 'Mailer Error: ' . $mail->ErrorInfo;
			return TAG_RESPONSE_BAD;
		} else {
		    //echo 'Message has been sent';
		    return TAG_RESPONSE_SUCCESS;
		}
    }
}
?>
