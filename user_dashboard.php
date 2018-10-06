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
                      <p>What do you want to do today?</p>
                      <p style="font-weight: bold; font-style: initial; color: #880000; font-family: cursive;">Last Log date: <?php echo $log_date; ?></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="cta-btn">
                      <a href="logout.php" class="btn btn-info">Log Out</a>
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
                 <a href="select_course.php">
              <!--   <a href="http://localhost/buth_net/nurse/nurse_login.php">-->
                   <div class="col-md-4 cms-boxes-outer">
                    <div class="cms-boxes-items cms-features">
                       <div class="boxes-align">
                          <div class="small-box">
                             <i class="fa fa-question-circle" style="font-size:70px; color: #000;">&nbsp;</i>
                             <h5>Take Exam</h5>
                             <p></p>
                          </div>
                       </div>
                    </div>
                 </div></a>
                 <a href="check_results.php">
                <!-- <a href="http://localhost/buth_net/pharmacySection/index.php">-->
                   <div class="col-md-4 cms-boxes-outer">
                    <div class="cms-boxes-items cms-features">
                       <div class="boxes-align">
                          <div class="small-box">
                             <i class="fa fa-pencil-square-o" style="font-size:70px; color: #000;">&nbsp;</i>
                             <h5>History</h5>
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
                             <h5>Community</h5>
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
</div>

     <!--AdminLogin box-->
  <div class="modal fade" id="adminLogin" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content no 1-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-center form-title">Admin Login</h4>
        </div>
        <div class="modal-body padtrbl">

          <div class="login-box-body">
            <p class="login-box-msg">Strictly for Admin Only</p>
            <div class="form-group">
              <form id="loginForm" method="POST" action="">
                <div class="form-group has-feedback">
                  <!----- username -------------->
                  <input class="form-control" placeholder="Email" id="loginid" name="email" type="text" autocomplete="off" autofocus 
                  />
                  <span style="display:none;font-weight:bold; position:absolute;color: red;position: absolute;padding:4px;font-size: 11px;background-color:rgba(128, 128, 128, 0.26);z-index: 17;  right: 27px; top: 5px;" id="span_loginid"></span>
                  <!---Alredy exists  ! -->
                  <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                  <!----- password -------------->
                  <input class="form-control" placeholder="Password" id="loginpsw" name="password" type="password" autocomplete="off"  />
                  <span style="display:none;font-weight:bold; position:absolute;color: grey;position: absolute;padding:4px;font-size: 11px;background-color:rgba(128, 128, 128, 0.26);z-index: 17;  right: 27px; top: 5px;" id="span_loginpsw"></span>
                  <!---Alredy exists  ! -->
                  <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                  <div class="col-xs-12">
                    <input type="submit" class="btn btn-primary btn-block btn-flat" name="login" id="loginBtn" value="Login As Admin">
                    <label class="form-check-label">
                      <span class="text-danger align-middle" id="errorMsg"></span>
                    </label>
                  </div>
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