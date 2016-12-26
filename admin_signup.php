<?php
require_once 'include/Security.php';

    # GET URL REEQUEST
   /* if(!isset($_GET['t']) && empty($_GET['t'])){
        header("Location: index.php");
    }
    $test = urlencode($_GET['t']);
    */
 
    $passstring=urldecode(stripslashes($test));
    $decrypted_string= Security::encrypt_decrypt($passstring);
    $data = explode("_", $decrypted_string);
   
     //print_r($data);
    $expirationTime = $data[1]+60*60;
   // echo date("Y-m-d H:i:s",$expirationTime);
    if (time() > $expirationTime) {
      # redirect to another page : 404

      //exit();
    }
?>
<!DOCTYPE html>

<html>
  <head>
    <meta charset="UTF-8">
    <title>Excellence| Log in</title>
  <?php include("link.php");?>
  </head>
  <body class="login-page">
    <div class="login-box">
       <div class="login-logo">
        <a href="#"><b>TFIN</b></a>
       </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Admin Signup</p>
         
       
        <form action="api/admin/index.php/insert_admin" method="post" enctype="multipart/form-data>
         <div class="form-group has-feedback">
               <input type="text" class="form-control" placeholder="Enter name" name="name" required/>
         </div>
        <div class="form-group has-feedback">
               <input type="text" class="form-control" placeholder="Enter contact number" name="mobile" required pattern="[7-9]{1}[0-9]{9}" 
                       title="Phone number with 7-9 and remaing 9 digit with 0-9" maxlength="10"/>
               
             </div>
             <div class="form-group has-feedback">
               <input type="email" class="form-control" placeholder="Enter email" name="email" required/>
              
             </div>
              <div class="form-group has-feedback">
              <input type="password" class="form-control" placeholder="Enter password" name="password" required/>
             
              </div>
               <div class="form-group">
                  <input type="file" name="image" />
                </div>
          <div class="row">
            <div class="col-xs-8">
               
            </div>
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
            
            </div>
          </div>
        </form>

        <!--<div class="social-auth-links text-center">
          <p>- OR -</p>
          <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
          <a href="#" class="btn btn-block btn-social btn-google-plus btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
        </div><!-- /.social-auth-links -->
 
       
     <br>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
<?php include("footer.php");?>
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
