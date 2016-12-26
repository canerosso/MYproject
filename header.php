<?PHP
 ini_set('display_errors', 1);
   ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
@session_start();
require_once 'include/User.php';
require_once 'include/Config.php';
$userObject = new User(SERVER_API_KEY);
/*$resposne= $userObject->notifyMsg();
$c=count($resposne);
$request=$userObject->request();
$c1=count($request);
$parts = explode("/", $_SERVER['REQUEST_URI']);
$file = end($parts);
//echo $file;
*/


if($_SESSION['id']!= 10) 
{	
	//echo $_SESSION['id'].">>>>>>>>>";die;
	if($_SESSION['id']!= 236) 
	{		
		//echo "Session not set";
		$_SESSION = array();
		// $app->redirect(URL);
		header('location: index.php');
	}
}


?>
<!--<?php 
$action="";
$main="";

if(strcasecmp(trim($file),"superadmin.php")==0) {

$action="api/superadmin/index.php/inviteSuperadmin";
$main="superadmin";
}
elseif (strcasecmp(trim($file),"admin.php")==0) {
$action="api/admin/index.php/inviteAdmin";
$main="admin";
}
elseif (strcasecmp(trim($file),"vendor.php")==0){
$action="api/vendor/index.php/inviteVendor";
$main="vendor";
}?>
<div class="modal fade" id="myModal3" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">
	        Add <?php echo $main;?></h4>
           </div>
      <div class="modal-body">
       <div class="row"> 
             <form role="form" action="<?php echo $action;?>" method="post" id="inviteSuperAdmin">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Please enter email</label>
                      <input type="email" class="form-control" id="exampleInputName" 
                      name="email" id="email" placeholder="josef@tfin.com" required>
                    </div>
                  </div>
                    <div class="box-footer">
                      <button type="submit" class="btn btn-primary">Invite</button>
                    </div>
             </form>
              <div class="box-footer">
                  <label id="message"></label>
                </div>
          </div>   
        </div>
      </div>
     </div>
    </div>-->

      <header class="main-header">
        <!-- Logo -->
        <a href="index.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          
          <span class="logo-mini"><!--<img src="dist/img/logo.png" height="25px" width="25px">-->RIIT</span>
          <!-- logo for regular state and mobile devices -->
         <span class="logo-lg"><img src="dist/img/logo.png" height="25px" width="25px">
          <label>RIIT</label></span>
        </a>
      <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
       <div class="navbar-custom-menu">

           <ul class="nav navbar-nav">
               
 
             <!-- Request for superadmin-->
          <?php /*    <?php if($_SESSION['user_type']==1){ ?>
              <li class="dropdown messages-menu">
                 <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-user"></i> 
                     <span class="label label-success"><?php echo $c1?></span>
                 </a>
                 <?php if($c1==0){ ?>
                <ul class="dropdown-menu">
                  <li class="header">You have <?php echo $c1;?> request</li>
                </ul> 
                  <?php } 
		  else { ?>
                <ul class="dropdown-menu">
                  <li class="header">You have <?php echo $c1;?> request</li>
                  <li>
                     <ul class="menu">
                     <?php for($i=0;$i<$c1;$i++){ ?>
                      <li>
                        <a href="#">
                          <div class="">
                          <i class="fa fa-users text-aqua"></i><?php echo $request[$i]->email;?>
                          </div>
                          <div  class="class="col-xs-3"">
                          <input type="submit" value="Approve" onclick="approve(<?php echo $request[$i]->id;?>);">
                          </div>
                        </a>
                      </li>     
                      <?php }?>               
                    </ul>
                  </li>
                  </ul>
               </li>
              <?php  }?>

              <?php }  ?>

            
              <!-- Messages: style can be found in dropdown.less-->
           <li class="dropdown messages-menu">             
              <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-envelope-o"></i>
                    <span class="label label-warning"><?php echo $c;?></span>
                </a>
                <?php if($c==0){ ?>
                 <ul class="dropdown-menu">
                   <li class="header">You have <?php echo $c;?> notifications</li>
                 </ul>  
                  <?php } else { ?>    
                 <ul class="dropdown-menu">
                    <li class="header">You have <?php echo $c;?>notifications</li>
                    <li>
                      <ul class="menu">
                        <?php for($i=0;$i<$c;$i++){ ?>
                        <li>
                           <a href="mail.php">
                             <i class="fa fa-users text-aqua"></i><?php echo $resposne[$i]->name;?> <?php echo $resposne[$i]->subject;?>
                           </a>
                         </li>     
                         <?php }?>               
                      </ul>
                    </li>
                  </ul>
               </li>
              <?php  }?>
              */?>

              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <span class="hidden-xs"><?php echo $_SESSION['name'];?></span>
                </a>
                <ul class="dropdown-menu">
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="profile.php" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="#" onclick="return check();" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                   </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
     </header>
     <script src="plugins/jQuery/jQuery-2.1.4.min1212.js"></script>
    <!-- jQuery UI 1.11.4 -->
   <script src="plugins/jquery-ui.min.js" type="text/javascript"></script>
  <script language="javascript" type="text/javascript" src="plugins/js/popup2.2.js"></script> 
     <script type="text/javascript">

	
    function check() {

  var logout = confirm("Are you sure to logout?");

   if(logout){
     location.href = "signout.php";
 }
 }
</script>
<script type="text/javascript">

  function approve(id){
       //alert(id);

      $.ajax
         ({
          type: "POST",
          url: "approveUser.php",
          data:"id="+id,
          success: function(msg)
          {
           // $("#maildata").replaceWith(msg);
          }
          });
  
  }
</script>
 <!-- Invite Super Administr -->
    <script type="text/javascript">
	function check1() {	
		if (document.getElementsByTagName) {	
			var inputElements = document.getElementsByTagName('input');		
			for (var i=0; inputElements[i]; i++) {
				inputElements[i].setAttribute('autocomplete','off');
			}
		}
		
	}

	setTimeout(function(){ 
		check1();		
	}, 900);

    $("#inviteSuperAdmin").submit(function(event){

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
              // console.log(data);

              if (data === "200") 
              {
                $( "#message" ).empty().append( "Invitation sent" );
                $('#exampleInputName').val("");
              }  
                       
            });
          }
    });

    </script>

