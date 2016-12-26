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
    <title>Excellence | Student Wise Report</title>
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
                    <h3 class="box-title">Student Wise Report </h3>
                    <hr />
                  </div><!-- /.box-header -->
                <div class="box-body">
                	<form role='form' method="get" action="student-wise-report.php">
                	<div class="form-group">
                		<div class='col-md-4'>
							<select name="student" id="student" class="form-control" required>
		                        <option value="">Select Student</option>
		                        <?php
		                        	  require 'include/student.php';	
		                              $studentobj=new Student(SERVER_API_KEY);
		                              $result=$studentobj->getData(TABLE_STUDENT,'','',array('student_id'=>'ASC'));
                     
					  					foreach ($result as $row)
									    {
										   if(isset($_GET['student']) && $row->student_id==$_GET['student'])
											   echo  "<option selected value='".$row->student_id."'>".$row->student_id." : ".$row->first_name." ".$row->last_name."</option>";
																						 else
											   echo  "<option value='".$row->student_id."'>".$row->student_id." : ".$row->first_name." ".$row->last_name."</option>";
										}
									 
		                        ?>
		                    </select>
	                    </div>
	                    
	                    <div class='col-md-4'>
							<select name="test" id="test" class="form-control" >
		                        <option value="">Select Test</option>
		                        <?php
		                        	 require 'include/test.php';
		                              $testobj=new Test(SERVER_API_KEY);
		                              $result=$testobj->getData(TABLE_TEST,'','',array('title'=>'ASC'));
		                              foreach ($result as $row)
		                              {
		                                  if(isset($_GET['test']) && $row->test_id==$_GET['test'])
		                                      echo  "<option selected value='".$row->test_id."'>".$row->title."</option>";
		
		                                  else
		                                      echo  "<option value='".$row->test_id."'>".$row->title."</option>";
		
		                              }
		                        ?>
		                    </select>
	                    </div>
	                    
	                    
	                    <div class='col-md-3'>
							<button class="btn btn-primary" type='submit'>Display Result</button>
	                    </div>
	                    </form>
	                    <div class="clearFix"></div>
                    </div>
                    	<hr>
                	  <table class="table table-bordered table-hover " id="tbl-student-wise-report" >
                 
                   <thead>
                       <tr>
                       <th>Test Id</th>
                       <th>Test Date</th>
                       <th>Test Title</th>
                       <th>Score</th>
                       <th>Percentage</th>
                       <th>Percentile</th>
                      
                      </tr>
                    </thead>
                   
                   <tbody>
                      <?php 
                      		
                      		if(isset($_GET['student']))
							{
								$test_id=0;
								if($_GET['test']!="")
								{
									$test_id=$_GET['test'];
								}
								
								$result=$testobj->getScoreAndPercentage($_GET['student'],$test_id);
								
								foreach($result as $row)
								{
									$percentile=$testobj->getPercentile($row->test_id, $row->student_marks);
									echo "<tr><td>$row->test_id</td><td>$row->test_date</td><td>$row->test_title</td><td>$row->student_marks / $row->total_marks</td><td>$row->percentage %</td> <td>$percentile</td></tr>";
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
   $('#tbl-student-wise-report').DataTable({
        "order": [[ 1, "desc" ]]
    });
       
		
        
       
</script>
   </body>
  </html>    

