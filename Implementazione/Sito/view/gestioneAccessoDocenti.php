<!-- pagina per la gestione degli accessi di tutti i docenti-->
<?
session_start();
if(($_SESSION['email']!="" OR $_SESSION['email']!=null) AND ($_SESSION["responsabile"]==1 OR $_SESSION["amministratore"]==1)){ // da riguardare
  include_once "connection.php";
  // aggiungere: quando data creazione != nulla
  $query = "select ute_nome as 'nome',ute_cognome as 'cognome',ute_email as 'email',ute_docente as 'docente', ute_responsabile as 'responsabile',ute_amministratore as 'amministratore', ute_gestoreEmail as 'gestore' from utente where ute_dataIscrizione is null order by ute_email;";
  $result = $newDB->query($query);
  ?>
  <!DOCTYPE html>
  <html lang="it">
  <head>
    <title>Gestione Accessi Docenti</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="script.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <link href="css/gestioneDocenti.css" rel="stylesheet">
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
      <h1 class="col-xs-12">Gestione Accessi Docenti</h1>
      <br>
      <div class="form-group">
        <label class="col-sm-2 control-label">Ricerca con Cognome/Nome:</label>
        <div class="col-sm-10">
          <div class="input-group">
            <span class="input-group-addon glyphicon glyphicon-search"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
            <input type="text" class="form-control" id="search"></input>
          </div>
        </div>
      </div>
      <form method="post">
        <table class="table" id="table">
          <thead>
            <tr>
              <th>Cognome</th>
              <th>Nome</th>
              <th>Email</th>
              <th>Docente</th>
              <th>Responsabile</th>
              <th>Gestore delle email</th>
              <th>Cancella</th>
            </tr>
          </thead>
          <tbody>
            <!--inserimento dati tramite php-->
            <?php
            while($row = $result->fetch_assoc()){
              ?>
              <tr>
                <td><?php echo $row["cognome"];?></td>
                <td><?php echo $row["nome"];?></td>
                <td><?php echo $row["email"];?></td>
                <td><div class="checkbox">
                  <label><input type="checkbox" value="<?php echo $row['email'];?>" name="docente[]" <?php echo ($row['docente']==1 ? 'checked' : '');?>></label>
                </div></td>
                <td><div class="checkbox">
                  <label><input type="checkbox" value="<?php echo $row['email'];?>" name="responsabile[]" <?php echo ($row['responsabile']==1 ? 'checked' : '');?>></label>
                </div></td>
                <td>
                  <div class="radio">
                    <label><input type="radio"  name="gestore[]" value="<?php echo $row['email'];?>" <?php echo ($row['gestore']==1 ? 'checked' : '');?>></label>
                  </div>
                </td>
                <td>
                  <?php if($row['amministratore']==1){ // se non è amministratore non mostrare

                  }
                  else if($row['responsabile']==1 AND $_SESSION["amministratore"]==1){ // se è responsabile e admin loggato mostra
                  ?>
                  <form method="post">
                    <button type="button" name='button' id="<?php echo $row['email'];?>" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" onclick="document.getElementById('pEliminazione').value='<?php echo $row['email'];?>';">
                      <span class="glyphicon glyphicon-remove"></span>
                    </button>
                  </form>
                  <?php
                  }
                  else if($row['responsabile']==1  AND $_SESSION["amministratore"]!=1){ // se è responsabile e non  admin loggato non mostrare

                  }
                  else{
                  ?>
                  <form method="post">
                    <button type="button" name='button' id="<?php echo $row['email'];?>" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" onclick="document.getElementById('pEliminazione').value='<?php echo $row['email'];?>';">
                      <span class="glyphicon glyphicon-remove"></span>
                    </button>
                  </form>
                  <?php
                  }
                  ?>
                </td>
              </tr>
              <?php
            }
            ?>
          </tbody>
        </table>
        <div>
        </div>
        <div class="col-xs-12 col-sm-12">
          <button type="submit" class="btn btn-secondary col-xs-2">
            <span class="glyphicon glyphicon-floppy-disk"></span>Salva
          </button>
          <span class="col-xs-1"></span>
          <label class="cols-xs-9 label label-warning" id="messaggio">le modifiche verranno apportate solo con il pulsante salva</label>
        </div>
      </form>
      <div class="container">
        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Eliminazione account</h4>
              </div>
              <div class="modal-body">
                <p>sei sicuro di voler eliminare l'account?</p>
              </div>
              <div class="modal-footer">
                <form method="post" action="">
                  <button type="submit" class="btn btn-default">ok</button>
                  <input type="hidden" name="emailCancellata" id="pEliminazione" required="required"/>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script>
    $("#search").keyup(function() {
      var value = this.value;
      $("#table").find("tr").each(function(index) {
        if (index === 0) return;
        var id = $(this).find("td").text();
        $(this).toggle(id.indexOf(value) !== -1);
      });
    });
    </script>
  </body>
  </html>
  <?php
}
else{
  echo "non hai i permessi per visualizzare questa pagina";

}
?>
