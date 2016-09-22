<?php

/*
 * Utilizzando la sessione, recupero le
 * informazioni di base dell'utente e,
 * tramite la vista, le stampo a video
 */
$userId		= sessionGetInformation('user_id');
$userEmail 	= sessionGetInformation('email');
$userName 	= sessionGetInformation('name');
