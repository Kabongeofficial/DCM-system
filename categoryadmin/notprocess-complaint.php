<?php
session_start();
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    date_default_timezone_set('Asia/Kolkata'); // change according to the timezone
    $currentTime = date('d-m-Y h:i:s A', time());
    // Retrieve the admin's ID
    $adminID = $_SESSION['id'];
    $adminType = $_SESSION['userType'];
    if ($adminType == 'minister') {
        // Retrieve the admin's category
        $query = mysqli_query($bd, "SELECT ministryName FROM minister WHERE id = '$adminID'");
        if (!$query) {
            // Query execution failed
            echo "Error: " . mysqli_error($bd);
            // You can handle the error in a way that suits your application
        } else {
            // Query executed successfully, check if there is a row
            if (mysqli_num_rows($query) > 0) {
                // Fetch the category from the result
                $row = mysqli_fetch_assoc($query);
                $adminCategory = $row['ministryName'];
            } else {
                // Admin ID not found in the admincategory table
                echo "Error: Admin ID not found.";
                // You can handle the error in a way that suits your application
            }
        }
    }

    if ($adminType == 'judge') {
        // Retrieve the admin's category
        $query = mysqli_query($bd, "SELECT unit FROM judge WHERE id = '$adminID'");
        if (!$query) {
            // Query execution failed
            echo "Error: " . mysqli_error($bd);
            // You can handle the error in a way that suits your application
        } else {
            // Query executed successfully, check if there is a row
            if (mysqli_num_rows($query) > 0) {
                // Fetch the category from the result
                $row = mysqli_fetch_assoc($query);
                $adminCategory = $row['unit'];
            } else {
                // Admin ID not found in the admincategory table
                echo "Error: Admin ID not found.";
                // You can handle the error in a way that suits your application
            }
        }

    }

    

    
    ?>
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin | Closed Complaints</title>

        <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link type="text/css" href="css/theme.css" rel="stylesheet">
        <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
        <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>

        <!-- Bootstrap core CSS -->
        <link href="assets/css/bootstrap.css" rel="stylesheet">
        <!--external css-->
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="assets/js/bootstrap-datepicker/css/datepicker.css" />
        <link rel="stylesheet" type="text/css" href="assets/js/bootstrap-daterangepicker/daterangepicker.css" />
        <link href="assets/css/style.css" rel="stylesheet">
        <link href="assets/css/style-responsive.css" rel="stylesheet">

        <script language="javascript" type="text/javascript">
            var popUpWin = 0;
            function popUpWindow(URLStr, left, top, width, height) {
                if (popUpWin) {
                    if (!popUpWin.closed) popUpWin.close();
                }
                popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width=' + 500 + ',height=' + 600 + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
            }
        </script>
    </head>
    <body>

    <section id="container">
        <?php include('includes/header.php'); ?>
        <?php include('includes/sidebar.php'); ?>
        <section id="main-content">
            <section class="wrapper">
                <div class="row mt">
                    <div class="span9">
                        <div class="content">
                            <div class="module">
                                <div class="module-head">
                                    <h3>Closed Complaints</h3>
                                </div>
                                <div class="module-body table">
                                    <table cellpadding="0" cellspacing="0" border="0"
                                           class="datatable-1 table table-bordered table-striped display">
                                        <thead>
                                        <tr>
                                            <th>Complaint No</th>
                                            <th>Complainant Name</th>
                                            <th>Reg Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $querys = null;
                                        if($adminType == 'minister'){
                                            $querys = mysqli_query($bd, "SELECT tblcomplaints.*, users.fullName AS name FROM tblcomplaints JOIN users ON users.id = tblcomplaints.userId WHERE tblcomplaints.status IS NULL AND tblcomplaints.ministry = '$adminCategory'");
                                        }
                                        if($adminType == 'judge'){
                                            $querys = mysqli_query($bd, "SELECT tblcomplaints.*, users.fullName AS name FROM tblcomplaints JOIN users ON users.id = tblcomplaints.userId WHERE tblcomplaints.status IS NULL AND tblcomplaints.unit = '$adminCategory'");

                                        }
                                        if($adminType == 'president'){
                                            $querys = mysqli_query($bd, "SELECT tblcomplaints.*, users.fullName AS name FROM tblcomplaints JOIN users ON users.id = tblcomplaints.userId WHERE tblcomplaints.status IS NULL");
                                        }
                                         if (!$querys) {
                                            // Query execution failed
                                            echo "Error: " . mysqli_error($bd);
                                            // You can handle the error in a way that suits your application
                                        } else {
                                            // Query executed successfully, check if there are any rows
                                            if (mysqli_num_rows($querys) > 0) {
                                                // Fetch and display the data
                                                while ($rows = mysqli_fetch_assoc($querys)) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo htmlentities($rows['complaintNumber']);?></td>
                                                        <td><?php echo htmlentities($rows['name']);?></td>
                                                        <td><?php echo htmlentities($rows['regDate']);?></td>
                                                        <td><button type="button" class="btn btn-danger">Not processed yet</button></td>
                                                        <td><a href="complaint-details.php?cid=<?php echo htmlentities($rows['complaintNumber']);?>">View Details</a></td>
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                // No complaints found in the education category
                                                echo "<tr><td colspan='5'>No complaints found in the education category.</td></tr>";
                                            }
                                        }

                                        // Remember to close the database connection
                                        mysqli_close($bd);
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div><!--/.content-->
                    </div><!--/.span9-->
                </div>
            </section>
        </section>
    </section><!--/.container-->

    <?php include('includes/footer.php'); ?>

    <script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
    <script src="scripts/datatables/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function () {
            $('.datatable-1').dataTable();
            $('.dataTables_paginate').addClass("btn-group datatable-pagination");
            $('.dataTables_paginate > a').wrapInner('<span />');
            $('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
            $('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
        });
    </script>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>

    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

    <!--script for this page-->
    <script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>

    <!--custom switch-->
    <script src="assets/js/bootstrap-switch.js"></script>

    <!--custom tagsinput-->
    <script src="assets/js/jquery.tagsinput.js"></script>

    <!--custom checkbox & radio-->
    <script type="text/javascript" src="assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap-daterangepicker/date.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap-daterangepicker/daterangepicker.js"></script>

    <script type="text/javascript" src="assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>

    <script src="assets/js/form-component.js"></script>

    <script>
        //custom select box
        $(function () {
            $('select.styled').customSelect();
        });
    </script>
    </body>
    <?php
}
?>