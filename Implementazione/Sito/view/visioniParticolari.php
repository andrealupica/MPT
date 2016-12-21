
<!-- pagina della visione dei particolari-->
<?
session_start();
if($_SESSION['email']=="" OR $_SESSION['email']==null){
  echo "non hai i permessi per visualizzare questa pagina";
  // reindirizzamento login
}
else{
  include_once "connection.php";
  ?>
<html lang="it">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>visioni particolari</title>
    <script src="script.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/visioniParticolari.css" rel="stylesheet">
  </head>
  <script>
  </script>
  <body>
    <div class="container contenitore">
      <div class="header class="col-xs-12"">
        <span class="opzione">
          <a class="btn btn-primary" href="menu.php">
            <span class="glyphicon glyphicon-arrow-left button"></span> menu
          </a>
          <a href="logout.php" class="btn btn-primary">
            <span class="glyphicon glyphicon-log-out button"></span> exit
          </a>
        </span>
      </div>
      <form method="post" action="model/visioniParticolari.php" target="_blank">
      <h1>Visioni Particolari</h1>
      <div class="form-group col-xs-12">
        <label class="col-xs-2 control-label">Ricerca:</label>
        <div class="col-xs-10">
          <div class="input-group">
            <span class="input-group-addon glyphicon glyphicon-search"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
            <input type="text" name="cerca" class="form-control" id="search" placeholder="filtraggio con più parole"></input>
          </div>
        </div>
      </div>
      <div class="col-xs-12" id="checkbox">
        <label class="col-xs-3">Docente: <input type="checkbox" name="docente" value="1" checked="true" id="docente"></label>
        <label class="col-xs-3">Materia: <input type="checkbox" name="materia" value="2" checked="true" id="materia"></label>
        <label class="col-xs-3">Classe: <input type="checkbox" name="classe" value="3" checked="true" id="classe"></label>
        <label class="col-xs-3">Tipo MP: <input type="checkbox" name="tipo" value="4" checked="true" id="tipo"></label>
        <label class="col-xs-3">Durata Ciclo: <input  type="checkbox" name="durata" value="5" checked="true" id="durata"></label>
        <label class="col-xs-3">Ore Annuali Materia: <input  type="checkbox" name="ore" value="6" checked="true" id="ore"></label>
        <label class="col-xs-3">Ciclo Formativo: <input  type="checkbox" name="ciclo" value="7" checked="true" id="ciclo"></label>
        <label class="col-xs-3">% AIT: <input  type="checkbox" name="AIT" value="8" checked="true" id="AIT"></label>
      </div>
      <?php
      $query = "SELECT cl.cla_nome AS  'classe', ma.mat_nome AS  'materia', co.cor_nome AS  'corso', co.cor_durata AS 'durata', pi.pia_ini_anno AS  'inizio anno',
      pi.pia_fin_anno AS  'fine anno', pi.pia_ore_tot AS 'ore totali', pi.pia_ore_AIT as 'AIT',ut.ute_nome AS 'nome',ut.ute_cognome AS 'cognome'
      FROM pianifica pi
      JOIN classe cl ON cl.cla_id = pi.cla_id
      JOIN materia ma ON ma.mat_id = pi.mat_id
      JOIN corso co ON co.cor_id = pi.cor_id
      JOIN utente ut ON ut.ute_email = pi.ute_email;";
      $result = $newDB->query($query);
      ?>
      <div id="visione" class="col-xs-12">
        Risultato:
        <table data-role="table" data-mode="columntoggle" class="ui-responsive table table-striped table-bordered" id="table">
            <tr>
              <th> Docente</th>
              <th> Materia</th>
              <th> Tipo MP</th>
              <th> Classe</th>
              <th> Durata</th>
              <th> Ore</th>
              <th> Ciclo</th>
              <th> % AIT</th>
            </tr>

          <?php
          while($row = $result->fetch_assoc()){
            ?>
            <tr>
              <td ><?php echo $row['cognome']." ".$row['nome'] ?></td>
              <td ><?php echo $row['materia'] ?></td>
              <td ><?php echo $row['corso'] ?></td>
              <td ><?php echo $row['classe'] ?></td>
              <td ><?php echo $row['durata'] ?></td>
              <td ><?php echo $row['ore totali'] ?></td>
              <td ><?php echo $row['inizio anno']." -- ".$row["fine anno"] ?></td>
              <td ><?php echo $row['AIT']/$row['ore totali']*100 ?></td>
            </tr>
            <?php } ?>
          </table>
        </div>
          <div class="col-xs-12 salva">
            <div class="col-xs-9"></div>
            <div class="col-xs-3">
              <button type="submit" class="btn btn-secondary" id="button">
                <span class="glyphicon glyphicon-floppy-disk button"></span>Salva
              </button>
            </div>
          </div>
      </form>
      </div>
    <?php } ?>
  </body>
  <script>
    // funzione per la barra di ricerca
    $("#search").keyup(function() {
      var value = this.value.toLowerCase();
      var words = value.split(' ');
      $("#table").find("tr").each(function(index) {
        if (index === 0) return;
        var ris = $(this).find("td").text().toLowerCase();
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
    // funzione per la visibilità delle colonne
    $("label input").change(function(){
      var valore=this.value;
        $("#table").find("tr").each(function(index) {
          $(this).find("td:nth-child("+valore+")").toggle();
          $(this).find("th:nth-child("+valore+")").toggle();
        });
    });
  </script>
</html>
