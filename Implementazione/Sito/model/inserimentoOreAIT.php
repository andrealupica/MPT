<?php
	### pagina per l'inserimento delle ore dei docenti
	// inclusione del file per la connessione al DB
	include_once "connection.php";
	// start della sessione
	session_start();
	// se le ore sono state settate allora
	if(isset($_POST["ore"])){
    $ore=$_POST["ore"];
    $classe=$_POST["classe"];
    $materia=$_POST["materia"];
    $corso=$_POST["corso"];
    $inizio=$_POST["ciclo1"];
    $email=$_SESSION["email"];
    for ($i=0; $i < count($materia); $i++) {
				// prendo l id della classe
        $query="select cla_id as 'id' from classe where cla_nome='".$classe[$i]."'";
        $result = $newDB->query($query);
        $row = $result->fetch_assoc();
        $idClasse = $row['id'];
        //prendo l'id della materia
        $query="select mat_id as 'id' from materia where mat_nome='".$materia[$i]."'";
        $result = $newDB->query($query);
        $row = $result->fetch_assoc();
        $idMateria = $row['id'];
        //prendo l'id della corso
        $query="select cor_id as 'id' from corso where cor_nome='".$corso[$i]."'";
        $result = $newDB->query($query);
        $row = $result->fetch_assoc();
        $idCorso = $row['id'];
				// prendo le ore
        $nOre=$ore[$i];
				if($nOre<0){
					$nOre=0;
				}
				// prendo solamente i primi 4 caratteri dle post inizio
				$inizio[$i]=substr($inizio[$i],0,4);
				// faccio un prepared statement
				$query = $newDB->getConnection()->prepare("update pianifica set pia_ore_AIT=? where ute_email='$email' AND pia_ini_anno=$inizio[$i] AND mat_id=$idMateria AND cla_id=$idClasse AND cor_id=$idCorso;");
        $query->bind_param("i",$nOre);
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
