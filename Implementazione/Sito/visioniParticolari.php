<!-- © 2016-2017 Andrea Lupica (I4AC) ALL RIGHTS RESERVED -->
<?php
	session_start();
	if($_SESSION['email']=="" OR $_SESSION['email']==null){
		include '404.php';
	}
	else{
		include 'view/visioniParticolari.php';
	}

?>
