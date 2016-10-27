<?php
	include_once "connection.php";
	session_start();
  //echo "a";
  echo $_POST["ore"];
	if(isset($_POST["ore"])){
    //echo "in";
    $ore=$_POST["ore"];
    $classe=$_POST["classe"];
    $materia=$_POST["materia"];
    $corso=$_POST["corso"];
    $inizio=$_POST["ciclo1"];
    $email=$_SESSION["email"];
    //echo count($email);
    for ($i=0; $i < count($materia); $i++) {
        /*echo "<br>".$i;
        echo "<br>email:".$email;
        echo "<br>classe:".$classe[$i];
        echo "<br>materia:".$materia[$i];
        echo "<br>corso:".$corso[$i];
        echo "<br>inizio:".$inizio[$i];
        echo "<br>ore:".$ore[$i];*/
        //prendo l'id della classe
        $query="select cla_id as 'id' from classe where cla_nome='".$classe[$i]."'";
        $result = $newDB->query($query);
        $row = $result->fetch_assoc();
        $idClasse = $row['id'];
        //prendo l'id della materia
        $query="select mat_id as 'id' from materia where mat_nome='".$materia[$i]."'";
        //echo $query;
        $result = $newDB->query($query);
        $row = $result->fetch_assoc();
        $idMateria = $row['id'];
        //prendo l'id della corso
        $query="select cor_id as 'id' from corso where cor_nome='".$corso[$i]."'";
        //echo "<br>".$query;
        $result = $newDB->query($query);
        $row = $result->fetch_assoc();
        $idCorso = $row['id'];
        $nOre=$ore[$i];
				$inizio[$i]=substr($inizio[$i],0,4);
				echo $inizio[$i];
        //echo "<br>update pianifica set pia_ore_AIT=? where ute_email='$email' AND pia_ini_anno='$inizio[$i]' AND mat_id=$idMateria AND cla_id=$idClasse AND cor_id=$idCorso;";
        $query = $newDB->getConnection()->prepare("update pianifica set pia_ore_AIT=? where ute_email='$email' AND pia_ini_anno=$inizio[$i] AND mat_id=$idMateria AND cla_id=$idClasse AND cor_id=$idCorso;");
        $query->bind_param("i",$nOre);
        //echo "<br> $i;insert into pianifica(ute_email,cla_id,mat_id,cor_id,pia_ini_anno,pia_fin_anno,pia_ore_tot) values($email,$idClasse,$idMateria,$idCorso,$inizioAnno,$fineAnno,$ore[$i])<br>";$

        if($query->execute()!=false){
            header('refresh:0');
            echo  "<script>document.getElementById('messaggio').innerHTML='salvataggio riuscito!'</script>";
        }
        else{
            echo  "<script>document.getElementById('messaggio').innerHTML='errore durante il salvataggio dei dati'</script>";
        }
    }

    //$query->bind_param("i",$ore[$i]);
	}

//$connection->close();

?>
