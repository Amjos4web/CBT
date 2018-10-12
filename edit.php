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

// get data for question
if (isset($_GET['question_id'])){
  $question_id = $_GET['question_id'];

  // fetch data with the question id
  $select_question = "SELECT * FROM `questions` WHERE `id`='".$question_id."' LIMIT 1";
  $check_select = $conn->query($select_question);
  if ($check_select->num_rows > 0){
    while ($row = $check_select->fetch_assoc()){
      $question_name = $row['questions'];
      $courseTitle = $row['course_title'];
      $optionA = $row['option_A'];
      $optionB = $row['option_B'];
      $optionC = $row['option_C'];
      $optionD = $row['option_D'];
      $correctAnswer = $row['answer'];
    }
  } else {
    echo "Question ID not found";
    die();
  }

}

if (isset($_POST['update'])){
  // get inputed values
  $course_title = $_POST['course_title'];
  $question = $_POST['question'];
  $option_A = $_POST['option_A'];
  $option_B = $_POST['option_B'];
  $option_C = $_POST['option_C'];
  $option_D = $_POST['option_D'];
  $correct_answer = $_POST['correct_answer'];
  //$date_added = date('Y-m-d H:i:s');

  // check if all field is not empty
  if (empty($question && $option_A && $option_B && $option_C && $option_D) == false)
  {
  
    //insert data into the data
    $sqlupdate = "UPDATE questions SET `course_title`='".$course_title."', `questions`='".$question."', `option_A`='".$option_A."', `option_B`='".$option_B."', `option_C`='".$option_C."', `option_D`='".$option_D."', `answer`='".$correct_answer."' WHERE `id`='".$question_id."' LIMIT 1";
    $checksql = $conn->query($sqlupdate);
    if ($checksql){
        echo '<script type="text/javascript">';
        echo 'setTimeout(function () { 
          swal({
            title: "Congratulations!",
            text: "Question '.$question_id.' Updated Successfully",
            type: "success",
            confirmButtonText: "OK"
          },
          function(isConfirm){
            if (isConfirm) {
              window.location.href = "edit.php?question_id='.$question_id.'";
            }
          }); }, 500)';
        echo '</script>';
    } else {
      echo '<script type="text/javascript">';
      echo 'setTimeout(function () { 
        swal({
          title: "Opps!",
          text: "Error has occured",
          type: "warning",
          confirmButtonText: "TRY AGAIN"
        },
        function(isConfirm){
          if (isConfirm) {
            window.location.href = "edit.php?question_id='.$question_id.'";
          }
        }); }, 500)';
      echo '</script>';
    }
  } else {
    echo '<script type="text/javascript">';
    echo 'setTimeout(function () { 
      swal({
        title: "Opps!",
        text: "All fields are require",
        type: "warning",
        confirmButtonText: "TRY AGAIN"
      },
      function(isConfirm){
        if (isConfirm) {
          window.location.href = "edit.php?question_id='.$question_id.'";
        }
      }); }, 500)';
    echo '</script>';
  }
   
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
                      <h2>Welcome! Admin - <?php echo $fullname . " " . "(" . $email. ")"; ?></h2>
                      <p>What do you want to do today?</p>
                      <p style="font-weight: bold; font-style: initial; color: #880000; font-family: cursive;">Last Log date: <?php echo $log_date; ?></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="cta-btn">
                      <a href="admin_logout.php" class="btn btn-info">Log Out</a>
                      <a href="edit_questions.php" class="btn btn-info">Go back <<<</a>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section><br>
    <div class="row centered">
      <div class="col-md-8">
          <center><h3 style="color: #880000;">Question ID: <?php echo $question_id; ?> (<?php echo $courseTitle; ?>)</h3></center>
          <hr>
            <div class="form-group">
              <form id="addQquizForm" method="POST" action="">
                <div class="form-group">
                  <label>Change Course</label>
                  <select name="course_title" class="form-control">
                    <option value="<?php echo $courseTitle; ?>"><?php echo $courseTitle; ?></option>
                    <option value="course001">Course001</option>
                    <option value="course002">Course002</option>
                    <option value="course003">Course003</option>
                    <option value="course004">Course004</option>
                  </select>
                </div>
                <div class="form-group">
                <label>Edit Question</label>
                  <textarea class="form-control" placeholder="Enter Question" rows="10" cols="40" id="" name="question" ><?php echo $question_name; ?></textarea> 
                </div>
                <div class="form-group">
                  <label>Change Option A</label>
                  <input class="form-control" placeholder="Option A" id="" name="option_A" type="text" autocomplete="off" value="<?php echo $optionA; ?>">
                </div>
                <div class="form-group">
                  <label>Change Option B</label>
                  <input class="form-control" placeholder="Option B" id="" name="option_B" type="text" autocomplete="off" value="<?php echo $optionB; ?>">
                </div>
                <div class="form-group">
                  <label>Change Option C</label>
                  <input class="form-control" placeholder="Option C" id="" name="option_C" type="text" autocomplete="off" value="<?php echo $optionC; ?>">
                </div>
                <div class="form-group">
                  <label>Change Option D</label>
                  <input class="form-control" placeholder="Option D" id="" name="option_D" type="text" autocomplete="off" value="<?php echo $optionD; ?>">
                </div>
                <div class="form-group">
                  <label>Change Correct Answer</label>
                  <select class="form-control" name="correct_answer">
                    <option value="<?php echo $correctAnswer; ?>"><?php echo $correctAnswer; ?></option>
                    <option value="A">Option A</option>
                    <option value="B">Option B</option>
                    <option value="C">Option C</option>
                    <option value="D">Option D</option>
                  </select>
                </div>
                <div class="row centered">
                    <input type="submit" class="btn btn-primary pull-right" style="margin-right: 12px;" name="update" id="addBtn" value="Update Question">
                </div>
              </form>
      </div>
    </div>
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
<script>
tinymce.init({ selector:'textarea',
height: 150,
menubar: false,
plugins: [
    'advlist autolink lists link image charmap print preview anchor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table contextmenu paste code'
  ],
toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
content_css: 'http://localhost/myCBT/style/content_css.css' });
</script>
</body>
</html>