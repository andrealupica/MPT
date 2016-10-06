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

    $queryEmail = "select ute_email as 'email' from utente";
    if($newDB->query($queryEmail)!=false){
      $result = $newDB->query($queryEmail);
      $cnt=0;
      while($email = $result->fetch_assoc()){

        $docente = $_POST['docente'];
        echo "prova".$docente[0];
        $responsabile = $_POST[$email['email'].'2'];
        $isdocente = isset($docente)?'1':null;
        $isresponsabile = isset($responsabile)?'1':null;
        $gestore = $_POST['gestore'];
        $queryModify = "update from utente ute_docente='".$isdocente."' & ute_responsabile='".$isresponsabile."'& ute_gestoreEmail='".$gestore."' where ute_email='".$email['email']."';";
        echo $queryModify;
        echo "docente:".$docente;
        echo "responsabile:".$responsabile."<br>";
      }


    }


?>
