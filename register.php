<?php
require './admin/connect.php';
if (isset($_POST['submit'])){
  // get inputed values
  $surName = $_POST['surName'];
  $firstName = $_POST['firstName'];
  $fullname = $surName . " " . $firstName;
  $username = $_POST['username'];
  $email = $_POST['email'];
  $matricNo = $_POST['matricNo'];
  $password = $_POST['passWord'];
  $confirmPass = $_POST['confirmPass'];
  $department = $_POST['department'];


  // check if all field is not empty
  if (empty($surName && $firstName && $username && $email && $matricNo && $password && $confirmPass && $department) == false)
  {
    

    // check if username exist
    $qry="SELECT username FROM student WHERE `username`='".$username."'";
    $qrycheck=$conn->query($qry);
    if ($qrycheck->num_rows == 0)
    {

      // check if password match
      if($password == $confirmPass)
      {
       //insert data into the data
        $sqlinsert = "INSERT INTO student (`fullname`, `username`, `emailAddress`, `matricNo`, `dept`, `password`, `confirmPassword`) VALUES ('".$fullname."', '".$username."', '".$email."', '".$matricNo."', '".$department."', '".$password."', '".$confirmPass."')";
        $checksql = $conn->query($sqlinsert);
        if ($checksql){
          /*echo '<script type="text/javascript">';
          echo 'swal({
            title: "Congratulations!",
            text: "Registratulation Successful",
            type: "sucess",
            closeOnClickOutside: false,
          },
          function(){
            window.location.href = "result.php";
          })';
          echo '</script>';*/
          echo '<script type="text/javascript">';
          echo 'setTimeout(function () { swal("Congratulations!","Registratulation Successful","sucess");';
          echo '}, 500);';
          echo '</script>';
        } else {
          echo "Error has occured";
        }
        
      } else {
        echo '<script type="text/javascript">';
        echo 'setTimeout(function () { swal("Error!","Password do not match","warning");';
        echo '}, 500);';
        echo '</script>';
      }
    } else {
      echo '<script type="text/javascript">';
      echo 'setTimeout(function () { swal("Error!","Username "'.$username.'" Already Exist","warning");';
      echo '}, 500);';
      echo '</script>';
    }
  } else {
     /* echo '<script type="text/javascript">';
      echo 'swal({
        title: "Error!",
        text: "AlL fields are required",
        type: "warning",
        closeOnClickOutside: false,
      },
      setTimeout (function(){
        window.location.href = "register.php";
      }), 500)';
      echo '</script>';*/

      echo '<script type="text/javascript">';
      echo 'setTimeout(function () { swal("Error!","AlL fields are required","warning");';
      echo '}, 500);';
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
<div class="row">
<div class="col-md-12">
<div class="col-md-3">
</div>

<div class="col-md-6 loginform">
<center><div class="page-header"><h4>Register For Your Exam Here</h4></div></center>

<div class="col-md-12">
<form method="POST" role="form" class="" action="">
<!--<div align="center"> <?php echo $msg; ?></div>-->
  <div class="form-group">
   <!--<label>Surname</label>-->
   <input type="text" class="form-control" id="regName" name="surName" placeholder="Surname" autofocus>
  </div>
  
  <div class="form-group">
   <!--<label>First Name</label>-->
   <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name">
  </div>
    
    <div class="form-group">
    <!--<label>PIN</label>-->
	<input type="text" class="form-control" id="username" name="username" placeholder="Username">
    </div>
	
	<div class="form-group">
    <!--<label>Email</label>-->
	<input type="text" class="form-control" id="email" name="email" placeholder="Email Address">
    </div>
	
	<div class="form-group">
    <!--<label>Matric</label>-->
	<input type="text" class="form-control" id="matricNo" name="matricNo" placeholder="Matric No">
    </div>
    
    <div class="form-group">
    <!--<label>Create Password</label> -->
	<input type="password" class="form-control" id="password" name="passWord" placeholder="Password">
    </div>
    
    <div class="form-group"> 
	<!--<label>Confirm Password</label>-->
    <input type="password" name= "confirmPass" class="form-control" id="confirmpassword" placeholder="Confirm Password">
	</div>
	
	<div class='form-group'>
	<select class="form-control" id="user_role" name="department" />
	  <option value="Null">Select Department</option>
	  <option value="Computer Science and Engineering">Computer Science and Engineering</option>
	  <option value="Nursing">Nursing</option>
	  <option value="Mechanical Engineering">Mechanical Engineering</option>
	  <option value="Bio-Chemistry">Bio-Chemistry</option>
	</select>
    </div>
	
	<input class="btn btn-default pull-right"  name="submit" type="submit" value="Register">
	Already Have An Account? <a href="index.php">Click Here to Login</a>
  </div><br><br><br>
    <p style="font-size: 12px; padding-right: 20px; padding-left: 15px; width: 60%px;">By signing up, you agree to the <a href='#'>Terms of Service</a> and <a href='#'>Privacy Policy</a>, including <a href='#'>Cookie Use</a>.<br> Others will be able to find you by email or phone number when provided.</p>
</form>
</div>

<div class="col-md-3">
</div>
</div>
</div>

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



</body>
</html>