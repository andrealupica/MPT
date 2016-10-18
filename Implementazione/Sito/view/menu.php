<?
  session_start();
  if($_SESSION['email']=="" OR $_SESSION['email']==null){
    echo "non hai i permessi per visualizzare questa pagina";
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
  <script src="file.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/menu.css" rel="stylesheet">

</head>
<body>
  <div class="container contenitore">
    <div class="header">
      <span class="opzione">
        <a href="logout.php" class="btn btn-primary">
          <span class="glyphicon glyphicon-log-out"></span> exit
        </a>
      </span>
            <h1>Menu principale AIT</h1>
    </div>
    <!--responsabile-->

    <?php
      //echo $_SESSION['docente'];
      //echo $_SESSION['amministratore'];
      //echo $_SESSION['responsabile'];
      if($_SESSION['responsabile']==1){
    ?>
    <a class="btn btn-primary col-md-5 col-xs-12" href="pianificazioneDocenti.php"><span>Pianificazione Docenti MPT</span></a>
    <a class="btn btn-primary col-md-5 col-xs-12"><span>Visione Pianificazione Docenti MPT(Responsabile)</span></a>
    <a class="btn btn-primary col-md-5 col-xs-12"><span>Visione Pianificazione Docente MPT completa</span></a>
    <a class="btn btn-primary col-md-5 col-xs-12" href="gestioneAccessoDocenti.php"><span>Gestione Accesso Docenti</span></a>
    <?php
      }
      if($_SESSION['docente']==1){
    ?>
    <!--docente-->
    <a class="btn btn-primary col-md-5 col-xs-12"><span>Inserimento ore AIT Docente</span></a>
    <a class="btn btn-primary col-md-5 col-xs-12"><span>Visione Pianificazione Docente MPT</span></a>
    <?php } ?>
    <!--altro-->
    <a class="btn btn-primary col-md-5 col-xs-12"><span>Visioni Particolari</span></a>
    <?php
      if($_SESSION['amministratore']==1){
    ?>
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
