<!-- pagina per la creazione delle classi -->
<?php
	session_start();
	if($_SESSION['email']=="" OR $_SESSION['email']==null){
	  echo "non hai i permessi per visualizzare questa pagina";
	}
	else{
  include_once "connection.php";
  ?>
	<html lang="it">
	  <head>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <title>proposte</title>
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
	            <span class="glyphicon glyphicon-arrow-left button"></span> menu
	          </a>
	          <a href="logout.php" class="btn btn-primary">
	            <span class="glyphicon glyphicon-log-out button"></span> exit
	          </a>
	        </span>
	      </div>
	      <h1>Proposte </h1>
	      <br>
    <div class="form-group col-xs-12">
      <label class="col-xs-3 control-label">Inserisci un titolo:</label>
      <form method="post">
        <div class="col-xs-9">
          <div class="input-group">
            <span class="input-group-btn">
              <button style="height:34px" id="buttonAdd"  class="btn glyphicon glyphicon-plus" type="submit" onclick="return false"></button>
            </span>
            <input  style="margin-top: 0.0625em" type="text" class="form-control" name="addTitolo" id="addTitolo" placeholder="clicca il + per salvare"></input>
          </div>
        </div>
      </form>
    </div>
    <div class="form-group col-xs-12">
      <label class="col-xs-3 control-label">Ricerca:</label>
      <div class="col-xs-9">
        <div class="input-group">
          <span class="input-group-addon glyphicon glyphicon-search"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
          <input type="text" class="form-control" id="search"></input>
        </div>
      </div>
    </div>
    <div>
      <table id="table" class="table col-xs-12">
        <tr><th>Tema</th><th>Materie</th><th>modifica</th><th>elimina</th></th>
        <?php
        $query="select t.tem_titolo,m.mat_nome from propone p,tema t,materia m where p.pro_flag=1 AND m.mat_id=p.mat_id AND t.tem_id=p.tem_id order by t.tem_titolo";
        $result = $newDB->query($query);
        while($row = $result->fetch_assoc()){
          ?>
          <tr>
            <td class="col-xs-5"><input type="text" readonly="true" class="form-control" id="<?php echo $row['cla_id'];?>" value="<?php echo $row['nome'];?>"></input></td>
						<td class="col-xs-5"><input type="text" readonly="true" class="form-control" id="<?php echo $row['cla_id'];?>" value="<?php echo $row['nome'];?>"></input></td>
						<td class="col-xs-1">
              <button type="button" name='button' id="" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModalM" onclick="document.getElementById('modifyProposte').value='<?php echo $row['tem_id'];?>';">
                <span class="glyphicon glyphicon-edit"></span>
              </button>
            </td>
            <td class="col-xs-1">
              <button type="button" name='button' id="" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#myModal" onclick="document.getElementById('removeProposte').value='<?php echo $row['tem_id'];?>';">
                <span class="glyphicon glyphicon-remove"></span>
              </button>
            </td>
          </tr>
          <?php } ?>
      </table>
    </div>
    <div class="container">
      <!-- Modal -->
      <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Eliminazione Classe</h4>
            </div>
            <div class="modal-body">
              <p>sei sicuro di voler eliminare la classe?</p>
              <div class="alert alert-warning">
                <strong>Attenzione!</strong> Se l'eliminazione sarà irreversibile
              </div>
            </div>
            <div class="modal-footer">
              <form method="post" action="">
                <button type="submit" onclick="return false" class="btn btn-default" id="buttonRemove">ok</button>
                <input type="hidden" id="removeProposte" name="removeProposte" required="required"/>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <!-- Modal -->
      <div class="modal fade" id="myModalM" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Modifica Classe</h4>
            </div>
            <div class="modal-body">
              <p>sei sicuro di voler modificare la classe?</p>
              <div class="alert alert-info">
                <strong>Info!</strong> Le modifiche verranno appportate anche alle altre pagine
              </div>
            </div>
            <div class="modal-footer">
              <form method="post" action="">
                <button type="submit" onclick="return false" class="btn btn-default" id="buttonModify">ok</button>
                <input type="hidden" id="modifyProposte" name="modifyProposte" required="required"/>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
  $("#search").keyup(function() {
    var value = this.value.toLowerCase();
    $("#table").find("tr").each(function(index) {
      if (index === 0) return;
      var id = $(this).find("td").find("input").val().toLowerCase();
      $(this).toggle(id.indexOf(value) !== -1);
    });
  });
  </script>
</body>
<?php } ?>
