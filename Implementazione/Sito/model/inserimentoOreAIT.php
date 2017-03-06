<?php
	### pagina per l'inserimento delle ore dei docenti
	// inclusione del file per la connessione al DB
	include_once "connection.php";
	// start della sessione
	session_start();
	// se le ore sono state settate allora
	if(isset($_POST["id"]) && isset($_POST["ore"]) AND isset($_SESSION['email'])){
    $id=$_POST['id'];
		$ore=$_POST['ore'];
    for ($i=0; $i < count($id); $i++) {

			if($ore[$i]<0){
				$ore[$i]=0;
			}
			$sql = "select pia_ore_AIT as 'AIT' from pianifica where pia_id=".$id[$i];
			$result = $newDB->query($sql);
			$row = $result->fetch_assoc();
			$AIT = $row['AIT'];
			if($AIT!=$ore[$i]){
								// faccio un prepared statement
				$query = $newDB->getConnection()->prepare("update pianifica set pia_ore_AIT=? where pia_id=?");
				//echo "update pianifica set pia_ore_AIT=$ore[$i] where pia_id=$id[$i] <br>";
			//	echo "<script>console.log('update pianifica set pia_ore_AIT=1 where pia_id=$id[$i]')</script>";
				$query->bind_param("ii",$ore[$i],$id[$i]);
				// se la query viene eseguita allora ricarico la pagina e segnalo il salvataggio
				if($query->execute()!=false){
					// creazione del log
					$newDB->createLog($_SESSION["email"],"modifica","modifica ore nella pianificazione numero ".$id[$i].", valore ore ".$ore[$i]);
						echo "<script> location.href='inserimentoOreAIT.php'</script>";
						echo  "<script>document.getElementById('messaggio').innerHTML='salvataggio riuscito!'</script>";
				}
				else{
					// creazione del log
					$newDB->createLog($_SESSION["email"],"attenzione","errore: pianificazione numero ".$id[$i]. ", ore inserite ".$ore[$i]);
					echo  "<script>document.getElementById('messaggio').innerHTML='errore durante il salvataggio dei dati'</script>";
				}
			}
    }
	}
?>
