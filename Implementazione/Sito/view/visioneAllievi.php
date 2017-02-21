<!-- pagina per la pianificazione dei docenti-->
<?php
session_start();
if(($_SESSION['email']!="" OR $_SESSION['email']!=null) AND ($_SESSION["amministratore"]==1)){ // da riguardare
  include_once "connection.php";

  if(isset($_POST['allievi']) AND !empty($_POST["allievi"])){
    $allievi=explode("+",$_POST["allievi"]);
    $idCorso=$allievi[0];
    $idClasse=$allievi[1];
  //  echo $idCorso."/".$idClasse;
    if(is_numeric($idClasse) AND is_numeric($idCorso)){
      try{
        $allievi = $newDB->getConnection()->prepare("SELECT all_nome AS 'nome',all_birthday AS 'born', all_info AS 'info' from allievo where cor_id=? AND cla_id=? AND all_flag=1");
        $allievi->bind_param("ii", $idCorso,$idClasse);
        $allievi->execute();

        //echo "<br>".$allievi->fullQuery;
      //  echo "<br>prepared:".$allievi->num_rows;
        $allievi->close();
        $sql= "SELECT all_nome AS 'nome',all_birthday AS 'born', all_info AS 'info' from allievo where cor_id=".$idCorso." AND cla_id=".$idClasse." AND all_flag=1";
        $result=$newDB->query($sql);

        $corso1= "SELECT cor_nome AS 'corso' FROM corso where cor_id=".$idCorso;
        $result1=$newDB->query($corso1);
        while($row = $result1->fetch_assoc()){
          $nomeCorso=$row['corso'];
        }
        $classe1= "SELECT cla_nome AS 'classe' FROM classe where cla_id=".$idClasse;
        $result2=$newDB->query($classe1);
        while($row = $result2->fetch_assoc()){
          $nomeClasse=$row['classe'];
        }
        //echo "<br>".$sql;
        //echo "<br>mysqli:".mysqli_num_rows($newDB->query($sql));
        //$result = $stmt->get_result(); //$result is of type mysqli_result
        //$num_rows = $result->num_rows;
        ?>
        <html lang="it">
        <head>
          <meta charset="utf-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <title>Pagina di visione classi</title>
          <script src="script.js"></script>
          <script src="bootstrap/js/bootstrap.min.js"></script>
          <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
          <link href="css/amministrazione.css" rel="stylesheet">
          <!-- script per la visualizzazione delle pagine -->
          <script>
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
                  <span class="glyphicon glyphicon-log-out butoon"></span> exit
                </a>
                <a href="javascript:history.go(-1)" class="btn btn-primary">
                  <span class=" glyphicon glyphicon-arrow-left button"></span> indietro
                </a>
              </span>
            </div>
            <?php
            echo "<h1>Classe ".$nomeCorso." ".$nomeClasse."</h1>";

            ?>

            <br>
            <div class="form-group col-xs-12">
              <label class="col-xs-3 control-label">Ricerca:</label>
              <div class="col-xs-9">
                <div class="input-group">
                  <span class="input-group-addon glyphicon glyphicon-search"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                  <input type="text" class="form-control" id="search"></input>
                </div>
              </div>
            </div>
            <table id="table" class="table col-xs-12">
              <tr><th class="col-xs-4">Allievo</th><th class="col-xs-3">Data di nascita</th><th class="col-xs-3">Altre info</th></tr>
              <?php
            //while($row=$allievi->fetch()){
            while($row = $result->fetch_assoc()){
                ?>
                <tr id="riga">
                  <td class="col-xs-3"><input type="text" class="form-control "  readonly="true" id="<?php echo 'nome'.$row['nome'];?>" value="<?php echo $row['nome'];?>"></input></td>
                  <td class="col-xs-2"><input type="date" class="form-control "  readonly="true" id="<?php echo 'nascita'.$row['born'];?>" value="<?php echo $row['born'] ?>"/></td>
                  <td class="col-xs-5"><input type="text" class="form-control "  readonly="true" id="<?php echo 'info'.$row['info'];?>" value="<?php echo $row['info'] ?>"/></td>
                </tr>
                <?php } ?>
              </table>
            </div>
          </body>
          </html>
          <?php
        }
        catch(PDOException $e)
        {
          echo  "<script>document.getElementById('errore').innerHTML='errore'</script>";
        }
      }
      else{
        echo "<script>javascript:history.go(-1)</script>";
      }
    }
    else{
      echo "<script>javascript:history.go(-1)</script>";
    }
  }
  else{
    echo "non hai i permessi per visualizzare questa pagina";
  }
  ?>
