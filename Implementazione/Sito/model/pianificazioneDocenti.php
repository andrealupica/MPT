<?php
  session_start();
	if(isset($_POST['nomeDocente']) && isset($_POST['cognomeDocente']) && isset($_POST['materia']) && isset($_POST['ciclo']) && isset($_POST['classe']) && isset($_POST['corso']) && isset($_POST['ore'])){
      include_once "connection.php";
      $nome=ucfirst(strtolower($_POST["nomeDocente"]));
      $cognome=ucfirst(strtolower($_POST["cognomeDocente"]));
      $materia=$_POST[""]
      echo "salva";

    }
 ?>
