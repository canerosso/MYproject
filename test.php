<?php  session_start();?>
<style type="text/css">
	.col-md-1
	{
    margin-bottom: 2%;
    width: 14.333 %!important;
}
</style>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>RIIT|ADD TEST</title>
<?php include("link.php"); ?>
</head>
  <body class="skin-blue sidebar-mini">

    <div class="wrapper">

     <?php include('header.php');?>
      <?php include('sidemenu.php');?>

      <div class="content-wrapper">
        <section class="content">
          <!--ADD BUTTON AT THE TOP-->
              <button type="submit" class="btn btn-block btn-primary btn-lg" data-toggle="modal" data-target="#myModal1" style="width:auto;margin-bottom: 1%;margin-right: 1%; float:left;" > Add <i class="fa fa-graduation-cap"></i></button>
              <button type="submit" class="btn btn-block btn-primary btn-lg" data-toggle="modal" data-target="#myModal2" style="width:auto;margin-bottom: 1%; margin-top: 0%;float:left;" > Create From Existing Test <i class="fa fa-graduation-cap"></i></button>
               <!-- Modal1 Add -->
           <div class="modal fade" id="myModal1" role="dialog">
             <div class="modal-dialog">
               <div class="modal-content">
                 <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" onclick="javascript:window.location.reload()">&times;</button>
                   <h4 class="modal-title"> Add Test</h4>
                 </div>
                 <div class="modal-body" >
                  <div class="row">
                     <form role="form" action="api/test/index.php/addTest" enctype="multipart/form-data"  method="post" id="inviteUser">
                    <div class="box-body">

                      <div class="form-group">
                       <label for="exampleInputEmail1">Test title</label>
                       <input maxlength=50 type="text" class="form-control" name="title" id="title" placeholder="Test title" required>
                      </div>

						<?php
							require_once 'include/course.php';
							require_once 'include/sub.php';
							$courseObject = new Course(SERVER_API_KEY);
							$data = $courseObject->getAllCourse(0);
							$subObject = new sub(SERVER_API_KEY);
							$subject = $subObject->getAllSubjects(0);

						?>
						<div class="form-group">
                       		<label for="exampleInputEmail1"> Course</label>
							  <select name="course" id="course" onchange="getSubject(this.value)" class="form-control" required>
								  <option value=''>Select Course</option>
									<?php for($i=0;$i<count($data);$i++){?>
											   <option value='<?php echo $data[$i]->course_id?>'><?php echo $data[$i]->course_name?></option>
									   <?php }?>
							  </select>
                      	</div>
						<div class="form-group" id="subjectDiv">
                       		<label for="exampleInputEmail1">Subject</label>
							  <select name="subject" id="subject" class="form-control" onchange="getTopics(this.value)" required>
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
                        <div class="form-group" id="topicDiv" style="display: none">
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

          <div class="modal fade" id="myModal2" role="dialog">
             <div class="modal-dialog">
               <div class="modal-content">
                 <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                   <h4 class="modal-title"> Create From Existing Test</h4>
                 </div>
                 <div class="modal-body" >
                  <div class="row">
                     <form role="form" action="api/test/index.php/copyTest" enctype="multipart/form-data"  method="post" id="create_test_from_existing_form">
                    <div class="box-body">

                      <div class="form-group">
                       <label for="exampleInputEmail1">Test title</label>
                       <input type="text" class="form-control" name="title" id="title" placeholder="Test title" required>
                      </div>

						<?php
							require_once 'include/test.php';
							$testObject = new Test(SERVER_API_KEY);
							$data = $testObject->getData(TABLE_TEST,array('test_id','title','testtype'),array('isDeleted'=>'0'), '');
						?>
                        <label for="testtype">Test Type</label> &nbsp;
                        <div class="form-group">

                            <label class="radio-inline"><input type="radio" name="testtype" value="IIT JEE">IIT JEE</label>
                            <label class="radio-inline"><input type="radio" name="testtype" value="NEET" checked>NEET</label>
                        </div>
						<div class="form-group">
                       		<label for="exampleInputEmail1"> Select Existing Test</label>
							  <select name="test" id="test"  class="form-control" required>
								  <option value=''>Select Test</option>
									<?php for($i=0;$i<count($data);$i++){?>
											   <option value='<?php echo $data[$i]->test_id?>' testtype="<?php echo $data[$i]->testtype?>"><?php echo $data[$i]->title ?></option>
									   <?php }?>
							  </select>
                      	</div>







                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                     <button type="submit" class="btn btn-primary"> Create Test</button>
                    </div>
                   </form>
                  <div class="box-footer">
                    <label id="message"></label>
                  </div>

              </div>  <!--modal body -->

            </div> <!--modal-content-->
           </div> <!--modal-dialog-->
          </div>  <!--modal fade-->

           <div class="row">
              <div class="col-xs-12">
                <div class="box">
                  <div class="box-header">
                    <h3 class="box-title">Test Management </h3>
                  </div><!-- /.box-header -->
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
                	  <table class="table table-bordered table-hover "  >

                   <thead style="float: left;width: 100%;box-sizing: border-box;">
                       <tr style="float: left;width: 100%;box-sizing: border-box;">
                       <th style="float: left;width: 4% !important;box-sizing: border-box;border:0px;border-right: 1px solid #f4f4f4;">Sr No</th>
                       <th style="float: left;width: 10% !important;box-sizing: border-box;border:0px;border-right: 1px solid #f4f4f4;">Title</th>
											 <th style="float: left;width: 8% !important;box-sizing: border-box;border:0px;border-right: 1px solid #f4f4f4;">No Of questions</th>
											 <th style="float: left;width: 7% !important;box-sizing: border-box;border:0px;border-right: 1px solid #f4f4f4;">Total Marks</th>
                       <th style="float: left;width: 10% !important;box-sizing: border-box;border:0px;border-right: 1px solid #f4f4f4;">Validation Code</th>
                       <th style="float: left;width: 5% !important;box-sizing: border-box;border:0px;border-right: 1px solid #f4f4f4;">Is Special</th>
                       <th style="float: left;width: 10% !important;box-sizing: border-box;border:0px;border-right: 1px solid #f4f4f4;">Course</th>
                       <th style="float: left;width: 5% !important;box-sizing: border-box;border:0px;border-right: 1px solid #f4f4f4;">Subject</th>
                       <th style="float: left;width: 36% !important;box-sizing: border-box;text-align:center;border:0px;border-right: 1px solid #f4f4f4;">Action</th>
                      </tr>
                    </thead>

                   <tbody style="float: left;width: 100%;box-sizing: border-box;">
                      <?php
                       $page=@$_GET['page'];
						if($page=='')
							$page=1;
                       require_once 'include/test.php';
                       $testObject = new Test(SERVER_API_KEY);

                       $data = $testObject->getAlltests($page);

						$countOfRole = count($data);
                       $count = $testObject->GetCountOfTest();
                      for($i=0;$i<$countOfRole;$i++)
                      {
                      ?>
                    <tr style="float: left;width: 100%;box-sizing: border-box;">
                    <td style="float: left;width: 4%;box-sizing: border-box;"><?php
                    if($page >1)
                    {
						echo (10*($page-1))+$i+1 ;
                    }
                    else
                    {
                    	echo $i+1 ;
                    }
                     ?></td>
						 <td style="float: left;width: 25%;box-sizing: border-box;"><?=$data[$i]->title?></td>
						  <td style="float: left;width: 10%;box-sizing: border-box;"><?=$data[$i]->code?></td>
              <td style="float: left;width: 5%;box-sizing: border-box;"><?php if($data[$i]->isSpecial==1) { echo "Yes"; } else { echo "No"; }?></td>
						<?php
							$where['course_id']=$data[$i]->course;
							$value=$courseObject->getCourse($where);
						?>
						 <td style="float: left;width: 10%;box-sizing: border-box;"><?php echo $value[0]->course_name;?></td>
						<?php
						 	$whereSub['cat_id']=$data[$i]->subject;
							$value=$subObject->getSub($whereSub);
						?>
						 <td style="float: left;width: 10%;box-sizing: border-box;"><?=$value[0]->cat_name?></td>

            <td style="float: left;width: 36%;box-sizing: border-box;display: flex;">

						 <div class='col-md-3' style="margin:auto;margin-right: 4px;padding: 0;">
							 <a href="UpdateTest.php?id=<?php echo "".$data[$i]->test_id;  ?>&page=<?php echo $page?>" data-toggle='modal' style="width:100%;font-size: 11px;" data-target='#theModal<?php echo "".$data[$i]->test_id;  ?>' type='button' class='btn  btn-warning'> Edit</a>
							 <div class="modal fade text-center" id="theModal<?php echo "".$data[$i]->test_id;  ?>">
							 <div class="modal-dialog">
									 <div class="modal-content">
								</div>
							</div>
						</div>
						  </div><!--</div>-->
				  <?php if ($data[$i]->isEnabled == 1) { ?>
						<div class='col-md-3' style="margin:auto;margin-right: 4px;padding: 0;">
							<a onclick=" return confirm(' Are You Sure' )" style="width:100%;font-size: 11px;" class="btn btn-primary" href="api/test/index.php/updateTestStatus/<?php echo "".$data[$i]->test_id;  ?>/0/<?=$page?>">
							Deactivate</a>
						</div>
				  <?php }else{ ?>
					<div class='col-md-3' style="margin:auto;margin-right: 4px;padding: 0;">
							<a onclick=" return confirm(' Are You Sure' )"  style="width:100%;font-size: 11px;"
							class="btn btn-info" href="api/test/index.php/updateTestStatus/<?php echo "".$data[$i]->test_id;?>/1/<?=$page?>">
							 Activate </a>
						</div>
				<?php } ?>
						<div class='col-md-3' style="margin:auto;margin-right: 4px;padding: 0;">
							<a onclick=" return confirm(' Are You Sure' )" style="width:100%;font-size: 11px;" class="btn btn-danger" href="api/test/index.php/deleteTest/<?php echo "".$data[$i]->test_id;  ?>/<?=$page?>">
							 Delete</a>
						 </div>
						 	<div class='col-md-3' style="margin:auto;margin-right: 4px;padding: 0;">
                        <a class="btn btn-success" style="width:100%;font-size: 11px;" href="export-test.php?Id=<?=$data[$i]->test_id;?>"> Export Result</a>
											</div>
												<div class='col-md-3' style="margin:auto;margin-right: 4px;padding: 0;">
                        <a class="btn btn-success" style="width:100%;font-size: 11px;" href="export-test-result-for-parent.php?Id=<?=$data[$i]->test_id;?>">Result for Parent</a>
						</div>
                    </td>

                      </tr>
                      <?php } ?>

                    </tbody>

                  </table>
					      <!--<ul class="pagination">
            <?php
/*
             $count;
             $cnt=$count/10;
            $RoundPage=ceil($cnt);
             if($RoundPage >1)
             {
              $EndRoundpage=$RoundPage;
             }
             else
             {
                $EndRoundpage=$RoundPage;
             }

         $startPage=$page;
         $totalPage=$RoundPage;
         $endPage = $EndRoundpage;
        if($totalPage >3)
        {
        $endPage1=3;
        }
        else
        {
            $endPage1=$totalPage;
        }
        $endPage = ($totalPage < $endPage) ? $totalPage : $endPage;
        $diff = $startPage - $endPage + 1;
        $startPage -= ($startPage - $diff > 0) ? $diff : 0;
        $startPage1= $startPage;
        $startPage=1;
        $diff = $startPage - $endPage1 + 1;
        $startPage -= ($startPage - $diff > 0) ? $diff : 0;
           $prev ="";
           if($page ==1)
           {
              $disabledprev="disabled";
              $prev='#';
           }
           else
           {
               $disabledprev="";
               $prev=$page-1;

           }

        // if ($startPage > 1)
            echo " </ul>
                     <div class='row'>
                      <div class='col-sm-12'>
                      <div class='dataTables_paginate paging_simple_numbers' id='example03_paginate'>
                      <ul class='pagination'>
                      <li class='paginate_button previous ". $disabledprev."' id='example03_previous'>
                      <a href='".URL."test.php?page=".$prev."' aria-controls='example03' data-dt-idx='0' tabindex='0'>Previous</a>
                      </li>";
        for($i=$startPage; $i<=$endPage1; $i++)
        {
            if($page==$i)
            {
              $actp='paginate_button active';
            }
            else
            {
              $actp='';
            }
           //echo "+++".$actp;
         echo "<li class='page-item ".$actp."'><a class='page-link' href='".URL."test.php?page=".$i."'> {$i}</a></li> ";
        }

        if($endPage1==3) echo " <li class='page-item'><a class='page-link' href='".URL."test.php?page=".$i."'>...</a></li> ";
        if($endPage1 < $startPage1 )
        {
        for($i=$startPage1; $i<=$endPage; $i++)
        {
          if($page==$i)
            {
              $actp='paginate_button active';
            }
            else
            {
              $actp='';
            }
           //echo "+++".$actp;
         echo "<li class='page-item ".$actp."'><a class='page-link' href='".URL."test.php?page=".$i."'> {$i}</a></li> ";
        //  echo " <li  class='page-link' ><a class='page-link' href='".URL."role.php?page=".$i."'>{$i}</a></li> ";
        }
        }
        if ($endPage+1 == $totalPage)
           $i= $i-1;
             $nxt =$page+1;
           if($nxt==$totalPage+1)
           {
              $disabled="disabled";
              $nxt="";
           }
           else
           {
               $disabled="";

           }
         echo "<li class='paginate_button next  ". $disabled."' id='example03_next'>
                      <a   href='".URL."test.php?page=".$nxt."' aria-controls='example03' data-dt-idx='2' tabindex='0'>Next</a>
                      </li>
                      </ul>
                      </div>
                      </div>
                      </div>";
        */?>

  </ul>-->
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->

        </section>
      </div>
     </div>
   <script type="text/javascript">
		$(function() {
			$('#msgdiv').delay(1000).hide(1000);
		});
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
        function getTopics(subjectid){
            $.ajax({
                type : "POST",
                url : "api/topic/index.php/getSubjectTopics",
                data : {subject:subjectid},
                success : function(response) {
                    $('#topicDiv').html(response);
                }
            });}

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
                    $("#topicDiv").show();
                    $("#topicDiv").find("select").attr('required','required');
                }
                else
                {
                    $("#topicDiv").hide();
                    $("#topicDiv").find("select").removeAttr('required');
                    $("#topicDiv").find("select").val('');
                }
            });

       $("#create_test_from_existing_form").submit(function(e){

           if($(this).find("input[name=testtype]:checked").val()=="IIT JEE" && $(this).find("#test option:selected").attr('testtype')=="NEET")
           {
               alert('Multi-correct questions cant be added to single correct questions.');
               e.preventDefault();
               return false;
           }

       });
</script>
      <div class="control-sidebar-bg"></div>
 <?php include("footer.php");?>

     <!-- Invite Super Administr -->

   </body>
  </html>
