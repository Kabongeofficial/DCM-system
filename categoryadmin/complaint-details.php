<?php
session_start();
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
	{	
header('location:index.php');
}
else{


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin| Complaint Details</title>
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
var popUpWin=0;
function popUpWindow(URLStr, left, top, width, height)
{
 if(popUpWin)
{
if(!popUpWin.closed) popUpWin.close();
}
popUpWin = open(URLStr,'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width='+600+',height='+600+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
}

</script>

</head>
<body>

<section id ="container">
<?php include('includes/header.php');?>
<?php include('includes/sidebar.php');?>				

	<section id="main-content">
				<section class="wrapper">				
		<div class="container mt">
			<div class="row">
			<div class="span9">
					<div class="content">

						


	<div class="module">
							<div class="module-head">
								<h3>Complaint Details</h3>
							</div>
							<div class="module-body table">
								<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display" width="100%">
									
									<tbody>

<?php $st='closed';
$query=mysqli_query($bd, "select tblcomplaints.*,users.fullName as name,category.categoryName as catname from tblcomplaints join users on users.id=tblcomplaints.userId join category on category.id=tblcomplaints.category where tblcomplaints.complaintNumber='".$_GET['cid']."'");
while($row=mysqli_fetch_array($query))
{

?>									
										<tr>
											<td><b>Complaint Number</b></td>
											<td><?php echo htmlentities($row['complaintNumber']);?></td>
											<td><b>Complainant Name</b></td>
											<td> <?php echo htmlentities($row['name']);?></td>
											<td><b>Reg Date</b></td>
											<td><?php echo htmlentities($row['regDate']);?>
											</td>
										</tr>

<tr>
											<td><b>Category </b></td>
											<td><?php echo htmlentities($row['catname']);?></td>
											<td><b>SubCategory</b></td>
											<td> <?php echo htmlentities($row['subcategory']);?></td>
											<td><b>Complaint Type</b></td>
											<td><?php echo htmlentities($row['complaintType']);?>
											</td>
										</tr>
<tr>
											<td><b>State </b></td>
											<td><?php echo htmlentities($row['state']);?></td>
											<td ><b>Nature of Complaint</b></td>
											<td colspan="3"> <?php echo htmlentities($row['noc']);?></td>
											
										</tr>
<tr>
											<td><b>Complaint Details </b></td>
											
											<td colspan="5"> <?php echo htmlentities($row['complaintDetails']);?></td>
											
										</tr>

											</tr>
<tr>
											<td><b>File(if any) </b></td>
											
											<td colspan="5"> <?php $cfile=$row['complaintFile'];
if($cfile=="" || $cfile=="NULL")
{
  echo "File NA";
}
else{?>
<a href="../users/complaintdocs/<?php echo htmlentities($row['complaintFile']);?>" ?> View File</a>
<?php } ?></td>
</tr>
<?php $ret=mysqli_query($bd, "select complaintremark.remark as remark,complaintremark.status as sstatus,complaintremark.remarkDate as rdate from complaintremark join tblcomplaints on tblcomplaints.complaintNumber=complaintremark.complaintNumber where complaintremark.complaintNumber='".$_GET['cid']."'");
while($rw=mysqli_fetch_array($ret))
{
?>
<tr>
<td><b>Remark</b></td>
<td colspan="5"><?php echo  htmlentities($rw['remark']); ?> <b>Remark Date <?php echo  htmlentities($rw['rdate']); ?></b></td>
</tr>

<tr>
<td><b>Status</b></td>
<td colspan="5"><?php echo  htmlentities($rw['sstatus']); ?></td>
</tr>
<?php }?>

<tr>
<td><b>Final Status</b></td>
											
											<td colspan="5"><?php if($row['status']=="")
											{ echo "Not Process Yet";
} else {
										 echo htmlentities($row['status']);
										 }?></td>
											
										</tr>



<tr>
											<td><b>Action</b></td>
											
											<td> 
											<?php if($row['status']=="closed"){

												} else {?>
<a href="javascript:void(0);" onClick="popUpWindow('http://localhost/Complaint Management System/categoryadmin/updatecomplaints.php?cid=<?php echo htmlentities($row['complaintNumber']);?>');" title="Update order">
											 <button type="button" class="btn btn-primary">Take Action</button></td>
											</a><?php } ?></td>
											<td colspan="4"> 
											<a href="javascript:void(0);" onClick="popUpWindow('http://localhost/Complaint Management System/categoryadmin/userprofile.php?uid=<?php echo htmlentities($row['userId']);?>');" title="Update order">
											 <button type="button" class="btn btn-primary">View User Detials</button></a></td>
											
										</tr>
										<?php  } ?>
										
								</table>
							</div>
						</div>						

						
						
					</div><!--/.content-->
				</div><!--/.span9-->
			</div>
		</div><!--/.container-->
		</section><!--/.wrapper-->
		</section>
	</section>

<?php include('includes/footer.php');?>

	<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
	<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
	<script src="scripts/datatables/jquery.dataTables.js"></script>
	<script>
		$(document).ready(function() {
			$('.datatable-1').dataTable();
			$('.dataTables_paginate').addClass("btn-group datatable-pagination");
			$('.dataTables_paginate > a').wrapInner('<span />');
			$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
			$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
		} );
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

      $(function(){
          $('select.styled').customSelect();
      });

  </script>
</body>
<?php } ?>