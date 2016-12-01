<?php
  session_start();
  include "../connection.php";
  if(($_SESSION['email']!="" OR $_SESSION['email']!=null) AND ($_SESSION["amministratore"]==1)){
    $query="select mat_nome AS 'nome' from materia order by mat_nome";
    $result = $newDB->query($query);
  ?>
  <body>
    <script>
    $(document).ready(function(){
      $("#buttonAdd").click(function(){
        valore=$("#addMateria").val();
        //alert(valore);
        $.ajax({
          type:"POST",
          url: "model/amministrazione.php",
          data:{addMat:valore},
          success: function(result){
            // location.reload();
          $("#creaMateria").load("view/amministrazioneCreaMateria.php");
          }
        });
      });
      $("#buttonRemove").click(function(){
        valore=$("#removeMateria").val();
        $('#myModal').modal('hide');
        //alert(valore);
        $.ajax({
          type:"POST",
          url: "model/amministrazione.php",
          data:{removeMat:valore},
          success: function(result){
            // location.reload();
          $("#creaMateria").load("view/amministrazioneCreaMateria.php");
          }
        });
      });
    });
    </script>
  <div></div>
  <div clas="contenitore">
    <h4>Creazione Materia</h4>
    <div class="form-group col-xs-12">
      <label class="col-xs-3 control-label">Crea Materia:</label>
      <form method="post">
        <div class="col-xs-9">
          <div class="input-group">
            <span class="input-group-btn">
              <button style="height:34px" id="buttonAdd"  class="btn glyphicon glyphicon-plus" type="submit" onclick="return false"></button>
            </span>
            <input  style="margin-top: 0.0625em" type="text" class="form-control" name="addMateria" id="addMateria" placeholder="clicca il + per salvare la materia"></input>
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
        <tr><th>nome della materia</th><th>elimina</th></th>
        <?php
        while($row = $result->fetch_assoc()){
          ?>
          <tr>
            <td class="col-xs-10"><?php echo $row["nome"];?></td>
            <td class="col-xs-2">
              <button type="button" name='button' id="" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" onclick="document.getElementById('removeMateria').value='<?php echo $row['nome'];?>';">
                <span class="glyphicon glyphicon-remove"></span>
              </button>
            </td>
          </tr>
          <?php } ?>
      </table>
    </div>
    <div class="container" id="myModal1">
      <!-- Modal -->
      <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Eliminazione Materia</h4>
            </div>
            <div class="modal-body">
              <p>sei sicuro di voler eliminare la materia?</p>
              <div class="alert alert-warning">
                <strong>Attenzione!</strong> Se la materia è stata inserita in una pianificazione non sarà possibile eliminarla
              </div>
            </div>
            <div class="modal-footer">
              <form method="post" action="">
                <button type="submit" onclick="return false" class="btn btn-default" id="buttonRemove">ok</button>
                <input type="hidden" id="removeMateria" name="removeMateria" required="required"/>
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
