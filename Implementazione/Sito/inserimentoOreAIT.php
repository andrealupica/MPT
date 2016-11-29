<?php
	session_start();
	if(($_SESSION['email']!="" OR $_SESSION['email']!=null) AND ($_SESSION["docente"]==1)  OR $_SESSION["amministratore"]==1){
		include 'view/inserimentoOreAIT.php';
		include 'model/inserimentoOreAIT.php';
	}
	else{
		include '404.php';
	}

?>
