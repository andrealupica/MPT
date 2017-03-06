<?php
	### pagina per una nuova password
	//inclusione del file per la connessione al DB
	include_once "connection.php";
	// controlle se il form è stato inviato e se gli input sono stati riempiti
	if(isset($_POST["email"]) && isset($_POST["reemail"])){
		if(!empty($_POST["email"]) && !empty($_POST["reemail"])){
			$reemail = $_POST["reemail"];
			$email = $_POST["email"];
			// se le due email combaciano
			if($reemail == $email){
				try{
					$query1 = $newDB->getConnection()->prepare("SELECT ute_email as 'email' from utente where ute_email=?");
					$query1->bind_param("s", $email);
					$query1->execute();
					$query1->close();
					$query1 = "select ute_email from utente where ute_email='".$email."';";
					if($newDB->query($query1) != false && mysqli_num_rows($newDB->query($query1)) == 1){
						$pass = implode(randomPassword());
						$query = "update utente set ute_password='".md5($pass)."', ute_temppassword=1 where ute_email='".$email."';";
						echo $query;
						if($newDB->query($query)!= false){
							// creazione dell'email
								$destinatario = $email;
								$oggetto = " modifica della password di: ".$email. "";
								$messaggio ="la tua nuova password è:".$pass;
								$tipoMessaggio = "Content-Type: text/html";
								$mittente =  'From: "sito MPT" <'.$_SERVER["SERVER_NAME"].'>';
								// dopo l'invio dell'email reindirizza alla pagina di login
								mail($destinatario,$oggetto,$messaggio,$mittente);
								// creazione del log
								$newDB->createLog($email,"informazione","l utente ha modificato la password");
								header("Location: index.php");
						}
						else{
							echo  "<script>document.getElementById('messaggio').innerHTML='errore'</script>";
						}
					}
					else
					{
						// creazione del log
						$newDB->createLog($email,"attenzione","email non registrata");
						echo  "<script>document.getElementById('messaggio').innerHTML='errore, l email potrebbe non essere stata registrata'</script>";
					}
				}
				catch(PDOException $e)
				{
					echo  "<script>document.getElementById('messaggio').innerHTML='errore, l email potrebbe non essere stata registrata'</script>";
				}
			}
			else{
				// creazione del log
				$newDB->createLog($email,"informazione","l email non combaciano");
				echo  "<script>document.getElementById('messaggio').innerHTML='le email non combaciano'</script>";
			}
		}
		else{
			echo  "<script>document.getElementById('messaggio').innerHTML='inserisci un email'</script>";
		}
	}

	// funzione per una password randomica
	function randomPassword() {
	    $alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	    for ($i = 0; $i < 10; $i++) {
	        $n = rand(1, 62);
	        $pass[$i] = $alphabet[$n-1];
	    }
	    return $pass;
	}
?>
