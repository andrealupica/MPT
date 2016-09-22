<?php
	include "phps/connection.php";
	$usr = $_POST["email"];
	$pwd = $_POST["password"];

	echo "ok";
	if(isset($_POST["email"]) && isset($_POST["password"])){
		$user = $_POST["email"];
		$pass = $_POST["pwd"];
		$query = "select ute_email as 'email' from utente where ute_email='$user' and ute_password='$pass';";
		
	}


//$connection->close();

?>