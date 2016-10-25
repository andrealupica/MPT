<!-- pagina di login-->
<!DOCTYPE html>
<html lang="it">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<script src="script.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="css/index.css" rel="stylesheet">

</head>
<body class="body">

	<div class="container contenitore">
		<div class="col-md-16">
			<div class="main-login main-center">
				<h1>Login AIT Docente</h1>
				<form class="form-horizontal" method="post" action="">
					<div class="form-group">
						<label for="email" class="cols-sm-3 control-label" id="email">Username:</label>
						<div class="cols-sm-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
								<input type="text" class="form-control" name="email" id="email"  placeholder="inserire la tua e-mail.edu" required="required"/>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="password" class="cols-sm-2 control-label" id="password">Password:</label>
						<div class="cols-sm-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
								<input type="password" class="form-control" name="password" id="password"  placeholder="Inserire la tua password" required="required"/>
							</div>
						</div>
					</div>
					<div class="form-group btn-group btn-group-justified" >
						<div class="col-xs-12 col-sm-6 col-md-4 bottone">
							<button class="btn btn-primary col-xs-12" type="submit" id="user-login">
								<span class="glyphicon glyphicon-log-in"></span> Log-in
							</button>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-4 bottone">
							<a href="register.php" class="btn btn-primary col-xs-12">
								<span class="glyphicon glyphicon-plus"></span> Registrazione
							</a>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-4 bottone">
							<a class="btn btn-primary col-xs-12" href="forgotPassword.php">
								<span class="glyphicon glyphicon-question-sign"></span> Password Dimenticata
							</a>
						</div>
						<div class="col-xs-0 col-sm-2"></div>
						<div>
							<label class="cols-sm-3 control-label" id="errore"></label>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
