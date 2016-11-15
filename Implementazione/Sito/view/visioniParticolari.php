
<!-- pagina della visione dei particolari-->
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
  <title>visioni particolari</title>
  <script src="script.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/visioniParticolari.css" rel="stylesheet">

</head>
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
    	<h1>Visioni Particolari</h1>
		<div class="form-group col-xs-12">
			<label class="col-xs-2 control-label">Ricerca:</label>
			<div class="col-xs-10">
				<div class="input-group">
					<span class="input-group-addon glyphicon glyphicon-search"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
					<input type="text" class="form-control" id="search"></input>
				</div>
			</div>
		</div>
		<div class="col-xs-12">
    	<label class="col-xs-4">Cognome: <input type="checkbox" value="cognome" checked="true"></label>
    	<label class="col-xs-4">Nome: <input type="checkbox" value="nome" checked="true"></label>
			<label class="col-xs-4">Materia: <input type="checkbox" value="materia" ></label>
			<label class="col-xs-4">Classe: <input type="checkbox" value="classe" ></label>
			<label class="col-xs-4">Tipo MP: <input type="checkbox" value="tipo" ></label>
			<label class="col-xs-4">Durata Ciclo: <input  type="checkbox" value="durata" ></label>
			<label class="col-xs-4">Ore Annuali Materia: <input  type="checkbox" value="ore" ></label>
			<label class="col-xs-4">Ciclo Formativo: <input  type="checkbox" value="ciclo" ></label>
			<label class="col-xs-4">% AIT: <input  type="checkbox" value="AIT" ></label>
		</div>
	</div>
	<?php } ?>
</body>
</html>
