<?php
	include "connection.php";
	$nome = "";
	$cognome = "";
	$email = "";
	$emailAdmin = "";
	/*
	$pass = "";
	$repass = "";
	&& isset($_POST["password"]) && isset($_POST["repassword"])*/
	if(isset($_POST["nome"]) && isset($_POST["cognome"]) && isset($_POST["email"])){
		/*$query1 = "select ute_email from utente where ute_gestoreEmail is not null limit 1;";
		$res = $newDB->query($query1);
		$newDB->fetch($res);
		$emailAdmin = $newDB->fetch($res) ;
		echo $emailAdmin;*/
		$nome = $_POST["nome"];
		$cognome = $_POST["cognome"];
		$email = $_POST["email"];
		$email = strtolower($email);/*
		$pass = $_POST["password"];
		$repass = $_POST["repassword"];*/
		if(strstr($email,'@')=='@edu.ti.ch'){
			$query = "insert into utente(ute_nome,ute_cognome,ute_email) values ('".$nome."','".$cognome."','".$email."');";
			//echo $query;
			if($newDB->query($query) != false){
				//sess("db")->stop();
				//	mail();
				$query1 = "select ute_email as 'email' from utente where ute_gestoreEmail is not null limit 1;";
				if($newDB->query($query1)!= false  && mysqli_num_rows($newDB->query($query1)) == 1){
					$dum = $newDB->fetch($newDB->query($query1));
					$destinatario = $dum['email'];						
				}
				//setta password momentanea
				$password = implode(randomPassword());
				$query2 = "update utente set ute_password='".md5($password)."', ute_temppassword=1 where ute_email='".$email."';";
				if($newDB->query($query2)!= false){
					echo $query2;		
					// invio dell'email
					$oggetto = " registrazione di ".$email. "";
					$messaggio ="<html><body>clicca qui sotto per registrare l'utente<br><a href='http://www.samtinfo.ch/~i13lupand//MPT/confirmRegister.php>registra<a/>";
					$tipoMessaggio = "Content-Type: text/html";
					$mittente =  'From: "Registrazione MPT" <prova.prova@edu.ti.ch>'; 
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
	    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
	    for ($i = 0; $i < 10; $i++) {
	        $n = rand(0, count($alphabet)-1);
	        $pass[$i] = $alphabet[$n];
	    }
	    return $pass;
	}
//$connection->close();

?>