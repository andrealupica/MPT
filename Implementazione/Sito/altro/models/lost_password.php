<?php

// includo il file con la lista delle funzioni di utilitˆ
require_once 'inc/utils.php';
	
// includo ora la lista di funzioni che servono per gestire l'utente
require_once 'inc/user.php';

// Qui inseriremo gli errori avvenuti durante la validazione
// dei dati inseriti dall'utente nel form di login
$formErrors = array();

// Questi sono i dati inviati dall'utente
$userEmail = $_POST['user-email'];

// Controllo sull'indirizzo email
// Se la lunghezza  0 allora il campo  vuoto 
if (strlen($userEmail) == 0)
{
	$formErrors[] = 'Il campo email &egrave; obbligatorio.';
}
// Altrimenti controllo che l'indirizzo email sia valido	
else if (false == emailIsValid($userEmail))
{
	$formErrors[] = "L'indirizzo email inserito non &egrave; corretto";
}
// altrimenti controllo che l'indirizzo email sia
// registrato al servizio
else if (false == userEmailExists($userEmail))
{
	$formErrors[] = "L'indirizzo email specificato non &egrave; registrato al servizio";
}
	
// Se non si sono verificati errori durante la validazione 
if (count($formErrors) == 0)
{
	// Cerco i dati dell'utente in base all'indirizzo email specificato
	$user = userFindByEmail($userEmail);
	
	// Questo token viene inserito come parametro nel link di attivazione
	$token = md5(time().'_'.$user['user_id']);
	
	// Cerco ora di registrare il token che ho generato inserendolo nei
	// dati dell'utente che ha richiesto il recupero della password
	if (false == userSetToken($token, $user['user_id']))
	{
		$errors[] = "Si &egrave; verificato un errore durante il tentativo di recupero password.";
	}
	else
	{
		// Questo  il link di attivazione che serve all'utente per cambiare
		// la propria password 
		$activationLink = 'http://'.$_SERVER['HTTP_HOST'];
		$activationLink .= str_replace('lost_password.php', 'change_password.php', $_SERVER['REQUEST_URI']);;
		$activationLink .= '?token='.$token;
		
		// Invio la mail in formato HTML
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// Oggetto e testo dell'email da inviare
		$subject 	= 'Recupero password';
		$emailText 	= "<p>Gentile {$user['name']},</p>"
						. "<p>per recuperare la tua password, clicca sul link sottostante</p>"
						. "<p><a href=\"{$activationLink}\">Clicca qui per recuperare la password</p>";
										
		// Provo ora ad inviare l'email all'indirizzo email specificato
		// Redirigo poi il nuovo utente alla pagina di conferma invio email
		if (false == mail($userEmail, $subject, $emailText, $headers))
		{
			$formErrors[] = "Si &egrave; verificato un errore durante il tentativo di invio dell'email di conferma";
		}
		else
		{ 
			header('Location: lost_password.php?sendmail=true');
		}
	}
}

// Stampo a video gli errori, se presenti
echo showFormErrors($formErrors);
	





