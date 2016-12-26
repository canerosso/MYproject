<?php

  require_once 'include/test.php';
  require_once 'include/Config.php';
  require_once 'include/topic.php';
  $topicObject = new Topic(SERVER_API_KEY);

 if(isset($_GET['page']))
	  $page=$_GET['page'];
  else
	  $page=1;
  $id =$_GET['id'];
  $where['test_id']=$id;
  $testObj  = new Test();
  $value	= $testObj->getTest($where);


	$topicdata=$topicObject->getData(TABLE_TOPIC,'', array('subjectid'=>$value[0]->subject),'');



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
       <h4 class="modal-title">Update Test</h4>
    </div>

<div class="modal-body">

       <div class="row">
                   <form role="form" action="api/test/index.php/updateTest" enctype="multipart/form-data" method="post" id="updatetest" >

                      <div class="form-group">
                       <label for="exampleInputEmail1" style="width:30%; float:left; font-size: 14px;">Test title</label>
                       <input type="text" class="form-control" style="width:65%; float:left" name="title" id="title" value="<?php echo $value[0]->title; ?>" placeholder="Test title" required>
                      </div>

						<?php
							require_once 'include/course.php';

							require_once 'include/sub.php';
							$courseObject = new Course(SERVER_API_KEY);

							$data = $courseObject->getAllCourse(0);

						?>

						<div class="form-group" style="width:100%; height:8%">
                       		<label for="exampleInputEmail1" style="width:30%; float:left; font-size: 14px;">Course</label>
							  <select name="course" style="width:65%; float:left" id="course"  onchange="getSubject(this.value)"  class="form-control" required>

									<?php for($i=0;$i<count($data);$i++){?>
							   <option value='<?php echo $data[$i]->course_id?>' <?php if($value[0]->course==$data[$i]->course_id) echo "selected"?>><?php echo $data[$i]->course_name?></option>
									   <?php }?>
							  </select>
                      	</div>
					   <?php
				       $courseArr['course']=$value[0]->course;
					   $subObject = new sub(SERVER_API_KEY);
					  $subject=$subObject->getCourseSub($courseArr);
						 ?>
						<div class="form-group" id="subjectDivEdit" style="width:100%; height:8%">
                       		<label for="exampleInputEmail1" style="width:30%; float:left; font-size: 14px;">Subject</label>
							  <select name="subject" id="subject" class="form-control" onchange="getTopics(this.value)" required>

									<?php for($i=0;$i<count($subject);$i++){?>
							   <option value='<?php echo $subject[$i]->cat_id?>' <?php if($value[0]->subject==$subject[$i]->cat_id) echo "selected"?>>
									   <?php echo $subject[$i]->cat_name?></option>
									   <?php }?>
							  </select>
                      	</div>

						<div class="form-group" style="width:100%; height:8%">
						   <label for="exampleInputEmail1" style="width:30%; float:left; font-size: 14px;">Test Time</label>
						   <input type="text" class="form-control" name="time" id="time" placeholder="Test time in minutes" value="<?php echo $value[0]->test_time; ?>" required>
                      </div>
					   <div class="form-group" style="width:100%; height:8%">
						   <label for="testtype" style="width:30%; float:left; font-size: 14px;">Are all the questions in this test from same topic</label> &nbsp;
						   <label class="radio-inline"><input type="radio" name="allquestionsfromsametopic" <?php if($value[0]->allquestionsfromsametopic=="YES") { echo "checked"; } ?> value="YES">Yes</label>
						   <label class="radio-inline"><input type="radio" name="allquestionsfromsametopic" <?php if($value[0]->allquestionsfromsametopic=="NO") { echo "checked"; } ?> value="NO" >No</label>
					   </div>
					   <div class="form-group" id="topicDiv" style="width:100%; height:8%; display :<?php if($value[0]->allquestionsfromsametopic=="YES") { echo "block"; } else { echo "none"; } ?>">
						   <label for="exampleInputEmail1" style="width:30%; float:left; font-size: 14px;">Topic </label>
						   <select name="topic" id="topic" class="form-control" <?php if($value[0]->allquestionsfromsametopic=="YES") { echo "required"; } ?>>
							   <option value=''>Select topic</option>
							   <?php for($i=0;$i<count($topicdata);$i++){?>
								   <option value='<?php echo $topicdata[$i]->id?>' <?php if($value[0]->topicid==$topicdata[$i]->id) echo "selected"?>>
									   <?php echo $topicdata[$i]->name?></option>
							   <?php }?>
						   </select>
					   </div>
					   <div class="form-group" style="width:100%; height:8%">
						   <label for="exampleInputEmail1" style="width:30%; float:left; font-size: 14px;">Is Special test</label>
						 <select required name="isSpecial" class="form-control">
							 <option value=''> Is Special</option>
							 <option value='1' <?php if($value[0]->isSpecial==1) echo "selected";?>>Yes</option>
							 <option value='0' <?php if($value[0]->isSpecial==0) echo "selected";?>>No</option>
						 </select>
                      </div>

					   <div class="form-group" style="width:100%; height:8%">
						   <label for="testtype" style="width:30%; float:left; font-size: 14px;">Test Type</label> &nbsp;
						   <label class="radio-inline"><input type="radio" name="testtype" value="IIT JEE"  <?php if($value[0]->testtype=="IIT JEE") { echo "checked"; } ?> >IIT JEE</label>
						   <label class="radio-inline"><input type="radio" name="testtype" value="NEET" <?php if($value[0]->testtype=="NEET") { echo "checked"; } ?> >NEET</label>
					   </div>
					   <div class="form-group" style="width:100%; height:8%">
						   <label for="" style="width:30%; float:left; font-size: 14px;">Do all the questions in this test have same marks</label> &nbsp;
						   <label class="radio-inline"><input type="radio" name="equalmarking" value="YES" <?php if($value[0]->allquestioncarriesequalmarks=="YES") { echo "checked"; }?> >Yes</label>
						   <label class="radio-inline"><input type="radio" name="equalmarking" value="NO" <?php if($value[0]->allquestioncarriesequalmarks=="NO") { echo "checked"; }?> >No</label> &nbsp;
						   <div class="inline" id="equalmarkspanel" style="display:<?php if($value[0]->allquestioncarriesequalmarks=="YES") { echo "block"; } else { echo "none";} ?>;;">
							   <input type="number" class="form-control inline"  id="equalmarks" name="equalmarks"   placeholder="Enter the marks" value="<?php echo $value[0]->positivemarks; ?>" />
						   </div>
					   </div>
					   <div class="form-group" style="width:100%; height:8%">
						   <label for="" style="width:30%; float:left; font-size: 14px;">Does this test have negative marking</label> &nbsp;
						   <label class="radio-inline"><input type="radio" name="negativemarking" value="YES" <?php if($value[0]->negativemarking=="YES") { echo "checked"; } ?> >Yes</label>
						   <label class="radio-inline"><input type="radio" name="negativemarking" value="NO" <?php if($value[0]->negativemarking=="NO") { echo "checked"; } ?>  >No</label>
						   <div class="inline" id="negativemarkspanel" style="display:<?php if($value[0]->negativemarking=="YES") { echo "block"; } else { echo "none";} ?>;">
							   <input type="number" class="form-control inline" style="font-weight:normal;min-width:238px;" id="negativemarks" name="negativemarks"  placeholder="Enter the negative marks"  value="<?php echo $value[0]->negativemarks; ?>" />
						   </div>
	   				   </div>
						  <input type="hidden" name="id" value="<?php echo $id; ?>">

                    <!-- /.box-body -->
                    <div>
                      <input type="submit" name="submit" value="Update" class="btn btn-primary">
                    </div>
                   </form>
                	</div>
               </div>


</div>
 <script type="text/javascript">
	 function getSubject(course){
	   		$.ajax({
						type : "POST",
						url : "api/sub/index.php/getCourseSub",
						data : {course:course},
						success : function(response) {
							$('#subjectDivEdit').html(response);
						}
					});
	   }

	 function getTopics(subjectid){
		 $.ajax({
			 type : "POST",
			 url : "api/topic/index.php/getSubjectTopics",
			 data : {subject:subjectid},
			 success : function(response) {
				 $("#updatetest").find('#topicDiv').html(response);
			 }
		 });}


	 $("#updatetest").find("input[name=equalmarking]").change(function(){
		 if($(this).val()=="YES")
		 {
			 $("#updatetest").find("#equalmarkspanel").show();
			 $("#updatetest").find("#equalmarks").attr('required','required');
		 }
		 else
		 {
			 $("#updatetest").find("#equalmarkspanel").hide();
			 $("#updatetest").find("#equalmarks").removeAttr('required');
			 $("#updatetest").find("#equalmarks").val('');
		 }
	 });

	 $("#updatetest").find("input[name=negativemarking]").change(function(){
		 if($(this).val()=="YES")
		 {
			 $("#updatetest").find("#negativemarkspanel").show();
			 $("#updatetest").find("#negativemarks").attr('required','required');
		 }
		 else
		 {
			 $("#updatetest").find("#negativemarkspanel").hide();
			 $("#updatetest").find("#negativemarks").removeAttr('required');
			 $("#updatetest").find("#negativemarks").val('');
		 }
	 });

	 $("#updatetest").find("input[name=allquestionsfromsametopic]").change(function(){

		 if($(this).val()=="YES")
		 {
			 $("#updatetest").find("#topicDiv").show();
			 $("#updatetest").find("#topicDiv").find("select").attr('required','required');
		 }
		 else
		 {
			 $("#updatetest").find("#topicDiv").hide();
			 $("#updatetest").find("#topicDiv").find("select").removeAttr('required');
			 $("#updatetest").find("#topicDiv").find("select").val('');
		 }
	 });
</script>
