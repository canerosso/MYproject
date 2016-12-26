<?php
$no_visible_elements = true;
//session_start();
?>
<!DOCTYPE html>

<html>
  <head>
    <meta charset="UTF-8">
    <title>Excellence| ForgetPassword</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
  </head>
  <body class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="#"><b>Mobiquiz</b></a>
      </div>
      <div class="login-box-body">
        
         
                <?php
                    if (isset($_GET['er']) && $_GET['er']==400) {
                       ?>
                      

                       <div class="alert alert-info" style="background-color:#BC2107 !important;border-color:#BC2107 !important">
                         EmailId not registered
                         </div>
                    <?php
                    }
                    elseif (isset($_GET['er'])&& $_GET['er']==200) {
                     # code...
                    ?>
                    <div class="alert alert-info" style="background-color:#155D2D !important;border-color:#155D2D !important">
                      Mail send Successfully to your mail id
                      </div>
                    <?php
                    }
                    elseif (isset($_GET['er'])&& $_GET['er']==406) {
                     # code...
                    ?>
                     <div class="alert alert-info" style="background-color:#BC2107 !important;border-color:#BC2107 !important">
                      Your Account is deactivated
                      </div>
                    <?php
                    }
                    
                    else{ ?>
                       
                       <div class="alert alert-info" >
                      Please enter your emailid
                      </div>
                   <?php }
                ?>
            
       
        <form action="api/admin/index.php/forget" method="post" onsubmit="return checkEmail()">
          <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="Enter email" name="email" id="email" required />
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
        
          <div class="row">
            <div class="col-xs-5">
                
            </div>
            <div class="col-xs-3">
           <a href="index.php" class="btn btn-primary btn-block btn-flat" > Back </a>
          <!--  <button type="button"  onclick="">Back</button>-->
              
             
            </div><!-- /.col -->
            <div class="col-xs-4">
               <button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
            </div>
          </div>
        </form>
    </div><!-- /.login-box-body -->
   </div><!-- /.login-box -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
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
    <script type="text/javascript">
        function checkEmail()
        {
           var val = document.getElementById('email').value;

          if(val=="")
          {
           alert('EmailId should not be empty');
          }
        }
    </script>
  </body>
</html>
