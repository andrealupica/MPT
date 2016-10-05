<?php
	if($_SESSION['email']=="" OR $_SESSION['email']==null){
		echo "non hai i permessi per visualizzare questa pagina";
	}
	else{
		include 'view/menu.php';
		include 'model/menu.php';
	}

?>
