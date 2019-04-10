<?php
	require_once("include/DB.php");
	require_once("include/session.php");
	require_once("include/functions.php");
?>
<?php Confirm_Login(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin Dashboard</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<script src="js/jquery-min-3.2.1.min.js" ></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/adminstyle.css">
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
		</div>
	</nav>
	<div class="Line" style="height: 10px; background: #27aae1;"></div>

	<!---Ending Navigation Bar-->
	<div class="container-fluid">
		<div class="row">
			
			<div class="col-sm-2">
				<br><br>
				<ul id="Side_Menu" class="nav nav-pills nav-stacked">
					<li class="active"><a href="Dashboard.php"><span class="glyphicon glyphicon-home"></span> Dashboard</a></li>
					<li ><a href="addnewpost.php"><span class="glyphicon glyphicon-list-alt"></span> &nbsp;Add New Player</a></li>
					<li><a href="categories.php"><span class="glyphicon glyphicon-tags"></span> &nbsp;Teams</a></li>
					
					
					<li><a href="manageadmins.php"><span class="glyphicon glyphicon-user"></span> Manage Admins</a></li>
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
			<div class="col-sm-10"><!--Main Area-->
				<div><?php echo Message(); 
							echo SuccessMessage();
					?></div>
				<span class="lead glyphicon glyphicon-user pull-right" style="color:#1ab394;">&nbsp;<?php echo $_SESSION["Username"]; ?></span>
				<h1>Admin Dashboard</h1>
				<div class="table-responsive">
					<table class="table table-striped table-hover" >
						<tr>
							<th>No.</th>
							<th>Post Title</th>
							<th>Date and Time </th>
							<th>Author</th>
							<th>Category</th>
							<th>Banner</th>
							<th>Comments</th>
							<th>Action</th>
							<th>Details</th>
						</tr>
				<?php
					global $Connection;
					$View_Query = "SELECT * FROM admin_panel ORDER BY datetime desc";
					$Execute = mysqli_query($Connection,$View_Query);
					$SrNo =0;
					while($DataRows = mysqli_fetch_array($Execute)){
						$No = $DataRows['id'];
						$Title = $DataRows['title'];
						$DateTime = $DataRows['datetime'];
						$Category = $DataRows['category'];
						$Author = $DataRows['author'];
						$Image = $DataRows['image'];
						$Post = $DataRows['post'];
						$SrNo++;
				
				?>
				<tr>
					<td><?php echo $SrNo; ?></td>
					<td style="color: #5e6eff;"><?php 
					if(strlen($Title)>20){
						$Title=substr($Title, 0,20)."...";
						}
					echo $Title; ?></td>
					<td><?php 
					if(strlen($DateTime)>14){
						$DateTime=substr($DateTime, 0,14);
						}
					echo $DateTime; ?></td>
					<td><?php 
					if(strlen($Author)>5){
						$Author=substr($Author, 0,5)."..";
						}
					echo $Author; ?></td>
					<td><?php 
					if(strlen($Category)>8){
						$Category=substr($Category, 0,8)."..";
						}
					echo $Category; ?></td>
					<td><img src="Upload/<?php echo $Image; ?>" width="200"; height="74" ></td>
					<td>
			<!---Approved Comment Count Code Starts-->
				<?php
					$Connection;
					$Approved_Query="SELECT COUNT(*) FROM comment WHERE admin_panel_id='$No' AND status='ONN'";
					$ApprovedExecute = mysqli_query($Connection,$Approved_Query);
					$RowApproved = mysqli_fetch_array($ApprovedExecute);
					$TotalApproved = array_shift($RowApproved);
					if($TotalApproved>0){

				?>
				<span class="label label-success pull-right">
					<?php echo $TotalApproved; ?>
				</span>
			<?php } ?>

			<!---Un-Approved Comment Count Code Starts-->
				<?php
					$Connection;
					$Approved_Query="SELECT COUNT(*) FROM comment WHERE admin_panel_id='$No' AND status='OFF'";
					$ApprovedExecute = mysqli_query($Connection,$Approved_Query);
					$RowApproved = mysqli_fetch_array($ApprovedExecute);
					$TotalApproved = array_shift($RowApproved);
					if($TotalApproved>0){

				?>
				<span class="label label-warning">
					<?php echo $TotalApproved; ?>
				</span>
			<?php } ?>
					</td>
					<td>
					<a href="editpost.php?id=<?php echo $No; ?>">
					<span class="btn btn-warning"> Edit</span></a>
					<a href="deletepost.php?id=<?php echo $No; ?>">
					<span class="btn btn-danger"> Delete</span></a>
					</td>
					<td>
					<a href="fullpost2.php?id=<?php echo $No; ?>" target="_blank">
					<span class="btn btn-primary"> Live Preview</span></a>
					</td>
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
		<a href="https://www.facebook.com/manish.bs.kr" target="_blank"><p>This is Simple Admin Panel of blog Site</p></a>

	</div>
	<div style="background: #27AAE1; height: 10px;"></div>

</body>
</html>