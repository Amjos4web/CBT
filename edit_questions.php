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
              $course_selected = $_GET['search_by_course'];

              $select_course = "SELECT * FROM questions WHERE `course_title`='".$course_selected."' ORDER BY `date_added` ASC";
              $check_query = $conn->query($select_course);
              if ($check_query->num_rows > 0)
              {
                while($fetch = $check_query->fetch_assoc()){
                  $question_id = $fetch['id'];
                  $date_added = $fetch['date_added'];
                  $course_title = $fetch['course_title'];
                  $date=strftime("%d %b, %Y %H:%M:%S",strtotime($fetch['date_added']));


                  $results .= "<tr style='text-align: center;'>";
                  $results .= "<td>".$counter++. "</td>";
                  //$results .= "<td>".$question_id. "</td>";
                  $results .= "<td>".$course_title."</td>"; 
                  $results .= "<td>".$date_added."</td>";
                  $results .= '<td><a href="edit.php?question_id='.$question_id.'" class="btn btn-primary">Edit</a></td>';
                  $results .= '<td><input type="submit" name="delete" value="Delete" class="btn btn-danger"></td>';
                  $results .= "</tr>";

                }

                echo '<div class="col-md-12">
                        <center><h3>'.$check_query->num_rows.' Results Found For '.$course_selected.'</h3></center>
                        <hr>
                       <div style="max-height: 350px; overflow-x: auto">
                         <table class="table table-bordered" style="font-family: arial;">
                          <thead>
                            <tr class="info" style="text-transform: uppercase; text-align: center;">
                              <th style="text-align: center;">sn</th>
                              <th style="text-align: center;">course Title</th>
                              <th style="text-align: center;">date Added</th>
                              <th style="text-align: center;">edit</th>
                              <th style="text-align: center;">delete</th>
                            </tr>
                          </thead>
                          '.$results.'
                          </table>
                        </div>
                      </div>';
                
            
              } else if ($_GET['search_by_course'] == "course002")
              {
                echo $_GET['search_by_course']; die();
                $course_selected = $_GET['search_by_course'];

                $select_course = "SELECT * FROM questions WHERE `course_title`='".$_GET['search_by_course']."' ORDER BY `date_added` ASC";
                $check_query = $conn->query($select_course);
                if ($check_query->num_rows > 0)
                {
                  while($fetch = $check_query->fetch_assoc()){
                    $question_id = $fetch['id'];
                    $date_added = $fetch['date_added'];
                    $course_title = $fetch['course_title'];
                    $date=strftime("%d %b, %Y %H:%M:%S",strtotime($fetch['date_added']));


                    $results .= "<tr style='text-align: center;'>";
                    $results .= "<td>".$counter++. "</td>";
                    //$results .= "<td>".$question_id. "</td>";
                    $results .= "<td>".$course_title."</td>"; 
                    $results .= "<td>".$date_added."</td>";
                    $results .= '<td><a href="edit.php?question_id='.$question_id.'" class="btn btn-primary">Edit</a></td>';
                    $results .= '<td><input type="submit" name="delete" value="Delete" class="btn btn-danger"></td>';
                    $results .= "</tr>";

                  }

                  echo '<div class="col-md-12">
                        <center><h3>'.$check_query->num_rows.' Results Found For '.$course_selected.'</h3></center>
                        <hr>
                         <div style="max-height: 350px; overflow-x: auto">
                           <table class="table table-bordered" style="font-family: arial;">
                            <thead>
                              <tr class="info" style="text-transform: uppercase; text-align: center;">
                                <th style="text-align: center;">sn</th>
                                <th style="text-align: center;">course Title</th>
                                <th style="text-align: center;">date Added</th>
                                <th style="text-align: center;">edit</th>
                                <th style="text-align: center;">delete</th>
                              </tr>
                            </thead>
                            '.$results.'
                            </table>
                          </div>
                        </div>';
                } else {
                  echo '<script type="text/javascript">';
                  echo 'setTimeout(function () { 
                  swal({
                    title: "Opps!",
                    text: "No result found",
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