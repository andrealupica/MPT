<?php

// includo il file con la lista delle funzioni di utilitˆ
require_once 'inc/utils.php';

// Qui inseriremo gli errori avvenuti durante la validazione
// dei dati inseriti dall'utente nel form di login
$formErrors = array();

// Questi sono i dati inviati dall'utente
$userEmail		= $_POST['user-email'];
$userPassword 	= $_POST['user-password'];

/* Controllo sull'indirizzo email
 * 
 * Se la lunghezza  0 allora il campo  vuoto
 * altrimenti controllo che l'indirizzo email sia valido
 */
if (strlen($userEmail) == 0)
{
	$formErrors[] = 'Il campo email &egrave; obbligatorio.'; 
}
else if (false == emailIsValid($userEmail))
{
	$formErrors[] = "L'indirizzo email inserito non &egrave; corretto";
}
		
/* Controllo sulla password inserita
 * 
 * Se la lunghezza  0 allora il campo  vuoto 
 * Altrimenti controllo che la password abbia una lunghezza minima di 6
 */
if (strlen($userPassword) == 0)
{
	$formErrors[] = 'Il campo password &egrave; obbligatorio';
}
else if (strlen($userPassword) < 6) 
{
	$formErrors[] = 'La password inserita &egrave; troppo corta';	
}

// Se $formErrors  vuoto vuol dire che
// tutti i campi compilati dall'utente sono corretti	
if (count($formErrors) == 0)
{
	//La password inserita viene ora criptata tramite la funzione md5()
	// criptare la password  un buon modo per alzare il livello di sicurezza
	// del nostro sistema di login	
	$userPassword = md5($userPassword);
	
	// includo ora la lista di funzioni che servono per gestire l'utente
	require_once 'inc/user.php';
	
	/* Provo ad autenticare l'utente cercando la coppia email:password
	 * nel database.
	 * 
	 * Se riesco ad autenticarlo, lo redirigo alla sua pagina Profilo
	 * inserendo nella sessione le informazioni basilari dell'utente
	 */
	$userId = authenticateUser($userEmail, $userPassword);
	if (false == $userId)
	{
		$formErrors[] = 'La coppia email/password non &egrave; corretta';
	}
	else
	{
		// Recupero le informazioni dell'utente
		$user = userFindById($userId);
		
		// Aggiungo le informazioni dell'utente alla sessione
		// ed imposto il login a true, per identificare 
		// che l'utente si  loggato correttamente
		sessionAddInformation('login', true);
		sessionAddInformation('user_id', $user['user_id']);
		sessionAddInformation('email', $user['email']);
		sessionAddInformation('name', $user['name']);
		
		// Rimando poi l'utente alla pagina del profilo
		header('Location: profile.php');
	}
}

// Stampo a video la lista degli errori, se presenti
echo showFormErrors($formErrors);

