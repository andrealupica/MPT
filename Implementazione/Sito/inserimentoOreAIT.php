<?php
	session_start();
if(($_SESSION['email']!="" OR $_SESSION['email']!=null) AND ($_SESSION["docente"]==1)){
		include 'view/inserimentoOreAIT.php';
		include 'model/inserimentoOreAIT.php';
		//echo "email: ".$_SESSION['email'];
	}
	else{
		include '404.php';
	}

?>
