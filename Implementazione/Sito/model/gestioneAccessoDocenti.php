<?php
	### pagina per la gestione degli utenti
	  include_once "connection.php";

    // se si vuole eliminare l'email
    if(isset($_POST["emailCancellata"]) AND isset($_SESSION['email'])){
      $email1 = $_POST['emailCancellata'];
      $query ="update utente set ute_flag=0 where ute_email='".$email1."';";
      if($newDB->query($query)!=false){
				// creazione del log
				$newDB->createLog($_SESSION['email'],"eliminazione","eliminazione dell email: ".$email1);
				echo "<script> location.href='gestioneAccessoDocenti.php'</script>";
        echo  "<script>document.getElementById('messaggio').innerHTML='email cancellata con successo'</script>";
      }
    }
		// se si vuole gestire i docenti
		if(isset($_POST['docente']) OR isset($_POST['responsabile']) OR isset($_POST['gestore'])  AND isset($_SESSION['email'])){
	    $queryEmail = "select ute_email as 'email' from utente";
	    if($newDB->query($queryEmail)!=false){
	      $result = $newDB->query($queryEmail);
				$docente = $_POST['docente'];
				$responsabile = $_POST['responsabile'];
				$gestore = $_POST['gestore'];
	      while($email = $result->fetch_assoc()){
					//controllo se è docente ovvero se l'email è stata inviata come post del checkbox
					// docente, se è così vuol dire che è stato settato e quindi imposto la variabile a 1
					$isdocente='0';
					$isresponsabile='0';
					$isgestore='0';
					for ($i=0; $i < count($docente) ; $i++) {
						if($email['email']==$docente[$i]){
							$isdocente='1';
						}
						else{
						}
					}
					//controllo se è responsabile nello stesso modo del docente
					for ($i=0; $i < count($responsabile) ; $i++) {
						if($email['email']==$responsabile[$i]){
							$isresponsabile='1';
						}
						else{
						}
					}
					//controllo se è gestore nello stesso del docente
					for ($i=0; $i < count($gestore) ; $i++) {
						if($email['email']==$gestore[$i]){
							$isgestore='1';
						}
						else{
						}
					}
					// creazione della query ed esecuzione
	        $queryModify = "update utente set ute_docente='".$isdocente."', ute_responsabile='".$isresponsabile."', ute_gestoreEmail='".$isgestore."' where ute_email='".$email['email']."';";
					if($newDB->query($queryModify)!=false){
						// creazione del log
						$newDB->createLog($_SESSION['email'],"informazione","modifica permessi dell email: ".$email['email']);
					}
	      }
	    }
			// ricarico la pagina
			echo "<script> location.href='gestioneAccessoDocenti.php'</script>";
	}
?>
