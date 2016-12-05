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

	// rimozione della materia
	if(isset($_POST["removeMat"])){
		$materia = $_POST["removeMat"];
		$query = "select * from pianifica p,materia m where p.mat_id=m.mat_id && m.mat_nome='".$materia."'";
		if($newDB->query($query) != false && mysqli_num_rows($newDB->query($query)) == 0){
			$query = "delete from materia where mat_nome='".$materia."'";
			if($newDB->query($query) != false){
			}
			else{
			}
		}
	}

	### parte per la pagina di creazione corso
	// inserimento del corso
	if(isset($_POST["addCor"]) && !empty($_POST["addCor"])){
		$corso=$_POST["addCor"];
		$query ="insert into corso(cor_nome) values('".$corso."')";
		if($newDB->query($query) != false){
		}
	}

	// rimozione del corso
	if(isset($_POST["removeCor"])){
		$materia = $_POST["removeCor"];
		$query = "select * from pianifica p,corso c where p.cor_id=c.cor_id && c.cor_nome='".$corso."'";
		if($newDB->query($query) != false && mysqli_num_rows($newDB->query($query)) == 0){
			$query = "delete from materia where mat_nome='".$corso."'";
			if($newDB->query($query) != false){
			}
			else{
			}
		}
	}
?>
