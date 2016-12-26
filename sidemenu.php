<?php
  @session_start();
 //include("config.php");
?>
      <aside class="main-sidebar" >
        <section class="sidebar" style="">

 <ul class="sidebar-menu" >
<li <?php if(basename($_SERVER['PHP_SELF'])=="dashboard.php") { echo "class='active'"; }?>>
    <a href="dashboard.php">
    <i class="fa fa-dashboard"></i><span>Dashboard</span>
</a>
</li>
<?php if($_SESSION['user_type']==3){?>
 <li  data-toggle="collapse" data-target="#demo" <?php if( in_array(basename($_SERVER['PHP_SELF']),array("top-scorers-report.php","bottom-scorers-report.php","average-score-report.php","average-score-report.php","student-trend-report.php","trending-report.php"))) { echo "class='active'"; }?>>

 <a style="color: #b8c7ce;padding: 0px 7px 0px 15px; cursor:pointer;"><i class="fa fa-dashcube"></i><span>Reports</span>
 </a>
 <ul id="demo" class="collapse <?php if( in_array(basename($_SERVER['PHP_SELF']),array("top-scorers-report.php","bottom-scorers-report.php","average-score-report.php","average-score-report.php","student-trend-report.php","trending-report.php"))) { echo " in"; }?>" style="list-style: none;">
    <li  >
        <a href="top-scorers-report.php" style=" <?php if(basename($_SERVER['PHP_SELF'])=="top-scorers-report.php") { echo "color:#E2FFFF !important;"; }?>">
        <span>Top 25 Scorers</span>
        </a>
     </li>
     <li>
         <a href="bottom-scorers-report.php" style=" <?php if(basename($_SERVER['PHP_SELF'])=="bottom-scorers-report.php") { echo "color:#E2FFFF !important;"; }?>">
         <span>Bottom 25 Scorers</span>
         </a>
     </li>
     <li>
        <a href="average-score-report.php" style=" <?php if(basename($_SERVER['PHP_SELF'])=="average-score-report.php") { echo "color:#E2FFFF !important;"; }?>">
        <span>Average Score</span>
        </a>
     </li>
    <li  id="demo" class="collapse">
          <a href="student-wise-report.php" style=" <?php if(basename($_SERVER['PHP_SELF'])=="student-trend-report.php") { echo "color:#E2FFFF !important;"; }?>">
             <span>Student Wise</span>
            </a>
    </li >
    <li>
        <a href="student-trend-report.php" style=" <?php if(basename($_SERVER['PHP_SELF'])=="student-trend-report.php") { echo "color:#E2FFFF !important;"; }?>">
        <span>Student Trend</span>
         </a>
    </li>
     <li>
        <a href="trending-report.php" style=" <?php if(basename($_SERVER['PHP_SELF'])=="trending-report.php") { echo "color:#E2FFFF !important;"; }?>">
         <span>Trending</span>
         </a>
    </li>
    <li  id="demo" class="collapse">
        <a href="best-scorers-report.php">
        <span>Best Scorers</span>
         </a>
    </li>
</ul>


</li>
<li <?php if(basename($_SERVER['PHP_SELF'])=="field.php") { echo "class='active'"; }?>>
     <a href="field.php">
        <i class="fa fa-dashcube"></i><span>Institute Management</span>
      </a>
</li>
<li <?php if(basename($_SERVER['PHP_SELF'])=="course.php") { echo "class='active'"; }?>>
     <a href="course.php">
      <i class="fa fa-dashcube"></i><span>Course Management</span>
    </a>
</li>
<li <?php if(basename($_SERVER['PHP_SELF'])=="subject.php") { echo "class='active'"; }?>>
  <a href="subject.php">
    <i class="fa fa-dashcube"></i><span>Subject Management</span>
  </a>
</li>
<li <?php if(basename($_SERVER['PHP_SELF'])=="topic.php") { echo "class='active'"; }?>>
  <a href="topic.php">
      <i class="fa fa-dashcube"></i><span>Topic Management</span>
  </a>
</li>
<li <?php if(basename($_SERVER['PHP_SELF'])=="test.php") { echo "class='active'"; }?>>
  <a href="test.php">
    <i class="fa  fa-dashcube"></i><span>Test Management</span>
  </a>
</li>
<li <?php if(basename($_SERVER['PHP_SELF'])=="question.php") { echo "class='active'"; }?>>
  <a href="question.php">
    <i class="fa  fa-dashcube"></i><span>Question Management</span>
  </a>
</li>
<li <?php if(basename($_SERVER['PHP_SELF'])=="questionbank.php") { echo "class='active'"; }?>>
  <a href="questionbank.php">
      <i class="fa  fa-dashcube"></i><span>Question Bank</span>
  </a>
</li>
<li <?php if(basename($_SERVER['PHP_SELF'])=="student.php") { echo "class='active'"; }?>>
  <a href="student.php">
    <i class="fa  fa-dashcube"></i><span>Student Management</span>
  </a>
</li>
<li <?php if(basename($_SERVER['PHP_SELF'])=="syllabus.php") { echo "class='active'"; }?>>
  <a href="syllabus.php">
    <i class="fa  fa-dashcube"></i><span>Syllabus Management</span>
  </a>
</li>
<li <?php if(basename($_SERVER['PHP_SELF'])=="flashcard.php") { echo "class='active'"; }?>>
  <a href="flashcard.php">
    <i class="fa  fa-dashcube"></i><span>Flashcard Management</span>
  </a>
</li>
<li <?php if(basename($_SERVER['PHP_SELF'])=="notice.php") { echo "class='active'"; }?>>
  <a href="notice.php">
    <i class="fa  fa-dashcube"></i><span>Notice Management</span>
  </a>
</li>
  <li <?php if(basename($_SERVER['PHP_SELF'])=="parent-discussion.php") { echo "class='active'"; }?>>
      <a href="parent-discussion.php">
          <i class="fa  fa-dashcube"></i><span>Parent Discussion</span>
      </a>
  </li>
<li <?php if(basename($_SERVER['PHP_SELF'])=="result.php") { echo "class='active'"; }?>>
  <a href="result.php">
    <i class="fa  fa-dashcube"></i><span>Result</span>
  </a>
</li>
<li >
  <a href="export.php">
    <i class="fa  fa-dashcube"></i><span>Backup</span>
  </a>
</li>
  <?php }?>
<?php /*if($_SESSION['user_type']==2){*/?><!--
   <li>
      <a href="institute.php">
        <i class="fa fa-pencil"></i><span>Institute Management</span>
      </a>
 </li>
  --><?php /*}*/?>
			<!--<li>
              <a href="send_notification.php">
                <i class="fa  fa-dashcube"></i><span>Send Notification</span>
              </a>
            </li>-->

			</ul>

      </section>
  </aside>

<style type="text/css">
   body.sidebar-mini section.sidebar
   {
       max-height: 620px;
       overflow-y: scroll;
   }
   body.sidebar-collapse section.sidebar
   {

       overflow:visible;
   }
</style>

<script type="text/javascript">

function check() {

  var logout = confirm("Are you sure to logout?");

   if(logout){
     location.href = "signout.php";
 }
 }
</script>
