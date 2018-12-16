<?php
  #include(get_template_directory()."/modelo/db.class.php");
  #$stmt = $db->prepare("select * from tesauro where id=:id");
  #$stmt->execute(array(":id"=>$a->decrypt($_GET['token'],"tesa")));
  #$row = $stmt->fetch();
  


//header('Content-Type: text/html; charset=ISO-8859-1');
require_once(dirname(dirname(__FILE__))."/iniciar.php");

if($_GET["usuario"]!="")
{
	$b->validaUsuario($a->decrypt($_GET["usuario"],"dos"));
	
	// Numero de registros ingresados
	$stmt = $db->prepare("select count(id) from tesauro where deleted=0");
	$stmt->execute();
	$row_stmt = $stmt->fetch();
}

function imprimirBloq($item,$titulo)
{
	$cadena = "<blockquote>
	<p>".ucfirst($titulo)."</p>
	<footer>".$item."</footer>
	</blockquote>";
	
	return $cadena;
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

    <title>Historico en SICPMT</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="bootstrap/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
	
	<link href="../sticky-footer-navbar.css" rel="stylesheet">
	

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../sicpmt/bootstrap/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="bootstrap/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

	<script type='text/javascript'>
	var cadena;

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
	// Funcion para Select de Dropdown -------
function MostrarCorreo(datos) {
 		
        ajax=objetoAjax();
        ajax.open("POST", datos);
        ajax.onreadystatechange=function() {
                
				if (ajax.readyState==3) {
				  //carga.style.visibility = 'visible';
				}
				if (ajax.readyState==4) {
					if(ajax.responseText) {
                        cadena = eval("("+ajax.responseText+")");
						
						
						var option=document.createElement("option");
						
						if(cadena.token=="true") {
							document.getElementById('resultado_'+entrada).innerHTML = cadena.resultado;
							//document.getElementById('nuevo_Input'+entrada).value = "";
						}
						else {
						option.value = cadena.dato_v;
						option.text = cadena.dato_t;
						
						document.getElementById('Input'+entrada).appendChild(option);
						document.getElementById('resultado_'+entrada).innerHTML = cadena.resultado;
						//document.getElementById('nuevo_Input'+entrada).value = "";
						}
						
						if(cadena.opcion=="borrado")
						{
							//document.getElementById('InputOC').find('option[cadena.valor]').remove();
							document.getElementById('Input'+entrada).options[document.getElementById('Input'+entrada).selectedIndex] = null;
							document.getElementById('resultado_'+entrada).innerHTML = cadena.resultado;
						}
					}
						
                }
				
				
        }
        ajax.send(null)
		
}
	</script>

	</head>
<body>  
<?php include("v.navbar.php");

$mvc = new MvcController();

 ?>



<!-- CONTENIDO ANTERIOR -->
<?php
  $stmt = $db->prepare("select * from tesauro where id=:id");
  $stmt->execute(array(":id"=>$a->decrypt($_GET['token'],"tesa")));
  $row = $stmt->fetch();

  $stmt2 = $db->prepare("select * from tesauro_c where id_t=:id && deleted=0 order by especie");
  $stmt2->execute(array(":id"=>$row['id']));

// Separo Latitud y Longitud
  $coord = explode("|",$row['unidades']);
  $und_latitud = $coord[0];
  $und_longitud = $coord[1];
  $datos_lat = explode("|",$row['latitud']);
  $datos_lon = explode("|",$row['longitud']);
  
  $coordenadasGD = $b->convertirGD($datos_lat[0],$datos_lat[1],$datos_lat[2],$datos_lon[0],$datos_lon[1],$datos_lon[2],$und_latitud,$und_longitud);
  
// Hipervinculo Mapa en Google
/*
https://www.google.com.co/maps/place/4°39'01.5"N+75°06'40.4"W
*/
$vinculo = "https://www.google.com.co/maps/place/".$coordenadasGD[0].",".$coordenadasGD[1];

// Consulto términos Tesauro relacionados al registro
  $terminos = $db->prepare("select * from tesauro_elementos where id_t=:id");
  $terminos->execute(array(":id"=>$a->decrypt($_GET['token'],"tesa")));
?>
<div class="container container-fluid">
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    
    <li role="presentation" class="active"><a href="#brief" aria-controls="brief" role="tab" data-toggle="tab">Brief</a></li>
    <li role="presentation"><a href="#grupo1" aria-controls="grupo1" role="tab" data-toggle="tab">Grupo 1</a></li>
    <li role="presentation"><a href="#grupo2" aria-controls="grupo2" role="tab" data-toggle="tab">Grupo 2</a></li>
	<li role="presentation"><a href="#grupo3" aria-controls="grupo3" role="tab" data-toggle="tab">Grupo 3</a></li>
	<li role="presentation"><a href="#grupo4" aria-controls="grupo4" role="tab" data-toggle="tab">Grupo 4</a></li>
	<li role="presentation"><a href="#grupo5" aria-controls="grupo5" role="tab" data-toggle="tab">Grupo 5</a></li>
	
  </ul>


<div class="tab-content">

  <div role="tabpanel" class="tab-pane fade active" id="brief">
<?php
echo imprimirBloq($row['tipo_documento'],"Tipo de documento");
echo imprimirBloq($row['categoria'],"Categor&iacute;a");
echo imprimirBloq($row['vigencia'],"Vigencia");
?>

  </div><!-- /.tab-pane fade active -->
  
  <div role="tabpanel" class="tab-pane fade" id="grupo1">

<?php
echo imprimirBloq($row['tipo_documento'],"Tipo de documento");
echo imprimirBloq($row['categoria'],"Categor&iacute;a");
echo imprimirBloq($row['vigencia'],"Vigencia");
?>

  </div><!-- ./tab-pane fade grupo1 -->

  <div role="tabpanel" class="tab-pane fade" id="grupo2">
<?php
echo imprimirBloq($row['autor'],"Autor");
echo imprimirBloq($row['titulo'],"T&iacute;tulo");
echo imprimirBloq($row['keywords'],"Palabras Clave");
echo imprimirBloq($row['resumen'],"Resumen");
?>

  </div><!-- ./tab-pane fade grupo2 -->

  <div role="tabpanel" class="tab-pane fade" id="grupo3">

<?php
echo imprimirBloq($row['pais'],"Pa&iacute;s de publicaci&oacute;n");
echo imprimirBloq($row['fecha'],"A&ntilde;o");
echo imprimirBloq($row['revista'],"Revista");
echo imprimirBloq($row['volumen'],"Volumen"); 
echo imprimirBloq($row['articulo_numero'],"N&uacute;mero de art&iacute;culo"); 
echo imprimirBloq($row['page_start'],"P&aacute;gina Inicio");
echo imprimirBloq($row['page_end'],"P&aacute;gina Fin");
echo imprimirBloq(abs($row['page_end']-$row['page_start']),"Conteo p&aacute;ginas");
echo imprimirBloq($row['link1'],"Enlace 1");
echo imprimirBloq($row['link2'],"Enlace 2");
?>

  </div><!-- ./tab-pane fade grupo3 -->


  <div role="tabpanel" class="tab-pane fade" id="grupo4">


<table class="table">
<!--
<tr>
<td><b>-</b></td>
<td><b>Grados</b></td>
<td><b>min</b></td>
<td><b>seg</b></td>
<td><b>-</b></td>
</tr>
<tr>
<td>LATITUD</td>
<td><?=$datos_lat[0]?></td>
<td><?=$datos_lat[1]?></td>
<td><?=$datos_lat[2]?></td>
<td><b><i><?=$und_latitud?></i></b></td>
</tr>
<tr>
<td>LONGITUD</td>
<td><?=$datos_lon[0]?></td>
<td><?=$datos_lon[1]?></td>
<td><?=$datos_lon[2]?></td>
<td><b><i><?=$und_longitud?></i></b></td>
</tr>
-->
</table>
<div class="row">
<div class="col-lg-6">
<?php
//var_dump($coordenadasGD);
?>
<a href="<?=$vinculo?>" target="_blank"> Ver en mapa</a>
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->
<table class="table">
<tr>
<td><b>#</b></td>
<td><b>Especie</b></td>
<td><b>Contaminante</b></td>
<td><b>Con. M&aacute;x.</b></td>
<td><b>Con. M&iacute;n.</b></td>
<td><b>Matriz</b></td>
<td><b>Pa&iacute;s</b></td>
<td><b>Regi&oacute;n</b></td>
<td><b>Latitud</b></td>

<td><b>Longitud</b></td>

</tr>
<?php
$k = 1;
 while($row2 = $stmt2->fetch()) {
   
   // Grados en formato decimal
   $grados_latitud = $row2['lat_grados'] + $row2['lat_minutos']/60 + $row2['lat_segundos']/3600;
   $grados_longitud = $row2['lon_grados'] + $row2['lon_minutos']/60 + $row2['lon_segundos']/3600;
   
   if($row2['latitud'] == 'S') { $grados_latitud = $grados_latitud*(-1); } else {  }
   if($row2['longitud'] == 'W') { $grados_longitud = $grados_longitud*(-1); } else {  }
   
   $el_vinculo = "https://www.google.com.co/maps/place/".$grados_latitud.",".$grados_longitud;
   
   ?><tr>
     <td><?=$k?></td>
     <td><?=$row2['especie']?></td>
     <td><?=$row2['contaminante']?></td>
     <td><?=$row2['concentracion_max']?></td>
     <td><?=$row2['concentracion_min']?></td>
     <td><?=$row2['matriz']?></td>
	 <td><?=$row2['pais']?></td>
	 <td><?=$row2['region']?></td>
	 <td><?=$grados_latitud?></td>
	 <td><?=$grados_longitud?></td>
	 <td><a href="<?=$el_vinculo?>" target="_blank"><span class="glyphicon glyphicon-globe" aria-hidden="true">
	 </span></a></td>

	 
     </tr>
   <?php
 $k++;
 }
?>
</table>

  </div><!-- ./tab-pane fade grupo4 -->

  <div role="tabpanel" class="tab-pane fade" id="grupo5">

<!--  
<div class="row">
  <div class="col-md-4"><strong>Descriptor</strong></div>
  <div class="col-md-4"><strong>T. General</strong></div>
  <div class="col-md-4"><strong>T. Asociados</strong></div>
</div> --> 
  
<div class="row">
<div class="col-lg-12">
<div class="input-group">
<!--

  -->
<?php 
$datosController = array();
$datosController['id'] = $a->decrypt($_GET['token'],"tesa");

echo '<br>';


# ------- Imprimo Terminos TESAURO ----------------------------------#
  $datoTerminos = array("id"=>$datosController['id']);               #
  $terminosTesauro = $mvc->terminosTesauroController($datoTerminos); #
# -------------------------------------------------------------------#

echo '<blockquote><p>';
echo $terminosTesauro;
echo '</p></blockquote>';

 ?>  
  
</div><!-- /input-group -->
</div><!-- /.col-lg-12 -->
</div><!-- /.row -->

<?php

echo imprimirBloq($row['titulador'],"Titulador");
echo imprimirBloq($row['estado_titulacion'],"Estado titulaci&oacute;n");
echo imprimirBloq($row['fecha_entrega'],"Fecha entrega");
echo imprimirBloq($row['revision_titulacion'],"Revisi&oacute;n titulaci&oacute;n");
echo imprimirBloq($row['fecha_revision'],"Fecha revis&oacute;n");
echo imprimirBloq($row['observaciones'],"Observaciones");
echo imprimirBloq($row['notas_relacion'],"Notas relacionadas");
?>

<form method="GET" name="form1">
  <div class="form-group">
    <label class="sr-only" for="exampleInputEmail3">Correo Cc</label>
	<input type="email" class="form-control" id="exampleInputEmail3" placeholder="Cc" name="correo_destinocc">
  </div>
  <!--<a role="button" class="btn btn-info" href="http://redraus.org/tesauro_wp/wp-content/themes/naturespace/controlador/enviar_correo.php?busca_dato=<?=$row['tipo_documento']?>&correo=" target="_blank">Enviar Correo</a>-->

  <a class="btn btn-default" href="javascript:void(0);" onclick="javascript:
  function objetoAjax(){
        var xmlhttp=false;
        try {
                xmlhttp = new ActiveXObject('Msxml2.XMLHTTP');
        } catch (e) {
                try {
                   xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
                } catch (E) {
                        xmlhttp = false;
                }
        }

        if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
                xmlhttp = new XMLHttpRequest();
        }
        return xmlhttp;
}

function MostrarDatos(datos) {
 		
        ajax=objetoAjax();
        ajax.open('POST', datos);
        ajax.onreadystatechange=function() {
                
				if (ajax.readyState==3) {
				  
				}
				if (ajax.readyState==4) {
					if(ajax.responseText) {
                        //cadena = eval('('+ajax.responseText+')');
						cadena = ajax.responseText;
						document.getElementById('resultado_correo').innerHTML = cadena;
						
						
					}
						
                }
				
				
        }
        ajax.send(null)
			
}
document.getElementById('resultado_correo').innerHTML = '';
//MostrarDatos('http://redraus.org/tesauro_wp/wp-content/themes/naturespace/controlador/enviar_correo.php?busca_dato=<?=$row['autor']?>&cc='+document.form1.correo_destinocc.value+'&token=<?=$_GET['token']?>');
">Enviar Correo</a>
<div id="resultado_correo"></div>
</form>

</div><!-- ./tab-pane fade grupo5 -->

</div>


<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/bootstrap/assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="bootstrap/assets/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="bootstrap/assets/js/ie10-viewport-bug-workaround.js"></script>

</body>
</html>