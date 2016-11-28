<?php
  ### pagina della pianificazione dei docenti
  // start della sessione
  session_start();
  // includiamo la connessione al DB
  include_once "connection.php";
    // se sono stati cliccato il bottone per il post degli input
    if(isset($_POST['nomeDocente']) && isset($_POST['cognomeDocente']) && isset($_POST['materia']) && isset($_POST['ore']) && isset($_POST['ciclo']) && isset($_POST['classe']) && isset($_POST['corso']) &&  isset($_POST['ciclo2']) ){
      $nome = $_POST["nomeDocente"];
      $ore = $_POST["ore"];
      $cognome = $_POST["cognomeDocente"];
      $materia = $_POST["materia"];
      $inizioAnno = $_POST["ciclo"];
      $fineAnno = $_POST["ciclo2"];
      $classe = $_POST["classe"];
      $corso = $_POST["corso"];
      // se gli input delle prime righe non sono vuoti
    	if(!empty($nome[0]) && !empty($nome[1]) && !empty($cognome[0]) && !empty($cognome[1]) && $materia[0]!="" && $materia[1]!="" && !empty($ore[0]) && !empty($ore[1])  && !empty($_POST['ciclo']) &&  !empty($_POST['ciclo2']) && !empty($_POST['classe']) && !empty($_POST['corso']) ){
        $queryEmail="";
        $controllo=0;
        for ($j=0; $j < count($cognome)-1; $j++) {
          // se il 4 campo fosse vuoto allora fa niente
          if($j==3 && empty($cognome[$j]) && empty($nome[$j]) && empty($ore[$j]) ){

          }
          // se il 3 campo fosse vuoto
          if($j==2 && empty($cognome[$j]) && empty($nome[$j]) && empty($ore[$j]) ){

          }
          // controllo se il docente inserito esiste
          else{
            $nome[$j]=ucfirst(strtolower($nome[$j]));
            $cognome[$j]=ucfirst(strtolower($cognome[$j]));
            $queryEmail ="select ute_email as 'email' from utente where ute_nome='$nome[$j]' && ute_cognome='$cognome[$j]';";
            //echo "<br>".$queryEmail;
            if($newDB->query($queryEmail)!= false){

            }
            else{
              $controllo=1;
            }
          //  echo $controllo;
          }
        //  echo $queryEmail;
        }
        // se non ci sono stati errori sul nome del docente o se i dati sono stati riempiti
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
              // se non ci sono problemi nella query mostro un messaggio positivo
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
          echo  "<script>document.getElementById('messaggio').innerHTML='errore, qualche docente non esiste o campo ore vuoto'</script>";
        }

      }
      else{
        	echo  "<script>document.getElementById('messaggio').innerHTML='inserisci tutti i campi in almeno le prime 2 righe e nella riga finale'</script>";
      }
    }
 ?>
