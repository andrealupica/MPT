<?php

/*
 * Questo file contiene la lista di funzioni di utilità 
 * utilizzate nel sistema 
 */

// Questa funzione permette di stampare una lista
// HTML di $formErrors
function showFormErrors($formErrors)
{
	return '<ul><li>'.implode('</li><li>', $formErrors).'</li></ul>';
}

// Questa funzione si occupa di controllare se un indirizzo
// email è stato scritto correttamente
function emailIsValid($email)
{
	if (false == preg_match('/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/', $email))
	{
		return false;
	}
	else
	{
		return true;
	}
}

// Questa funzione si occupa di controllare se un token
// è scritto correttamente
function tokenIsValid($token)
{
	// Un token deve essere composto solamente da numeri e lettere
	// ed avere una lunghezza di 32 caratteri
	if (false == preg_match('/^([a-z0-9]){32}$/', $token))
	{
		return false;
	}
	else
	{
		return true;
	}
}