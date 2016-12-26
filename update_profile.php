<?php session_start();
 $userid=$_SESSION['id'];?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>RIIT|UPDATE Profile</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
  </head>
  
     
  <body class="skin-blue sidebar-mini">
     <?php 
    
            require_once 'include/Admin.php';
            require_once 'include/Config.php';
          
            $object = new Admin(SERVER_API_KEY);
            $data = $object->getAllDetails(1);
            //print_r($data);
            unset($object);
  
       ?>
    <div class="wrapper">

     <?php include('header.php');?>
      <?php include('sidemenu.php');?>
     
      <div class="content-wrapper">   
        <section class="content">
         <div class="row">
            <div class="col-md-6">
              <div class="box box-primary">
                 <div class="box-header with-border">
                  <h3 class="box-title">Profile</h3>
                 </div>
                <form role="form" action="api/admin/index.php/updateProfile" method="post" id="idOfForm">
                  <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" class="form-control" id="exampleInputName" name="name" 
                         value="<?php echo $data[0]->name; ?>" >
                     </div>
                     <div class="form-group">
                        <label for="exampleInputEmail1">Contact</label>
                        <input type="text" class="form-control" id="exampleInputContact" name="mobile"
                         placeholder="Enter mobile" value="<?php echo $data[0]->mobile; ?>" pattern="[7-9]{1}[0-9]{9}" title="Phone number with 7-9 and remaing 9 digit with 0-9" maxlength="10" >
                     </div>
                     <div class="form-group">
                       <label for="exampleInputEmail1">Emailid</label>
                       <input type="text" class="form-control" id="exampleInputEmail" name="email"
                       placeholder="Enter email" value="<?php echo $data[0]->email; ?>"  readonly>
                     </div>
                 </div>
                    <div class="box-footer">
                     <button type="submit" class="btn btn-primary">Update</button>
                     <input type="hidden" name="id" value="<?php echo $userid;?>">
                    </div>
                 </form>
              </div><!-- /.box -->
            </div><!--col-->         
          </div>  
        </section>
   

      <div class="control-sidebar-bg"></div>
    </div>
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
    function doPreview()
    {
        form=document.getElementById('idOfForm');
       // form.target='_blank';
        form.action='change_password.php';
        form.submit();
       // form.action='send.php';
        form.target='';
    }
</script>
