<aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
              
              	  <p class="centered"><a href="profile.html"><img src="assets/img/ui-sam.jpg" class="img-circle" width="60"></a></p>
                   <?php $query=mysqli_query($bd, "select username from admincategory where email='".$_SESSION['login']."'");
 while($row=mysqli_fetch_array($query)) 
 {
 ?> 
              	  <h5 class="centered"><?php echo htmlentities($row['username']);?></h5>
                  <?php } ?>
              	  	
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
                $adminId = $_SESSION['id'];
                $queryAdmin = "SELECT categoryName FROM admincategory WHERE id = '$adminId'";
                $resultAdmin = mysqli_query($bd, $queryAdmin);
                $rowAdmin = mysqli_fetch_assoc($resultAdmin);
                $adminCategory = $rowAdmin['categoryName'];

                $rt = mysqli_query($bd, "SELECT * FROM tblcomplaints WHERE status IS NULL AND category = '$adminCategory'");
                $num1 = mysqli_num_rows($rt);
                {?>
                    <b class="label orange pull-right"><?php echo htmlentities($num1); ?></b>
                <?php } ?>
            </a>
        </li>
        <li class="sub-menu">
            <a href="inprocess-complaint.php">
                <i class="icon-tasks"></i>
                Pending Complaint
                <?php
                $adminId = $_SESSION['id'];
                $queryAdmin = "SELECT categoryName FROM admincategory WHERE id = '$adminId'";
                $resultAdmin = mysqli_query($bd, $queryAdmin);
                $rowAdmin = mysqli_fetch_assoc($resultAdmin);
                $adminCategory = $rowAdmin['categoryName'];

                $status = "in Process";
                $rt = mysqli_query($bd, "SELECT * FROM tblcomplaints WHERE status = '$status' AND category = '$adminCategory'");
                $num1 = mysqli_num_rows($rt);
                {?>
                    <b class="label orange pull-right"><?php echo htmlentities($num1); ?></b>
                <?php } ?>
            </a>
        </li>
        <li>
            <a href="closed-complaint.php">
                <i class="icon-inbox"></i>
                Closed Complaints
                <?php
                $adminId = $_SESSION['id'];
                $queryAdmin = "SELECT categoryName FROM admincategory WHERE id = '$adminId'";
                $resultAdmin = mysqli_query($bd, $queryAdmin);
                $rowAdmin = mysqli_fetch_assoc($resultAdmin);
                $adminCategory = $rowAdmin['categoryName'];

                $status = "closed";
                $rt = mysqli_query($bd, "SELECT * FROM tblcomplaints WHERE status = '$status' AND category = '$adminCategory'");
                $num1 = mysqli_num_rows($rt);
                {?>
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