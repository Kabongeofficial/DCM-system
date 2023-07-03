<?php
session_start();
include('include/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    date_default_timezone_set('Asia/Kolkata'); // change according to your timezone
    $currentTime = date('d-m-Y h:i:s A', time());

    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $position = $_POST['position'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $contactno = $_POST['contactno'];

        if ($position === 'minister') {
            $ministryName = $_POST['ministryName'];

            $query = mysqli_query($bd, "INSERT INTO minister (username, email, position, ministryName, contactno, password) 
                                        VALUES ('$username', '$email', '$position', '$ministryName', '$contactno', '$password')");

            if ($query) {
                $msg = "Minister registration successful!";
            } else {
                $msg = "Error in minister registration. Please try again.";
            }
        } elseif ($position === 'judge') {
            $unit = $_POST['unit'];

            $query = mysqli_query($bd, "INSERT INTO judge (username, email, position, unit, contactno, password) 
                                        VALUES ('$username', '$email', '$position', '$unit', '$contactno', '$password')");

            if ($query) {
                $msg = "Judge registration successful!";
            } else {
                $msg = "Error in judge registration. Please try again.";
            }
        } elseif ($position === 'president') {
            $query = mysqli_query($bd, "INSERT INTO president (username, email, position, contactno, password) 
                                        VALUES ('$username', '$email', '$position', '$contactno', '$password')");

            if ($query) {
                $msg = "President registration successful!";
            } else {
                $msg = "Error in president registration. Please try again.";
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
    <title>Minister | Registration</title>
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
                                <h3>Add Admin according to Position</h3>
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

                                    <lable>Position:</lable>
                                    <select id="position" name="position" onchange="handlePositionChange();" required>
                                        <option value="" disabled selected>Select position</option>
                                        <option value="judge">Judge</option>
                                        <option value="president">President</option>
                                        <option value="minister">Minister</option>
                                    </select>

                                    <div id="ministryFields" style="display: none;">
                                        <label for="ministry">Ministry:</label>
                                        <select name="ministryName" id="ministryName" class="form-control">
                                            <option value="">Select Ministry</option>
                                            <?php 
                                                $sql = mysqli_query($bd, "SELECT id, ministryName FROM ministry");
                                                while($rw = mysqli_fetch_array($sql)) {
                                                    echo '<option value="'.htmlentities($rw['id']).'">'.htmlentities($rw['ministryName']).'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <div id="collegeField" style="display: none;">
                                        <label for="unit">Unit:</label>
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
                                    </div>

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
    <script>
       function handlePositionChange() {
            var positionSelect = document.getElementById('position');
            var ministryFieldsDiv = document.getElementById('ministryFields');
            var collegeFieldDiv = document.getElementById('collegeField');

            if (positionSelect.value === 'minister') {
                ministryFieldsDiv.style.display = 'block';
                collegeFieldDiv.style.display = 'none';
                document.getElementById('ministryName').required = true;
                document.getElementsByName('unit')[0].required = false;
            } else if (positionSelect.value === 'judge') {
                ministryFieldsDiv.style.display = 'none';
                collegeFieldDiv.style.display = 'block';
                document.getElementById('ministryName').required = false;
                document.getElementsByName('unit')[0].required = true;
            } else {
                ministryFieldsDiv.style.display = 'none';
                collegeFieldDiv.style.display = 'none';
                document.getElementById('ministryName').required = false;
                document.getElementsByName('unit')[0].required = false;
            }
        }

    </script>
</body>
</html>
