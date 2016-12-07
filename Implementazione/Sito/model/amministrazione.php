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
		if($newDB->query($query) != false){
		}
	}

	// modifica della classe
	if(isset($_POST["modifyNomeMateria"]) && !empty($_POST["modifyNomeMateria"]) && isset($_POST["modifyMateriaId"]) && !empty($_POST["modifyMateriaId"])){
		$materia = $_POST["modifyNomeMateria"];
		$id = $_POST["modifyMateriaId"];
		// se non è presente in nessuna prianificazione
		$query = "update materia set mat_nome='".$materia."' where mat_id='".$id."'";
		if($newDB->query($query) != false){
		}
		else{
		}
	}

	// rimozione della materia
	if(isset($_POST["removeMat"])){
		$materia = $_POST["removeMat"];
		// se non è presente in nessuna pianificazione
		$query = "select * from pianifica p,materia m where p.mat_id=m.mat_id && m.mat_nome='".$materia."'";
		if($newDB->query($query) != false && mysqli_num_rows($newDB->query($query)) == 0){
			$query = "delete from materia where mat_id='".$materia."'";
			if($newDB->query($query) != false){
			}
			else{
			}
		}
	}




	### parte per la pagina di creazione corso
	// inserimento del corso
	if(isset($_POST["addCorso"]) && !empty($_POST["addCorso"]) && isset($_POST["addCorsoDurata"]) && !empty($_POST["addCorsoDurata"])){
		$corso = $_POST["addCorso"];
		$durata = $_POST["addCorsoDurata"];
		$query ="insert into corso(cor_nome,cor_durata) values('".$corso."','".$durata."')";
		if($newDB->query($query) != false){
		}
	}

	// modifica del corso
	if(isset($_POST["modifyNomeCorso"]) && !empty($_POST["modifyNomeCorso"]) && isset($_POST["modifyCorsoDurata"]) && !empty($_POST["modifyCorsoDurata"]) && isset($_POST["modifyCorsoId"]) && !empty($_POST["modifyCorsoId"]) ){
		$corso = $_POST["modifyNomeCorso"];
		$durata = $_POST["modifyCorsoDurata"];
		$id = $_POST["modifyCorsoId"];
		// se non è presente in nessuna prianificazione
		$query = "update corso set cor_nome='".$corso."', cor_durata='".$durata."' where cor_id='".$id."'";
		if($newDB->query($query) != false){
		}
		else{
		}
	}
	// rimozione del corso
	if(isset($_POST["removeCor"])){
		$corso = $_POST["removeCor"];
		// se non è presente in nessuna prianificazione
		$query = "select * from pianifica p,corso c where p.cor_id=c.cor_id && c.cor_id='".$corso."'";
		if($newDB->query($query) != false && mysqli_num_rows($newDB->query($query)) == 0){
			$query = "delete from corso where cor_id='".$corso."'";
			if($newDB->query($query) != false){
			}
			else{
			}
		}
	}

	// inserimento della classe
	if(isset($_POST["addCla"]) && !empty($_POST["addCla"])){
		$classe=$_POST["addCla"];
		$query ="insert into classe(cla_nome) values('".$classe."')";
		if($newDB->query($query) != false){
		}
	}

	// modifica della classe
	if(isset($_POST["modifyNomeClasse"]) && !empty($_POST["modifyNomeClasse"]) && isset($_POST["modifyClasseId"]) && !empty($_POST["modifyClasseId"])){
		$corso = $_POST["modifyNomeClasse"];
		$id = $_POST["modifyClasseId"];
		// se non è presente in nessuna prianificazione
		$query = "update classe set cla_nome='".$corso."' where cla_id='".$id."'";
		if($newDB->query($query) != false){
		}
		else{
		}
	}
	// rimozione della classe
	if(isset($_POST["removeCla"])){
		$classe = $_POST["removeCla"];
		// se non è presente in nessuna pianificazione
		$query = "select * from pianifica p,classe cl where p.mat_id=cl.cla_id && cl.cla_id='".$classe."'";
		if($newDB->query($query) != false && mysqli_num_rows($newDB->query($query)) == 0){
			$query = "delete from classe where cla_id='".$classe."'";
			if($newDB->query($query) != false){
			}
			else{
			}
		}
	}
	// inserimento della gestione
	if(isset($_POST["addCorso"]) && !empty($_POST["addCorso"]) && isset($_POST["addClasse"]) && !empty($_POST["addClasse"])){
		$classe=$_POST["addClasse"];
		$corso=$_POST["addCorso"];
    //$query="select f.cla_id as 'classe',f.cor_id as 'corso' from cla_fre_cor f,classe cl, corso co where co.cor_id=f.cor_id AND cl.cla_id=f.cla_id;";
		$queryIdClasse = "SELECT cla_id FROM classe WHERE cla_nome='".$classe."'";
		//echo $queryIdClasse;
		$result = $newDB->query($queryIdClasse);
		$row = $result->fetch_assoc();
		$claId=$row['cla_id'];
		$queryIdCorso = "select cor_id from corso where cor_nome='".$corso."'";
		$result = $newDB->query($queryIdCorso);
		$row = $result->fetch_assoc();
		$corId = $row['cor_id'];
		if($corso!="-- corso --" && $classe!="-- classe --"){
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
		$queryIdClasse = "SELECT cla_id FROM classe WHERE cla_nome='".$classe."'";
		//echo $queryIdClasse;
		$result = $newDB->query($queryIdClasse);
		$row = $result->fetch_assoc();
		$claId=$row['cla_id'];
		$queryIdCorso = "select cor_id from corso where cor_nome='".$corso."'";
		$result = $newDB->query($queryIdCorso);
		$row = $result->fetch_assoc();
		$corId = $row['cor_id'];
		$query = "delete from cla_fre_cor where cla_id='".$claId."' AND cor_id='".$corId."'";
		//echo $query;
		if($newDB->query($query) != false){
		}
		else{
		}
	}
?>
