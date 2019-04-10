<?php
	require_once("include/DB.php");
	require_once("include/session.php");
	require_once("include/functions.php");
?>
<?php Confirm_Login(); ?>

<?php
if(isset($_POST["Submit"])){
$Username=($_POST["Username"]);
$Password=($_POST["Password"]);
$ConfirmPassword=($_POST["ConfirmPassword"]);
date_default_timezone_set("Asia/Kolkata");
$CurrentTime=time();
//$DateTime=strftime("%Y-%m-%d %H:%M:%S",$CurrentTime);
$DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
$DateTime;
$Admin=$_SESSION["Username"];
if(empty($Username)||empty($Password)||empty($ConfirmPassword)){
	$_SESSION["ErrorMessage"]="All Fields must be filled out";
	Redirect_to("manageadmins.php");
	
}elseif(strlen($Password)<4){
	$_SESSION["ErrorMessage"]="Atleast 4 Characters For Password are required";
	Redirect_to("manageadmins.php");
	
}elseif($Password!==$ConfirmPassword){
	$_SESSION["ErrorMessage"]="Password / ConfirmPassword does not match";
	Redirect_to("manageadmins.php");
	
}
else{
	global $Connection;
	$Query="INSERT INTO registration(datetime,username,password,addedby)
	VALUES('$DateTime','$Username','$Password','$Admin')";
	$Execute=mysqli_query($Connection,$Query);
	if($Execute){
	$_SESSION["SuccessMessage"]="Admin Added Successfully";
	Redirect_to("manageadmins.php");
	}else{
	$_SESSION["ErrorMessage"]="Category failed to Add";
	Redirect_to("manageadmins.php");
		
	}
	
}	
	
}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Manage Admins</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<script src="js/jquery-min-3.2.1.min.js" ></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/adminstyle.css">
<style type="text/css">
	.FieldInfo{
		color:rgb(251,174,44);
		font-size: 1.2em;
		font-family: Bitter,Georgia,"Times New Roman", Times, serif;
	}
</style>
</head>

<body>
	<div style="height: 10px; background: #27aae1;"></div>
	<nav class="navbar navbar-inverse" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapsed" data-target="#collapse">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="index.php" class="navbar-brand">
					<img src="images/manis.png" style="margin-top: -8px;margin-left: -68px" width="250" height="40">
				</a>
				
			</div>
			<div class="collapse navbar-collapse" id="collapse">
			<ul class="nav navbar-nav" style="margin-left: 12px; ">
				<li class="active"><a href="index.php">Home</a></li>
				<li><a href="#">Teams</a></li>
				<li><a href="#">About Us</a></li>
				
				<li><a href="#">Contact Us</a></li>
				<li><a href="adminlogin.php">Administrator Login</a></li>
				
			</ul>
			<form action="index.php" class="navbar-form navbar-right">
				<div class="form-group">
					<input type="text" name="Search" placeholder="Search" class="form-control">
				</div>
				<button class="btn btn-default" name="SearchButton">Search</button>
			</form>
		</div>
	</nav>
	<div class="Line" style="height: 10px; background: #27aae1;"></div>

	<!---Ending Navigation Bar-->
	<div class="container-fluid">
		<div class="row">
			
			<div class="col-sm-2">
				<br><br>
				
				<ul id="Side_Menu" class="nav nav-pills nav-stacked">
					<li ><a href="Dashboard.php"><span class="glyphicon glyphicon-home"></span> Dashboard</a></li>
					<li><a href="addnewpost.php"><span class="glyphicon glyphicon-list-alt"></span> &nbsp;Add New Player</a></li>
					<li><a href="categories.php"><span class="glyphicon glyphicon-tags"></span> &nbsp;Teams</a></li>
					
					
					<li class="active"><a href="manageadmins.php"><span class="glyphicon glyphicon-user"></span> Manage Admins</a></li>
					<li><a href="comments.php"><span class="glyphicon glyphicon-comment"></span> Comments
		<!--Count number of Un-Approved Comments Code Starts--->
				<?php
					$Connection;
					$TotalUnApproved_Query="SELECT COUNT(*) FROM comment WHERE status='OFF'";
					$ApprovedExecute = mysqli_query($Connection,$TotalUnApproved_Query);
					$RowUnApproved = mysqli_fetch_array($ApprovedExecute);
					$TotalUnApproved = array_shift($RowUnApproved);//Shifting array value in to String or Number
					if($TotalUnApproved>0){

				?>
				<span class="label label-warning pull-right">
					<?php echo $TotalUnApproved; ?>
				</span>
			<?php } ?> <!--Count number of Un-Approved Comments Code Ending-->
					</a>
					</li>
					<li><a href="#"><span class="glyphicon glyphicon-equalizer"></span> Current Stats</a></li>
					<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
				</ul>
			</div><!-- Ending of Side Area-->
			<div class="col-sm-10">
				<h1>Add New Admins</h1>

				<div><?php echo Message(); 
							echo SuccessMessage();
					?></div>

				<div>
					<form action="manageadmins.php" method="POST">
						<fieldset>
						<div class="form-group">
						<label for="username"><span class="FieldInfo">Username: </span></label>
						<input class="form-control" type="text" name="Username" id="username" placeholder="Username ">

						<label for="password"><span class="FieldInfo">Password: </span></label>
						<input class="form-control" type="password" name="Password" id="password" placeholder="Password ">

						<label for="confirmpassword"><span class="FieldInfo">Confirm Password: </span></label>
						<input class="form-control" type="password" name="ConfirmPassword" id="confirmpassword" placeholder="Re-Type Password ">
						
					</div>
					<br>
					<input class="btn btn-success btn-block" type="submit" name="Submit" value="Add New Admins">
				</fieldset>
					<br>
					</form>
				</div>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th>Sr No.</th>
							<th>Date and Time</th>
							<th>Admins Name</th>
							<th>Added By</th>
							<th>Action</th>
						</tr>

				<?php
					global $Connection;
					$View_Query = "SELECT * FROM registration ORDER BY datetime desc";
					$Execute = mysqli_query($Connection,$View_Query);
					$SrNo = 0;
					while($DataRows =mysqli_fetch_array($Execute)){
						$Number = $DataRows['id'];
						$DT = $DataRows['datetime'];
						$Name = $DataRows['username'];
						$AddedBy = $DataRows['addedby'];
						$SrNo++;
					
				?>

						<tr>
							<td> <?php echo $SrNo; ?></td>
							<td> <?php echo $DT; ?></td>
							<td> <?php echo $Name; ?></td>
							<td> <?php echo $AddedBy; ?></td>
							<td><a href="deleteadmins.php?id=<?php echo $Number; ?>">
								<span class="btn btn-danger">Delete</span>
							</a></td>
						</tr>
				<?php } ?>
					</table>
				</div>
			</div><!-- Ending of Main Area-->
		</div><!-- Ending of Row-->
	</div><!-- Ending of Container-->

	<div id="footer">
		<hr>
		<p>Developed by Manish Kumar | &copy;2018 ---All right released</p>
		<a href="https://www.facebook.com/manish.bs.kr"><p>This is Simple Admin Panel of The ProgrammerBlog </p></a>
		
	</div>
	<div style="background: #27AAE1; height: 10px;"></div>

</body>
</html>