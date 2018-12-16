<?php
header('Content-Type: text/html; charset=utf-8');

require_once("iniciar.php");
//require_once("../sicpmt/private/modelo/db.class.php");

//echo dirname(dirname(__FILE__));

if($_POST["inputEmail"]!="" && $_POST["inputPassword"]!="") {
  
   if($b->registroUser($_POST["inputEmail"],$_POST["inputPassword"]))
{
   if($b->envioCorreo($_POST["inputEmail"],"")==true) {
   
     $respuesta = "<div style='float-center'>Se envió un correo a su buzón para validar acceso <a href='index.php' role='link'>Volver</a></div><br>";
   }
   else {
     
     //echo "No fue posible validar su acceso. Por favor intente mas tarde <a href='index.php' role='link'>Volver</a><br>";
   }

}
else {
   
   $respuesta = "Ya est&aacute; registrado el usuario <a href='http://redraus.org/sicpmt' role='link'>Volver</a>";
   exit;
}

  echo $respuesta;
   
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="Uriel MArtinez-Jose Vargas">
    <link rel="icon" href="../../favicon.ico">

    <title>Registro en SICPMT</title>

    <!-- Bootstrap core CSS -->
    <link href="vistas/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="vistas/bootstrap/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="vistas/bootstrap/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

      <form class="form-signin" method="POST">
        <h2 class="form-signin-heading">Registro nuevo usuario</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Email address" name="inputEmail"  required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" oninvalid="this.setCustomValidity('Diligencie este campo')" required>
        <!--<div class="link">
          <label>
            <a href="registro.php"> Registrarse</a>
          </label>
        </div>-->
        <button class="btn btn-lg btn-primary btn-block" type="submit">Registrarse</button>
      </form>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="vistas/bootstrap/assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>