<?php
	session_start();
	if(($_SESSION['email']!="" OR $_SESSION['email']!=null) AND $_SESSION["amministratore"]==1){
		include 'view/amministrazione.php';
		//include 'model/amministrazione.php';
	}
	else{
		include '404.php';
	}

?>
