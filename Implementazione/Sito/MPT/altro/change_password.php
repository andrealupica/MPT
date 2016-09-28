<?php 

// Se il parametro token non  stato passato
// alla pagina in GET, redirigo l'utente alla pagina
// di recupero password
if (false == isset($_GET['token']))
{
	header('Location: lost_password.php');
}

// includo il modello per la pagina di cambio password
require_once 'models/change_password.php';

// includo la vista per la pagina di cambio password
require_once 'views/change_password.php';

?>