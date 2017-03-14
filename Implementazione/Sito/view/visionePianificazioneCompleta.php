<!-- pagina per la visione della pianificazione completa dei docenti (simile alla pianificazione docenti)-->
<?php
session_start();
if($_SESSION['email']=="" OR $_SESSION['email']==null){
  echo "non hai i permessi per visualizzare questa pagina";
}
else if(isset($_GET["id"])){
  include_once "connection.php";
  try{
    $idGruppo=$_GET["id"];
    $query1 =  $newDB->getConnection()->prepare("SELECT cl.cla_nome AS  'classe',cl.cla_id AS 'idClasse', ma.mat_nome AS  'materia', co.cor_nome AS  'corso',co.cor_id AS 'idCorso', pi.pia_ini_anno AS  'inizio anno', pi.pia_sem AS 'sem',
    pi.pia_fin_anno AS  'fine anno', pi.pia_ore_tot AS 'ore totali', pi.pia_ore_AIT as 'AIT', ut.ute_cognome as 'cognome', ut.ute_nome as 'nome'
    FROM pianifica pi
    JOIN classe cl ON cl.cla_id = pi.cla_id
    JOIN materia ma ON ma.mat_id = pi.mat_id
    JOIN corso co ON co.cor_id = pi.cor_id
    JOIN utente ut ON ut.ute_email = pi.ute_email
    WHERE pi.pia_gruppo = ?");
    $query1->bind_param("i", $idGruppo);
    $query1->execute();
    $query1->close();
    //$query1 = $newDB->getConnection()->prepare("SELECT cla_id as 'classe',cor_id as 'corso', pia_ini_anno as 'anno', pia_sem as 'sem' from pianifica where pia_id=?");
  }
  catch(PDOException $e)
  {
  }
  $query = "SELECT cl.cla_nome AS  'classe',cl.cla_id AS 'idClasse', ma.mat_nome AS  'materia', co.cor_nome AS  'corso',co.cor_id AS 'idCorso', pi.pia_ini_anno AS  'inizio anno', pi.pia_sem AS 'sem',
  pi.pia_fin_anno AS  'fine anno', pi.pia_ore_tot AS 'ore totali', pi.pia_ore_AIT as 'AIT', ut.ute_cognome as 'cognome', ut.ute_nome as 'nome'
  FROM pianifica pi
  JOIN classe cl ON cl.cla_id = pi.cla_id
  JOIN materia ma ON ma.mat_id = pi.mat_id
  JOIN corso co ON co.cor_id = pi.cor_id
  JOIN utente ut ON ut.ute_email = pi.ute_email
  WHERE pi.pia_gruppo = $idGruppo";
  //echo $query;
  if($newDB->query($query)!=false && mysqli_num_rows($newDB->query($query)) !=0){
    $result = $newDB->query($query);
    ?>
    <!DOCTYPE html>
    <html lang="it">
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Visione Pianificazione Docenti</title>
      <script src="js/script.js"></script>
      <script src="bootstrap/js/bootstrap.min.js"></script>
      <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <link href="css/pianificazioneDocenti.css" rel="stylesheet">
      <script>
      </script>
    </head>

    <body class="body">
      <div class="container contenitore">
        <div class="header">
          <span class="opzione">
            <a class="btn btn-primary" href="menu.php">
              <span class="glyphicon glyphicon-arrow-left button"></span> menu
            </a>
            <a href="logout.php" class="btn btn-primary">
              <span class="glyphicon glyphicon-log-out butoon"></span> exit
            </a>
            <a href="javascript:history.go(-1)" class="btn btn-primary">
              <span class=" glyphicon glyphicon-arrow-left button"></span> indietro
            </a>
          </span>
        </div>
        <h1>Visione Pianificazione Completa Docenti MP</h1>
        <br>
        <label class="col-sm-12 col-xs-12 control-label titolo">Docenti</label>
          <?php
          while($row = $result->fetch_assoc()){
            $sem=$row["sem"];
            //$sem1=$sem[0];
            $Ianno=$row["inizio anno"];
            $Fanno=$row["fine anno"];
            $classe=$row["classe"];
            $corso=$row["corso"];
            $idCorso=$row['idCorso'];
            $idClasse=$row['idClasse'];
            ?>
            <div class="col-md-12" id="docente">
              <span class="col-md-3 col-xs-6">
                Cognome
                <input type="text" name="cognomeDocente[]" class="form-control" readonly="true" value="<?php echo $row["cognome"];?>" ></input>
              </span>
              <span class="col-md-3 col-xs-6">
                Nome
                <input type="text" name="nomeDocente[]" class="form-control" readonly="true" value="<?php echo $row["nome"];?>" ></input>
              </span>
              <span class="col-md-2 col-xs-6">
                Materia
                <input type="text" name="nomeDocente[]" class="form-control" readonly="true" value="<?php echo $row["materia"];?>" ></input>
              </span>
              <span class="col-md-2 col-xs-3">
                Ore Annuale Materia
                <input type="number" class="form-control" name="ore[]" id="ore" <input type="text" name="nomeDocente[]" class="form-control" readonly="true" value="<?php $ris=$row["ore totali"]; echo $ris ?>"/>
              </span>
              <span class="col-md-2 col-xs-3">
                % ore AIT
                <input type="number" class="form-control" name="ore[]" id="ore" <input type="text" name="nomeDocente[]" class="form-control" readonly="true" value="<?php $ris=number_format($row["AIT"]/$row["ore totali"]*100,2); echo $ris ?>"/>
              </span>
            </div>
            <?php
          }
          ?>
          <div class="col-xs-12 altro">
            <span class="col-md-3 col-xs-4">
              Tipo MP
              <input type="text" name="tipo[]" class="form-control" readonly="true" value="<?php echo $corso;?>" ></input>
            </span>
            <span class="col-md-2 col-xs-4">
              Classe
              <input type="text" name="classe[]" class="form-control" readonly="true" value="<?php echo $classe;?>" ></input>
            </span>
            <span class="col-md-2 col-xs-4">
              Durata Ciclo
              <input type="text" name="durata[]" class="form-control" readonly="true" value="<?php echo $Fanno-$Ianno;?>" ></input>
            </span>
            <span class="col-md-3 col-xs-8">
              Ciclo Formativo
              <table>
                <tr>
                  <td class="col-xs-5" style="padding-left:0px;">
                    <span>
                      <input type="text" name="inizio[]" class="form-control" readonly="true" value="<?php echo $Ianno;?>" />
                    </span>
                  </td>
                  <td class="col-xs-2">
                    <span >
                      <span>--</span>
                    </span>
                  </td>
                  <td class="col-xs -5">
                    <span>
                      <input type="text" name="fine[]" class="form-control" readonly="true" value="<?php echo $Fanno;?>" />
                    </span>
                  </td>
                </tr>
              </table>
            </span>
            <span class="col-md-1 col-xs-4">
              Semestre
              <input type="text" name="semestre" class="form-control" readonly="true" value="<?php echo $sem; ?>"/>
            </span>
            <?php
              $query="SELECT * FROM allievo where all_flag=1 AND cor_id=".$idCorso." AND cla_id=".$idClasse;
      				if($newDB->query($query) != false && mysqli_num_rows($newDB->query($query)) != 0){
             ?>
            <span class="col-md-1 col-xs-1">
              allievo
              <form method="post" action="visioneAllievi.php">
                <input type="hidden" name="allievi" readonly="true" value="<?php echo $idCorso."+".$idClasse?>" />
                <input type="submit" value="vedi" class="form-control btn btn-primary" />
              </form>
            </span>
            <?php } ?>
          </div>
          <div>
            <label class="col-xs-4 control-label" id="messaggio"></label>
          </div>
        </div>
    </div>
  </body>
  </html>
  <?php
  }
  else{
  }
}
?>
