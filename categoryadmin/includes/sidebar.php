<aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
              
              	  <p class="centered"><a href="profile.html"><img src="assets/img/ui-sam.jpg" class="img-circle" width="60"></a></p>
                    <?php
                        $userType = $_SESSION['userType'];
                        $username = "";

                        if ($userType == "minister") {
                            $query = mysqli_query($bd, "SELECT username FROM minister WHERE email='" . $_SESSION['login'] . "'");
                            $row = mysqli_fetch_assoc($query);
                            $username = htmlentities($row['username']);
                        } elseif ($userType == "judge") {
                            $query = mysqli_query($bd, "SELECT username FROM judge WHERE email='" . $_SESSION['login'] . "'");
                            $row = mysqli_fetch_assoc($query);
                            $username = htmlentities($row['username']);
                        } elseif ($userType == "president") {
                            $query = mysqli_query($bd, "SELECT username FROM president WHERE email='" . $_SESSION['login'] . "'");
                            $row = mysqli_fetch_assoc($query);
                            $username = htmlentities($row['username']);
                        }
                        ?>

                        <h5 class="centered"><?php echo $username; ?></h5>
              	  	
                  <li class="mt">
                      <a href="dashboard.php">
                          <i class="fa fa-dashboard"></i>
                          <span>Dashboard</span>
                      </a>
                  </li>


                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-cogs"></i>
                          <span>Account Setting</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="profile.php">Profile</a></li>
                          <li><a  href="change-password.php">Change Password</a></li>
                        
                      </ul>
                  </li>
                  <li class="sub-menu">
    <a class="collapsed" data-toggle="collapse" href="#togglePages">
        <i class="menu-icon icon-cog"></i>
        <i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>
        Manage Complaint
    </a>
    <ul id="togglePages" class="collapse unstyled">
        <li>
            <a href="notprocess-complaint.php">
                <i class="icon-tasks"></i>
                Not Process Yet Complaint
               
                <?php
                                if ($adminType == 'minister') {
                                    $adminId = $_SESSION['id'];
                                    $queryAdmin = "SELECT ministryName FROM minister WHERE id = '$adminId'";
                                    $resultAdmin = mysqli_query($bd, $queryAdmin);
                                    $rowAdmin = mysqli_fetch_assoc($resultAdmin);
                                    $adminCategory = $rowAdmin['ministryName'];

                                    $rt = mysqli_query($bd, "SELECT * FROM tblcomplaints WHERE  status IS NULL AND ministry = '$adminCategory'");
                                    $num1 = mysqli_num_rows($rt);
                                    // Remove the extra curly brace here {
                                ?>
                                    <b class="label orange pull-right"><?php echo htmlentities($num1); ?></b>
                                <?php } ?>

                                <?php
                                if ($adminType == 'judge') {
                                    $adminId = $_SESSION['id'];
                                    $queryAdmin = "SELECT unit FROM judge WHERE id = '$adminId'";
                                    $resultAdmin = mysqli_query($bd, $queryAdmin);
                                    $rowAdmin = mysqli_fetch_assoc($resultAdmin);
                                    $adminUnit = $rowAdmin['unit'];

                                    $rt = mysqli_query($bd, "SELECT * FROM tblcomplaints WHERE  status IS NULL AND unit = '$adminUnit'");
                                    $num1 = mysqli_num_rows($rt);
                                    // Remove the extra curly brace here {
                                ?>
                                    <<b class="label orange pull-right"><?php echo htmlentities($num1); ?></b>
                                <?php } ?>

                                <?php
                                if ($adminType == 'president') {

                                    $rt = mysqli_query($bd, "SELECT * FROM tblcomplaints WHERE  status IS NULL");
                                    $num1 = mysqli_num_rows($rt);
                                    // Remove the extra curly brace here {
                                ?>
                                    <b class="label orange pull-right"><?php echo htmlentities($num1); ?></b>
                                <?php } ?>
            </a>
        </li>
        <li class="sub-menu">
            <a href="inprocess-complaint.php">
                <i class="icon-tasks"></i>
                Pending Complaint
                <?php
                                if ($adminType == 'minister') {
                                    $adminId = $_SESSION['id'];
                                    $queryAdmin = "SELECT ministryName FROM minister WHERE id = '$adminId'";
                                    $resultAdmin = mysqli_query($bd, $queryAdmin);
                                    $rowAdmin = mysqli_fetch_assoc($resultAdmin);
                                    $adminCategory = $rowAdmin['ministryName'];

                                    $status = "in process";
                                        $rt = mysqli_query($bd, "SELECT * FROM tblcomplaints WHERE  status = '$status' AND ministry = '$adminCategory'");
                                        $num1 = mysqli_num_rows($rt);
                                        
                                        ?>
                                           <b class="label orange pull-right"><?php echo htmlentities($num1); ?></b>
                                <?php } ?>

                                <?php
                                if ($adminType == 'judge') {
                                    $adminId = $_SESSION['id'];
                                    $queryAdmin = "SELECT unit FROM judge WHERE id = '$adminId'";
                                    $resultAdmin = mysqli_query($bd, $queryAdmin);
                                    $rowAdmin = mysqli_fetch_assoc($resultAdmin);
                                    $adminUnit = $rowAdmin['unit'];

                                    $status = "in process";
                                        $rt = mysqli_query($bd, "SELECT * FROM tblcomplaints WHERE  status = '$status' AND unit = '$adminUnit'");
                                        $num1 = mysqli_num_rows($rt);
                                        
                                        ?>
                                            <b class="label orange pull-right"><?php echo htmlentities($num1); ?></b>
                                <?php } ?>

                                <?php
                                if ($adminType == 'president') {

                                    $status = "in process";
                                        $rt = mysqli_query($bd, "SELECT * FROM tblcomplaints WHERE  status = '$status'");
                                        $num1 = mysqli_num_rows($rt);
                                        
                                        ?>
                                            <b class="label orange pull-right"><?php echo htmlentities($num1); ?></b>
                                <?php } ?>
            </a>
        </li>
        <li>
            <a href="closed-complaint.php">
                <i class="icon-inbox"></i>
                Closed Complaints

                <?php
                    if ($adminType == 'minister') {
                        $adminId = $_SESSION['id'];
                        $queryAdmin = "SELECT ministryName FROM minister WHERE id = '$adminId'";
                        $resultAdmin = mysqli_query($bd, $queryAdmin);
                        $rowAdmin = mysqli_fetch_assoc($resultAdmin);
                        $adminCategory = $rowAdmin['ministryName'];

                        $status = "closed";
                            $rt = mysqli_query($bd, "SELECT * FROM tblcomplaints WHERE  status = '$status' AND ministry = '$adminCategory'");
                            $num1 = mysqli_num_rows($rt);
                            
                            ?>
                                <b class="label green pull-right"><?php echo htmlentities($num1); ?></b>
                    
                    <?php } ?>

                    <?php
                    if ($adminType == 'judge') {
                        $adminId = $_SESSION['id'];
                        $queryAdmin = "SELECT unit FROM judge WHERE id = '$adminId'";
                        $resultAdmin = mysqli_query($bd, $queryAdmin);
                        $rowAdmin = mysqli_fetch_assoc($resultAdmin);
                        $adminUnit = $rowAdmin['unit'];

                        $status = "closed";
                            $rt = mysqli_query($bd, "SELECT * FROM tblcomplaints WHERE  status = '$status' AND unit = '$adminUnit'");
                            $num1 = mysqli_num_rows($rt);
                            
                            ?>
                                <b class="label green pull-right"><?php echo htmlentities($num1); ?></b>
                    <?php } ?>

                    <?php
                    if ($adminType == 'president') {

                        $status = "closed";
                            $rt = mysqli_query($bd, "SELECT * FROM tblcomplaints WHERE  status = '$status'");
                            $num1 = mysqli_num_rows($rt);
                            
                            ?>
                                <b class="label green pull-right"><?php echo htmlentities($num1); ?></b>
                    <?php } ?>
            </a>
        </li>
    </ul>
</li>
                  <li class="sub-menu">
                      <a href="report.php" >
                          <i class="fa fa-tasks"></i>
                          <span>Complaint Report</span>
                      </a>
                      
                  </li>
                 
              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>