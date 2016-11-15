<?php
	session_start();
	if(($_SESSION['email']!="" OR $_SESSION['email']!=null) AND ($_SESSION["responsabile"]==1 OR $_SESSION["amministratore"]==1)){ // da riguardare
		include 'view/pianificazioneDocenti.php';
		include 'model/pianificazioneDocenti.php';
		//echo "email: ".$_SESSION['email'];
	}
	else{
		include '404.php';
	}

?>
