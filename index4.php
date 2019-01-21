<?php
header('Content-Type: text/html; charset=UTF-8');

require_once("iniciar.php");

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

	<script language="JavaScript" type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script language="JavaScript" type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="vistas/bootstrap/js/bootstrap.min.js"></script>
	
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
	
	peticion.open("POST", "vistas/v.historico_ajax.php?accion="+ruta, true);
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
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      
	  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
	  <a class="navbar-brand" href="#">
        <img alt="Brand" src="raus.jpg">
      </a>
    </div>
	
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
	    <li><a href="#">Consulta Tesauro <span class="sr-only">(current)</span></a></li>
        <li><a href="#">WordCloud</a></li>
		<li class="active"><a href="#">Buscar</a></li>
	  </ul>
	  <ul class="nav navbar-nav navbar-right">
        <li><a href="http://redraus.com.co/sicpmt">Iniciar Sesi&oacute;n</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Separated link</a></li>
          </ul>
        </li>
      </ul>
	  
	</div><!-- collapse navbar --> 
  </div><!-- container-fluid -->
</nav>

<br><br><br>

<!-- Contenido Base -->
<div class="container container-fluid">

<!-- Jumbotron -->
<div class="jumbotron">
  <h1>SICPMT!</h1>
  <p>Bienvenido a SICPMT. En este sitio encontrará informaciónde artículos sobre estudios de contaminación de varias zonas de Colombia con grandes fuentes fluviales y su impacto sobre la salud humana</p>
  <p><a class="btn btn-primary btn-lg" href="#" role="button">Leer más</a></p>
</div>

<div class="row">
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src="..." alt="...">
      <div class="caption">
        <h3>Tesauro</h3>
        <p>Por esta opci&oacute;n se presenta una opción de consulta del Tesauro almacenado en la aplicación de SICPMT</p>
        <p><a href="#" class="btn btn-primary" role="button">Button</a> </p>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src="..." alt="...">
      <div class="caption">
        <h3>WordCloud</h3>
        <p>Nube de palabras</p>
        <p><a href="wordcloud/" class="btn btn-primary" role="button">Ir a</a> </p>
      </div>
    </div>
  </div>  
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src="..." alt="...">
      <div class="caption">
        <h3>Consulta SICPMT</h3>
        <p>Puede consulta el histórico de solicitudes de titulación, publicaciones, revisión de titulación entre otros</p>
        <p><a href="vistas/v.historico_c.php" class="btn btn-primary" role="button">Ir a</a> </p>
      </div>
    </div>
  </div> 

  
</div>



</div>

	</body>
	</html>