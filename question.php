<?php  session_start();?>
<style type="text/css">
	.col-md-1
	{
    margin-bottom: 2%;
    width: 14.333 %!important;
}
</style>
<?php
if(isset($_GET['page']))
	$page=$_GET['page'];
else
	$page=1;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>RIIT|ADD QUESTION</title>
<?php include("link.php"); ?>
</head>
  <body class="skin-blue sidebar-mini">

    <div class="wrapper">

     <?php include('header.php');?>
      <?php include('sidemenu.php');?>

      <div class="content-wrapper">
        <section class="content">
          <!--ADD BUTTON AT THE TOP-->
              <button type="submit" class="btn btn-block btn-primary btn-lg" onclick="createQues()" style="width:auto;margin-bottom: 1%;" > Add <i class="fa fa-graduation-cap"></i></button>
               <!-- Modal1 Add -->
           <div class="modal fade" id="myModal1" role="dialog">
             <div class="modal-dialog">
               <div class="modal-content">
                 <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" onclick="javascript:window.location.reload()">&times;</button>
                   <h4 class="modal-title"> Add Question</h4>
                 </div>


            </div> <!--modal-content-->
           </div> <!--modal-dialog-->
          </div>  <!--modal fade-->

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
                   <div class="row">
                   <form role="form" action="api/question/index.php/getQuestionPost"  method="POST" id="getQustionform">
                    <div class="box-body">

						<?php
							require_once 'include/test.php';
							$testObject = new Test(SERVER_API_KEY);
							$data = $testObject->getAlltests(0);
							?>
						<div class="form-group">
							<div class="box-header">
								<h3 class="box-title">Question Management </h3>
							</div><!-- /.box-header -->
                       	<div style="height:2%;"></div>
							  <select name="test" id="test" onchange="submitForm()" class="form-control" required>
								  <option value=''>Select Test</option>
									<?php for($i=0;$i<count($data);$i++){?>
											   <option value='<?php echo $data[$i]->test_id?>' <?php if(isset($_GET['test']) && $data[$i]->test_id==$_GET['test']) { echo "selected='selected'"; } ?>><?php echo $data[$i]->title?></option>
									   <?php }?>
							  </select>
							<input type="hidden" name="page" value="<?php echo $page;?>"/>
                      	</div>

                    </div><!-- /.box-body -->
                   </form>
					   <div class="col-md-12">
						  <table class="table table-bordered table-hover " id="tbl-question-list" >

						   <thead>
							   <tr>
								   <th>Sr No</th>
								   <th>Question</th>
								   <th>image</th>
								   <th>Difficulty Level</th>
							   	   <th>Action </th>
								</tr>
							</thead>
							  <tbody>
								  <?php

								   require_once 'include/question.php';
								   require_once 'include/test.php';
								   $questionObject = new Question(SERVER_API_KEY);
								   $testObject = new Test(SERVER_API_KEY);
					               $data = $questionObject->getAllQuestionList();

								  for($i=0;$i<count($data);$i++)
								  {

								  ?>
								<tr>
								<td><?php

									echo $i+1 ;

								 ?></td>

									<td style="width:40%"><?=$data[$i]->question?></td>
									<td >
										<?php if($data[$i]->quesIsFile==1){?>
										<a href="<?php echo URL.'uploads/Questions/'.$data[$i]->questionFile?>">
										<!--<img id="Question image" src="<?php echo URL.'uploads/Questions/'.$data[$i]->questionFile?>" alt="Question image" width="50" height="50" class="popup"/>--><?php echo $data[$i]->questionFile?></a>
										<?php }else echo "No Image";?></td>
									<td ><?=$data[$i]->difficultylevel?></td>
								<td>
										 <a href="questionEdit.php?id=<?php echo "".$data[$i]->question_id;?>" type='button' class='btn  btn-warning'> Edit</a>


							  <?php if ($data[$i]->isEnabled == 1) { ?>
								  <!--<a onclick=" return confirm(' Are You Sure' )" class="btn btn-primary" href="api/question/index.php/updateQuesStatus/<?php echo $data[$i]->question_id;  ?>/0">
										Deactivate</a>-->

							  <?php }else{ ?>
										<!--<a onclick=" return confirm(' Are You Sure' )"  style="width:78px"
										class="btn btn-info" href="api/question/index.php/updateQuesStatus/<?php echo "".$data[$i]->question_id;?>/1">
										 Activate </a>-->

							<?php } ?>
										<a onclick=" return confirm(' Are You Sure' )" class="btn btn-danger" href="api/question/index.php/deleteQuestion/<?php echo "".$data[$i]->question_id;  ?>">
										 Delete</a>

								</td>

								  </tr>
								  <?php } ?>

								</tbody>


						  </table>
					   </div>
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

      <div class="control-sidebar-bg"></div>
 <?php include("footer.php");?>
	<script type="text/javascript">
		$(function() {
			$('#msgdiv').delay(1000).hide(1000);
		});
		function submitForm() {
			document.getElementById("getQustionform").submit();
		}
		function createQues(){
			window.location = "createQuestion.php";
		}
		$('#tbl-question-list').DataTable( {    } );
	</script>
     <!-- Invite Super Administr -->

   </body>
  </html>
