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
                   <form role="form" action="api/question/index.php/updateQuestion" enctype="multipart/form-data"  method="post" id="questionForm">
                    <div class="box-body">
								 
						<?php
							require_once 'include/question.php';
							 $id =$_GET['id'];
							 $where['question_id']=$id;
							 $questionObj = new Question();
							 $value=$questionObj->getQuestion($where);
							 $ansData=$questionObj->getQuestionAns($where);

							require_once 'include/test.php';
							require_once 'include/sub.php';
							$testObject = new Test(SERVER_API_KEY);
							$data = $testObject->getAlltests(0);
							$subObject = new sub(SERVER_API_KEY);
							$subject = $subObject->getAllSubjects(0);
							$qpanelvisible="NO";
							
						?>
						<div id="questionDiv1">
							<div class="form-group">
								<label for="exampleInputEmail1">Question</label>
								<input type="text" class="form-control-big" id="question" name="question" value="<?php echo $value[0]->question?>"/>

								<input type="file" id="ques_file" name="ques_file" onchange="checkPhoto(this.id)" accept=".png"/>
								<div> (max height 50px and width between 50-500 )</div>

								<?php
								if($value[0]->quesIsFile==1)
								{
									echo "<img src='uploads/Questions/".$value[0]->questionFile."' style='max-width:200px;' /> <a href='api/question/index.php/deleteQuestionImage/".$value[0]->question_id."'><i class='fa fa-trash fa-2x' style='color:red;cursor:pointer;'></i></a>";
								}
								?>
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Ans 1</label>
								<?php if($ansData[0]->is_file==0){?>
									<input type="text" class="form-control-big" id="ans1" name="ans1" value="<?php echo $ansData[0]->choice;?>"/>
									<input type="file" id="fileans1" name="fileans1" onchange="checkPhoto(this.id)" accept=".png"/>
								<?php }else{?>
									<input type="text" class="form-control-big" id="ans1" name="ans1" value=""/>
									<input type="file" id="fileans1" name="fileans1" onchange="checkPhoto(this.id)" value="<?php echo URL.'uploads/Questions/'.$ansData[0]->choice?>"  accept=".png"/>
								<?php }?>
								<div> (max height 50px and width between 50-500 )</div>
								 <input type="checkbox" name="correct_1" id="correct_1" value="1" <?php if($ansData[0]->is_right==1) echo "checked"; ?>> isCorrect.		
							<input type="hidden" name="ans_id_1" value="<?php echo $ansData[0]->choice_id?>"/> <br />
                                <?php
                                if($ansData[0]->is_file==1)
                                {
                                    echo "<img src='uploads/Questions/".$ansData[0]->choice."' style='max-width:200px;' /> <a href='api/question/index.php/deleteQuestionChoiceImage/".$ansData[0]->question_id."/".$ansData[0]->choice_id."'><i class='fa fa-trash fa-2x' style='color:red;cursor:pointer;'></i></a>";
                                }
                                ?>
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Ans 2 </label>
								<?php if($ansData[1]->is_file==0){?>
									<input type="text" class="form-control-big" id="ans2" name="ans2" value="<?php echo $ansData[1]->choice;?>"/>
									<input type="file" id="fileans2" name="fileans2" onchange="checkPhoto(this.id)" accept=".png"/>
								<?php }else{?>
									<input type="text" class="form-control-big" id="ans2" name="ans2" value=""/>
									<input type="file" id="fileans2" name="fileans2" onchange="checkPhoto(this.id)" accept=".png"/>
								<?php }?>
								<div> (max height 50px and width between 50-500 )</div>
								<input type="checkbox" name="correct_2" id="correct_2" value="1" <?php if($ansData[1]->is_right==1) echo "checked"; ?>> isCorrect		<input type="hidden" name="ans_id_2" value="<?php echo $ansData[1]->choice_id?>"/>
                                <br />
                                <?php
                                if($ansData[1]->is_file==1)
                                {
                                    echo "<img src='uploads/Questions/".$ansData[1]->choice."' style='max-width:200px;' /> <a href='api/question/index.php/deleteQuestionChoiceImage/".$ansData[1]->question_id."/".$ansData[1]->choice_id."'><i class='fa fa-trash fa-2x' style='color:red;cursor:pointer;'></i></a>";
                                }
                                ?>
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Ans 3</label>
								<?php if($ansData[2]->is_file==0){?>
									<input type="text" class="form-control-big" id="ans3" name="ans3" value="<?php echo $ansData[2]->choice;?>"/>
									<input type="file" id="fileans3" name="fileans3" onchange="checkPhoto(this.id)" accept=".png"/>
								<?php }else{?>
									<input type="text" class="form-control-big" id="ans3" name="ans3" value=""/>
									<input type="file" id="fileans3" name="fileans3" onchange="checkPhoto(this.id)" accept=".png"/>
								<?php }?>
								<div> (max height 50px and width between 50-500 )</div>
								<input type="checkbox" name="correct_3" id="correct_3" value="1" <?php if($ansData[2]->is_right==1) echo "checked"; ?>>  isCorrect		<input type="hidden" name="ans_id_3" value="<?php echo $ansData[2]->choice_id?>"/>
                                <br />
                                <?php
                                if($ansData[2]->is_file==1)
                                {
                                    echo "<img src='uploads/Questions/".$ansData[2]->choice."' style='max-width:200px;' /> <a href='api/question/index.php/deleteQuestionChoiceImage/".$ansData[2]->question_id."/".$ansData[2]->choice_id."'><i class='fa fa-trash fa-2x' style='color:red;cursor:pointer;'></i></a>";
                                }
                                ?>
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Ans 4</label>
								<?php if($ansData[3]->is_file==0){?>
									<input type="text" class="form-control-big" id="ans4" name="ans4" value="<?php echo $ansData[3]->choice;?>"/>
									<input type="file" id="fileans4" name="fileans4" onchange="checkPhoto(this.id)" accept=".png"/>
								<?php }else{?>
									<input type="text" class="form-control-big" id="ans4" name="ans4" value=""/>
									<input type="file" id="fileans4" name="fileans4" onchange="checkPhoto(this.id)" accept=".png"/>
								<?php }?>
								<div> (max height 50px and width between 50-500 )</div>
								 <input type="checkbox" name="correct_4" id="correct_4" value="1" <?php if($ansData[3]->is_right==1) echo "checked"; ?>> isCorrect	<input type="hidden" name="ans_id_4" value="<?php echo $ansData[3]->choice_id?>"/>
                                <br />
                                <?php
                                if($ansData[3]->is_file==1)
                                {
                                    echo "<img src='uploads/Questions/".$ansData[3]->choice."' style='max-width:200px;' /> <a href='api/question/index.php/deleteQuestionChoiceImage/".$ansData[3]->question_id."/".$ansData[3]->choice_id."'><i class='fa fa-trash fa-2x' style='color:red;cursor:pointer;'></i></a>";
                                }
                                ?>
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1"> Difficulty Level</label>
								<select name="difficultylevel" id="difficultylevel"  class="form-control-big" >
									<option value=''>Select Difficulty Level</option>
									<option value='High' <?php if($value[0]->difficultylevel=="High") echo "selected"; ?>>High</option>
									<option value='Medium' <?php if($value[0]->difficultylevel=="Medium") echo "selected"; ?>>Medium</option>
									<option value='Low' <?php if($value[0]->difficultylevel=="Low") echo "selected"; ?>>Low</option>
								</select>
							</div>
							<div id="questionmarkpanel" style="display: <?php if($qpanelvisible=="YES") { echo "none"; }else { echo "block"; } ?>">
								<div class="form-group">
									<label for="exampleInputEmail1">Question Mark</label>
									<input type="number" class="form-control-big" id="mark" name="mark" value="<?php echo $value[0]->marks?>" />
								</div>
							</div>
							<input type="hidden" name="id" value="<?php echo $_GET['id']?>"/>
							<input type="hidden" name="testMarks" value="<?php echo $value[0]->marks?>"/>
						</div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                    <!-- <button type="submit" class="btn btn-primary"> Add</button>-->
						<input type="button" onClick="submitForm()" class="btn btn-primary" value="Update" />
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
		   console.log(equalmarks);
		   if(equalmarks=="YES")
		   {
			   $("#questionmarkpanel").hide();
		   }
		   else
		   {
			   $("#questionmarkpanel").show();
		   }


	   });
	function submitForm(){
		//alert('submited');
		if($('#test').val()!=''){
			if($('#mark').val()==''){
				alert('Please enter marks');
			}else{
				if($('#question').val()=='' && $('#ques_file').val()==''){
					alert('Please add question or add image for question.');
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
		}/*
		else{
					alert('Please select test.');
				}*/
		
		
	}
	   function getSubject(course){
	   		$.ajax({
						type : "POST",
						url : "api/sub/index.php/getCourseSub",
						data : {course:course},
						success : function(response) {
							$('#subjectDiv').html(response);
						}
					});
	   }
	   
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
                        if ((height < 50 || height > 60 ) || width <= 100) {
							
                           // alert("Height must not exceed 50Px and Width must not exceed 500Px .");
							//document.getElementById(id).value = "";
                          //  return false;
							
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

</script>
	  
      <div class="control-sidebar-bg"></div>
 <?php include("footer.php");?>
   
     <!-- Invite Super Administr -->
  
   </body>
  </html>    

