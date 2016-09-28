<?php

/*
 * In questo file sono contenute le funzioni utili
 * alla gestione delle sessioni
 */

// Questa funzion fa partire la sessione
function sessionStart()
{
	// session_start()  una funzione nativa di PHP
	session_start();
}

// Questa funzione controlla se l'utente  loggato
function sessionUserIsLogged()
{
	// L'utente risulta loggato se nei dati della sessione 
	// risulta login = true
	if (array_key_exists('login', $_SESSION) && $_SESSION['login'] == true)
	{
		return true;
	}
	else
	{
		return false;
	}
}

// Questa funzione aggiunge informazioni alla sessione
function sessionAddInformation($informationKey, $informationValue)
{
	$_SESSION[$informationKey] = $informationValue;
}

// Questa funzione serve per ottenere informazioni dalla sessione
function sessionGetInformation($informationKey)
{
	return $_SESSION[$informationKey];
}

// Questa funzione distrugge la sessione,  usata per 
// effettuare il logout di un utente
function sessionDestroy()
{
	// session_destroy()  una funzione nativa di PHP
	session_destroy();
}