<?php

// includo il file con la lista delle funzioni di utilità
require_once 'inc/utils.php';

// Qui inseriremo gli errori avvenuti durante la validazione
// dei dati inseriti dall'utente nel form di login
$formErrors = array();

// Questi sono i dati inviati dall'utente
$userName			= $_POST['user-name'];
$userEmail 			= $_POST['user-email'];
$userEmailRepeat 	= $_POST['user-email-repeat'];
$userPassword 		= $_POST['user-password'];
$userPasswordRepeat = $_POST['user-password-repeat'];

/* Controllo sull'indirizzo email
 * 
 * Se la lunghezza è 0 allora il campo è vuoto
 * altrimenti controllo che l'indirizzo email sia valido
 * altrimenti controllo che l'indirizzo email sia uguale
 * all'indirizzo email ripetuto
 */
if (strlen($userEmail) == 0)
{
	$formErrors[] = 'Il campo email &egrave; obbligatorio.';
}
else if (false == emailIsValid($userEmail))
{
	$formErrors[] = "L'indirizzo email inserito non &egrave; corretto";
}
else if ($userEmail != $userEmailRepeat)
{
	$formErrors[] = "L'indirizzo email e l'indirizzo ripeti email non sono uguali";
}
	
/* Controllo sulla password inserita
 * 
 * Se la lunghezza è 0 allora il campo è vuoto 
 * altrimenti controllo che la password abbia una lunghezza di almeno 6 caratteri
 * altrimenti controllo che il campo password ed il campo ripeti password siano uguali
 */
if (strlen($userPassword) == 0)
{
	$formErrors[] = 'Il campo password &egrave; obbligatorio';
}
else if (strlen($userPassword) < 6)
{
	$formErrors[] = 'La password inserita &egrave; troppo corta';
}
else if ($userPassword != $userPasswordRepeat)
{
	$formErrors[] = 'Il campo password ed il campo ripeti password non sono uguali';
}
	
/* Controllo sul campo nome
 *
 * Se la lunghezza è 0 allora il campo è vuoto
 * altrimenti controllo che il campo nome abbia una lunghezza di almeno 3 caratteri
 */
if (strlen($userName) == 0)
{
	$formErrors[] = 'Il campo nome &egrave; obbligatorio';
}
else if (strlen($userName) < 3)
{
	$formErrors[] = 'Il nome inserito &egrave; troppo corto';
}
	
// Se il conteggio degli errori è 0 allora i dati inviati dall'utente
// sono validi, procedo con la registrazione del nuovo utente	
if (count($formErrors) == 0)
{
	// includo ora la lista di funzioni che servono per gestire l'utente
	require_once 'inc/user.php';
	
	// Per prima cosa mi assicuro che l'indirizzo email del nuovo utente
	// non sia già registrato nel database
	if (true == userEmailExists($userEmail))
	{
		$formErrors[] = "L'indirizzo email inserito &egrave; gi&agrave; stato registrato";
	}
	else
	{
		// La password inserita viene ora criptata tramite la funzione md5()
		// criptare la password è un buon modo per alzare il livello di sicurezza
		// del nostro sistema di login	
		$userPassword = md5($userPassword);
		
		// Questo è il codice alfanumerico di 32 caratteri che verrà utilizzato
		// nel link di attivazione account
		$activationToken = md5(time().'_'.$userEmail);
		
		/* Tento di registrare il nuovo utente sul database
		 * 
		 * Se non riesco avverto il nuovo utente che non ho potuto registrarlo
		 * altrimenti gli invio una email contenente un link con cui confermare
		 * la registrazione
		 */
		$userData = array(
			'email'		=> $userEmail, 
			'password' 	=> $userPassword, 
			'name' 		=> $userName,
			'token'		=> $activationToken
		);
		
		$userId = registerNewUser($userData);
		
		if (false == $userId)
		{
			$formErrors[] = 'Si &egrave; verificato un errore durante la registrazione';
		}
		else 
		{
			// Questo è il link di attivazione che serve all'utente per confermare
			// la propria registrazione 
			$activationLink = 'http://'.$_SERVER['HTTP_HOST'];
			$activationLink .= str_replace('register.php', 'confirm.php', $_SERVER['REQUEST_URI']);
			$activationLink .= '?token='.$activationToken;
			
			// Invio la mail in formato HTML
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			
			// Oggetto e testo dell'email da inviare
			$subject 	= 'Attivazione account';
			$emailText 	= "<p>Gentile {$userName}, la tua registrazione &egrave; avvenuta correttamente.</p>"
							. "<p>Per attivare il tuo account, clicca sul link sottostante</p>"
							. "<p><a href=\"{$activationLink}\">Clicca qui per attivare il tuo account</p>";
											
			// Provo ora ad inviare l'email all'indirizzo del nuovo utente
			// Redirigo poi il nuovo utente alla pagina di conferma invio email
			if (false == mail($userEmail, $subject, $emailText, $headers))
			{
				$formErrors[] = "Si &egrave; verificato un errore durante il tentativo di invio dell'email di conferma";
			}
			else
			{ 
				header('Location: confirm_sendmail.php');
			}
		}	
			
	}
	
}

// Stampo a video la lista degli errori, se presenti
echo showFormErrors($formErrors);
