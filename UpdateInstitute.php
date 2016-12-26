<?php

  require_once 'include/institute.php';
  require_once 'include/Config.php';
 if(isset($_GET['page']))
	  $page=$_GET['page'];
  else
	  $page=1;
  $id =$_GET['id'];
  $where['institute_id']=$id;
  $insObj = new Institute();
  $value=$insObj->getInstitute($where);

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
  <h1>Update Subject</h1>
</div>
<div class="modal-body">
  <div class="panel panel-default">

    <div class="panel-body">
       <div class="row">
                   <form role="form" action="api/institute/index.php/updateInstitute" enctype="multipart/form-data" method="post" id="" >
					   <div class="form-group">
                       <label for="exampleInputEmail1">Select Course</label>
						  <select name="course[]" id="course" class="form-control" onchange="checkDupSub('<?php echo $id; ?>')" multiple required>
							  <option value=''>Select Course</option>
							 	<?php for($i=0;$i<count($data);$i++){?>
							  		<?php $courseArr=explode(',',$value[0]->course); ?>
									   <option value='<?php echo $data[$i]->course_id?>' <?php if(in_array($data[$i]->course_id,$courseArr)) echo "selected";?>>
										   <?php echo $data[$i]->course_name?>
										</option>
								   <?php }?>
						  </select>
                      </div>
                      <div class="form-group">
                       <label for="exampleInputEmail1">Institute Name</label>
                       <input type="text" maxlength=50 class="form-control" id="instituteEdit" name="institute" placeholder="Institute" onblur="checkDupSub('<?php echo $id; ?>')" required onkeypress='return alpha(event);return removespace(event)' value="<?php echo $value[0]->institute_name; ?>">
                      </div>
					   <div class="form-group">
                      	 <label for="exampleInputEmail1">Logo</label>
                      	 <input type="file" name="logo" id="logo" >
                      </div>
						<div class="form-group">
                      	 <label for="exampleInputEmail1">Address</label>
                      	 <textarea class="form-control" name="address" id="address" placeholder="Address" required><?php echo $value[0]->address; ?></textarea>
                      </div>
						<div class="form-group">
                      	 <label for="exampleInputEmail1">Email</label>
                      	 <input type="text" class="form-control" name="email" value="<?php echo $value[0]->email; ?>" id="email" placeholder="Institute" required>
                      </div>
						<div class="form-group">
                      	 <label for="exampleInputEmail1">Phone No</label>
                      	 <input type="text" class="form-control" name="phone" value="<?php echo $value[0]->phone; ?>" id="phone" placeholder="Phone" required>
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
