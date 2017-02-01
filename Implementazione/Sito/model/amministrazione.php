<?php
	### pagina per la gestione amministrativa
	// inclusione del file per la connessione al DB
	include_once "../connection.php";
	// start della sessione
	session_start();

	### parte per la pagina di creazione materia
	// inserimento della materia
	if(isset($_POST["addMat"]) && !empty($_POST["addMat"])){
		$materia=$_POST["addMat"];
		$query ="insert into materia(mat_nome) values('".$materia."')";
		if($newDB->query($query) == false){
			$query = "update materia set mat_flag=1 where mat_nome='".$materia."'";
			if($newDB->query($query) != false){
			}
		}
	}

	// modifica della materia
	if(isset($_POST["modifyNomeMateria"]) && !empty($_POST["modifyNomeMateria"]) && isset($_POST["modifyMateriaId"]) && !empty($_POST["modifyMateriaId"])){
		$materia = $_POST["modifyNomeMateria"];
		$id = $_POST["modifyMateriaId"];
		$query = "update materia set mat_nome='".$materia."' where mat_id='".$id."'";
		if($newDB->query($query) != false){
		}
		else{
		}
	}

	// rimozione della materia
	if(isset($_POST["removeMat"])){
		$materia = $_POST["removeMat"];
		$query = "select * from pianifica p,materia m where p.mat_id=m.mat_id && m.mat_id='".$materia."' AND p.pia_flag=1";
		// se non è presente in nessuna pianificazione
		if($newDB->query($query) != false && mysqli_num_rows($newDB->query($query)) == 0){
			// allora puoi eliminarla
			$query = "update materia set mat_flag=0 where mat_id='".$materia."'";
			if($newDB->query($query) != false){
			}
		}
	}

	### parte per la pagina di creazione corso
	// inserimento del corso
	if(isset($_POST["addCorso"]) && !empty($_POST["addCorso"]) && isset($_POST["addCorsoDurata"]) && !empty($_POST["addCorsoDurata"])){
		$corso = $_POST["addCorso"];
		$durata = $_POST["addCorsoDurata"];
		$query ="insert into corso(cor_nome,cor_durata) values('".$corso."','".$durata."')";
		// se da errore vuol dire che esiste già
		if($newDB->query($query) == false){
			$query = "update corso set cor_flag=1 where cor_nome='".$corso."'";
			if($newDB->query($query) != false){
			}
		}
	}

	// modifica del corso
	if(isset($_POST["modifyNomeCorso"]) && !empty($_POST["modifyNomeCorso"]) && isset($_POST["modifyCorsoDurata"]) && !empty($_POST["modifyCorsoDurata"]) && isset($_POST["modifyCorsoId"]) && !empty($_POST["modifyCorsoId"]) ){
		$corso = $_POST["modifyNomeCorso"];
		$durata = $_POST["modifyCorsoDurata"];
		$id = $_POST["modifyCorsoId"];
		$query = "update corso set cor_nome='".$corso."', cor_durata='".$durata."' where cor_id='".$id."'";
		if($newDB->query($query) != false){
		}
		else{
		}
	}

	// rimozione del corso
	if(isset($_POST["removeCor"])){
		$corso = $_POST["removeCor"];
		$query = "select * from pianifica p,corso c where p.cor_id=c.cor_id && c.cor_id='".$corso."'  AND p.pia_flag=1";
		// se non è presente in nessuna prianificazione
		if($newDB->query($query) != false && mysqli_num_rows($newDB->query($query)) == 0){
			// allora puoi eliminarlo
			$query = "update corso set cor_flag=0 where cor_id='".$corso."'";
			if($newDB->query($query) != false){
			}
		}
	}

	// inserimento della classe
	if(isset($_POST["addCla"]) && !empty($_POST["addCla"])){
		$classe=$_POST["addCla"];
		$query ="insert into classe(cla_nome) values('".$classe."')";
		if($newDB->query($query) == false){
			$query = "update classe set cla_flag=1 where cla_nome='".$classe."'";
			if($newDB->query($query) != false){
			}
		}
	}

	// modifica della classe
	if(isset($_POST["modifyNomeClasse"]) && !empty($_POST["modifyNomeClasse"]) && isset($_POST["modifyClasseId"]) && !empty($_POST["modifyClasseId"])){
		$classe = $_POST["modifyNomeClasse"];
		$id = $_POST["modifyClasseId"];
		$query = "update classe set cla_nome='".$classe."' where cla_id='".$id."'";
		if($newDB->query($query) != false){
		}
		else{
		}
	}

	// rimozione della classe
	if(isset($_POST["removeCla"])){
		$classe = $_POST["removeCla"];
		$query = "select * from pianifica p,classe cl where p.cla_id=cl.cla_id && cl.cla_id='".$classe."' AND p.pia_flag=1";
		// se non è presente in nessuna pianificazione
		if($newDB->query($query) != false && mysqli_num_rows($newDB->query($query)) == 0){
			// allora puoi nasconderla
			$query = "update classe set cla_flag=0 where cla_id='".$classe."'";
			if($newDB->query($query) != false){
			}
		}
	}

	// inserimento della gestione
	if(isset($_POST["addCorso"]) && !empty($_POST["addCorso"]) && isset($_POST["addClasse"]) && !empty($_POST["addClasse"])){
		// se non sono stati lasciati i valori di default
		if($corso!="-- corso --" && $classe!="-- classe --"){
			$classe=$_POST["addClasse"];
			$corso=$_POST["addCorso"];
			// selezione l'id della classe
			$queryIdClasse = "SELECT cla_id FROM classe WHERE cla_nome='".$classe."'";
			$result = $newDB->query($queryIdClasse);
			$row = $result->fetch_assoc();
			$claId=$row['cla_id'];
			// seleziona l'id del corso
			$queryIdCorso = "select cor_id from corso where cor_nome='".$corso."'";
			$result = $newDB->query($queryIdCorso);
			$row = $result->fetch_assoc();
			$corId = $row['cor_id'];
			// inserisci nella tabella cla_fre_cor la classe e il suo corso
			$query ="insert into cla_fre_cor(cla_id,cor_id) values('".$claId."','".$corId."')";
			if($newDB->query($query) != false){
			}
		}
	}

	// rimozione della gestione
	if(isset($_POST["removeGestione"])){
		$gest=explode("+",$_POST["removeGestione"]);
		$classe=$gest[0];
		$corso=$gest[1];
		// seleziona l'id della classe
		$queryIdClasse = "SELECT cla_id FROM classe WHERE cla_nome='".$classe."'";
		$result = $newDB->query($queryIdClasse);
		$row = $result->fetch_assoc();
		$claId=$row['cla_id'];
		// seleziona l'id del corso
		$queryIdCorso = "select cor_id from corso where cor_nome='".$corso."'";
		$result = $newDB->query($queryIdCorso);
		$row = $result->fetch_assoc();
		$corId = $row['cor_id'];
		// elimina l'associazione classe-corso
		$query = "delete from cla_fre_cor where cla_id='".$claId."' AND cor_id='".$corId."'";
		if($newDB->query($query) != false){
		}
		else{
		}
	}
?>
