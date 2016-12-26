
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
    <title>Excellence|Menu</title>
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
         
            <div class="col-xs-2">
              <a href="javascript:history.back()"><input type="button" name="Back" value="Back" class="btn btn-block btn-primary"></a>
            </div><!-- ./col --> 
          </div><!-- /.row -->
          <br/>
          <div class="row">
          <?php for($i=0;$i<count($size);$i++){?>
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-aqua" id="<?php echo $i+1;?>" name="id">  
                 <div class="inner" data-toggle="modal" data-target="#myModal1" onclick="test(<?php echo $i+1;?>);"> 
                   <p><?php echo $size[$i]->name;?></p>
                 </div>
                 <a href="manuview.php?id=<?php echo $size[$i]->meal_type_id;?>" class="small-box-footer">
                   View
                 </a>
              </div>
            </div><!-- ./col -->
             <?php }?>
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

 <div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Item</h4>
        </div>
      <div class="modal-body">
       <div class="row"> 
        <form name="menuform" action="api/meal/index.php/addMenu" method="post">
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
          <input type="hidden" name="id" value="" id="meal_id">
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
        <div id="maildata">
           <select class="form-control">
           <?php for($i=0;$i<count($size1);$i++){?>
            <option value="<?php echo  $a1[$i]->meal_type_id;?>"><?php echo  $a1[$i]->name;?></option>
           <?php }?>
           </select>
         </div>
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
</div>

      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->
 <?php include("footer.php");?>
   
  </body>
</html>
 <script type="text/javascript">

  function Data(){

      // var delete2 = confirm("Are you sure to delete?");
      //var id=$('#meal_id').val()
       alert(data);

   if(delete2)
   {
      $.ajax
         ({
          type: "POST",
          url: "deleteData.php",
          data:"id="+id,
          success: function(msg)
          {
            $("#maildata").replaceWith(msg);
          }
          });
   }
  }
</script>

<script type="text/javascript">

  function test(id){
        $.ajax
         ({
          type: "POST",
          url: "existingMenu.php",
          data:"id="+id,
          success: function(msg)
          {
            $("#maildata").replaceWith(msg);
            $("#meal_id").val(id);
          }
          });
   }
   </script>
