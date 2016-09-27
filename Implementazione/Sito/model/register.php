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
				$query1 = "select ute_email from utente where ute_gestoreEmail is not null limit 1;";
				if($newDB->query($query1)!= false  && mysqli_num_rows($newDB->query($query1)) == 1){
					$dum = $newDB->query($query1);
					$destinatario = $newDB->fetch($dum);						
				}
				echo $destinatario;
				//header("Location: index.php");
			}
			else{
				echo  "<script>document.getElementById('errore').innerHTML='Errore durante la registrazione, l\'email potrebbe essere già stata registrata' </script>";
			}
		}
		else{
			echo  "<script>document.getElementById('errore').innerHTML='email non corretta : nome.cognome@edu.ti.ch'</script>";
			//echo strstr($email,'@');
		}

		
	}
//$connection->close();

?>