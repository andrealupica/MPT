<h1>Pagina profilo di <?php echo $userName; ?></h1>
<ul>
	<li><strong>ID Utente: </strong><?php echo $userId; ?></li>
	<li><strong>Indirizzo email: </strong><?php echo $userEmail; ?></li>
	<li><strong>Nome: </strong><?php echo $userName; ?></li>
</ul>
<a href="logout.php">Esegui il logout</a>
<hr/>
<ul>
	<li><strong>Modello: </strong>models/profile.php</li>
	<li><strong>Vista: </strong>views/profile.php</li>
	<li><strong>Pagina pubblica: </strong>profile.php</li>
</ul>
<hr/>
<p>La pagina Profilo serve per stampare a video le informazioni dell'utente loggato nel sistema.</p>
<p>Le informazioni presenti in questa pagina sono prese direttamente dalla sessione ma
&egrave; possibile includere tutti i dati che volete.</p>
<p>Ogni utente visualizza solamente le informazioni relative al proprio account e non le informazioni
relative ad altri utenti.</p>