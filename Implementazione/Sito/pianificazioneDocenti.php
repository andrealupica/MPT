<?php
	session_start();
	if(($_SESSION['email']!="" OR $_SESSION['email']!=null) AND ($_SESSION["responsabile"]==1 OR $_SESSION["amministratore"]==1)){ 
		include 'view/pianificazioneDocenti.php';
		include 'model/pianificazioneDocenti.php';
	}
	else{
		include '404.php';
	}

?>
