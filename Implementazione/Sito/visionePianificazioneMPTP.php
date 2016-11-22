<?php
	session_start();
	if(($_SESSION['email']!="" OR $_SESSION['email']!=null) AND ($_SESSION["docente"]==1)){ // da riguardare

		include 'view/visionePianificazioneMPTP.php';
	}
	else{
		include '404.php';
	}
?>
