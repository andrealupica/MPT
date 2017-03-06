
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
    <title>log sito web</title>
    <script src="script.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/visioniParticolari.css" rel="stylesheet">
  </head>
  <script>
  </script>
  <body>
    <?php
      $query = "SELECT l.ute_email AS 'email', l.log_data AS 'data',l.log_descrizione AS 'descrizione',l.log_pagina AS 'pagina',l.log_azione AS 'azione'
      FROM log_ l order by  l.log_data desc";
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
      <h1>Log del sito web</h1>
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
      <div id="visione" class="col-xs-12">
        Log:
        <table data-role="table" data-mode="columntoggle" class="ui-responsive table table-striped table-bordered" id="table">
            <tr>
              <th> Docente</th>
              <th> Azione</th>
              <th> Pagina</th>
              <th> Descrizione</th>
              <th> Data</th>
            </tr>

          <?php
          while($row = $result->fetch_assoc()){
            if($row['azione']=="informazione"){
              echo "<tr class='info'>";
            }
            elseif($row['azione']=="attenzione"){
              echo "<tr class='warning'>";
            }
            elseif($row['azione']=="eliminazione"){
              echo "<tr class='danger'>";
            }
            elseif($row['azione']=="inserimento"){
              echo "<tr class='success'>";
            }
            elseif($row['azione']=="modifica"){
              echo "<tr class='success'>";
            }
            else{
              echo "<tr class='default'>";
            }
            ?>
              <td ><?php echo $row['email'] ?></td>
              <td ><?php echo $row['azione'] ?></td>
              <td ><?php echo $row['pagina'] ?></td>
              <td ><?php echo $row['descrizione'] ?></td>
              <td ><?php echo $row['data'] ?></td>
            </tr>
            <?php } ?>
          </table>
        </div>
          <?php
            }
            else{
              ?>
              <div class="col-xs-12" >
                <h3>
                <label class="col-xs-12 alert lbl-lg alert-info">Non sono presenti dei log</label>
              </h3>
              </div>
              <?php
            }
          ?>
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
        //alert(valore);
        $("#table").find("tr").each(function(index) {
          $(this).find("td:nth-child("+valore+")").toggle();
          $(this).find("th:nth-child("+valore+")").toggle();
        });
    });
  </script>
</html>
