<?php 
//header('Content-Type: text/html; charset=iso-8859-1');
require_once(dirname(dirname(__FILE__))."/iniciar.php");

if($_GET["usuario"]!="")
{
	$b->validaUsuario($a->decrypt($_GET["usuario"],"dos"));
		
}
else {
	echo "Sesion cerrada <a href='../index.php' role='link'>Inicio</a>";
	exit;
}

// Verifica existencia de 'token' para navegar por las pestañas
if($_GET["token"]=="")
{
	$b->redirigir_a("v.historico.php?usuario=".$_GET["usuario"]);
}

include_once(dirname(dirname(__FILE__))."/controlador/editar_registro_1.php");

// Consulto los datos en base al ID para edicion
$stmt_datos = $db->prepare("select autor,titulo,keywords,resumen,usuario,status from tesauro where id=:id");
$stmt_datos->execute(array(":id"=>$a->decrypt($_GET['token'],"tesa")));
$row_stmt_datos = $stmt_datos->fetch();

if($row_stmt_datos["usuario"]!=$a->decrypt($_GET["usuario"],"dos") || $row_stmt_datos["status"]=="OK")
{
	$b->redirigir_a("v.historico.php?usuario=".$_GET["usuario"]);
}

//echo "EL PUNTERO ES: ".$a->decrypt($_POST['token'],"tesa")."<br>";

?>
<!DOCTYPE html>
<html lang="sp">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="Uriel MArtinez-Jose Vargas">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="icon" href="../../favicon.ico">

    <title>Registro en SICPMT</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="bootstrap/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    
    <!-- Custom styles for this template -->
    <link href="../sticky-footer-navbar.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../sicpmt/bootstrap/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!--<script src="bootstrap/assets/js/ie-emulation-modes-warning.js"></script>-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  
<body>
<?php $activo=2; ?>
<?php include("v.navbar.php"); ?>

<div class="container container-fluid">
<h2>Grupo 2</h2>
<form method="POST" action="v.editar_datos_3.php?usuario=<?=$_GET["usuario"]?>&token=<?=$_GET["token"]?>" class="form-horizontal">

<div class="panel panel-success">
  <div class="panel-heading">
    <h3 class="panel-title">Titulaci&oacute;n</h3>
  </div>
  <div class="panel-body">

  <div class="row">
<div class="col-lg-6">
<div class="input-group">
  <input type="text" class="form-control" aria-describedby="basic-addon1" name="autor" value="<?=$row_stmt_datos[0]?>" required>
  <span class="input-group-addon" id="basic-addon1">Emisor Autor</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <input type="text" class="form-control" placeholder="Titulo" aria-describedby="basic-addon2" name="titulo" value="<?=$row_stmt_datos[1]?>" required>
  <span class="input-group-addon" id="basic-addon2">T&iacute;tulo</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <input type="text" class="form-control" placeholder="" aria-describedby="basic-addon3" name="palabras" value="<?=$row_stmt_datos[2]?>" required>
  <span class="input-group-addon" id="basic-addon3">Palabras claves</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <textarea class="form-control" aria-describedby="basic-addon4" name="resumen" required><?=$row_stmt_datos[3]?></textarea>
  <span class="input-group-addon" id="basic-addon4">Resumen</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <input type="submit" class="btn btn-danger" value="Guardar y Continuar">
  <!--<input type="hidden" name="token" value="<?=$_POST['token']?>">-->
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%;">
    40%
  </div>
</div>

</div><!-- /.panel-body -->
</div><!-- /.panel-success -->
</form>
</div>
<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="bootstrap/assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="bootstrap/assets/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="bootstrap/assets/js/ie10-viewport-bug-workaround.js"></script>
	
</body>
</html>
<?php

?>