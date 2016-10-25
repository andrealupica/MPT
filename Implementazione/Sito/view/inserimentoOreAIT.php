<?
session_start();
if($_SESSION['email']=="" OR $_SESSION['email']==null OR  $_SESSION["docente"]!=1){
  echo "non hai i permessi per visualizzare questa pagina";
}
else{
  include_once "connection.php";?>
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

  <body class="body">
    <div class="container contenitore">
      <div class="header">
        <span class="opzione">
          <a class="btn btn-primary" href="menu.php">
            <span class="glyphicon glyphicon-arrow-left"></span> menu
          </a>
          <a href="logout.php" class="btn btn-primary">
            <span class="glyphicon glyphicon-log-out"></span> exit
          </a>
        </span>
      </div>
      <h1>inserimento ore AIT </h1>
      <br>
      <label class="col-sm-2 control-label">Docenti</label>
      <label class="col-sm-10 control-label"></label>
      <form method="post">
        <?php
          for ($i=0; $i < 1; $i++) {

        ?>
        <div class="col-md-12" id="docente">
          <span class="col-md-2 col-xs-12">
            Materia
            <input type="text" name="materia[]" class="form-control" readonly="true"></input>
          </span>
          <span class="col-md-1 col-xs-12">
            Classe
            <input type="text" name="classe[]" class="form-control" readonly="true"></input>
          </span>
          <span class="col-md-2 col-xs-12">
            Tipo MP
            <input type="text" name="corso[]" class="form-control" readonly="true"></input>
          </span>
          <span class="col-md-4 col-xs-6">
            <span class="col-md-12 col-xs-12">
                  Ciclo Formativo
            </span>
            <span class="col-md-5 col-xs-5">
              <input type="text" class="form-control" name="ciclo[]"  readonly="true"/>
            </span>
            <span  class="col-md-2 col-xs-2">
              --
            </span>
            <span  class="col-md-5 col-xs-5">
              <input type="text" class="form-control" name="ciclo[]"  readonly="true"/>
            </span>
          </span>
          <span class="col-md-1 col-xs-2">
            Ore_AIT
            <input type="text" class="form-control" name="ore[]"  readonly="true"/>
          </span>
          <span class="col-md-1 col-xs-2">
            % AIT
            <input type="text" class="form-control"  readonly="true"/>
          </span>
          <span class="col-md-1 col-xs-2">
            Dettaglio
            <input type="button" class="form-control" name="dettaglio[]"  readonly="true"/>
          </span>
        </div>
        <?php
          }
        ?>
        <div>
          <label class="col-sm-4 control-label" id="messaggio"></label>
        </div>
        <div class="col-md-12  salva">
          <div class="col-sm-9"></div>
          <div class="col-sm-6 col-md-3">
            <button type="submit" class="btn btn-secondary">
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
?>
