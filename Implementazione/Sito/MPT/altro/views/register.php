<style type="text/css">
<!--
form { margin: 20px; padding: 20px; border: 1px solid #ccc; }
form span { display: block; margin-bottom: 10px;}
form span label { display: block; float: left; width: 200px; }
-->
</style>
<h1>Form di registrazione</h1>
<form method="post" action="">
	<span>
		<label for="user-email">Tua email:</label>
		<input type="text" name="user-email" />
	</span>
	<span>
		<label for="user-email-repeat">Ripeti email:</label>
		<input type="text" name="user-email-repeat" />
	</span>
	<span>
		<label for="user-password">Password:</label>
		<input type="password" name="user-password" />
	</span>
	<span>
		<label for="user-password-repeat">Ripeti password:</label>
		<input type="password" name="user-password-repeat" />
	</span>
	<span>
		<label for="user-name">Tuo nome:</label>
		<input type="text" name="user-name" />
	</span>
	<span>
		<input type="submit" value="Registrami" />
	</span>
</form>
<a href="login.php">Fai il login ora</a>&nbsp;&nbsp;
<a href="lost_password.php">Password persa?</a>
<hr/>
<ul>
	<li><strong>Modello: </strong>models/lost_password.php</li>
	<li><strong>Vista: </strong>views/lost_password.php</li>
	<li><strong>Pagina pubblica: </strong>lost_password.php</li>
</ul>
<hr/>
<p>Questo form permette agli utenti di iscriversi al sistema inserendo un indirizzo email
valido ed una password; la richiesta del nome &egrave; presentata per essere utilizzata come base 
nella creazione di altri input quali select, checkbox, campi testo, ecc...</p>
<p>Per completare l'iscrizione il sistema invia una email contenente un link con cui confermare
ed attivare il proprio account.</p>