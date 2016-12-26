<?php

  require_once 'include/syllabus.php';
  require_once 'include/Config.php';
 if(isset($_GET['page']))
	  $page=$_GET['page'];
  else
	  $page=1;

  $id =$_GET['id'];
  $where['syllabus_id']=$id;
  $sullabusObj = new Syllabus();

  $value=$sullabusObj->getSyllabus($where);

  $valueData=$sullabusObj->getSyllabusData($where);

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
       <h4 class="modal-title">Update Subject</h4>
    </div>
    <div class="modal-body">

       <div class="row">
		          <form role="form" action="api/syllabus/index.php/updateSyllabus" enctype="multipart/form-data"  method="post" id="" >
					   <div class="form-group" style="width:100%; height:8%">
                       <label for="exampleInputEmail1" style="width:30%; float:left; font-size: 14px;">Select Course</label>
						  <select name="course" style="width:65%; float:left" id="course" class="form-control" onchange="checkDupSub('<?php echo $id; ?>')" required>

							 	<?php for($i=0;$i<count($data);$i++){?>
							  		<?php $courseArr=explode(',',$value[0]->course); ?>
									   <option value='<?php echo $data[$i]->course_id?>' <?php if(in_array($data[$i]->course_id,$courseArr)) echo "selected";?>>
										   <?php echo $data[$i]->course_name?>
										</option>
								   <?php }?>
						  </select>
                      </div>
                      <div class="form-group" style="width:100%; height:8%">
                       <label for="exampleInputEmail1" style="width:30%; float:left; font-size: 14px;">Syllabus Title</label>
                       <input type="text" style="width:65%; float:left" class="form-control" id="title" name="title" placeholder="Title" required onkeypress='return alpha(event);return removespace(event)' value="<?php echo $value[0]->title; ?>">
                      </div>
					  <div class="form-group" style="width:100%; height:8%">

                      	 <label for="exampleInputEmail1" style="width:30%; float:left; font-size: 14px;">File</label>
                      	 <input type="file" name="file[]" id="file" accept=".pdf" multiple>
                      </div>
					   <div class="form-group" id="div_data" style="width:100%; height:8%">
						   <table id="docs" style="width: 100%;">
							<?php for($j=0;$j<count($valueData);$j++){?>
                <tr style="width: 100%;">
                  <td style="width: 30%;">   </td>
                <td>
								   	<?php echo $valueData[$j]->file_name;?> <input type="button" style="margin-left: 4%;" id="tr_<?php echo $j+1?>" value="x" onclick="deleteFile(<?php echo $id;?>,<?php echo $valueData[$j]->id;?>)"/>
								   </td>
							   </tr>
							<?php }?>
						   </table>
                      </div>
						  <input type="hidden" name="id" value="<?php echo $id; ?>">
						  <input type="hidden" name="page" value="<?php echo $page; ?>">
					      <input type="hidden" name="oldfile" value="<?php echo $value[0]->syllabus; ?>">

                    <!-- /.box-body -->
                    <div>
                      <input type="submit" name="submit" value="Update" class="btn btn-primary">
                    </div>
                   </form>

               </div>


</div>
 <script type="text/javascript">

	   function deleteFile(syllId,fileId){
	   		var r = confirm("Do you really want to delete ?");
		   if (r == true) {
			   $.ajax({
						type : "POST",
						url : "api/syllabus/index.php/deletePDF",
						data : {fileId:fileId,syllId:syllId},
						success : function(response) {
						//	alert(response);
							$('#div_data').html(response);
						}
					});
		   	}else{
		   		return false;
		   }
	   }
</script>
