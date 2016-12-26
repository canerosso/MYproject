<?php  session_start();
        require_once 'include/top.php';
        $topObject = new top(SERVER_API_KEY);
        $ids= $_GET['id'];
        $data = $topObject->getAlltop($ids);
        $name = $topObject->getcatname($ids);
        $Subjectname = $name[0]->cat_name;
                    
?>
<style type="text/css">
	.col-md-1 
	{
    margin-bottom: 2%;
    width: 14.333 %!important;
}
</style>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Excellence|ADD Topic</title>
<?php include("link.php"); ?>
</head>
  <body class="skin-blue sidebar-mini">

    <div class="wrapper">

     <?php include('header.php');?>
      <?php include('sidemenu.php');?>
    
      <div class="content-wrapper">
        <section class="content">
          <!--ADD BUTTON AT THE TOP--> 
              <button type="submit" class="btn btn-block btn-primary btn-lg" data-toggle="modal" data-target="#myModal1" style="width:auto;margin-bottom: 1%;" > Add <i class="fa fa-graduation-cap"></i></button> 
                  <a href="subject.php" class="btn btn-block btn-primary btn-lg" style="width:auto;margin-bottom: 1%;float:right;margin-top: -5%;" > Back <i class="fa fa-graduation-cap"></i></a> 
               <!-- Modal1 Add -->
           <div class="modal fade" id="myModal1" role="dialog">
             <div class="modal-dialog">
               <div class="modal-content">
                 <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                   <h4 class="modal-title"> Add Topic To Subject <?php echo $Subjectname; ?></h4>
                 </div>
                 <div class="modal-body" >
                  <div class="row"> 
                   <form role="form" action="api/top/index.php/addtop" method="post" id="inviteUser">
                    <div class="box-body">
                      <div class="form-group">
                       <label for="exampleInputEmail1">Please enter Topic Name</label>
                       <input type="text" class="form-control" id="exampleInputName" 
                       name="cat_name"  placeholder="Phy" required>
                       <input type="hidden" name="parent_id" value="<?php echo $_GET['id']; ?>">
                      <input type="hidden" name="level" value="1" >
                      </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                     <button type="submit" class="btn btn-primary"> Add</button>
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
  
           <div class="row">
              <div class="col-xs-12">
                <div class="box">
                  <div class="box-header">
                    <h3 class="box-title">  <?php echo $Subjectname; ?> Topic Management </h3>
                  </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example20" class="table table-bordered table-hover dataTable " >
                    
                   <thead>
                       <tr>
                       <th>Sr No</th>
                       <th>Topic Name</th>
                       <th>Action </th>
                      
                       
                      </tr>
                    </thead>
                   
                    <tbody>
                      <?php
                     
                       echo $data;
                   
                     ?>
                    </tbody>
                    
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->

           <!--ADD BUTTON AT THE BOTTOM--> 
           <button type="submit" class="btn btn-block btn-primary btn-lg" data-toggle="modal" data-target="#myModal1" style="width:auto;margin-bottom: 1%;" > Add <i class="fa fa-mortar-board"></i></button> 
              <a href="subject.php" class="btn btn-block btn-primary btn-lg" style="width:auto;margin-bottom: 1%;float:right;margin-top: -5%;" > Back <i class="fa fa-graduation-cap"></i></a> 
            <!-- Modal1 Add -->

        </section>
      </div>
     </div> 
   
      <div class="control-sidebar-bg"></div>
 <?php include("footer.php");?>
     <script type="text/javascript">
      $(function () {
        //$("#example1").DataTable();
        $('#example20').DataTable({
          
        });
      });
    </script>
     <!-- Invite Super Administr -->
  
   </body>
  </html>    

