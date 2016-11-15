<?php
	session_start();
	if(($_SESSION['email']!="" OR $_SESSION['email']!=null) OR $_SESSION["docente"]==1){
		include 'view/inserimentoOreAIT.php';
		include 'model/inserimentoOreAIT.php';
		//echo "email: ".$_SESSION['email'];
	}
	else{
		header("location:index.php");
	}

?>
