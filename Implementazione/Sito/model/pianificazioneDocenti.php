<?php
  session_start();
  include_once "connection.php";
  	 if(!empty($_POST['nomeDocente']) && !empty($_POST['cognomeDocente']) && !empty($_POST['materia']) && !empty($_POST['ciclo']) && !empty($_POST['classe']) && !empty($_POST['corso']) && !empty($_POST['ore'])){
      $nome = ucfirst(strtolower($_POST["nomeDocente"]));
      $cognome = ucfirst(strtolower($_POST["cognomeDocente"]));
      $materia = $_POST["materia"];
      $ciclo = $_Post["ciclo"];
      $classe = $_POST["classe"];
      $corso = $_POST["corso"];
      $ore = $_POST["ore"];
      echo "nome:".$nome;
      $queryEmail ="select ute_email as 'email' from utente where ute_nome='$nome' && ute_cognome='$cognome'";
      echo $queryEmail;
      $ris=$newDB->query($queryEmail);
      $email= $ris->fetch_assoc();

      echo $email;
      echo "salva";

    }
    else{
      	echo  "<script>document.getElementById('messaggio').innerHTML='inserisci tutti i campi'</script>";
    }
 ?>
