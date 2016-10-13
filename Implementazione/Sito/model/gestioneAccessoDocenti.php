<?php
	  include_once "connection.php";
    echo $_POST["email"];
    //cancellazione email
    if(isset($_POST["emailCancellata"])){
      $email1 = $_POST['email'];
      $query ="delete from utente where ute_email='".$email1."';";
      echo $query;
      if($newDB->query($query)!=false){
        echo  "<script>document.getElementById('messaggio').innerHTML='email cancellata con successo'</script>";
        header("Location: gestioneAccessoDocenti.php");
      }
    }

	if(isset($_POST['docente']) && isset($_POST['responsabile'])){
	    $queryEmail = "select ute_email as 'email' from utente";
	    if($newDB->query($queryEmail)!=false){
	      $result = $newDB->query($queryEmail);
				$docente = $_POST['docente'];
				$responsabile = $_POST['responsabile'];
				$gestore = $_POST['gestore'];
	      while($email = $result->fetch_assoc()){
					//controllo se è docente
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
					//controllo se è responsabile
					for ($i=0; $i < count($responsabile) ; $i++) {
						if($email['email']==$responsabile[$i]){
							$isresponsabile='1';
						}
						else{
						}
					}
					//controllo se è gestore
					for ($i=0; $i < count($gestore) ; $i++) {
						if($email['email']==$gestore[$i]){
							$isgestore='1';
						}
						else{
						}
					}
	        $queryModify = "update utente set ute_docente='".$isdocente."', ute_responsabile='".$isresponsabile."', ute_gestoreEmail='".$isgestore."' where ute_email='".$email['email']."';";
	        //echo $queryModify."<br>";
					$newDB->query($queryModify);
					//$cnt++;
	      }
	    }
			header('refresh:0');
	}


?>
