<?php 

// includo le funzioni per gestire le sessioni
require_once 'inc/session.php';

// faccio partire la sessione
sessionStart();

// Controllo se l'utente  loggato e, nel caso 
// non sia loggato, lo rimando alla pagina di login
if (false == sessionUserIsLogged())
{
	header('Location: login.php');
}

// includo il modello per la pagina del profilo
require_once 'models/profile.php';

// includo la vista per la pagina del profilo
require_once 'views/profile.php';

?>