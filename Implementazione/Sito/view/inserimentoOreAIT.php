<!-- pagina per l'inserimento delle ore AIT da parte dei docenti-->
<?
session_start();
if(($_SESSION['email']!="" OR $_SESSION['email']!=null) AND ($_SESSION["docente"]==1 OR $_SESSION["amministratore"]==1)){// da riguardare
  include_once "connection.php";
  $query = "SELECT cl.cla_nome AS  'classe', ma.mat_nome AS  'materia', co.cor_nome AS  'corso', pi.pia_ini_anno AS  'inizio anno', pi.pia_sem AS 'sem', pi.pia_id as 'ID',
  pi.pia_fin_anno AS  'fine anno', pi.pia_ore_tot AS 'ore totali', pi.pia_ore_AIT as 'AIT'
  FROM pianifica pi
  JOIN classe cl ON cl.cla_id = pi.cla_id
  JOIN materia ma ON ma.mat_id = pi.mat_id
  JOIN corso co ON co.cor_id = pi.cor_id
  WHERE pi.ute_email='".$_SESSION['email']."' AND pi.pia_flag=1";
  $result = $newDB->query($query);
  ?>
  <!DOCTYPE html>
  <html lang="it">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inserimento Ore AIT</title>
    <script src="script.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/inserimentoOreAIT.css" rel="stylesheet">
  </head>
  <script>
  </script>
  <body class="body">
    <div class="container contenitore">
      <div class="header">
        <span class="opzione">
          <a class="btn btn-primary" href="menu.php">
            <span class="glyphicon glyphicon-arrow-left button"></span> menu
          </a>
          <a href="logout.php" class="btn btn-primary">
            <span class="glyphicon glyphicon-log-out button"></span> exit
          </a>
        </span>
      </div>
      <h1>Inserimento ore AIT </h1>
      <br>
      <div class="form-group">
        <label class="col-xs-2 control-label">Ricerca:</label>
        <div class="col-xs-10">
          <div class="input-group">
            <span class="input-group-addon glyphicon glyphicon-search"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
            <input type="text" class="form-control" id="search"></input>
          </div>
        </div>
      </div>
      <form method="post">
        <div id="docente">
          <div>
            <span>
              <input hidden="true" class="col-xs-0"/>
            </span>
          </div>
          <?php
          while($row = $result->fetch_assoc()){
            ?>
            <div class="col-xs-12 riga">
              <span class="col-md-0 col-xs-0">
                <input type="text" readonly="true" hidden="true" value="<?php echo $row["materia"].$row["classe"].$row["corso"].$row["inizio anno"]." -- ".$row["fine anno"].$row["AIT"].$row["AIT"]/$row["ore totali"]*100 ?>"/>
              </span>
              <span class="col-md-0 col-xs-0">
                <input type="text" readonly="true" name="id[]" hidden="true" value="<?php echo $row["ID"] ?>" id="<?php echo $row["ID"] ?>"/>
              </span>
              <span class="col-md-2 col-xs-5">
                Materia
                <input type="text" name="materia[]" class="form-control" readonly="true"  title="<?php echo $row["materia"];?>" value="<?php echo $row["materia"];?>" id="<?php echo 'materia'.$i;?>"/>
              </span>
              <span class="col-md-1 col-xs-2">
                Classe
                <input type="text" name="classe[]" class="form-control" readonly="true"   title="<?php echo $row["classe"];?>" value="<?php echo $row["classe"];?>" id="<?php echo $row["classe"];?>"/>
              </span>
              <span class="col-md-2 col-xs-5">
                Tipo MP
                <input type="text" name="corso[]" class="form-control" readonly="true" title="<?php echo $row["corso"];?>" value="<?php echo $row["corso"];?>" id="<?php echo $row["corso"];?>"/>
              </span>
              <span class="col-md-2 col-xs-4 ciclo">
                Ciclo Formativo
                <input type="text" class="form-control col-md-1" name="ciclo1[]"  readonly="true"  value="<?php echo $row["inizio anno"]." -- ".$row["fine anno"];?>" id="<?php echo $row["inizio anno"];?>"/>
              </span>
              <span class="col-md-1 col-xs-2">
                Semestre
                <input type="text" name="classe[]" class="form-control" readonly="true"   title="<?php echo $row["sem"];?>" value="<?php echo $row["sem"];?>" id="sem"/>
              </span>
              <span class="col-md-2 col-xs-2">
                Ore_AIT
                <input type="number" class="form-control" name="ore[]"   min="0" value="<?php echo $row["AIT"]; ?>" id="ore"/>
              </span>
              <span class="col-md-1 col-xs-2">
                % AIT
                <input type="text" class="form-control" maxlength="5" readonly="true" value="<?php $ris=number_format($row["AIT"]/$row["ore totali"]*100,2); echo $ris ?>" id="<?php echo 'AIT'.$i;?>"/>
              </span>
              <span class="col-md-1 col-xs-2">
                Dettaglio
                <a href="visionePianificazioneCompleta.php?ID=<?php echo $row["ID"];?>"
                  class="form-control dettaglio" name="dettaglio[]" value"" readonly="true"  id="<?php echo $row["ID"]?>"><div class="glyphicon glyphicon-option-horizontal"></div>
                </a>
              </span>
            </div>
            <?php
            }
            ?>
          </div>

          <div class="col-xs-12 salva">
            <div class="col-xs-9" >
              <label class="col-xs-9 alert alert-warning" id="messaggio">le modifiche verranno apportate solo con il pulsante salva</label>
            </div>
            <div class="col-md-3">
              <button type="submit" class="btn btn-secondary">
                <span class="glyphicon glyphicon-floppy-disk button"></span>Salva
              </button>
            </div>
          </div>
        </form>
      </div>
      <script>
      $("#search").keyup(function() {
        var value = this.value.toLowerCase();
        var words = value.split(' ');
        $("#docente").find(".riga").each(function(index) {
          var ris = $(this).find("span").find("input").val().toLowerCase();
          var flag=0;
          // controllo se l'array di parole splittate è contenuto nella riga
          for (i = 0; i < words.length; i++) {
            if(ris.indexOf(words[i])!=-1){
            }
            else{
              flag=1;
            }
          }
          if(flag==0){
            $(this).show();
          }
          else{
            $(this).hide();
          }
          flag=0;
        });
      });
      </script>
    </body>
    </html>
    <?php
  }
  else{
    echo "non hai i permessi per visualizzare questa pagina";
  }
  ?>
