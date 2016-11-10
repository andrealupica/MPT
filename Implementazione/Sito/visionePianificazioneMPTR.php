<?php
	session_start();
	if($_SESSION['email']=="" OR $_SESSION['email']==null OR $_SESSION["responsabile"]!=1){
		header("location:index.php");
		//echo "email: ".$_SESSION['email'];
	}
	else{
		include 'view/visionePianificazioneMPTR.php';
		include 'model/visionePianificazioneMPTR.php';
	}
?>
