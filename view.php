<?php  @session_start();
     require_once 'include/question.php';
        $questionObject = new question(SERVER_API_KEY);
        $ids= $_GET['id'];
        $title = $questionObject-> selectsinglequetion($ids);
        $matter = $title[0]->question;;
?>

<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title">Question</h4>
            </div>			<!-- /modal-header -->
            <div class="modal-body">
            <p>
            	<?php
            	echo $matter;
            	?>

            </p>
            </div>			<!-- /modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>			