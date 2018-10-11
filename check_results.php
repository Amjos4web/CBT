<?php
// set session
ob_start();
session_start();
require './admin/connect.php';

if (!isset($_SESSION['user'])){
	header ('location: ./index.php');
} else {
	// set session for sessioned data
	$username = $_SESSION['user'];
}

$msg = "";
$results = "";
$counter = 1;
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
    header ('location: ./index.php');
}

// get course
// fetch out questions and answers from the database
$qryresult="SELECT * FROM result WHERE `username`='".$username."' LIMIT 30";
$qryresultcheck=$conn->query($qryresult);
if ($qryresultcheck->num_rows > 0){
  while ($row = $qryresultcheck->fetch_assoc()) {
    $id = $row['id'];
    $username = $row['username'];
    $course_title = $row['course_title'];
    $matricNo = $row['matricNo'];
    $score= $row['result'];
    //$date_taken = $row['date_taken'];
    $date_taken=strftime("%d %b, %Y %H:%M:%S",strtotime($row['date_taken']));
    $percentage = $row['percentage_score'];

    $results .= "<tr>";
    $results .= "<td><b>".$counter++. "</b></td>";
    $results .= "<td>".$date_taken. "</td>";
    $results .= "<td>".$course_title."</td>"; 
    $results .= "<td>".$score."</td>";
    $results .= "<td>".$percentage."</td>";
    $results .= "</tr>";
  }
} else {
  $msg =  "No exam history found";
}

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
          <div class="row">
            <div class="col-md-8 page-title">
              <h4 style="">Your Exams Details</h4>
              <p style="font-style: italic;">This contain all exams you have taken</p>
            </div>
            <div class="col-md-12">
              <p style="text-align: center; color: #880000; font-size: 20px;"><?php echo $msg; ?></p>
               <div style="max-height: 400px; overflow-x: auto">
                 <table class="table table-bordered" style="font-family: arial;">
                  <thead>
                    <tr class="info" style="text-transform: uppercase;">
                      <th>S/N</th>
                      <th>Date Of Exam</th>
                      <th>Course Title</th>
                      <th>Score</th>
                      <th>Percentage Score</th>
                    </tr>
                  </thead>
                  <?php echo $results; ?>
                  </table>
                </div>
            </div>
         
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