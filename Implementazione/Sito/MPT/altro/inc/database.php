<?php

static $connectionLink = null;

function getConnection()
{
    global $connectionLink;

    if (true == is_null($connectionLink))
    {
        $connectionLink = createConnection();
    }

    return $connectionLink;
}

function createConnection()
{
    $databaseHostName	= 'localhost';
    $databaseUserName 	= 'root';
    $databasePassword 	= 'root';
    $databaseName = 'login_guide';

    $connection = mysqli_connect($databaseHostName, $databaseUserName, $databasePassword, $databaseName);

    if (false == $connection)
    {
        die("Si è verificato un errore durante la connessione al database. Ricontrolla i dati di accesso");
    }

    return $connection;
}