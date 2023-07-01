<?php
session_start();
include('includes/config.php');

//Load Composer's autoloader
require '../vendor/autoload.php';

if (strlen($_SESSION['login']) == 0) { 
    header('location:index.php');
} else {
    if (isset($_POST['update'])) {
        $complaintnumber = $_GET['cid'];
        $status = $_POST['status'];
        $remark = $_POST['remark'];

        // Insert complaint remark
        $query = mysqli_query($bd, "insert into complaintremark(complaintNumber,status,remark) values('$complaintnumber','$status','$remark')");

        // Update complaint status
        $sql = mysqli_query($bd, "update tblcomplaints set status='$status' where complaintNumber='$complaintnumber'");

        // Get user email and name
       $complaintInfo = mysqli_query($bd, "SELECT u.fullName, u.userEmail FROM tblcomplaints c JOIN users u ON c.userId = u.id WHERE c.complaintNumber = '$complaintnumber'");
        $row = mysqli_fetch_assoc($complaintInfo);
        $userName = $row['fullName'];
        $userEmail = $row['userEmail'];

        echo "<script>alert('Complaint details updated successfully');</script>";

        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom("Darusocomplaint@outlook.com", "Daruso");
        $email->setSubject("Complaints");
        $email->addTo($userEmail, $userName);
        $email->addContent("text/plain", "please visit now Daruso Compliant Management system to track the status of your compliant");
        $email->addContent(
            "text/html", "<strong>please visit now Daruso Compliant Management system to track the status of your compliant</strong>"
        );
        $sendgrid = new \SendGrid("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");
        try {
            $response = $sendgrid->send($email);
            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
    }
}
?>

<script language="javascript" type="text/javascript">
function f2() {
    window.close();
}

function f3() {
    window.print(); 
}
</script>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>User Profile</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="anuj.css" rel="stylesheet" type="text/css">
</head>
<body>

<div style="margin-left:50px;">
 <form name="updateticket" id="updatecomplaint" method="post"> 
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr height="50">
      <td><b>Complaint Number</b></td>
      <td><?php echo htmlentities($_GET['cid']); ?></td>
    </tr>
    <tr height="50">
      <td><b>Status</b></td>
      <td>
        <select name="status" required="required">
          <option value="">Select Status</option>
          <option value="in process">In Process</option>
          <option value="closed">Closed</option>
        </select>
      </td>
    </tr>
    <tr height="50">
      <td><b>Remark</b></td>
      <td><textarea name="remark" cols="50" rows="10" required="required"></textarea></td>
    </tr>
    <tr height="50">
      <td>&nbsp;</td>
      <td><input type="submit" name="update" value="Submit"></td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr>
      <td></td>
      <td>   
        <input name="Submit2" type="submit" class="txtbox4" value="Close this window" onClick="return f2();" style="cursor: pointer;"  />
      </td>
    </tr>
</table>
 </form>
</div>

</body>
</html>