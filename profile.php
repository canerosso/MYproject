<?php 
  session_start();
  require_once 'include/Config.php';
  if($_SESSION!="") 
{


  require_once 'include/Tiffin.php';
   ini_set('display_errors', 1);
  $tiffinobject = new Tiffin();
  //$data = $tiffinobject->getAllLoactions();  //Display all locations for selection to vendor
  //$size=$tiffinobject->displayPlace(); //Display places selected by the vendor        
        
   $user=$tiffinobject->getAlluser();

        
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Excellence| Profile</title>
    <?php include("link.php");?>
        <link rel="stylesheet" href="plugins/select2/select2.min.css">
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
                  <h3 class="box-title">Profile</h3>
                </div>

<?php
    if (isset($_GET['chpwd']) && $_GET['chpwd']==200) {
             echo '<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5>  <i class="icon fa fa-check"></i>  Password Updated successfully .</h5>
                  </div>';   
            }elseif(isset($_GET['chpwd']) && $_GET['chpwd']==401)
            {
              echo '<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fa fa-ban"></i> Old password not match</h5>
                          </div>';   
            }
            elseif(isset($_GET['chpwd']) && $_GET['chpwd']==400)
              {
              
echo '<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fa fa-ban"></i>Enter same new and confirm Password !</h5>
                  </div>'; 

              }
                 elseif(isset($_GET['chpwd']) && $_GET['chpwd']==406)
              {
             
              
echo '<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fa fa-ban"></i> Please Enter atleast six character !</h5>
                  </div>'; 
                   }
            
?>

<?php
    if (isset($_GET['pu']) && $_GET['pu']==200) {
              echo '<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4>  <i class="icon fa fa-check"></i>  profile Updated successfully .</h4>
                  </div>';   
            }elseif(isset($_GET['pu']) && $_GET['pu']!=200){
              echo '<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> Error During updating Profile</h4>
                     .
                  </div>';   
            }
?>


                <form role="form" action="#" method="post" id="idOfForm">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Name</label>
                      <input type="text" readonly class="form-control" id="exampleInputName" name="name" 
                      value="<?php echo $user[0]->name; ?>" required>
                    </div>
                     <!--<div class="form-group">
                      <label for="exampleInputEmail1">Address</label><br/>
                      <textarea readonly="readonly" lass="form-control" id="exampleInputContact" name="mobile"
                       placeholder="Enter address" rows="4" cols="63"><?php echo $user[0]->address;?>
</textarea>
                    

                      
                     </div>-->
                    <div class="form-group">
                      <label for="exampleInputEmail1">Contact</label>
                      <input  type="text" readonly class="form-control" id="exampleInputContact" name="mobile"
                       placeholder="Enter mobile" value="<?php echo $user[0]->mobile; ?>" pattern="[7-9]{1}[0-9]{9}" 
                       title="Phone number with 7-9 and remaing 9 digit with 0-9" maxlength="10" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Email</label>
                      <input type="text" class="form-control" id="exampleInputEmail" name="email"
                       placeholder="Enter email" value="<?php echo $user[0]->email;?>" readonly >
                    </div>
                  </div>
                  <div class="box-footer">
                   
                  <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal3">Edit Profile</a>

                   <input type="hidden" name="id" value="<?php echo $_SESSION['id']; ?>">
                   <!-- <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal2">Change Password</a>            -->
                  </div>  
                </form>
               </div><!--box-->
           </div> <!--col-->

<div class="modal fade" id="myModal3" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">

  <form role="form" action="api/admin/index.php/updateProfile" method="post" id="idOfForm">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Name</label>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <input type="text" class="form-control" id="exampleInputName" name="name" 
                      value="<?php echo $_SESSION['name']; ?>" required>
                    </div>
                     <!--<div class="form-group">
                      <label for="exampleInputEmail1">Address</label>
                      <br/>
        <textarea  class="form-control" id="exampleInputContact" name="address"
                       placeholder="Enter address" rows="4" cols="63"><?php echo $user[0]->address;?>
</textarea>
                    
                     </div>-->
                    <div class="form-group">
                      <label for="exampleInputEmail1">Contact</label>
                      <input type="text" class="form-control" id="exampleInputContact" name="mobile"
                       placeholder="Enter mobile" value="<?php echo $_SESSION['mobile']; ?>" pattern="[7-9]{1}[0-9]{9}" 
                       title="Phone number with 7-9 and remaing 9 digit with 0-9" maxlength="10" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Email</label>
                      <input type="text" class="form-control" id="exampleInputEmail" name="email"
                       placeholder="Enter email" value="<?php echo $_SESSION['user']; ?>" readonly >
                    </div>
                  </div>
                  <div class="box-footer">
                   <button type="submit" class="btn btn-primary"  id="edit_profile">Update Profile</button>
                   <input type="hidden" name="id" value="<?php echo $_SESSION['id']; ?>">
                              
                  </div>
                    <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
             </div>  
                </form>
                </div>
                </div>
</div>

                     <!-- Modal1 breakfast -->
  <div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        
         <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Change Password</h4>
         </div>

       <div class="modal-body">
         <div class="row"> 
          <form role="form" autocomplete="off" action="api/superadmin/index.php/update_password" method="post" >
           <div class="col-md-12">
             <div class="form-group">
               <label for="exampleInputEmail1">Old Password</label>
               <input type="password" class="form-control" name="old_password" placeholder="Enter old password" required>
             </div>

            <div class="form-group">
               <label for="exampleInputEmail1">New Password</label>
               <input type="password" class="form-control" name="password_1" placeholder="Enter new password" required >        
            </div>

             <div class="form-group">
                <label for="exampleInputEmail1">confirm Password</label>
                <input type="password" class="form-control" name="password_2" placeholder="confirm password" required >
             </div>

             <div class="box-footer"> 
                <button type="submit"  class="btn btn-primary">Change Password</button> 
             </div>
             <input type="hidden" name="id" value="<?php echo $_SESSION['id']; ?>"> 
             <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
             </div> 
              <div class="box-footer" > 
                <label id="message"></label>
              </div>   

            </div>  
          </form> 
        </div>  <!--row-->
       </div>  <!--modal body-->

     </div>
   </div>
  </div>        
            <?php
            if ($_SESSION['user_type'] == VENDOR) {?>
            <div class="col-md-6">
              <div class="box box-default collapsed-box">
                <div class="box-header with-border">
                  <h3 class="box-title">Add Delivery Areas</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->

                <div class="box-body">
                  <form role="form" action="api/tiffin/index.php/addPlace" method="post" id="add_places"> 
                    <div class="form-group">     
                      <label for="exampleInputEmail1">Add Deleviry Areas</label>
                       <select class="form-control select2" style="width: 100%;" name="location" id="location" required>
                         <option value="">Select Place</option>            
                        <?php for($i=0;$i<count($data);$i++){?>
                          <option value="<?php echo $data[$i]->location;?>"><?php echo $data[$i]->location;?></option>
                          <?php }?>
                       </select>
                    </div><!--form group-->
                   <br/>
                   <input type="hidden" name="user_id" value="<?php echo $_SESSION['id'];?>">
                   <div class="box-footer">
                     <button type="submit"  class="btn btn-primary">Add Deleviry Area</button>
                    </div>  
                  </form>                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              <div class="box box-primary"> 
                <div class="box-header">
                  <h3 class="box-title">Delivery Areas</h3>
                </div><!-- /.box-header -->
                 <div class="box-body">
                   <table id="example2" class="table table-bordered table-hover" id="maildata">
                    <thead>
                     <tr>
                     <th>Area Name</th>
                     <th>Action</th>
                     </tr>
                     </thead>
                      <tbody> 
                      <?php for($i=0;$i<count($size);$i++){?>
                     <tr>
                     <td>
                     <label for="exampleInputEmail1"><?php echo $size[$i]->place_name; ?></label>
                      <!--<input type="text" class="form-control"  value="<?php echo $size[$i]->place_name; ?>">-->
                     </td>
                     <td>
                      <div class="col-md-8"><input type="button" class="btn btn-block btn-danger" value="Delete" onclick="return checkValue(<?php echo $size[$i]->id;?>);"></div>
                      <!--  <input type="hidden"  value="<?php echo $size[$i]->id;?>" >-->
                     </td>
                     </tr>
                     <?php }?>
                      <tbody>
                    </table>      
                   </div>
                 </div>         
            </div><!-- /.col -->           
       <?php } ?>
       </div>
       
   <div class="row">
    <!--<div class="col-md-6">
       <div class="box box-primary"> 
          <div class="box-body">
           <!--  <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#myModal1">Change Password</button>           
          </div><!--box body-->
       </div><!--box-->
    </div><!--col-->
  </div> <!--row-->-->
          <!-- Modal1 breakfast -->
  <div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        
         <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Change Password</h4>
         </div>

       <div class="modal-body">
         <div class="row"> 
          <form role="form" action="api/superadmin/index.php/update_password" method="post" id="changeUserPassword">
           <div class="col-md-12">
             <div class="form-group">
               <label for="exampleInputEmail1">Old Password</label>
               <input type="password" class="form-control" name="old_password" placeholder="Enter old password" required>
             </div>

            <div class="form-group">
               <label for="exampleInputEmail1">New Password</label>
               <input type="password" class="form-control" name="password_1" placeholder="Enter new password" required >        
            </div>

             <div class="form-group">
                <label for="exampleInputEmail1">Retype Password</label>
                <input type="password" class="form-control" name="password_2" placeholder="Retype password" required >
             </div>

             <div class="box-footer"> 
                <button type="submit" class="btn btn-primary">Change Password</button> 
             </div>
             <input type="hidden" name="id" value="<?php echo $_SESSION['id']; ?>"> 
             <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
             </div> 
              <div class="box-footer" > 
                <label id="message"></label>
              </div>   

            </div>  
          </form> 
        </div>  <!--row-->
       </div>  <!--modal body-->

     </div>
   </div>
  </div>        
 </section>
       
      <div class="control-sidebar-bg"></div>
      </div>
  <?php include("footer.php");?>
   <!-- Select2 -->
    <script src="plugins/select2/select2.full.min.js"></script>
    <!-- InputMask -->
    <script src="plugins/input-mask/jquery.inputmask.js"></script>
    <script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>  
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- Page script -->
   
  <script type="text/javascript">
    // Handle edit profile click
    $(document).ready(function(){
      // Edit profile button handler
      $("#edit_profile").click(function(event){
          // event.preventDefault();
      });
    });
  </script>

  <script type="text/javascript"> //Change password script
    $("#changeUserPassword").submit(function(event){

      // prevent default submit
      event.preventDefault();

      // Get values 
      var $form = $( this ),
          original_password = $form.find( "input[name='old_password']" ).val(),
          new_password_1 = $form.find( "input[name='password_1']" ).val(),
          new_password_2 = $form.find( "input[name='password_2']" ).val(),
          user_id = $form.find( "input[name='id']" ).val(),
          url = $form.attr( "action" );

          //console.log(old_password);
          //console.log(password_1);
          //console.log(password_2);

          if (new_password_1 === new_password_2) {
            // submit form
           // console.log("password matched");
            var posting = $.post( url, { old_password: original_password, password_1:new_password_1, password_2: new_password_2, id:user_id } );
            
            posting.done(function( data ) {
            var content = $( data ).find( "#content" );
             // console.log(data);
              if (data == "200") 
        {
                  console.log(data);
                $( "#message" ).empty().append( "Password changed success" );
              }else if (data === "401") {};{
                $( "#message" ).empty().append( "Old password mismatch" );
              }                 
            });
          }else{
            $( "#message" ).empty().append("password mismatch");
          }
    });
    </script>


    <script>  //To display Location in dropdown script
      $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

       /* // Add Places
        $("#add_places").submit(function(e){
          e.preventDefault();
          
          // Accept data from select 2
          var data = $('.select2').select2('data');
          console.log(data[0].text);


          // Accept data from FORM
          var $form = $( this ),
          user_id = $form.find( "input[name='user_id']" ).val(),
          url = $form.attr( "action" );
        });*/
      });
    </script>
  <script type="text/javascript"> //To delete the delivery area
  function  checkValue(id) {
  
   var delete2 = confirm("Are you sure to delete?");
    
   if(delete2)
   {
         $.ajax
         ({
          type: "POST",
          url: "deleteDeliveryPlace.php",
          data:"id="+id,
          success: function(msg)
          {
              alert('Place Deleted ');

            $("#example2").replaceWith(msg);
          }
          });
        
    }
  }
</script>
 <script type="text/javascript"> //For pagination
      $(function () {
        $("#example2").DataTable();
      });
    </script>

    </body>
    </html>

    <?php }
else {?>
   <script type="text/javascript">
    window.location.href = "<?php echo URL ?>";
   </script>
<?php } ?>
