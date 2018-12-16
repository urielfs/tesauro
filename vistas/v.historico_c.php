<?php
//header('Content-Type: text/html; charset=ISO-8859-1');
require_once(dirname(dirname(__FILE__))."/iniciar.php");

	//$b->validaUsuario("consulta");
	
	// Numero de registros ingresados
	$stmt = $db->prepare("select count(id) from tesauro where deleted=0");
	$stmt->execute();
	$row_stmt = $stmt->fetch();

if($_GET["peticion"]=="ok")
{
	$b->redirigir_a("v.editar_datos_1.php?peticion=ok&usuario='consulta'");
}

?>
<!DOCTYPE html>

  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="Uriel Martinez-Jose Vargas">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="icon" href="../../favicon.ico">

    <title>Hist&oacute;rico en SICPMT</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="bootstrap/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
	
	<link href="../sticky-footer-navbar.css" rel="stylesheet">
	
	<!-- Data Tables -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../sicpmt/bootstrap/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!--<script src="bootstrap/assets/js/ie-emulation-modes-warning.js"></script>-->
	
	<script language="JavaScript" type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script language="JavaScript" type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
<script language="JavaScript">
/* ------------------------------------- */
/*          Consulta en AJAX-JSON        */
/* ------------------------------------- */

/*


*/

function objetoAjax(){
        var xmlhttp=false;
        try {
                xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
                try {
                   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (E) {
                        xmlhttp = false;
                }
        }

        if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
                xmlhttp = new XMLHttpRequest();
        }
        return xmlhttp;
}

var peticion = objetoAjax();

function enviarPost(ruta,formulario){
	
	peticion.open("POST", "v.historico_ajax.php?accion="+ruta, true);
	peticion.onreadystatechange = procesarPeticion;
	
	peticion.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	var parametros = $("#"+formulario).serialize();
		document.getElementById('btn_buscar').disabled = 'disabled';
		//document.getElementById('btn_crear').disabled = 'disabled';
		document.getElementById('btn_exportar').disabled = 'disabled';
		document.getElementById('btn_buscar').value = '..buscando';
		
	peticion.send(parametros);
	
}

function procesarPeticion(){
	if(peticion.readyState==4){
		
		
		
		if(peticion.status==200){
			
			cadena = eval("("+peticion.responseText+")");
			
			document.getElementById('btn_buscar').disabled = false;
			document.getElementById('btn_exportar').disabled = false;
			//document.getElementById('btn_crear').disabled = false;
			document.getElementById('btn_buscar').value = 'Buscar';
			document.getElementById('resultado_historico').innerHTML = cadena.resultado;
			//alert(cadena.resultado);
		}
	}
	
	
}

//$.fn.dataTable.ext.errMode = 'throw';

</script>
  
  
<body>
<?php $activo='h'; ?>

<div class="container container-fluid">
<div class="page-header">
<h1>Hist&oacute;rico de Solicitudes <small><?=$row_stmt[0]?> registros ingresados</small></h1>
</div>
<div class="row">
<form class="form-inline" method="POST" name="form1" id="form1">
  <div class="col-md-5">
  <div class="form-group">
    <label class="sr-only" for="buscaTitulo">T&iacute;tulo</label>
    <div class="input-group">
      
      <input type="text" class="form-control" id="buscaTitulo" name="buscaTitulo" value="<?=$_GET["buscaTitulo"]?>" placeholder="T&iacute;tulo">
      
    </div>
  </div>
  
  
  <!--<button class="btn btn-primary" onclick="javascript:document.form1.action='v.historico.php'; document.form1.peticion.value=''; document.form1.submit();">Buscar</button>-->
  <input type="button" id="btn_buscar" class="btn btn-primary" onclick="enviarPost('historico','form1')" value="Buscar">
  <!--<button id="btn_crear" class="btn btn-success" onclick="javascript:document.form1.action='v.editar_datos_1.php'; document.form1.peticion.value='ok'; document.form1.submit();">Crear registro</button>-->
 
 </div>
 
 <div class="col-md-3 col-md-offset-3">
 <a class="btn btn-default btn-lg" id="btn_exportar" href="v.export_historico.php?buscaTitulo="+document.form1.buscaTitulo.value>
  <span class="glyphicon glyphicon-export" aria-hidden="true"></span>
 </a>
 </div>
 <input type="hidden" name="usuario" value="<?=$_GET["usuario"]?>" />
 <input type="hidden" name="peticion" />
</form>
</div>
<br/>

	<div id="resultado_historico"></div>

<!--

-->
<!--

-->


</div>
<!-- Bootstrap core JavaScript ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>-->
      <!--<script>window.jQuery || document.write('<script src="/bootstrap/assets/js/vendor/jquery.min.js"><\/script>')</script>-->
      <!--<script src="bootstrap/js/bootstrap.min.js"></script>-->
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
      <!--<script src="bootstrap/assets/js/vendor/holder.min.js"></script>-->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
      <!--<script src="bootstrap/assets/js/ie10-viewport-bug-workaround.js"></script>-->
</body>
</html>