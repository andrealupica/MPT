<!-- pagina per la registrazione-->
<?php
session_start();

?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registrazione</title>
  <script src="js/script.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/index.css" rel="stylesheet">
</head>
<script>
$(document).ready(function(){
  $("#OkRegister").click(function(){
    $(location).attr('href', 'index.php')
  });
  $("#registrati").click(function(){
  //  alert("<?php echo 'vecchia sessione: '.$_SESSION['codice']?>. post:"+$("#captcha").val());
    <?php $_SESSION['codice']=$_SESSION['captcha']['code'];?>
  //  alert("<?php echo 'nuovo valore miaSessione: '.$_SESSION['codice']?>. post:"+$("#captcha").val());
  });
});
</script>
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
            <label class="cols-sm-2 control-label">Captcha:</label>
            <div>
              <div class="input-group col-xs-12">
                <span>
                  <img src="<?php echo $_SESSION['captcha']['image_src'];?>" width="180"  height="40" border="1" alt="CAPTCHA" class="col-xs-6">
                  <div class="input-group  col-xs-12">
                    <span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
                      <input type="text" size="6" maxlength="5" name="captcha" id="captcha" class="form-control col-xs-12" value="">
                  </div>
                </span>

              </div>
            </div>
            <p class="help-block">inserire il codice captcha</p>
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
          <div>
            <label class="cols-sm-3 control-label" id="errore"></label>
          </div>
          <br>
          <div class="form-group btn-group btn-group-justified">
            <div class="col-xs-0 col-sm-2"></div>
            <div class="col-xs-6 col-sm-3">
              <button id="registrati" class="btn btn-primary col-xs-12">
                <span></span> Registrati
              </button>
            </div>
             <p class="help-block">invia la richiesta di registrazione all'amministratore</p>
            <div class="col-xs-0 col-sm-2"></div>
          </div>

        </form>
      </div>
    </div>
    <div class="container">
      <!-- Modal -->
      <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Registrazione effettuata</h4>
            </div>
            <div class="modal-body">
              <p>È stata inviata un'email all'amministratore</p>
              <div class="alert alert-info">
                Riceverai un'email quando l'amministratore confermerà la tua registrazione
              </div>
            </div>
            <div class="modal-footer">
                <button type="submit" onclick="return false" class="btn btn-default" id="OkRegister">ok</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
