<?php  session_start();?>
<?php
    require_once 'include/student.php';

?>
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
    <title>Excellence | Parent Discussion</title>
<?php include("link.php"); ?>
</head>
  <body class="skin-blue sidebar-mini">

    <div class="wrapper">

     <?php include('header.php');?>
      <?php include('sidemenu.php');?>

      <div class="content-wrapper">
        <section class="content">


           <div class="row">
              <div class="col-xs-12">
                <div class="box">
                  <div class="box-header">
                    <h3 class="box-title"> Parent Discussion  </h3>
                      <hr />
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
                    <form role="form" method="post" action="api/student/index.php/addDiscussion">
                    <select name="student" id="student" class="form-control" required>
                        <option value="">Select Student</option>
                        <?php
                              $studentobj=new Student(SERVER_API_KEY);
                              $result=$studentobj->getData(TABLE_STUDENT,'','',array('student_id'=>'ASC'));
                              foreach ($result as $row)
                              {
                                  if(isset($_GET['Id']) && $row->student_id==$_GET['Id'])
                                      echo  "<option selected value='".$row->student_id."'>".$row->first_name." ".$row->last_name."</option>";

                                  else
                                      echo  "<option value='".$row->student_id."'>".$row->first_name." ".$row->last_name."</option>";

                              }
                        ?>
                    </select>
                    <hr />
                        <?php
                                $studentobj=new Student(SERVER_API_KEY);
                                $discussions=array();
                                if(isset($_GET['Id']))
                                {
                                    $discussions = $studentobj->getDiscussion(array("studentid" => $_GET['Id']));
                                }

                                foreach ($discussions as $row)
                                {
                                    echo "<div class='panel panel-default'>
                                          <div class='panel-heading'><b>".date('d M Y, h:i a',strtotime($row->createdon))." - Discussed points were</b></div>

                                           <div class='panel-body'>".$row->discussion."</div>
                                          </div>";
                                }
                                if(isset($_GET['Id']) && count($discussions)==0)
                                {
                                    echo "<p>No discussion available.</p>";
                                }
                                if(isset($_GET['Id'])) { echo "<hr />"; }
                         ?>

                    <textarea rows="10" class="form-control" name="discussion" id="discussion" required maxlength="5000" <?php if(!isset($_GET['Id'])){ echo "disabled"; }?> autofocus></textarea>
                    <div id="count"></div>
                    <br />
                    <button class="btn btn-primary col-md-2" type="submit" style="margin-right:20px;" <?php if(!isset($_GET['Id'])){ echo "disabled"; }?>> SAVE </button>
                    <button class="btn btn-danger  col-md-2" type="reset" <?php if(!isset($_GET['Id'])){ echo "disabled"; }?> > CANCEL </button>
                    </form>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->

        </section>
      </div>
     </div>

      <div class="control-sidebar-bg"></div>
 <?php include("footer.php");?>
    <link rel="stylesheet" type="text/css" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <script type="text/javascript" src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

    <script type="text/javascript">
        $(function() {
            $('#msgdiv').delay(1000).hide(2000);
        });


        $("#student").change(function(){
            if($(this).val().length!=0)
            {
                window.location='parent-discussion.php?Id='+$(this).val();
            }

        });



       var texteditor= $('#discussion').wysihtml5({
            events: {
                load: function() {
                    var editor = this;
                    $(editor.currentView.doc.body).on("keydown",function(event) {
                        var l = event.currentTarget.innerText.length;
                        if(l >= 5000) {
                            $('#count').html('<span class="text-danger">Total characters exceed 5000. Extra characters will not be saved.</span>');
                        } else {
                            var left = 5000 - l;
                            $('#count').html('<span class="text-info">'+ left + ' characters left ' +'</span>');
                        }
                    });
                }
            }
        });

        $("button[type=reset]").click(function(){
           $("#count").html('');
        });
      /*  $("button[type=button]").click(function(){

            $("#discussion").val('');


            //$('#discussion').data("wysihtml5").editor.clear();

            //$('#discussion').data("wysihtml5").editor.clear();
            window.location.reload();
        });*/
    </script>

     <!-- Invite Super Administr -->

   </body>
  </html>
