<?php
	### pagina per la conferma della registrazione
	// inclusione del file per la connessione al DB
	include_once "connection.php";

	// se sono stati inviati come get dall'email che il resposanbile ha ricevuto i seguenti parametri
	if(isset($_GET["param"]) && isset($_GET["password"])){
		$email = $_GET["param"];
		$password = $_GET["password"];
		$destinatario = $email;
		$oggetto = " registrazione di ".$email. " al sito web";
		$messaggio ="sei stato/a registrato al sito web ".$_SERVER["SERVER_NAME"].substr($_SERVER["PHP_SELF"],0,strlen($_SERVER["PHP_SELF"])-20).", le tue credenziali sono username: ".$email." password: ".$password. " appena effettuerai l'accesso potrai cambiare la password. Hai solo 3 giorni per effettuare il primo login, dopodiché bisognerà rieffettuare la registrazione";
		$query3 = "select ute_email as 'email' from utente where ute_gestoreEmail=1 limit 1;";
		$result = $newDB->query($query3);
		$row = $result->fetch_assoc();
		$emailMittente=$row['email'];
		$mittente = 'From: Responsabile email<'.$emailMittente.'>';
		// setto la data limite per la conferma
		$date = time()+(4 * 24 * 60 * 60);
		$date = date("Y-m-d",$date);
		//inserisco la data di iscrizione massima
		$query = "UPDATE utente SET ute_dataIscrizione='".$date."' where ute_email='".$email."';";
		// se la query ha avuto successo allora invia l'email segnalando la conferma della registrazione
		if($newDB->query($query)!= false){
			mail($destinatario,$oggetto,$messaggio,$mittente);
			echo "email inviata al docente";
		}
	}
	else{
		echo "404 not found";
	}
?>
