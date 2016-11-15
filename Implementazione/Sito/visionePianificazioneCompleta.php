<?php
	session_start();
	if(($_SESSION['email']!="" OR $_SESSION['email']!=null) AND ($_SESSION["responsabile"]==1 OR $_SESSION["amministratore"]==1  OR $_SESSION["docente"]==1)){ // da riguardare
			include 'view/visionePianificazioneCompleta.php';
			include 'model/visionePianificazioneCompleta.php';
		//echo "email: ".$_SESSION['email'];
	}
	else{
		header("location:index.php");
	}

?>
