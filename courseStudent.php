<?php  session_start();?>
<style type="text/css">
	.col-md-1 
	{
    margin-bottom: 2%;
    width: 14.333 %!important;
}
</style>
<?php
if(isset($_GET['page']))
	$page=$_GET['page'];
else
	$page=1;
if(isset($_GET['course']))
	$course=$_GET['course'];
else
	$course=0;
require_once 'include/course.php';
$courseObject = new Course(SERVER_API_KEY);
$data = $courseObject->getAllCourse(0);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Excellence|ADD STUDENT</title>
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
               <!-- Modal1 Add -->
           <div class="modal fade" id="myModal1" role="dialog">
             <div class="modal-dialog">
               <div class="modal-content">
                 <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                   <h4 class="modal-title"> Add student</h4>
                 </div>
               	     <div class="modal-body" >
					  <div class="row"> 
					   <form role="form" action="api/student/index.php/addStudent" enctype="multipart/form-data" method="post" onkeypress="return event.keyCode != 13;">
						<div class="box-body">
							<div class="form-group">
						   <label for="exampleInputEmail1">Select Course</label>
							  <select name="course" id="course" class="form-control" required>
								  <option value=''>Select Course</option>
									<?php for($i=0;$i<count($data);$i++){?>
											   <option value='<?php echo $data[$i]->course_id?>'><?php echo $data[$i]->course_name?></option>
									   <?php }?>
							  </select>
						  </div>
						  <div class="form-group">
							 <label for="exampleInputEmail1">First Name</label>
							 <input type="text" class="form-control" name="firstName" id="firstName" onkeypress='return alpha(event);return removespace(event)' placeholder="First Name" required>
						  </div>
							<div class="form-group">
							 <label for="exampleInputEmail1">Last Name</label>
							 <input type="text" class="form-control" name="lastName" id="lastName" onkeypress='return alpha(event);return removespace(event)' placeholder="Last Name" required>
						  </div>
						  <div class="form-group">
							 <label for="exampleInputEmail1">Photo</label>
							 <input type="file" name="photo" id="photo" >
						  </div>
							<div class="form-group">
							 <label for="exampleInputEmail1">Address</label>
							 <textarea class="form-control" name="address" id="address" onkeypress='return removespace(event)' placeholder="Address" required></textarea>
						  </div>
							<div class="form-group">
							 <label for="exampleInputEmail1">Email</label>
							 <input type="email" class="form-control" name="email" onkeypress='return removespace(event)' id="email" onblur="checkDupStud(this.value)" placeholder="Email" required>
						  </div>
							<div class="form-group">
							 <label for="exampleInputEmail1">Phone No</label>
							 <input type="text" class="form-control" name="phone" id="phone" onkeypress="return removespace(event);return isNumberKey(event)"  placeholder="Phone" required>
						  </div>
							<div class="form-group">
							 <label for="exampleInputEmail1">Attendance per month</label>
							 <input type="text" class="form-control" name="attendance" id="attendance" onkeypress='return removespace(event)' placeholder="Attendance" required>
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
              </div>  <!--modal body -->
            
            </div> <!--modal-content-->
           </div> <!--modal-dialog-->
          </div>  <!--modal fade--> 
  
            <div class="row">
              <div class="col-xs-12">
                <div class="box">
                  
                <div class="box-body">
					<?php if(isset($_SESSION['type'])){
							if($_SESSION['type']=='success'){?>
								<div class="alert alert-success" id="msgdiv">
									<strong><?php //echo $type;?></strong> <?php echo $_SESSION['msg'];?>
								</div>
						<?php }else{?>
						<div class="alert alert-danger alert-dismissable" id="msgdiv">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<strong></strong> <?php echo $_SESSION['msg'];?>
						</div>
					<?php }}?>
					<?php unset($_SESSION['type']);
						  unset($_SESSION['msg']);?>
                   	<div class="form-group">
						<form role="form" action="api/student/index.php/getCourseStudent"  method="POST" id="getStudentform">
                       		<label for="exampleInputEmail1">Select Test</label>
							  <select name="course" id="course" class="form-control"  onchange="submitForm()" required>
							  <option value='0'>Select Course</option>
							 	<?php for($i=0;$i<count($data);$i++){?>
										   <option value='<?php echo $data[$i]->course_id?>'  <?php if($course==$data[$i]->course_id) echo "selected";?>><?php echo $data[$i]->course_name?></option>
								   <?php }?>
						  </select>
							<input type="hidden" name="page" value="<?php echo $page;?>"/>
						</form>
                      	</div>
                  <div class="box-footer">
                    <label id="message"></label>
                  </div>
               </div>   
               
				   <div id="table">
						  <table class="table table-bordered table-hover " >

						  <thead>
							   <tr>
							   <th>Student Id</th>
							   <th>First Name</th>
							   <th>Email</th>
							   <th>Phone</th>
							   <th>Course</th>
							   <th>Password</th>
							   <th>Action </th>


							  </tr>
							</thead>
							   <tbody>
                      <?php
                       
                       require_once 'include/student.php';
					   $studObject = new Student(SERVER_API_KEY);

					   $data = $studObject->getCourseWiseStud($course,$page);
						$countOfRole = count($data);
					   $count = $studObject->GetCoursewiseCount($course);
						if($countOfRole!=0){
						  for($i=0;$i<$countOfRole;$i++)
						  { ?>
								<tr>
								<td><?=$data[$i]->student_id?></td>
									 <td><?=$data[$i]->first_name?></td>
									 <td><?=$data[$i]->email?></td>
									 <td><?=$data[$i]->phone?></td>
									 <td><?=$data[$i]->course_name?></td>
									 <?php require_once 'include/Utils.php';?>
									 <td><?php echo Utils::decode($data[$i]->password);?></td>
									 <td>
										  <div class='col-md-3'>
											 <a href="UpdateStudent.php?id=<?php echo "".$data[$i]->student_id;  ?>&page=<?php echo $page?>" data-toggle='modal' data-target='#theModal<?php echo "".$data[$i]->student_id;  ?>' type='button' class='btn btn-block btn-warning'> Edit</a>
											 <div class="modal fade text-center" id="theModal<?php echo "".$data[$i]->student_id;  ?>">
											 <div class="modal-dialog">
													 <div class="modal-content">
												</div>
											</div>
										  </div></div>
								  <?php if ($data[$i]->isEnabled == 1) { ?>
										<div class="col-md-3">
											<a onclick=" return confirm(' Are You Sure' )" class="btn btn-primary" href="api/student/index.php/updateStudStatus/<?php echo "".$data[$i]->student_id;  ?>/0/<?=$page?>/<?=$course?>/2">
											Deactivate</a>
										</div>
								  <?php }else{ ?>
										<div class="col-md-3">
											<a onclick=" return confirm(' Are You Sure' )"  style="width:78px"
											class="btn btn-info" href="api/student/index.php/updateStudStatus/<?php echo "".$data[$i]->student_id; ?>/1/<?=$page?>/<?=$course?>/2">
											 Activate </a>
										</div>
								<?php } ?>
										<div class="col-md-3">
											<a onclick=" return confirm(' Are You Sure' )" class="btn btn-danger" href="api/student/index.php/deleteStudent/<?php echo "".$data[$i]->student_id;  ?>/<?=$page?>/<?=$course?>/2">
											 Delete</a>
										</div>
									</td>

								  </tr>
						  <?php } 
						}else{ ?>
								   <tr>
									   <td colspan="7" align="center">No Record found. </td>
								   </tr>
						<?php }?>
                    <tr>
                    
                    </tr>
                    </tbody>

							  </table>
		  <ul class="pagination">
            <?php
 
             $count;
             $cnt=$count/10;
            $RoundPage=ceil($cnt);
             if($RoundPage >1)
             {
              $EndRoundpage=$RoundPage;
             }
             else
             {
                $EndRoundpage=$RoundPage;
             }

         $startPage=$page;
         $totalPage=$RoundPage;
         $endPage = $EndRoundpage;
        if($totalPage >3)
        {
        $endPage1=3;
        }
        else
        {
            $endPage1=$totalPage;
        }
        $endPage = ($totalPage < $endPage) ? $totalPage : $endPage;
        $diff = $startPage - $endPage + 1;
        $startPage -= ($startPage - $diff > 0) ? $diff : 0;
        $startPage1= $startPage;
        $startPage=1;
        $diff = $startPage - $endPage1 + 1;
        $startPage -= ($startPage - $diff > 0) ? $diff : 0;
           $prev ="";
           if($page ==1)
           {
              $disabledprev="disabled";
              $prev='#';
           }
           else
           {
               $disabledprev="";
               $prev=$page-1;

           }

        // if ($startPage > 1)
            echo " </ul>
                     <div class='row'>
                      <div class='col-sm-12'>
                      <div class='dataTables_paginate paging_simple_numbers' id='example03_paginate'>
                      <ul class='pagination'>
                      <li class='paginate_button previous ". $disabledprev."' id='example03_previous'>
                      <a href='".URL."courseStudent.php?page=".$prev."&course=".$course."' aria-controls='example03' data-dt-idx='0' tabindex='0'>Previous</a>
                      </li>";
        for($i=$startPage; $i<=$endPage1; $i++) 
        {
            if($page==$i)
            {
              $actp='paginate_button active';
            }
            else
            {
              $actp='';
            }
           //echo "+++".$actp;
         echo "<li class='page-item ".$actp."'><a class='page-link' href='".URL."courseStudent.php?page=".$i."&course=".$course."'> {$i}</a></li> ";
        }

        if($endPage1==3) echo " <li class='page-item'><a class='page-link' href='".URL."courseStudent.php?page=".$i."&course=".$course."'>...</a></li> ";
        if($endPage1 < $startPage1 )
        {
        for($i=$startPage1; $i<=$endPage; $i++)
        { 
          if($page==$i)
            {
              $actp='paginate_button active';
            }
            else
            {
              $actp='';
            }
           //echo "+++".$actp;
         echo "<li class='page-item ".$actp."'><a class='page-link' href='".URL."courseStudent.php?page=".$i."&course=".$course."'> {$i}</a></li> ";
        //  echo " <li  class='page-link' ><a class='page-link' href='".URL."role.php?page=".$i."'>{$i}</a></li> ";
        }
        }
        if ($endPage+1 == $totalPage)
           $i= $i-1;
             $nxt =$page+1;
           if($nxt==$totalPage+1)
           {
              $disabled="disabled";
              $nxt="";
           }
           else
           {
               $disabled="";
              
           }
         echo "<li class='paginate_button next  ". $disabled."' id='example03_next'>
                      <a   href='".URL."courseStudent.php?page=".$nxt."&course=".$course."' aria-controls='example03' data-dt-idx='2' tabindex='0'>Next</a>
                      </li>
                      </ul>
                      </div>
                      </div>
                      </div>";
        ?>

  </ul>
					   </div>
					
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->

        </section>
      </div>
     </div> 
   <script type="text/javascript">
	   $(function() {
			$('#msgdiv').delay(1000).hide(1000); 
		});
 	function submitForm() {
		 document.getElementById("getStudentform").submit();
	}
</script>
      <div class="control-sidebar-bg"></div>
 <?php include("footer.php");?>
   
     <!-- Invite Super Administr -->
  
   </body>
  </html>    

