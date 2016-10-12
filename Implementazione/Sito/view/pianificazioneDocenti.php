<?
session_start();
if($_SESSION['email']=="" OR $_SESSION['email']==null OR  $_SESSION["responsabile"]!=1){
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
    <title>pianificazione Docenti</title>
    <script src="file.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/pianificazioneDocenti.css" rel="stylesheet">

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
      <h1>pianificazione Docenti MPT</h1>
      <br>
      <label class="col-sm-2 control-label">Docenti</label>
      <form method="post">
        <div class="col-md-12" id="docente">
          <span class="col-md-3">
            Cognome
            <select name="cognome" class="form-control">
              <!--inserimento dati tramite php-->
              <?php
              $cognome = "select ute_cognome as 'cognome' from utente;";
              $result = $newDB->query($cognome);
              while($row = $result->fetch_assoc()){
                ?>
                <option><?php echo $row["cognome"]?></option>
                <?php
              }
              ?>
            </select>
          </span>
          <span class="col-md-3">
            Nome
            <select name="nome" class="form-control">
              <!--inserimento dati tramite php-->
              <?php
              $nome = "select ute_nome as 'nome' from utente;";
              $result = $newDB->query($nome);
              while($row = $result->fetch_assoc()){
                ?>
                <option><?php echo $row["nome"]?></option>
                <?php
              }
              ?>
            </select>
          </span>
          <span class="col-md-3">
            Materia
            <select name="materia" class="form-control">
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
          <span class="col-md-3">
            Ore Totali Materia
            <input type="number" class="form-control" name="ore" id="ore" step="0.5"/>
          </span>
        </div>
        <div class="col-md-8 altro">
          <span class="col-md-3">
            Tipo MPT
            <select name="corso" class="form-control">
            </select>
          </span>
          <span class="col-md-3">
            Classe
            <select name="corso" class="form-control">
            </select>
          </span>
          <span class="col-md-3">
            Durata Ciclo
            <select name="corso" class="form-control">
            </select>
          </span>
          <span class="col-md-3">
            Ciclo Formativo
            <table>
              <tr>
                <td>
                  <select name="corso" class="form-control">
                  </select>
                </td>
                <td>
                  <p>--</p>
                </td>
                <td>
                  <select name="corso" class="form-control"></select>
                </td>
              </tr>
            </table>
          </span>
        </div>
        <div class="col-md-4">
        </div>
        <div class="col-md-12">
          <div class="col-md-9"></div>
          <div class="col-sm-6 col-md-3">
            <button type="submit" class="btn btn-secondary">
              <span class="glyphicon glyphicon-floppy-disk"></span>Salva
            </button>
          </div>
        </div>
      </form>
    </div>
    <?php

    $cognome = "select ute_cognome as 'cognome' from utente;";
    $result = $newDB->query($cognome);
    while($row = $result->fetch_assoc()){
      echo $row["cognome"];
      echo "<br>";
    }
    ?>
  </body>
  </html>
  <?php
}
?>
