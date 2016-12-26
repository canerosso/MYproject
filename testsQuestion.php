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
if(isset($_GET['test']))
	$test=$_GET['test'];
else
	$test=0;
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
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
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
                   <div >
                    <form role="form" action="api/question/index.php/getQuestionPost"  method="POST" id="getQustionform">
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
							  <select name="test" id="test" onchange="submitForm(this.value)" class="form-control" required>
								  <option value=''>Select Test</option>
									<?php for($i=0;$i<count($data);$i++){?>
									   <option value='<?php echo $data[$i]->test_id?>' <?php if($test==$data[$i]->test_id) echo "selected";?>><?php echo $data[$i]->title?></option>
									   <?php }?>
							  </select>
							<input type="hidden" name="page" value="<?php echo $page;?>"/>
                      	</div>
					
                    </div><!-- /.box-body -->
                   </form>
					   <div id="table">
						  <table class="table table-bordered table-hover " id="tbl-question-list">

						   <thead>
							   <tr>
								   <th>Sr No</th>
								   <th>Test Title</th>
								   <th width="40%">Question</th>
								   <th>Image</th>
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
					
								   $data = $questionObject->getQuestionList($test);
								   
								   $countOfRole = count($data);
								   //$count = $questionObject->GetCountOfQuestion($test);
//echo ">>".$count;
								//print_r($data);
								  for($i=0;$i<$countOfRole;$i++)
								  {
								  ?>
								<tr>
								<td><?php

									echo $i+1 ;

								 ?></td>
									<?php
										$where['test_id']=$test;
										$value=$testObject->getTest($where);
									?>
									 <td><?php echo $value[0]->title;?></td>
									<td width="40%"><?=$data[$i]->question?></td>

									<td >
										<?php if($data[$i]->quesIsFile==1){?>
										<a href="<?php echo URL.'uploads/Questions/'.$data[$i]->questionFile?>">
										<!--<img id="Question image" src="<?php echo URL.'uploads/Questions/'.$data[$i]->questionFile?>" alt="Question image" width="50" height="50" class="popup"/>--><?php echo $data[$i]->questionFile?></a>
										<?php }else echo "No Image";?></td>
									<td><?=$data[$i]->difficultylevel?></td>
								<td>
									
										 <a href="questionEdit.php?id=<?php echo "".$data[$i]->question_id;?>"  type='button' class='btn  btn-warning'> Edit</a>
									
							  
									
										<a onclick=" return confirm(' Are You Sure' )" class="btn btn-danger" href="api/question/index.php/deleteQuestionFromTest/<?php echo "".$data[$i]->question_id;  ?>/<?=$test?>">
										 Delete </a>
									
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
								  <a href='".URL."testsQuestion.php?page=".$prev."&test=".$test."' aria-controls='example03' data-dt-idx='0' tabindex='0'>Previous</a>
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
					 echo "<li class='page-item ".$actp."'><a class='page-link' href='".URL."testsQuestion.php?page=".$i."&test=".$test."'> {$i}</a></li> ";
					}

					if($endPage1==3) echo " <li class='page-item'><a class='page-link' href='".URL."testsQuestion.php?page=".$i."&test=".$test."'>...</a></li> ";
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
					 echo "<li class='page-item ".$actp."'><a class='page-link' href='".URL."testsQuestion.php?page=".$i."&test=".$test."'> {$i}</a></li> ";
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
								  <a   href='".URL."testsQuestion.php?page=".$nxt."&test=".$test."' aria-controls='example03' data-dt-idx='2' tabindex='0'>Next</a>
								  </li>
								  </ul>
								  </div>
								  </div>
								  </div>";
					*/?>

			  </ul>-->
					   </div>
                  <!--<div class="box-footer">
                    <label id="message"></label>
                  </div>-->
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
   
     <!-- Invite Super Administr -->
	<script type="text/javascript">
		$(function() {
			$('#msgdiv').delay(1000).hide(1000);
		});
		function submitForm(test) {
			if(test!='')
				document.getElementById("getQustionform").submit();
		}
		function createQues(){
			window.location = "createQuestion.php";
		}
		$('#tbl-question-list').DataTable( {    } );
	</script>
   </body>
  </html>    

