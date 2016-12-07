<?php
  session_start();
  include "../connection.php";
  if(($_SESSION['email']!="" OR $_SESSION['email']!=null) AND ($_SESSION["amministratore"]==1)){
  ?>
  <body>
    <script>
    $(document).ready(function(){
      $("#buttonAdd").click(function(){
        valore=$("#addClasse").val();
        $.ajax({
          type:"POST",
          url: "model/amministrazione.php",
          data:{addCla:valore},
          success: function(result){
          $("#Gestione").load("view/amministrazioneCreaClasse.php");
          }
        });
      });

      $("#buttonRemove").click(function(){
        valore=$("#removeClasse").val();
        //aggiunte queste righe per far funzionare la rimozione della parte nera
        $("#myModal").modal("hide");
        $("body").removeClass("modal-open");
        $(".modal-backdrop").remove();
        $.ajax({
          type:"POST",
          url: "model/amministrazione.php",
          data:{removeCla:valore},
          success: function(result){
          $("#Gestione").load("view/amministrazioneCreaClasse.php");
          }
        });
      });

      $("#buttonModify").click(function(){
        id = $("#modifyClasse").val();;
        nome = $("#"+id).val();
        //alert(nome+" "+id);
        $("#myModalM").modal("hide");
        $("body").removeClass("modal-open");
        $(".modal-backdrop").remove();
        $.ajax({
          type:"POST",
          url: "model/amministrazione.php",
          data:{modifyNomeClasse:nome,modifyClasseId:id},
          success: function(result){
          //alert(result);
          $("#Gestione").load("view/amministrazioneCreaClasse.php");
          }
        });
      });
    });
    </script>
  <div></div>
  <div clas="contenitore">
    <h4>Creazione Classe</h4>
    <div class="form-group col-xs-12">
      <label class="col-xs-3 control-label">Crea Classe:</label>
      <form method="post">
        <div class="col-xs-9">
          <div class="input-group">
            <span class="input-group-btn">
              <button style="height:34px" id="buttonAdd"  class="btn glyphicon glyphicon-plus" type="submit" onclick="return false"></button>
            </span>
            <input  style="margin-top: 0.0625em" type="text" class="form-control" name="addClasse" id="addClasse" placeholder="clicca il + per salvare"></input>
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
        <tr><th>nome della classe</th><th>modifica</th><th>elimina</th></th>
        <?php
        $query="select cla_nome AS 'nome',cla_id from classe order by cla_nome";
        $result = $newDB->query($query);
        while($row = $result->fetch_assoc()){
          ?>
          <tr>
            <td class="col-xs-8"><input type="text" class="form-control" id="<?php echo $row['cla_id'];?>" value="<?php echo $row['nome'];?>"></input></td>
            <td class="col-xs-2">
              <button type="button" name='button' id="" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModalM" onclick="document.getElementById('modifyClasse').value='<?php echo $row['cla_id'];?>';">
                <span class="glyphicon glyphicon-ok"></span>
              </button>
            </td>
            <td class="col-xs-2">
              <button type="button" name='button' id="" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" onclick="document.getElementById('removeClasse').value='<?php echo $row['cla_id'];?>';">
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
                <strong>Attenzione!</strong> Se la classe è stata inserita in una pianificazione non sarà possibile eliminarla
              </div>
            </div>
            <div class="modal-footer">
              <form method="post" action="">
                <button type="submit" onclick="return false" class="btn btn-default" id="buttonRemove">ok</button>
                <input type="hidden" id="removeClasse" name="removeClasse" required="required"/>
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
                <input type="hidden" id="modifyClasse" name="modifyClasse" required="required"/>
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
