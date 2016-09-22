
<!DOCTYPE html>
<html>
<head>
	<title>iSete | Pagina principale</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/jpeg" href="images/isete-logo.jpg">
	<link rel="stylesheet" type="text/css" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container-fluid">
		<div class="row"><div class="col-xs-12">&nbsp;</div></div>
		<div class="row">
			<div class="col-xs-1 col-sm-2 col-md-3"></div>
			<form method="post" action="#" class="form-horizontal col-xs-10 col-sm-8 col-md-6 panel panel-default">
				<img src="images/isete.jpg" class="img-responsive center-block" width="450" alt="iSete Main Logo">
				<h1>Login</h1>
				<div class="form-group">
					<label class="col-xs-4 control-label" for="email">Email</label>
					<div class="col-xs-7 col-sm-5">
						<input type="email" name="email" id="email" pattern="[a-zA-Z]{3,30}.[a-zA-Z]{3,30}@(edu.ti|samtrevano).ch" name="usr" class="form-control" placeholder="E-mail qui...">
					</div>
					<div class="col-xs-1 col-sm-4"></div>
				</div>
				<div class="form-group">
					<label class="col-xs-4 control-label" for="pwd">Password</label>
					<div class="col-xs-7 col-sm-5">
						<input type="password" id="pwd" name="pwd" class="form-control" placeholder="Password qui...">
					</div>
					<div class="col-xs-1 col-sm-4"></div>
				</div>
				<div class="form-group btn-group btn-group-justified">
					<div class="col-xs-0 col-sm-2"></div>
					<div class="col-xs-6 col-sm-3">
						<a href="phps/register.php" class="btn btn-link col-xs-12">
							<span class="glyphicon glyphicon-plus"></span> Registrati
						</a>
					</div>
					<div class="col-xs-0 col-sm-2"></div>
					<div class="col-xs-6 col-sm-3">
						<button class="btn btn-primary col-xs-12" type="submit">
							<span class="glyphicon glyphicon-log-in"></span> Log-in
						</button>
					</div>
 					<div class="col-xs-0 col-sm-2"></div>
				</div>
			</form>
			<div class="col-xs-1 col-sm-2 col-md-3"></div>
		</div>
		<div class="row">
			<div class="col-xs-1 col-sm-2 col-md-3"></div>
			<div class="col-xs-10 col-sm-8 col-md-6">
				<?php
					if($err != ""){
						echo "<div class='alert alert-danger fade in'>" .
						"<a href='javascript:void(0)' class='close' data-dismiss='alert' aria-label='close'>" .
						"&times;</a> $err</div>";
					}
					elseif($succ != ""){
						echo "<div class='alert alert-success fade in'>" .
						"<a href='javascript:void(0)' class='close' data-dismiss='alert' aria-label='close'>" .
						"&times;</a>$succ</div>";
					}
					else{
						echo "&nbsp;";
					}
				?>
			</div>
			<div class="col-xs-1 col-sm-2 col-md-3"></div>
		</div>
	</div>
</body>
</html>