<?php
	session_start();
	if($_SESSION['email']=="" OR $_SESSION['email']==null){
		header("location:index.php");
	}
	else{
		include 'view/menu.php';
		include 'model/menu.php';
	}

?>
