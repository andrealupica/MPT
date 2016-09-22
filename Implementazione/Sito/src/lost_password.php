<?php 

// Controllo se sono presenti dei dati inviati in POST; 
// se ci sono, il form  stato inviato dall'utente
if (count($_POST) > 0)
{
	// Includo il modello per la pagina di recupero password
	require_once 'models/lost_password.php';
}

// Se  presente il parametro sendmail allora l'email
// con il link di recupero  stata inviata
if (isset($_GET['sendmail']) && $_GET['sendmail'] == true)
{
	require_once 'views/lost_password_sendmail.php';
}
// Altrimenti mostro il form per richiedere il recupero della password
else 
{
	require_once 'views/lost_password.php';
}
	
?>