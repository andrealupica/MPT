<?php
  include_once "../connection.php";
  session_start();
  require('../pdf/fpdf.php');
  $colonne="";
  if(isset($_POST["docente"]) && isset($_POST["materia"]) && isset($_POST["classe"]) && isset($_POST["tipo"]) && isset($_POST["durata"]) &&  isset($_POST["ore"]) && isset($_POST["ciclo"]) && isset($_POST["AIT"]) &&  isset($_POST["cerca"])){
    echo $_POST["docente"];
    echo "ciao";
    // se è checckato il docente allora seleziona il nome e il cognome
    if(!empty($_POST["docente"])){
      $colonne.=" ute_cognome,ute_nome,";
    }
    if(!empty($_POST["materia"])){
      $colonne.="materia,";
    }
    $pdf = new FPDF();
    $pdf->AddPage();

		$pdf->SetFont('Arial','B',16);
    // larghezza colonne (docente,materia,tipo,classe,durata,ore,ciclo,AIT)
    $WidthColumn = array(250,150,250,100,100,100,150,100);
    // array delle colonne
    //$colonne = [!empty($_POST["docente"]),!empty($_POST["materia"]),!empty($_POST["classe"]),!empty($_POST["tipo"]),!empty($_POST["durata"]),!empty($_POST["ore"]),!empty($_POST["ciclo"]),!empty($_POST["AIT"])];

    $WidthIniziale=0;
  }


?>
