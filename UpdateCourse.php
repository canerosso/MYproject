<?php

  require_once 'include/course.php';
  require_once 'include/Config.php';
 if(isset($_GET['page']))
	  $page=$_GET['page'];
  else
	  $page=1;
  $id =$_GET['id'];
  $where['course_id']=$id;
  $course = new Course();
  $value=$course->getCourse($where);

require_once 'include/field.php';
    $fieldObject = new Field(SERVER_API_KEY);

$data = $fieldObject->getAllField(0);


//print_r($value);die;
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
       <h4 class="modal-title">Update Course</h4>
    </div><div class="modal-body">

       <div class="row">
                   <form role="form" action="api/course/index.php/updateCourse" method="post" id="courseedit" >
					     <div class="form-group" style="width:100%; height:8%">
                       <label for="exampleInputEmail1" style="width:30%; float:left; font-size: 14px;">Select Institute</label>
						  <select name="field"  style="width:65%; float:left"  id="fieldEdit" class="form-control" required onchange="checkDupCourse('<?php echo $id; ?>')">

							 	<?php for($i=0;$i<count($data);$i++){?>
										   <option value='<?php echo $data[$i]->field_id?>' <?php if($value[0]->field== $data[$i]->field_id) echo "selected"?>><?php echo $data[$i]->field_name?></option>
								   <?php }?>
						  </select>
                      </div>
                      <div class="form-group" style="width:100%; height:8%">
                       <label for="exampleInputEmail1" style="width:30%; float:left; font-size: 14px;">Course Name</label>
                       <input type="text" style="width:65%; float:left" class="form-control" id="courseEdit" name="course" placeholder="Course" onblur="checkDupCourse('<?php echo $id; ?>')" required onkeypress='return alpha(event);return removespace(event)' value="<?php echo $value[0]->course_name; ?>">
                      </div>
						  <input type="hidden" name="id" value="<?php echo $id; ?>">
						  <input type="hidden" name="page" value="<?php echo $page; ?>">

                    <!-- /.box-body -->
                    <div>
                      <input type="submit" name="submit" value="Update" class="btn btn-primary">
                    </div>
                   </form>

               </div>


</div>
<script type="text/javascript">
		function checkDupCourse(id){
			var field=$('#fieldEdit').val();
			var course=$('#courseEdit').val();
			$.ajax({
				type : "POST",
				url : "api/course/index.php/checkDuplicateEdit",
				data : {field:field,course:course,id:id},
				success : function(response) {

					if(response==1){
						$('#courseEdit').addClass('errormsg');
					 	document.getElementById("courseEdit").value = "";
						$('#courseEdit').attr("placeholder", "Course already exists.");
						return false;
					}
				}
			});

		}
</script>
