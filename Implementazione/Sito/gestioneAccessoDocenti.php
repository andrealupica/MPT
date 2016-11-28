<?php
	session_start();
	if(($_SESSION['email']!="" OR $_SESSION['email']!=null) AND ($_SESSION["responsabile"]==1 OR $_SESSION["amministratore"]==1)){
		//echo "email: ".$_SESSION['email'];
		include 'view/gestioneAccessoDocenti.php';
		include 'model/gestioneAccessoDocenti.php';
	}
	else{
		include '404.php';
	}

?>
