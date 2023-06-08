<?php
session_start();
include('include/config.php');

if(strlen($_SESSION['alogin'])==0)
{	
    header('location:index.php');
}
else {
    date_default_timezone_set('Asia/Kolkata'); // change according to your timezone
    $currentTime = date('d-m-Y h:i:s A', time());

    if(isset($_POST['submit'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $category = $_POST['category'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $contactno = $_POST['contactno'];

        // Check if username or email already exists
        $checkUsernameQuery = mysqli_query($bd, "SELECT * FROM adminCategory WHERE username = '$username'");
        $checkEmailQuery = mysqli_query($bd, "SELECT * FROM adminCategory WHERE email = '$email'");

        if(mysqli_num_rows($checkUsernameQuery) > 0) {
            $msg = "Username already exists. Please choose a different username.";
        } elseif(mysqli_num_rows($checkEmailQuery) > 0) {
            $msg = "Email already exists. Please use a different email address.";
        } else {
            // Insert new admin record
            $query = mysqli_query($bd, "INSERT INTO adminCategory (username, email, categoryName, password, contactno) VALUES ('$username', '$email', '$category', '$password', '$contactno')");

            if($query) {
                $msg = "Registration successful. Now you can login!";
            } else {
                $msg = "Registration failed. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Registration</title>
    <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link type="text/css" href="css/theme.css" rel="stylesheet">
    <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
    <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
</head>
<body>
    <?php include('include/header.php'); ?>

    <div class="wrapper">
        <div class="container">
            <div class="row">
                <?php include('include/sidebar.php'); ?>    
                <div class="span9">
                    <div class="content">
                        <div class="module">
                            <div class="module-head">
                                <h3>Add Admin according to category</h3>
                            </div>
                            <div class="module-body">
                                <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                                    <p style="padding-left: 1%; color: green">
                                        <?php if(isset($msg)) { echo htmlentities($msg); } ?>
                                    </p>
                                    <label for="username">User Name:</label>
                                    <input type="text" id="username" name="username" required><br>

                                    <label for="email">Email:</label>
                                    <input type="email" id="email" name="email" required><br>

                                    <label for="category">Category:</label>
                                    <select name="category" id="category" class="form-control" onChange="getCat(this.value);" required="">
                                        <option value="">Select Category</option>
                                        <?php 
                                            $sql = mysqli_query($bd, "SELECT id, categoryName FROM category");
                                            while($rw = mysqli_fetch_array($sql)) {
                                                echo '<option value="'.htmlentities($rw['id']).'">'.htmlentities($rw['categoryName']).'</option>';
                                            }
                                        ?>
                                    </select>

                                    <label for="password">Password:</label>
                                    <input type="password" id="password" name="password" required><br>

                                    <label for="contactno">Contact Number:</label>
                                    <input type="text" id="contactno" name="contactno" required><br>

                                    <input type="submit" name="submit" value="Add Admin" class="btn btn-primary">
                                </form>
                            </div>
                        </div>
                        
                    </div>
                </div>            
            </div>
        </div>
    </div>

    <?php include('include/footer.php'); ?>
    <script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>
