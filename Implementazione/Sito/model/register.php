<?php
	include_once "connection.php";
	$nome = "";
	$cognome = "";
	$email = "";
	$emailAdmin = "";
	/*
	$pass = "";
	$repass = "";
	&& isset($_POST["password"]) && isset($_POST["repassword"])*/
	if(isset($_POST["nome"]) && isset($_POST["cognome"]) && isset($_POST["email"])){
		$nome = $_POST["nome"];
		$nome = ucfirst(strtolower($nome));
		$cognome = $_POST["cognome"];
		$cognome = ucfirst(strtolower($cognome));
		$email = $_POST["email"];
		$email = strtolower($email);
		if(strstr($email,'@')=='@edu.ti.ch'){
		//	$query = "insert into utente(ute_nome,ute_cognome,ute_email) values ('".$nome."','".$cognome."','".$email."');";
			// inserimento tramite statement
			$connect=$newDB->getConnection();
			$query = $connect->prepare("insert into utente(ute_nome,ute_cognome,ute_email) values (?,?,?);");
			$query->bind_param("sss",$nome,$cognome,$email);
			$query->execute();
			//echo $query;
			//echo $query;
			if($query != false){
				// prende l'email del gestore email
				$query1 = "select ute_email as 'email' from utente where ute_gestoreEmail is not null limit 1;";
				if($newDB->query($query1)!= false  && mysqli_num_rows($newDB->query($query1)) == 1){
					$result = $newDB->query($query1);
					$row = $result->fetch_assoc();
					$destinatario = $row['email'];
				}
				//setta password momentanea
				$password = implode(randomPassword());
				$query2 = "update utente set ute_password='".md5($password)."', ute_temppassword=1 where ute_email='".$email."';";
				if($newDB->query($query2)!= false){
					echo $query2;
					// invio dell'email
					$oggetto = " registrazione di ".$email. "";
					$messaggio ="clicca questo link per accettare la registrazione: http://www.samtinfo.ch/~i13lupand//MPT/confirmRegister.php?param=".$email."&password=".$password."";
					$mittente =  'From: "Registrazione MPT" <prova.prova@edu.ti.ch>';
					//$mittente .= " Content-Type: text/html; charset=ISO-8859-1";
					echo $password."<br>";
					echo $mittente;
					echo $destinatario;
					echo $oggetto;
					echo $messaggio;
					mail($destinatario,$oggetto,$messaggio,$mittente);
					echo "email inviata all'amministratore";
				}
				else{
					echo "error";
					echo $query2;
				}
				//header("Location: index.php");
			}
			else{
				echo  "<script>document.getElementById('errore').innerHTML='Errore durante la registrazione, l\'email potrebbe essere già stata registrata' </script>";
			}
		}
		else{
			echo  "<script>document.getElementById('errore').innerHTML='email non corretta : nome.cognome@edu.ti.ch'</script>";

		}


	}
	function randomPassword() {
	    $alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	    for ($i = 0; $i < 10; $i++) {
	        $n = rand(1, 62);
	        $pass[$i] = $alphabet[$n-1];
	    }
	    return $pass;
	}
//$connection->close();

?>
