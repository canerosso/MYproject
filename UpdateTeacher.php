<?php 
 
  require_once 'include/teacher.php';
  require_once 'include/Config.php';
 if(isset($_GET['page']))
	  $page=$_GET['page'];
  else
	  $page=1;
  $id =$_GET['id'];
  $where['teacher_id']=$id;
  $teacherObj = new Teacher();
  $value=$teacherObj->getTeacher($where);

	require_once 'include/course.php';
    $courseObject = new Course(SERVER_API_KEY);
                                      
	$data = $courseObject->getAllCourse(0);
	

?>  <script type="text/javascript">
		function alpha(e) {
			if (e.which === 32 &&  e.target.selectionStart === 0) {
				return false;
			}
			var k;
			document.all ? k = e.keyCode : k = e.which;

			return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 ); //|| (k >= 48 && k <= 57)
		}
	  	function removespace(e)
		{
			if (e.which === 32 &&  e.target.selectionStart === 0) {
				return false;
			}
			else 
				return true;
		}
	  </script>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">X</button>
  <h1>Update Teacher</h1>
</div>
<div class="modal-body">
  <div class="panel panel-default">

    <div class="panel-body">
       <div class="row"> 
                   <form role="form" action="api/teacher/index.php/updateTeacher" enctype="multipart/form-data" method="post" id="" >
					  	
                      <div class="form-group">
                       <label for="exampleInputEmail1">First Name</label>
                       <input type="text" class="form-control" name="firstName" id="firstName" value="<?php echo $value[0]->first_name; ?>" placeholder="First Name" required>
                      </div>
					 <div class="form-group">
                      	 <label for="exampleInputEmail1">Last Name</label>
                      	 <input type="text" class="form-control" name="lastName" id="lastName" value="<?php echo $value[0]->last_name; ?>" placeholder="Last Name" required>
                      </div>
					  <div class="form-group">
                      	 <label for="exampleInputEmail1">Photo</label>
                      	 <input type="file" name="photo" id="photo" >
                      </div>
						<div class="form-group">
                      	 <label for="exampleInputEmail1">Address</label>
                      	 <textarea class="form-control" name="address" id="address" placeholder="Address" required><?php echo $value[0]->address; ?></textarea>
                      </div>
						<div class="form-group">
                      	 <label for="exampleInputEmail1">Email</label>
                      	 <input type="text" class="form-control" name="email" value="<?php echo $value[0]->email; ?>" id="email" placeholder="Email" required>
                      </div>
						<div class="form-group">
                      	 <label for="exampleInputEmail1">Phone No</label>
                      	 <input type="text" class="form-control" name="phone" value="<?php echo $value[0]->phone; ?>" id="phone" placeholder="Phone" required>
                      
                      </div>
						<?php
							require_once 'include/institute.php';
							require_once 'include/sub.php';
							$insObject = new Institute(SERVER_API_KEY);
							$data = $insObject->getAllInstitutes(0);
							$subObject = new sub(SERVER_API_KEY);
							$subject = $subObject->getAllSubjects(0);
						?>
					<!--	<div class="form-group">
                       		<label for="exampleInputEmail1">Select Institute</label>
							  <select name="institute" id="institute" class="form-control" required>
								  <option value=''>Select Institute</option>
									<?php for($i=0;$i<count($data);$i++){?>
						   <option value='<?php echo $data[$i]->institute_id?>' <?php if($value[0]->institute==$data[$i]->institute_id) echo "selected"?>>
									   <?php echo $data[$i]->institute_name?>
								</option>
									   <?php }?>
							  </select>
                      	</div>-->
						<div class="form-group">
                       		<label for="exampleInputEmail1">Select Subject</label>
							  <select name="subject" id="subject" class="form-control" required>
								  <option value=''>Select Subject</option>
									<?php for($i=0;$i<count($subject);$i++){?>
							   <option value='<?php echo $subject[$i]->cat_id?>' <?php if($value[0]->subject==$subject[$i]->cat_id) echo "selected"?>>
									   <?php echo $subject[$i]->cat_name?></option>
									   <?php }?>
							  </select>
                      	</div>
						
						  <input type="hidden" name="id" value="<?php echo $id; ?>">
						  <input type="hidden" name="page" value="<?php echo $page; ?>">
            			
                    <!-- /.box-body -->
                    <div class="box-footer">
                      <input type="submit" name="submit" value="Update" class="btn btn-primary">
                    </div>
                   </form>
                
               </div>  
    </div>
  </div>
 
</div>  
 <script type="text/javascript">
		function checkDupSub(id){
			var inst=$('#instituteEdit').val();
			if(inst!=''){
				$.ajax({
						type : "POST",
						url : "api/institute/index.php/checkDuplicateEdit",
						data : {inst:inst,id:id},
						success : function(response) {
							if(response==1){
								$('#instituteEdit').addClass('errormsg');
								document.getElementById("instituteEdit").value = "";
								$('#instituteEdit').attr("placeholder", "Institute already exists.");
								return false;
							}
						}
					});
			}
		}
</script>