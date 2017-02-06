<!-- pagina per la gestione dei select corsi-classi -->
<?php
  session_start();
  include "../connection.php";
  if(($_SESSION['email']!="" OR $_SESSION['email']!=null) AND ($_SESSION["amministratore"]==1)){
  ?>
  <body>
    <script>
    $(document).ready(function(){
      $("#buttonAdd").click(function(){
        cor=$("#addCorso").val();
        cla=$("#addClasse").val();
        $.ajax({
          type:"POST",
          url: "model/amministrazione.php",
          data:{addCorso:cor,addClasse:cla},
          success: function(result){
          $("#Gestione").load("view/amministrazioneGestioneClaCor.php");
          }
        });
      });

      $("#buttonRemove").click(function(){
        valore=$("#removeCorCla").val();

        //aggiunte queste righe per far funzionare la rimozione della parte nera
        $("#myModal").modal("hide");
        $("body").removeClass("modal-open");
        $(".modal-backdrop").remove();
        $.ajax({
          type:"POST",
          url: "model/amministrazione.php",
          data:{removeGestione:valore},
          success: function(result){
                      //alert(result);
          $("#Gestione").load("view/amministrazioneGestioneClaCor.php");
          }
        });
      });
    });
    </script>
  <div></div>
  <div clas="contenitore">
    <h4>Gestione corso-classe</h4>
    <div class="form-group col-xs-12">
      <label class="col-xs-3 control-label">Crea gestione:</label>
      <form method="post">
        <div class="col-xs-9">
          <div class="input-group">
            <span class="input-group-btn">
              <button style="top:0px;" id="buttonAdd"  class="btn glyphicon glyphicon-plus" type="submit" onclick="return false"></button>
            </span>
            <span class="col-xs-5" style="padding:0px">
              <select name="addCorso" id="addCorso" value='-- corso --' class="form-control">
                <option>-- corso --</option>
                <?php
                $corso = "select cor_nome as 'corso' from corso where cor_flag=1;";
                $result1 = $newDB->query($corso);
                while($row = $result1->fetch_assoc()){
                  ?>
                  <option value='<?php echo $row["corso"]?>'><?php echo $row["corso"]?></option>
                  <?php
                }
                ?>
              </select>
            </span>
            <span class="col-xs-3" style="padding:0px">
              <select name="addClasse" id="addClasse" value='-- classe --' class="form-control">
                <option>-- classe --</option>
                <?php
                $corso = "select cla_nome as 'classe' from classe where cla_flag=1;";
                $result1 = $newDB->query($corso);
                while($row = $result1->fetch_assoc()){
                  ?>
                  <option value='<?php echo $row["classe"]?>'><?php echo $row["classe"]?></option>
                  <?php
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
          <input type="text" class="form-control" id="search"></input>
        </div>
      </div>
    </div>
    <div>
      <table id="table" class="table col-xs-12">
        <tr><th>nome del corso</th><th>nome della classe</th><th>elimina</th></th>
        <?php
        $query="select cl.cla_nome as 'classe',co.cor_nome as 'corso' from cla_fre_cor f,classe cl, corso co where co.cor_id=f.cor_id AND cl.cla_id=f.cla_id && cla_flag=1 && cor_flag=1 order by co.cor_nome,cl.cla_nome ;";
        $result = $newDB->query($query);
        while($row = $result->fetch_assoc()){
          ?>
          <tr>
            <td class="col-xs-6"><?php echo $row["corso"];?></td>
            <td class="col-xs-5"><?php echo $row["classe"];?></td>
            <td class="col-xs-2">
              <button type="button" name='button' id="" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#myModal" onclick="document.getElementById('removeCorCla').value='<?php echo $row['classe']."+".$row['corso'];?>';">
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
              <h4 class="modal-title">Eliminazione gestione</h4>
            </div>
            <div class="modal-body">
              <p>sei sicuro di voler eliminare il collegamento corso-classe?</p>
              <div class="alert alert-info">
                <strong>Info!</strong> L'eliminazione comporterà modifiche nella pagina Pianificazione Docenti
              </div>
            </div>
            <div class="modal-footer">
              <form method="post" action="">
                <button type="submit" onclick="return false" class="btn btn-default" id="buttonRemove">ok</button>
                <input type="hidden" id="removeCorCla" name="removeCorCla" required="required"/>
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
