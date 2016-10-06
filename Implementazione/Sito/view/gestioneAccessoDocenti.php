<?
session_start();
if($_SESSION['email']=="" OR $_SESSION['email']==null){
  echo "non hai i permessi per visualizzare questa pagina";
}
else{
  include_once "connection.php";
  $query = "select ute_nome as 'nome',ute_cognome as 'cognome',ute_email as 'email',ute_docente as 'docente', ute_responsabile as 'responsabile', ute_gestoreEmail as 'Gestore' from utente;";
  $result = $newDB->query($query);
  ?>
  <!DOCTYPE html>
  <html lang="it">
  <head>
    <title>Gestione Accessi Docenti</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>

    <div class="container">
      <h1>Gestione Accessi Docenti</h1>
      <form>
        <table class="table">
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
                  <label><input type="checkbox" name="<?php echo $row['$email'];?>[]" value="docente"></label>
                </div></td>
                <td><div class="checkbox">
                  <label><input type="checkbox" name="<?php echo $row['$email'];?>[]" value="responsabile"></label>
                </div></td>
                <td><div class="radio">
                  <label><input type="radio" name="<?php echo $row['$email'];?>[]" value="gestore"></label>
                </div></td>
                <td>
                  <form>
                    <button type="button" name='button' class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">
                      <span class="glyphicon glyphicon-remove"></span>
                    </button>
                    <input type="hidden" name="<?php echo $row['$email'];?>">
                  </form>
                </td>
              </tr>
              <?php
            }
            ?>
          </tbody>
        </table>
        <div class="col-xs-6 col-sm-3">
          <button type="submit" class="btn btn-secondary" href="model/gestioneAccessoDocenti.php">
            <span class="glyphicon glyphicon-floppy-disk"></span>Salva
          </button>
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
         <p>Sei sicuro di voler eliminare l'account<?php echo $_Post['name']?>?</p>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal">ok</button>
       </div>
     </div>

   </div>
 </div>

      </div>
    </div>
  </body>
  <script src="file.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  </html>
  <?php
}
?>
