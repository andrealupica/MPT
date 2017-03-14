<?php
// pagina del login
include_once "connection.php";
session_start();
$user = "";
$pass = "";
	if(isset($_POST["email"]) && isset($_POST["password"])){
		if(!empty($_POST["email"]) && !empty($_POST["password"])){

			$user = $_POST["email"];
			$user = mb_strtolower($user);
			$pass = $_POST["password"];
			try{
				$query1 = $newDB->getConnection()->prepare("SELECT ute_email as 'email' from utente where ute_email=? && ute_password=?;");
				$pass1="";
				$pass1=md5($pass);
				$query1->bind_param("ss", $user, $pass1);
				$query1->execute();
				$query1->close();
				// si logga
				$query = "select ute_email as 'email' from utente where ute_email='$user' && ute_password='" . md5($pass) . "' AND ute_flag=1;";
				// esegue la query e funziona solo se ritorna un risultato (come è giusto che sia)
				if($newDB->query($query) != false && mysqli_num_rows($newDB->query($query)) == 1){
					// seleziono i tipi del docente che sta facendo il login e li salvo come sessioni
					$queryTipo ="select ute_docente as 'docente',ute_amministratore as 'amministratore', ute_responsabile as 'responsabile' from utente where ute_email='$user';";
					if($newDB->query($queryTipo)!= false && mysqli_num_rows($newDB->query($queryTipo)) == 1){
						$result = $newDB->query($queryTipo);
						$row = $result->fetch_assoc();
						// controllo che il docente in questione abbia almeno un permesso
						if($row['docente']==1 OR $row['amministratore']==1 OR $row['responsabile']==1){
							$_SESSION['docente'] = $row['docente'];
							$_SESSION['amministratore'] = $row['amministratore'];
							$_SESSION['responsabile'] = $row['responsabile'];

							// data di scadenza
							$queryDate = "select ute_dataIscrizione as 'data' from utente where ute_email='$user' && ute_password='" . md5($pass) . "';";
							if($newDB->query($queryDate) != false && mysqli_num_rows($newDB->query($queryDate)) == 1){
								$result = $newDB->query($queryDate);
								$row = $result->fetch_assoc();
								$data = $row['data'];
								$today_date = date("Y-m-d");
								// se la data è superiore allora l'iscrizione è scaduta e viene eliminata la sua email
								if ($data<$today_date && $data!=null){
									$queryDeleteAccount = "update utente set ute_flag=0 where ute_email='".$user."';";
									$newDB->query($queryDeleteAccount);
									echo  "<script>document.getElementById('errore').innerHTML='l account è stato eliminato poiché non è stato effettuato il login entro il tempo limite, rieffettuare la registrazione'</script>";
									// creazione del log
									$newDB->createLog($user,"informazione","l utente ha fatto il login dopo il tempo limite");
								}
								else{
									$query1 = "update utente set ute_dataIscrizione=null where ute_email='$user';";
									$newDB->query($query1);
								}
							}

							// inserisco l'email del docente che ha fatto il login come email di sessione
							$queryEmail ="select ute_email as 'email' from utente where ute_flag=1 AND ute_email='$user';";
							if($newDB->query($queryEmail)!= false && mysqli_num_rows($newDB->query($queryEmail)) == 1){
								$result = $newDB->query($queryEmail);
								$row = $result->fetch_assoc();
								$_SESSION['email'] = $row['email'];
							}
							// location a pagina del menu o del cambia password nel caso si abbia una password momentanea
							$queryPasswordTemp = "select ute_temppassword as 'tpassword' from utente where  ute_flag=1 AND ute_email='$user'";
							if($newDB->query($queryPasswordTemp)!= false && mysqli_num_rows($newDB->query($queryPasswordTemp)) == 1){
								echo "pass mom";
								$result = $newDB->query($queryPasswordTemp);
								$row = $result->fetch_assoc();
								echo $queryPasswordTemp;
								echo $row['tpassword'];

								// creazione del log
								$newDB->createLog($_SESSION['email'],"informazione","l utente ha effettuato il login");
								if($row['tpassword']==null){
									header("Location: menu.php");
								}
								else{
									header("Location: changePassword.php");
								}
								//echo $_SESSION['email']."informazione".$_SERVER["PHP_SELF"]."l'utente ha effettuato il login";
								//echo "INSERT INTO log_(ute_email,log_pagina,log_azione,log_descrizione,log_data) values ($_SESSION['email'],$_SERVER['PHP_SELF'],'ok','descrizione',$time)";
							}
						}
						else{
								// creazione del log
								$newDB->createLog($user,"informazione","l utente ha cercato di effettuare il login con l account disabilitato");
								echo  "<script>document.getElementById('errore').innerHTML='errore durante il login, il tuo account potrebbe essere momentaneamente disabilitato'</script>";
						}
					}
				}
				else{
					// creazione del log
					$newDB->createLog($user,"attenzione","la password o l email non corrispondono");
					echo  "<script>document.getElementById('errore').innerHTML='l email o la password non è corretta'</script>";
				}
			}
			catch(PDOException $e)
			{
				echo  "<script>document.getElementById('errore').innerHTML='errore'</script>";
			}
		}
		else{
			echo  "<script>document.getElementById('errore').innerHTML='riempire entrambi i campi'</script>";
		}
	}
?>
