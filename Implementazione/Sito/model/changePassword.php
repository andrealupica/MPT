<?php
// pagina per il cambiamento della password

	include_once "connection.php";
	session_start();
	// se viene inviato il post
	if(isset($_POST["password"]) && isset($_POST["repassword"])){
		// se i due input sono stati riempiti
		if(!empty($_POST["password"]) && !empty($_POST["repassword"])){
			$repass = $_POST["repassword"];
			$pass = $_POST["password"];
			// se le due password combaciano
			if($repass ==$pass){
				// modifico la password e setto a null la password momentanea così da non rientrare più in questa pagina al prossimo login
				$query = "update utente set ute_password='".md5($pass)."', ute_temppassword=null where ute_email='".$_SESSION['email']."';";
				//echo $query;
				//echo "sess: ".$_SESSION['email'];
				// se la query ha successo reindirizza alla pagina di login
				if($newDB->query($query)!= false){
					header("Location: index.php");
				}
				else{
				echo  "<script>document.getElementById('errore').innerHTML='errore'</script>";
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
