<?php 

// Questo è il token che identifica la richiesta di un utente
$token  = $_GET['token'];

// Qui inseriamo gli errori 
$errors	= array();

// includo la lista delle funzioni di utilità
require_once 'inc/utils.php';

// Controllo se il token è valido e, se non lo è,
// stampo a video l'errore
if (false == tokenIsValid($token))
{
	$errors[] = 'Il codice specificato non &egrave; valido';
	echo showFormErrors($errors);
	exit();	
}

// Includo la lista delle funzioni per gestire gli utenti
require_once 'inc/user.php';

// Cerco i dati di un utente in base al token
$user = userFindByToken($token);

// Se non ho trovato nessun utente genero un errore
if (false == $user)
{
	$errors[] = 'Nessun utente da attivare con il codice specificato.';
}
// Altrimenti se non sono riuscito ad attivare l'account dell'utente
// genero un errore
else if (false == userActivate($user['user_id']))
{
	$errors[] = 'Si &egrave; verificato un errore durante il tentativo di attivazione account';
}

// Se sono presenti degli errori li stampo a video
if (count($errors) > 0)  
{
	echo showFormErrors($errors);
	exit();	
}

// Questo è il nome dell'utente da visualizzare nella vista
$userName = $user['name'];