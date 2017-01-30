<?php
	### pagina per il cambiamento della password
	// inclusione del file per la connessione al DB
	include_once "connection.php";
	// start della sessione
	session_start();
	// se viene inviato il post
	if(isset($_POST["password"]) && isset($_POST["repassword"])){
		// se i due input sono stati riempiti, altrimenti segnala
		if(!empty($_POST["password"]) && !empty($_POST["repassword"])){
			$repass = $_POST["repassword"];
			$pass = $_POST["password"];
			// se le due password combaciano, altrimenti segnala
			if($repass ==$pass){
				// modifico la password e setto a null la password momentanea così da non rientrare più in questa pagina al prossimo login
				try{
					$query1 = $newDB->getConnection()->prepare("update utente set ute_password=?, ute_temppassword=null where ute_email=?;");
					$pass1="";
					$pass1=md5($pass);
					$user=$_SESSION['email'];
					$query1->bind_param("ss", $user, $pass1);
					$query1->execute();
					$query1->close();
					// se la query ha successo reindirizza alla pagina di login
					header("Location: index.php");
				catch(PDOException $e){
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
?>
