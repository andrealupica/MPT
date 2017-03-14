<!-- pagina del menu-->
<?php
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
  <script src="js/script.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/menu.css" rel="stylesheet">

</head>
<body>
  <div class="container contenitore">
    <div class="header col-xs-12 margin-bottom:0px">
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
    <span class="col-xs-12 col-sm-6">
        <a class="btn btn-primary col-xs-12" href="pianificazioneDocenti.php"><span>Pianificazione Docenti MP</span></a>
    </span>
    <span class="col-xs-12 col-sm-6">
      <a class="btn btn-primary col-xs-12" href="visionePianificazioneMPTR.php"><span>Visione Pianificazione Docenti MP(Responsabile)</span></a>
    </span>
    <span class="col-xs-12 col-sm-6">
      <a class="btn btn-primary col-xs-12" href="gestioneAccessoDocenti.php"><span>Gestione Accesso Docenti</span></a>
    </span>
    <?php
      }
      if($_SESSION['docente']==1 OR $_SESSION['amministratore']==1){
    ?>
    <!--docente-->
    <span class="col-xs-12 col-sm-6">
      <a class="btn btn-primary col-xs-12" href="inserimentoOreAIT.php"><span>Inserimento ore AIT Docente</span></a>
    </span>
    <span class="col-xs-12 col-sm-6">
      <a class="btn btn-primary col-xs-12" href="visionePianificazioneMPTP.php"><span>Visione Pianificazione Personale MP</span></a>
    </span>
    <?php } ?>
    <!--altro-->
     <?php
       if($_SESSION['docente']==1 OR $_SESSION['responsabile']==1 OR $_SESSION['amministratore']==1){
     ?>
    <span class="col-xs-12 col-sm-6">
      <a class="btn btn-primary col-xs-12 " href="visioniParticolari.php"><span>Visioni Particolari</span></a>
    </span>
    <span class="col-xs-12 col-sm-6">
      <a class="btn btn-primary col-xs-12" href="proposte.php"><span>proposte</span></a>
    </span>
     <?php } ?>
     <?php
       if($_SESSION['amministratore']==1){
     ?>
     <!-- amministratore -->
    <span class="col-xs-12 col-sm-6">
      <a class="btn btn-primary col-xs-12" href="amministrazione.php"><span>Amministrazione</span></a>
    </span>
     <?php
       }
      ?>
  </div>
  <h7 style="margin-top:30px;position:fixed;bottom:5px;right:5px;">© 2016-2017 Andrea Lupica (I4AC) ALL RIGHTS RESERVED</h7>
</body>
</html>
<?php
  }
?>
