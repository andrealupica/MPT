<?php
	include "connection.php";
	session_start();
	$user = "";
	$pass = "";

	if(isset($_POST["email"]) && isset($_POST["password"])){
		$user = $_POST["email"];
		$user = mb_strtolower($user);
		$pass = $_POST["password"];

		$query = "select ute_email as 'email' from utente where ute_email='$user' && ute_password='" . md5($pass) . "';";
		if($newDB->query($query) != false && mysqli_num_rows($newDB->query($query)) == 1){
			$queryTipo =" select ute_tipo as 'tipo' from utente where ute_email='$user';";
			if($newDB->query($queryTipo)!= false && mysqli_num_rows($newDB->query($queryTipo)) == 1){
				$_SESSION['tipo'] = $newDB->fetch($queryTipo);
			}
			$queryEmail =" select ute_email as 'email' from utente where ute_email='$user';";
			if($newDB->query($queryEmail)!= false && mysqli_num_rows($newDB->query($queryEmail)) == 1){
				$_SESSION['email'] = $newDB->fetch($queryEmail);
			}
			$queryPasswordTemp = "select ute_temppassword as 'tpassword' from utente where ute_email='$user'";
			if($newDB->query($queryPasswordTemp)!= false && mysqli_num_rows($newDB->query($queryPasswordTemp)) == 1){
				if($newDB->fetch($queryPasswordTemp)!=null){
					header("Location: menu.php");
				}
				else{
					header("Location: changePassword.php");
				}
			}
			else{
				echo "error";
			}

		}
		else{
			echo  "<script>document.getElementById('errore').innerHTML='email o password non sono corrette'</script>";
		}
	}
//$connection->close();

?>