<?php
  session_start();
  include_once "connection.php";
  	 if(isset($_POST['nomeDocente']) && isset($_POST['cognomeDocente']) && isset($_POST['materia']) && isset($_POST['ore']) && isset($_POST['ciclo']) && isset($_POST['classe']) && isset($_POST['corso']) &&  isset($_POST['ciclo2']) ){
        $nome = $_POST["nomeDocente"];
        $ore = $_POST["ore"];
        $cognome = $_POST["cognomeDocente"];
        $materia = $_POST["materia"];
        $inizioAnno = $_POST["ciclo"];
        $fineAnno = $_POST["ciclo2"];
        $classe = $_POST["classe"];
        $corso = $_POST["corso"];
        /*

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
        echo "materia:".$materia[2]."<br>";*/
        /*  for ($i=0; $i < 1; $i++) {
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
          }*/
    	if(!empty($nome[0]) && !empty($nome[1]) && !empty($cognome[0]) && !empty($cognome[1]) && $materia[0]!="" && $materia[1]!="" && !empty($ore[0]) && !empty($ore[1])  && !empty($_POST['ciclo']) &&  !empty($_POST['ciclo2']) && !empty($_POST['classe']) && !empty($_POST['corso']) ){
        // && !empty($_POST['durataCiclo']) && !empty($_POST['ciclo2'])
        // gestire il tutto, sono array !!!!
        $queryEmailProva="";
        $controllo=0;
        for ($j=0; $j < count($cognome)-1; $j++) {
          if($j==3 && empty($cognome[$j]) && empty($nome[$j])){

          }
          if($j==2 && empty($cognome[$j]) && empty($nome[$j])){

          }
          else{
            $nome[$j]=ucfirst(strtolower($nome[$j]));
            $cognome[$j]=ucfirst(strtolower($cognome[$j]));
            $queryEmailProva ="select ute_email as 'email' from utente where ute_nome='$nome[$j]' && ute_cognome='$cognome[$j]';";
            //echo "<br>".$queryEmailProva;
            if($newDB->query($queryEmailProva)!= false){

            }
            else{
              $controllo=1;
            }
          //  echo $controllo;
          }

          //eseguo la query
        //  echo $queryEmailProva;
        }
        if($controllo==0){
          for ($i=0; $i < count($cognome)-1; $i++) {
            if($i==3 && empty($cognome[$i]) && empty($nome[$i])){

            }
            if($i==2 && empty($cognome[$i]) && empty($nome[$i])){

            }
            else{
              //creo la query
              $nome[$j]=ucfirst(strtolower($nome[$j]));
              $cognome[$j]=ucfirst(strtolower($cognome[$j]));
              $queryEmail ="select ute_email as 'email' from utente where ute_nome='$nome[$i]' && ute_cognome='$cognome[$i]'";
              //eseguo la query

              $ris = $newDB->query($queryEmail);
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
              $idClasse =  $dum['id'];
              $queryPianifica = $newDB->getConnection()->prepare("insert into pianifica(ute_email,cla_id,mat_id,cor_id,pia_ini_anno,pia_fin_anno,pia_ore_tot) values(?,?,?,?,?,?,?)");
              $queryPianifica->bind_param("siiiiii",$email,$idClasse,$idMateria,$idCorso,$inizioAnno,$fineAnno,$ore[$i]);
              //echo "<br> $i;insert into pianifica(ute_email,cla_id,mat_id,cor_id,pia_ini_anno,pia_fin_anno,pia_ore_tot) values($email,$idClasse,$idMateria,$idCorso,$inizioAnno,$fineAnno,$ore[$i])<br>";
              if($queryPianifica->execute()!=false){
                  echo  "<script>document.getElementById('messaggio').innerHTML='pianificazione riuscita!'</script>";
              }
              else{
                  echo  "<script>document.getElementById('messaggio').innerHTML='errore durante il salvataggio dei dati'</script>";
              }
            }
          }
        }
        else{
          echo  "<script>document.getElementById('messaggio').innerHTML='errore, qualche docente non esiste'</script>";
        }

      }
      else{
        	echo  "<script>document.getElementById('messaggio').innerHTML='inserisci tutti i campi in almeno le prime 2 righe e nella riga finale'</script>";
      }
    }
 ?>
