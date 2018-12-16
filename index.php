<?php
header('Content-Type: text/html; charset=ISO-8859-1');

require_once("iniciar.php");
//require("private/modelo/db.class.php");

if($_POST["inputEmail"]!="" && $_POST["inputPassword"]!="") {

 $dato = $b->ingresoUsuario($_POST["inputEmail"], $_POST["inputPassword"]);

  if($b->ingresoUsuario($_POST["inputEmail"], $_POST["inputPassword"]) == "Correcto") {
	  
	 $b->sesionUsuario($_POST["inputEmail"]);
     $b->redirigir_a("vistas/v.historico.php?usuario=".$a->encrypt($_POST["inputEmail"],"dos"));
  }
  else {
    
     $b->redirigir_a("http://redraus.com.co/sicpmt");
  }
}

?>
<!DOCTYPE html>
<html lang="sp">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="Uriel Martinez-Jose Vargas">
    <link rel="icon" href="../../favicon.ico">

    <title>Inicio SICPMT</title>

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
	<?php echo $mensaje; ?>

      <form class="form-signin" method="POST">
        <h2 class="form-signin-heading">Iniciar Sesi&oacute;n</h2>
        <label for="inputEmail" class="sr-only">Correo electr&oacute;nico</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Correo electr&oacute;nico" name="inputEmail"  required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Clave" required>
        
        <button class="btn btn-lg btn-primary btn-block" type="submit">Iniciar sesi&oacute;n</button>
      </form>
	  
	  <div class="link" align="center">
          <label>
            <a href="registro.php"> Registrarse</a> |
			<a href="forgot.php?inputEmail="+this.form.inputEmail.value>Olvid&oacute; su clave ?</a> |
			<a href="vistas/v.historico_c.php?usuario=consulta">Consulta</a> |
			<a href="wordcloud/" target="_blank">WordCloud</a>
          </label>
      </div>

    </div> <!-- /container -->
    

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../sicpmt/vistas/bootstrap/assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
