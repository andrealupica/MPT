<?php
	if($_SESSION['email']=="" OR $_SESSION['email']==null){
		echo "non hai i permessi per visualizzare questa pagina";
	}
	else{
		include 'view/changePassword.php';
		include 'model/changePassword.php';
	}

?>
