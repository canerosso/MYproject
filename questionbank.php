<?php  session_start();?>
<style type="text/css">
	.col-md-1 
	{
    margin-bottom: 2%;
    width: 14.333 %!important;
}

    .loading {
        position: fixed;
        z-index: 999;
        height: 2em;
        width: 2em;
        overflow: show;
        margin: auto;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
    }

    /* Transparent Overlay */
    .loading:before {
        content: '';
        display: block;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.3);
    }

    /* :not(:required) hides these rules from IE9 and below */
    .loading:not(:required) {
        /* hide "loading..." text */
        font: 0/0 a;
        color: transparent;
        text-shadow: none;
        background-color: transparent;
        border: 0;
    }

    .loading:not(:required):after {
        content: '';
        display: block;
        font-size: 10px;
        width: 1em;
        height: 1em;
        margin-top: -0.5em;
        -webkit-animation: spinner 1500ms infinite linear;
        -moz-animation: spinner 1500ms infinite linear;
        -ms-animation: spinner 1500ms infinite linear;
        -o-animation: spinner 1500ms infinite linear;
        animation: spinner 1500ms infinite linear;
        border-radius: 0.5em;
        -webkit-box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
        box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) -1.5em 0 0 0, rgba(0, 0, 0, 0.75) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
    }

    /* Animation */

    @-webkit-keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
    @-moz-keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
    @-o-keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
    @keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
</style>
<?php
if(isset($_GET['page']))
	$page=$_GET['page'];
else
	$page=1;
if(isset($_GET['test']))
	$test=$_GET['test'];
else
	$test=0;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>RIIT| Question Bank</title>
<?php include("link.php"); ?>
</head>

  <body class="skin-blue sidebar-mini">
  <?php if(isset($_GET['course'])) { ?>
  <div class="loading">Loading&#8230;</div>
  <?php }?>
<div class="modal fade" id="myModal2" role="dialog">
             <div class="modal-dialog">
               <div class="modal-content">
                 <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                   <h4 class="modal-title"> Add Question(s) To Existing Test</h4>
                 </div>
                 <div class="modal-body" >
                  <div class="row"> 
                     <form role="form" action="api/test/index.php/addQuestionsToTest" enctype="multipart/form-data"  method="post" id="addQuestionsToTest">
                    <div class="box-body">
					<input type="hidden" name="questionids" id="questionids" value="" />
                     <input type="hidden" name="qbcourse" id="qbcourse" value="" />	
                     <input type="hidden" name="qbsubject" id="qbsubject" value="" />	
                     <input type="hidden" name="qbtopic" id="qbtopic" value="" />
						<?php
							require_once 'include/course.php';
							require_once 'include/sub.php';
							$courseObject = new Course(SERVER_API_KEY);
							$data = $courseObject->getAllCourse(0);
							$subObject = new sub(SERVER_API_KEY);
							$subject = $subObject->getAllSubjects(0);
							
							$testdata=$courseObject->getData(TABLE_TEST, '', '', '');

						?>
						<div class="form-group">
                       		<label for="exampleInputEmail1">Select Test</label>
							  <select name="test" id="test" class="form-control" required>
								  <option value=''>Select Test</option>
									<?php for($i=0;$i<count($testdata);$i++){?>
											   <option value='<?php echo $testdata[$i]->test_id?>' testtype='<?php echo $testdata[$i]->testtype?>'><?php echo $testdata[$i]->title ?></option>
									   <?php }?>
							  </select>
                      	</div>
						
			           </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                     <button type="submit" class="btn btn-primary"> Add Question(s)</button>
                    </div>
                   </form>
                  <div class="box-footer">
                    <label id="message"></label>
                  </div>

              </div>  <!--modal body -->
            
            </div> <!--modal-content-->
           </div> <!--modal-dialog-->
          </div> 
          
<div class="modal fade" id="myModal1" role="dialog">
             <div class="modal-dialog">
               <div class="modal-content">
                 <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                   <h4 class="modal-title"> Add Test</h4>
                 </div>
                 <div class="modal-body" >
                  <div class="row"> 
                     <form role="form" action="api/test/index.php/CreateTest" enctype="multipart/form-data"  method="post" id="createtest">
                     <input type="hidden" name="questionids" id="questionids" value="" />
                     <input type="hidden" name="qbcourse" id="qbcourse" value="" />	
                     <input type="hidden" name="qbsubject" id="qbsubject" value="" />	
                     <input type="hidden" name="qbtopic" id="qbtopic" value="" />		
                    <div class="box-body">
						
                      <div class="form-group">
                       <label for="exampleInputEmail1">Test title</label>
                       <input type="text" class="form-control" name="title" id="title" placeholder="Test title" required>
                      </div>
					 
						
						<div class="form-group">
                       		<label for="exampleInputEmail1"> Course</label>
							  <select name="course" id="course" onchange="getSubject2(this.value)" class="form-control" required>
								  <option value='0'>Select Course</option>
									<?php for($i=0;$i<count($data);$i++){?>
											   <option value='<?php echo $data[$i]->course_id?>'><?php echo $data[$i]->course_name?></option>
									   <?php }?>
							  </select>
                      	</div>
						<div class="form-group" id="subjectDiv2">
                       		<label for="exampleInputEmail1">Subject</label>
							  <select name="subject" id="subject" class="form-control" onchange="getTopics2(this.value)" required>
								  <option value=''>Select Subject</option>
							  </select>
                      	</div>

					 <div class="form-group">
						   <label for="exampleInputEmail1">Test Time</label>
						   <input type="number" class="form-control" name="time" id="time" placeholder="Test time in minutes" required>
                      </div>
                        <div class="form-group">
                            <label for="testtype">Are all the questions in this test from same topic</label> &nbsp;
                            <label class="radio-inline"><input type="radio" name="allquestionsfromsametopic" value="YES">Yes</label>
                            <label class="radio-inline"><input type="radio" name="allquestionsfromsametopic" value="NO" checked>No</label>
                        </div>
                        <div class="form-group" id="topicDiv2" style="display: none">
                            <label for="exampleInputEmail1">Topic</label>
                            <select name="topic" id="topic" class="form-control" >
                                <option value=''>Select topic</option>
                            </select>
                        </div>
					 <div class="form-group">
						   <label for="exampleInputEmail1">Is Special test</label>
						 <select required name="isSpecial" class="form-control">
							 <option value=''> Is Special</option>	
							 <option value='1'>Yes</option>	
							 <option value='0'>No</option>	
						 </select>
                      </div>
                        <div class="form-group">
                            <label for="testtype">Test Type</label> &nbsp;
                            <label class="radio-inline"><input type="radio" name="testtype" value="IIT JEE">IIT JEE</label>
                            <label class="radio-inline"><input type="radio" name="testtype" value="NEET" checked>NEET</label>
                        </div>
                        <div class="form-group">
                            <label for="">Do all the questions in this test have same marks</label> &nbsp;
                            <label class="radio-inline"><input type="radio" name="equalmarking" value="YES">Yes</label>
                            <label class="radio-inline"><input type="radio" name="equalmarking" value="NO" checked>No</label> &nbsp;
                            <div class="inline" id="equalmarkspanel" style="display:none;">
                                <input type="number" class="form-control inline" value="" id="equalmarks" name="equalmarks"   placeholder="Enter the marks" />
                            </div>
                        </div>
                        <label class="form-group">
                            <label for="">Does this test have negative marking</label> &nbsp;
                            <label class="radio-inline"><input type="radio" name="negativemarking" value="YES">Yes</label>
                            <label class="radio-inline"><input type="radio" name="negativemarking" value="NO" checked>No</label>
                            <div class="inline" id="negativemarkspanel" style="display:none;">
                                <input type="number" class="form-control inline" value="" style="font-weight:normal;min-width:238px;" id="negativemarks" name="negativemarks"  placeholder="Enter the negative marks"  />
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                     <button type="submit" class="btn btn-primary"> Add</button>
                    </div>
                   </form>
                  <div class="box-footer">
                    <label id="message"></label>
                  </div>

              </div>  <!--modal body -->
            
            </div> <!--modal-content-->
           </div> <!--modal-dialog-->
          </div>  <!--modal fade-->
    <div class="wrapper">

     <?php include('header.php');?>
      <?php include('sidemenu.php');?>
    
      <div class="content-wrapper">
        <section class="content">
          <!--ADD BUTTON AT THE TOP--> 
               
               <!-- Modal1 Add -->
            <a  class="btn btn-primary btn-lg" href="addQuestionToBank.php" style="width:auto;margin-bottom: 1%;" > Add Question<i class="fa fa-graduation-cap"></i></a>
  
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
                   <div >
					   <h4>Question Bank</h4>
					   <hr />
                    <form role="form" action="questionbank.php"  method="GET" id="questionbank">
						<?php
							require_once 'include/course.php';
							require_once 'include/sub.php';
							$courseObject = new Course(SERVER_API_KEY);
							$data = $courseObject->getData(TABLE_COURSE,'',array('isDeleted'=>0),array('course_name'=>'ASC'));
							$subObject = new sub(SERVER_API_KEY);

						?>
						<div class="form-group">
							<div class="col-md-3">
							  <label for="">Select Course</label>
							  <select name="course" id="course" onchange="getSubject(this.value)" class="form-control" required>
								   <option value=''>Select Course</option>
									<?php for($i=0;$i<count($data);$i++){?>
									   <option value='<?php echo $data[$i]->course_id?>' <?php if(isset($_GET['course']) && $_GET['course'] ==$data[$i]->course_id) echo "selected";?>><?php echo $data[$i]->course_name?></option>
									   <?php }?>
							  </select>
					  		</div>
							<div class="col-md-3" id="subjectDiv">
								<label for="">Select Subject</label>
								<select name="subject" id="subject" onchange="getTopics(this.value)" class="form-control" required>
									 <option value=''>Select Subject</option>
                                    <?php
                                        if(isset($_GET['course']))
                                        {
                                           $data=$subObject->getData(TABLE_CAT,'','','');
                                           for($i=0;$i<count($data);$i++)
                                           {
                                            	$courses=@explode(",", $data[$i]->course);
												if(in_array($_GET['course'],$courses))  
                                                {  
                                    ?>
                                        <option value='<?php echo $data[$i]->cat_id?>' <?php if($_GET['subject']==$data[$i]->cat_id) echo "selected";?>><?php echo $data[$i]->cat_name?></option>
                                    <?php } } }?>
								</select>
							</div>
							<div class="col-md-3" id="topicDiv">
								<label for="">Select Topic</label>
								<select name="topic" id="topic" class="form-control" required>
									 <option value='0'>Select Topic</option>
									<?php
										
                                        if(isset($_GET['subject']))
                                        {
                                           require_once 'include/topic.php';
										   $topicobject=new Topic(SERVER_API_KEY);
								           $data=$subObject->getData(TABLE_TOPIC,'',array('isdeleted'=>0,'subjectid'=>$_GET['subject']),'');
                                           for($i=0;$i<count($data);$i++)
                                           {
                                     	?>
                                        <option value='<?php echo $data[$i]->id?>' <?php if($_GET['topic']==$data[$i]->id) echo "selected";?>><?php echo $data[$i]->name?></option>
                                    <?php } } ?>
								</select>
							</div>
							<div class="col-md-3" id="subjectDiv">
								<label for="">&nbsp;</label>
								<button type="submit" class="form-control btn btn-primary" >Load Questions</button>
							</div>
						</div>
                 		<div class="clearfix"></div>

                  </form> 
					   <hr />
					   <div id="table" style="overflow-x: scroll; max-width: 97%;">
						  <table class="table table-bordered " > <!--id="tbl-question-bank"-->



							   <tr><th >Sr. No.</th>
									<th>Select</th>
                                    <th>Test Title</th>
									<th>Course</th>
								    <th>Subject</th>
								    <th>Topic</th>
								    <th >Question</th>
								    <th>Option 1</th>
								    <th>Option 2</th>
								    <th>Option 3</th>
								    <th>Option 4</th>
								    <th>Correct Answer</th>
								    <th>Difficulty Level</th>
								</tr>

							  <tbody>
								  <?php
								   
								   require_once 'include/question.php';
								   $questionObject = new Question(SERVER_API_KEY);
								   
								   $data=array();
								   if(isset($_GET['topic']))
								   {	
								   		$data = $questionObject->getQuestionListByTopic($_GET['course'],$_GET['subject'],$_GET['topic']);
								   
								   
								  $countOfRole = count($data);
								  for($i=0;$i<$countOfRole;$i++)
								  {
								  	 $data2=$questionObject->getQuestionAns(array('question_id'=>$data[$i]->question_id));

								  ?>
								<tr>
                                    <td ><?=$i+1;?></td>
									<td><input name="qid" type='checkbox' serialno="<?=$i+1;?>" value='<?php echo $data[$i]->question_id;?>'  /></td>
                                    <td><?php echo $data[$i]->title;?></td>
									<td><?php echo $data[$i]->course_name;?></td>
									<td><?php echo $data[$i]->cat_name;?></td>
									<td><?php echo $data[$i]->topic_name;?></td>
									<td ><?=$data[$i]->question?>
										<?php if($data[$i]->quesIsFile==1){?>
										<a href="<?php echo URL.'uploads/Questions/'.$data[$i]->questionFile?>" target="_blank">
										<img id="Question image" src="<?php echo URL.'uploads/Questions/'.$data[$i]->questionFile?>" alt="Question image" style="max-width:120px;" class="popup"/></a>
										<?php } ?>
									</td>
									
									<?php $correctanscount=0; $correctanswers=""; for($j=0;$j<count($data2); $j++) { ?>
										<td>
											<?php if($data2[$j]->is_file==1){?>
											<a href="<?php echo URL.'uploads/Questions/'.$data2[$j]->choice?>" target="_blank">
											<img id="Question image" src="<?php echo URL.'uploads/Questions/'.$data2[$j]->choice?>" alt="Question image" style="max-width:120px;" class="popup"/></a>
											<?php }else { echo $data2[$j]->choice;}
                                            if($data2[$j]->is_right==1){ $correctanscount++; $correctanswers.="Option ".($j+1)."<br>"; }?>
										</td>
									<?php } ?>
									<td><?php echo $correctanswers; ?> <input type="hidden" id="correctanscount<?php echo $data[$i]->question_id;?>" value="<?php echo $correctanscount; ?>"/></td>
									<td><?php echo $data[$i]->difficultylevel;?></td>

								  </tr>
								  <?php } } ?>

								</tbody>

							  </table>
                           <style type="text/css">

                               td{white-space:nowrap; word-wrap:break-word; }
                           </style>
				<hr />

                  <!--<div class="box-footer">
                    <label id="message"></label>
                  </div>-->
                  
                  
               </div>
                <br />
                <button id="btn-create-test" type="button" class="btn btn-block btn-primary btn-lg" data-toggle="modal" data-target="#myModal1" style="width:auto;margin-bottom: 1%;margin-right: 1%; float:left;" > Create a new test </button>
                <button id="btn-add-to-existing-test" type="button" class="btn btn-block btn-primary btn-lg" data-toggle="modal" data-target="#myModal2" style="width:auto;margin-bottom: 1%; margin-top: 0%;float:left;" > Add these question to an existing test</button></div><!-- /.box-body -->
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
		$(function() {
			$('#msgdiv').delay(3000).hide(2000);
		});
/*$("#questionbank").find("#topic").change(function () { 
                    
                        if($("#questionbank").find("#course").val()!="" && $("#questionbank").find("#subject").val()!="" && $("#questionbank").find("#topic").val()!="" )
                        {
                        	$("#questionbank").submit();
                             // window.location='questionbank.php?course='+$("#questionbank").find("#course").val()+'&subject='+$("#questionbank").find("#subject").val()+'&topic='+$(this).val();
                        }});*/

		     
		function createQues(){
			window.location = "createQuestion.php";
		}
		$("#tbl-question-bank").DataTable({});

        function getSubject(course){
            $.ajax({
                type : "POST",
                url : "api/sub/index.php/getCourseSub",
                data : {course:course},
                success : function(response) {
                    response = response.replace("<label for=\"exampleInputEmail1\">Subject</label>", "<label for=\"exampleInputEmail1\">Select Subject</label>");
                   // response = response.replace("<option value=\"\">Select Subject</option>", "<option value=\"0\">Show all records</option>");
                    $('#subjectDiv').html(response);
                }
            });
      }
      function getSubject2(course){
            $.ajax({
                type : "POST",
                url : "api/sub/index.php/getCourseSub",
                data : {course:course},
                success : function(response) {
                    response = response.replace("getTopics(this.value)", "getTopics2(this.value)");
                  
                    $('#subjectDiv2').html(response);
                }
            });
      }
       function getTopics2(subjectid){
            $.ajax({
                type : "POST",
                url : "api/topic/index.php/getSubjectTopics",
                data : {subject:subjectid},
                success : function(response) { 
                     $('#topicDiv2').html(response);

                }
            });
        }
        function getTopics(subjectid){
            $.ajax({
                type : "POST",
                url : "api/topic/index.php/getSubjectTopics",
                data : {subject:subjectid},
                success : function(response) {
                    response = response.replace("<label for=\"exampleInputEmail1\">Topic</label>", "<label for=\"exampleInputEmail1\">Select Topic</label>");
                    // response = response.replace("<option value=\"\">Select Topic</option>", "<option value=\"0\">Show all records</option>");
                    $('#topicDiv').html(response);

                   /* $("#questionbank").find("#topic").change(function () { 
                    	
                    	  if($("#questionbank").find("#course").val()!="" && $("#questionbank").find("#subject").val()!="" && $("#questionbank").find("#topic").val()!="" )
                        {
                        	$("#questionbank").submit();
                             // window.location='questionbank.php?course='+$("#questionbank").find("#course").val()+'&subject='+$("#questionbank").find("#subject").val()+'&topic='+$(this).val();
                        }});*/

                }
            });
        }
        
        $("input[name=equalmarking]").change(function(){
                if($("input[name=equalmarking]:checked").val()=="YES")
                {
                    $("#equalmarkspanel").show();
                    $("#equalmarks").attr('required','required');
                }
                else
                {
                    $("#equalmarkspanel").hide();
                    $("#equalmarks").removeAttr('required');
                    $("#equalmarks").val('');
                }
            });

            $("input[name=negativemarking]").change(function(){
                if($("input[name=negativemarking]:checked").val()=="YES")
                {
                    $("#negativemarkspanel").show();
                    $("#negativemarks").attr('required','required');
                }
                else
                {
                    $("#negativemarkspanel").hide();
                    $("#negativemarks").removeAttr('required');
                    $("#negativemarks").val('');
                }
            });

            $("input[name=allquestionsfromsametopic]").change(function(){

                if($("input[name=allquestionsfromsametopic]:checked").val()=="YES")
                {
                    $("#topicDiv2").show();
                    $("#topicDiv2").find("select").attr('required','required');
                }
                else
                {
                    $("#topicDiv2").hide();
                    $("#topicDiv2").find("select").removeAttr('required');
                    $("#topicDiv2").find("select").val('');
                }
            });
            
        $("#btn-create-test").click(function(e){ 
        	var checkedBoxes = getCheckedBoxes("qid");
        	if(checkedBoxes==0)
        	{
        		alert('Please select at least one question.');
	        	e.preventDefault();
	        	return false;
        	}
        	else
        	{
        		var checkboxes = document.getElementsByName('qid');
			    var checkboxesChecked = [];
			  
				for (var i=0; i<checkboxes.length; i++) {
				   
				     if (checkboxes[i].checked) {
				        checkboxesChecked.push(checkboxes[i].value);
				     }
				 }
        		$("#createtest").find("#qbcourse").val($("#questionbank").find("#course").val());
        		$("#createtest").find("#qbsubject").val($("#questionbank").find("#subject").val());
        		$("#createtest").find("#qbtopic").val($("#questionbank").find("#topic").val());
        		$("#createtest").find("#questionids").val(checkboxesChecked.toString());
        	}
        
        });
        
        $("#btn-add-to-existing-test").click(function(e){ 
        	var checkedBoxes = getCheckedBoxes("qid");
        	if(checkedBoxes==0)
        	{
        		alert('Please select at least one question.');
	        	e.preventDefault();
	        	return false;
        	}
        	else
        	{
        		var checkboxes = document.getElementsByName('qid');
			    var checkboxesChecked = [];
			  
				for (var i=0; i<checkboxes.length; i++) {
				   
				     if (checkboxes[i].checked) {
				        checkboxesChecked.push(checkboxes[i].value);
				     }
				 }
        		$("#addQuestionsToTest").find("#qbcourse").val($("#questionbank").find("#course").val());
        		$("#addQuestionsToTest").find("#qbsubject").val($("#questionbank").find("#subject").val());
        		$("#addQuestionsToTest").find("#qbtopic").val($("#questionbank").find("#topic").val());
        		$("#addQuestionsToTest").find("#questionids").val(checkboxesChecked.toString());
        	}
        
        });
       

        $("#createtest").submit(function(e)
        {
            var serialnos = [];
            if($("input[name=testtype]:checked").val()=="IIT JEE")
            {
                var checkboxes = document.getElementsByName('qid');
                for (var i=0; i<checkboxes.length; i++)
                {
                    if (checkboxes[i].checked==true && $("#correctanscount"+checkboxes[i].value).val()>1)
                    {
                        serialnos.push($(checkboxes[i]).attr('serialno'));
                    }
                }
                if(serialnos.length>0)
                {
                    alert('Multi-correct questions cant be added to single correct questions. serial number(s) are '+serialnos.toString()+'.');
                    e.preventDefault();
                    return false;
                }
            }


        });

        $("#addQuestionsToTest").submit(function(e)
        {
           // alert($("#addQuestionsToTest").find("#test option:selected").attr('testtype'));

            var serialnos = [];
            if($("#addQuestionsToTest").find("#test option:selected").attr('testtype')=="IIT JEE")
            {
                var checkboxes = document.getElementsByName('qid');
                for (var i=0; i<checkboxes.length; i++)
                {
                    if (checkboxes[i].checked==true && $("#correctanscount"+checkboxes[i].value).val()>1)
                    {
                        serialnos.push($(checkboxes[i]).attr('serialno'));
                    }
                }
                if(serialnos.length>0)
                {
                    alert('Multi-correct questions cant be added to single correct questions. serial number(s) are '+serialnos.toString()+'.');
                    e.preventDefault();
                    return false;
                }
            }


        });
        
function getCheckedBoxes(chkboxName) 
{
 	 var checkboxes = document.getElementsByName(chkboxName);
	  var checkboxesChecked = [];
	  
	  for (var i=0; i<checkboxes.length; i++) {
	   
	     if (checkboxes[i].checked) {
	        checkboxesChecked.push(checkboxes[i]);
	     }
	  }
	  
	  return checkboxesChecked.length > 0 ? checkboxesChecked : 0;
}

        $(document).ready(function(){ $(".loading").hide(); });

	</script>
   </body>
  </html>    


