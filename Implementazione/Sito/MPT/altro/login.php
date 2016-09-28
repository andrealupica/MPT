<?php 

// includo le funzioni per gestire le sessioni
require_once 'inc/session.php';

// faccio partire la sessione
sessionStart();

// Controllo se l'utente  gia loggato 
// e, nel caso lo sia, lo rimando alla pagina di profilo
if (true == sessionUserIsLogged())
{
	header('Location: profile.php');
}
// Altrimenti controllo se sono presenti dei dati inviati in POST; 
// se ci sono, il form  stato inviato dall'utente
else if (count($_POST) > 0)
{
	// includo il modello per la pagina di login
	require_once 'models/login.php';
}
	
// includo la vista per la pagina di login
require_once 'views/login.php';

