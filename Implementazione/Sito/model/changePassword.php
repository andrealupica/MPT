<?php
	include "connection.php";
	if(isset($_POST["password"]) && isset($_POST["repassword"])){
		$repass = $_POST["repassword"];
		$pass = $_POST["password"];
		if($repass ==$pass){
			$query = "update utente set ute_password='".md5($pass)."', ute_temppassword=null where ute_email='".$_SESSION['email']."';";
			if($newDB->query($query)!= false){
				header("Location: index.php");
			}
			else{
				echo "error";
				echo $newDB->error($query);
				//echo "sess: ".$_SESSION['email'];
			}
		}
		echo  "<script>document.getElementById('errore').innerHTML='le password non sono uguali'</script>";
	}
//$connection->close();

?>