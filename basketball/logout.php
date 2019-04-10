<?php require_once("include/session.php"); ?>
<?php require_once("include/functions.php"); ?>

<?php 
	$_SESSION['User_ID']=null;
	session_destroy();
	Redirect_to("index.php");
?>