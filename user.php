<?php  session_start();?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>RIIT|ADD USERS</title>
<?php include("link.php"); ?>
</head>
  <body class="skin-blue sidebar-mini">

    <div class="wrapper">

     <?php include('header.php');?>
      <?php include('sidemenu.php');?>
    
      <div class="content-wrapper">
        <section class="content">
          <!--ADD BUTTON AT THE TOP--
             <div class="row">
              <div class="col-md-1">
                <div class="box">
                 <div class="box-body">
                   <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#myModal1"><i class="fa fa-plus-square-o"></i></button> 
                 </div>
                </div>
               </div>
            </div>
                 <!-- Modal1 Add -->
           <?php /*
           <div class="modal fade" id="myModal1" role="dialog">
             <div class="modal-dialog">
               <div class="modal-content">
                 <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                   <h4 class="modal-title"> Add User</h4>
                 </div>
                 <div class="modal-body">
                  <div class="row"> 
                   <form role="form" action="api/users/index.php/inviteUser" method="post" id="inviteUser">
                    <div class="box-body">
                      <div class="form-group">
                       <label for="exampleInputEmail1">Please enter email</label>
                       <input type="email" class="form-control" id="exampleInputName" 
                       name="email" id="email" placeholder="josef@tfin.com" required>
                      </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                      <button type="submit" class="btn btn-primary">Invite</button>
                    </div>
                   </form>
                  <div class="box-footer">
                    <label id="message"></label>
                  </div>
               </div>     
              </div>  <!--modal body-->
            </div> <!--modal-content-->
           </div> <!--modal-dialog-->
          </div>  <!--modal fade--> 
  */?>
           <div class="row">
              <div class="col-xs-12">
                <div class="box">
                  <div class="box-header">
                    <h3 class="box-title">Users</h3>
                  </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example2" class="table table-bordered table-hover dataTable " >
                    
                   <thead>
                       <tr>
                       <th>Name</th>
                       <!-- <th>Score</th> -->
                       <th>Contact No</th>
                       <th>Email</th>
                       
                      </tr>
                    </thead>
                   
                    <tbody>
                      <?php
                       require_once 'include/Users.php';
                       $userObject = new Users(SERVER_API_KEY);
                       $data = $userObject->getAllUsers(1);
                       echo $data;
                     ?>
                    </tbody>
                    
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->

           <!--ADD BUTTON AT THE BOTTOM- 
          <div class="row">
           <div class="col-md-1">
              <div class="box">
                 <div class="box-body">
                   <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#myModal1"><i class="fa fa-plus-square-o"></i></button> 
                 </div>
              </div>
            </div>
         </div>-->
                <?php /*
                 <!-- Modal1 Add -->
        <div class="modal fade" id="myModal1" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content"> 
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> Add User</h4>
              </div>
              <div class="modal-body">
               <div class="row"> 
                 <form role="form" action="api/user/index.php/inviteUser" method="post" id="inviteUser">
                   <div class="box-body">
                     <div class="form-group">
                       <label for="exampleInputEmail1">Please enter email</label>
                       <input type="email" class="form-control" id="exampleInputName" 
                       name="email" id="email" placeholder="josef@tfin.com" required>
                     </div>
                   </div><!-- /.box-body -->
                   <div class="box-footer">
                      <button type="submit" class="btn btn-primary">Invite</button>
                   </div>
                 </form>
                 <div class="box-footer">
                   <label id="message"></label>
                 </div>
              </div>     
             </div>  <!--modal body-->
           </div> <!--modal-content-->
         </div> <!--modal-dialog-->
        </div>  <!--modal fade--> 
       */ ?>
        </section>
      </div>
     </div> 
   
      <div class="control-sidebar-bg"></div>
 <?php include("footer.php");?>
     <script type="text/javascript">
      $(function () {
        //$("#example1").DataTable();
        $('#example2').DataTable({
          
        });
      });
    </script>
     <!-- Invite Super Administr -->
    <script type="text/javascript">

    $("#inviteUser").submit(function(event){

      // prevent default submit
      event.preventDefault();

      // Get values 
      var $form = $( this ),
          email = $form.find( "input[name='email']" ).val(),
          url = $form.attr( "action" );

          if (email === "") {
            $( "#message" ).empty().append("password mismatch");
          }else{

            // submit form
            var posting = $.post( url, {email: email} );
            posting.done(function( data ) {
            var content = $( data ).find( "#content" );
              if (data === "200") {
                $( "#message" ).empty().append( "Invitation sent" );
                $('#exampleInputName').val("");
              }                 
            });
          }
    });

    </script>

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
