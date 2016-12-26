
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Excellence| Dashboard</title>
    <?php include("link.php");?>
  </head>
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">
      <?php include('header.php');?>
      <?php include('sidemenu.php');?>
       <div class="content-wrapper">
        <section class="content"> 
          <div class="row">  
          
          <?php
    if (isset($_GET['id']) && $_GET['id']==200) {
             echo '<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5>  <i class="icon fa fa-check"></i>  Notification Sent successfully .</h5>
                  </div>';   
            }
            if(isset($_GET['id']) && $_GET['id']==400)
              {
              
echo '<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fa fa-ban"></i> Error While Sending Notification !</h5>
                  </div>'; 

              }
      
            
?>
            

          <div class="col-md-12" style="margin-top: 5%;">  
          <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title"> Add Notification</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal"  method="post" action="api/notify/index.php/notification" >
                  <div class="box-body">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Notification</label>
                      <div class="col-sm-10">
                       <textarea class="form-control" maxlength="120" rows="3" name="msg" placeholder="Enter Notification ..." required></textarea>
                      

                      </div>
                    </div>
                  
                   
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                   
                    <button type="submit" class="btn btn-info pull-right"> Send</button>
                  </div><!-- /.box-footer -->
                </form>
              </div>
 </div>
          </div><!-- /.row (main row) -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
     <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->
  <?php include("footer.php");?>
  </body>
</html>
