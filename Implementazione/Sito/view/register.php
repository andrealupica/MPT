<!-- pagina per la registrazione-->
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registrazione</title>
  <script src="script.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/index.css" rel="stylesheet">

</head>
<body class="body">
  <div class="container contenitore">
    <div class="col-md-16">
      <div class="main-login main-center">
        <h1>Registrazione</h1>
        <form class="form-horizontal" method="post" action="#">
          <div class="form-group">
            <label for="email" class="cols-sm-2 control-label">Nome:</label>
            <div class="cols-sm-10">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
                <input type="text" class="form-control" name="nome" id="nome"  placeholder="inserire il tuo nome" required="required"/>
              </div>
            </div>
            <p class="help-block">inserire il proprio nome, non inserire numeri o spazi</p>
          </div>

          <div class="form-group">
            <label for="email" class="cols-sm-2 control-label">Cognome:</label>
            <div class="cols-sm-10">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
                <input type="text" class="form-control" name="cognome" id="cognome"  placeholder="inserire il tuo cognome" required="required"/>
              </div>
            </div>
            <p class="help-block">inserire il proprio cognome, non inserire numeri o spazi</p>
          </div>

          <div class="form-group">
            <label for="email" class="cols-sm-2 control-label">Email:</label>
            <div class="cols-sm-10">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
                <input type="text" class="form-control" name="email" id="email"  placeholder="inserire la tua e-mail.edu" required="required"/>
              </div>
            </div>
            <p class="help-block">l'email dovrebbe essere nome.cognome@edu.ti.ch</p>
          </div>
          <!--
          <div class="form-group">
            <label for="password" class="cols-sm-2 control-label">Password:</label>
            <div class="cols-sm-10">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                <input type="password" class="form-control" name="password" id="password"  placeholder="Inserire la tua password"/>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="password" class="cols-sm-2 control-label">Conferma password:</label>
            <div class="cols-sm-10">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                <input type="password" class="form-control" name="repassword" id="repassword"  placeholder="ripetere la tua password"/>
              </div>
            </div>
          </div>
          -->
          <div>
            <label class="cols-sm-3 control-label" id="errore"></label>
          </div>
          <br>
          <div class="form-group btn-group btn-group-justified">
            <div class="col-xs-0 col-sm-2"></div>
            <div class="col-xs-6 col-sm-3">
              <button class="btn btn-primary col-xs-12">
                <span></span> Registrati
              </button>
            </div>
             <p class="help-block">invia la richiesta di registrazione all'amministratore</p>
            <div class="col-xs-0 col-sm-2"></div>
          </div>

        </form>
      </div>
    </div>
  </div>
</body>
</html>
