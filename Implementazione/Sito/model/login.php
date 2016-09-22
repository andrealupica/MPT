<?php
	include "connection.php";
	$user = "";
	$pass = "";

	if(isset($_POST["email"]) && isset($_POST["password"])){
		$user = $_POST["email"];
		$user = mb_strtolower($user);
		$pass = $_POST["password"];
		$query = "select ute_email as 'email' from utente where ute_email='$user' && ute_password='" . md5($pass) . "';";;
		if($newDB->query($query) != false && mysqli_num_rows($newDB->query($query)) == 1){
			//sess("db")->stop();
			header("Location: menu.php");
		}
		else{
			echo  "<script>document.getElementById('errore').innerHTML='email o password non sono corrette'</script>";
		}
	}
//$connection->close();

?>