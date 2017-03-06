<?php
	### pagina per la gestione amministrativa
	// inclusione del file per la connessione al DB
include_once "../connection.php";
	// start della sessione
session_start();
if(($_SESSION['email']!="" OR $_SESSION['email']!=null) AND ($_SESSION["amministratore"]==1)){
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
		$newDB->createLog($_SESSION['email'],"inserimento","nuova materia: ".$materia);
	}

	// modifica della materia
	if(isset($_POST["modifyNomeMateria"]) && !empty($_POST["modifyNomeMateria"]) && isset($_POST["modifyMateriaId"]) && !empty($_POST["modifyMateriaId"])){
		$materia = $_POST["modifyNomeMateria"];
		$id = $_POST["modifyMateriaId"];
		$queryMateria = "select mat_nome from materia where mat_id=".$id;
		$result = $newDB->query($queryMateria);
		while($row = $result->fetch_assoc()){
			$oldMateria=$row['mat_nome'];
		}
		$query = "update materia set mat_nome='".$materia."' where mat_id='".$id."'";
		if($newDB->query($query) != false){
			$newDB->createLog($_SESSION['email'],"modifica","materia ".$oldMateria." modificato in ".$materia);
		}
	}

	// rimozione della materia
	if(isset($_POST["removeMat"])){
		$id = $_POST["removeMat"];
		$query = "select * from pianifica p,materia m where p.mat_id=m.mat_id && m.mat_id='".$id."' AND p.pia_flag=1";
		// se non è presente in nessuna pianificazione
		if($newDB->query($query) != false && mysqli_num_rows($newDB->query($query)) == 0){
			// allora puoi eliminarla
			$query = "update materia set mat_flag=0 where mat_id='".$id."'";
			if($newDB->query($query) != false){
				$queryMateria = "select mat_nome from materia where mat_id=".$id;
				$result = $newDB->query($queryMateria);
				while($row = $result->fetch_assoc()){
					$materia=$row['mat_nome'];
				}
				$newDB->createLog($_SESSION['email'],"eliminazione","materia eliminata: ".$materia);
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
		$newDB->createLog($_SESSION['email'],"inserimento","nuovo corso: ".$corso);
	}

	// modifica del corso
	if(isset($_POST["modifyNomeCorso"]) && !empty($_POST["modifyNomeCorso"]) && isset($_POST["modifyCorsoDurata"]) && !empty($_POST["modifyCorsoDurata"]) && isset($_POST["modifyCorsoId"]) && !empty($_POST["modifyCorsoId"]) ){
		$corso = $_POST["modifyNomeCorso"];
		$durata = $_POST["modifyCorsoDurata"];
		$id = $_POST["modifyCorsoId"];
		$queryCorso = "select cor_nome,cor_durata from corso where cor_id=".$id;
		$result = $newDB->query($queryCorso);
		while($row = $result->fetch_assoc()){
			$oldCorso=$row['cor_nome'];
			$oldDurata=$row['cor_durata'];
		}
		$query = "update corso set cor_nome='".$corso."', cor_durata='".$durata."' where cor_id='".$id."'";
		if($newDB->query($query) != false){
			$newDB->createLog($_SESSION['email'],"modifica","corso ".$oldCorso." ".$oldDurata." modificato in ".$corso." ".$durata);
		}
		else{
		}
	}

	// rimozione del corso
	if(isset($_POST["removeCor"])){
		$id = $_POST["removeCor"];
		$query = "select * from pianifica p,corso c where p.cor_id=c.cor_id && c.cor_id='".$id."'  AND p.pia_flag=1";
		// se non è presente in nessuna prianificazione
		if($newDB->query($query) != false && mysqli_num_rows($newDB->query($query)) == 0){
			// allora puoi eliminarlo
			$query = "update corso set cor_flag=0 where cor_id='".$id."'";
			if($newDB->query($query) != false){
				$queryCorso = "select cor_nome,cor_durata from corso where cor_id=".$id;
				$result = $newDB->query($queryCorso);
				while($row = $result->fetch_assoc()){
					$corso=$row['cor_nome'];
					$durata=$row['cor_durata'];
				}
				$newDB->createLog($_SESSION['email'],"eliminazione","corso eliminato: ".$corso." ".$durata);
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
		$newDB->createLog($_SESSION['email'],"inserimento","nuova classe: ".$classe);
	}

	// modifica della classe
	if(isset($_POST["modifyNomeClasse"]) && !empty($_POST["modifyNomeClasse"]) && isset($_POST["modifyClasseId"]) && !empty($_POST["modifyClasseId"])){
		$classe = $_POST["modifyNomeClasse"];
		$id = $_POST["modifyClasseId"];
		$queryClasse = "select cla_nome from classe where cla_id=".$id;
		$result = $newDB->query($queryClasse);
    while($row = $result->fetch_assoc()){
			$oldClasse=$row['cla_nome'];
		}
		$query = "update classe set cla_nome='".$classe."' where cla_id='".$id."'";
		if($newDB->query($query) != false){
			$newDB->createLog($_SESSION['email'],"modifica","classe ".$oldClasse." modificata in ".$classe);
		}
		else{
		}
	}

	// rimozione della classe
	if(isset($_POST["removeCla"])){
		$id = $_POST["removeCla"];
		$query = "select * from pianifica p,classe cl where p.cla_id=cl.cla_id && cl.cla_id='".$id."' AND p.pia_flag=1";
		// se non è presente in nessuna pianificazione
		if($newDB->query($query) != false && mysqli_num_rows($newDB->query($query)) == 0){
			// allora puoi nasconderla
			$query = "update classe set cla_flag=0 where cla_id='".$id."'";
			if($newDB->query($query) != false){
				$queryClasse = "select cla_nome from classe where cla_id=".$id;
				$result = $newDB->query($queryClasse);
				while($row = $result->fetch_assoc()){
					$classe=$row['cla_nome'];
				}
				$newDB->createLog($_SESSION['email'],"eliminazione","classe eliminata: ".$classe);
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
				$newDB->createLog($_SESSION['email'],"inserimento","nuova gestione: ".$corso." - ".$classe);
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
			$newDB->createLog($_SESSION['email'],"eliminazione","gestione eliminata: ".$corso." - ".$classe);
		}
		else{
		}
	}
}
?>
