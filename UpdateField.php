<?php

  require_once 'include/field.php';
  require_once 'include/Config.php';
 if(isset($_GET['page']))
	  $page=$_GET['page'];
  else
	  $page=1;
  $id =$_GET['id'];
  $where['field_id']=$id;
  $field = new Field();
  $value=$field->getField($where);
//print_r($value);die;
?>  <script type="text/javascript">
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
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" onclick="javascript:window.location.reload()">&times;</button>
       <h4 class="modal-title">Update Institute Name</h4>
    </div>
<div class="modal-body">

       <div class="row">
                   <form role="form" action="api/field/index.php/updateField" method="post" id="" >
                    <div class="form-group" style="width:100%; height:8%">
                       <label for="exampleInputEmail1" style="width:30%; float:left" >Institute Name</label>
                       <input type="text" maxlength=50 style="width:65%; float:left" class="form-control" id="fieldEdit" name="field" placeholder="Field" onblur="checkDupField(this.value,'<?php echo $id; ?>')" value="<?php echo $value[0]->field_name; ?>">
                      </div>
						  <input type="hidden" name="id" value="<?php echo $id; ?>">
						  <input type="hidden" name="page" value="<?php echo $page; ?>">

                    <!-- /.box-body -->


                      <input type="submit" name="submit" value="Update" class="btn btn-primary">

                   </form>

               </div>


</div>
<script type="text/javascript">
		function checkDupField(field,id){
		$.ajax({
				type : "POST",
				url : "api/field/index.php/checkDuplicateEdit",
				data : {field:field,id:id},
				success : function(response) {
					if(response==1){
						$('#fieldEdit').addClass('errormsg');
					 	document.getElementById("fieldEdit").value = "";
						$('#fieldEdit').attr("placeholder", "Field already exists.");
						return false;
					}
				}
			});

		}
</script>
