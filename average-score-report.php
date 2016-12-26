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
    <title>Excellence | Average Score and Average Percentage</title>
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
                    <h3 class="box-title">Average Score and Average Percentage</h3>
                    <hr />
                      <form method="get" action="average-score-report.php">
                      <div class='col-md-3'>
                          <select name="course" id="course" class="form-control" onchange="return getSubject(this.value);" required>
                              <option value="0">Show records for all courses</option>
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
                          <select name="subject" id="subject" class="form-control" required>
                              <option value="0">Show records for all subjects</option>
                              <?php
                              if(isset($_GET['subject']))
                              {
                                  require 'include/sub.php';
                                  $subjectObj = new sub(SERVER_API_KEY);
                                  $result = $subjectObj->getData(TABLE_CAT, '', '', array('cat_name' => 'ASC'));
                                  foreach ($result as $row)
                                  {
                                      
                                      if(in_array($_GET['course'],explode(",",$row->course)))
                                      {
                                          if (isset($_GET['subject']) && $row->cat_id == $_GET['subject'])
                                              echo "<option selected value='" . $row->cat_id . "'>" . $row->cat_name . "</option>";

                                          else
                                              echo "<option value='" . $row->cat_id . "'>" . $row->cat_name . "</option>";
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
                          <button class="btn btn-primary" type='submit'>Show Result</button>
                      </div>
                      </form>
                      <div class="clearfix" ></div>
                      <hr />
                  </div><!-- /.box-header -->
                <div class="box-body">
					
                	  <table class="table table-bordered table-hover " id="tbl-average-score" >
                 
                   <thead>
                       <tr>
	                       <th>Sr. No</th>
	                       <th>Test Title</th>
	                       <th>Test Date</th>
	                       <th>Average Score</th>
	                       <th>Average Pecentage</th>
	                       <th>Analysis</th>
                       </tr>
                    </thead>
                   
                   <tbody>
                      <?php 
                      		
                      			require 'include/test.php';	
                              	$testobj=new Test(SERVER_API_KEY);
                                $course=0; $subject=0; $isspecial='NO';
                                if(isset($_GET['course']) && $_GET['course']!="")
                                {
                                    $course=$_GET['course'];
                                }
                                if(isset($_GET['subject']) && $_GET['subject']!="")
                                {
                                   $subject=$_GET['subject'];
                                }
                                if(isset($_GET['optmajortests']) && $_GET['optmajortests']!="")
                                {
                                    $isspecial=$_GET['optmajortests'];
                                }


					  			$result=$testobj->getAverageScoreAndPecentage($course,$subject,$isspecial);
								$i=1;
								foreach($result as $row)
								{
									echo "<tr><td>$i</td><td>$row->test_title</td><td>$row->test_date</td><td>$row->average_score</td><td>$row->average_percentage %</td>
											<td><a class='btn btn-primary' href='most-incorrect-analysis-report.php?Id=$row->test_id'>Most Incorrect</a>
											    <a class='btn btn-primary' href='most-timetaken-analysis-report.php?Id=$row->test_id'>Most Time Taken</a></td>
										  </tr>";
									$i++;
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
   $('#tbl-average-score').DataTable({});

   function getSubject(course){
       $.ajax({
           type : "POST",
           url : "api/sub/index.php/getCourseSub",
           data : {course:course},
           success : function(response) {
               response=response.replace('<label for="exampleInputEmail1">Subject</label>','');
               response=response.replace('<option value="">Select Subject</option>','<option value="0">Show records for all subjects</option>');
               $('#subjectDiv').html(response);
           }
       });


   }
       
</script>
   </body>
  </html>    

