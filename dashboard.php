
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>RIIT| Dashboard</title>
    <?php include("link.php");?>
  </head>
  <body class="skin-blue sidebar-mini">
  <?php
	require_once 'include/course.php';
    $courseObject = new Course(SERVER_API_KEY);
                                      
	$data = $courseObject->getAllCourse(0);
	
  ?>  
    <div class="wrapper">
      <?php include('header.php');?>
      <?php include('sidemenu.php');?>
       <div class="content-wrapper">
       <section class="content-header">
          <h1>
            Dashboard
            
          </h1>
           </section><!-- right col -->


          <section class ="content">
			   <div id="page-wrapper">
           
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Overall Top 10 students
                        </div>
						<div class="panel-heading">
                          
							<select name="course[]" id="course" class="form-control" onchange="getCourseReport(this.value)">
							  <option value=''>Select Course</option>
							 	<?php for($i=0;$i<count($data);$i++){?>
										   <option value='<?php echo $data[$i]->course_id?>'><?php echo $data[$i]->course_name?></option>
								   <?php }?>
						  </select>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
							Top 10
                            <div class="list-group" id="overAllTopStud">
                                
                            </div>
                        </div>
						<div class="panel-body">
							Bottom 10
                            <div class="list-group" id="overAllBottomStud">
                                
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                  
                </div>
                <!-- /.col-lg-8 -->
               <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Subject-wise Top 10 students
                        </div>
						<div class="panel-heading">
                          <div>
							 <select name="course" id="coursede" onchange="getSubject(this.value)" class="form-control" required>
								  <option value=''>Select Course</option>
									<?php for($i=0;$i<count($data);$i++){?>
											   <option value='<?php echo $data[$i]->course_id?>'><?php echo $data[$i]->course_name?></option>
									   <?php }?>
							  </select>
							</div><br>
							<div id="subjectDiv">
							<select name="subject" id="subject" class="form-control" onchange="getSubReport()" required>
								  <option value=''>Select Subject</option>
							  </select>
							</div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
							Top 10
                            <div class="list-group" id="subAllTopStud">
                                
                            </div>
                        </div>
						<div class="panel-body">
							Bottom 10
                            <div class="list-group" id="subAllBottomStud">
                                
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                  
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        </div>
         
          </section>

          </div><!-- /.row (main row) -->
       <!-- /.content -->
      </div><!-- /.content-wrapper -->
	<script type="text/javascript">
	function getCourseReport(course){
			if(course!=''){
				$.ajax({
						type : "POST",
						url : "api/test/index.php/getCourseReport",
						data : {course:course},
						success : function(response) {
							var arr=response.split("~");
							$("#overAllTopStud").html(arr[0]);
							$("#overAllBottomStud").html(arr[1]);
						}
					});
			}else{
				$("#overAllTopStud").html('');
				$("#overAllBottomStud").html('');
			}
			
		}
		function getSubReport(){
			var course=$('#coursede').val();
			var subject=$('#subject').val();
			if(course!='' && subject!=''){
				$.ajax({
						type : "POST",
						url : "api/test/index.php/getSubWiseReport",
						data : {course:course,subject:subject},
						success : function(response) {
							//console.log(response);
							var arr=response.split("~");
							$("#subAllTopStud").html(arr[0]);
							$("#subAllBottomStud").html(arr[1]);
						}
					});
			}else{
				//$("#overAllTopStud").html('');
				//$("#overAllBottomStud").html('');
			}
			
		}
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
     <div class="control-sidebar-bg"></div>
    <!-- ./wrapper -->
  <?php include("footer.php");?>
  </body>
</html>
