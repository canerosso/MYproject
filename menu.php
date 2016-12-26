
<?php 
//session_start();
require_once 'include/Meal.php';
require_once 'include/Config.php';
          
            $object = new Meal(SERVER_API_KEY);
            $data = $object->displayBreakfast(1);
            $a1=(array)$data;
            $data1=$object->displayBread(1);
            $a2=(array)$data1;
            $data2=$object->displayRice(1);
            $a3=(array)$data2;
            $data3=$object->displaySabji(1);
            $a4=(array)$data3;
            $data4=$object->displayDal(1);
            $a5=(array)$data4;
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
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-aqua" >
                <div class="inner" data-toggle="modal" data-target="#myModal1"> 
                  <p>Breakfast</p>
                </div>
                <a href="breakfast.php" class="small-box-footer">
                 View
                </a>
              </div>
            </div><!-- ./col -->

            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-aqua" >
                <div class="inner" data-toggle="modal" data-target="#myModal2">        
                  <p>Bread</p>
                </div>    
                <a href="bread.php" class="small-box-footer">
                 <b>View</b>
                </a>
              </div>
            </div><!-- ./col -->

            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-aqua" >
                <div class="inner" data-toggle="modal" data-target="#myModal3">
                  <p>Rice</p>
                </div>
              <a href="rice.php" class="small-box-footer">
               <b>View</b>
                </a>
              </div>
            </div><!-- ./col -->

            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-aqua" >
                <div class="inner" data-toggle="modal" data-target="#myModal4">            
                  <p>Sabji</p>
                </div>     
                <a href="sabji.php" class="small-box-footer">
                 <b>View</b>
                </a>
              </div>
            </div><!-- ./col -->

            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua" >
                <div class="inner" data-toggle="modal" data-target="#myModal5">      
                  <p>Dal</p>
                </div>    
                <a href="dal.php" class="small-box-footer">
           <b>View</b>
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
          <h4 class="modal-title">Breakfast</h4>
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
              <input type="text" name="name" class="form-control input-sm">
           </div>
         </div>
         <div class="col-md-3"> 
          <div class="form-group">
          <input type="hidden" name="id" value="5">
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
           <?php for($i=0;$i<count($a1);$i++){?>
            <option value="<?php echo $a1[$i]->meal_type_id;?>"><?php echo $a1[$i]->name;?></option>
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
 <!-- Modal2 bread -->
    <div class="modal fade" id="myModal2" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Bread</h4>
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
              <input type="text" name="name" class="form-control input-sm">
           </div>
         </div>
         <div class="col-md-3"> 
          <div class="form-group">
          <input type="hidden" name="id" value="1">
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
           <?php for($i=0;$i<count($a2);$i++){?>
            <option value="<?php echo $a2[$i]->meal_type_id;?>"><?php echo $a2[$i]->name;?></option>
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
<!-- Modal3 Rice -->
    <div class="modal fade" id="myModal3" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Rice</h4>
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
              <input type="text" name="name" class="form-control input-sm">
           </div>
         </div>
         <div class="col-md-3"> 
          <div class="form-group">
          <input type="hidden" name="id" value="2">
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
           <?php for($i=0;$i<count($a3);$i++){?>
            <option value="<?php echo $a3[$i]->meal_type_id;?>"><?php echo $a3[$i]->name;?></option>
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

<!-- Modal4 Sabji -->
    <div class="modal fade" id="myModal4" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Sabji</h4>
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
              <input type="text" name="name" class="form-control input-sm">
           </div>
         </div>
         <div class="col-md-3"> 
          <div class="form-group">
          <input type="hidden" name="id" value="3">
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
           <?php for($i=0;$i<count($a4);$i++){?>
            <option value="<?php echo $a4[$i]->meal_type_id;?>"><?php echo $a4[$i]->name;?></option>
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

<!-- Modal5 Dal-->
    <div class="modal fade" id="myModal5" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Dal</h4>
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
              <input type="text" name="name" class="form-control input-sm">
           </div>
         </div>
         <div class="col-md-3"> 
          <div class="form-group">
          <input type="hidden" name="id" value="4">
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
           <?php for($i=0;$i<count($a5);$i++){?>
            <option value="<?php echo $a5[$i]->meal_type_id;?>"><?php echo $a5[$i]->name;?></option>
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
<script src="plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script src="plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/r/dt/dt-1.10.9/datatables.min.js"></script>
    <script src="plugins/datatables/jquery.dataTables_nik.js" type="text/javascript"></script>
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
   
  </body>
</html>
