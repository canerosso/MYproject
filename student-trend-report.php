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
    <title>Excellence | Student Trend Report</title>
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
                    <h3 class="box-title">Student Trend Report </h3>
                    <hr />
                  </div><!-- /.box-header -->
                <div class="box-body">
                	<form role='form' method="get" action="student-trend-report.php">
                	<div class="form-group">
                		<div class='col-md-3'>
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
	                    
	                    <div class='col-md-3'>
							<select name="subject" id="subject" class="form-control" required>
		                        <option value="">Select Subject</option>
		                        <?php
		                        	 require 'include/sub.php';
		                              $subjectObj=new sub(SERVER_API_KEY);
		                              $result=$subjectObj->getData(TABLE_CAT,'','',array('cat_name'=>'ASC'));
		                              foreach ($result as $row)
		                              {
		                                  if(isset($_GET['subject']) && $row->cat_id==$_GET['subject'])
		                                      echo  "<option selected value='".$row->cat_id."'>".$row->cat_name."</option>";
		
		                                  else
		                                      echo  "<option value='".$row->cat_id."'>".$row->cat_name."</option>";
		
		                              }
		                        ?>
		                    </select>
	                    </div>
	                    <div class='col-md-3'>
							Display result for major tests only <Br>
							<?php if(isset($_GET['optmajortests']) && $_GET['optmajortests']=="YES") { ?> 
									<label class="radio-inline"><input type="radio" name="optmajortests" value="YES" checked="checked">Yes</label>
									<label class="radio-inline"><input type="radio" name="optmajortests" value="NO" >No</label>		
								<?php } else{?>
									<label class="radio-inline"><input type="radio" name="optmajortests" value="YES" >Yes</label>
									<label class="radio-inline"><input type="radio" name="optmajortests" value="NO" checked="checked">No</label>	
								<?php }?>	
	                    </div>
	                    
	                    <div class='col-md-3'>
							<button class="btn btn-primary" type='submit'><i class='fa fa-line-chart'></i> Load Graph</button>
	                    </div>
	                    </form>
	                    <div class="clearFix"></div>
                    </div>
                    	<hr>
                	  
                   <div id="curve_chart" style="width: 100%; height: 500px"></div>
					     <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
			    <script type="text/javascript">
			      google.charts.load('current', {'packages':['corechart', 'line']});
			      google.charts.setOnLoadCallback(drawChart);
			
			      function drawChart() {
			        var data = google.visualization.arrayToDataTable(
			           	<?php 
			           		  require 'include/test.php';
							  $testobj=new Test(SERVER_API_KEY);
							  $graphdata=array();
							  array_push($graphdata,array('Test','Percentile','Percentage (%)'));
							  
							  if(isset($_GET['student']))
							  {
							  		$result=$testobj->getPercentageTrend($_GET['student'],$_GET['subject'],$_GET['optmajortests']);
									foreach($result as $row)
									{
										$percentile=$testobj->getPercentile($row->test_id, $row->student_marks);
										array_push($graphdata,array($row->test_title,floatval($percentile),floatval($row->percentage)));
									}
									
									if(count($result)==0)
										array_push($graphdata,array('',0,0));
							  }   
							  else {
								  array_push($graphdata,array('',0,0));
							  }
							  echo json_encode($graphdata);
							  
						?>
			        
			        	);
			
			        var options = {
			          title: 'Student Performance Report',
			          curveType: 'function',
			          legend: { position: 'top' },
			          lineWidth: 2,
			         vAxis: { 
				              title: "", 
				              viewWindowMode:'explicit',
				              viewWindow:{
				                max:120,
				                min:0
				              }
				           },
				           
			          pointSize: 8,
			          pointShape: 'circle'
					   
			        };
			
			        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
			
			        chart.draw(data, options);
			      }
			      
			      
			      
			    </script>
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

