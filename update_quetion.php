
<?php  @session_start();
     require_once 'include/question.php';
        $questionObject = new question(SERVER_API_KEY);
        $ids= $_GET['id'];
        $data = $questionObject-> selectquetion($ids);
          // echo'<pre>';
          // print_r($data);
          // echo'<pre>';

       $count =count($data);


?>
<style type="text/css">

  .form-inline .form-control {
    display: inline-block;
    vertical-align: middle;
    width: 100%!important;
}
</style>


                 <div class="modal-dialog">
               <div class="modal-content">
                 <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" onclick="javascript:window.location.reload()">&times;</button>
                   <h4 class="modal-title"> Update  Question To Topic For <?php echo $Subjectname; ?></h4>
                 </div>
                 <div class="modal-body" >
               <div class="box-body" >
                  <div class="row">
                   <form role="form" action="api/question/index.php/updatequestion" method="post" id="inviteUser">

                      <div class="form-group" style="width:100%;">
                       <label for="exampleInputEmail1">Question</label>
                        <input type="text" required class="form-control" name="question" placeholder="question"  value="<?php echo $data[0]->question; ?>" title="char and number allowed">

                       <?php for ($i=0; $i <$count ; $i++) {
                         # code...
                       ?>
                         <br/><label for="exampleInputEmail1">Option-<?php echo $i+1;?></label>
                        <input type="text" class="form-control" name="options[]" value="<?php echo $data[$i]->choice; ?>" placeholder="Option" <?php if($i<4) { echo "required"; }?>>
                          <input type="hidden" name="choice_id[]" value="<?php echo $data[$i]->choice_id; ?>" >
                          <br/><input type="radio" name="istrue<?php echo $i+1;?>" value="1" <?php if($data[$i]->is_right==1) {?> checked="checked" <?php } ?> required> True <input type="radio" name="istrue<?php echo $i+1;?>" value="0" <?php if($data[$i]->is_right==0) {?> checked="checked" <?php } ?>  required> Flase<br>
                     <?php }?>
                      <input type="hidden" value="<?php echo $_GET['id']; ?>" name='id'>
                       <input type="hidden" value="<?php echo $data[0]->topic_id; ?>" name='cat_id'>

                       <input type="hidden" value="<?php echo $_GET['prev']; ?>" name='prev'>
                       <br/>
                          <label for="exampleInputEmail1">Hint</label>
                        <input type="text" class="form-control" name="hint" value="<?php echo $data[0]->hint; ?>" placeholder="Use...">


                         </div>

                         <div class="box-footer">
                     <button type="submit" class="btn btn-primary"> Update</button>
                    </div>
                   </form>

                   </div>



                  <div class="box-footer">
                    <label id="message"></label>
                  </div>
               </div>
              </div>  <!--modal body-->

             </div>
           </div>
           </div>
         </div>
         </div>
