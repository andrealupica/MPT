<style type="text/css">
<!--
form { margin: 20px; padding: 20px; border: 1px solid #ccc; }
form span { display: block; margin-bottom: 10px;}
form span label { display: block; float: left; width: 200px; }
-->
</style>
<h1>Form di login</h1>
<form method="post" action="">
	<span>
		<label for="user-email">Tua email:</label>
		<input type="text" name="user-email" />
	</span>
	<span>
		<label for="user-password">Password:</label>
		<input type="password" name="user-password" />
	</span>
	<span>
		<input type="submit" value="Login" />
	</span>
</form>
<a href="register.php">Registrati</a>&nbsp;&nbsp;
<a href="lost_password.php">Password persa?</a>
<hr/>
<ul>
	<li><strong>Modello: </strong>models/login.php</li>
	<li><strong>Vista: </strong>views/login.php</li>
	<li><strong>Pagina pubblica: </strong>login.php</li>
</ul>
<hr/>
<p>Tramite questo form, l'utente pu&ograve; autenticarsi nel sistema inserendo email e password.</p>
<p>Quando l'utente preme il pulsante Login l'accoppiata email:password viene 
cercata nel database e, se trovata, l'utente &egrave; loggato a sistema; a questo punto l'utente
viene indirizzato ad una pagina di Profilo, che stampa a video i dati dell'utente.</p>
<p>Prima di cercare nel database, l'indirizzo email e la password vengono controllate in modo da
garantire un maggiore livello di sicurezza: &egrave; sempre consigliabile eseguire questi controlli
prima di utilizzare i dati inviati dagli utenti.</p>
<p>Se l'indirizzo email o la password non sono corrette, vengono stampati a video gli errori.</p>