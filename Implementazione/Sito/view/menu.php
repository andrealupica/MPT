<!-- pagina del menu-->
<?
  session_start();
  if($_SESSION['email']=="" OR $_SESSION['email']==null){
    echo "non hai i permessi per visualizzare questa pagina";
    // reindirizzamento login
  }
  else{
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Menu</title>
  <script src="script.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/menu.css" rel="stylesheet">

</head>
<body>
  <div class="container contenitore">
    <div class="header">
      <span class="opzione">
        <a href="logout.php" class="btn btn-primary  button">
          <span class="glyphicon glyphicon-log-out"></span> exit
        </a>
      </span>
            <h1>Menu Principale AIT</h1>
    </div>
    <!--responsabile-->
    <?php
      if($_SESSION['responsabile']==1 OR $_SESSION['amministratore']==1){
    ?>
    <a class="btn btn-primary col-md-5 col-xs-12" href="pianificazioneDocenti.php"><span>Pianificazione Docenti MP</span></a>
    <a class="btn btn-primary col-md-5 col-xs-12" href="visionePianificazioneMPTR.php"><span>Visione Pianificazione Docenti MP(Responsabile)</span></a>
    <a class="btn btn-primary col-md-5 col-xs-12" href="gestioneAccessoDocenti.php"><span>Gestione Accesso Docenti</span></a>
    <?php
      }
      if($_SESSION['docente']==1){
    ?>
    <!--docente-->
    <a class="btn btn-primary col-md-5 col-xs-12" href="inserimentoOreAIT.php"><span>Inserimento ore AIT Docente</span></a>
    <a class="btn btn-primary col-md-5 col-xs-12" href="visionePianificazioneMPTP.php"><span>Visione Pianificazione Personale MP</span></a>
    <?php } ?>
    <!--altro-->
    <a class="btn btn-primary col-md-5 col-xs-12 " href="visioniParticolari.php"><span>Visioni Particolari</span></a>
    <?php
      if($_SESSION['amministratore']==1){
    ?>
    <!-- amministratore -->
    <a class="btn btn-primary col-md-5 col-xs-12"><span>Amministrazione</span></a>
    <?php
      }
     ?>
  </div>
</body>
</html>
<?php
  }
?>
