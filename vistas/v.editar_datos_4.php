<?php 
//header('Content-Type: text/html; charset=ISO-8859-1');
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



if($_POST["toke"]=="acth") {
  include_once(dirname(dirname(__FILE__))."/controlador/editar_registro_4.php");
}
else {
  include_once(dirname(dirname(__FILE__))."/controlador/editar_registro_3.php");
}

// Consulto los datos en base al ID para edicion
$stmt_datos = $db->prepare("select pais_muestreo,region,latitud,longitud,matriz,especie,contaminante,unidades,usuario,status from tesauro where id=:id");
$stmt_datos->execute(array(":id"=>$a->decrypt($_GET["token"],"tesa")));
$row_stmt_datos = $stmt_datos->fetch();

if($row_stmt_datos["usuario"]!=$a->decrypt($_GET["usuario"],"dos") || $row_stmt_datos["status"]=="OK")
{
	$b->redirigir_a("v.historico.php?usuario=".$_GET["usuario"]);
}

// Separo Latitud y Longitud
$coord = explode("|",$row_stmt_datos['unidades']);
$und_lat = $coord[0];
$und_lon = $coord[1];

$coord_latitud = explode("|",$row_stmt_datos['latitud']);
$coord_longitud = explode("|",$row_stmt_datos['longitud']);

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
<?php $activo=4; ?>
<?php include("v.navbar.php"); ?>

<div class="container container-fluid">
<h2>Grupo 4</h2>
<form method="POST" name="form1" class="form-horizontal" enctype="multipart/form-data" action="v.editar_datos_5.php?usuario=<?=$_GET["usuario"]?>&token=<?=$_GET["token"]?>">

<div class="panel panel-success">
  <div class="panel-heading">
    <h3 class="panel-title">Georeferenciaci&oacute;n /Especies</h3>
  </div>
  <div class="panel-body">

<!-- Cambios Mayo 13/17  
<div class="row">
<div class="col-xs-8">
<div class="input-group">
  <select class="form-control" aria-describedby="basic-addon1" name="pais_muestreo" required>
   <option value="<?=$row_stmt_datos[0]?>"><?=$row_stmt_datos[0]?></option>
   <option value=""> --- </option>
   <?php $otro_sql=$db->prepare("select pais from paises order by pais");
         $otro_sql->execute();
		  while($row_otro_sql=$otro_sql->fetch()) {
			  ?><option value="<?=$row_otro_sql[0]?>"><?=$row_otro_sql[0]?></option><?php
		  }
   ?>
  </select>
  <span class="input-group-addon" id="basic-addon1">Pais muestreo</span>
</div>
</div>
</div>
-->

<!--
<div class="row">
<div class="col-xs-8">
<div class="input-group">
  <input type="text" class="form-control" aria-describedby="basic-addon1" value="<?=$row_stmt_datos[1]?>" name="region" required>
  <span class="input-group-addon" id="basic-addon1">Regi&oacute;n</span>
</div>
</div>
</div>
-->

<!-- Cambios Mayo 13/17
<div class="row">
<div class="col-xs-2">
<div class="input-group">
  <input type="number" class="form-control" aria-describedby="basic-addon1" value="<?=$coord_latitud[0]?>" name="latitud_g">
  <span class="input-group-addon" id="basic-addon1">g</span>
</div>
</div>
<div class="col-xs-2">
<div class="input-group">
  <input type="number" min="0" class="form-control" aria-describedby="basic-addon1" value="<?=$coord_latitud[1]?>" name="latitud_m">
  <span class="input-group-addon" id="basic-addon1">m</span>
</div>
</div>

<div class="col-xs-2">
<div class="input-group">
  <input type="number" min="0" class="form-control" aria-describedby="basic-addon1" value="<?=$coord_latitud[2]?>" name="latitud_s">
  <span class="input-group-addon" id="basic-addon1">s</span>
</div>
</div>

<div class="col-xs-2">
<div class="input-group">
  <select name="und_latitud" class="form-control">
    <option value="<?=$und_lat?>"><?=$und_lat?></option>
	<option value=""> - </option>
    <option value="N">N</option>
	<option value="S">S</option>
  </select>
  <span class="input-group-addon" id="basic-addon1">Lat</span>
</div>
</div>
</div>
-->

<!-- Cambios Mayo 13/17
<div class="row">
<div class="col-xs-2">
<div class="input-group">
  <input type="number" class="form-control" aria-describedby="basic-addon1" value="<?=$coord_longitud[0]?>" name="longitud_g">
  <span class="input-group-addon" id="basic-addon1">g</span>
</div>
</div>
<div class="col-xs-2">
<div class="input-group">
  <input type="number" class="form-control" aria-describedby="basic-addon1" value="<?=$coord_longitud[1]?>" name="longitud_m">
  <span class="input-group-addon" id="basic-addon1">m</span>
</div>
</div>
<div class="col-xs-2">
<div class="input-group">
  <input type="number" class="form-control" aria-describedby="basic-addon1" value="<?=$coord_longitud[2]?>" name="longitud_s">
  <span class="input-group-addon" id="basic-addon1">s</span>
</div>
</div>
<div class="col-xs-2">
<div class="input-group">
  <select name="und_longitud" class="form-control" class="">
    <option value="<?=$und_lon?>"><?=$und_lon?></option>
	<option value=""> - </option>
    <option value="E">E</option>
	<option value="W">W</option>
  </select>
  <span class="input-group-addon" id="basic-addon1">Long</span>
</div>
</div>
</div>
-->



<h3>Agregar Grupo   <input type="button" class="btn btn-info" value="+" onClick="javascript:
  this.form.action='v.editar_datos_4.php?token_especie=add&usuario=<?=$_GET["usuario"]?>&token=<?=$_GET["token"]?>';
  this.form.submit();">
</h3>
<?php echo $cadena_especie;
?>


<div class="row">
<div class="col-lg-6">
<div class="input-group">
<input type="hidden" name="toke">
<input type="submit" value="Guardar y Continuar" class="btn btn-danger" onClick="this.form.toke.value='act';">
<!--<input type="hidden" name="token" value="<?=$_POST['token']?>" />-->
<input type="button" value="Guardar" class="btn btn-success" onClick="javascript:this.form.action='v.editar_datos_4.php?usuario=<?=$_GET["usuario"]?>&token=<?=$_GET["token"]?>'; this.form.toke.value='acth'; this.form.submit();">
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

</div><!-- /.panel-body -->
</div><!-- /.panel-success -->
</form>

<div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%;">
    80%
  </div>
</div>
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