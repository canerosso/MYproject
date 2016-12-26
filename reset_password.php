<?php
    
  require_once 'include/Security.php';


    # GET URL REEQUEST
    if(!isset($_GET['t']) && empty($_GET['t'])){
        header("Location: index.php");
    }
    $test = urlencode($_GET['t']);
    

    $passstring=urldecode(stripslashes($test));
    $decrypted_string= Security::encrypt_decrypt($passstring);
    $data = explode("_", $decrypted_string);
   //print_r($data);
    $expirationTime = $data[2]+60*60;
    //echo date("Y-m-d H:i:s",$expirationTime);
    if (time() > $expirationTime) {
      # redirect to another page : 404

      exit();
    }
?>

<!DOCTYPE html>
<html >
    <meta charset="UTF-8">
    <title>Excellence|Reset Password</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
 </head>
    <body class="login-page">
     <div class="login-box">
      <div class="login-logo">
        <a href="#"><b>TFIN</b></a>
      </div>
      <div class="login-box-body">
        
         <div class="alert alert-info">
                <?php
                    if (isset($_GET['er']) && $_GET['er']==400) {
                        echo 'Invalid username/password';
                    }else{
                        echo 'Enter new password.';
                    }
                ?>
            </div>
       
        <form action="api/admin/index.php/resetPassword" method="post" onsubmit=" return checkPassword();">
            <div class="form-group has-feedback">
               <input type="password" class="form-control" placeholder="Enter password" name="new_password" required/>
               <span class="glyphicon glyphicon-lock form-control-feedback"></span>
           </div>
          <div class="form-group has-feedback">
              <input type="password" class="form-control" placeholder="Retype password" name="password"  required/>
              <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
           <input type="hidden" name="id" value="<?php echo $test; ?>">
          <div class="row">
            <div class="col-xs-8">
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
            </div><!-- /.col -->
          </div>
        </form>
    </div><!-- /.login-box-body -->
   </div><!-- /.login-box -->
   
    <script src="plugins/iCheck/icheck.min.js" type="text/javascript"></script>
   <script src="plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js" type="text/javascript"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js" type="text/javascript"></script>
    </body>
</html>

<script type="text/javascript">

function checkPassword() {
 
if (document.getElementById('new_password').value != document.getElementById('password').value)
    {
        alert('Passwords Not Matching!');


        return false;
    }
    else 
    {
       return true;
    }
    
   
}
</script>
