<?php
	session_start();
	if($_SESSION['email']=="" OR $_SESSION['email']==null){
		header("location:index.php");
	}
	else{
		include 'view/changePassword.php';
		include 'model/changePassword.php';
	}

?>
