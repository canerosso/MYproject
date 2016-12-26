<?php  session_start();?>
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
    <title>Excellence | Bottom 25 Scorers</title>
<?php include("link.php"); ?>
</head>
  <body class="skin-blue sidebar-mini">

    <div class="wrapper">

     <?php include('header.php');?>
      <?php include('sidemenu.php');?>
    
      <div class="content-wrapper">
        <section class="content">

           
  
           <div class="row">
              <div class="col-xs-12">
                <div class="box">
                  <div class="box-header">
                    <h3 class="box-title">Bottom 25 Scorers </h3>
                    <hr />
                  </div><!-- /.box-header -->
                <div class="box-body">
					<select name="test" id="test" class="form-control" required>
                        <option value="">Select Test</option>
                        <?php
                        	  require 'include/test.php';	
                              $testobj=new Test(SERVER_API_KEY);
                              $result=$testobj->getData(TABLE_TEST,'','',array('title'=>'ASC'));
                              foreach ($result as $row)
                              {
                                  if(isset($_GET['Id']) && $row->test_id==$_GET['Id'])
                                      echo  "<option selected value='".$row->test_id."'>".$row->title."</option>";

                                  else
                                      echo  "<option value='".$row->test_id."'>".$row->title."</option>";

                              }
                        ?>
                    </select>
                    	<hr>
                	  <table class="table table-bordered table-hover " id="tbl-top-scorers-list" >
                 
                   <thead>
                       <tr>
                       <th>Rank</th>
                       <th>Student Id</th>
                       <th>Student Name</th>
                       <th>Course</th>
                       <th>Student Marks</th>
                       <th>Test Title</th>
                       <th>Test Date </th>
                      </tr>
                    </thead>
                   
                   <tbody>
                      <?php 
                      		
					  		if(isset($_GET['Id']))
							{
								$result=$testobj->getBottom25Scorers($_GET['Id']);
								foreach($result as $row)
								{
									echo "<tr><td>$row->rank</td><td>$row->student_id</td><td>$row->student_name</td><td>$row->course_name</td><td>$row->student_marks</td><td>$row->test_title</td><td>$row->test_date</td></tr>";
								}
							}
							
					  ?>

                    </tbody>
                     
                  </table>
					      <!--<ul class="pagination">

                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->

        </section>
      </div>
     </div> 
   
      <div class="control-sidebar-bg"></div>
 <?php include("footer.php");?>
   
     <!-- Invite Super Administr -->
  <script type="text/javascript">
   $('#tbl-top-scorers-list').DataTable({});
       
		$("#test").change(function(){ 
            if($(this).val().length!=0)
            {
                window.location='bottom-scorers-report.php?Id='+$(this).val();
            }

        });
        
       
</script>
   </body>
  </html>    

