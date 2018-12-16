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

include_once(dirname(dirname(__FILE__))."/controlador/editar_registro_2.php");


// Consulto los datos en base al ID para edicion
$stmt_datos = $db->prepare("select pais,fecha,revista,volumen,issue,articulo_numero,nombre_publicacion,usuario,link1,link2,page_start,page_end,status from tesauro where id=:id");
$stmt_datos->execute(array(":id"=>$a->decrypt($_GET['token'],"tesa")));
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
<?php $activo=3; ?>
<?php include("v.navbar.php"); ?>

<div class="container container-fluid">
<h2>Grupo 3</h2>
<form method="POST" name="form1" class="form-horizontal" action="v.editar_datos_4.php?usuario=<?=$_GET["usuario"]?>&token=<?=$_GET["token"]?>">

<div class="panel panel-success">
  <div class="panel-heading">
    <h3 class="panel-title">Publicaci&oacute;n</h3>
  </div>
  <div class="panel-body">

<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <input type="text" class="form-control" aria-describedby="basic-addon1" value="<?=$row_stmt_datos[6]?>" name="nombre_publicacion" required>
  <span class="input-group-addon" id="basic-addon1">Nombre publicaci&oacute;n</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <select class="form-control" aria-describedby="basic-addon1" name="pais" required>
   <option value="<?=$row_stmt_datos[0]?>"><?=$row_stmt_datos[0]?></option>
   <option value=""> --- </option>
  <?php $otro_sql=$db->prepare("select pais from paises order by pais");
         $otro_sql->execute();
		  while($row_otro_sql=$otro_sql->fetch()) {
			  ?><option value="<?=$row_otro_sql[0]?>"><?=$row_otro_sql[0]?></option><?php
		  }
   ?>
  </select>
  <span class="input-group-addon" id="basic-addon1">Pais de publicaci&oacute;n</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <input type="month" class="form-control" aria-describedby="basic-addon2" name="fecha" value="<?=$row_stmt_datos[1]?>" required>
  <span class="input-group-addon" id="basic-addon2">A&ntilde;o</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <input type="text" class="form-control" placeholder="" aria-describedby="basic-addon3" name="revista" value="<?=$row_stmt_datos[2]?>" required>
  <span class="input-group-addon" id="basic-addon2">Revista</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <input type="text" class="form-control" placeholder="" aria-describedby="basic-addon4" name="volumen" value="<?=$row_stmt_datos[3]?>" required>
  <span class="input-group-addon" id="basic-addon4">Volumen</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->
<br/>
<div class="form-group">
<div class="col-lg-6">
<div class="checkbox">
  <label>  
     <input type="checkbox" name="checkarticulo_n" id="checkarticulo_n" onclick="if(document.form1.checkarticulo_n.checked){ document.form1.articulo_n.value='NA'; } else { document.form1.articulo_n.value=''; }"><strong>Seleccionar si No Aplica Art&iacute;culo N&uacute;mero </strong>
  </label>
</div>
</div>
</div>


<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <input type="text" class="form-control" placeholder="" aria-describedby="basic-addon5" name="articulo_n" value="<?=$row_stmt_datos[5]?>" required>
  <span class="input-group-addon" id="basic-addon5">Art&iacute;culo N&uacute;mero</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
<div class="col-lg-6">
<div class="checkbox">
  <label for="checkissue">  
     <input type="checkbox" value="NA" name="checkissue" id="checkissue" onclick="if(document.form1.checkissue.checked){ document.form1.issue.value='NA'; } else { document.form1.issue.value=''; }"><strong>Seleccionar si No Aplica Issue </strong>
  </label>
</div>
<div class="input-group">
  <input type="text" class="form-control" placeholder="" aria-describedby="basic-addon6" name="issue" value="<?=$row_stmt_datos[4]?>" required>
  <span class="input-group-addon" id="basic-addon6">Issue</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <input type="number" min="0" class="form-control" placeholder="" aria-describedby="basic-addon4" name="Inputpaginicio" value="<?=$row_stmt_datos['page_start']?>" required>
  <span class="input-group-addon" id="basic-addon4">P&aacute;gina Inicio</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <input type="number" min="0" class="form-control" placeholder="" aria-describedby="basic-addon4" name="Inputpagfin" value="<?=$row_stmt_datos['page_end']?>" required>
  <span class="input-group-addon" id="basic-addon4">P&aacute;gina Fin</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <input type="url" class="form-control" placeholder="http://" aria-describedby="basic-addon4" name="Inputlink1" value="<?=$row_stmt_datos['link1']?>" required>
  <span class="input-group-addon" id="basic-addon4">Enlace 1</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <input type="url" class="form-control" placeholder="http://" aria-describedby="basic-addon4" name="Inputlink2" value="<?=$row_stmt_datos['link2']?>" required>
  <span class="input-group-addon" id="basic-addon4">Enlace 2</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
<div class="col-lg-6">
<div class="input-group">
<input type="hidden" name="toke">
<input type="submit" value="Guardar y Continuar" class="btn btn-danger" onclick="this.form.toke.value='act';">
<!--<input type="hidden" name="token" value="<?=$_POST['token']?>" />-->
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

</div><!-- /.panel-body -->
</div><!-- /.panel-success -->
</form>

<div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
    60%
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
