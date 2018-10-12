<?php
// set session
session_start();
require './admin/connect.php';

if (!isset($_SESSION['email'])){
	header ('location: ./index.php');
} else {
	// set session for sessioned data
	$email = $_SESSION['email'];
}

// fetch out data for sessioned user
$qry="SELECT * FROM admin WHERE email='".$email."' LIMIT 1";
$qrycheck=$conn->query($qry);
if ($qrycheck->num_rows > 0){
    while($fetch = $qrycheck->fetch_assoc()){
        $fullname=$fetch['fullname'];
        $email=$fetch['email'];
        $last_log_date=$fetch['last_log_date'];
        $log_date=strftime("%d %b, %Y %H:%M:%S",strtotime($fetch['last_log_date']));

    }
} else {
    echo "No user data found";
}

$results = "";
$counter = 1;
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
                      <h2>Welcome! Admin - <?php echo $fullname . " " . "(" . $email. ")"; ?></h2>
                      <p>What do you want to do today?</p>
                      <p style="font-weight: bold; font-style: initial; color: #880000; font-family: cursive;">Last Log date: <?php echo $log_date; ?></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="cta-btn">
                      <a href="admin_logout.php" class="btn btn-info">Log Out</a>
                      <a href="admin_dashboard.php" class="btn btn-info">Go back <<<</a>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section><br>
    <div class="container">
      <div class="row centered">
        <div class="col-md-6">
          <h3 style="text-align: center;">Search By Course</h3>
          <div class="form-group">
            <form action="" method="GET">
              <select name="search_by_course" class="form-control">
                <option value="Null">Select Course</option>
                <option value="course001">Course 001</option>
                <option value="course002">Course 002</option>
                <option value="course003">Course 003</option>
                <option value="course004">Course 004</option>
              </select><br>
              <div class="col-md-12 text-center">
                <input type="submit" name="search" class="btn btn-default" value="Search">
              </div>
            </form>
          </div>
        </div>
      </div><br>
      <?php
        if (isset($_GET['search']))
        {
          // get inputed values
          $course = $_GET['search_by_course'];
          // check if all field is not empty
          if (empty($course) == false)
          {
            if($_GET['search_by_course'] == "course001"){
              require_once "includes/select_query.php";
            } else if ($_GET['search_by_course'] == "course002"){
              require_once "includes/select_query.php";
            } else if ($_GET['search_by_course'] == "course003"){
              require_once "includes/select_query.php";
            } else if ($_GET['search_by_course'] == "course004"){
              require_once "includes/select_query.php";
            } else if ($_GET['search_by_course'] == "Null"){
              echo '<script type="text/javascript">';
              echo 'setTimeout(function () { 
              swal({
                title: "Error!",
                text: "Please Select Course",
                type: "warning",
                confirmButtonText: "OK"
              },
              function(isConfirm){
                if (isConfirm) {
                  window.location.href = "edit_questions.php";
                }
              }); }, 500)';
              echo '</script>';
            } 
          } else {
            echo '<script type="text/javascript">';
            echo 'setTimeout(function () { 
            swal({
              title: "Error!",
              text: "Please Select Course",
              type: "warning",
              confirmButtonText: "OK"
            },
            function(isConfirm){
              if (isConfirm) {
                window.location.href = "edit_questions.php";
              }
            }); }, 500)';
            echo '</script>';
          }
        }

?>
</div>
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