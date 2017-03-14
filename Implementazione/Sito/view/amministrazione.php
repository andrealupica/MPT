<!-- pagina per la pianificazione dei docenti-->
<?php
session_start();
if(($_SESSION['email']!="" OR $_SESSION['email']!=null) AND ($_SESSION["amministratore"]==1)){ // da riguardare
  include_once "connection.php";
  ?>
  <!DOCTYPE html>
  <html lang="it">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pagina di amministrazione</title>
    <script src="js/script.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/amministrazione.css" rel="stylesheet">
    <!-- script per la visualizzazione delle pagine -->
    <script>

    $(document).ready(function(){
      $("#Gestione").load("view/amministrazioneCreaMateria.php");
      // funzione per la gestione dei bottoni, prima li setto tutti uguali, dopo modifico solo quello chliccato
      function resetProperty(){
        document.getElementById("bCreaMateria").setAttribute("class","btn btn-primary col-xs-3");
        document.getElementById("bCreaCorso").setAttribute("class","btn btn-primary col-xs-3");
        document.getElementById("bCreaClasse").setAttribute("class","btn btn-primary col-xs-3");
        document.getElementById("bGestioneClasse").setAttribute("class","btn btn-primary col-xs-3");
      }
        $("#bCreaMateria").click(function(){
          resetProperty();
          this.setAttribute("class","btn btn-info col-xs-3");
          $("#Gestione").load("view/amministrazioneCreaMateria.php");
        });
        $("#bCreaCorso").click(function(){
          resetProperty();
          this.setAttribute("class","btn btn-info col-xs-3");
          $("#Gestione").load("view/amministrazioneCreaCorso.php");
        });
        $("#bCreaClasse").click(function(){
          resetProperty();
          this.setAttribute("class","btn btn-info col-xs-3");
          $("#Gestione").load("view/amministrazioneCreaClasse.php");
        });
        $("#bGestioneClasse").click(function(){
          resetProperty();
          this.setAttribute("class","btn btn-info col-xs-3");
          $("#Gestione").load("view/amministrazioneGestioneClaCor.php");
        });
    });
    </script>
  </head>
  <body class="body">
    <div class="container contenitore">
      <div class="header">
        <span class="opzione">
          <a class="btn btn-primary" href="pageLog.php">
            <span class="glyphicon glyphicon-align-justify button"></span> log
          </a>
          <a class="btn btn-primary" href="menu.php">
            <span class="glyphicon glyphicon-arrow-left button"></span> menu
          </a>
          <a href="logout.php" class="btn btn-primary">
            <span class="glyphicon glyphicon-log-out button"></span> exit
          </a>
        </span>
      </div>
      <h1>Pagina di amministrazione</h1>
      <br>
      <label class="col-sm-12 col-xs-12 control-label titolo">Amministrazione</label>
      <div id="gestioneBottoni" class="btn-group col-xs-12">
        <button type="submit" class="btn btn-primary col-xs-3" id="bCreaMateria" checked>
          <span class="button"></span>Materia
        </button>
        <button type="submit" class="btn btn-primary col-xs-3" id="bCreaCorso">
          <span class="button"></span>Corso
        </button>
        <button type="submit" class="btn btn-primary col-xs-3" id="bCreaClasse">
          <span class="button"></span>Classe
        </button>
        <button type="submit" class="btn btn-primary col-xs-3" id="bGestioneClasse">
          <span class="button"></span>Gestione Classe
        </button>
      </div>
      <div class="col-xs-2"></div>
      <div class="col-xs-8">
        <!-- pagina di Creazione Materia -->
        <div id="Gestione">

        </div>
      </div>
    </div>
    <div>
      <label class="cols-sm-3 control-label" id="errore"></label>
    </div>
  </body>
  </html>
  <?php
}
else{
  echo "non hai i permessi per visualizzare questa pagina";
  }
?>
