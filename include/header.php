<?PHP session_start();
require_once 'include/User.php';

$userObject = new User(SERVER_API_KEY);
$resposne= $userObject->notifyMsg();
$c=count($resposne);
?>
      <header class="main-header">
        <!-- Logo -->
        <a href="index.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini">TFIN</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">TFIN</span>
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
              <!-- Messages: style can be found in dropdown.less-->
              <li class="dropdown messages-menu">
              
             
              <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-warning"><?php echo $c;?></span>
                </a>
               <?php if($c==0){
                ?>
               <ul class="dropdown-menu">
                  <li class="header">You have <?php echo $c;?> notifications</li>
                </ul>  
                  <?php }
                  else {
                     ?>
                   
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
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                 
                  <span class="hidden-xs"><?php echo $_SESSION['user'];?></span>
                </a>
                <ul class="dropdown-menu">
                </ul>
              </li>
            </ul>
          </div>
        </nav>
     </header>
