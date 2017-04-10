<?php
  include_once "connection.php";
  // start della sessione
  session_start();
  //echo "<script>alert('pagina')</script>";
    // i dati inviati in post vengono salvati in sessione dalla pagina amministrazione
    if(isset($_POST['importaClasse']) AND isset($_SESSION['email'])){
      $gest=explode("+",$_POST["importaClasse"]);
      $_SESSION["idCorso"]=$gest[1];
      $_SESSION["idClasse"]=$gest[0];
      $_SESSION["corso"]=$gest[3];
      $_SESSION["classe"]=$gest[2];
    }
    // nel momento in cui si clicca su import e le sessioni sono attivate
    if(isset($_POST["Import"]) && !empty($_POST["Import"]) AND isset($_SESSION['email'])){
      $classe=$_SESSION["idClasse"];
      $corso=$_SESSION["idCorso"];
    if ($_FILES["idCSV"]["size"] > 0) {
      $grandezz=0;
      $file = $_FILES['idCSV']['tmp_name'];
      $handle = fopen($file,"r");
      if($handle == false) {
      }
      $data = null;
      fgets($handle);
      // finché non finisce il file
      while (($getData = fgetcsv($handle,10000,";")) != FALSE){
        // se il primo campo non è vuoto
        if(!empty($getData[0])){
          $info=$getData[3]." ".$getData[4];
          $data = explode('.', $getData[1]);
          $born = $data[2].'-'.$data[1].'-'.$data[0];
          $nome=utf8_encode($getData[0]);
          try{
            $allievi = $newDB->getConnection()->prepare("SELECT * from allievo where all_nome=? AND all_birthday=?");

            $allievi->bind_param("ss",$nome,$born);
            $allievi->execute();
            $allievi->store_result();
            // controlla se l'allievo è già presente nel db
            if($allievi->num_rows == 0) {
              // in caso contrario
              $query = $newDB->getConnection()->prepare("INSERT INTO allievo(all_nome,all_birthday,all_info,cor_id,cla_id) values (?,?,?,?,?)");
              $info=$getData[3]." ".$getData[4];
              //echo "INSERT INTO allievo(all_nome,all_birthday,all_info,cor_id,cla_id) values ($nome,$born,$info,$corso,$classe)";
              $query->bind_param("sssii",$nome,$born,$info,$corso,$classe);
              $query->execute();
              $query->close();
            } else {
              // in caso affermativo
              $aggiorna = $newDB->getConnection()->prepare("UPDATE allievo set all_flag=1,cor_id=?,cla_id=?,all_info=? where all_nome=? AND all_birthday=?");
              $aggiorna->bind_param("sssss",$corso,$classe,$info,$nome,$born);
              $aggiorna->execute();
              $aggiorna->close();
            }
  					// creazione del log
            $allievi->close();
          }
          catch(PDOException $e)
    			{
            echo $e;
    			}
        }
      }
      $nomeCorso=$_SESSION["corso"];
      $nomeClasse=$_SESSION["classe"];
      $newDB->createLog($_SESSION["email"],"inserimento","aggiunti studenti a ".$nomeCorso." - ".$nomeClasse);
  	fclose($handle);
    }
   echo "<script>location.href='importClasse.php'</script>";
  }
  // se si preme sul tasto di modifica allievo
  if(isset($_POST["modifyAllievo"])){
    $modify=explode("+",$_POST["modifyAllievo"]);
    $id=$modify[0];
    $nome=$modify[1];
    $born=$modify[2];
    $info=$modify[3];
    try{
      $allievi = $newDB->getConnection()->prepare("SELECT * from allievo where all_nome=? AND all_birthday=?");

      $allievi->bind_param("ss",$nome,$born);
      $allievi->execute();
      $allievi->store_result();
      // controlla se l'allievo è già presente nel db
      if($allievi->num_rows == 0) {
        $allievi = $newDB->getConnection()->prepare("UPDATE allievo set all_nome=?, all_birthday=?,all_info=? where all_id=?");
        $allievi->bind_param("sssi",$nome,$born,$info,$id);
        $allievi->execute();
        $allievi->close();
        // creazione del log
        $newDB->createLog($_SESSION["email"],"modifica","allievo ".$nome." modificato");
      }
      echo "<script>location.href='importClasse.php'</script>";
    }
    catch(PDOException $e)
    {
      echo $e;
    }
  }

  // se si preme sul tasto di elimina allievo
  if(isset($_POST["removeAllievo"])){
    $sql ="UPDATE allievo set all_flag=0 where all_id=".$_POST["removeAllievo"];
    if($newDB->query($sql)!=false){
      // creazione del log
      $newDB->createLog($_SESSION["email"],"eliminazione","allievo eliminato da ".$_SESSION['corso']." - ".$_SESSION['classe']);
    }
     echo "<script>location.href='importClasse.php'</script>";
  }
  if(isset($_POST["clearClasse"])){
    $sql = "UPDATE allievo set all_flag=0 where cla_id=".$_SESSION['idClasse']." and cor_id=".$_SESSION['idCorso'];
    if($newDB->query($sql)!=false){
      // creazione del log
      $newDB->createLog($_SESSION["email"],"eliminazione","rimossi tutti gli allievi da ".$_SESSION['corso']." - ".$_SESSION['classe']);
    }
    echo "<script>location.href='importClasse.php'</script>";
  }
?>
