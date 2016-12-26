<?php

  require_once 'include/Config.php';
  require_once 'include/topic.php';
  require_once 'include/course.php';
  require_once 'include/sub.php';
$courseObj = new Course(SERVER_API_KEY);
$subjectObj	 = new sub(SERVER_API_KEY);
$topicObj	 = new Topic(SERVER_API_KEY);


$value	 = $topicObj->getData(TABLE_TOPIC,'',array('id'=>$_GET['id']),'');
//print_r($value);



	$data = $courseObj->getAllCourse(0);
    $subjectdata = $subjectObj->getCourseSub(array('course'=>$value[0]->courseid));



?>


<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" onclick="javascript:window.location.reload()">&times;</button>
   <h4 class="modal-title" style="text-align: center;"> Update Topic</h4>
</div>
<div class="modal-body">
       <div class="row">
               <form role="form" action="api/topic/index.php/UpdateTopic" enctype="multipart/form-data" method="post"  >
                   <div class="box-body">
                 <div class="form-group" style="width:100%; height:8%">
                 <label for="exampleInputEmail1" style="width:30%; float:left; font-size: 14px;" >Course</label>
                      <select name="course" style="width:65%; float:left"  id="course" class="form-control" required>

                            <?php for($i=0;$i<count($data);$i++){?>
                                       <option value='<?php echo $data[$i]->course_id?>' <?php if($value[0]->courseid==$data[$i]->course_id) echo "selected";?>><?php echo $data[$i]->course_name?></option>
                               <?php }?>
                      </select>
                  </div>
<br />
<div style="height:10px"></div>

                   <div class="form-group" style="width:100%; height:8%">
                       <label for="exampleInputEmail1" style="width:30%; float:left; font-size: 14px;">Subject</label>
                       <select name="subject"  style="width:65%; float:left" id="subject" class="form-control" required>

                           <?php for($i=0;$i<count($subjectdata);$i++){?>
                               <option value='<?php echo $subjectdata[$i]->cat_id?>' <?php if($value[0]->subjectid==$subjectdata[$i]->cat_id) echo "selected";?>><?php echo $subjectdata[$i]->cat_name?></option>
                           <?php }?>
                       </select>
                   </div>

<br/>
<div style="height:10px"></div>
                  <div class="form-group" style="width:100%; height:8%">
                     <label for="exampleInputEmail1" style="width:30%; float:left; font-size: 14px;">Topic name</label>
                     <input type="text" maxlength=50 style="width:65%; float:left"  class="form-control" value="<?php echo $value[0]->name; ?>" name="topic_name" id="topic_name" placeholder="Topic name" required>
                  </div>
                       <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">


                       <div style="width:100%">
                         <input type="submit" name="submit" value="Update" class="btn btn-primary">
                       </div>
               </form>
           </div>
           <!-- /.box-body -->
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
<script type="text/javascript">
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
