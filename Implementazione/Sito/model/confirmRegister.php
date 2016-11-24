<?php
	// pagina per la conferma della registrazione
	include_once "connection.php";

	// se sono stati inviati come get dall'email che il resposanbile ha ricevuto i seguenti parametri
	if(isset($_GET["param"]) && isset($_GET["password"])){
		$email = $_GET["param"];
		$password = $_GET["password"];
		$destinatario = $email;
		$oggetto = " registrazione di ".$email. " al sito web";
		$messaggio ="sei stato registrato al sito web www.samtinfo.ch, le tue credenziali sono username: ".$email." password: ".$password. " appena effettuerai l'accesso potrai cambiare la password. Hai solo 3 giorni per effettuare il primo login, dopodiché bisognerà rieffettuare la registrazione";
		$query3 = "select ute_email as 'email' from utente where ute_gestoreEmail=1 limit 1;";
		$result = $newDB->query($query3);
		$row = $result->fetch_assoc();
		$emailMittente=$row['email'];
		//echo "mittente:".$emailMittente."<br>";
		$mittente = 'From: Responsabile email<'.$emailMittente.'>';
		//$mittente .= " Content-Type: text/html; charset=ISO-8859-1";
		//echo $password."<br>";
		//echo $mittente;
		//echo $destinatario;
		//echo $oggetto;
		//echo $messaggio."<br>";
		// setto la data limite per la conferma
		$date = time()+ (4 * 24 * 60 * 60);
		$date = date("Y-m-d",$date);
		//inserisco la data di iscrizione massima
		//$query = "insert into utente(ute_dataIscrizione) values('".$date."') where ='".$email."';";
		$query = "UPDATE utente SET ute_dataIscrizione='".$date."' where ute_email='".$email."';";

		//echo $query;
		if($newDB->query($query)!= false){
			mail($destinatario,$oggetto,$messaggio,$mittente);
			echo "email inviata all'amministratore";
			//echo $date;
		}
	}
	else{
		echo "404 not found";
	}

?>
