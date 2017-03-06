<!-- pagina per la visione della pianificazione dei docenti visto dal Responsabile-->
<?php
session_start();
if($_SESSION['email']=="" OR $_SESSION['email']==null){
  echo "non hai i permessi per visualizzare questa pagina";
}
else{
  include_once "connection.php";
  // aggiungere: quando data creazione != nulla
  $query = "SELECT ut.ute_nome AS 'nome', ut.ute_cognome AS 'cognome', cl.cla_nome AS  'classe', ma.mat_nome AS  'materia', co.cor_nome AS  'corso',pi.pia_sem AS 'sem', pi.pia_ini_anno AS  'inizio anno', pi.pia_id as 'ID',
  pi.pia_fin_anno AS  'fine anno', pi.pia_ore_tot AS 'ore totali', pi.pia_ore_AIT as 'AIT'
  FROM pianifica pi
  JOIN classe cl ON cl.cla_id = pi.cla_id
  JOIN materia ma ON ma.mat_id = pi.mat_id
  JOIN corso co ON co.cor_id = pi.cor_id
  JOIN utente ut ON ut.ute_email = pi.ute_email AND pi.pia_flag=1 order by ut.ute_cognome";
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
    <link href="css/visionePianificazioneMPTR.css" rel="stylesheet">
  </head>
  <script>
  $(document).ready(function(){
    $("#buttonRemove").click(function(){
      id=$("#removeId").val();
      //alert(id);
      $.ajax({
        type:"POST",
        url: "model/visionePianificazioneMPTR.php",
        data:{removeId:id},
        success: function(result){
          //alert(result);
          location.reload();
        }
      });
    });
    $("#buttonModify").click(function(){
      id=$("#modifyId").val();
      ore=$("#modifyHour").val();
      //alert(id+ore);
      $.ajax({
        type:"POST",
        url: "model/visionePianificazioneMPTR.php",
        data:{modifyId:id,ore:ore},
        success: function(result){
          //alert(result);
          location.reload();
        }
      });
    });
  });
  function getOre(obj){
    val=$(obj).parent().parent().find("#ore").val();
    $("#modifyHour").val(val);
  }
  </script>
  <body class="body">
    <div class="col-xs-0 col-sm-1"></div>
    <div class="col-xs-12 col-lg-10">
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
      <?php
      if(mysqli_num_rows($result) != 0){
      ?>
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
          while($row = $result->fetch_assoc()){
            ?>
            <div class="col-xs-12 riga" id="riga">
              <span class="col-md-0 col-xs-0">
                <input type="text" readonly="true" hidden="true" value="<?php echo $row["nome"]." ".$row["cognome"]." ".$row["materia"]." ".$row["classe"]." ".$row["corso"]." ".$row["inizio anno"]." ".$row["fine anno"]." ".$row["sem"]." ".$row["AIT"]." ".$row["AIT"]/$row["ore totali"]*100 ?>"/>
              </span>
              <span class="col-md-2 col-xs-5">
                Docente
                <input type="text" name="docente[]" class="form-control" readonly="true"  title="<?php echo $row["cognome"]." ".$row["nome"];?>" value="<?php echo  $row["cognome"]." ".$row["nome"];?>" id="nome"/>
              </span>
              <span class="col-md-1 col-xs-5">
                Materia
                <input type="text" name="materia[]" class="form-control" readonly="true"  title="<?php echo $row["materia"];?>" value="<?php echo $row["materia"];?>" id="materia"/>
              </span>
              <span class="col-md-1 col-xs-2">
                Classe
                <input type="text" name="classe[]" class="form-control" readonly="true"  title="<?php echo $row["corso"];?>" value="<?php echo $row["classe"];?>" id="classe"/>
              </span>
              <span class="col-md-2 col-xs-4 ciclo">
                Ciclo Formativo
                <input type="text" class="form-control col-md-1" name="ciclo1[]"  readonly="true"  value="<?php echo $row["inizio anno"]." -- ".$row["fine anno"];?>" id="anno"/>
              </span>
              <span class="col-md-1 col-xs-2">
                Semestre
                <input type="text" name="classe[]" class="form-control" readonly="true"   title="<?php echo $row["sem"];?>" value="<?php echo $row["sem"];?>" id="sem"/>
              </span>
              <span class="col-md-1 col-xs-2">
                % AIT
                <input type="text" class="form-control"  id="<?php echo 'AIT';?>" readonly="true" value="<?php $ris=number_format($row["AIT"]/$row["ore totali"]*100,2); echo $ris ?>" title="<?php $ris=number_format($row['AIT']/$row['ore totali']*100,2); echo $ris ?>"/>
              </span>
              <span class="col-md-1 col-xs-2">
                Ore Totali
                <input type="number" class="form-control"  id="ore" value="<?php echo $row["ore totali"] ?>" title="<?php echo $row["ore totali"] ?>"/>
              </span>
              <span class="col-md-1 col-xs-2">
                Dettaglio
                <a href="visionePianificazioneCompleta.php?id=<?php echo $row["ID"];?>"
                  class="form-control dettaglio" name="dettaglio[]" value"" readonly="true"  id="<?php echo $row["ID"]?>"><div class="glyphicon glyphicon-option-horizontal"></div>
                </a>
              </span>
              <span class="col-md-1 col-xs-2">
                Modifica
                <button class="form-control dettaglio "  style="background-color:#337ab7;border-color:##2e6da4" value="buttonModify" id="modify" readonly="true" data-toggle="modal" data-target="#myModalM" onclick="getOre(this);document.getElementById('modifyId').value='<?php echo $row["ID"];?>';" >
                  <input class="col-xs-0" type="hidden" name="modify" value"<?php echo $row["ID"];?>"/>
                  <div class="glyphicon glyphicon-edit btn-primary"></div>
                </button>
              </span>
              <span class="col-md-1 col-xs-2">
                Elimina
                <button class="form-control dettaglio " style="background-color:#d9534f;border-color:#d43f3a" id="elimina" readonly="true" data-toggle="modal" data-target="#myModal" onclick="document.getElementById('removeId').value='<?php echo $row["ID"];?>';" >
                  <input class="col-xs-0" type="hidden" name="delete" value"<?php echo $row["ID"];?>"/>
                  <div class="glyphicon glyphicon-remove btn-danger"></div>
                </button>
              </span>
            </div>
            <?php
          }

          ?>
        </div>
        <?php
          }
          else{
            ?>
            <div class="col-xs-12" >
              <h3>
              <label class="col-xs-12 alert lbl-lg alert-info">Non sono presenti delle pianificazioni</label>
            </h3>
            </div>
            <?php
          }
        ?>
        <div>
          <label class="col-sm-4 control-label" id="errore"></label>
        </div>

      <div class="container">
        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
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
      <div class="container">
        <!-- Modal -->
        <div class="modal fade" id="myModalM" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">modifica pianificazione</h4>
              </div>
              <div class="modal-body">
                <p>sei sicuro di voler modificare l'ora totale del docente?</p>
                <div class="alert alert-info">
                  <strong>Info!</strong> La modifica comporterà cambiamenti anche in altre pagine
                </div>
              </div>
              <div class="modal-footer">
                <form method="post" action="">
                  <button type="submit" onclick="return false" class="btn btn-default" id="buttonModify">ok</button>
                  <input type="hidden" id="modifyId" name="modifyId" required="required"/>
                  <input type="hidden" id="modifyHour" name="modifyHour" required="required"/>
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
?>
