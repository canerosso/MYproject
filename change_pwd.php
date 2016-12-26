<?php
   session_start();
   $id=$_REQUEST['id'];
   
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
                  <div class="col-md-6">
                     <div class="box box-primary">
                        <div class="box-header with-border">
                           <h3 class="box-title">Change Password</h3>
                        </div>
                        <form action="api/superadmin/index.php/change_password_user" method="post" id="changeUserPassword">
                           <div class="box-body">
                              <div class="form-group">
                                 <label for="exampleInputEmail1">New Password</label>
                                 <input type="password" class="form-control" name="password_1" placeholder="Enter new password" required >
                              </div>
                              <div class="form-group">
                                 <label for="exampleInputEmail1">Retype Password</label>
                                 <input type="password" class="form-control" name="password_2" placeholder="Retype password" required >
                              </div>
                           </div>
                           <!-- /.box-body -->
                           <div class="box-footer">
                              <input type="hidden" name="id" value="<?php echo $id;?>">
                              <button type="submit" class="btn btn-primary">Change Password</button> 
                           </div>
                           <div>
                              <div id="progress"> </div>  
                              <label id="message"> </label>
                           </div>
                        </form>
                     </div>
                     <!-- /.box -->
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
      <script type="text/javascript">
        $("#changeUserPassword").submit(function(event){

          // prevent default submit
          event.preventDefault();
          $( "#progress" ).html('<div class="overlay"> <i class="fa fa-refresh fa-spin"></i></div>');
          // Get values 
          var $form = $( this ),
              user_id = $form.find( "input[name='id']" ).val(),
              new_password_1 = $form.find( "input[name='password_1']" ).val(),
              new_password_2 = $form.find( "input[name='password_2']" ).val(),
              url = $form.attr( "action" );
              if (new_password_1 === new_password_2) {
                // submit form
                console.log("password matched");
                var posting = $.post( url, { id: user_id, password_1:new_password_1, password_2: new_password_2 } );
                
                posting.done(function( data ) {
                var content = $( data ).find( "#content" );
                  if (data === "200") {
                    $( "#message" ).empty().append( "Password changed success" );
                    $( "#progress" ).html('');
                  }                 
                });
              }else{
                $( "#message" ).empty().append("password mismatch");
                $( "#progress" ).html('');
              }
        });
      </script>

   </body>
</html>
