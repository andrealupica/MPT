<?php
	include_once "connection.php";
	if(isset($_POST["email"]) && isset($_POST["reemail"])){
		if(!empty($_POST["email"]) && !empty($_POST["reemail"])){
			$reemail = $_POST["reemail"];
			$email = $_POST["email"];
			// se le due email combaciano
			if($reemail == $email){
				$query1 = "select ute_email from utente where ute_email='".$email."';";
				if($newDB->query($query1) != false && mysqli_num_rows($newDB->query($query1)) == 1){
					$pass = implode(randomPassword());
					$query = "update utente set ute_password='".md5($pass)."', ute_temppassword=1 where ute_email='".$email."';";
					echo $query;
					if($newDB->query($query)!= false){
						// creazione dell'email
							$destinatario = $email;
							$oggetto = " modifica della password di: ".$email. "";
							$messaggio ="la tua nuova password è:".$pass;
							$tipoMessaggio = "Content-Type: text/html";
							$mittente =  'From: "sito MPT" <prova.prova@edu.ti.ch>';
							echo $pass."<br>";
							echo $mittente;
							echo $destinatario;
							echo $oggetto;
							echo $messaggio;
							mail($destinatario,$oggetto,$messaggio,$mittente);
						//header("Location: index.php");
					}
					else{
						echo  "<script>document.getElementById('messaggio').innerHTML=errore</script>";
					}
				}
				else{
					echo  "<script>document.getElementById('messaggio').innerHTML=errore, l email potrebbe non essere stata registrata</script>";

				}
			}
			else{
				echo  "<script>document.getElementById('messaggio').innerHTML='le email non combaciano'</script>";
			}
		}
		else{
			echo  "<script>document.getElementById('messaggio').innerHTML='inserisci un email'</script>";
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
