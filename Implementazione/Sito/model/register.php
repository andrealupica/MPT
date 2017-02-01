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
		try{
			// query per controllare che non venga effettuato una injection
			$query1 = $newDB->getConnection()->prepare("SELECT ute_email as 'email' from utente where ute_email=? && ute_email=? && ute_email=? && ute_email=?;");
			$query1->bind_param("ssss", $_POST["nome"], $_POST["cognome"],$_POST["email"],$_POST["captcha	"]);
			$query1->execute();
			$query1->close();
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
								$query = "select ute_email as 'email' from utente where ute_email='$email' AND ute_flag=1;";
								//echo $query."<br>";
								// esegue la query e controlla che l'email non sia già registrata
								if($newDB->query($query) != false && mysqli_num_rows($newDB->query($query)) == 1){
									echo  "<script>document.getElementById('errore').innerHTML='Errore durante la registrazione, l\'email potrebbe essere già stata registrata' </script>";
								}
								// se l'email non è presente nel DB
								else{
										// prende l'email del gestore email
									$query1 = "select ute_email as 'email' from utente where ute_gestoreEmail='1' limit 1;";
									if($newDB->query($query1)!= false  && mysqli_num_rows($newDB->query($query1)) == 1){
										$result = $newDB->query($query1);
										$row = $result->fetch_assoc();
										$destinatario = $row['email'];
									}
									$connect=$newDB->getConnection();
									$password = implode(randomPassword());
									$pass=md5($password);
									$query = $connect->prepare("insert into utente(ute_nome,ute_cognome,ute_email,ute_password,ute_dataIscrizione,ute_flag) values (?,?,?,?,1,1);");
									$query->bind_param("ssss",$nome,$cognome,$email,$pass);
									if($query->execute() != false && $query->affected_rows==1){
										$query->close();
										// invio dell'email
										$oggetto = " registrazione di ".$email. "";
										// in questo modo il percorso cambia a dipendenza di dove si trova il sito.
										$messaggio ="clicca questo link per accettare la registrazione:
										http://".$_SERVER["SERVER_NAME"].substr($_SERVER["PHP_SELF"],0,strlen($_SERVER["PHP_SELF"])-13)."/confirmRegister.php?param=".$email."&password=".$password."";
										$mittente = 'From: registrazione MPT <'.$email.'>';
										// viene inviata un'email al gestore delle email e viene avvisato colui che ha fatto la richiesta
										mail($destinatario,$oggetto,$messaggio,$mittente);
										echo "<script type='text/javascript'> $(document).ready(function(){ $('#myModal').modal('show'); }); </script>";
									}
									else{
										$query="update utente set ute_flag=1,ute_dataIscrizione='0000-00-00 00:00:00',ute_temppassword=1,
										ute_password='".$pass."',ute_nome='".$nome."',ute_cognome='".$cognome."' where ute_email='".$email."'";
										//echo $query;
										if($newDB->query($query) != false){
											// invio dell'email
											$oggetto = " registrazione di ".$email. "";
											// in questo modo il percorso cambia a dipendenza di dove si trova il sito.
											$messaggio ="clicca questo link per accettare la registrazione (l'utente era già stato accettato in precedenza):
											http://".$_SERVER["SERVER_NAME"].substr($_SERVER["PHP_SELF"],0,strlen($_SERVER["PHP_SELF"])-13)."/confirmRegister.php?param=".$email."&password=".$password."";
											$mittente = 'From: registrazione MPT <'.$email.'>';
											// viene inviata un'email al gestore delle email e viene avvisato colui che ha fatto la richiesta
											mail($destinatario,$oggetto,$messaggio,$mittente);
											echo "<script type='text/javascript'> $(document).ready(function(){ $('#myModal').modal('show'); }); </script>";
										}
									}
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
		catch(PDOException $e)
		{
			echo  "<script>document.getElementById('errore').innerHTML='errore'</script>";
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
