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
			<script>
				// funzione che viene eseguita quando si cambia il corso
				$(document).ready(function(){
					cnt=0; // variabile per contare i select in modal aggiungi
					i=1; // variabile per univocare i select in modal aggiungi
					iM=0;// variabile per contare i select in modal modifica
					cntM=-1; // variabile per univocare i select in modal modifica

						// settaggio del titolo da barra a modal quando viene cliccato il tasto +
						$("#buttonAdd").click(function(){
							i=1;
							valore=$("#addTitolo").val();
							$("#addModalTitolo").val(valore);
						});
						$("#buttonSave").click(function(){
							tito=$("#addModalTitolo").val();
							valu=$("#valutazioneM").val();
							desc=$("#descrizioneM").val();
							id=0;
							materia="";
							materia +=$("#materiaM1").val();
							if($("#materiaM2").val()!=undefined){
								materia+="/"+$("#materiaM2").val();
							}
							if($("#materiaM3").val()!=undefined){
								materia+="/"+$("#materiaM3").val();
							}
							$.ajax({
								type:"POST",
								url: "model/proposte2.php",
								data:{materia:materia,valu:valu,desc:desc,tito:tito,id:id},
								success: function(result){
									alert(result+"c");
									location.reload();
							}});
						});
						// invio dei dati quando si clicca sul	 tasto salva del modal modifica
						$("#buttonModify").click(function(){
							valu=$("#valutazioneM").val();
							desc=$("#descrizioneM").val();
							tito=$("#modifyTitolo").val();
							id=$("#modifyProposte").val();
							materia="";
							materia +=$("#materiaM1").val();
							if($("#materiaM2").val()!=undefined){
								materia+="/"+$("#materiaM2").val();
							}
							if($("#materiaM3").val()!=undefined){
								materia+="/"+$("#materiaM3").val();
							}
							//alert(materia);
							$.ajax({
								type:"POST",
								url: "model/proposte2.php",
								data:{materia:materia,valu:valu,desc:desc,tito:tito,id:id},
								success: function(result){
									//$('#ciclo2').val(result);
									// result=JSON.parse(result);
									alert(result);
									location.reload();
							}});
						});
				});
				// chiamata quando viene cliccato un bottone di modifica
				function selectID(obj){
					iM=0;
					cntM=-1;
					valore=$(obj).val();
					$.ajax({
						type:"POST",
						url: "model/proposte2.php",
						data:{idTitolo:valore},
						success: function(result){
							//$('#ciclo2').val(result);
							result=JSON.parse(result);
							//alert(result);
							$("#modifyTitolo").val(result[0]);
							$("#descrizioneM").val(result[1]);
							$("#valutazioneM").val(result[2]);
					}});
					$.ajax({
						type:"POST",
						url: "model/proposte2.php",
						data:{select:"ok"},
						success: function(result2){ // ritorna in una variabile tutti le materie disponibili
							//alert("materie:"+result2);
							result2=JSON.parse(result2);
							//alert(result2);
							$.ajax({
								type:"POST",
								url: "model/proposte2.php",
								data:{idMat:valore},
								success: function(result){
									result=JSON.parse(result); // materie separate presenti in propone
									$("#selectMod").empty();
									for(numero=0;numero<result.length;numero++){
										cntM++;
										//alert("prima"+numero);
										$.ajax({
											type:"POST",
											url: "model/proposte2.php",
											data:{mat:result[numero]},
											success: function(result1){ // ritorna i valori del selezionato 1 sel 0 non selezionato
												result1=JSON.parse(result1);
												iM++;

												//alert("dopo"+numero);
												var sel = document.createElement('select');
												sel.className = "form-control";
												sel.name = "materiaM"+iM;
												sel.id = "materiaM"+iM;
												sel.style ="margin-bottom:10px";
												sel.innerHTML ="<option value='-- seleziona --'>-- seleziona --</option>";
												for(j=0;j<result1.length;j++){
													//alert(result1[j]);
													if(result1[j]==1){
														sel.innerHTML +="<option selected value='"+result2[j]+"'>"+result2[j]+"</option>";
													}
													else{
														sel.innerHTML +="<option value='"+result2[j]+"'>"+result2[j]+"</option>";
													}
													document.getElementById("selectMod").appendChild(sel);
												}
										}});
									}
							}});
					}});
				}
				function addMat(){
					if(cnt<2){

						i++;
						var sel = document.createElement('select');
						sel.className = "form-control";
						sel.name = "materia[]";
						sel.id = "materia"+i;
						sel.style ="margin-bottom:10px";
						sel.innerHTML = "<?php $sql = 'select mat_nome,mat_id from materia where mat_flag=1' ; $result = $newDB->query($sql); echo '<option value='."-- seleziona --".'>'.'-- seleziona --'.'</option>'; while ($row = $result->fetch_assoc()) {echo '<option value='.$row['mat_id'].'>'.$row['mat_nome'].'</option>' ;}?>"
						document.getElementById("selectAdd").appendChild(sel);
						cnt++;
					}

				}
				function removeMat(){
					if(cnt>0){
						var del = document.getElementById("selectAdd").lastChild.remove();
						cnt--;
						i--;
					}
				}
				function addMatM(){
					if(cntM<2){
						iM++;
						var sel = document.createElement('select');
						sel.className = "form-control";
						sel.name = "materia[]";
						sel.id = "materiaM"+iM;
						sel.style ="margin-bottom:10px";
						sel.innerHTML = "<?php $sql = 'select mat_nome,mat_id from materia where mat_flag=1' ; $result = $newDB->query($sql); echo '<option value='."-- seleziona --".'>'.'-- seleziona --'.'</option>'; while ($row = $result->fetch_assoc()) {echo '<option value='.$row['mat_nome'].'>'.$row['mat_nome'].'</option>' ;}?>"
						document.getElementById("selectMod").appendChild(sel);
						cntM++;
					}

				}
				function removeMatM(){
					if(cntM>0){
						var del = document.getElementById("selectMod").lastChild.remove();
						cntM--;
						iM--;
					}
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
	      <h1>Proposte </h1>
	      <br>
    <div class="form-group col-xs-12">
      <label class="col-xs-3 control-label">Inserisci un titolo:</label>
        <div class="col-xs-9">
          <div class="input-group">
            <span class="input-group-btn">
              <button style="height:34px" id="buttonAdd" name="buttonAdd" class="btn glyphicon glyphicon-plus" type="submit" data-toggle="modal" data-target="#myModalA"></button>
            </span>
            <input  style="margin-top: 0.0625em" type="text" class="form-control" name="addTitolo" id="addTitolo" placeholder="clicca il + per salvare"></input>
          </div>
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
        <tr><th>Tema</th><th>Materie</th><th>modifica</th><th>elimina</th></th>
        <?php
        $query="select t.tem_titolo AS 'titolo',t.tem_id AS 'id' from propone p,tema t where p.pro_flag=1 AND t.tem_id=p.tem_id group by t.tem_titolo order by t.tem_titolo";
        $result = $newDB->query($query);
        while($row = $result->fetch_assoc()){
          ?>
          <tr id="riga">
            <td class="col-xs-5"><input type="text" readonly="true" class="form-control tema"  value="<?php echo $row['titolo'];?>"></input></td>
						<td class="col-xs-5"><input type="text" readonly="true" class="form-control materia"  value="<?php
						$id=$row['id'];
						$query1="select m.mat_nome as 'nome' from materia m,propone p where p.pro_flag=1 AND m.mat_id=p.mat_id AND p.tem_id=$id";
						//echo $query1.",";
						$result1 = $newDB->query($query1);
						while($row1 = $result1->fetch_assoc()){	echo $row1['nome'].",";}
							?>"
						/>
					</td>
						<td class="col-xs-1">
              <button type="button" name='buttonM' id="buttonM" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModalM" onclick="selectID(this);document.getElementById('modifyProposte').value='<?php echo $row['id'];?>'" value="<?php echo $row['id'] ?>">
                <span class="glyphicon glyphicon-edit"></span>
              </button>
            </td>
            <td class="col-xs-1">
              <button type="button" name='button' id="" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#myModal" onclick="document.getElementById('removeProposte').value='<?php echo $row['id'];?>';">
                <span class="glyphicon glyphicon-remove"></span>
              </button>
            </td>
          </tr>
          <?php } ?>
      </table>
    </div>
		<div class="container">
      <!-- Modal aggiungi -->
      <div class="modal fade" id="myModalA" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Crea proposta</h4>
							<div>Titolo:
								<input type="text" class="form-control" id="addModalTitolo" name="addModalTitolo" value="" placeholder="Inserisci un titolo"/>
							</div>
            </div>
            <div class="modal-body">
							<div>
              	<p>Aggiungi materia:
                	<span class="glyphicon glyphicon-plus-sign" id="piu" onclick="addMat()"></span>
									<span class="glyphicon glyphicon-minus-sign" id="meno" onclick="removeMat()"></span>
								</p>
								<div class="form-group" id="selectAdd">
									<select class="form-control" name="materia[]" id="materia1" style="margin-bottom:10px">
										<option selected="true" value="">-- seleziona --</option>
										<?php
										$materia = "select mat_nome as 'materia' from materia where mat_flag=1;";
										$result = $newDB->query($materia);
										while($row = $result->fetch_assoc()){
											?>
											<option><?php echo $row["materia"]?></option>
											<?php
										}
										?>
									</select>
              	</div>
							</div>
							<div>
								<p>Descrizione:</p>
								<textarea type="text" class="form-control" name="descrizione" id="descrizione" placeholder="Inserisci una descrizione" style="resize: vertical; "></textarea>
							</div>
							<div>
								<p>Valutazione:</p>
								<textarea type="text" class="form-control" name="valutazione" id="valutazione" style="resize: vertical; " placeholder="Inserisci un metodo di valutazione"></textarea>
							</div>
            </div>
            <div class="modal-footer">
              <form method="post" action="">
                <button type="submit" onclick="return false" class="btn btn-success" id="buttonSave">Salva</button>
                <input type="hidden" id="modifyProposte" name="modifyProposte" required="required"/>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
		<div class="container">
			<!-- Modal modifica -->
			<div class="modal fade" id="myModalM" role="dialog">
				<div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Modifica proposta</h4>
							<div>Titolo:
								<input type="text" class="form-control" id="modifyTitolo" name="modifyTitolo" value="" placeholder="Inserisci un titolo"/>
							</div>
						</div>
						<div class="modal-body">
							<div>
								<p>Aggiungi materia:
									<span class="glyphicon glyphicon-plus-sign" id="piu" onclick="addMatM()"></span>
									<span class="glyphicon glyphicon-minus-sign" id="meno" onclick="removeMatM()"></span>
								</p>
								<div class="form-group" id="selectMod">
									<select class="form-control" name="materiaM[]" id="materiaM" style="margin-bottom:10px">
										<option selected="true" value="">-- caricamento --</option>
									</select>
									<select class="form-control" name="materiaM[]" id="materiaM" style="margin-bottom:10px">
										<option selected="true" value="">-- caricamento --</option>
									</select>
									<select class="form-control" name="materiaM[]" id="materiaM" style="margin-bottom:10px">
										<option selected="true" value="">-- caricamento --</option>
									</select>
								</div>
							</div>
							<div>
								<p>Descrizione:</p>
								<textarea type="text" class="form-control" name="descrizioneM" id="descrizioneM" placeholder="Inserisci una descrizione" style="resize: vertical; "></textarea>
							</div>
							<div>
								<p>Valutazione:</p>
								<textarea type="text" class="form-control" name="valutazioneM" id="valutazioneM" style="resize: vertical; " placeholder="Inserisci un metodo di valutazione"></textarea>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" onclick="return false" class="btn btn-success" id="buttonModify">Salva</button>
						</div>
					</div>
				</div>
			</div>
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

  </div>

  <script>
	$("#search").keyup(function() {
		var value = this.value.toLowerCase();
		var words = value.split(' ');
		$("#table").find("tr").each(function(index) {
			var ris =$(this).find(".tema").val()+" "+$(this).find(".materia").val();
			var flag=0;
			// controllo se l'array di parole splittate è contenuto nella riga
			if(index!==0){
				for (i = 0; i < words.length; i++) {
					if(ris.indexOf(words[i])!=-1){
					}
					else{
						flag=1;
					}
				}
				if(flag==0){
					$(this).show();
				}
				else{
					$(this).hide();
				}
				flag=0;
			}
		});
	});
  </script>
</body>
<?php } ?>
