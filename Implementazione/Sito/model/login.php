<?php
	include "connection.php";
	session_start();
	$user = "";
	$pass = "";

	if(isset($_POST["email"]) && isset($_POST["password"])){
		$user = $_POST["email"];
		$user = mb_strtolower($user);
		$pass = $_POST["password"];

		// data di scadenza

      $queryDate = "select ute_dataIscrizione as 'data' from utente where ute_email='$user' && ute_password='" . md5($pass) . "';";
  		if($newDB->query($queryDate) != false && mysqli_num_rows($newDB->query($queryDate)) == 1){

  			$result = $newDB->query($queryDate);
  			$row = $result->fetch_assoc();
  			$data = $row['data'];
  			$today_date = date("Y-m-d");
  			if ($data<$today_date){
  				// non può piu loggarsi
  				$queryDeleteAccount = "delete from utente where ute_email='".$user."';";
  				$newDB->query($queryDeleteAccount);
  				echo  "<script>document.getElementById('errore').innerHTML='l account è stato eliminato poiché non è stato effettuato il login entro il tempo limite'</script>";
  			}
        else{
          echo "strano";
        }
      }
      else{
        //  echo "altro";
          $query = "select ute_email as 'email' from utente where ute_email='$user' && ute_password='" . md5($pass) . "';";
          if($newDB->query($query) != false && mysqli_num_rows($newDB->query($query)) == 1){

            //tipo nella sessione
            $queryTipo =" select ute_tipo as 'tipo' from utente where ute_email='$user';";
            if($newDB->query($queryTipo)!= false && mysqli_num_rows($newDB->query($queryTipo)) == 1){
              $result = $newDB->query($queryTipo);
              $row = $result->fetch_assoc();
              $_SESSION['tipo'] = $row['tipo'];
            }
            // email nella sessione
            $queryEmail =" select ute_email as 'email' from utente where ute_email='$user';";
            if($newDB->query($queryEmail)!= false && mysqli_num_rows($newDB->query($queryEmail)) == 1){
              $result = $newDB->query($queryEmail);
              $row = $result->fetch_assoc();
              $_SESSION['email'] = $row['email'];
              echo $_SESSION['email'];
            }
            // location a pagina menu o cambia password
            $queryPasswordTemp = "select ute_temppassword as 'tpassword' from utente where ute_email='$user'";
            if($newDB->query($queryPasswordTemp)!= false && mysqli_num_rows($newDB->query($queryPasswordTemp)) == 1){
              $result = $newDB->query($queryPasswordTemp);
              $row = $result->fetch_assoc();
              echo $queryPasswordTemp;
              echo $row['tpassword'];
              if($row['tpassword']==null){
                header("Location: menu.php");
              }
              else{
                header("Location: changePassword.php");
              }
            }
            else{
              echo "error";
            }

          }
          else{
            echo  "<script>document.getElementById('errore').innerHTML='email o password non sono corrette'</script>";
          }
        }
      }

    // controlla se utente esiste

//$connection->close();

?>
