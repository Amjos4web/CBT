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

if (isset($_GET['course_title'])){
  $course_title = $_GET['course_title'];

} else {
echo "Error has occured"; die();
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
<style type="text/css">
hr { 
  height: 30px; 
  border-style: solid; 
  border-color: #8c8b8b; 
  border-width: 1px 0 0 0; 
  border-radius: 20px; 
} 
hr { 
  display: block; 
  content: ""; 
  height: 30px; 
  margin-top: 15px; 
  border-style: solid; 
  border-color: #8c8b8b; 
  border-width: 0 0 1px 0; 
  border-radius: 20px; 
}
</style>   
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
            <div class="col-md-8 page-title">
              <h4 style="text-decoration: underline;"><?php echo "Course Title: " . " " . $course_title; ?></h4>
              <p><b>Instructions:</b> attempts all Questions within the limited time provided. You have 2mins for this session.</p>
            </div>
            <div class="col-md-4">
              <div class="cta-btn">
                <div class="btn btn-danger" id="timebar">Time Remaining <span id="timer">2m:18s:00ms</span></div>
              </div>
            </div>
          </div>
           <center><div class="row">
            <div class="col-md-12">
              <button class="btn btn-info" id="mybut" onclick="myFunction()">START EXAM</button>
            </div>
          </div></center><br>
          <div id="MyDiv" style="max-height: 500px; overflow-x: auto; border: 0px solid #CECECE; background: #f4f4f4; padding: 18px 18px 18px 18px; border-radius: 10px;">
          <div class="row">
            <div class="col-md-12">
             <form method="POST" role="form" id="form" action="result.php">
             <?php
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
                $_SESSION['course_title'] = $course_title;
               
             ?>
             <div class="form-group">
                <label style="font-weight: normal; text-align: justify;"><b><?php echo "Question" . " " . $counter++; ?></b>&nbsp<?php echo $questions; ?></label><br>
                <div id="quiz-options">
                  <label style="font-weight: normal; cursor: pointer;">
                    <input type="checkbox" name="option[]" value="A"> <?php echo $optionA; ?>
                  </label><br>
                  <label style="font-weight: normal; cursor: pointer;">
                    <input type="checkbox" name="option[]" value="B"> <?php echo $optionB; ?>
                  </label><br>
                  <label style="font-weight: normal; cursor: pointer;">
                    <input type="checkbox" name="option[]" value="C"> <?php echo $optionC; ?>
                  </label><br>
                  <label style="font-weight: normal; cursor: pointer;">
                    <input type="checkbox" name="option[]" value="D"> <?php echo $optionD; ?>
                  </label><br>
                </div>
                <hr>
             </div><br>
             <?php } ?>
            <input class="btn btn-primary pull-right"  name="submit" type="submit" value="Submit">
            </form>
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
    <p style="font-size: 13px; font-family: arial;"><a rel="license" href="http://creativecommons.org/licenses/by-nc/4.0/" style="color: #000000;"><img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by-nc/4.0/88x31.png" /></a><br />This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc/4.0/">Creative Commons Attribution-NonCommercial 4.0 International License</a></p>
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
<script src="js/jGrowl/jquery.jgrowl.js" type="text/javascript"> </script>
<script>
$(document).ready(function() {
    $('input[type="checkbox"]').change(function(){ 
        var $this =  $(this).parents('#quiz-options').find('input[type="checkbox"]');
        $this.not(this).prop('checked', false);
    });    
});


function myFunction() {
  var x = document.getElementById("MyDiv");
  var b = document.getElementById("mybut");
  if (x.style.display === "none") { 
    b.style.visibility = 'hidden';
    x.style.display = "block";
    startTimer();
  }
}
window.onload = function () {
  document.getElementById('MyDiv').style.display = 'none';
};

/*
<?php   
  /*$fetchtime = "SELECT `timer` FROM `questions` WHERE `course_title`='".$course_title."'";
  $fetched = $conn->query($fetchtime);
  $time->fetch_assoc($fetched);
  $settime = $time['timer']; */   
?>*/
 
function startTimer() {
  var zeroFill = function(units) {
    return units < 10 ? "0" + units + "" : units;
  };
  var count = 0;

  var interval = window.setInterval(function() {
    var centisecondsRemaining = 10000 - count;
    var min = Math.floor(centisecondsRemaining / 100 / 60);
    var sec = zeroFill(Math.floor(centisecondsRemaining / 100 % 60));
    var cs = zeroFill(centisecondsRemaining % 100);
    //quiz.state.timer.text(min + ":" + sec + ":" + cs);
    document.getElementById('timer').innerHTML = min + "m" + ":" + sec + "s" + ":" + cs + "cs";
    count++;
    if (centisecondsRemaining === 0) {
      clearInterval(interval);
      alert('Your Time is up... Click OK to continue');
      /*swal({
          title: "Opps!",
          text: "Your time is up... Click OK to continue",
          type: "warning",
          closeOnClickOutside: false,
      },
      function(){
        //redirect to result page
        window.location.href = "result.php";
      });*/
      window.location = 'result.php';
    }
  }, 10);
}

</script>

</body>
</html>