<?php 

// Includo la lista delle funzioni per operare sul database
require_once 'inc/database.php';

// Apro una connessione con il database
$connection = openConnection();

// Query per la creazione del database
$sql = "CREATE DATABASE `login_guide` CHARACTER SET utf8 COLLATE utf8_unicode_ci";

// Se la creazione del database non riesce, stampo l'errore
if (false == mysql_query($sql, $connection))
{
	die("Si &egrave; verificato un errore durante la creazione del database");
}

// Query per la creazione della tabella user
$sql = "CREATE TABLE `login_guide`.`user` (
	`user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
	`password` char(32) COLLATE utf8_unicode_ci NOT NULL,
	`name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
	`token` char(32) COLLATE utf8_unicode_ci DEFAULT NULL,
	`active` int(1) NOT NULL DEFAULT '0',
	PRIMARY KEY (`user_id`),
	UNIQUE KEY (`email`),
	KEY `token` (`token`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

// Se la creazione della tabella genera un errore, lo stampo a video
if (false == mysql_query($sql, $connection))
{
	die("Si &egrave; verificato un errore durante la creazione della tabella user");
}

echo "Installazione database avvenuta correttamente.";