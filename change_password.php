<?php
    session_start();
    
    if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
        //echo 'In Session';

    }else{
        # SESSION NO VALID 
        header("Location: index.php");
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Excellence|CHANGE PASSWORD</title>
  <?php include("link.php");?>
</head>
   <body class="skin-blue sidebar-mini">
    <div class="wrapper">
      <?php include('header.php');?>
      <?php include('sidemenu.php');?>
       <div class="content-wrapper">
         <section class="content">
          <div class="row">
            <div class="col-md-12"> 
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Change Password</h3>
                </div>
              
                <form action="api/admin/index.php/change_password" method="post">
                  <div class="box-body">
                  
                    <div class="form-group">
                      <label for="exampleInputEmail1">Old Password</label>
                      <input type="password" class="form-control" name="user" placeholder="Enter old password" required>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputEmail1">New Password</label>
                      <input type="password" class="form-control" name="password_1" placeholder="Enter new password" required >
                    </div>

                     <div class="form-group">
                      <label for="exampleInputEmail1">Retype Password</label>
                      <input type="password" class="form-control" name="password_2" placeholder="Retype password" required >
                    </div>
                    
                  </div><!-- /.box-body -->
                   
                    <div class="box-footer">
                     <input type="hidden" name="username" value="<?php echo $_SESSION['user'];?>">
                      <button type="submit" class="btn btn-primary">Change Password</button>
                    </div>
                </form>
              </div><!-- /.box -->
            </div>
            <div class="col-md-6">

            </div>
          </div>  
        </section>
      </div>
     </div>
      <div class="control-sidebar-bg"></div>
       </div>
<?php include("footer.php");?>
</body>
</html>
