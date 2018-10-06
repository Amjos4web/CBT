<?php
require './admin/connect.php';

if (isset($_POST['loginAsADmin'])){
    $admin_email = $_POST['adminemail'];
    $admin_password = $_POST['adminpassword'];
    $last_log_date = date('Y-m-d H:i:s');

    $qry="SELECT * FROM admin WHERE email='$admin_email' AND password='$admin_password' LIMIT 1";
    $qrycheck=$conn->query($qry);
    if ($qrycheck->num_rows > 0){
        while($fetch = $qrycheck->fetch_assoc()){
            $fullname=$fetch['fullname'];
            $email=$fetch['email'];
            $id=$fetch['id'];

        }
        //echo "True";
        session_start();
        $_SESSION['adminid']=$id;
        $_SESSION['email']=$email;
        $_SESSION['name']=$fullname;
        header ('location: admin_dashboard.php');
        // update last_log_date
        $update_last_log_date = "UPDATE admin SET `last_log_date`='".$last_log_date."' WHERE `email`='".$email."'";
        $checkupdate = $conn->query($update_last_log_date);
    } else {
        ?><script type="text/javascript">
        	alert ('Invalid Login Details');
        </script><?php
    }
}
?>
<?php include_once "includes/header.php"; ?>
<body>
<div class="container-fluid">
 <div class="row">
    <div class="col-md-12 header">
      <h2 class="headtext">Online Examination Processing System</h2>
    </div>
</div>

<div class="row" id="content">
<div class="col-md-12">
<div class="col-md-3">
</div>

<div class="col-md-6 loginform">
<div align="center">

<script>
jQuery(document).ready(function(){
jQuery(".login").submit(function(e){
		e.preventDefault();
		var formData = jQuery(this).serialize();
		$.ajax({
			type:"POST",
			url:"login_validate.php",
			data:formData,
			success: function(response){
				/** alert (response);
			 }, error: function(jqXHR, textStatus, errorThrown){
					alert('error');
			 } **/       
				if(response == "True")
				{
					//alert('Yes');
					//$.jGrowl("Loading File Please Wait......", { sticky: true });
					$.jGrowl("Welcome... Redirecting", { header: 'Login Successful' });
					var delay = 3000;
					setTimeout((function(){ window.location = 'user_dashboard.php'  }), delay);
			 
				}else{
					//alert('No');
					$.jGrowl("Invalid Login Details", { header: 'Access Denied' });
                }
			}
		});
		return false;
	});

});	

</script>

<!--<h3><strong>Student Login Page</strong></h3>-->
<div class="login-box-body">
<div class="form-group" id="studentLogin">
  <form id="loginForm" method="POST" action="" class="login">
	<div class="form-group has-feedback">
	  <input class="form-control" placeholder="Username" id="user" name="username" type="text" autocomplete="off" autofocus required 
	  />
	  <span style="display:none;font-weight:bold; position:absolute;color: red;position: absolute;padding:4px;font-size: 11px;background-color:rgba(128, 128, 128, 0.26);z-index: 17;  right: 27px; top: 5px;" id="span_loginid"></span>
	  <span class="glyphicon glyphicon-user form-control-feedback"></span>
	</div>
	<div class="form-group has-feedback">
	  <input class="form-control" placeholder="Password" id="pass" name="password" type="password" autocomplete="off"  required/>
	  <span style="display:none;font-weight:bold; position:absolute;color: grey;position: absolute;padding:4px;font-size: 11px;background-color:rgba(128, 128, 128, 0.26);z-index: 17;  right: 27px; top: 5px;" id="span_loginpsw"></span>
	  <span class="glyphicon glyphicon-lock form-control-feedback"></span>
	</div>
	<div class="row">
	  <div class="col-xs-12" align="left">
		<div class="checkbox icheck">
		  <label>
			 <input type="checkbox" id="loginrem" onclick="if (pass.type == 'text') pass.type = 'password'; 
			else pass.type = 'text';"> Show Password
		  </label>
		</div>
	  </div>
	  <div class="col-xs-6">
		<input type="submit" class="btn btn-default" name="loginbtn" id="" value="Login as Student"><br><br>
	  </div>
	  <div class="col-xs-6">
	  	<a href="#" class="btn btn-default" data-target="#adminLogin" data-toggle="modal">Login as admin</a><br>
	  </div>
	  <div class="col-md-12">
	  <p>Have No Account Yet? <a href="register.php">Click Here to Register</a></p>
	  <p style="font-size: 12px; padding-right: 20px; padding-left: 20px; margin-top: 20px;">By signing up, you agree to the <a href='#'>Terms of Service</a> and <a href='#'>Privacy Policy</a>, including <a href='#'>Cookie Use</a>. Others will be able to find you by email or phone number when provided.</p>

	 </div>
	</div>
  </form>
</div>
</div>
     <!--adminLogin box-->
  <div class="modal fade" id="adminLogin" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content no 1-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h2 class="modal-title">ADMIN LOGIN</h2>
        </div>
        <div class="modal-body padtrbl">

          <div class="login-box-body">
            <p class="login-box-msg" style="text-align: left; font-size: 16px;">Strictly for Admin Users Only</p>
            <div class="form-group">
              <form id="loginForm" method="POST" action="">
                <div class="form-group has-feedback">
                  <!----- username -------------->
                  <input class="form-control" placeholder="Email" id="loginid" name="adminemail" type="email" autocomplete="off" autofocus 
                  />
                  <span style="display:none;font-weight:bold; position:absolute;color: red;position: absolute;padding:4px;font-size: 11px;background-color:rgba(128, 128, 128, 0.26);z-index: 17;  right: 27px; top: 5px;" id="span_loginid"></span>
                  <!---Alredy exists  ! -->
                  <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                  <!----- password -------------->
                  <input class="form-control" placeholder="Password" id="loginpsw" name="adminpassword" type="password" autocomplete="off"  />
                  <span style="display:none;font-weight:bold; position:absolute;color: grey;position: absolute;padding:4px;font-size: 11px;background-color:rgba(128, 128, 128, 0.26);z-index: 17;  right: 27px; top: 5px;" id="span_loginpsw"></span>
                  <!---Alredy exists  ! -->
                  <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                  <!--<div class="col-xs-12">
                    <div class="checkbox icheck">
                      <label>
                     	 <input type="checkbox" id="loginrem" > Remember Me
                      </label>
                    </div>
                  </div>-->
                    <input type="submit" class="btn btn-primary pull-right" style="margin-right: 12px;" name="loginAsADmin" id="loginBtn" value="Sign Me In">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
    <!--/adminLogin box-->

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
</div>
</body>
</html>