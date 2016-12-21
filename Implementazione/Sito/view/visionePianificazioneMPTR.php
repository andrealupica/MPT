<!-- pagina per la visione della pianificazione dei docenti visto dal Responsabile-->
<?
session_start();
if($_SESSION['email']=="" OR $_SESSION['email']==null){
  echo "non hai i permessi per visualizzare questa pagina";
}
else{
  include_once "connection.php";
  // aggiungere: quando data creazione != nulla
  $query = "SELECT ut.ute_nome AS 'nome', ut.ute_cognome AS 'cognome', cl.cla_nome AS  'classe', ma.mat_nome AS  'materia', co.cor_nome AS  'corso', pi.pia_ini_anno AS  'inizio anno',
  pi.pia_fin_anno AS  'fine anno', pi.pia_ore_tot AS 'ore totali', pi.pia_ore_AIT as 'AIT'
  FROM pianifica pi
  JOIN classe cl ON cl.cla_id = pi.cla_id
  JOIN materia ma ON ma.mat_id = pi.mat_id
  JOIN corso co ON co.cor_id = pi.cor_id
  JOIN utente ut ON ut.ute_email = pi.ute_email";
  //echo $query;
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
    <link href="css/inserimentoOreAIT.css" rel="stylesheet">
  </head>
  <script>
  $(document).ready(function(){
    $("#buttonRemove").click(function(){
      n=$("#removeId").val();
      //alert(n);
      docente = $(".riga:nth-child("+n+")").find("span:nth-child(2)").find("input").val();
      classe  = $(".riga:nth-child("+n+")").find("span:nth-child(4)").find("input").val();
      corso  = $(".riga:nth-child("+n+")").find("span:nth-child(5)").find("input").val();
      anno  = $(".riga:nth-child("+n+")").find("span:nth-child(6)").find("input").val();
      materia  = $(".riga:nth-child("+n+")").find("span:nth-child(3)").find("input").val();
      $.ajax({
        type:"POST",
        url: "model/visionePianificazioneMPTR.php",
        data:{docente:docente,classe:classe,corso:corso,anno:anno,materia:materia},
        success: function(result){
          //alert(result);
          location.reload();
        }
      });
    });

  });
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
      <h1>Visione Pianificazione Docenti MP </h1>
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
        <div id="docente">
          <div>
            <span>
              <input hidden="true" class="col-xs-0"/>
            </span>
          </div>
          <?php
          $cnt=2;
          while($row = $result->fetch_assoc()){
            ?>
            <div class="col-xs-12 riga">
              <span class="col-md-0 col-xs-0">
                <input type="text" readonly="true" hidden="true"
                value="<?php echo $row["nome"].$row["cognome"].$row["materia"].$row["classe"].$row["corso"].$row["inizio anno"].$row["fine anno"].$row["AIT"].$row["AIT"]/$row["ore totali"]*100 ?>"/>
              </span>
              <span class="col-md-2 col-xs-5">
                Docente
                <input type="text" name="docente[]" class="form-control" readonly="true"  title="<?php echo $row["cognome"]." ".$row["nome"];?>" value="<?php echo  $row["cognome"]." ".$row["nome"];?>" id="nome"/>
              </span>
              <span class="col-md-2 col-xs-5">
                Materia
                <input type="text" name="materia[]" class="form-control" readonly="true"  title="<?php echo $row["materia"];?>" value="<?php echo $row["materia"];?>" id="materia"/>
              </span>
              <span class="col-md-1 col-xs-2">
                Classe
                <input type="text" name="classe[]" class="form-control" readonly="true"   title="<?php echo $row["classe"];?>" value="<?php echo $row["classe"];?>" id="classe"/>
              </span>
              <span class="col-md-2 col-xs-5">
                Tipo MP
                <input type="text" name="corso[]" class="form-control" readonly="true" title="<?php echo $row["corso"];?>" value="<?php echo $row["corso"];?>" id="corso"/>
              </span>
              <span class="col-md-2 col-xs-5 ciclo">
                Ciclo Formativo
                <input type="text" class="form-control col-md-1" name="ciclo1[]"  readonly="true"  value="<?php echo $row["inizio anno"]." -- ".$row["fine anno"];?>" id="anno"/>
              </span>
              <span class="col-md-1 col-xs-2">
                % AIT
                <input type="text" class="form-control"  readonly="true" value="<?php $ris=$row["AIT"]/$row["ore totali"]*100; echo $ris ?>" title="<?php $ris=$row["AIT"]/$row["ore totali"]*100; echo $ris ?>" id="<?php echo 'AIT'.$i;?>"/>
              </span>
              <span class="col-md-1 col-xs-2">
                Dettaglio
                <a href="visionePianificazioneCompleta.php?classe=<?php echo $row["classe"];?>&tipo=<?php echo $row["corso"];?>&anno=<?php echo $row["inizio anno"];?>"
                  class="form-control dettaglio" name="dettaglio[]" value"" readonly="true"  id="<?php echo 'dettaglio'.$i;?>"><div class="glyphicon glyphicon-option-horizontal"></div></a>
              </span>
              <span class="col-md-1 col-xs-2">
                Elimina
                <button class="form-control dettaglio" id="elimina" readonly="true" data-toggle="modal" data-target="#myModalM" onclick="document.getElementById('removeId').value='<?php echo $cnt;?>';" >
                  <input class="col-xs-0" type="hidden" name="delete" value"<?php echo $row["classe"];?>&tipo=<?php echo $row["corso"];?>&anno=<?php echo $row["inizio anno"];?>"/>
                  <div class="glyphicon glyphicon-remove"></div>
                </button>
              </span>
            </div>
            <?php
            $cnt++;
          }

          ?>
        </div>
        <div>
          <label class="col-sm-4 control-label" id="messaggio"></label>
        </div>

      <div class="container">
        <!-- Modal -->
        <div class="modal fade" id="myModalM" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Elimina pianificazione</h4>
              </div>
              <div class="modal-body">
                <p>sei sicuro di voler eliminare la pianificazione?</p>
                <div class="alert alert-danger">
                  <strong>Attezione!</strong> L'eliminazione è irreversibile
                </div>
              </div>
              <div class="modal-footer">
                <form method="post" action="">
                  <button type="submit" onclick="return false" class="btn btn-default" id="buttonRemove">ok</button>
                  <input type="hidden" id="removeId" name="remove" required="required"/>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script>
    // funzione per la barra di ricerca
    $("#search").keyup(function() {
      var value = this.value.toLowerCase();
      $("#docente").find(".riga").each(function(index) {
        var id = $(this).find("span").find("input").val().toLowerCase();
        $(this).toggle(id.indexOf(value) !== -1);
      });
    });
    </script>
</body>
</html>
<?php
}
?>
