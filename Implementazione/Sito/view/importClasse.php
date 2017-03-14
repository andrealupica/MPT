<!-- pagina per la pianificazione dei docenti-->
<?php
session_start();
if(($_SESSION['email']!="" OR $_SESSION['email']!=null) AND ($_SESSION["amministratore"]==1)){ // da riguardare
  include_once "connection.php";

  //echo "sessione:".$_POST['importaClasse'].$_SESSION["idClasse"].$_SESSION["idCorso"];
  // se è stato premuto il tasto nella pagina amministrazione o se si ricarica la pagina ( sessioni già attivate)
  if(isset($_POST['importaClasse']) OR isset($_SESSION["idClasse"]) AND isset($_SESSION["idCorso"])){
  ?>
  <!DOCTYPE html>
  <html lang="it">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Importa classe</title>
    <script src="js/script.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/inserimentoOreAIT.css" rel="stylesheet">
    <!-- script per la visualizzazione delle pagine -->
    <script>
    $(document).ready(function(){

      $("#buttonRemove").click(function(){
        id=$("#removeAllievo").val();
        //aggiunte queste righe per far funzionare la rimozione della parte nera
        $.ajax({
          type:"POST",
          url: "model/importClasse.php",
          data:{removeAllievo:id},
          success: function(result){
          }
        });
      });

      $("#buttonClear").click(function(){
        //aggiunte queste righe per far funzionare la rimozione della parte nera
        id="";
        $.ajax({
          type:"POST",
          url: "model/importClasse.php",
          data:{clearClasse:id},
          success: function(result){
          }
        });
      });

      $("#buttonModify").click(function(){
        valore = $("#modifyAllievo").val();
        //alert(nome+" "+id);
        //alert(valore);
        $.ajax({
          type:"POST",
          url: "model/importClasse.php",
          data:{modifyAllievo:valore},
          success: function(result){
          }
        });
      });
    });
    function selectInfo(obj){
      stringa="";
      id=$(obj).val();
      //alert(id);
      stringa+= $(obj).val()+"+";
      stringa+= $("#nome"+id).val()+"+";
      stringa+= $("#nascita"+id).val()+"+";
      stringa+= $("#info"+id).val();
      $("#modifyAllievo").val(stringa);
    }
    </script>
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
      <h1>Inserimento degli allievi</h1>
      <h3><?php echo $_SESSION["corso"]." - ".$_SESSION["classe"]; ?></h3>
      <div class="container">
          <div class="tab-content">
             <div role="tabpanel" class="tab-pane active">
                <div class="row">
                   <div class="col-xs-12">
                     <form role="form" action="" method="post" name="form1" enctype="multipart/form-data">
                        <fieldset>
                           <div class="form-group">
                              <p>Scegli il file degli utenti:</p>
                           </div>
                            <input name="idCSV" type="file" id="idCSV" accept=".csv" />
                            <input type="text" hidden="true" name="corso" readonly="true" value="<?php echo $idCorso;?>"/>
                            <input type="text" hidden="true" name="classe" readonly="true" value="<?php echo $idClasse;?>"/>
                            <input type="submit" name="Import" value="Importa " class="btn btn-primary" />
                        </fieldset>
                     </form>
                   </div>
                </div>
             </div>
          </div>
        </div>
      <br>
      <div class="form-group">
        <label class="col-xs-2 control-label">Ricerca: </label>
        <div class="col-xs-8">
          <div class="input-group">
            <span class="input-group-addon glyphicon glyphicon-search"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
            <input type="text" class="form-control" id="search"></input>
          </div>
        </div>
        <td class="col-xs-1">
          <button type="button" name='buttonM' id="buttonClear" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#myModalClear">
            <h5>svuota</h5>
          </button>
        </td>
      </div>
      <label class="col-sm-12 col-xs-12 control-label titolo"></label>
      <?php
        $query="SELECT all_id AS 'id', all_nome AS 'nome', all_birthday AS 'born', all_info AS 'info' FROM allievo where all_flag=1 AND cor_id=".$_SESSION["idCorso"]." AND cla_id=".$_SESSION["idClasse"];
        //echo $query;
        $result = $newDB->query($query);
        if(mysqli_num_rows($newDB->query($query)) !=0 ){
       ?>
      <table id="table" class="table col-xs-12">
        <tr><th class="col-xs-4">Allievo</th><th class="col-xs-3">Data di nascita</th><th class="col-xs-3">Altre info</th><th class="col-xs-1">Modifica</th><th class="col-xs-1">Elimina</th></tr>
        <?php
        while($row = $result->fetch_assoc()){
          ?>
          <tr id="riga">
            <td class="col-xs-3"><input type="text" class="form-control "  id="<?php echo 'nome'.$row['id'];?>" value="<?php echo $row['nome'];?>"></input></td>
            <td class="col-xs-2"><input type="date" class="form-control " placeholder="yyyy-mm-dd"  id="<?php echo 'nascita'.$row['id'];?>" value="<?php echo $row['born'] ?>"/>
            <td class="col-xs-5"><input type="text" class="form-control "  id="<?php echo 'info'.$row['id'];?>" value="<?php echo $row['info'] ?>"/>
          </td>
            <td class="col-xs-1">
              <button type="button" name='buttonM' id="buttonM" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModalM" onclick="selectInfo(this);" value='<?php echo $row['id'];?>'>
                <span class="glyphicon glyphicon-ok"></span>
              </button>
            </td>
            <td class="col-xs-1">
              <button type="button" name='button' id="" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#myModal" onclick="document.getElementById('removeAllievo').value='<?php echo $row['id'];?>';">
                <span class="glyphicon glyphicon-remove"></span>
              </button>
            </td>
          </tr>
          <?php } ?>
      </table>
      <?php
      }
      else{
        ?>
        <div class="col-xs-12">
          <h3>
          <label class="col-xs-12 alert lbl-lg alert-info">Non sono presenti allievi</label>
        </h3>
        </div>
        <?php
      }
    ?>
    </div>
    <div class="container">
      <!-- Modal -->
      <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Eliminazione allievo</h4>
            </div>
            <div class="modal-body">
              <p>sei sicuro di voler eliminare l'allievo?</p>
              <div class="alert alert-warning">
                <strong>Attenzione!</strong> L'eliminazione è irreversibile
              </div>
            </div>
            <div class="modal-footer">
              <form method="post" action="">
                <button type="submit" class="btn btn-default" id="buttonRemove">ok</button>
                <input type="hidden" id="removeAllievo" name="removeAllievo" required="required"/>
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
              <h4 class="modal-title">Modifica allievo</h4>
            </div>
            <div class="modal-body">
              <p>sei sicuro di voler modificare l'allievo?</p>
              <div class="alert alert-info">
                <strong>Info!</strong> Le modifiche verranno modificate anche nelle altre pagine
              </div>
            </div>
            <div class="modal-footer">
              <form method="post" action="">
                <button type="submit"  class="btn btn-default" id="buttonModify">ok</button>
                <input type="hidden" id="modifyAllievo" name="modifyAllievo" required="required"/>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <!-- Modal -->
      <div class="modal fade" id="myModalClear" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Eliminazione di tutti gli allievi</h4>
            </div>
            <div class="modal-body">
              <p>sei sicuro di voler svuotare l'intera classe?</p>
              <div class="alert alert-danger">
                <strong>Attenzione!</strong> L'eliminazione è irreversibile
              </div>
            </div>
            <div class="modal-footer">
              <form method="post" action="">
                <button type="submit" class="btn btn-default" id="buttonClear">ok</button>
                <input type="hidden" id="clearClasse" name="clearClasse" required="required"/>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div>
      <label class="cols-sm-3 control-label" id="errore"></label>
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
  </html>
  <?php
  }
  else{
    echo "non è stato selezionato nessuna classe di un determinato corso";
    echo "<br><a href='amministrazione.php'>torna alla pagina di amministrazione</a>";
  }
}
else{
  echo "non hai i permessi per visualizzare questa pagina";
}
?>
