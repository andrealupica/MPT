<?php
	include_once "connection.php";
	session_start();
	if(isset($_POST["password"]) && isset($_POST["repassword"])){
		if(!empty($_POST["password"]) && !empty($_POST["repassword"])){
			$repass = $_POST["repassword"];
			$pass = $_POST["password"];
			// se le due password combaciano
			if($repass ==$pass){
				$query = "update utente set ute_password='".md5($pass)."', ute_temppassword=null where ute_email='".$_SESSION['email']."';";
				echo $query;
				echo "sess: ".$_SESSION['email'];
				if($newDB->query($query)!= false){
					header("Location: index.php");
				}
				else{
				echo  "<script>document.getElementById('errore').innerHTML='errore'</script>";
					//echo $newDB->error($query);
					//echo "sess: ".$_SESSION['email'];
				}
			}
			else{
				echo  "<script>document.getElementById('errore').innerHTML='le password non sono uguali'</script>";
			}
		}
		else{
			echo  "<script>document.getElementById('errore').innerHTML='inserisci una password'</script>";
		}
	}

//$connection->close();

?>
