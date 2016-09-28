<style type="text/css">
<!--
form { margin: 20px; padding: 20px; border: 1px solid #ccc; }
form span { display: block; margin-bottom: 10px;}
form span label { display: block; float: left; width: 200px; }
-->
</style>
<h1>Form cambio password</h1>
<form method="post" action="">
	<span>
		<label for="user-password">Password:</label>
		<input type="password" name="user-password" />
	</span>
	<span>
		<label for="user-password-repeat">Ripeti password:</label>
		<input type="password" name="user-password-repeat" />
	</span>
	<span>
		<input type="submit" value="Cambia la mia password" />
	</span>
</form>
<hr/>
<ul>
	<li><strong>Modello: </strong>models/change_password.php</li>
	<li><strong>Vista: </strong>views/change_password.php</li>
	<li><strong>Pagina pubblica: </strong>change_password.php</li>
</ul>
<hr/>
<p>Questo form permette ad un utente di resettare la password smarrita.</p>
<p>Un utente arriva su questa pagina dopo aver fatto click sul link inviato 
durante la richiesta di recupero password eseguita nella pagina lost_password.php.</p>