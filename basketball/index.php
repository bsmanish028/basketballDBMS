<?php
	require_once("include/DB.php");
	require_once("include/session.php");
	require_once("include/functions.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>The Programmer Blog </title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<script src="js/jquery-min-3.2.1.min.js" ></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/publicstyle.css">

<style>


</style>
</head>
<body>
	<div style="height: 10px; background: #27aae1;"></div>
	<nav class="navbar navbar-inverse" role="navigation">
	<div class="container">
		<div class="navbar-header">
	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
		data-target="#collapse">
		<span class="sr-only">Toggle Navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</button>
				<a href="index.php" class="navbar-brand">
					<img src="images/manish.png" style="margin-top: -8px;margin-left: -68px" width="250" height="40">
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
				<button class="btn btn-default" name="SearchButton">Go</button>
			</form>
		</div>
		</div>
	</nav>
	<div class="Line" style="height: 10px; background: #27aae1;"></div>

	<!---Ending Navigation Bar-->

	<div class="container">
		<div class="blog-header">
			<h1>Inter NIT Basketball Club</h1>
			<p class="lead">Dunk it in the basket..!</p>
		</div>

		<div class="row">
			<div class="col-sm-8"><!---Main Area-->
				<?php
					global $Connection;
					//Query when search button is active
					if(isset($_GET['SearchButton'])){
						$Search = $_GET['Search'];
						
						$View_Query = "SELECT * FROM admin_panel WHERE datetime LIKE '%$Search%' OR title LIKE '%$Search%' OR post LIKE '%$Search%'OR category LIKE '%$Search%' ";
						
					}
					//Query when search by category is active or by clicking on category
					elseif(isset($_GET['Category'])){
						$Category = $_GET['Category'];
						$View_Query = "SELECT * FROM admin_panel WHERE category='$Category' ORDER BY datetime desc ";
					}


					//Query is active while pagination is active like user search parameter like index.php?Page=2
					elseif(isset($_GET['Page'])){
						$Page=$_GET['Page'];
						if($Page == 0 || $Page<1){
							$ShowPostFrom = 0;
						}else{
						$ShowPostFrom = ($Page*5)-5;}

						$View_Query= " SELECT * FROM admin_panel ORDER BY datetime desc LIMIT $ShowPostFrom,5 ";


					}

					//Default Query : Query Active when user visit the blog page index.php
					else{
						
					$View_Query = "SELECT * FROM admin_panel ORDER BY datetime desc LIMIT 0,4 ";}
					$Execute = mysqli_query($Connection,$View_Query);
					while($DataRows =mysqli_fetch_array($Execute)){
						$Post_ID = $DataRows['id'];
						$Title = $DataRows['title'];
						$DateTime = $DataRows['datetime'];
						$Category = $DataRows['category'];
						$Image = $DataRows['image'];
						$Post = $DataRows['post'];
				?>
			<div class=" BlogPost thumbnail">
				<img height="300" class="img-responsive img-rounded" src="Upload/<?php echo $Image; ?>">
				<div class="caption">
					<h1 id="heading" ><?php echo htmlentities($Title); ?></h1>
					<p class="description"> Category: <?php echo htmlentities($Category); ?> &nbsp; Published on <?php echo htmlentities($DateTime); ?></p>
					<p class="post"><?php 
					if(strlen($Post)>150){
						$Post = substr($Post,0,150)."...";
					}

					echo htmlentities($Post); ?></p>
				</div>
				<a href="fullpost2.php?id=<?php echo $Post_ID; ?>"><span class="btn btn-info">Read More &rsaquo; &rsaquo;</span></a>
			</div>
		<?php } ?>

		<!--Code for Pagination--->
		<nav>
			<ul class="pagination pull-left pagination-lg">
				<!--Code for Backward Button--->
				<?php 
					if(isset($Page)){
						if($Page>1){
							?>
							<li><a href="index.php?Page=<?php echo $Page-1; ?>">&laquo;</a></li>
					<?php	}
					}
				?>
				
		<?php 
			global $Connection;
			$Pagination_Query = " SELECT COUNT(*) FROM admin_panel ";
			$Execute_Pagination = mysqli_query($Connection,$Pagination_Query);
			$RowPagination = mysqli_fetch_array($Execute_Pagination);
			$TotalPagination = array_shift($RowPagination);
			$PostPerPage = $TotalPagination/5;
			$PostPerPage = ceil($PostPerPage);
			for($i=1;$i<=$PostPerPage;$i++){
			if(isset($Page)){
				if($i==$Page){
					?>
			<li class="active"><a href="index.php?Page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
			<?php 
			}else{ 
			?>
		<li><a href="index.php?Page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
		<?php } } } ?>
		<!--Code for Forward Button--->
		<?php 
			if(isset($Page)){
					if($Page+1<=$PostPerPage){
					?>
			<li><a href="index.php?Page=<?php echo $Page+1; ?>">&raquo;</a></li>
		<?php	
			} }
			?>
	
</ul>
</nav>

			</div><!---Ending Main Area-->

			<div class="col-sm-offset-1 col-sm-3"><!---Side Area Starts-->
			<!-- <div class="panel panel-primary">
				<div class="panel-heading">
					<h2 class="panel-title">About Me</h2>				
				</div>
				<div class="panel-body background">
					<img class="img-responsive img-circle imageicon" src="images/AI.jpg">
					<h2>Manish Kumar </h2><br><p>CSE Undergraduate <br> NIT Silchar <br>Website and Android Developer</p>
				</div>
				<div align="center" class="panel-footer">&copy; Manish Kumar</div>
			</div> -->

			<!-- <div class="panel panel-primary">
				<div class="panel-heading">
					<h2 class="panel-title">Hot Topics</h2>				
				</div>
				<div class="panel-body">
					<li>Trending</li>
					<li>Recent Post</li>
					<li>Networking </li>
					<li>Top Topics</li>
					<li>Hot Topics</li>
				</div>
				<div align="center" class="panel-footer">&copy; The Programmer Blog</div>
			</div> -->
			
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h2 class="panel-title">Players</h2>				
				</div>
				<div class="panel-body background">
					<?php
						global $Connection;
						$Category_Query = " SELECT * FROM admin_panel ORDER BY datetime ";
						$Execute_Players = mysqli_query($Connection,$Category_Query);
						while($DataRows = mysqli_fetch_array($Execute_Players)){
							$Category_ID = $DataRows['id'];
							$Player_Name = $DataRows['title'];
						
					?>
				<a href="index.php?Category=<?php echo $Player_Name; ?>">
					<span id="heading"><?php echo "<li>".$Player_Name."</li>"; ?></span>
				</a>
				<?php } ?>
				</div>
				<div align="center" class="panel-footer">&copy; Inter NIT Basketball Club</div>
			</div>

			<div class="panel panel-primary">
				<div class="panel-heading">
					<h2 class="panel-title">Recent Post</h2>				
				</div>
				<div class="panel-body background">
					<?php 
						global $Connection;
						$RecentPost_Query = " SELECT * FROM admin_panel ORDER BY datetime desc LIMIT 0,4 ";
						$Execute_RecentPost = mysqli_query($Connection,$RecentPost_Query);
						while($DataRows = mysqli_fetch_array($Execute_RecentPost)){
							$RecentPostID = $DataRows['id'];
							$RecentPostTitle = $DataRows['title'];
							$RecentPostDT = $DataRows['datetime'];
							$RecentPostImage = $DataRows['image'];
							if(strlen($RecentPostDT)>14){
								$RecentPostDT = substr($RecentPostDT, 0,14);
							}
							if(strlen($RecentPostTitle)>36){
								$RecentPostTitle = substr($RecentPostTitle, 0,36)."...";
							}
					?>
					<img class="pull-left" style="margin-top: 8px;" src="Upload/<?php echo $RecentPostImage; ?>" width="70" height="70">
					<a href="fullpost2.php?id=<?php echo $RecentPostID; ?>">
					<h5 id="heading" style="margin-left: 90px"><?php echo $RecentPostTitle; ?></h5></a>
					<p class="description" style="margin-left: 90px"><?php echo $RecentPostDT; ?></p>
					<hr>
				<?php } ?>
				</div>
				<div align="center" class="panel-footer">&copy; The Programmer Blog </div>
			</div>
				
			</div><!---Ending Side Area-->
			
		</div><!---Ending Row-->
	</div><!---Ending Container-->
	<!-- Footer Section--->
	<div id="footer">
		<hr>
		<p>Developed by Manish Kumar | &copy;2018 ---All right released</p>
		<a href="https://www.facebook.com/manish.bs.kr"><p>The only blog for Programmer.</p></a>

	</div>
	<div style="background: #27AAE1; height: 10px;"></div>

</body>