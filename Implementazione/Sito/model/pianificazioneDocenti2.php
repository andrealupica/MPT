<?php
// pagina per i valori all'interno degli option select
    include_once "../connection.php";
    // viene ritornata la durata nel select menu
    if(isset($_POST['durataCorso'])){
      $corso = $_POST['durataCorso'];
      $queryDurataCorso ="select cor_durata as 'durata' from corso where cor_nome='$corso'";
      //echo $queryDurataCorso."<br>";
      $ris =$newDB->query($queryDurataCorso);
      $dum = $ris->fetch_assoc();
      $durata = $dum['durata'];
      echo $durata;
    }
    // viene ritornato il nome del classe
    if(isset($_POST['classeCorso'])){
      $corso = $_POST['classeCorso'];
      $QuerynomeClasse ="SELECT cl.cla_nome as'nome' FROM corso co JOIN cla_fre_cor cfc ON cfc.cor_id = co.cor_id JOIN classe cl ON cl.cla_id = cfc.cla_id WHERE co.cor_nome = '$corso'";
      //echo $queryDurataCorso."<br>";
      $ris =$newDB->query($QuerynomeClasse);
      $nomi=array();
      while($dum = $ris->fetch_assoc()){

        $nomi[]=$dum['nome'];
      }
      echo json_encode($nomi);
    }

    // viene calcolata la fine del corso
    if(isset($_POST['durataCiclo']) && isset($_POST['annoCiclo'])){
      $ciclo = $_POST['durataCiclo'];
      $anno = $_POST['annoCiclo'];
      echo $ciclo+$anno;
    }
?>
