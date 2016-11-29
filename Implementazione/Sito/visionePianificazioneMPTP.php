<?php
	session_start();
	if(($_SESSION['email']!="" OR $_SESSION['email']!=null) AND ($_SESSION["docente"]==1  OR $_SESSION["amministratore"]==1)){ 
		include 'view/visionePianificazioneMPTP.php';
	}
	else{
		include '404.php';
	}
?>
