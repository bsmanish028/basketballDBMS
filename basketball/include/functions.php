<?php
	require_once("include/DB.php");
	require_once("include/session.php");
?>

<?php
	function Redirect_to($New_Location){
		header("Location:".$New_Location);
		exit;
	}



	function Login_Attempt($Username,$Password){
    global $Connection;
    $Query="SELECT * FROM registration
    WHERE username='$Username' AND password='$Password'";
    $Execute=mysqli_query($Connection,$Query);
    if($admin=mysqli_fetch_assoc($Execute)){
	return $admin;
    }else{
	return null;
    }
}



	function Login(){
		if(isset($_SESSION["User_Id"])){
			return true;
		}
	}

	function Confirm_Login(){
		if(!Login()){
			$_SESSION["ErrorMessage"]="Login Required to access Admin Page.";
			Redirect_to("adminlogin.php");
		}
	}
 ?>