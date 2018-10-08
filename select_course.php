<?php
// set session
session_start();
require './admin/connect.php';

if (!isset($_SESSION['user'])){
	header ('location: ./index.php');
} else {
	// set session for sessioned data
	$username = $_SESSION['user'];
}

$quizpack = "";
// fetch out data for sessioned user
$qry="SELECT * FROM student WHERE username='".$username."' LIMIT 1";
$qrycheck=$conn->query($qry);
if ($qrycheck->num_rows > 0){
    while($fetch = $qrycheck->fetch_assoc()){
        $fullname=$fetch['fullname'];
        $username=$fetch['username'];
        $dept=$fetch['dept'];
        $last_log_date=$fetch['last_log_date'];
        $id=$fetch['id'];
        $log_date=strftime("%d %b, %Y %H:%M:%S",strtotime($fetch['last_log_date']));

    }
} else {
    echo "No user data found";
}

// get course
$course1 = "course001";
$course2 = "course002";
$course3 = "course003";
$course4 = "course004";
$page = 1;

?>
<?php include "./includes/header.php"; ?>
<body>
<div class="container-fluid">
   <div class="row">
    <div class="col-md-12 header">
      <h2 class="headtext">Online Examination Processing System</h2>
    </div>
</div>
<section id="callaction" class="home-section paddingtop-20">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="callaction bg-gray">
              <div class="row">
                <div class="col-md-8">
                    <div class="cta-text">
                      <h2>Welcome! <?php echo $fullname . " " . "(" . $username. ")"; ?></h2>
                      <p style="font-weight: bold; font-style: initial; color: #880000; font-family: cursive;">Last Log date: <?php echo $log_date; ?></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="cta-btn">
                      <a href="logout.php" class="btn btn-info">Log Out</a>
                      <a href="user_dashboard.php" class="btn btn-info">Go back <<<</a>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section id="callaction" class="home-section paddingtop-20">
      <div class="col-md-12">
        <div class="container">
               <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#accordion" id="collapseaccordion" href="#collapse1">
                  Select Course (Choose from the options below to proceed)</a>
                  </h4>
                </div>
                <div id="collapse1" class="panel-collapse">
                  <div class="panel-body">
                    <div class="col-md-12">
                      <div class="course-links">
                        <li><a href='quiz001.php?course_title=<?php echo $course1; ?>'>Course 001</a></li><br>
                        <li><a href='quiz002.php?course_title=<?php echo $course2; ?>'>Course 002</a></li><br>
                        <li><a href='quiz003.php?course_title=<?php echo $course3; ?>'>Course 003</a></li><br>
                        <li><a href='quiz004.php?course_title=<?php echo $course4; ?>'>Course 004</a></li><br>
                      </div>
                    </div>
                </div>
                </div>
                </div>
             </div>
        <div class="col-md-12">
         
          </div>
      </div>
    </div>
    </section>
<div class="row">
<div class="col-md-12 footer">
<div class="col-md-3">

</div>
<div class="col-md-6">
  <div class="footertext">
    <p style="font-size: 13px; font-family: arial;"><a rel="license" href="http://creativecommons.org/licenses/by-nc/4.0/" style="color: #000000;"><img alt="Creative Commons License" style="border-width:0" src="images/nc.png" /></a><br />This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc/4.0/">Creative Commons Attribution-NonCommercial 4.0 International License</a></p>
 Powered by Amjos &copy; 2018. All Right Reserved
  </div>
 </div>
 <div class="col-md-3">
 </div>
</div>
</div>


</div>
</body>
</html>