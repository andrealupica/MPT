<!-- pagina per la visione della pianificazione completa dei docenti (simile alla pianificazione docenti)-->
<?
session_start();
if($_SESSION['email']=="" OR $_SESSION['email']==null){
  echo "non hai i permessi per visualizzare questa pagina";
}
else{
  include_once "connection.php";
  $classe=$_GET["classe"];
  $corso=$_GET["tipo"];
  $anno=$_GET["anno"];
  $query = "SELECT cl.cla_nome AS  'classe', ma.mat_nome AS  'materia', co.cor_nome AS  'corso', pi.pia_ini_anno AS  'inizio anno',
  pi.pia_fin_anno AS  'fine anno', pi.pia_ore_tot AS 'ore totali', pi.pia_ore_AIT as 'AIT', ut.ute_cognome as 'cognome', ut.ute_nome as 'nome'
  FROM pianifica pi
  JOIN classe cl ON cl.cla_id = pi.cla_id
  JOIN materia ma ON ma.mat_id = pi.mat_id
  JOIN corso co ON co.cor_id = pi.cor_id
  JOIN utente ut ON ut.ute_email = pi.ute_email
  WHERE cl.cla_nome='".$classe."' AND co.cor_nome='".$corso."' AND pi.pia_ini_anno='".$anno."'";
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
      <script src="script.js"></script>
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
            <a href="inserimentoOreAIT.php" class="btn btn-primary">
              <span class=" glyphicon glyphicon-arrow-left button"></span> indietro
            </a>
          </span>
        </div>
        <h1>Visione Pianificazione Completa Docenti MP</h1>
        <br>
        <label class="col-sm-12 col-xs-12 control-label titolo">Docenti</label>
        <form method="post">
          <?php
          while($row = $result->fetch_assoc()){
            $Ianno=$row["inizio anno"];
            $Fanno=$row["fine anno"];
            $classe=$row["classe"];
            $corso=$row["corso"];
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
                <input type="number" class="form-control" name="ore[]" id="ore" <input type="text" name="nomeDocente[]" class="form-control" readonly="true" value="<?php $ris=$row["AIT"]; echo $ris ?>"/>
              </span>
              <span class="col-md-2 col-xs-3">
                % ore AIT
                <input type="number" class="form-control" name="ore[]" id="ore" <input type="text" name="nomeDocente[]" class="form-control" readonly="true" value="<?php $ris=$row["AIT"]/$row["ore totali"]*100; echo $ris ?>"/>
              </span>
            </div>
            <?php
          }
          ?>
          <div class="col-xs-12 altro">
            <span class="col-md-3 col-xs-4">
              Tipo MP
              <input type="text" name="nomeDocente[]" class="form-control" readonly="true" value="<?php echo $corso;?>" ></input>
            </span>
            <span class="col-md-2 col-xs-4">
              Classe
              <input type="text" name="nomeDocente[]" class="form-control" readonly="true" value="<?php echo $classe;?>" ></input>
            </span>
            <span class="col-md-2 col-xs-4">
              Durata Ciclo
              <input type="text" name="nomeDocente[]" class="form-control" readonly="true" value="<?php echo $Fanno-$Ianno;?>" ></input>
            </span>
            <span class="col-md-4 col-xs-12">
              Ciclo Formativo
              <table>
                <tr>
                  <td class="col-xs-5">
                    <span>
                      <input type="text" name="nomeDocente[]" class="form-control" readonly="true" value="<?php echo $Ianno;?>" ></input>
                    </span>
                  </td>
                  <td class="col-xs-2">
                    <span >
                      <span>--</span>
                    </span>
                  </td>
                  <td class="col-xs -5">
                    <span>
                      <input type="text" name="nomeDocente[]" class="form-control" readonly="true" value="<?php echo $Fanno;?>" ></input>
                    </span>
                  </td>
                </tr>
              </table>
            </span>
          </div>
          <div>
            <label class="col-xs-4 control-label" id="messaggio"></label>
          </div>
        </div>
      </form>
    </div>
  </body>
  </html>
  <?php
}
else{
}
}
?>