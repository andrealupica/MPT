<?php
	session_start();
	if(($_SESSION['email']!="" OR $_SESSION['email']!=null) AND $_SESSION["amministratore"]==1){
		include 'view/pageLog.php';
	}
	else{
		include '404.php';
	}

?>
