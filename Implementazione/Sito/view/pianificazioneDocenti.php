<!-- pagina per la pianificazione dei docenti-->
<?php
session_start();
if(($_SESSION['email']!="" OR $_SESSION['email']!=null) AND ($_SESSION["responsabile"]==1 OR $_SESSION["amministratore"]==1)){ // da riguardare
  include_once "connection.php";?>
  <!DOCTYPE html>
  <html lang="it">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>pianificazione Docenti</title>
    <script src="js/script.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/pianificazioneDocenti.css" rel="stylesheet">
    <!-- script per la gestione dei select -->
    <script>
      // funzione che viene eseguita quando si cambia il corso
      $(document).ready(function(){
          $("#corso").change(function(){
            valore=$("#corso").val();
              $.ajax({
                type:"POST",
                url: "model/pianificazioneDocenti2.php",
                data:{durataCorso:valore},
                success: function(result){
                  $('#durataCiclo').val(result);
                  anno=$("#ciclo").val();
                  durata=$("#durataCiclo").val();
                    $.ajax({
                      type:"POST",
                      url: "model/pianificazioneDocenti2.php",
                      data:{annoCiclo:anno,durataCiclo:durata},
                      success: function(result){
                        $('#ciclo2').val(result);
                    }});
              }});
          });
      });
      // funzione che viene eseguita quando si cambia il corso
      $(document).ready(function(){
          $("#corso").change(function(){
            valore=$("#corso").val();
              $.ajax({
                type:"POST",
                url: "model/pianificazioneDocenti2.php",
                data:{classeCorso:valore},
                success: function(result){
                  result=JSON.parse(result);
                  $("#classe").find("option").remove();
                  for (var i = 0; i < result.length; i++) {
                    $("#classe").append("<option value='"+result[i]+"'>"+result[i]+"</option>")
                  }
              }});
          });
      });
      // funzione che viene eseguita quando si cambia il ciclo
      $(document).ready(function(){
          $("#ciclo").change(function(){
            anno=$("#ciclo").val();
            durata=$("#durataCiclo").val();
              $.ajax({
                type:"POST",
                url: "model/pianificazioneDocenti2.php",
                data:{annoCiclo:anno,durataCiclo:durata},
                success: function(result){
                  $('#ciclo2').val(result);
              }});
          });
      });


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
            <span class="glyphicon glyphicon-log-out button"></span> exit
          </a>
        </span>
      </div>
      <h1>Pianificazione Docenti MP</h1>
      <br>
      <label class="col-sm-12 col-xs-12 control-label titolo">Docenti</label>
      <form method="post">
        <?php
          for ($i=0; $i < 4; $i++) {

        ?>
        <div class="col-md-12" id="docente">
          <span class="col-md-3 col-xs-6">
            Cognome
            <input type="text" name="cognomeDocente[]" class="form-control"></input>
          </span>
          <span class="col-md-3 col-xs-6">
            Nome
            <input type="text" name="nomeDocente[]" class="form-control"></input>
          </span>
          <span class="col-md-3 col-xs-6">
            Materia
            <select name="materia[]" class="form-control">
              <option selected="true" value="">-- seleziona --</option>
              <!--inserimento dati tramite php-->
              <?php
              $materia = "select mat_nome as 'materia' from materia;";
              $result = $newDB->query($materia);
              while($row = $result->fetch_assoc()){
                ?>
                <option><?php echo $row["materia"]?></option>
                <?php
              }
              ?>
            </select>
          </span>
          <span class="col-md-3 col-xs-6">
            Ore Materia (ciclo form.)
            <input type="number" class="form-control" name="ore[]" id="ore" step="1" min="0"/>
          </span>
        </div>
        <?php
          }
        ?>
        <div class="col-xs-12 altro">
          <span class="col-md-3 col-xs-4">
            Tipo MP
            <select name="corso" id="corso" class="form-control">
              <option selected="true" value="">-- seleziona --</option>
              <?php
              $corso = "select cor_nome as 'corso' from corso;";
              $result = $newDB->query($corso);
              while($row = $result->fetch_assoc()){
                ?>
                <option><?php echo $row["corso"]?></option>
                <?php
              }
              ?>
            </select>
          </span>
          <span class="col-md-2 col-xs-4">
            Classe
            <select name="classe" id="classe" class="form-control">
              <option selected="true" value=""> -- </option>
            </select>
          </span>
          <span class="col-md-2 col-xs-4">
            Durata Ciclo
            <input name="durataCiclo" id="durataCiclo" tyte="text" readonly="true" class="form-control"></input>
          </span>
          <span class="col-md-3 col-xs-10">
            Ciclo Formativo
            <table>
              <tr>
                <td class="col-xs-5" style="padding-left:0px;">
                  <span>
                    <select name="ciclo" id="ciclo" class="form-control">
                      <?php
                        for ($i=2013; $i < 2023; $i++) {
                      ?>
                        <option><?php echo $i; ?></option>
                      <?php
                        }
                      ?>

                    </select>
                  </span>
                </td>
                <td class="col-xs-2">
                  <span >
                    <span>--</span>
                  </span>
                </td>
                <td class="col-xs -5">
                  <span>
                  <input name="ciclo2" id="ciclo2" type="text" readonly="true" class="form-control"></input>
                  </span>
                </td>
              </tr>
            </table>
          </span>
          <span class="col-md-2 col-xs-2">
            Semestre
            <select name="sem" id="sem" class="form-control">
              <?php
                for ($i=1; $i <=2; $i++) {
              ?>
                <option><?php echo $i; ?></option>
              <?php
                }
              ?>

            </select>
          </span>
        </div>
        <div>
          <span class="col-xs-6">
          <label class="col-xs-12 control-label" id="messaggio"></label>
          </span>
        </div>
        <div class="col-md-6">
          <div class="col-md-9"></div>
          <div class="col-xs-6 col-md-3">
            <button type="submit" class="btn btn-secondary btn-lg">
              <span class="glyphicon glyphicon-floppy-disk"></span>Salva
            </button>
          </div>
        </div>
      </form>
    </div>
  </body>
  </html>
  <?php
}
else{
  echo "non hai i permessi per visualizzare questa pagina";
  }
?>
