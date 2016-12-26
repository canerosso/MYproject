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
    <title>Excellence | Average score and Average percentage Trend </title>
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
                    <h3 class="box-title">Average score and Average percentage Trend </h3>
                    <hr />
                  </div><!-- /.box-header -->
                <div class="box-body">
                	<form role='form' method="get" action="trending-report.php">
                	<div class="form-group">
                		<div class='col-md-3'>
							<select name="course" id="course" class="form-control" required onchange="getSubject(this.value)">
		                        <option value="">Select Course</option>
		                        <?php
		                        	  require 'include/course.php';	
		                              $courseobj=new Course(SERVER_API_KEY);
		                              $result=$courseobj->getData(TABLE_COURSE,'',array('isDeleted'=>0),array('course_name'=>'ASC'));
                     					foreach ($result as $row)
									    {
										   if(isset($_GET['course']) && $row->course_id==$_GET['course'])
											   echo  "<option selected value='".$row->course_id."'>".$row->course_name."</option>";
																						 else
											   echo  "<option value='".$row->course_id."'>".$row->course_name."</option>";
										}
									 
		                        ?>
		                    </select>
	                    </div>
	                    
	                    
                      	
	                    <div class='col-md-3' id="subjectDiv">
							<select name="subject" id="subject" class="form-control" >
		                        <option value="">Select Subject</option>
		                        <?php
		                        	 if(isset($_GET['course'])) 
									 {
			                        	 require 'include/sub.php';
			                              $subjectObj=new sub(SERVER_API_KEY);
			                              $result=$subjectObj->getData(TABLE_CAT,'','',array('cat_name'=>'ASC'));
			                              foreach ($result as $row)
			                              {
			                              	 $courses=@explode(",", $row->course);
			                              	 if(in_array($_GET['course'], $courses))
			                              	 {
			                                  if(isset($_GET['subject']) && $row->cat_id==$_GET['subject'])
			                                      echo  "<option selected value='".$row->cat_id."'>".$row->cat_name."</option>";
			
			                                  else
			                                      echo  "<option value='".$row->cat_id."'>".$row->cat_name."</option>";
											 }	
			                              }
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
							  array_push($graphdata,array('Test','Average Score','Average Percentage (%)'));
							  
							  if(isset($_GET['course']))
							  {
							  		$subject_id=0;
									if($_GET['subject']!="") { $subject_id=$_GET['subject']; }
							  		$result=$testobj->getAverageScoreAveragePercentageTrend($_GET['course'],$subject_id,$_GET['optmajortests']);
									
									foreach($result as $row)
									{
										array_push($graphdata,array($row->test_title,floatval($row->average_score),floatval($row->average_percentage)));
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
			          title: 'Average Score and Average Percentage Report',
			          curveType: 'function',
			          legend: { position: 'top' },
			          lineWidth: 2,
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
       
		
         function getSubject(course){
	   		$.ajax({
						type : "POST",
						url : "api/sub/index.php/getCourseSub2",
						data : {course:course},
						success : function(response) {
							$('#subjectDiv').html(response);
						}
					});


	   }
       
</script>
   </body>
  </html>    

