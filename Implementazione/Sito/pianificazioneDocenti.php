<?php
	session_start();
	if($_SESSION['email']=="" OR $_SESSION['email']==null OR $_SESSION["responsabile"]!=1){
		echo "non hai i permessi per visualizzare questa pagina";
		//echo "email: ".$_SESSION['email'];
	}
	else{
		include 'view/pianificazioneDocenti.php';
		include 'model/pianificazioneDocenti.php';
	}

?>
