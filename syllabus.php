<?php  session_start();?>
<style type="text/css">
	.col-md-1
	{
    margin-bottom: 2%;
    width: 14.333 %!important;
}
</style>
<?php
	require_once 'include/course.php';
    $courseObject = new Course(SERVER_API_KEY);
  	$data = $courseObject->getAllCourse(0);

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>RIIT|ADD SYLLABUS</title>
<?php include("link.php"); ?>
</head>
  <body class="skin-blue sidebar-mini">

    <div class="wrapper">

     <?php include('header.php');?>
      <?php include('sidemenu.php');?>

      <div class="content-wrapper">
        <section class="content">
          <!--ADD BUTTON AT THE TOP-->
              <button type="submit" class="btn btn-block btn-primary btn-lg" data-toggle="modal" data-target="#myModal1" style="width:auto;margin-bottom: 1%;" > Add <i class="fa fa-graduation-cap"></i></button>
               <!-- Modal1 Add -->
           <div class="modal fade" id="myModal1" role="dialog">
             <div class="modal-dialog">
               <div class="modal-content">
                 <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" onclick="javascript:window.location.reload()">&times;</button>
                   <h4 class="modal-title"> Upload Syllabus</h4>
                 </div>
                 <div class="modal-body" >
                  <div class="row">
                   <form role="form" action="api/syllabus/index.php/addSyllabus" enctype="multipart/form-data" method="post" onkeypress="return event.keyCode != 13;">
                    <div class="box-body">
						<div class="form-group">
                       <label for="exampleInputEmail1">Select Course</label>
						  <select name="course" id="course" class="form-control" required>

							 	<?php for($i=0;$i<count($data);$i++){?>
										   <option value='<?php echo $data[$i]->course_id?>'><?php echo $data[$i]->course_name?></option>
								   <?php }?>
						  </select>
                      </div>
                      <div class="form-group">
                      	 <label for="exampleInputEmail1">Syllabus Title</label>
                      	 <input type="text" class="form-control" name="title" id="title" onkeypress='return alpha(event);return removespace(event)' placeholder="Enter Syllabus Title" required>
                      </div>
					  <div class="form-group">
                      	 <label for="exampleInputEmail1">File</label>
                      	 <input type="file" name="file[]" id="file" accept=".pdf" data-max-size="25000" required multiple>
                      </div>

                    </div><!-- /.box-body -->
                    <div class="box-footer">
                     <button type="submit" class="btn btn-primary"> Add</button>
                    </div>
                   </form>
                  <div class="box-footer">
                    <label id="message"></label>
                  </div>
               </div>
              </div>  <!--modal body -->

            </div> <!--modal-content-->
           </div> <!--modal-dialog-->
          </div>  <!--modal fade-->

           <div class="row">
              <div class="col-xs-12">
                <div class="box">
                  <div class="box-header">
                    <h3 class="box-title">Syllabus Management </h3>
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
                  <table class="table table-bordered table-hover " >

                   <thead>
                       <tr>
                       <th>Sr No</th>
                       <th>Title</th>
                        <th>Course</th>
                       <th>Action </th>
                      </tr>
                    </thead>

                   <tbody>
                      <?php
                       $page=@$_GET['page'];
						if($page=='')
							$page=1;
                       require_once 'include/syllabus.php';
                       $syllObj = new Syllabus(SERVER_API_KEY);

                       $data = $syllObj->getAllSyllabus($page);
					   $countOfRole = count($data);
                       $count = $syllObj->GetCountOfSyllabus();
				     for($i=0;$i<$countOfRole;$i++)
                      {
                      ?>
                    <tr>
                    <td><?php
                    if($page >1)
                    {
						echo (10*($page-1))+$i+1 ;
                    }
                    else
                    {
                    	echo $i+1 ;
                    }
                     ?></td>
						 <td style="width:40%"><?=$data[$i]->title?></td>
						 <td><?=$data[$i]->course_name?></td>
                    <td>
					 <div class='col-md-3'>
							 <a href="UpdateSyllabus.php?id=<?php echo "".$data[$i]->syllabus_id;  ?>&page=<?php echo $page?>" data-toggle='modal' data-target='#theModal<?php echo "".$data[$i]->syllabus_id; ?>' type='button' class='btn btn-block btn-warning'> Edit</a>
							 <div class="modal fade text-center" id="theModal<?php echo "".$data[$i]->syllabus_id;  ?>">
							 <div class="modal-dialog">
									 <div class="modal-content">
								</div>
							</div>
						  </div></div>
				  <?php if ($data[$i]->isEnabled == 1) { ?>
						<div class="col-md-3">
							<a onclick=" return confirm(' Are You Sure' )" class="btn btn-primary" href="api/syllabus/index.php/updateSyllabusStatus/<?php echo "".$data[$i]->syllabus_id;  ?>/0/<?=$page?>">
							Deactivate</a>
						</div>
				  <?php }else{ ?>
						<div class="col-md-3">
							<a onclick=" return confirm(' Are You Sure' )"  style="width:78px"
							class="btn btn-info" href="api/syllabus/index.php/updateSyllabusStatus/<?php echo "".$data[$i]->syllabus_id; ?>/1/<?=$page?>?>">
							 Activate </a>
						</div>
				<?php } ?>
						<div class="col-md-3">
							<a onclick=" return confirm(' Are You Sure' )" class="btn btn-danger" href="api/syllabus/index.php/deleteSyllabus/<?php echo "".$data[$i]->syllabus_id;  ?>/<?=$page?>">
							 Delete</a>
						</div>
                    </td>

                      </tr>
                      <?php } ?>
                    <tr>

                    </tr>
                    </tbody>

                  </table>
					      <ul class="pagination">
            <?php

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
                      <a href='".URL."syllabus.php?page=".$prev."' aria-controls='example03' data-dt-idx='0' tabindex='0'>Previous</a>
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
         echo "<li class='page-item ".$actp."'><a class='page-link' href='".URL."syllabus.php?page=".$i."'> {$i}</a></li> ";
        }

        if($endPage1==3) echo " <li class='page-item'><a class='page-link' href='".URL."syllabus.php?page=".$i."'>...</a></li> ";
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
         echo "<li class='page-item ".$actp."'><a class='page-link' href='".URL."syllabus.php?page=".$i."'> {$i}</a></li> ";
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
                      <a   href='".URL."syllabus.php?page=".$nxt."' aria-controls='example03' data-dt-idx='2' tabindex='0'>Next</a>
                      </li>
                      </ul>
                      </div>
                      </div>
                      </div>";
        ?>

  </ul>
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
	   function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
		function checkDupStud(email){
			if(email!=''){
				$.ajax({
						type : "POST",
						url : "api/student/index.php/checkDuplicate",
						data : {email:email},
						success : function(response) {
							if(response==1){
								$('#email').addClass('errormsg');
								document.getElementById("email").value = "";
								$('#email').attr("placeholder", "Email Id already exists.");
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
      <div class="control-sidebar-bg"></div>
 <?php include("footer.php");?>

     <!-- Invite Super Administr -->

   </body>
  </html>
