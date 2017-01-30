<?php
  ### pagina per la gestione della pagina di visione pianificazione MPT del responsabile
  ### in particolare l'eliminazione di una pianificazione
  // inclusione del file per la connessione al DB
  include_once "../connection.php";
  // start della sessione
  session_start();
  if(isset($_POST["id"])){
    $id=$_POST["id"];
		try{
    $query1 = $newDB->getConnection()->prepare("update pianifica set pia_flag=0 where pia_id=?");
    $query1->bind_param("i", $id);
    $query1->execute();
    $query1->close();
    }
    catch(PDOException $e)
    {
      echo  "<script>document.getElementById('errore').innerHTML='errore'</script>";
    }
  }
?>
