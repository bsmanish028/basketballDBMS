<?php require_once("include/DB.php"); ?>
<?php require_once("include/session.php"); ?>
<?php require_once("include/functions.php"); ?>

<!--Insert Comment Code--->
<?php
if(isset($_POST["Submit"])){
$Name=($_POST["Name"]);
$Email=($_POST["Email"]);
$Comment=($_POST["Comment"]);
date_default_timezone_set("Asia/Kolkata");
$CurrentTime=time();
//$DateTime=strftime("%Y-%m-%d %H:%M:%S",$CurrentTime);
$DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
$DateTime;
$PostId=$_GET["id"];

if(empty($Name)||empty($Email) ||empty($Comment)){
	$_SESSION["ErrorMessage"]="All Fields are required";
	
}elseif(strlen($Comment)>500){
	$_SESSION["ErrorMessage"]="only 500  Characters are Allowed in Comment";
	
}else{
	global $Connection;
	$PostIDFromURL=$_GET['id'];
        $Query="INSERT INTO comment (datetime,name,email,comments,approvedby,status,admin_panel_id)
	VALUES ('$DateTime','$Name','$Email','$Comment','Pending','OFF','$PostIDFromURL')";
	$Execute=mysqli_query($Connection,$Query);
	if($Execute){
	$_SESSION["SuccessMessage"]="Comment Submitted Successfully";
	Redirect_to("fullpost2.php?id={$PostId}");
	}else{
	$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again !";
	Redirect_to("fullpost2.php?id={$PostId}");
		
	}
	
}	
	
}

?>
<!DOCTYPE>

<html>
	<head>
		<title>Full Blog Post</title>
                <link rel="stylesheet" href="css/bootstrap.min.css">
                <script src="js/jquery-3.2.1.min.js"></script>
                <script src="js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="css/publicstyle.css">
               <style>
		

.FieldInfo{
    color: rgb(251, 174, 44);
    font-family: Bitter,Georgia,"Times New Roman",Times,serif;
    font-size: 1.2em;
}
.CommentBlock{
background-color:#F6F7F9;
}
.Comment-info{
	color: #365899;
	font-family: sans-serif;
	font-size: 1.1em;
	font-weight: bold;
	padding-top: 10px;
        
	
}
.comment{
    margin-top:-2px;
    padding-bottom: 10px;
    font-size: 1.1em
}


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
	<a class="navbar-brand" href="index.php">
	   <img src="images/manis.png" style="margin-top: -8px;margin-left: -68px" width="250" height="40">
	</a>
		</div>
		<div class="collapse navbar-collapse" id="collapse">
		<ul class="nav navbar-nav">
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
<div class="container">
		<div class="blog-header">
			<h1>The Programmer Blog</h1>
			<p class="lead">The only blog for Programmer.</p>
		</div>
	<div class="row"> <!--Row-->
		<div class="col-sm-8"> <!--Main Blog Area-->
		<?php echo Message();
	      echo SuccessMessage();
	?>

	<!--For Searching Data Code -->
		<?php
		global $Connection;
		if(isset($_GET["SearchButton"])){
			$Search=$_GET["Search"];
		$ViewQuery="SELECT * FROM admin_panel
		WHERE datetime LIKE '%$Search%' OR title LIKE '%$Search%'
		OR category LIKE '%$Search%' OR post LIKE '%$Search%'";
		}else{
			$PostIDFromURL=$_GET["id"];
		$ViewQuery="SELECT * FROM admin_panel WHERE id='$PostIDFromURL'
		ORDER BY datetime desc";}
		$Execute=mysqli_query($Connection,$ViewQuery);
		while($DataRows=mysqli_fetch_array($Execute)){
			$PostId=$DataRows["id"];
			$DateTime=$DataRows["datetime"];
			$Title=$DataRows["title"];
			$Category=$DataRows["category"];
			$Admin=$DataRows["author"];
			$Image=$DataRows["image"];
			$Post=$DataRows["post"];
		
		?>
		<div class="blogpost thumbnail">
			<img class="img-responsive img-rounded"src="Upload/<?php echo $Image;  ?>" >
		<div class="caption">
			<h1 id="heading"> <?php echo htmlentities($Title); ?></h1>
		<p class="description">Category:<?php echo htmlentities($Category); ?> Published on
		<?php echo htmlentities($DateTime);?></p>
		<p class="post"><?php
		echo nl2br($Post); ?></p>
		</div>
			
		</div>
		<?php } ?>
		<br><br>
		<br><br>
		<span class="FieldInfo">Comments</span>
		<div>
			<!--Fetching Comments Part Code-->
			<?php 
				$Connection;
				$PostIDFromURL=$_GET['id'];
				$Comment_Query= "SELECT * FROM comment WHERE admin_panel_id='$PostIDFromURL' AND status='ONN' ";
				$Execute = mysqli_query($Connection,$Comment_Query);
				while($DataRows = mysqli_fetch_array($Execute)){
					$Comments = $DataRows['comments'];
					$Names = $DataRows['name'];
					$Email = $DataRows['email'];
					$DateandTime = $DataRows['datetime'];
				
			?>
			<div class="CommentBlock">
			<img class="pull-left" style="margin-top: 10px; margin-right: 10px" src="images/comments1.png" width="70" height="70">
			<h3 style="margin-left: 90px" class="Comment-info"><?php echo $Names; ?></h3>
			<p style="margin-left: 90px" class="description"><?php echo $DateandTime; ?></p>
			<p style="margin-left: 90px" class="comment"><?php echo nl2br($Comments); ?></p>
		</div>
			<?php } ?>
		</div>

		
		
		<br>
		<span class="FieldInfo">Share your thoughts about this post</span>
		
		
<div>
<form action="fullpost2.php?id=<?php echo $PostId; ?>" method="post" enctype="multipart/form-data">
	<fieldset>
	<div class="form-group">
	<label for="Name"><span class="FieldInfo">Name</span></label>
	<input class="form-control" type="text" name="Name" id="Name" placeholder="Name">
	</div>
	<div class="form-group">
	<label for="Email"><span class="FieldInfo">Email</span></label>
	<input class="form-control" type="email" name="Email" id="Email" placeholder="email">
	</div>
	<div class="form-group">
	<label for="commentarea"><span class="FieldInfo">Comment</span></label>
	<textarea class="form-control" name="Comment" id="commentarea"></textarea>
	<br>
<input class="btn btn-primary" type="Submit" name="Submit" value="Submit">
	</fieldset>
	<br>
</form>
</div>

		</div> <!--Main Blog Area Ending-->
		<div class="col-sm-offset-1 col-sm-3"><!---Side Area-->
					<div class="panel panel-primary">
				<div class="panel-heading">
					<h2 class="panel-title ">About Me</h2>				
				</div>
				<div class="panel-body background">
					<img class="img-responsive img-circle imageicon" src="images/AI.jpg">
					<h2>Manish Kumar </h2><br><p>Computerized face recognition is an important part of initiatives to develop security systems, in building social networks, in curating photographs</p>
				</div>
				<div align="center" class="panel-footer">&copy; Manish Kumar</div>
			</div>

			<div class="panel panel-primary">
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
			</div>
			
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h2 class="panel-title">Categories</h2>				
				</div>
				<div class="panel-body background" >
					<?php
						global $Connection;
						$Category_Query = " SELECT * FROM category ORDER BY datetime desc ";
						$Execute_Category = mysqli_query($Connection,$Category_Query);
						while($DataRows = mysqli_fetch_array($Execute_Category)){
							$Category_ID = $DataRows['id'];
							$Category_Name = $DataRows['name'];
						
					?>
				<a href="index.php?Category=<?php echo $Category_Name; ?>">
					<span id="heading"><?php echo "<li>".$Category_Name."</li>"; ?></span>
				</a>
				<?php } ?>
				</div>
				<div align="center" class="panel-footer">&copy; The Programmer Blog</div>
			</div>

			<div class="panel panel-primary">
				<div class="panel-heading">
					<h2 class="panel-title ">Recent Post</h2>				
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
	</div> <!--Row Ending-->
	
	
</div><!--Container Ending-->
<!-- Footer Section--->
	<div id="footer">
		<hr>
		<p>Developed by Manish Kumar | &copy;2018 ---All right released</p>
		<a href="https://www.facebook.com/manish.bs.kr"><p>The only blog for Programmer.</p></a>

	</div>
	<div style="background: #27AAE1; height: 10px;"></div>







	    
	</body>
</html>