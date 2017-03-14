
<!-- pagina della visione dei particolari-->
<?php
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
    <script src="js/script.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/visioniParticolari.css" rel="stylesheet">
    <script type="text/javascript" src="./js/jquery-latest.js"></script>
    <script type="text/javascript" src="./js/jquery.tablesorter.js"></script>
  </head>
  <script>
  $(document).ready(function()
      {
          $("table").tablesorter();
          $("th").click(function(){
            thSelected=$(this);
            $("#indice").text($(this).text());
            //alert($(this).attr('class'));
            if($(this).attr('class')=="header" || $(this).attr('class')=="header headerSortUp"){
              $("#ordine").text("crescente");
            }
            else if($(this).attr('class')=="header headerSortDown"){
              $("#ordine").text("decrescente");
            }

          });
          $("#button").click(function(){
            if(thSelected!=null){

              //alert(thSelected.attr('class'));
              classe = thSelected.attr('class');
              name = thSelected.text();
              $("#orderTable").val(name+"/"+classe);
              //alert($("#orderTable").val());
            }

          });
      });
  </script>
  <body>
    <?php
      $query = "SELECT cl.cla_nome AS  'classe', ma.mat_nome AS  'materia', co.cor_nome AS  'corso', co.cor_durata AS 'durata', pi.pia_ini_anno AS  'inizio anno',
      pi.pia_fin_anno AS  'fine anno', pi.pia_ore_tot AS 'ore totali', pi.pia_ore_AIT as 'AIT',ut.ute_nome AS 'nome',ut.ute_cognome AS 'cognome', pi.pia_sem as 'sem'
      FROM pianifica pi
      JOIN classe cl ON cl.cla_id = pi.cla_id
      JOIN materia ma ON ma.mat_id = pi.mat_id
      JOIN corso co ON co.cor_id = pi.cor_id
      JOIN utente ut ON ut.ute_email = pi.ute_email AND pi.pia_flag=1 order by ut.ute_cognome;";
      $result = $newDB->query($query);
    ?>
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
      <?php
      if(mysqli_num_rows($result) != 0){
      ?>
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
        <label class="col-xs-4">Docente: <input type="checkbox" name="docente" value="1" checked="true" id="docente"></label>
        <label class="col-xs-4">Materia: <input type="checkbox" name="materia" value="2" checked="true" id="materia"></label>
        <label class="col-xs-4">Tipo MP: <input type="checkbox" name="tipo" value="3" checked="true" id="tipo"></label>
        <label class="col-xs-4">Classe: <input type="checkbox" name="classe" value="4" checked="true" id="classe"></label>
        <label class="col-xs-4">Durata Ciclo: <input  type="checkbox" name="durata" value="5" checked="true" id="durata"></label>
        <label class="col-xs-4">Ciclo Formativo: <input  type="checkbox" name="ciclo" value="6" checked="true" id="ciclo"></label>
        <label class="col-xs-4">Semestre: <input  type="checkbox" name="Sem" value="7" checked="true" id="Sem"></label>
        <label class="col-xs-4">Ore Semestrali Materia: <input  type="checkbox" name="ore" value="8" checked="true" id="ore"></label>
        <label class="col-xs-4">% AIT: <input  type="checkbox" name="AIT" value="9" checked="true" id="AIT"></label>
      </div>
      <div id="visione" class="col-xs-12">
        <div>
        <span>la tabella è ordinata per: <b id="indice">Docente</b> </span>
          <br>
          <span>in ordine: <b id="ordine">crescente</b></span>
          <br>
          <span>clicca su un indice della tabella per cambiare l'ordinamento </span>
        </div>
        <table data-role="table" data-mode="columntoggle" class="ui-responsive table table-striped table-bordered" id="table">
          <thead>
            <tr>
              <th class="headerSortDown" >Docente</th>
              <th>Materia</th>
              <th>Tipo MP</th>
              <th>Classe</th>
              <th>Durata</th>
              <th>Ciclo</th>
              <th>Semestre</th>
              <th>Ore</th>
              <th>% AIT</th>
            </tr>
          </thead>
          <tbody>

          <?php
          while($row = $result->fetch_assoc()){
            ?>
            <tr>
              <td ><?php echo $row['cognome']." ".$row['nome'] ?></td>
              <td ><?php echo $row['materia'] ?></td>
              <td ><?php echo $row['corso'] ?></td>
              <td ><?php echo $row['classe'] ?></td>
              <td ><?php echo $row['durata'] ?></td>
              <td ><?php echo $row['inizio anno']." -- ".$row["fine anno"] ?></td>
              <td ><?php echo $row['sem'] ?></td>
              <td ><?php echo $row['ore totali'] ?></td>
              <td ><?php echo number_format($row["AIT"]/$row["ore totali"]*100,2) ?></td>
            </tr>
            <?php } ?>
          </tbody>
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
          <input type="hidden" id="orderTable" name="orderTable" value=""/>
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
      var checkbox = $(this);
        //alert(valore);
        $("#table").find("tr").each(function(index) {
          if($(checkbox).attr('checked')){
            $(this).find("td:nth-child("+valore+")").show();
            $(this).find("th:nth-child("+valore+")").show();
          }
          else{
            $(this).find("td:nth-child("+valore+")").hide();
            $(this).find("th:nth-child("+valore+")").hide();
          }
        });
    });
  </script>
</html>
