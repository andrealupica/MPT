<?php
  ### pagina per la gestione della pagina di visione pianificazione MPT del responsabile
  ### in particolare l'eliminazione di una pianificazione
  // inclusione del file per la connessione al DB
  include_once "../connection.php";
  // start della sessione
  session_start();
  if(isset($_POST["removeId"])){
    $id=$_POST["removeId"];
		try{
    $query1 = $newDB->getConnection()->prepare("update pianifica set pia_flag=0 where pia_id=?");
    $query1->bind_param("i", $id);
    $query1->execute();
    $query1->close();
    // creazione del log
    $newDB->createLog($_SESSION['email'],"eliminazione","eliminazione della pianificazione numero ".$id);
    }
    catch(PDOException $e)
    {
      echo  "<script>document.getElementById('errore').innerHTML='errore'</script>";
    }
  }
  if(isset($_POST["modifyId"]) AND isset($_POST["ore"])){
    $id=$_POST["modifyId"];
    $ore=$_POST["ore"];
    try{
    $query1 = $newDB->getConnection()->prepare("update pianifica set pia_ore_tot=? where pia_id=?");
    echo "update pianifica set pia_ore_tot=".$ore." where pia_id=".$id;
    $query1->bind_param("ii", $ore,$id);
    $query1->execute();
    $query1->close();
    // creazione del log
    $newDB->createLog($_SESSION['email'],"informazione","modifica della pianificazione numero ".$id.", numero ore totali modificato in ".$ore);
    //echo "<script>location.href='pianificazioneMPTR.php'</script>";
    }
    catch(PDOException $e)
    {
      echo  "<script>document.getElementById('errore').innerHTML='errore'</script>";
    }
  }
?>
