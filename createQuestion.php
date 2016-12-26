<?php  session_start();?>
<style type="text/css">
	.col-md-1 
	{
    margin-bottom: 2%;
    width: 14.333 %!important;
}
.form-control-big{
	display: block;
	width: 70%;
	height: 34px;
	padding: 6px 12px;
	font-size: 14px;
	line-height: 1.42857;
	color: #555;
	background-color: #FFF;
	background-image: none;
	border: 1px solid #CCC;
	border-radius: 4px;
	box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.075) inset;
	transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
}
.form-control-small{
	display: block;
	width: 30%;
	height: 34px;
	padding: 6px 12px;
	font-size: 14px;
	line-height: 1.42857;
	color: #555;
	background-color: #FFF;
	background-image: none;
	border: 1px solid #CCC;
	border-radius: 4px;
	box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.075) inset;
	transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
}
	#questionmarkpanel {display: none;}
</style>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Excellence|ADD TEST</title>
<?php include("link.php"); ?>
</head>
  <body class="skin-blue sidebar-mini">

    <div class="wrapper">

     <?php include('header.php');?>
      <?php include('sidemenu.php');?>
    
      <div class="content-wrapper">
        <section class="content">
          
           <div class="row">
              <div class="col-xs-10">
                <div class="box">
                  
                <div class="box-body">
                   <div class="">
                   <form role="form" action="api/question/index.php/addQuestion" enctype="multipart/form-data"  method="post" id="questionForm">
                    <div class="box-body">
								 
						<?php
							require_once 'include/test.php';
							require_once 'include/sub.php';
							$testObject = new Test(SERVER_API_KEY);
							$data = $testObject->getAlltests(0);
							$subObject = new sub(SERVER_API_KEY);
							$subject = $subObject->getAllSubjects(0);
						?>
						<div class="form-group">
                       		<label for="exampleInputEmail1">Select Test</label>
							  <select name="test" id="test"  class="form-control-big" required>
								  <option value=''>Select Test</option>
									<?php for($i=0;$i<count($data);$i++){?>
											   <option value='<?php echo $data[$i]->test_id?>' equalmarks='<?php echo $data[$i]->allquestioncarriesequalmarks?>' sametopic='<?php echo $data[$i]->allquestionsfromsametopic?>'  subject='<?php echo $data[$i]->subject?>'  testtype='<?php echo $data[$i]->testtype?>'  ><?php echo $data[$i]->title?></option>
									   <?php }?>
							  </select>
                      	</div>
						<?php
						require_once 'include/course.php';
						require_once 'include/sub.php';
						$courseObject = new Course(SERVER_API_KEY);
						$data = $courseObject->getAllCourse(0);
						$subObject = new sub(SERVER_API_KEY);
						$subject = $subObject->getAllSubjects(0);

						?>
						<div id="capturetopicpanel" style="display:none">
                            <div class="form-group" id="topicDiv" style="">
                                <label for="exampleInputEmail1">Topic</label>
                                <select name="topic" id="topic" class="form-control-big" >
                                    <option value=''>Select Topic</option>
                                </select>
                            </div>
                        </div>
						<div id="questionDiv1">
							<div class="form-group">
								<label for="exampleInputEmail1">Question</label>
								<input type="text" class="form-control-big" id="question" name="question"/>
								<input type="file" id="ques_file" name="ques_file" onchange="checkPhoto(this.id)" accept=".png"/>
								<div> (max height 50px and width between 50-500 )</div>
								
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Ans 1</label>
								<input type="text" class="form-control-big" id="ans1" name="ans1"/>
								<input type="file" id="fileans1" name="fileans1" onchange="checkPhoto(this.id)" accept=".png"/>
								<div> (max height 50px and width between 50-500 )</div>
								 <input type="checkbox" name="correct_1" id="correct_1" value="1"> isCorrect.			 
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Ans 2</label>
								<input type="text" class="form-control-big" id="ans2" name="ans2"/>
								<input type="file" id="fileans2" name="fileans2" onchange="checkPhoto(this.id)" accept=".png"/>
								<div> (max height 50px and width between 50-500 )</div>
								<input type="checkbox" name="correct_2" id="correct_2" value="1"> isCorrect
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Ans 3</label>
								<input type="text" class="form-control-big" id="ans3" name="ans3"/>
								<input type="file" id="fileans3" name="fileans3" onchange="checkPhoto(this.id)" accept=".png"/>
								<div> (max height 50px and width between 50-500 )</div>
								<input type="checkbox" name="correct_3" id="correct_3" value="1">  isCorrect
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Ans 4</label>
								<input type="text" class="form-control-big" id="ans4" name="ans4"/>
								<input type="file" id="fileans4" name="fileans4" onchange="checkPhoto(this.id)" accept=".png"/>
								<div> (max height 50px and width between 50-500 )</div>
								 <input type="checkbox" name="correct_4" id="correct_4" value="1"> isCorrect
							</div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"> Difficulty Level</label>
                                <select name="difficultylevel" id="difficultylevel"  class="form-control-big" >
                                    <option value=''>Select Difficulty Level</option>
                                    <option value='High'>High</option>
                                    <option value='Medium'>Medium</option>
                                    <option value='Low'>Low</option>

                                </select>
                            </div>
							<div id="questionmarkpanel">
								<div class="form-group">
									<label for="exampleInputEmail1">Question Mark</label>
									<input type="number" class="form-control-big" id="mark" name="mark" />
								</div>
							</div>
						</div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                    <!-- <button type="submit" class="btn btn-primary"> Add</button>-->
						<input type="button" onClick="submitForm()" class="btn btn-primary" value="Add" />
                    </div>
                   </form>
                  <div class="box-footer">
                    <label id="message"></label>
                  </div>
               </div>   
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->

        </section>
      </div>
     </div> 
   <script type="text/javascript">
	   $("#test").change(function(e){
	   		var equalmarks=$(this).find("option:selected").attr('equalmarks');
            var sametopic=$(this).find("option:selected").attr('sametopic');
           console.log(sametopic);
          // console.log(equalmarks);
            if(equalmarks=="YES")
            {
                $("#questionmarkpanel").hide();
            }
            else
            {
                $("#questionmarkpanel").show();
            }

           if(sametopic=="NO")
           {
               $("#capturetopicpanel").show();
              
           }
           else
           {
               $("#capturetopicpanel").hide();
             
           }

	   });
	function submitForm(){
		//alert('submited');

		if($('#test').val()!='')
		{
			var correctanscount=0;

			if($("#correct_1").prop('checked')==true)
			{
				correctanscount++;
			}
			if($("#correct_2").prop('checked')==true)
			{
				correctanscount++;
			}
			if($("#correct_3").prop('checked')==true)
			{
				correctanscount++;
			}
			if($("#correct_4").prop('checked')==true)
			{
				correctanscount++;
			}


            var equalmarks=$("#test").find("option:selected").attr('equalmarks');
			var testtype=$("#test").find("option:selected").attr('testtype');
            var sametopic=$("#test").find("option:selected").attr('sametopic');

			if(testtype=="IIT JEE" && correctanscount>1)
			{
				alert('You can select mamimum one correct answer for IIT JEE test.')
				return false;
			}
			if($('#mark').val()=='' && equalmarks=="NO"){
				alert('Please enter marks');
			}else{
                if(sametopic=='NO' && $("#course").val()==""){
                    alert('Please select course.');
                    return;
                }
                if(sametopic=='NO' && $("#subject").val()==""){
                    alert('Please select subject.');
                    return;
                }
                if(sametopic=='NO' && $("#topic").val().length==""){
                    alert('Please select topic.');
                    return;
                }
				if($('#question').val()=='' && $('#ques_file').val()==''){
					alert('Please add question or add image for question.');
				}else{
					if(document.getElementById("fileans1").files.length == 0 && $('#ans1').val()=='' ){
						alert('Please enter answer 1 or choose file.');
					}else{
						if(document.getElementById("fileans2").files.length == 0 && $('#ans2').val()=='' ){
							alert('Please enter answer 2 or choose file.');
						}else{
							if(document.getElementById("fileans3").files.length == 0 && $('#ans3').val()=='' ){
								alert('Please enter answer 3 or choose file.');
							}else{
								if(document.getElementById("fileans4").files.length == 0 && $('#ans4').val()=='' ){
									alert('Please enter answer 4 or choose file.');
								}else{
									if(document.getElementById("correct_1").checked)
									{
										document.getElementById('questionForm').submit();
									}else{
										if(document.getElementById("correct_2").checked){
											document.getElementById('questionForm').submit();
										}else{
											if(document.getElementById("correct_3").checked){
												document.getElementById('questionForm').submit();
											}else{
												if(document.getElementById("correct_4").checked){
													document.getElementById('questionForm').submit();
												}else
													alert('Please select atleast one correct answer.');
											}
										}
									}	
								}
							}
						}
					
					}

				}
				

			}
		}else{
			alert('Please select test.');
		}
		
	}

	   /*function TestChange(course){
	   		$.ajax({
						type : "POST",
						url : "api/sub/index.php/getCourseSub",
						data : {course:course},
						success : function(response) {
							$('#subjectDiv').html(response);
						}
					});
	   }*/
	   
 function checkPhoto(id){
        //Get reference of FileUpload.
        var fileUpload = $("#"+id)[0];

        //Check whether the file is valid Image.
        var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.png)$");
        if (regex.test(fileUpload.value.toLowerCase())) {
            //Check whether HTML5 is supported.
            if (typeof (fileUpload.files) != "undefined") {
                //Initiate the FileReader object.
                var reader = new FileReader();
                //Read the contents of Image File.
                reader.readAsDataURL(fileUpload.files[0]);
                reader.onload = function (e) {
                    //Initiate the JavaScript Image object.
                    var image = new Image();
                    //Set the Base64 string return from FileReader as source.
                    image.src = e.target.result;
                    image.onload = function () {
                        //Determine the Height and Width.
                        var height = this.height;
                        var width = this.width;
                        if ((height < 50 || height > 60 ) || width < 50 ) {
							
                            //alert("Height must not exceed 50Px and Width must not exceed 500Px .");
							//document.getElementById(id).value = "";
                           // return false;
							
                        }
                        //alert("Uploaded image has valid Height and Width.");
                        return true;
                    };
                }
            } else {
                alert("This browser does not support HTML5.");
				document.getElementById(id).value = "";
                return false;
            }
        } else {
            alert("Please select a valid Image file.");
			document.getElementById(id).value = "";
            return false;
        }
    }


      /* function getSubject(course){
           $.ajax({
               type : "POST",
               url : "api/sub/index.php/getCourseSub",
               data : {course:course},
               success : function(response) {
                   response = response.replace("form-control", "form-control-big");
                   $('#subjectDiv').html(response);
               }
           });


       }*/

      $("#test").change(function(){
		  getTopics($(this).find("option:selected").attr('subject'));
//		  /alert($(this).find("option:selected").attr('subject'));
	  });
       function getTopics(subjectid){
           $.ajax({
               type : "POST",
               url : "api/topic/index.php/getSubjectTopics",
               data : {subject:subjectid},
               success : function(response) {
                   response = response.replace("form-control", "form-control-big");
                   $('#topicDiv').html(response);
               }
           });}
</script>
	  
      <div class="control-sidebar-bg"></div>
 <?php include("footer.php");?>
   
     <!-- Invite Super Administr -->
  
   </body>
  </html>    

