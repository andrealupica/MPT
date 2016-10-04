<?php
	include "connection.php";

	if(isset($_GET["param"]) && isset($_GET["password"])){
		$email = $_GET["param"];
		$password = $_GET["password"];
		$destinatario = $email;
		$oggetto = " registrazione di ".$email. " al sito web";
		$messaggio ="sei stato registrato al sito web www.samtinfo.ch, le tue credenziali sono username: ".$email." password: ".$password. " appena effettuerai l'accesso potrai cambiare la password. Hai solo 3 giorni per effettuare il primo login, dopodiché bisognerà rieffettuare la registrazione";
		$mittente =  'From: "Sito MPT"';
		//$mittente .= " Content-Type: text/html; charset=ISO-8859-1";
		echo $password."<br>";
		echo $mittente;
		echo $destinatario;
		echo $oggetto;
		echo $messaggio;

		$date = time()+ (4 * 24 * 60 * 60);
		$date = date("Y-m-d",$date);

		$query = "insert into utente(ute_dataIscrizione) values('".$date."') where ='".$email."';'";
		if($newDB->query($query)!= false){
			mail($destinatario,$oggetto,$messaggio,$mittente);
			echo "email inviata all'amministratore";
			echo $date;
		}
	}
	else{
		echo "404 not found";
	}

?>
