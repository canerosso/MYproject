<?php

  require_once 'include/student.php';
  require_once 'include/Config.php';
  require_once 'include/Utils.php';
 if(isset($_GET['page']))
	  $page=$_GET['page'];
  else
	  $page=1;
  $id =$_GET['id'];
  $where['id']=$id;
  $studObj	 = new Student();
  $value	 = $studObj->getStudent($where);

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
      <button type="button" class="close" data-dismiss="modal" onclick="javascript:window.location.reload()">&times;</button>
       <h4 class="modal-title">Update Student</h4>
    </div>
<div class="modal-body">

       <div class="row">
                   <form role="form" action="api/student/index.php/updateStudent" enctype="multipart/form-data" method="post" id="" >
					  <div class="form-group" style="width:100%; height:8%">
                       <label for="exampleInputEmail1" style="width:30%; float:left; font-size: 14px;">Select Course</label>
						  <select name="course" id="course" class="form-control" style="width:65%; float:left" required>

							 	<?php for($i=0;$i<count($data);$i++){?>
										   <option value='<?php echo $data[$i]->course_id?>' <?php if($value[0]->course==$data[$i]->course_id) echo "selected";?>><?php echo $data[$i]->course_name?></option>
								   <?php }?>
						  </select>
                      </div>
                      <div class="form-group" style="width:100%; height:8%">
                      	 <label for="exampleInputEmail1" style="width:30%; float:left; font-size: 14px;">Student Id</label>
                      	 <input type="text" style="width:65%; float:left" class="form-control" maxlength=50 value="<?php echo $value[0]->student_id; ?>" name="studentid" id="studentid" onkeypress='return removespace(event)' placeholder="Enter Student Id" required>
                      </div>
                      <div class="form-group" style="width:100%; height:8%">
                      	 <label for="exampleInputEmail1" style="width:30%; float:left; font-size: 14px;">First Name</label>
                      	 <input type="text" style="width:65%; float:left" class="form-control" maxlength=50 value="<?php echo $value[0]->first_name; ?>" name="firstName" id="firstName" onkeypress='return alpha(event);return removespace(event)' placeholder="Enter First Name" required>
                      </div>
						<div class="form-group" style="width:100%; height:8%">
                      	 <label for="exampleInputEmail1" style="width:30%; float:left; font-size: 14px;">Last Name</label>
                      	 <input type="text" style="width:65%; float:left" class="form-control" maxlength=50 value="<?php echo $value[0]->last_name; ?>" name="lastName" id="lastName" onkeypress='return alpha(event);return removespace(event)' placeholder="Enter Last Name" required>
                      </div>
					  <div class="form-group" style="width:100%; height:8%">
                      	 <label for="exampleInputEmail1" style="width:30%; float:left; font-size: 14px;">Photo</label>
                      	 <input type="file" name="photo" style="width:65%; float:left" id="photo">
                      </div>
						<div class="form-group" style="width:100%; height:12%">
                      	 <label for="exampleInputEmail1" style="width:30%; float:left; font-size: 14px;">Address</label>
                      	 <textarea class="form-control" style="width:65%; float:left"  name="address" id="address" onkeypress='return removespace(event)' placeholder="Address" required><?php echo $value[0]->address; ?>	</textarea>
                      </div>
						<div class="form-group" style="width:100%; height:8%">
                      	 <label for="exampleInputEmail1" style="width:30%; float:left; font-size: 14px;">Email</label>
                      	 <input type="email" class="form-control" style="width:65%; float:left"  name="email" value="<?php echo $value[0]->email; ?>" onkeypress='return removespace(event)' id="emailEdit" onblur="checkDupStud(this.value,'<?php echo $id; ?>')" placeholder="Email" required>
                      </div>
						<div class="form-group" style="width:100%; height:8%">
                      	 <label for="exampleInputEmail1" style="width:30%; float:left; font-size: 14px;">Phone No</label>
                      	 <input type="text" class="form-control" style="width:65%; float:left"  name="phone" value="<?php echo $value[0]->phone; ?>" id="phone" onkeypress="return removespace(event);return isNumberKey(event)"  placeholder="Phone" required>
                      </div>

					   <?php $decrypted_password=Utils::decode($value[0]->password);?>
						<!--<div class="form-group">
                      	 <label for="exampleInputEmail1">Student Password</label>
                      	 <input type="password" class="form-control" name="password" id="password" value="<?php echo $decrypted_password;?>" onkeypress='return removespace(event)' placeholder="Password" required>
                      </div>-->
						  <input type="hidden" name="id" value="<?php echo $id; ?>">
						  <input type="hidden" name="page" value="<?php echo $page; ?>">

                    <!-- /.box-body -->
                    <div class="box-footer">
                      <input type="submit" name="submit" value="Update" class="btn btn-primary">
                    </div>
                   </form>


  </div>

</div>
 <script type="text/javascript">
		  $(function() {
			$('#msgdiv').delay(1000).hide(1000);
		});
	   function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
		function checkDupStud(email,id){
			if(email!=''){
				$.ajax({
						type : "POST",
						url : "api/student/index.php/checkDuplicateEdit",
						data : {email:email,id:id},
						success : function(response) {
							if(response==1){
								$('#emailEdit').addClass('errormsg');
								document.getElementById("emailEdit").value = "";
								$('#emailEdit').attr("placeholder", "Email Id already exists.");
								return false;
							}
						}
					});
			}
		}
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
