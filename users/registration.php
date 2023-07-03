<?php
include('includes/config.php');
error_reporting(0);
if(isset($_POST['submit']))
{
	$fullname=$_POST['fullname'];
	$email=$_POST['email'];
	$unit= $_POST['unit'];
	$password=md5($_POST['password']);
	$contactno=$_POST['contactno'];
	$status=1;
	$query=mysqli_query($bd, "insert into users(fullName,userEmail,password,unit,contactNo,status) values('$fullname','$email','$password','$unit','$contactno','$status')");
	if($query)
	{
		$msg="Registration successful. Now you can login!";
		header("Location: index.php");
		exit();
	}
	else
	{
		$msg="Registration failed. Please try again.";
	}
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>DCMS | Student Registration</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    	<script>
function userAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'email='+$("#email").val(),
type: "POST",
success:function(data){
$("#user-availability-status1").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>
  </head>

  <body>
      <div id="login-background"></div>
	  <div id="login-page">
	  	<div class="container">
	  	
		      <form class="form-login" method="post">
		        <h2 class="form-login-heading">Students Registration</h2>
		        <p style="padding-left: 1%; color: green">
		        	<?php if($msg){
echo htmlentities($msg);
		        		}?>


		        </p>
		        <div class="login-wrap">
		         <input type="text" class="form-control" placeholder="Full Name" name="fullname" required="required" autofocus>
		            <br>
		            <input type="email" class="form-control" placeholder="Email" id="email" onBlur="userAvailability()" name="email" required="required">
		             <span id="user-availability-status1" style="font-size:12px;"></span>
		            <br>
					<select name="unit" class="form-control">
						<option value="" selected>Select Unit</option>
						<option value="CoHU">College of Humanities</option>
						<option value="CoICT">College of Information and Communication Technologies</option>
						<option value="CoNAS">College of Natural and Applied Sciences</option>
						<option value="SoED">School of Education</option>
						<option value="IDS">Institute of Development Studies</option>
						<option value="CoAF">College of Agriculture and Forestry</option>
						<option value="CoSS">College of Social Sciences</option>
						<option value="SoMG">School of Medicine and Dentistry</option>
						<option value="UDSE">University Department of Special Education</option>
						<option value="UDBS">University Department of Business Studies</option>
						<option value="UDSoL">University Department of Sociology and Law</option>
						<option value="SoAF">School of Architecture and Design</option>
						<option value="IKS">Institute of Kiswahili Studies</option>
						<option value="CoET">College of Engineering and Technology</option>
						<option value="SJMC">School of Journalism and Mass Communication</option>
						<option value="IMR">Institute of Marine Sciences</option>
						<option value="MCHAS">Muhimbili College of Health and Allied Sciences</option>
					</select><br>

		            <input type="password" class="form-control" placeholder="Password" required="required" name="password"><br >
		             <input type="text" class="form-control" maxlength="10" name="contactno" placeholder="Contact no" required="required" autofocus>
		            <br>
		            
		            <button class="btn btn-theme btn-block"  type="submit" name="submit" id="submit"><i class="fa fa-user"></i> Register</button>
		            <hr>
		            
		            <div class="registration">
		                Already Registered<br/>
		                <a class="" href="index.php">
		                   Sign in
		                </a>
		            </div>
		
		        </div>
		
		      
		
		      </form>	  	
	  	
	  	</div>
	  </div>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

	<script>
    var backgroundImageUrl = 'assets/img/nkurummah.jpg';
    var backgroundStyle = "url('" + backgroundImageUrl + "')";

    var loginBackground = document.getElementById('login-background');
    loginBackground.style.backgroundImage = backgroundStyle;
    loginBackground.style.backgroundSize = 'cover';
    loginBackground.style.backgroundPosition = 'center';
    // Add any additional styling properties here
</script>

<style>
    #login-background {
        /* Add any additional styling properties */
        width: 100vw;
        height: 100vh;
		position: absolute;
		z-index: -2;
    }
</style>


  </body>
</html>
