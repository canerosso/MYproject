
<?php 
//session_start();
require_once 'include/Meal.php';
require_once 'include/Config.php';
          
            $object = new Meal(SERVER_API_KEY);
            $data = $object->displayMealtype(1);
            $size=(array)$data;
            
            ?>
<!DOCTYPE html>
<html>
  <head>
    <title>Excellence|Menu Type</title>
    <?php include("link.php");?>
  </head>
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">
     <?php include('header.php');?>
      <?php include('sidemenu.php');?>
     
      <div class="content-wrapper">
        <section class="content-header">
          <h1>
            Menu    
          </h1>
        </section>
        <section class="content">
          <div class="row">
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-aqua" >
                <div class="inner" data-toggle="modal" data-target="#myModal1"> 
                  <p>Add Menu Type</p>
                </div>
                <a href="main.php" class="small-box-footer">
                 View
                </a>
              </div>
            </div><!-- ./col -->

            

          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <!-- Modal1 breakfast -->
 <div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Menu Type</h4>
        </div>
      <div class="modal-body">
       <div class="row"> 
        <form name="menuform" action="api/meal/index.php/addMenutype" method="post">
         <div class="col-md-3">
          <div class="form-group">
           <label for="inputdefault">Add Items:</label>
          </div>
         </div>
         <div class="col-md-6">  
           <div class="form-group">
              <input type="text" name="name" class="form-control input-sm" required>
           </div>
         </div>
         <div class="col-md-3"> 
          <div class="form-group">
          
             <button type="submit" class="btn btn-info btn-sm" value="Save">Save</button>
          </div>
         </div>
       </div>
     </form>
    <div class="row">
      <div class="col-md-3">
       <div class="form-group"> 
         <label for="sel1">Existing Items</label>
       </div>
      </div>
      <div class="col-md-9">
        <div class="form-group"> 
           <select class="form-control">
           <?php for($i=0;$i<count($size);$i++){?>
            <option value="<?php echo $size[$i]->meal_type_id;?>"><?php echo $size[$i]->name;?></option>
           <?php }?>
           </select>
         </div>
      </div>
    </div>          
  </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
  </div>
 </div>
</div>
 
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->
 <?php include("footer.php");?>
   
  </body>
</html>
