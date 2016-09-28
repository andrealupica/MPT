<?php 

// includo le funzioni per gestire le sessioni
require_once 'inc/session.php';

// Faccio partire la sessione
sessionStart();

// Controllo se l'utente  loggato e,
// nel caso NON lo sia, lo rimando alla pagina di login
if (false == sessionUserIsLogged())
{
	header('Location: login.php');
}

// includo il modello per la pagina di logout
require_once 'models/logout.php';

// includo la vista per la pagina di logout
require_once 'views/logout.php';

?>