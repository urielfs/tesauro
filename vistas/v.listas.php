<?php
//header('Content-Type: text/html; charset=ISO-8859-1');
require_once(dirname(dirname(__FILE__))."/iniciar.php");

if($_POST['usuario']!='')
{
	$dato_usuario = $_POST['usuario'];
}
if($_GET['usuario']!='')
{
	$dato_usuario = $_GET['usuario'];
}

if($dato_usuario!='')
{
	$b->validaUsuario($a->decrypt($dato_usuario,"dos"));
	
	// Inserto nuevo registro
	if($_GET["peticion"]=="ok") {
		
		$sql = $db->prepare("insert into tesauro(usuario,fecha_act) values(:usuario,:fecha)");
		$sql->execute(array(":usuario"=>$a->decrypt($dato_usuario,"dos"), ":fecha"=>date("Y-m-d H:i:s")));
		
		$puntero = $b->consulta_sql("tesauro","MAX(id)","");
		$puntero = $puntero->fetch();
		
	}
	
	if($_GET["token"]!="") {
			
			$id_sincronizado = $_GET["token"];
	}
	else {
			
			$id_sincronizado = $a->encrypt($puntero[0],"tesa");
	}
		
}
else {
	echo "Sesion cerrada <a href='../index.php' role='link'>Inicio</a>";
	exit;
}

//............Rutina para Cargar Foto..............
// Verifico la Imagen cargada y si cumple con los parámetros se ingresa..
// Recibo los datos de la imagen
$nombre_img = $_FILES['nuevo_InputFotoEspecie']['name'];
$tipo = $_FILES['nuevo_InputFotoEspecie']['type'];
$tamano = $_FILES['nuevo_InputFotoEspecie']['size'];
$dato_especie = $_GET['InputEspecies'];
 
//Si existe imagen y tiene un tamaño correcto
if (($nombre_img == !NULL) && ($_FILES['nuevo_InputFotoEspecie']['size'] <= 2000000) && $_POST['inputEspecies']!='') 
{
   //indicamos los formatos que permitimos subir a nuestro servidor
   if (($_FILES["nuevo_InputFotoEspecie"]["type"] == "image/gif")
   || ($_FILES["nuevo_InputFotoEspecie"]["type"] == "image/jpeg")
   || ($_FILES["nuevo_InputFotoEspecie"]["type"] == "image/jpg")
   || ($_FILES["nuevo_InputFotoEspecie"]["type"] == "image/png"))
   {
      // Ruta donde se guardarán las imágenes que subamos
      $directorio = dirname(dirname(__FILE__)).'/vistas/imagenes/';
      // Muevo la imagen desde el directorio temporal a nuestra ruta indicada anteriormente
      move_uploaded_file($_FILES['nuevo_InputFotoEspecie']['tmp_name'],$directorio.$nombre_img);
	  
	  // Nombre de la imagen asociada a la especies
	  $cargue_foto = $db->prepare("update tesauro_cstm set valor2=:nombre where valor=:especie && label='especies'");
	  $cargue_foto->execute(array(":nombre"=>$nombre_img, ":especie"=>$_POST["InputEspecies"]));
    } 
    else 
    {
       //si no cumple con el formato
       echo "No se puede subir una imagen con ese formato ";
    }
} 
else 
{
   //si existe la variable pero se pasa del tamaño permitido
   if($nombre_img == !NULL) echo "La imagen ".$nombre_img." es demasiado grande "; 
}

//............Fin cargue foto......................

//................................Consulto foto disponible para la Especie...........
$sql_foto = $db->prepare("select valor2 from tesauro_cstm where label='especies' && valor=:valor");
$sql_foto->execute(array(":valor"=>$dato_especie));
$row_foto = $sql_foto->fetch();
//...................................................................................

?>
<!DOCTYPE html>
<html lang="en">
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
function MostrarDropdown(datos,entrada) {
 		
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
							document.getElementById('nuevo_Input'+entrada).value = "";
						}
						else {
						option.value = cadena.dato_v;
						option.text = cadena.dato_t;
						
						document.getElementById('Input'+entrada).appendChild(option);
						document.getElementById('resultado_'+entrada).innerHTML = cadena.resultado;
						document.getElementById('nuevo_Input'+entrada).value = "";
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
<?php include("v.navbar.php"); ?>
<br><br><br>


<div class="container-fluid">
<h2>Listas desplegables</h2>

<form enctype="multipart/form-data" class="form-inline" name="form1">
<input type="hidden" name="usuario" value="<?=$dato_usuario?>">
<p></p>

<!-- LISTA DE MATRIZ -->
<div class="row">
<div class="col-lg-4">
  <div class="form-group">
    <label class="sr-only" for="InputMatriz"></label>
    <div class="input-group">
      <div class="input-group-addon">MATRIZ</div>
      <select class="form-control" id="InputMatriz" name="InputMatriz">
	   <option value=""> -- </option>
	   <?php echo $b->verLista("matriz"); ?>
	  </select>
	  <input type="text" class="form-control" id="nuevo_InputMatriz" name="nuevo_InputMatriz" placeholder="Nuevo valor Matriz" onkeyup="javascript:document.getElementById('resultado_Matriz').innerHTML='';">
    </div>
	<div id="resultado_Matriz"></div>
  </div>
  </div><!-- /.col-lg-8 -->

  <!-- Split button -->
<div class="btn-group">
  <button type="button" class="btn btn-primary" onclick="MostrarDropdown('c.editar_listas.php?dato='+this.form.nuevo_InputMatriz.value+'&item=matriz&use=<?=$_GET["usuario"]?>','Matriz')">Agregar Matriz</button>
  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="javascript:void(0);" onclick="MostrarDropdown('c.editar_listas.php?dato='+document.form1.InputMatriz.value+'&opcion=del&use=<?=$_GET["usuario"]?>','Matriz')">Borrar Matriz</a></li>
  </ul>
</div><!-- /.btn-group -->

</div><!-- /.row -->
<!-- FIN LISTA DE MATRIZ -->

<p></p>
<!-- LISTA DE ESPECIES -->
<div class="row">
<div class="col-lg-4">
  <div class="form-group">
    <label class="sr-only" for="InputEspecies"></label>
    <div class="input-group">
      <div class="input-group-addon">Especies</div>
      <select class="form-control" id="InputEspecies" name="InputEspecies" onchange="this.form.submit()">
	   <option value="<?=$_GET['InputEspecies']?>"><?=$_GET['InputEspecies']?></option>
	   <option value=""> -- </option>
	   <?php echo $b->verLista("especies"); ?>
	  </select>
	  
	  <input type="text" class="form-control" id="nuevo_InputEspecies" name="nuevo_InputEspecies" placeholder="Nuevo valor Especie" onkeyup="javascript:document.getElementById('resultado_Especies').innerHTML='';">
    </div>
	<div id="resultado_Especies"></div>
  </div>
  </div><!-- /.col-lg-8 -->

  <!-- Split button -->
<div class="btn-group">
  <button type="button" class="btn btn-primary" onclick="MostrarDropdown('c.editar_listas.php?dato='+document.form1.nuevo_InputEspecies.value+'&dato2=&item=especies&use=<?=$dato_usuario?>','Especies')">Agregar Especie</button>
  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="javascript:void(0);" onclick="MostrarDropdown('c.editar_listas.php?dato='+document.form1.InputEspecies.value+'&opcion=del&use=<?=$dato_usuario?>','Especies')">Borrar Especie</a></li>
  </ul>
</div><!-- /.btn-group -->

</div><!-- /.row -->
<!-- FIN LISTA DE ESPECIES -->

<!--<p><img src="imagenes/<?=$row_foto[0]?>"></img></p>-->
<div class='row'>
<div class='col-xs-6 col-md-3'>
              <a href='#' class='thumbnail'>
              <img src='imagenes/<?=$row_foto[0]?>' alt='...' width='171px' heigth='180px'>
              </a>
</div>
</div>
<p></p>
<!-- LISTA DE CONTAMINANTES -->
<div class="row">
<div class="col-lg-4">
  <div class="form-group">
    <label class="sr-only" for="InputContaminantes"></label>
    <div class="input-group">
      <div class="input-group-addon">Contaminantes</div>
      <select class="form-control" id="InputContaminantes" name="InputContaminantes">
	   <option value=""> -- </option>
	   <?php echo $b->verLista("contaminantes"); ?>
	  </select>
	  <input type="text" class="form-control" id="nuevo_InputContaminantes" name="nuevo_InputContaminantes" placeholder="Nuevo valor Contaminante" onkeyup="javascript:document.getElementById('resultado_Contaminantes').innerHTML='';">
    </div>
	<div id="resultado_Contaminantes"></div>
  </div>
  </div><!-- /.col-lg-8 -->

  <!-- Split button -->
<div class="btn-group">
  <button type="button" class="btn btn-primary" onclick="MostrarDropdown('c.editar_listas.php?dato='+document.form1.nuevo_InputContaminantes.value+'&item=contaminantes&use=<?=$_GET["usuario"]?>','Contaminantes')">Agregar Contaminante</button>
  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="javascript:void(0);" onclick="MostrarDropdown('c.editar_listas.php?dato='+document.form1.InputContaminantes.value+'&opcion=del&use=<?=$_GET["usuario"]?>','Contaminantes')">Borrar Contaminante</a></li>
  </ul>
</div><!-- /.btn-group -->
</div><!-- /.row -->

<!-- FIN LISTA DE CONTAMINANTES -->

<p></p>
<!-- LISTA DE CONCENTRACION -->
<div class="row">
<div class="col-lg-4">
  <div class="form-group">
    <label class="sr-only" for="InputConcentracion"></label>
    <div class="input-group">
      <div class="input-group-addon">Concentraci&oacute;n</div>
      <select class="form-control" id="InputConcentracion" name="InputConcentracion">
	   <option value=""> -- </option>
	   <?php echo $b->verLista("concentracion"); ?>
	  </select>
	  <input type="text" class="form-control" id="nuevo_InputConcentracion" name="nuevo_InputConcentracion" placeholder="Nuevo valor Concentraci&oacute;n" onkeyup="javascript:document.getElementById('resultado_Concentracion').innerHTML='';">
    </div>
	<div id="resultado_Concentracion"></div>
  </div>
  </div><!-- /.col-lg-8 -->

  <!-- Split button -->
<div class="btn-group">
  <button type="button" class="btn btn-primary" onclick="MostrarDropdown('c.editar_listas.php?dato='+document.form1.nuevo_InputConcentracion.value+'&item=concentracion&use=<?=$_GET["usuario"]?>','Concentracion')">Agregar Concentraci&oacute;n</button>
  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="javascript:void(0);" onclick="MostrarDropdown('c.editar_listas.php?dato='+document.form1.InputConcentracion.value+'&opcion=del&use=<?=$_GET["usuario"]?>','Concentracion')">Borrar Concentraci&oacute;n</a></li>
  </ul>
</div><!-- /.btn-group -->
</div><!-- /.row -->

<!-- FIN LISTA DE CONCENTRACION -->

<p></p>
<!-- LISTA DE UNIDADES CONCENTRACION -->
<div class="row">
<div class="col-lg-4">
  <div class="form-group">
    <label class="sr-only" for="InputUndConcentracion"></label>
    <div class="input-group">
      <div class="input-group-addon">Unidades Concentraci&oacute;n</div>
      <select class="form-control" id="InputUndConcentracion" name="InputUndConcentracion">
	   <option value=""> -- </option>
	   <?php echo $b->verLista("undconcentracion"); ?>
	  </select>
	  <input type="text" class="form-control" id="nuevo_InputUndConcentracion" name="nuevo_InputUndConcentracion" placeholder="Nueva Unidad Concentraci&oacute;n" onkeyup="javascript:document.getElementById('resultado_UndConcentracion').innerHTML='';">
    </div>
	<div id="resultado_UndConcentracion"></div>
  </div>
  </div><!-- /.col-lg-8 -->

  <!-- Split button -->
<div class="btn-group">
  <button type="button" class="btn btn-primary" onclick="MostrarDropdown('c.editar_listas.php?dato='+document.form1.nuevo_InputUndConcentracion.value+'&item=undconcentracion&use=<?=$_GET["usuario"]?>','UndConcentracion')">Agregar Unidades Concentraci&oacute;n</button>
  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="javascript:void(0);" onclick="MostrarDropdown('c.editar_listas.php?dato='+document.form1.InputUndConcentracion.value+'&opcion=del&use=<?=$_GET["usuario"]?>','UndConcentracion')">Borrar Unidades Concentraci&oacute;n</a></li>
  </ul>
</div><!-- /.btn-group -->
</div><!-- /.row -->

<!-- FIN LISTA DE UNIDADES CONCENTRACION -->

<p></p>
<!-- LISTA DE CATEGORIA -->
<div class="row">
<div class="col-lg-4">
  <div class="form-group">
    <label class="sr-only" for="InputCategoria"></label>
    <div class="input-group">
      <div class="input-group-addon">Categor&iacute;a</div>
      <select class="form-control" id="InputCategoria" name="InputCategoria">
	   <option value=""> -- </option>
	   <?php echo $b->verLista("categoria"); ?>
	  </select>
	  <input type="text" class="form-control" id="nuevo_InputCategoria" name="nuevo_InputCategoria" placeholder="Nuevo valor Categor&iacute;a" onkeyup="javascript:document.getElementById('resultado_Categoria').innerHTML='';">
    </div>
	<div id="resultado_Categoria"></div>
  </div>
  </div><!-- /.col-lg-8 -->

  <!-- Split button -->
<div class="btn-group">
  <button type="button" class="btn btn-primary" onclick="MostrarDropdown('c.editar_listas.php?dato='+document.form1.nuevo_InputCategoria.value+'&item=categoria&use=<?=$_GET["usuario"]?>','Categoria')">Agregar Categor&iacute;a</button>
  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="javascript:void(0);" onclick="MostrarDropdown('c.editar_listas.php?dato='+document.form1.InputCategoria.value+'&opcion=del&use=<?=$_GET["usuario"]?>','Categoria')">Borrar Categor&iacute;a</a></li>
  </ul>
</div><!-- /.btn-group -->
</div><!-- /.row -->

<!-- FIN LISTA DE CATEGORIA -->

<p></p>
<!-- LISTA DE TIPO DOCUMENTO -->
<div class="row">
<div class="col-lg-4">
  <div class="form-group">
    <label class="sr-only" for="InputTipoDocumento"></label>
    <div class="input-group">
      <div class="input-group-addon">Tipo Doc.</div>
      <select class="form-control" id="InputTipoDocumento" name="InputTipoDocumento">
	   <option value=""> -- </option>
	   <?php echo $b->verLista("tipo_documento"); ?>
	  </select>
	  <input type="text" class="form-control" id="nuevo_InputTipoDocumento" name="nuevo_InputTipoDocumento" placeholder="Nuevo valor Tipo Doc." onkeyup="javascript:document.getElementById('resultado_TipoDocumento').innerHTML='';">
    </div>
	<div id="resultado_TipoDocumento"></div>
  </div>
  </div><!-- /.col-lg-8 -->

  <!-- Split button -->
<div class="btn-group">
  <button type="button" class="btn btn-primary" onclick="MostrarDropdown('c.editar_listas.php?dato='+document.form1.nuevo_InputTipoDocumento.value+'&item=tipo_documento&use=<?=$_GET["usuario"]?>','TipoDocumento')">Agregar Tipo Doc.</button>
  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="javascript:void(0);" onclick="MostrarDropdown('c.editar_listas.php?dato='+document.form1.InputTipoDocumento.value+'&opcion=del&use=<?=$_GET["usuario"]?>','TipoDocumento')">Borrar Tipo Doc.</a></li>
  </ul>
</div><!-- /.btn-group -->
</div><!-- /.row -->

<!-- FIN LISTA DE TIPO DOCUMENTO -->

<p></p>
<!-- LISTA DE ESTADO TITULACION -->
<div class="row">
<div class="col-lg-4">
  <div class="form-group">
    <label class="sr-only" for="InputEstadoTitulacion"></label>
    <div class="input-group">
      <div class="input-group-addon">Estado Titulaci&oacute;n</div>
      <select class="form-control" id="InputEstadoTitulacion" name="InputEstadoTitulacion">
	   <option value=""> -- </option>
	   <?php echo $b->verLista("estado_titulacion"); ?>
	  </select>
	  <input type="text" class="form-control" id="nuevo_InputEstadoTitulacion" name="nuevo_InputEstadoTitulacion" placeholder="Nuevo valor Estado Titulaci&oacute;n" onkeyup="javascript:document.getElementById('resultado_EstadoTitulacion').innerHTML='';">
    </div>
	<div id="resultado_EstadoTitulacion"></div>
  </div>
  </div><!-- /.col-lg-8 -->

  <!-- Split button -->
<div class="btn-group">
  <button type="button" class="btn btn-primary" onclick="MostrarDropdown('c.editar_listas.php?dato='+document.form1.nuevo_InputEstadoTitulacion.value+'&item=estado_titulacion&use=<?=$_GET["usuario"]?>','EstadoTitulacion')">(+) Estado Titulaci&oacute;n</button>
  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="javascript:void(0);" onclick="MostrarDropdown('c.editar_listas.php?dato='+document.form1.InputEstadoTitulacion.value+'&opcion=del&use=<?=$_GET["usuario"]?>','EstadoTitulacion')">Borrar Estado Titulaci&oacute;n</a></li>
  </ul>
</div><!-- /.btn-group -->
</div><!-- /.row -->

<!-- FIN LISTA ESTADO TITULACION -->

<p></p>
<!-- LISTA DE ARTICULO NUMERO -->
<div class="row">
<div class="col-lg-4">
  <div class="form-group">
    <label class="sr-only" for="InputArticuloNumero"></label>
    <div class="input-group">
      <div class="input-group-addon">Art&iacute;culo N&uacute;m.</div>
      <select class="form-control" id="InputArticuloNumero" name="InputArticuloNumero">
	   <option value=""> -- </option>
	   <?php echo $b->verLista("articulo_numero"); ?>
	  </select>
	  <input type="text" class="form-control" id="nuevo_InputArticuloNumero" name="nuevo_InputArticuloNumero" placeholder="Nuevo valor Art&iacute;culo N&uacute;mero" onkeyup="javascript:document.getElementById('resultado_ArticuloNumero').innerHTML='';">
    </div>
	<div id="resultado_ArticuloNumero"></div>
  </div>
  </div><!-- /.col-lg-8 -->

  <!-- Split button -->
<div class="btn-group">
  <button type="button" class="btn btn-primary" onclick="MostrarDropdown('c.editar_listas.php?dato='+document.form1.nuevo_InputArticuloNumero.value+'&item=articulo_numero&use=<?=$_GET["usuario"]?>','ArticuloNumero')">Agregar Art&iacute;culo N&uacute;mero</button>
  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="javascript:void(0);" onclick="MostrarDropdown('c.editar_listas.php?dato='+document.form1.InputArticuloNumero.value+'&opcion=del&use=<?=$_GET["usuario"]?>','ArticuloNumero')">Borrar Art&iacute;culo N&uacute;mero</a></li>
  </ul>
</div><!-- /.btn-group -->
</div><!-- /.row -->

<!-- FIN LISTA ARTICULO NUMERO -->

<p></p>
<!-- LISTA DE PUBLICACION -->
<div class="row">
<div class="col-lg-4">
  <div class="form-group">
    <label class="sr-only" for="InputPublicacion"></label>
    <div class="input-group">
      <div class="input-group-addon">Publicaci&oacute;n</div>
      <select class="form-control" id="InputPublicacion" name="InputPublicacion">
	   <option value=""> -- </option>
	   <?php echo $b->verLista("publicacion"); ?>
	  </select>
	  <input type="text" class="form-control" id="nuevo_InputPublicacion" name="nuevo_InputPublicacion" placeholder="Nuevo valor Publicaci&oacute;n" onkeyup="javascript:document.getElementById('resultado_Publicacion').innerHTML='';">
    </div>
	<div id="resultado_Publicacion"></div>
  </div>
  </div><!-- /.col-lg-8 -->

  <!-- Split button -->
<div class="btn-group">
  <button type="button" class="btn btn-primary" onclick="MostrarDropdown('c.editar_listas.php?dato='+document.form1.nuevo_InputPublicacion.value+'&item=publicacion&use=<?=$_GET["usuario"]?>','Publicacion')">Agregar Publicaci&oacute;n</button>
  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="javascript:void(0);" onclick="MostrarDropdown('c.editar_listas.php?dato='+document.form1.InputPublicacion.value+'&opcion=del&use=<?=$_GET["usuario"]?>','Publicacion')">Borrar Publicaci&oacute;n</a></li>
  </ul>
</div><!-- /.btn-group -->
</div><!-- /.row -->

<!-- FIN LISTA PUBLICACION -->

<p></p>


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