<?php
### pagina per inserimento inserimento titolo
include_once "../connection.php";
// se viene inserito un valore nel select corso,viene ritornata la durata nel select menu

if(isset($_POST['id']) AND !empty($_POST['id'])){
  $id = $_POST['id'];
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
    echo  "<script>document.getElementById('errore').innerHTML='errore'</script>";
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
    //echo $sql;
    $result = $newDB->query($sql);
    while($dum = $result->fetch_assoc()){
      $dati[]=$dum['mat'];
    }
    echo json_encode($dati);
  }
  catch(PDOException $e)
  {
    echo  "<script>document.getElementById('errore').innerHTML='errore'</script>";
  }
}

// ritorna il tag option con la selezione della materia con l'id in proposte
if(isset($_POST['mat']) AND !empty($_POST['mat'])){
  $mat = $_POST['mat'];
  $materie=array();
  $sql ="SELECT m.mat_nome AS 'mat' from materia m where m.mat_flag=1 order by m.mat_nome";
  //echo $sql;
  $result = $newDB->query($sql);
  while($dum = $result->fetch_assoc()){
    if($mat==$dum['mat']){
      $materie[]="1";
    }
    else{
      $materie[]="0";
    }
  }
  //echo $materie;
  echo json_encode($materie);
  //echo json_encode($materie,SON_HEX_TAG);
}

// ritorna il tag option con la selezione della materia con l'id in proposte
if(isset($_POST['materia']) AND !empty($_POST['materia'])){
  $materie=array();
  $sql ="SELECT m.mat_nome AS 'mat' from materia m where m.mat_flag=1 order by m.mat_nome";
  //echo $sql;
  $result = $newDB->query($sql);
  while($dum = $result->fetch_assoc()){
      $materie[]=$dum['mat'];
  }
  //echo $materie;
  echo json_encode($materie);
  //echo json_encode($materie,SON_HEX_TAG);
}
 ?>
