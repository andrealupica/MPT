<?php
	session_start();
	if($_SESSION['email']=="" OR $_SESSION['email']==null OR $_SESSION["docente"]!=1 OR $_SESSION["responsabile"]!=1){
		header("location:index.php");
		//echo "email: ".$_SESSION['email'];
	}
	else{
		include 'view/visionePianificazioneCompleta.php';
		include 'model/visionePianificazioneCompleta.php';
	}

?>
