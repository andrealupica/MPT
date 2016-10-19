<?php
  session_start();
  include_once "connection.php";
  	 if(isset($_POST['nomeDocente']) && isset($_POST['cognomeDocente']) && isset($_POST['materia']) && isset($_POST['ore']) && isset($_POST['ciclo']) && isset($_POST['classe']) && isset($_POST['corso']) &&  isset($_POST['ciclo2']) ){
        $nome = $_POST["nomeDocente"];
        $ore = $_POST["ore"];
        $cognome = $_POST["cognomeDocente"];
        $materia = $_POST["materia"];
        $ciclo = $_Post["ciclo"];
        $classe = $_POST["classe"];
        $corso = $_POST["corso"];
        echo "nome:".$nome[0]."<br>";
        echo "nome:".$nome[1]."<br>";
        echo "nome:".$nome[2]."<br>";
        echo "ore:".$ore[0]."<br>";
        echo "ore:".$ore[1]."<br>";
        echo "ore:".$ore[2]."<br>";
        echo "cognome:".$cognome[0]."<br>";
        echo "cognome:".$cognome[1]."<br>";
        echo "cognome:".$cognome[2]."<br>";
        echo "materia:".$materia[0]."<br>";
        echo "materia:".$materia[1]."<br>";
        echo "materia:".$materia[2]."<br>";
          for ($i=0; $i < 1; $i++) {
            $queryIdMateria ="select mat_id as 'id' from materia where mat_nome='$materia[$i]'";
            echo $queryIdMateria."<br>";
            $ris =$newDB->query($queryIdMateria);
            $dum = $ris->fetch_assoc();
            $idMateria = $dum['id'];
            $queryIdCorso = "select cor_id as 'id' from corso where cor_nome='$corso'";
            echo $queryIdCorso."<br>";
            echo $corso."nome corso<br>";
            $ris=$newDB->query($queryIdCorso);
            $dum= $ris->fetch_assoc();
            $idCorso =  $dum['id'];
            echo "id materia: ".$idMateria." id corso:".$idCorso;
          }
    	if(!empty($nome[0]) && !empty($nome[1]) && !empty($nome[2]) && !empty($cognome[0]) && !empty($cognome[1]) && !empty($cognome[2]) && $materia[0]!="" && $materia[1]!="" && $materia[2]!="" && !empty($ore[0]) && !empty($ore[1]) && !empty($ore[2]) && !empty($_POST['ciclo']) &&  !empty($_POST['ciclo2']) && !empty($_POST['classe']) && !empty($_POST['corso']) ){
        // && !empty($_POST['durataCiclo']) && !empty($_POST['ciclo2'])
        // gestire il tutto, sono array !!!!

        for ($i=0; $i < count($cognome); $i++) {
          if($i==4 && empty($cognome[$i]) && empty($nome[$i]) && $materia[$i]!="" && empty($ore[$i]) ){

          }
          else{
            //creo la query
            $queryEmail ="select ute_email as 'email' from utente where ute_nome='$nome[$i]' && ute_cognome='$cognome[$i]'";
            //eseguo la query
            $ris =$newDB->query($queryEmail);
            // fetcho la query
            $dum = $ris->fetch_assoc();
            // prendo il valore
            $email = $dum['email'];
            // creo la query per l'id

            $queryIdMateria ="select mat_id as 'id' from materia where mat_nome='$materia[$i]'";
            $ris =$newDB->query($queryIdMateria);
            $dum = $ris->fetch_assoc();
            $idMateria = $dum['id'];

            $oreTotali = $ore[$i];

            $queryIdCorso = "select cor_id as 'id' from corso where cor_nome='$corso'";
            $ris=$newDB->query($queryIdCorso);
            $dum= $ris->fetch_assoc();
            $idCorso =  $dum['id'];

            $queryIdClasse = "select cla_id as 'id' from classe where cla_nome='$classe'";
            $ris=$newDB->query($queryIdClasse);
            $dum= $ris->fetch_assoc();
            $idNome =  $dum['id'];

            $inizioAnno = $ciclo[$i];
            $fineAnno = $ciclo2[$i];
            $queryPianifica= $newDB->getConnection()->prepare("insert into pianifica(ute_email,cla_id,mat_id,cor_id,pia_ini_anno,pia_fin_anno,pia_ore_tot,pia_ore_AIT) values(?,?,?,?,?,?,?,?)");

          }

        }

        echo "nome:".$nome;



        echo $email;
        echo "salva";

      }
      else{
        	echo  "<script>document.getElementById('messaggio').innerHTML='inserisci tutti i campi in almeno le prime 3 righe'</script>";
      }
    }
 ?>
