<?php
// set session
session_start();
ob_start();
require './admin/connect.php';

if (!isset($_SESSION['user'])){
	header ('location: ./index.php');
} else {
	// set session for sessioned data
	$username = $_SESSION['user'];
}

$quizpack = "";
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
        $matricNo=$fetch['matricNo'];
        $log_date=strftime("%d %b, %Y %H:%M:%S",strtotime($fetch['last_log_date']));

    }
} else {
    echo "No user data found";
}

$course_title = $_SESSION['course_title'];


// fetch out questions and answers from the database
$qryquestions="SELECT * FROM questions WHERE `course_title`='".$course_title."' LIMIT 10";
$qryquestionscheck=$conn->query($qryquestions);
foreach ($qryquestionscheck as $row){
  $id = $row['id'];
  $questions = $row['questions'];
  $optionA = $row['option_A'];
  $optionB = $row['option_B'];
  $optionC= $row['option_C'];
  $optionD = $row['option_D'];
  $answer = $row['answer'];
 }


//check and compare anwsers
if (isset($_POST['submit'])){
  /*?><script type="text/javascript">
    var confirmSubmit = confirm ('Are you of submitting this exam?');
    if (confirmSubmit == true){
        </script><?php*/
        $option_array = $_POST['option'];
        $each_question_correct_answer = $_POST["correct_answer"];
        //echo json_encode($each_question_correct_answer).'<br/>';
        //convert answers to string
        $each_question_correct_answer_string = implode(',', $each_question_correct_answer);
        //echo $each_question_correct_answer_string . '<br>';

        if (empty($option_array) == false){
          //convert answers back to array
          
          $correct_answer_array = explode(",", $each_question_correct_answer_string);
          //echo json_encode($correct_answer_array).'<br/>';
          $answered=0;
          $unanswered=0;
          if ($_POST['option'] == ""){
            $unanswered++;
          } elseif ($_POST['option'] !== "") {
            $answered++;
          }
          //use array_intersect to check for corresponding answers
          $result= array_intersect_assoc($correct_answer_array,$option_array);
          $resultcount = count($result);
          $noOfQuestions = "10";
          $wrongAnswers = $noOfQuestions - $resultcount;
          //echo $resultcount;
          //exit();

          $date_taken = date('Y-m-d:h:i:s');

          // performance
          if ($resultcount >= "7"){
            $performance = "Excellent";
          } else if ($resultcount >= "5") {
            $performance = "Good";
          } else if ($resultcount <= "4") {
            $performance = "Poor";
          }

          $insertresult = "INSERT INTO result (`username`, `fullname`, `result`, `matricNo`, `date_taken`, `course_title`) VALUES ('$username', '$fullname', '$resultcount', '$matricNo', '$date_taken', '$course_title')";
          $checkinsert = $conn->query($insertresult);
          if (!$checkinsert){
            die ('Error inserting has occurred');
          }
        } else {
          ?><script type="text/javascript">
            alert('You need to attempt at least one question');
            window.location = "select_course.php";
          </script><?php
        }
    /*?><script type="text/javascript">
     else {
      console.log('Cancel');
    }</script><?php*/
} else {
  echo "<p style='text-align: center; font-size: 18px;'>Your Quiz session has expired... Click <a href='user_dashboard.php'>here</a> to go to your dashboard and re-take the exam if needed</p>";
  die();
}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="charset=utf-8" />
<title>CBT EXAM</title>
<!-- Custom styles for this template -->
<link href="style/style.css" type="text/css" rel="stylesheet" />
<link href="style/sweet-alert.css" type="text/css" rel="stylesheet" />
<link href="style/bootstrap.min.css" type="text/css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="style/lineicons/style.css">
<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />    
    
</head>
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
                      <a href="select_course.php" class="btn btn-info">Go back <<<</a>
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
            <div class="col-md-12">
              <center><h3 style="text-transform: uppercase; font-weight: bold;"><?php echo "Your Results For : " . " " . $course_title; ?></h3></center>
            </div>
          </div>
           <div class="row centered">
            <div class="col-md-6">
              <table class="table table-bordered" style="font-family: arial;">
                <tr class="success">
                  <td width="50%">Total Number of Question</td>
                  <td width="50%" style="text-align: center;"><?php echo $noOfQuestions; ?></td>
                </tr>
                <tr class="info">
                  <td width="50%">Answered Correctly</td>
                  <td width="50%" style="text-align: center;"><?php echo $resultcount; ?></td>
                </tr>
                <tr class="danger">
                  <td width="50%">Answered Wrongly</td>
                  <td width="50%" style="text-align: center;"><?php echo $wrongAnswers; ?></td>
                </tr>
                <!-- <tr class="success">
                  <td width="50%">Attempted Questions</td>
                  <td width="50%" style="text-align: center;"><?php echo $answered; ?></td>
                </tr>
                <tr class="info">
                  <td width="50%">Unattempted Questions</td>
                  <td width="50%" style="text-align: center;"><?php echo $unanswered; ?></td>
                </tr>-->
                <tr class="success">
                  <td width="50%">Total Score</td>
                  <td width="50%" style="text-align: center;"><?php echo $resultcount; ?></td>
                </tr>
                <tr class="warning">
                  <td width="50%">Performance</td>
                  <td width="50%" style="text-align: center;"><?php echo $performance; ?></td>
                </tr>
              </table>
            </div>
          </div><br><br>
          <div class="row">
            <div class="col-md-6">
              <center><a href="select_course.php" class="btn btn-default">Take Another Exam</a></center>
            </div>
            <div class="col-md-6">
              <center><a href="quiz001.php?course_title=<?php echo $course_title; ?>" class="btn btn-default">Re-take Exam</a></center>
            </div>
          </div>
          </div>
        </div>
        </div>
        <div class="col-md-12">
         
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
<!-- Javascript files -->
<script src="js/jquery/jquery-2.1.3.min.js" type="text/javascript"> </script>
<script src="js/jquery/bootstrap.min.js" type="text/javascript"> </script>
<script src="js/sweet-alert.js" type="text/javascript"> </script>
</body>
</html>