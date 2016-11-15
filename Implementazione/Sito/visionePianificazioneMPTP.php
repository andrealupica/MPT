<?php
	session_start();
	if(($_SESSION['email']!="" OR $_SESSION['email']!=null) AND ($_SESSION["docente"]==1)){ // da riguardare

		include 'view/visionePianificazioneMPTP.php';
		include 'model/visionePianificazioneMPTP.php';
		//echo "email: ".$_SESSION['email'];
	}
	else{
		header("location:index.php");
	}
?>
