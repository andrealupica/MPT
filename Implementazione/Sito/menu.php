<?php
	session_start();
	if($_SESSION['email']=="" OR $_SESSION['email']==null){
		include '404.php';
	}
	else{
		include 'view/menu.php';
		include 'model/menu.php';
	}

?>
