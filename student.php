<?php  session_start();?>
<style type="text/css">
	.col-md-1
	{
    margin-bottom: 2%;
    width: 14.333 %!important;
}

    /* Absolute Center Spinner */
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
	require_once 'include/course.php';
    $courseObject = new Course(SERVER_API_KEY);
  	$data = $courseObject->getAllCourse(0);
	$page=@$_GET['page'];
	if($page=='')
		$page=1;
	$course=@$_GET['course'];
	if($course=='')
		$course=0;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>RIIT|ADD Student</title>
<?php include("link.php"); ?>
</head>
  <body class="skin-blue sidebar-mini">
  <div class="loading">Loading&#8230;</div>
    <div class="wrapper">

     <?php include('header.php');?>
      <?php include('sidemenu.php');?>

      <div class="content-wrapper">
        <section class="content">
          <!--ADD BUTTON AT THE TOP-->
              <button type="submit" class="btn btn-block btn-primary btn-lg" data-toggle="modal" data-target="#myModal1" style="width:auto;margin: 0 1% 1% 0; float:left;" > Add <i class="fa fa-graduation-cap"></i></button>
              <button type="submit" class="btn btn-block btn-primary btn-lg" data-toggle="modal" onclick="$('#myModal2').show()" style="width:auto;margin: 0 1% 1% 0; float:left;" > Import Student List <i class="fa fa-file-excel-o "></i></button>
              <a href="export-student-list.php" class="btn btn-block btn-primary btn-lg"  style="width:auto;margin: 0 1% 1% 0; float:left;" > Export Student List <i class="fa fa-file-excel-o"></i></a>
              <div style="clear:both" ></div>
               <!-- Modal1 Add -->
           <div class="modal fade" id="myModal1" role="dialog">
             <div class="modal-dialog">
               <div class="modal-content">
                 <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" onclick="javascript:window.location.reload()">&times;</button>
                   <h4 class="modal-title"> Add Student</h4>
                 </div>
                 <div class="modal-body" >
                  <div class="row">
                   <form role="form" action="api/student/index.php/addStudent" enctype="multipart/form-data" method="post" onkeypress="return event.keyCode != 13;">
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
                      	 <label for="exampleInputEmail1">Student Id</label>
                      	 <input type="text" class="form-control" name="studentid" maxlength=50 id="studentid" onkeypress='return removespace(event)' placeholder="Enter Student Id" required>
                      </div>
                      <div class="form-group">
                      	 <label for="exampleInputEmail1">First Name</label>
                      	 <input type="text" class="form-control" name="firstName" maxlength=50 id="firstName" onkeypress='return alpha(event);return removespace(event)' placeholder="Enter First Name" required>
                      </div>
						<div class="form-group">
                      	 <label for="exampleInputEmail1">Last Name</label>
                      	 <input type="text" class="form-control" name="lastName" maxlength=50 id="lastName" onkeypress='return alpha(event);return removespace(event)' placeholder="Enter Last Name" required>
                      </div>
					  <div class="form-group">
                      	 <label for="exampleInputEmail1">Photo</label>
                      	 <input type="file" name="photo" id="photo" >
                      </div>
						<div class="form-group">
                      	 <label for="exampleInputEmail1">Address</label>
                      	 <textarea class="form-control" name="address" id="address" onkeypress='return removespace(event)' placeholder="Address" required></textarea>
                      </div>
						<div class="form-group">
                      	 <label for="exampleInputEmail1">Email</label>
                      	 <input type="email" class="form-control" name="email" onkeypress='return removespace(event)' id="email" onblur="checkDupStud(this.value)" placeholder="Email" required>
                      </div>
						<div class="form-group">
                      	 <label for="exampleInputEmail1">Phone No</label>
                      	 <input type="text" class="form-control" name="phone" id="phone" onkeypress="return removespace(event);return isNumberKey(event)"  placeholder="Phone" required>
                      </div>
                        <input type="hidden" class="form-control" name="attendance" id="attendance" placeholder="Attendance" value="">
						<!--<div class="form-group">
                      	 <label for="exampleInputEmail1">Attendance per month</label>
                      	 <input type="text" class="form-control" name="attendance" id="attendance" onkeypress='return removespace(event)' placeholder="Attendance" required>
                      </div>-->


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

            <div class="modal fade in" id="myModal2" aria-hidden="false" role="dialog" style="display: none;">
                <div class="modal-dialog" style="margin-top:12%">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" style="outline:none" onclick="closeimportpanel();">&times;</button>
                            <h4 class="modal-title"> Import Student List  </h4>
                        </div>
                        <div class="modal-body" >
                            <div class="row">

                                    <div class="box-body">

                                        <div class="form-group">
                                            <div class="studentimportformpanel">
                                                <div class="col-md-8">
                                                    <input type="file" name="excelfile" id="excelfile" accept="application/vnd.ms-excel" >
                                                    <div class="input-error" style="color:red; font-style: oblique;"></div>
                                                </div>
                                                <div class="col-md-4">

                                                    <button type="button" class="btn btn-primary pull-right" onclick="uploadstudentlist()"> Upload File</button>
                                                 </div>
                                            </div>
                                            <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/xlsx.js"></script>
                                            <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/jszip.js"></script>
                                            <script type="text/javascript">
                                                function closeimportpanel()
                                                {
                                                    $('#myModal2').hide();
                                                    $("#excelfile").val('');
                                                    $('#excelfile').parent().find(".input-error").html('');
                                                    $('#myModal2 .studentimportresultpanel').hide();
                                                    $('#myModal2 .studentimportresultpanel').hide();
                                                    $('#myModal2 .studentimportresultpanel').html("<div style='color: #1ea58b; position: relative; left: 43%;'> <i class='fa fa-spinner fa-spin fa-4x' aria-hidden='true'></i><div>Processing ...</div></div>")
                                                    $('#myModal2 .studentimportformpanel').show();
                                                }
                                                var uploadstudentlist = function()
                                                {
                                                    var flag=false;
                                                    var errorRecords=[];
                                                    $('#excelfile').parent().find(".input-error").html('');

                                                    var file = $('#excelfile')[0].files[0];
                                                    if(file)
                                                    {
                                                        var name=file.name;
                                                        var ext=name.split(".");

                                                        if(ext[1].toLowerCase()!="xls" )
                                                        {
                                                            $('#excelfile').parent().find(".input-error").html('Only .xls [Excel 97-2003 Workbook] file is allowed. <br /> Please refer template.');
                                                            flag=true;
                                                        }
                                                    }

                                                    if(!flag)
                                                    {
                                                        $(".studentimportformpanel").hide();
                                                        $(".studentimportparsepanel").show();
                                                        filePicked();
                                                    }

                                                    function filePicked() {
                                                        // Get The File From The Input
                                                        var oFile = $('#excelfile')[0].files[0];
                                                        var sFilename = oFile.name;
                                                        // Create A File Reader HTML5
                                                        var reader = new FileReader();

                                                        // Ready The Event For When A File Gets Selected
                                                        reader.onload = function(e) {
                                                            var data = e.target.result;
                                                            var cfb = XLS.CFB.read(data, {type: 'binary'});
                                                            var wb = XLS.parse_xlscfb(cfb);
                                                            // Loop Over Each Sheet
                                                            wb.SheetNames.forEach(function(sheetName) {
                                                                // Obtain The Current Row As CSV
                                                                var sCSV = XLS.utils.make_csv(wb.Sheets[sheetName]);
                                                                var jsonObj = XLS.utils.sheet_to_row_object_array(wb.Sheets[sheetName]);

                                                                if(jsonObj.length==0)
                                                                {
                                                                    $("#excelfile").parent().find(".input-error").html('No record found!');
                                                                    $(".studentimportparsepanel").hide();
                                                                    $(".studentimportresultpanel").hide();
                                                                    $(".studentimportformpanel").show();
                                                                    return false;

                                                                }
                                                                var errFlag=false;
                                                                for(var i=0;i<jsonObj.length;i++)
                                                                {
                                                                   // console.log(jsonObj[i]);
                                                                    if(jsonObj[i].StudentId==undefined || jsonObj[i].Course==undefined || jsonObj[i].FirstName==undefined
                                                                        || jsonObj[i].LastName==undefined || jsonObj[i].Address==undefined)
                                                                    {
                                                                          errFlag=true;
                                                                          errorRecords.push(i+2);
                                                                    }

                                                                }
                                                                if(errFlag)
                                                                {
                                                                    $(".studentimportformpanel").show();
                                                                    $(".studentimportparsepanel").hide();
                                                                    $("#excelfile").parent().find('.input-error').html("Mandatory fields are missing at " + errorRecords.toString()+" record(s).");
                                                                }
                                                                else
                                                                {
                                                                    $(".studentimportparsepanel").hide();
                                                                    $(".studentimportresultpanel").show();

                                                                    formData = new FormData();
                                                                    formData.append("excelfile", file);

                                                                    $.ajax({
                                                                        url:'api/student/index.php/importStudents',
                                                                        type:'POST',
                                                                        data:formData,
                                                                        dataType: 'JSON',
                                                                        cache:false,
                                                                        processData:false,
                                                                        contentType: false,
                                                                        success:function(response){
                                                                           $('.studentimportresultpanel').html(response.responseText);
                                                                        },
                                                                        error:function(response)
                                                                        {
                                                                            $('.studentimportresultpanel').html(response.responseText);
                                                                            //console.log(response);
                                                                        }
                                                                    });

                                                                }
                                                                console.log(jsonObj)
                                                            });
                                                        };
                                                        reader.readAsBinaryString(oFile);
                                                    }

                                                    }
                                            </script>
                                            <div class="clearfix"></div>
                                            <div class="row studentimportresultpanel"  style="display:none;">
                                                <div style="color: #1ea58b; position: relative; left: 43%;">
                                                <i class="fa fa-spinner fa-spin fa-4x" style="" aria-hidden="true"></i>
                                                    <div>Processing ...</div>
                                                </div>

                                            </div>
                                            <div class="row studentimportparsepanel"  style="display:none;">
                                                <div style="color: #1ea58b; position: relative; left: 43%;">
                                                    <i class="fa fa-spinner fa-spin fa-4x" style="" aria-hidden="true"></i>
                                                    <div>Parsing File ...</div>
                                                </div>

                                            </div>

                                        </div>


                                    </div><!-- /.box-body -->
                                    <div class="box-footer">
                                        <a href="templates/student-list-upload.xls">Click here to download template</a>
                                    </div>
                                </form>

                            </div>
                        </div>  <!--modal body -->

                    </div> <!--modal-content-->
                </div> <!--modal-dialog-->
            </div>  <!--modal fade-->

            <div class="row">
              <div class="col-xs-12">
                <div class="box">
                  <div class="box-header">
                    <h3 class="box-title">Student Management </h3>
                  </div><!-- /.box-header -->
                <div class="box-body">
					<div class="form-group">
						<form role="form" action="api/student/index.php/getCourseStudent"  method="POST" id="getStudentform">

							  <select name="course" id="course" class="form-control" onchange="submitForm()" required>
							  <option value='' style="width:50%;">Select Course</option>
							 	<?php for($i=0;$i<count($data);$i++){?>
										   <option value='<?php echo $data[$i]->course_id?>' <?php if(isset($_GET['course'])  && $data[$i]->course_id==$_GET['course']) {echo "selected='selected'"; }?> ><?php echo $data[$i]->course_name?></option>
								   <?php }?>
						  </select>
							<input type="hidden" name="page" value="<?php echo $page;?>"/>
						</form>
                      	</div>
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
                  <table class="table table-bordered table-hover " id="tbl-student-list">

                   <thead>
                       <tr>
                       <th>Student Id</th>
                       <th>First Name</th>
											 <th>Last Name</th>
                       <th>Email</th>
                       <th>Phone</th>
                       <th>Course</th>
                       <th>Password</th>
                       <th style="text-align:center">Action </th>


                      </tr>
                    </thead>

                   <tbody>
                      <?php

                       require_once 'include/student.php';
                       require_once 'include/course.php';
                       $studObject = new Student(SERVER_API_KEY);
                       $courseObject = new Course(SERVER_API_KEY);

//                       $data = $studObject->getAllStudents($page);
                         $data = $studObject->getCourseWiseStudentList($_GET['course']);
						$countOfRole = count($data);
                       $count = $studObject->GetCountOfStudents();
                      for($i=0;$i<$countOfRole;$i++)
                      {
                          $courseResult=$courseObject->getData(TABLE_COURSE,array('course_name'),array('course_id'=>$data[$i]->course),'')

                      ?>
                    <tr>
             <td style="width:10%"><?=$data[$i]->student_id?></td>
             <td style="width:10%"><?=$data[$i]->first_name?></td>
							<td style="width:10%"><?=$data[$i]->last_name?></td>
						 <td style="width:10%"><?=$data[$i]->email?></td>
						 <td style="width:10%"><?=$data[$i]->phone?></td>
						 <td style="width:10%"><?=$courseResult[0]->course_name?></td>
						 <?php require_once 'include/Utils.php';?>
						 <td style="width:10%"><?php echo Utils::decode($data[$i]->password);?></td>

                        <td style="width: 30%;">
                          	<div class='col-md-3' style="margin:auto;margin-right: 4px;padding: 0;">
                                 <a href="UpdateStudent.php?id=<?php echo "".$data[$i]->id;  ?>&page=<?php echo $page?>" data-toggle='modal' data-target='#theModal<?php echo "".$data[$i]->id;  ?>' type='button' style="width:100%" class='btn  btn-warning'> Edit</a>
                                 <div class="modal fade text-center" id="theModal<?php echo "".$data[$i]->id;  ?>">
                                 <div class="modal-dialog">
                                         <div class="modal-content">
                                    </div>
                                </div>
                              </div></div>
                      <?php if ($data[$i]->isEnabled == 1) { ?>
                            	<div class='col-md-3' style="margin:auto;margin-right: 4px;padding: 0;">
                                <a onclick=" return confirm(' Are You Sure' )" style="width:100%" class="btn btn-primary" href="api/student/index.php/updateStudStatus/<?php echo "".$data[$i]->id;  ?>/0/<?=$page?>/<?=$course?>/1">
                                Deactivate</a>
                          </div>
                      <?php }else{ ?>
                            	<div class='col-md-3' style="margin:auto;margin-right: 4px;padding: 0;">
                                <a onclick=" return confirm(' Are You Sure' )"  style="width:100%"
                                class="btn btn-info" href="api/student/index.php/updateStudStatus/<?php echo "".$data[$i]->id; ?>/1/<?=$page?>/<?=$course?>/1">
                                 Activate </a>
                          </div>
                    <?php } ?>
                             	<div class='col-md-3' style="margin:auto;margin-right: 4px;padding: 0;">
                                <a onclick=" return confirm(' Are You Sure' )" style="width:100%" class="btn btn-danger" href="api/student/index.php/deleteStudent/<?php echo "".$data[$i]->id;  ?>/<?=$page?>/<?=$course?>/1">
                                 Delete</a>
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
                      <a href='".URL."student.php?page=".$prev."' aria-controls='example03' data-dt-idx='0' tabindex='0'>Previous</a>
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
         echo "<li class='page-item ".$actp."'><a class='page-link' href='".URL."student.php?page=".$i."'> {$i}</a></li> ";
        }

        if($endPage1==3) echo " <li class='page-item'><a class='page-link' href='".URL."student.php?page=".$i."'>...</a></li> ";
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
         echo "<li class='page-item ".$actp."'><a class='page-link' href='".URL."student.php?page=".$i."'> {$i}</a></li> ";
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
                      <a   href='".URL."student.php?page=".$nxt."' aria-controls='example03' data-dt-idx='2' tabindex='0'>Next</a>
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

      <div class="control-sidebar-bg"></div>
 <?php include("footer.php");?>

     <!-- Invite Super Administr -->
    <script type="text/javascript">
        $('#tbl-student-list').DataTable( {    } );

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
        function submitForm() {
            document.getElementById("getStudentform").submit();
        }

        $(document).ready(function(){ $(".loading").hide(); });
    </script>
   </body>
  </html>
