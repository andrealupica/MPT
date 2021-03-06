<?php
### pagina per la gestione delle proposte
include_once "../connection.php";
session_start();
// apertura modal di modifica con l'inserimento dei dati
if(isset($_POST['idTitolo']) AND !empty($_POST['idTitolo'])){
  $id = $_POST['idTitolo'];
  try{
    $query = $newDB->getConnection()->prepare("SELECT t.tem_titolo AS 'titolo',t.tem_descrizione AS 'descrizione',t.tem_valutazione AS 'valutazione' from propone p,tema t where t.tem_id=p.tem_id AND t.tem_id=? AND p.pro_flag=1 group by t.tem_id");
    $query->bind_param("i", $id);
    $query->execute();
    $query->close();
    $dati=array();
    $sql ="SELECT t.tem_titolo AS 'titolo',t.tem_descrizione AS 'descrizione',t.tem_valutazione AS 'valutazione' from propone p,tema t where t.tem_id=p.tem_id AND t.tem_id=".$id." AND p.pro_flag=1 group by t.tem_id";
    $result = $newDB->query($sql);
    while($dum = $result->fetch_assoc()){
      $dati[]=$dum['titolo'];
      $dati[]=$dum['descrizione'];
      $dati[]=$dum['valutazione'];
    }
    echo json_encode($dati);
  }
  catch(PDOException $e)
  {
  }
}

// ritorna l'id delle materie presenti nelle proposte
if(isset($_POST['idMat']) AND !empty($_POST['idMat'])){
  $id = $_POST['idMat'];
  try{
    $query = $newDB->getConnection()->prepare("SELECT m.mat_nome from propone p,materia m where m.mat_id=p.mat_id AND p.tem_id=?");
    $query->bind_param("i", $id);
    $query->execute();
    $query->close();
    $dati=array();
    $sql ="SELECT m.mat_nome AS 'mat' from propone p,materia m where m.mat_id=p.mat_id AND p.pro_flag=1 AND p.tem_id=".$id." order by m.mat_nome";
    $result = $newDB->query($sql);
    while($dum = $result->fetch_assoc()){
      $dati[]=$dum['mat'];
    }
    echo json_encode($dati);
  }
  catch(PDOException $e)
  {
  }
}

// ritorna il tag option con la selezione della materia con l'id in proposte
if(isset($_POST['mat']) AND !empty($_POST['mat'])){
  $mat = $_POST['mat'];
  $materie=array();
  $sql ="SELECT m.mat_nome AS 'mat' from materia m where m.mat_flag=1 order by m.mat_nome";
  $result = $newDB->query($sql);
  while($dum = $result->fetch_assoc()){
    if($mat==$dum['mat']){
      $materie[]="1";
    }
    else{
      $materie[]="0";
    }
  }
  echo json_encode($materie);
}

// ritorna il tag option con la selezione della materia con l'id in proposte
if(isset($_POST['select']) AND !empty($_POST['select'])){
  $materie=array();
  $sql ="SELECT m.mat_nome AS 'mat' from materia m where m.mat_flag=1 order by m.mat_nome";
  $result = $newDB->query($sql);
  while($dum = $result->fetch_assoc()){
      $materie[]=$dum['mat'];
  }
  echo json_encode($materie);
}

// creazione o modifica delle proposte quando si preme il pulsante salva
if(isset($_POST["materia"]) AND isset($_POST["valu"]) && isset($_POST["desc"])  && isset($_POST["tito"]) && isset($_POST["id"])){
  $id=$_POST["id"];
  $tit=$_POST["tito"];
  // se id 0 vuol dire che il tema non esiste
  try{
    if($id==0){
      $query = $newDB->getConnection()->prepare("INSERT into tema(tem_titolo) values (?)");
      $query->bind_param("s",$tit);
      $query->execute();
      $query->close();
      // creazione del log
      $newDB->createLog($_SESSION['email'],"inserimento","creato tema con il titolo ".$tit);
      $sql = "SELECT max(tem_id) AS 'id' from tema";
      $result = $newDB->query($sql);
      while($dum = $result->fetch_assoc()){
        $id=$dum['id'];
      }
    }
    $materie=$_POST['materia'];
    $dum = explode('/',$materie);
    $materia=array();
    for ($i=0; $i < count($dum); $i++) {
      if($dum[$i]!="--" && $dum[$i]!=null)
        $materia[]=$dum[$i];
    }
    // inserimento dati in tema
    $query = $newDB->getConnection()->prepare("UPDATE tema set tem_titolo=?,tem_valutazione=?,tem_descrizione=? where tem_id=?");
    $query->bind_param("sssi", $_POST["tito"],$_POST["valu"],$_POST["desc"],$id);
    $query->execute();
    $query->close();
    // rimozione di tutti i collegamenti propone
    $sql = "UPDATE  propone set pro_flag=0 where tem_id=".$id;
    $titolo=$_POST['tito'];
    $result = $newDB->query($sql);
    for ($i=0; $i < count($materia) ; $i++) {
      // selezione della materia
      $sql = "SELECT mat_id AS 'id' from materia m where m.mat_nome='".$materia[$i]."'";
      $result = $newDB->query($sql);
      while($dum = $result->fetch_assoc()){
        $d=$dum["id"];
        // aggiorno il propone se esiste e in seguito provo a crearlo ( se esiste già ritorna errore e non viene eseguito )
        $sql1 = "UPDATE  propone set pro_flag=1 where tem_id=".$id." AND mat_id=".$d;
        $result1 = $newDB->query($sql1);
        $sql1 = "INSERT into propone(tem_id,mat_id) values($id,$d)";
        $result1 = $newDB->query($sql1);
        // creazione del log

        $newDB->createLog($_SESSION['email'],"inserimento","modifica del tema ".$tit." con aggiunta della materia ".$materia[$i]);
      }
    }
  }
  catch(PDOException $e)
  {
  }
}

// eliminazione della proposta
if(isset($_POST["removeId"])){
  $id=$_POST["removeId"];
    $sql = "UPDATE propone set pro_flag='0' where tem_id='".$id."'";
    $result = $newDB->query($sql);
    if($newDB->query($sql)!=false){
      // creazione del log
      $newDB->createLog($_SESSION['email'],"eliminazione","rimossa proposta numero ".$id);
    }
}

?>
