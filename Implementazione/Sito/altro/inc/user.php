<?php

/*
 * In questo file sono contenute le funzioni utili
 * alla gestione degli utenti 
 */

// Includo la lista delle funzioni per dialogare con il database
require_once 'database.php';

// Questa funzione si occupa di autenticare un utente 
// nel sistema
function authenticateUser($userEmail, $userPassword)
{
	// Apro una connessione con il database
	$connection = getConnection();
	
	// Cerco nel database un utente attivo
	// con la coppia email:password specificata
	$sql = "SELECT user_id
			FROM user 
			WHERE 
				email = '%s' 
			AND 
				password = '%s'
			AND
				active = 1";

	// Assegno alla query i parametri da cercare
	$sql = sprintf($sql, $userEmail, $userPassword);
	
	// Eseguo la query sul database
	$result = mysqli_query($connection, $sql);
	
	// Se si è verificato un errore oppure non ho trovato nessun risultato
	if (false == $result || mysqli_num_rows($result) == 0)
		return false;
	
	// Questa riga contiene le informazioni dell'utente, se trovato nel database	
	$row = mysqli_fetch_assoc($result);

	// Ritorno lo user_id dell'utente
	return $row['user_id'];	
}

// Questa funzione permette di registrare un nuovo utente nel sistema
function registerNewUser($userData)
{
	// Apro una connessione con il database
	$connection = getConnection();

	// Questi sono i dati da inserire nel database
	$userEmail 		= $userData['email'];
	$userPassword 	= $userData['password'];
	$userName		= $userData['name'];
	$token 			= $userData['token'];
	
	// Query per inserire i nuovi dati nel database
	$sql = "INSERT INTO user 
				(email, password, name, token) 
			VALUES 
				('%s', '%s', '%s', '%s') ";
	
	// Assegno alla query i parametri da cercare
	$sql = sprintf($sql, 
				$userEmail, 
				$userPassword, 
				mysqli_real_escape_string($userName),
				$token);
	
	// Provo ad inserire i dati
	if (false == mysqli_query($connection, $sql))
	{
		return false;
	}
	// se sono riuscito ad inserire i dati,
	// ritorno l'ultimo user_id inserito	
	else
	{
		return mysqli_insert_id($connection);
	}
}

// Questa funzione controlla l'esistenza
// nel database di un utente con uno specifico indirizzo email
function userEmailExists($userEmail)
{
	// Apro una connessione con il database
	$connection = getConnection();
	
	// Conto il numero di utenti registrati con 
	// l'indirizzo email specificato
	$sql = "SELECT user_id
			FROM user 
			WHERE 
				email = '%s' ";
	
	// Assegno alla query i parametri da cercare
	$sql = sprintf($sql, $userEmail);
	
	// Eseguo la query sul database
	$result = mysqli_query($connection, $sql);
	
	// Se non ho trovato utenti oppure se si è
	// verificato un errore
	if (false == $result || mysqli_num_rows($result) == 0)
	{
		return false;
	}
	// Altrimenti vuol dire che ho trovato un utente
	// con l'indirizzo email specificato
	else
	{	 
		return true;
	}
}

// Questa funzione cerca i dati di un utente 
// in base al token specificato
function userFindByToken($token)
{
	// Apro una connessione con il database
	$connection = getConnection();
	
	// Cerco un utente con un certo token
	$sql = "SELECT * 
			FROM user
			WHERE
				token = '%s'";
	
	// Assegno alla query i parametri da cercare
	$sql = sprintf($sql, $token);
	
	// Eseguo la query sul database
	$result = mysqli_query($connection, $sql);
	
	// Se si è verificato un errore oppure non
	// ho trovato nessun utente
	if (false == $result || mysqli_num_rows($result) == 0)
	{
		return false;
	}
	
	// Ritorno i dati dell'utente trovato
	return mysqli_fetch_assoc($result);
}

// Questa funzione cerca i dati di un utente 
// in base all'indirizzo email specificato
function userFindByEmail($userEmail)
{
	// Apro una connessione con il database
	$connection = getConnection();
	
	// Cerco un utente con un certo indirizzo email
	$sql = "SELECT * 
			FROM user 
			WHERE 
				email = '%s'";
	
	// Assegno alla query i parametri da cercare
	$sql = sprintf($sql, $userEmail);
	
	// Eseguo la query sul database
	$result = mysqli_query($connection, $sql);
	
	// Se si è verificato un errore oppure non
	// ho trovato nessun utente
	if (false == $result || mysqli_num_rows($result) == 0)
	{
		return false;
	}
	
	// Ritorno i dati dell'utente trovato
	return mysqli_fetch_assoc($result);
}

// Questa funzione cerca i dati di un utente 
// in base ad un userId specificato
function userFindById($userId)
{	
	// Apro una connessione con il database
	$connection = getConnection();
	
	// Cerco un utente con un certo userId
	$sql = "SELECT * 
			FROM user 
			WHERE 
				user_id = %d";
	
	// Assegno alla query i parametri da cercare
	$sql = sprintf($sql, $userId);
	
	// Eseguo la query sul database
	$result = mysqli_query($connection, $sql);
	
	// Se si è verificato un errore oppure non
	// ho trovato nessun utente
	if (false == $result || mysqli_num_rows($result) == 0)
	{
		return false;
	}
	
	// Ritorno i dati dell'utente trovato
	return mysqli_fetch_assoc($result);
}

// Questa funzione serve per attivare l'account 
// di un utente con un certo userId
function userActivate($userId)
{
	// Apro una connessione con il database
	$connection = getConnection();
	
	// Attivo l'utente impostando il campo
	// active a 1
	$sql = "UPDATE user 
			SET active = 1, token = NULL
			WHERE
				user_id = %d";
	
	// Assegno alla query i parametri da cercare
	$sql = sprintf($sql, $userId);
	
	// Eseguo la query sul database
	$result = mysqli_query($connection, $sql);
	
	// Se si è verificato un errore oppure nessun utente
	// � stato attivato
	if (false == $result || mysqli_affected_rows($connection) == 0)
	{
		return false;
	}
	// Altrimenti l'utente � stato attivato
	else
	{ 	
		return true;
	}	
}

// Questa funzione permette di settare il token
// di uno specifico utente, identificato dal suo userId
function userSetToken($token, $userId)
{
	// Apro la connessione al database
	$connection = getConnection();
	
	// Questa è la query di aggornamento
	$sql = "UPDATE user 
			SET token = '%s'
			WHERE user_id = %d";
	
	// Assegno alla query i parametri da cercare
	$sql = sprintf($sql, $token, $userId);
	
	// Eseguo la query
	$result = mysqli_query($connection, $sql);
	
	// Se si è verificato un errore oppure nessun token � stato settato
	// ritorno false
	if (false == $result || mysqli_affected_rows($connection) == 0)
	{
		return false;
	}
	// altrimenti ritorno true
	else
	{
		return true;
	}
}