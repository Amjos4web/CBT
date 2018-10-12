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

if (isset($_POST['add'])){
  // get inputed values
  $course_title = $_POST['course_title'];
  $question = $_POST['question'];
  $option_A = $_POST['option_A'];
  $option_B = $_POST['option_B'];
  $option_C = $_POST['option_C'];
  $option_D = $_POST['option_D'];
  $correct_answer = $_POST['correct_answer'];
  $date_added = date('Y-m-d H:i:s');
  // generate pin for this email
  for ($index = 0; $index < 1; $index++){
    $rand = mt_rand(1000000000, (int)9999999999);
    $question_id = $rand;
  }

  // check if all field is not empty
  if (empty($course_title && $question && $option_A && $option_B && $option_C && $option_D && $correct_answer) == false)
  {
    $query_question_id = "SELECT question_id FROM questions WHERE `question_id`='".$question_id."'";
    $check_query = $conn->query($query_question_id);
    if ($check_query->num_rows == 0)
    {
      //insert data into the data
      $sqlinsert = "INSERT INTO questions (`course_title`, `questions`, `option_A`, `option_B`, `option_C`, `option_D`, `answer`, `date_added`, `question_id`) VALUES ('".$course_title."', '".$question."', '".$option_A."', '".$option_B."', '".$option_C."', '".$option_D."', '".$correct_answer."', '".$date_added."', '".$question_id."')";
      $checksql = $conn->query($sqlinsert);
      if ($checksql){
        ?><script type="text/javascript">
          alert ('Question Added Successfully');
        </script><?php
      } else {
        ?><script type="text/javascript">
          alert ('Error has occurred');
        </script><?php
      }
    } else {
      $index -= 1;
      ?><script type="text/javascript">
        alert ('Opps! Error has occurred');
      </script><?php
    }
  } else {
    ?><script type="text/javascript">
        alert ('All fields are required');
    </script><?php
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
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
<!-- Section: Login boxes -->
    <section id="boxes" class="home-section paddingtop-30">
       <div class="container">
        <section class="cms-boxes">
           <div class="container-fluid">
           <div class="wow fadeInUp" data-wow-delay="0.1s">
              <div class="row">
                 <a href="#" data-target="#addQuiz" data-toggle="modal">
              <!--   <a href="http://localhost/buth_net/nurse/nurse_login.php">-->
                   <div class="col-md-4 cms-boxes-outer">
                    <div class="cms-boxes-items cms-features">
                       <div class="boxes-align">
                          <div class="small-box">
                             <i class="fa fa-plus" style="font-size:70px; color: #000;">&nbsp;</i>
                             <h5>Add Quiz</h5>
                             <p></p>
                          </div>
                       </div>
                    </div>
                 </div></a>
                 <a href="edit_questions.php">
                <!-- <a href="http://localhost/buth_net/pharmacySection/index.php">-->
                   <div class="col-md-4 cms-boxes-outer">
                    <div class="cms-boxes-items cms-features">
                       <div class="boxes-align">
                          <div class="small-box">
                             <i class="fa fa-pencil-square-o" style="font-size:70px; color: #000;">&nbsp;</i>
                             <h5>Edit Quiz</h5>
                             <p></p>
                          </div>
                       </div>
                    </div>
                 </div></a>
                 <a href="#">
                 <!--<a href="http://localhost/buth_net/accountSection/account_home.php">-->
                  <div class="col-md-4 cms-boxes-outer">
                    <div class="cms-boxes-items cms-features">
                       <div class="boxes-align">
                          <div class="small-box">
                             <i class="fa fa-users" style="font-size:70px; color: #000;">&nbsp;</i>
                             <h5>View Students Performance</h5>
                             <p></p>
                          </div>
                       </div>
					         </div></a>
                 </div>
                 </div>
        </section><br>
    <!-- /Section: boxes -->
</div>
</div>
</div>

     <!--AdminLogin box-->
  <div class="modal fade" id="addQuiz" role="dialog">
    <div class="modal-dialog modal-lg" style="max-height: 600px; overflow-x: auto;">

      <!-- Modal content no 1-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">ADD EXAM</h4>
        </div>
        <div class="modal-body padtrbl">

          <div class="login-box-body">
            <p class="login-box-msg" style="text-align: left; font-size: 16px;">Enter all exam details</p>
            <div class="form-group">
              <form id="addQquizForm" method="POST" action="">
                <div class="form-group">
                  <select name="course_title" class="form-control">
                    <option value="course001">Select Course Title</option>
                    <option value="course001">Course001</option>
                    <option value="course002">Course002</option>
                    <option value="course003">Course003</option>
                    <option value="course004">Course004</option>
                  </select>
                </div>
                <div class="form-group">
                <p style="text-align: left; font-size: 16px;">Enter Question</p>
                  <textarea class="form-control" placeholder="Enter Question" rows="10" cols="40" id="" name="question" ></textarea> 
                </div>
                <div class="form-group">
                  <input class="form-control" placeholder="Option A" id="" name="option_A" type="text" autocomplete="off"  />
                </div>
                <div class="form-group">
                  <input class="form-control" placeholder="Option B" id="" name="option_B" type="text" autocomplete="off"  />
                </div>
                <div class="form-group">
                  <input class="form-control" placeholder="Option C" id="" name="option_C" type="text" autocomplete="off"  />
                </div>
                <div class="form-group">
                  <input class="form-control" placeholder="Option D" id="" name="option_D" type="text" autocomplete="off"  />
                </div>
                <div class="form-group">
                  <select class="form-control" name="correct_answer">
                    <option value="Null">Select Correct Option</option>
                    <option value="A">Option A</option>
                    <option value="B">Option B</option>
                    <option value="C">Option C</option>
                    <option value="D">Option D</option>
                  </select>
                </div>
                <div class="row">
                    <input type="submit" class="btn btn-primary pull-right" style="margin-right: 12px;" name="add" id="addBtn" value="Add Question">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
    <!--/AdminLogin box-->
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