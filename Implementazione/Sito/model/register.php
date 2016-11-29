<?php
 	### pagina per la registrazione
	// inclusione del per la connessione al DB
	include_once "connection.php";
	// file per il captcha
	require_once "./captcha/include/fgcontactform.php";
	require_once "./captcha/include/captcha-creator.php";
	// start della sessione
	session_start();
	$nome = "";
	$cognome = "";
	$email = "";
	$emailAdmin = "";
// se sono stati riempiti tutti i campi
	if(isset($_POST["nome"]) && isset($_POST["cognome"]) && isset($_POST["email"]) && isset($_POST["captcha"])){
		// se il messaggio del captcha non corrsiponde al testo scritto
		if($_POST["captcha"]!=$_SESSION['digit']){
			echo "<script>document.getElementById('errore').innerHTML='Captcha non corretto'</script>";
		}
		else{
			// se i campi del nome, del cognome e dell'email non sono vuoti
			if(!empty($_POST["nome"]) && !empty($_POST["cognome"]) && !empty($_POST["email"])){
					// se il captcha è corretto
						$nome = $_POST["nome"];
						$nome = ucfirst(strtolower($nome)); // rendo soltanto la prima lettera in maiuscolo
						$cognome = $_POST["cognome"];
						$cognome = ucfirst(strtolower($cognome)); // rendo soltanto la prima lettere in maiuscolo
						$email = $_POST["email"];
						$email = strtolower($email);
						if(strstr($email,'@')=='@edu.ti.ch'){
							// inserimento tramite statement
							$connect=$newDB->getConnection();
							$query = $connect->prepare("insert into utente(ute_nome,ute_cognome,ute_email) values (?,?,?);");
							$query->bind_param("sss",$nome,$cognome,$email);
							$query->execute();
							if($query != false){
								// prende l'email del gestore email
								$query1 = "select ute_email as 'email' from utente where ute_gestoreEmail is not null limit 1;";
								if($newDB->query($query1)!= false  && mysqli_num_rows($newDB->query($query1)) == 1){
									$result = $newDB->query($query1);
									$row = $result->fetch_assoc();
									$destinatario = $row['email'];
								}
								//setta password momentanea
								$password = implode(randomPassword());
								$query2 = "update utente set ute_password='".md5($password)."', ute_temppassword=1 where ute_email='".$email."';";
								if($newDB->query($query2)!= false){
									//echo $query2;
									// invio dell'email
									$oggetto = " registrazione di ".$email. "";
									// bisogna ricordarsi di cambiare questo percorso !!
									$messaggio ="clicca questo link per accettare la registrazione: http://".$_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"]."?param=".$email."&password=".$password."";
									$mittente = 'From: registrazione MPT <'.$email.'>';
									// viene inviata un'email al gestore delle email e viene avvisato colui che ha fatto la richiesta
									mail($destinatario,$oggetto,$messaggio,$mittente);
									echo  "<script>document.getElementById('errore').innerHTML='email inviata al responsabile' </script>";
								}
								else{
									echo "error";
								}
							}
							else{
								echo  "<script>document.getElementById('errore').innerHTML='Errore durante la registrazione, l\'email potrebbe essere già stata registrata' </script>";
							}
						}
						else{
							echo  "<script>document.getElementById('errore').innerHTML='email non corretta : nome.cognome@edu.ti.ch'</script>";
						}
			}
			else{
				echo  "<script>document.getElementById('errore').innerHTML='riempire tuti i campi'</script>";
			}
		}

	}


// funzione per la password randomica
	function randomPassword() {
	    $alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	    for ($i = 0; $i < 10; $i++) {
	        $n = rand(1, 62);
	        $pass[$i] = $alphabet[$n-1];
	    }
	    return $pass;
	}
?>
