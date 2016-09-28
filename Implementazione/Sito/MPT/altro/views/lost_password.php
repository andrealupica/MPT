<style type="text/css">
<!--
form { margin: 20px; padding: 20px; border: 1px solid #ccc; }
form span { display: block; margin-bottom: 10px;}
form span label { display: block; float: left; width: 200px; }
-->
</style>
<h1>Form di recupero password</h1>
<form method="post" action="">
	<span>
		<label for="user-email">Tua email:</label>
		<input type="text" name="user-email" />
	</span>
	<span>
		<input type="submit" value="Recupera password" />
	</span>
</form>
<a href="login.php">Fai il login ora</a>&nbsp;&nbsp;
<a href="register.php">Registrati</a>
<hr/>
<ul>
	<li><strong>Modello: </strong>models/recover.php</li>
	<li><strong>Vista: </strong>views/recover.php</li>
	<li><strong>Pagina pubblica: </strong>recover.php</li>
</ul>
<hr/>
<p>Da questo form l'utente pu&ograve; recuperare la propria password.</p> 