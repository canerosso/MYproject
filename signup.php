<?php
   require_once 'include/Security.php';
   
       # GET URL REEQUEST
    /*   if(!isset($_GET['t']) && empty($_GET['t'])){
           header("Location: index.php");
       }
       $test = urlencode($_GET['t']);
       
       $passstring=urldecode(stripslashes($test));

       $decrypted_string= Security::encrypt_decrypt($passstring);
        
       $data = explode("_", $decrypted_string);
      
       $expirationTime = $data[1]+60*60;
       if (time() > $expirationTime) {
         # redirect to another page : 404
   
         //exit();
       */
   ?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8">
      <title>MOBiquiz|Signup</title>
      <!-- Tell the browser to be responsive to screen width -->
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <!-- Bootstrap 3.3.4 -->
      <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
      <!-- Font Awesome Icons -->
      <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
      <!-- Theme style -->
      <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
      <!-- iCheck -->
      <link href="plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
   </head>
   <body class="login-page">
      <div class="login-box">
         <div class="login-logo">
            <a href="#"><b>Mobiquizz</b></a>
         </div>
         <!-- /.login-logo -->
         <div class="login-box-body">
           
            <form action="api/users/index.php/register_user" method="post" enctype="multipart/form-data">
               <div class="form-group has-feedback">
                  <input type="text" class="form-control" placeholder="Enter name" name="name" required/>
               </div>
               <div class="form-group has-feedback">
                  <input type="text" class="form-control" placeholder="Enter contact number" name="mobile" required pattern="[7-9]{1}[0-9]{9}" 
                     title="Phone number with 7-9 and remaing 9 digit with 0-9" maxlength="10"/>
               </div>
               <div class="form-group has-feedback">
                  <input type="email" class="form-control" placeholder="Enter email" name="email" value="<?php echo $data[0]?>" />
                  <input type="hidden" name="api_key" value="145236">
               </div>
               <div class="form-group has-feedback">
                  <!--<input type="password" class="form-control" placeholder="Enter password" name="password" required/>-->
               </div>
               <!--
               <div class="form-group">
                  <label> Profile Image</label>
                  <input type="file" name="image" />
               </div>
               -->
               <div class="row">
                  <div class="col-xs-8">
                  </div>
                  <div class="col-xs-12">
                     <button type="submit" class="btn btn-primary btn-block btn-flat">Sign Up</button>
                     <input type="hidden" name="user_type" value="0">
                  </div>
               </div>
            </form>
         </div>
         <!-- /.login-box-body -->
      </div>
      <!-- /.login-box -->
      <!-- jQuery 2.1.4 -->
      <script src="plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
      <!-- Bootstrap 3.3.2 JS -->
      <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
      <!-- iCheck -->
      <script src="plugins/iCheck/icheck.min.js" type="text/javascript"></script>
      <script>
         $(function () {
           $('input').iCheck({
             checkboxClass: 'icheckbox_square-blue',
             radioClass: 'iradio_square-blue',
             increaseArea: '20%' // optional
           });
         });
      </script>
   </body>
</html>