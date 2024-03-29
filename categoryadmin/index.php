<?php
session_start();
error_reporting(0);
include("includes/config.php");

if(isset($_POST['submit'])) {
    $email = $_POST['username'];
    $password = $_POST['password'];
    
    $query = mysqli_query($bd, "SELECT * FROM minister WHERE email='$email'");
    $minister = mysqli_fetch_array($query);
    
    $query = mysqli_query($bd, "SELECT * FROM judge WHERE email='$email'");
    $judge = mysqli_fetch_array($query);
    
    $query = mysqli_query($bd, "SELECT * FROM president WHERE email='$email'");
    $president = mysqli_fetch_array($query);
    
    if(password_verify($password, $minister['password'])) {
        $userType = 'minister';
        $userInfo = $minister;
    } elseif(password_verify($password, $judge['password'])) {
        $userType = 'judge';
        $userInfo = $judge;
    } elseif(password_verify($password, $president['password'])) {
        $userType = 'president';
        $userInfo = $president;
    } else {
        $_SESSION['login'] = $email;
        $uip = $_SERVER['REMOTE_ADDR'];
        $status = 0;
        // mysqli_query($bd, "INSERT INTO userlog(username,userip,status) VALUES ('".$_SESSION['login']."','$uip','$status')");
        $errormsg = "Invalid username or password";
        $extra = "login.php";
    }
    
    if (isset($userType)) {
        $extra = "dashboard.php";
        $_SESSION['login'] = $email;
        $_SESSION['id'] = $userInfo['id'];
        $_SESSION['userType'] = $userType;
        $host = $_SERVER['HTTP_HOST'];
        $uip = $_SERVER['REMOTE_ADDR'];
        $status = 1;
        // $log = mysqli_query($bd, "INSERT INTO userlog(uid,username,userip,status) VALUES ('".$_SESSION['id']."','".$_SESSION['login']."','$uip','$status')");
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("location:http://$host$uri/$extra");
        exit();
    }
}

if(isset($_POST['change'])) {
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $queryMinister = mysqli_query($bd, "SELECT * FROM minister WHERE email='$email' AND contactno='$contact'");
    $queryJudge = mysqli_query($bd, "SELECT * FROM judge WHERE email='$email' AND contactno='$contact'");
    $queryPresident = mysqli_query($bd, "SELECT * FROM president WHERE email='$email' AND contactno='$contact'");
    
    $numMinister = mysqli_num_rows($queryMinister);
    $numJudge = mysqli_num_rows($queryJudge);
    $numPresident = mysqli_num_rows($queryPresident);
    
    if($numMinister > 0) {
        mysqli_query($bd, "UPDATE minister SET password='$password' WHERE email='$email' AND contactno='$contact'");
        $msg = "Minister Password Changed Successfully";
    } elseif($numJudge > 0) {
        mysqli_query($bd, "UPDATE judge SET password='$password' WHERE email='$email' AND contactno='$contact'");
        $msg = "Judge Password Changed Successfully";
    } elseif($numPresident > 0) {
        mysqli_query($bd, "UPDATE president SET password='$password' WHERE email='$email' AND contactno='$contact'");
        $msg = "President Password Changed Successfully";
    } else {
        $errormsg = "Invalid email id or contact no";
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

    <title>DCMS | Admin Login</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
        
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    
    <script type="text/javascript">
        function valid() {
            if(document.forgot.password.value != document.forgot.confirmpassword.value) {
                alert("Password and Confirm Password Field do not match!");
                document.forgot.confirmpassword.focus();
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
	  <div id="login-background"></div>
    <div id="login-page">
        <div class="container">
            <form class="form-login" name="login" method="post">
                <h2 class="form-login-heading"> Leader Sign in now</h2>
                <p style="padding-left:4%; padding-top:2%;  color:red">
                    <?php if($errormsg) { echo htmlentities($errormsg); } ?>
                </p>
                <p style="padding-left:4%; padding-top:2%;  color:green">
                    <?php if($msg) { echo htmlentities($msg); } ?>
                </p>
                <div class="login-wrap">
                    <input type="text" class="form-control" name="username" placeholder="Email" required autofocus>
                    <br>
                    <input type="password" class="form-control" name="password" required placeholder="Password">
                    <label class="checkbox">
                        <span class="pull-right">
                            <a data-toggle="modal" href="login.html#myModal"> Forgot Password?</a>
                        </span>
                    </label>
                    <button class="btn btn-theme btn-block" name="submit" type="submit"><i class="fa fa-lock"></i> SIGN IN</button>
                    <hr>
                </div>
            </form>

            <!-- Modal -->
            <form class="form-login" name="forgot" method="post">
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Forgot Password?</h4>
                            </div>
                            <div class="modal-body">
                                <p>Enter your details below to reset your password.</p>
                                <input type="email" name="email" placeholder="Email" autocomplete="off" class="form-control" required><br >
                                <input type="text" name="contact" placeholder="Contact No" autocomplete="off" class="form-control" required><br>
                                <input type="password" class="form-control" placeholder="New Password" id="password" name="password" required><br />
                                <input type="password" class="form-control unicase-form-control text-input" placeholder="Confirm Password" id="confirmpassword" name="confirmpassword" required>
                            </div>
                            <div class="modal-footer">
                                <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                                <button class="btn btn-theme" type="submit" name="change" onclick="return valid();">Submit</button>
                            </div>
                        </div>
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
