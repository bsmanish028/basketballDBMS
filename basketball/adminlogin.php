<?php
	require_once("include/DB.php");
	require_once("include/session.php");
	require_once("include/functions.php");
?>

<?php
if(isset($_POST["Submit"])){
$Username=($_POST["Username"]);
$Password=($_POST["Password"]);
if(empty($Username)||empty($Password)){
	$_SESSION["ErrorMessage"]="All Fields must be filled out";
	Redirect_to("adminlogin.php");
	
}
else{
		$Found_Account=Login_Attempt($Username,$Password);
		$_SESSION["User_Id"]=$Found_Account["id"];
		$_SESSION["Username"]=$Found_Account["username"];
		if($Found_Account){
		$_SESSION["SuccessMessage"]="Welcome  {$_SESSION["Username"]} ";
			Redirect_to('dashboard.php');
		}else{
			$_SESSION['ErrorMessage'] = "Invalid Username/Password";
			Redirect_to('adminlogin.php');
		}
		
	}
	
}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Login | The Programmer Blog</title>
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
	body{
		background: url('images/AI.jpg');
		height: 100%; 

    /* Center and scale the image nicely */
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
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
		</div>
		</div>
	</nav>
	<div class="Line" style="height: 10px; background: #27aae1;"></div>

	<!---Ending Navigation Bar-->
	<div class="container-fluid">
		<div class="row">
			<!-- Ending of Side Area-->
			<div class="col-sm-offset-4 col-sm-4" style="background: #ffffff;margin-top: 100px;">
				

				<div><?php echo Message(); 
							echo SuccessMessage();
					?></div>
				<h1>Admin Login</h1>
				<br>

				<div><?php echo Message(); 
							echo SuccessMessage();
					?></div>

				<div>
					<form action="adminlogin.php" method="POST">
						<fieldset>
						<div class="form-group">
						<label for="username"><span class="FieldInfo">Username: </span></label>
						<div class="input-group input-group-lg ">
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-user"></span>
							</span>
						<input class="form-control" type="text" name="Username" id="username" placeholder="Username ">
						</div><br>
						<label for="password"><span class="FieldInfo">Password: </span></label>
						<div class="input-group input-group-lg">
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-lock"></span>
							</span>
						
						<input class="form-control" type="password" name="Password" id="password" placeholder="Password ">
					</div>

						
						
					</div>
					<br>
					<input class="btn btn-primary btn-block" type="submit" name="Submit" value="Login">

				</fieldset>
					<br>
					</form>
				</div>
			</div><!-- Ending of Main Area-->
		</div><!-- Ending of Row-->
	</div><!-- Ending of Container-->
	
	

	

</body>
</html>