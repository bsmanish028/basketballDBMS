<?php
	require_once("include/DB.php");
	require_once("include/session.php");
	require_once("include/functions.php");
?>
<?php Confirm_Login(); ?>
<?php Confirm_Login(); ?>
<?php
	
	if(isset($_GET['id'])){
		$Connection;
		$URLFromID = $_GET['id'];
		$Approve_Query="DELETE FROM comment WHERE id='$URLFromID' ";
		$Execute = mysqli_query($Connection,$Approve_Query);
		if($Execute){
			$_SESSION["SuccessMessage"]="Comment Deleted Successfully";
			Redirect_to("comments.php");
			}
		else{
			$_SESSION["ErrorMessage"]="Something Went Wrong. Try Again !";
			Redirect_to("comments.php");
			}
		}
?>