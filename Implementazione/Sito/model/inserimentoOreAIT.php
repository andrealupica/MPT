<?php
	### pagina per l'inserimento delle ore dei docenti
	// inclusione del file per la connessione al DB
	include_once "connection.php";
	// start della sessione
	session_start();
	// se le ore sono state settate allora
	if(isset($_POST["id"]) && isset($_POST["ore"])){
    $id=$_POST['id'];
		$ore=$_POST['ore'];
    for ($i=0; $i < count($id); $i++) {
				// faccio un prepared statement
				if($ore[$i]<0){
					$ore[$i]=0;
				}
				$query = $newDB->getConnection()->prepare("update pianifica set pia_ore_AIT=? where pia_id=?");
				//echo "update pianifica set pia_ore_AIT=$ore[$i] where pia_id=$id[$i] <br>";
			//	echo "<script>console.log('update pianifica set pia_ore_AIT=1 where pia_id=$id[$i]')</script>";
        $query->bind_param("ii",$ore[$i],$id[$i]);
				// se la query viene eseguita allora ricarico la pagina e segnalo il salvataggio
        if($query->execute()!=false){
						echo "<script> location.href='inserimentoOreAIT.php'</script>";
            echo  "<script>document.getElementById('messaggio').innerHTML='salvataggio riuscito!'</script>";
        }
        else{
            echo  "<script>document.getElementById('messaggio').innerHTML='errore durante il salvataggio dei dati'</script>";
        }
    }
	}
?>
