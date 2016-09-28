<?php 

// Se il parametro token non  stato settato
// regirigo l'utente alla  pagina di login
if (false == isset($_GET['token']))
{
	header('Location: login.php');
}
	
// Includo il modello per la pagina di conferma registrazione
require_once 'models/confirm.php';

// Includo la vista per la pagina di conferma registrazione
require_once 'views/confirm.php';

?>
