<?php include_once "includes/header.php"; ?>
<body>
<div class="container-fluid">
<div class="row">
<div class="col-md-12 header ">
<div class="col-md-3">
<img src="images/logo.gif" class="logo"/>
</div>
<div class="col-md-6">
<div class="headtext" >
 Online Examination Processing System
 </div>
 </div>
 <div class="col-md-3">
 </div>
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

$(document).ready(function(){
	$('.logbtn').click(function(){
		$('#adminLogin').load('index.php #studentLogin');
	});	
});						
	
</script>

<!--<h3><strong>Student Login Page</strong></h3>-->
<div class="login-box-body">
<div class="form-group" id="adminLogin">
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
	  <div class="col-xs-12">
		<input type="submit" class="btn btn-default" name="loginbtn" id="" value="Login as Admin">
		<p class="logbtn">Login as student</p>
	  </div><br><br><br>
	  <p style="font-size: 12px; padding-right: 20px; padding-left: 20px; margin-top: 40px;">By signing up, you agree to the <a href='#'>Terms of Service</a> and <a href='#'>Privacy Policy</a>, including <a href='#'>Cookie Use</a>. Others will be able to find you by email or phone number when provided.</p>
	</div>
  </form>
</div>
</div>

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