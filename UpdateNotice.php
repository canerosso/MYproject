<?php

  require_once 'include/notice.php';
  require_once 'include/Config.php';
 if(isset($_GET['page']))
	  $page=$_GET['page'];
  else
	  $page=1;
  $id =$_GET['id'];
  $where['notice_id']=$id;
  $notiObj = new Notice();
  $value=$notiObj->getNotice($where);

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
  <h1>Update Notice</h1>
</div>
<div class="modal-body">
  <div class="panel panel-default">

    <div class="panel-body">
       <div class="row">
		          <form role="form" action="api/notice/index.php/updateNotice" enctype="multipart/form-data"  method="post" id="" >
					   <div class="form-group">
                       <label for="exampleInputEmail1">Select Course</label>
						<!--  <select name="course[]" id="course" class="form-control" onchange="checkDupSub('<?php echo $id; ?>')" multiple required>
							  <option value='0' <?php if($value[0]->course=='0') echo "selected";?>>All</option>
							 	<?php for($i=0;$i<count($data);$i++){?>
							  		<?php $courseArr=explode(',',$value[0]->course); ?>
									   <option value='<?php echo $data[$i]->course_id?>' <?php if(in_array($data[$i]->course_id,$courseArr)) echo "selected";?>>
										   <?php echo $data[$i]->course_name?>
										</option>
								   <?php }?>
						  </select>-->
						   <select name="course" id="course" class="form-control" required>
							  <option value='0' <?php if($value[0]->course=='0') echo "selected";?>>All</option>
							 	<?php for($i=0;$i<count($data);$i++){?>
							  		<?php// $courseArr=explode(',',$value[0]->course); ?>
									   <option value='<?php echo $data[$i]->course_id?>' <?php if($data[$i]->course_id==$value[0]->course) echo "selected";?>>
										   <?php echo $data[$i]->course_name?>
										</option>
								   <?php }?>
						  </select>
                      </div>
                      <div class="form-group">
                       <label for="exampleInputEmail1">Title</label>
                       <input type="text" class="form-control" id="title" name="title" placeholder="Subject" required onkeypress='return alpha(event);return removespace(event)' value="<?php echo $value[0]->title; ?>">
                      </div>
					  <div class="form-group">

                      	 <label for="exampleInputEmail1">Notice</label>
						  <textarea name="notice" class="form-control"><?php echo $value[0]->notice; ?></textarea>
                      </div>

						  <input type="hidden" name="id" value="<?php echo $id; ?>">
						  <input type="hidden" name="page" value="<?php echo $page; ?>">
					      <input type="hidden" name="oldfile" value="<?php echo $value[0]->syllabus; ?>">

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
			var cat=$('#cat_nameEdit').val();
			if(cat!=''){
				$.ajax({
						type : "POST",
						url : "api/sub/index.php/checkDuplicateEdit",
						data : {cat:cat,id:id},
						success : function(response) {
							if(response==1){
								$('#cat_nameEdit').addClass('errormsg');
								document.getElementById("cat_nameEdit").value = "";
								$('#cat_nameEdit').attr("placeholder", "Subject already exists.");
								return false;
							}
						}
					});
			}
		}
	   function deleteFile(subId,fileId){
	   		var r = confirm("Do you really want to delete ?");
		   if (r == true) {
		   		$.ajax({
						type : "POST",
						url : "api/sub/index.php/deletePDF",
						data : {pdfId:fileId,subId:subId},
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
