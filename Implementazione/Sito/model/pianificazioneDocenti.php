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
      $sem = $_POST["sem"];
      $cnt=-1;
      // se gli input delle prime righe non sono vuoti
    	if(!empty($nome[0]) && !empty($nome[1]) && !empty($cognome[0]) && !empty($cognome[1]) && $materia[0]!="" && $materia[1]!="" && !empty($ore[0]) && !empty($ore[1])  && !empty($_POST['ciclo']) &&  !empty($_POST['ciclo2']) && !empty($_POST['classe']) && !empty($_POST['corso']) ){
        $queryEmail="";
        $controllo=array();
        // check di errori
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
            $queryEmail ="select ute_email as 'email' from utente where ute_nome='".addslashes($nome[$j])."' && ute_cognome='".addslashes($cognome[$j])."';";

            // eseguo la query e se funziona setto la posizione dell'array a 0
            if($newDB->query($queryEmail)!= false && mysqli_num_rows($newDB->query($queryEmail)) == 1){
              $controllo[$j]=0;
              $cnt++;
            }
            // altrimenti se da errore inserisco nella posizione dell'array un 1
            else{
              $controllo[$j]=1;
            }
          }
        }
        // se non ci sono stati errori sul nome del docente o se i dati sono stati riempiti
        if(in_array(1,$controllo)!=true){
          for ($i=0; $i <= $cnt; $i++) {
            //echo "<script>console.log('".count($cognome)."')</script>";
            //echo "<script>console.log('".$i.$cognome[$i].",".$nome[$i]."')</script>";
            if($i==3 && empty($cognome[$i]) && empty($nome[$i])){
              //echo "<script>console.log('4 campo vuoto')</script>";
            }
            if($i==2 && empty($cognome[$i]) && empty($nome[$i])){
              //echo "<script>console.log('3 campo vuoto')</script>";
            }
            else{
              //creo la query
              $nome[$i]=ucfirst(strtolower($nome[$i]));
              $cognome[$i]=ucfirst(strtolower($cognome[$i]));
              $queryEmail ="select ute_email as 'email' from utente where ute_nome='".addslashes($nome[$i])."' && ute_cognome='".addslashes($cognome[$i])."';";
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
              if($oreTotali<0){
                $oreTotali=0;
              }
              $queryIdCorso = "select cor_id as 'id' from corso where cor_nome='$corso'";
              $ris=$newDB->query($queryIdCorso);
              $dum= $ris->fetch_assoc();
              $idCorso =  $dum['id'];

              $queryIdClasse = "select cla_id as 'id' from classe where cla_nome='$classe'";
              $ris=$newDB->query($queryIdClasse);
              $dum= $ris->fetch_assoc();
              $idClasse =  $dum['id'];

              $sem=$_POST["sem"];
              if($sem!="1" OR $sem!="2" OR $sem!="1-2"){
                $sem="1-2";
              }
              echo $sem;
              // eseguo la query di insert
              // echo "<br>insert into pianifica(ute_email,cla_id,mat_id,cor_id,pia_ini_anno,pia_fin_anno,pia_ore_tot) values('$email','$idClasse','$idMateria','$idCorso','$inizioAnno','$fineAnno','$ore[$i]')";
              $queryPianifica = $newDB->getConnection()->prepare("insert into pianifica(ute_email,cla_id,mat_id,cor_id,pia_ini_anno,pia_fin_anno,pia_ore_tot,pia_sem) values(?,?,?,?,?,?,?,?)");
              $queryPianifica->bind_param("siiiiiis",$email,$idClasse,$idMateria,$idCorso,$inizioAnno,$fineAnno,$oreTotali,$sem);
              // se non ci sono problemi nella query mostro un messaggio positivo
              if($queryPianifica->execute()!=false){
                // creazione del log
                $newDB->createLog($_SESSION['email'],"inserimento","creata pianificazione, utente: ".$nome[$i]." ".$cognome[$i].", materia: ".$materia[$i].", ore: ".$oreTotali.", corso: ".$corso." ,classe: ".$classe.", anno: ".$inizioAnno." -- ".$fineAnno.", semestre: ".$sem);
                echo  "<script>document.getElementById('messaggio').innerHTML='pianificazione riuscita!';document.getElementById('messaggio').setAttribute('class','control-label alert alert-success')</script>";
              }
              else{
                // creazione del log
                $newDB->createLog($_SESSION['email'],"attenzione","pianificazione non riuscita, utente: ".$nome[$i]." ".$cognome[$i].", materia: ".$materia[$i].", ore: ".$oreTotali.", corso: ".$corso." ,classe: ".$classe.", anno: ".$inizioAnno." -- ".$fineAnno.", semestre: ".$sem);
                  echo  "<script>document.getElementById('messaggio').innerHTML='errore durante il salvataggio dei dati';document.getElementById('messaggio').setAttribute('class','control-label alert alert-danger')</script>";
              }
            }
          }
        }
        else{
          // creazione del log
          for ($i=0; $i < count($cognome)-1; $i++) {
          $newDB->createLog($_SESSION['email'],"attenzione","pianificazione non riuscita, utente: ".$nome[$i]." ".$cognome[$i].", materia: ".$materia[$i].", ore: ".$ore[$i].", corso: ".$corso." ,classe: ".$classe.", anno: ".$inizioAnno." -- ".$fineAnno.", semestre: ".$sem);
          }
          echo  "<script>document.getElementById('messaggio').innerHTML='errore, qualche docente non esiste o campo ore vuoto';document.getElementById('messaggio').setAttribute('class','control-label alert alert-danger')</script>";
        }

      }
      else{
        	echo  "<script>document.getElementById('messaggio').innerHTML='inserisci tutti i campi in almeno le prime 2 righe e nella riga finale';document.getElementById('messaggio').setAttribute('class','control-label alert alert-warning')</script>";
      }
    }
 ?>
