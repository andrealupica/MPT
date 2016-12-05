<?php
  session_start();
  include "../connection.php";
  if(($_SESSION['email']!="" OR $_SESSION['email']!=null) AND ($_SESSION["amministratore"]==1)){
    $query="select cor_nome AS 'nome' from corso order by cor_nome";
    $result = $newDB->query($query);
  ?>
  <body>
    <script>
    $(document).ready(function(){
      $("#buttonAdd").click(function(){
        valore=$("#addCorso").val();
        $.ajax({
          type:"POST",
          url: "model/amministrazione.php",
          data:{addCor:valore},
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
              <button style="height:34px" id="buttonAdd"  class="btn glyphicon glyphicon-plus" type="submit" onclick="return false"></button>
            </span>
            <input  style="margin-top: 0.0625em" type="text" class="form-control" name="addCorso" id="addCorso" placeholder="clicca il + per salvare"></input>
            <input  style="margin-top: 0.0625em" type="number" min="1" class="form-control" name="addCorsoDurata" id="addCorsoDurata" placeholder="durata"></input>
          </div>
        </div>
      </form>

    </div>


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
        <tr><th>nome del corso</th><th>elimina</th></th>
        <?php
        while($row = $result->fetch_assoc()){
          ?>
          <tr>
            <td class="col-xs-10"><?php echo $row["nome"];?></td>
            <td class="col-xs-2">
              <button type="button" name='button' id="" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" onclick="document.getElementById('removeCorso').value='<?php echo $row['nome'];?>';">
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
                <strong>Attenzione!</strong> Se il corso è stata inserita in una pianificazione non sarà possibile eliminarlo
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
  </div>

  <script>
  $("#search").keyup(function() {
    var value = this.value.toLowerCase();
    $("#table").find("tr").each(function(index) {
      if (index === 0) return;
      var id = $(this).find("td").text().toLowerCase();
      $(this).toggle(id.indexOf(value) !== -1);
    });
  });
  </script>
</body>
<?php } ?>
