<?php
  ### pagina per la gestione della pagina di visione pianificazione MPT del responsabile
  ### in particolare l'eliminazione di una pianificazione
  // inclusione del file per la connessione al DB
  include_once "../connection.php";
  // start della sessione
  session_start();
  if(isset($_POST["docente"]) && isset($_POST["classe"]) && isset($_POST["corso"]) && isset($_POST["anno"]) && isset($_POST["materia"])){
    $docente=$_POST["docente"];
    $classe=$_POST["classe"];
    $corso=$_POST["corso"];
    $anno=$_POST["anno"];
    $materia=$_POST["materia"];
    $docenteArray=explode(" ",$docente);
    $annoArray=explode(" -- ",$anno);
    $nome=$docenteArray[1];
    $cognome=$docenteArray[0];
    $annoI=$annoArray[0];
    // seleziona email
    $sqlEmail = "select ute_email from utente where ute_nome='".$nome."' AND ute_cognome='".$cognome."'";
    $result = $newDB->query($sqlEmail);
    $row = $result->fetch_assoc();
    $email = $row['ute_email'];
    // prendo l id della classe
    $queryCla="select cla_id as 'id' from classe where cla_nome='".$classe."'";
    $result = $newDB->query($queryCla);
    $row = $result->fetch_assoc();
    $idClasse = $row['id'];
    //prendo l'id della materia
    $queryMat="select mat_id as 'id' from materia where mat_nome='".$materia."'";
    $result = $newDB->query($queryMat);
    $row = $result->fetch_assoc();
    $idMateria = $row['id'];
    //prendo l'id della corso
    $queryCor="select cor_id as 'id' from corso where cor_nome='".$corso."'";
    $result = $newDB->query($queryCor);
    $row = $result->fetch_assoc();
    $idCorso = $row['id'];
    $sql ="delete from pianifica where ute_email='".$email."' AND cla_id='".$idClasse."' AND mat_id='".$idMateria."' AND cor_id='".$idCorso."' AND pia_ini_anno='".$annoI."'";
    if($newDB->query($sql)!=false){
    }
  }
?>
