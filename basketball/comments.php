<?php
	require_once("include/DB.php");
	require_once("include/session.php");
	require_once("include/functions.php");
?>
<?php Confirm_Login(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Manage Comments</title>
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
					<li ><a href="Dashboard.php"><span class="glyphicon glyphicon-home"></span> Dashboard</a></li>
					<li ><a href="addnewpost.php"><span class="glyphicon glyphicon-list-alt"></span> &nbsp;Add New Player</a></li>
					<li><a href="categories.php"><span class="glyphicon glyphicon-tags"></span> &nbsp;Teams</a></li>
					
					
					<li><a href="manageadmins.php"><span class="glyphicon glyphicon-user"></span> Manage Admins</a></li>
					<li class="active"><a href="comments.php"><span class="glyphicon glyphicon-comment"></span> Comments
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
			</div><!-- Ending of Left-Side Area-->
			<div class="col-sm-10"><!--Main Area-->
				<div><?php echo Message(); 
							echo SuccessMessage();
					?></div>
	<!---Un-Approved Comment Section--->
				<h1>Un-Approved Comments</h1>
				<div class="table-responsive">

					<table class="table table-striped table-hover">
						<tr>
							<th>No.</th>
							<th>Name</th>
							<th>Date</th>
							<th>Comments</th>
							<th>Status</th>
							<th>Delete</th>
							<th>Preview</th>
						</tr>

					<?php 

						$Connection;
						$Query= "SELECT * FROM comment WHERE status='OFF' ORDER BY datetime desc ";
						$Execute = mysqli_query($Connection,$Query);
						$SrNo = 0;
						while($DataRows = mysqli_fetch_array($Execute)){
							$ID = $DataRows['id'];
							$CommentorName = $DataRows['name'];
							$CommentDateTime = $DataRows['datetime'];
							$Comments = $DataRows['comments'];
							$CommentStatus = $DataRows['status'];
							$CommentOnPostID = $DataRows['admin_panel_id'];
							$SrNo++;
							
						

					?>

					<tr>
						<td><?php echo $SrNo; ?></td>
						<td><?php echo $CommentorName; ?></td>
						<td><?php echo $CommentDateTime; ?></td>
						<td><?php
						if(strlen($Comments)>14){
							$Comments=substr($Comments,0,14)."..";
						}
						echo $Comments; ?></td>
						<td>
						<a href="approvecomment.php?id=<?php echo $ID ?>"><span class="btn btn-success">
								APPROVE</span></a>
						</td>
						<td>
						<a href="deletecomment.php?id=<?php echo $ID; ?>"><span class="btn btn-danger">Delete</span></a>
						</td>
						<td>
						<a href="fullpost2.php?id=<?php echo $CommentOnPostID; ?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a>
						</td>
						
					</tr>

					<?php } ?>

					</table>
				</div>

<!---Approved Comment Section--->
		<h1>Approved Comments</h1>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th>No.</th>
							<th>Name</th>
							<th>Date</th>
							<th>Comments</th>
							<th>Approved By</th>
							<th>Status</th>
							<th>Delete</th>
							<th>Preview</th>
						</tr>

					<?php 

						$Connection;
						$Query= "SELECT * FROM comment WHERE status='ONN' ORDER BY datetime desc ";
						$Execute = mysqli_query($Connection,$Query);
						$SrNo = 0;
						
						while($DataRows = mysqli_fetch_array($Execute)){
							$ID = $DataRows['id'];
							$CommentorName = $DataRows['name'];
							$CommentDateTime = $DataRows['datetime'];
							$Comments = $DataRows['comments'];
							$ApprovedBy = $DataRows['approvedby'];
							$CommentStatus = $DataRows['status'];
							$CommentOnPostID = $DataRows['admin_panel_id'];
							$SrNo++;
							
						

					?>

					<tr>
						<td><?php echo $SrNo; ?></td>
						<td><?php echo $CommentorName; ?></td>
						<td><?php echo $CommentDateTime; ?></td>
						<td><?php
						if(strlen($Comments)>14){
							$Comments=substr($Comments,0,14)."..";
						}
						echo $Comments; ?></td>
						<td><?php echo $ApprovedBy; ?></td>
						<td>
						<a href="disprovecomment.php?id=<?php echo $ID ?>"><span class="btn btn-warning">
								DIS-APPROVE</span></a>
						</td>
						<td>
						<a href="deletecomment.php?id=<?php echo $ID; ?>"><span class="btn btn-danger">Delete</span></a>
						</td>
						<td>
						<a href="fullpost2.php?id=<?php echo $CommentOnPostID; ?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a>
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