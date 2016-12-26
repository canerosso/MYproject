<?php
ob_clean();
ob_start();
session_start();

//print_r($_SESSION);

if( isset($_SESSION['id']) && $_SESSION['id']!="")
{
  //header('location :dashboard.php');
  header("Location:dashboard.php");
}
?>

<!DOCTYPE html>

<html>
  <head>
    <meta charset="UTF-8">
    <title>Excellence| Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="icon" href="favicon.ico" type="image/x-icon">
    <!-- Bootstrap 3.3.4 -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
  </head>
<body background="terms/css/background.png">
    <div class="login-box">
       <div class="login-logo">
        <a href="#"><b>Excellence</b></a>
       </div><!-- /.login-logo -->
      <div class="login-box-body">
       
        <?php
            if (isset($_GET['er']) && $_GET['er']==400) {
              echo '<div class="alert alert-error">
                      Please check username or password
                    </div>';   
            }else{
              echo '<div class="alert" style="background: none repeat scroll 0 0 #1b8f79;
    color: #fff;">
                      Login with username and password.
                    </div>';   
            }
        ?>
       
        <form action="api/admin/index.php/signin" method="post">
          <div class="form-group has-feedback">
            <input type="email" class="form-control" required placeholder="Email" name="username" />
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" required placeholder="Password" name="password" />
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
			<input type="hidden" id="ismobile" name="ismobile" value="0"/>
          <div class="row">
            <div class="col-xs-12">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div>
          </div>
        </form>
        <div class="row">
          &nbsp;          
        </div>
          <div class="row">
            <div class="col-xs-12">
              <a href="forget.php" class="btn btn-primary btn-block btn-flat">Forgot Password</a>
            </div>
          </div>
 
     
       
     <br>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

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
