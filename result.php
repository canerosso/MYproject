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
    <title>Excellence| Test Result</title>
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
                       		<label for="exampleInputEmail1">Select Test</label>
							  <select name="test" id="test" onchange="getTestResult(this.value)" class="form-control" required>
								  <option value=''>Select Test</option>
									<?php for($i=0;$i<count($data);$i++){?>
											   <option value='<?php echo $data[$i]->test_id?>'><?php echo $data[$i]->title?></option>
									   <?php }?>
							  </select>
							<input type="hidden" name="page" value="<?php echo $page;?>"/>
                      	</div>
					
                    </div><!-- /.box-body -->
                   </form>
					   <div id="table">
						  <table class="table table-bordered table-hover " >

						   <thead>
							   <tr>
								   <th>Sr No</th>
								   <th>Student Name</th>
								   <th>Test</th>
							   	   <th>Marks (In %) </th>
								</tr>
							</thead>


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
   <script type="text/javascript">
	   $(function() {
			$('#msgdiv').delay(1000).hide(1000); 
		});
		 function getTestResult(test_id) {
			 
			 $.ajax({
					type : "POST",
					url : "api/test/index.php/getTestResult",
					data : {test_id:test_id,pdf:0},
					success : function(response) {
						$('#table').html(response);
                        //console.log(response);
					}
				});
		}
	    function getPdf(test_id) {
			 
			 $.ajax({
					type : "POST",
					url : "api/test/index.php/getTestResult",
					data : {test_id:test_id,pdf:1},
					success : function(response) {
						alert('PDF generated successfully..');
                        //console.log(response);
					}
				});
		}
	    function createQues(){
				window.location = "createQuestion.php";
		}
</script>
      <div class="control-sidebar-bg"></div>
 <?php include("footer.php");?>
   
     <!-- Invite Super Administr -->
  
   </body>
  </html>    

