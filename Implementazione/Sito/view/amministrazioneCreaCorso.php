<!-- pagina per la creazione dei corsi -->
<?php
  session_start();
  include "../connection.php";
  if(($_SESSION['email']!="" OR $_SESSION['email']!=null) AND ($_SESSION["amministratore"]==1)){
  ?>
  <body>
    <script>
    $(document).ready(function(){
      $("#buttonAdd").click(function(){
        valore=$("#addCorso").val();
        //alert(valore);
        durata=$("#addCorsoDurata").val();
        $.ajax({
          type:"POST",
          url: "model/amministrazione.php",
          data:{addCorso:valore,addCorsoDurata:durata},
          success: function(result){
          $("#Gestione").load("view/amministrazioneCreaCorso.php");
          }
        });
      });

      $("#buttonRemove").click(function(){
        valore=$("#removeCorso").val();
        //aggiunte queste righe per far funzionare la rimozione della parte nera
        $("#myModal").modal("hide");
        $("body").removeClass("modal-open");
        $(".modal-backdrop").remove();
        $.ajax({
          type:"POST",
          url: "model/amministrazione.php",
          data:{removeCor:valore},
          success: function(result){
          $("#Gestione").load("view/amministrazioneCreaCorso.php");
          }
        });
      });
    });

    $("#buttonModify").click(function(){
      id=$("#modifyCorso").val();
      nome=$("#n"+id).val();
      durata=$("#d"+id).val();
      $("#myModalM").modal("hide");
      $("body").removeClass("modal-open");
      $(".modal-backdrop").remove();
      $.ajax({
        type:"POST",
        url: "model/amministrazione.php",
        data:{modifyNomeCorso:nome,modifyCorsoDurata:durata,modifyCorsoId:id},
        success: function(result){
        $("#Gestione").load("view/amministrazioneCreaCorso.php");
        }
    });
  });
    </script>
  <div></div>
  <div clas="contenitore">
    <h4>Creazione Corso</h4>
    <div class="form-group col-xs-12">
      <label class="col-xs-3 control-label">Crea Corso:</label>
      <form method="post">
        <div class="col-xs-9">
          <div class="input-group">
            <span class="input-group-btn">
              <button style="top:0px;" id="buttonAdd"  class="btn glyphicon glyphicon-plus" type="submit" onclick="return false"></button>
            </span>
            <span class="col-xs-6" style="padding:0px">
              <input type="text" class ="form-control" name="addCorso" id="addCorso" placeholder="clicca il + per salvare">
            </span>
            <span class="col-xs-2" style="padding:0px">
              <select name="addCorsoDurata" id="addCorsoDurata" class="form-control">
                <?php
                for ($i=1; $i < 5; $i++) {
                  echo "<option>".$i."</option>";
                }
                ?>
              </select>
            </span>
         </div>
        </div>
      </form>


    </div>
    <div class="form-group col-xs-12">
      <label class="col-xs-3 control-label">Ricerca:</label>
      <div class="col-xs-9">
        <div class="input-group">
          <span class="input-group-addon glyphicon glyphicon-search"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
          <input type="text" class="form-control" id="search">
        </div>
      </div>
    </div>
    <div>
      <table id="table" class="table col-xs-12">
        <tr><th>nome del corso</th><th>durata del corso</th><th>modifica</th><th>elimina</th></th>
        <?php
        $query="select cor_nome AS 'nome',cor_durata AS 'durata',cor_id from corso where cor_flag=1 order by cor_nome";
        $result = $newDB->query($query);
        while($row = $result->fetch_assoc()){
          ?>
          <tr>
            <td class="col-xs-6"><input type="text" class="form-control" id="<?php echo "n".$row['cor_id'];?>" value="<?php echo $row['nome'];?>"></td>
            <td class="col-xs-3"><input type="number" min=0 max=4 class="form-control" id="<?php echo "d".$row['cor_id'];?>" value="<?php echo $row['durata'];?>"></td>
            <td class="col-xs-2">
              <button type="button" name='button' id="" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModalM" onclick="document.getElementById('modifyCorso').value='<?php echo $row['cor_id'];?>';">
                <span class="glyphicon glyphicon-ok"></span>
              </button>
            </td>
            <td class="col-xs-2">
              <button type="button" name='button' id="" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#myModal" onclick="document.getElementById('removeCorso').value='<?php echo $row['cor_id'];?>';">
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
              <h4 class="modal-title">Eliminazione Corso</h4>
            </div>
            <div class="modal-body">
              <p>sei sicuro di voler eliminare il corso?</p>
              <div class="alert alert-warning">
                <strong>Attenzione!</strong> Se il corso è stato inserito in una pianificazione non sarà possibile eliminarlo
              </div>
            </div>
            <div class="modal-footer">
              <form method="post" action="">
                <button type="submit" onclick="return false" class="btn btn-default" id="buttonRemove">ok</button>
                <input type="hidden" id="removeCorso" name="removeCorso" required="required"/>
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
              <h4 class="modal-title">Modifica Corso</h4>
            </div>
            <div class="modal-body">
              <p>sei sicuro di voler modificare il corso?</p>
              <div class="alert alert-info">
                <strong>Info!</strong> Le modifiche verranno appportate anche alle altre pagine
              </div>
            </div>
            <div class="modal-footer">
              <form method="post" action="">
                <button type="submit" onclick="return false" class="btn btn-default" id="buttonModify">ok</button>
                <input type="hidden" id="modifyCorso" name="modifyCorso" required="required"/>
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
