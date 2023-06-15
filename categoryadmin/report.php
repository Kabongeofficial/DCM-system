<?php
session_start();
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {	
    header('location:index.php');
} else {
    date_default_timezone_set('Asia/Kolkata'); // change according to your timezone
    $currentTime = date('d-m-Y h:i:s A', time());
    // Retrieve the admin's category
    $adminId = $_SESSION['id'];
    $queryAdmin = "SELECT categoryName FROM admincategory WHERE id = '$adminId'";
    $resultAdmin = mysqli_query($bd, $queryAdmin);
    $rowAdmin = mysqli_fetch_assoc($resultAdmin);
    $adminCategory = $rowAdmin['categoryName'];

    // Fetch distinct years from the tblcomplaints table
    $queryYears = "SELECT DISTINCT YEAR(regDate) AS year FROM tblcomplaints WHERE category = '$adminCategory'";
    $resultYears = mysqli_query($bd, $queryYears);
    $years = array();
    while ($row = mysqli_fetch_assoc($resultYears)) {
        $years[] = $row['year'];
    }
    
    // Set the default year filter
    $selectedYear = isset($_GET['year']) ? $_GET['year'] : $years[0];
    
    $status = isset($_GET['status']) ? $_GET['status'] : 'all';
    $statusCondition = ($status == 'all') ? '' : "AND status = '$status'";
    
    $queryYear = "SELECT MONTH(regDate) AS month, COUNT(*) AS count FROM tblcomplaints WHERE YEAR(regDate) = '$selectedYear' AND category = '$adminCategory' $statusCondition GROUP BY MONTH(regDate)";
    $resultYear = mysqli_query($bd, $queryYear);
    
    $yearData = array(
        array('Month', 'Number of Complaints')
    );

    // Initialize month names
    $monthNames = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');

    // Initialize counts for all months to 0
    $monthCounts = array_fill(1, 12, 0);
    
     while ($row = mysqli_fetch_assoc($resultYear)) {
        $month = (int)$row['month'];
        $count = (int)$row['count'];
        $monthCounts[$month] = $count;
    }

    // Populate yearData array with month names and counts
    for ($month = 1; $month <= 12; $month++) {
        $monthName = $monthNames[$month - 1];
        $count = $monthCounts[$month];
        $yearData[] = array($monthName, $count);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Complaint Reports</title>
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
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawYearChart);
        
        function drawYearChart() {
            var data = google.visualization.arrayToDataTable(<?php echo json_encode($yearData); ?>);
            
            var options = {
                title: 'Complaints by Month (<?php echo $selectedYear; ?>)',
                vAxis: {title: 'Number of Complaints'},
                hAxis: {title: 'Month'},
                legend: {position: 'none'}
            };
            
            var chart = new google.visualization.ColumnChart(document.getElementById('year-chart'));
            chart.draw(data, options);
        }
    </script>
</head>
<body>
    <section id="container">
    <?php include('includes/header.php');?>
    <?php include('includes/sidebar.php');?>
    <section id="main-content">
    <section class="wrapper">
        <div class="container">
            <div class="row mt">
                <div class="span9">
                    <div class="content">
                        <div class="module">
                            <div class="module-head">
                                <h3>Complaint Reports</h3>
                            </div>
                            <div class="module-body">
                                <div class="row">
                                    <!-- Add the year filter select input -->
                                    <div class="span3">
                                        <div class="control-group">
                                            <label class="control-label" for="year-filter">Filter by Year:</label>
                                            <div class="controls">
                                                <select id="year-filter" name="year" onchange="updateYearChart(this.value)">
                                                    <?php foreach ($years as $year) {
                                                        $selected = ($year == $selectedYear) ? 'selected' : '';
                                                        echo "<option value=\"$year\" $selected>$year</option>";
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="span8">
                                        <div class="widget widget-table action-table">
                                            <div class="widget-header">
                                                <h3>Year View</h3>
                                            </div>
                                            <div class="widget-content">
                                                <div id="year-chart" style="width: 100%; height: 300px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!--/.content-->
                </div><!--/.span9-->
            </div>
        </div><!--/.container-->
    </section>    
    </section><!--/.wrapper-->
    </section>

    <?php include('includes/footer.php');?>

    <script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
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
        function updateYearChart(year) {
            var chartData = <?php echo json_encode($yearData); ?>;

            // Apply the year filter
            chartData = chartData.filter(function(item) {
                return item[0] !== 'Month';
            });

            // Update the chart with the filtered data
            var data = google.visualization.arrayToDataTable(chartData);
            var options = {
                title: 'Complaints by Month (' + year + ')',
                vAxis: {title: 'Number of Complaints'},
                hAxis: {title: 'Month'},
                legend: {position: 'none'}
            };
            var chart = new google.visualization.ColumnChart(document.getElementById('year-chart'));
            chart.draw(data, options);
        }

        // Call the updateYearChart function with the selected year on page load
        $(document).ready(function() {
            var selectedYear = '<?php echo $selectedYear; ?>';
            updateYearChart(selectedYear);
        });
    </script>
</body>
</html>
<?php } ?>