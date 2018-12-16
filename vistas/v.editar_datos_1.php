<?php
//header('Content-Type: text/html; charset=ISO-8859-1');
require_once(dirname(dirname(__FILE__))."/iniciar.php");




if($_GET["usuario"]!="" || $_POST["usuario"]!="")
{
	$b->validaUsuario($a->decrypt($_GET["usuario"],"dos"));
	
	// Inserto nuevo registro
	if($_GET["peticion"]=="ok") {
		
		$sql = $db->prepare("insert into tesauro(usuario,fecha_act) values(:usuario,:fecha)");
		$sql->execute(array(":usuario"=>$a->decrypt($_GET["usuario"],"dos"), ":fecha"=>date("Y-m-d H:i:s")));
		
		$puntero = $b->consulta_sql("tesauro","MAX(id)","");
		$puntero = $puntero->fetch();
		
	}
	
	if($_GET["token"]!="") {
			
			$id_sincronizado = $_GET["token"];
	}
	else {
			
			$id_sincronizado = $a->encrypt($puntero[0],"tesa");
	}
	
	// Verifica existencia de 'token' para navegar por las pestañas
    if($id_sincronizado=="")
{
	$b->redirigir_a("v.historico.php?usuario=".$_GET["usuario"]);
}

		
}
else {
	echo "Sesion cerrada <a href='../index.php' role='link'>Inicio</a>";
	exit;
}

//echo "<br>Id sincronizado: ".$id_sincronizado, "<br>Puntero: ".$a->decrypt($id_sincronizado,"tesa");
//exit;

//include_once(dirname(dirname(__FILE__))."/controlador/editar_registro_1.php");



// Consulto los datos en base al ID para edicion
$stmt_datos = $db->prepare("select tipo_documento,categoria,vigencia,usuario,status from tesauro where id=:id");
$stmt_datos->execute(array(":id"=>$a->decrypt($id_sincronizado,"tesa")));
$row_stmt_datos = $stmt_datos->fetch();

if($row_stmt_datos["usuario"]!=$a->decrypt($_GET["usuario"],"dos") || $row_stmt_datos["status"]=="OK")
{
	
	
	$b->redirigir_a("v.historico.php?usuario=".$_GET["usuario"]);
}



?>
<!DOCTYPE html>
<html lang="sp">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="Uriel Martinez-Jose Vargas">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="icon" href="../../favicon.ico">

    <title>Registro en SICPMT</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="bootstrap/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    
    <!-- Custom styles for this template -->
    <link href="../sticky-footer-navbar.css" rel="stylesheet">
	<!-- <link href="editar_datos.css" rel="stylesheet"> -->

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
<?php $activo=1; ?>
<?php include("v.navbar.php"); ?>

<div class="container container-fluid">
<h2>Grupo 1</h2>
<form method="POST" class="form-horizontal" action="v.editar_datos_2.php?usuario=<?=$_GET["usuario"]?>&token=<?=$id_sincronizado?>">

<div class="panel panel-success">
  <div class="panel-heading">
    <h3 class="panel-title">Datos de inicio</h3>
  </div>
  <div class="panel-body">

<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <select class="form-control" aria-describedby="basic-addon2" name="tipo_documento" required>
   <option value="<?=$row_stmt_datos['tipo_documento']?>"><?=$row_stmt_datos['tipo_documento']?></option>
   <option value=""> -- </option>
   <?php echo $b->verLista("tipo_documento"); ?>
  </select>
  <span class="input-group-addon" id="basic-addon2">Tipo de Documento</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <select class="form-control" aria-describedby="basic-addon3" name="categoria" required>
    <option value="<?=$row_stmt_datos['categoria']?>"><?=$row_stmt_datos['categoria']?></option>
    <option value=""> -- </option>
    <?php echo $b->verLista("categoria"); ?>
  </select>
  <span class="input-group-addon" id="basic-addon3">  Categoria</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <input type="date" class="form-control" placeholder="Vigencia" aria-describedby="basic-addon4" name="vigencia" value="<?=$row_stmt_datos['vigencia']?>" required>
  <span class="input-group-addon" id="basic-addon4">Vigencia</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

  <div class="form-group">
    <div class="col-lg-6">
      <div class="checkbox">
        <label>
          <input type="checkbox" onClick="this.form.vigencia.value='00/00/1900'"> <strong>Seleccionar si no aplica</strong>
        </label>
      </div>
    </div>
  </div>

<div class="row">
<div class="col-lg-6">
<div class="input-group">
 <input type="submit" class="btn btn-danger" value="Guardar y Continuar" onClick="" />
 <input type="hidden" name="token" value="<?=$id_sincronizado?>" />
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

</form>
</div><!-- /.panel-body -->
</div><!-- /.panel panel-info -->

<div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%;">
    20%
  </div>
</div>

</div><!-- /.container-fliud -->

<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../sicpmt/bootstrap/assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="bootstrap/assets/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="bootstrap/assets/js/ie10-viewport-bug-workaround.js"></script>

</body>
</html>