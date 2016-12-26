<?php  session_start();
   if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
      //echo 'In Session';

   }else{
      # SESSION NO VALID 
      header("Location: index.php");
   }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>RIIT|ADD SUPERADMIN</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
  
    <link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
</head>
  <body class="skin-blue sidebar-mini">

    <div class="wrapper">

     <?php include('header.php');?>
      <?php include('sidemenu.php');?>
    
      <div class="content-wrapper">
      
        <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Add Superadmin</h3>
                </div><!-- /.box-header -->
               <div class="alert alert-info">
                  <?php
                   
                    if (isset($_GET['er'])&& $_GET['er']==200) {
                      # code...
                      echo 'Mail send Successfully to your mail id';
                    }
                    elseif(isset($_GET['er'])&& $_GET['er']==400)
		   {
                      echo 'Emailid already exist';
		   }
                    else{
                        echo 'Please enter your emailid.';
                    }
                ?>
            </div>
                <form role="form" action="api/superadmin/index.php/add_subadmin" method="post" onsubmit=" return checkEmail();">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Superadmin email</label>
                      <input type="email" class="form-control" id="exampleInputName" name="subadmin_email" 
                      id="email" placeholder="Enter email" required>
                    </div>
                  </div><!-- /.box-body -->
                    <div class="box-footer">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
              </div><!-- /.box -->
            </div>
            <div class="col-md-6">

            </div>
          </div>  
        </section>
      </div>
   
      <div class="control-sidebar-bg"></div>
       </div>

    <!-- jQuery 2.1.4 -->
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
        function checkEmail()
        {
           var val = document.getElementById('email').value;

          if(val=="")
          {
           alert('EmailId should not be empty');
          }
        }
    </script>
