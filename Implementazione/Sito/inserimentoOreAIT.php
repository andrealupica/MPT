<?php
	session_start();
	if($_SESSION['email']=="" OR $_SESSION['email']==null OR $_SESSION["docente"]!=1){
		header("location:index.php");
		//echo "email: ".$_SESSION['email'];
	}
	else{
		include 'view/inserimentoOreAIT.php';
		include 'model/inserimentoOreAIT.php';
	}

?>