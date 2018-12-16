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
$dato_especie = $_POST['InputEspecies'];
$dato_foto = $_POST['nuevo_InputFotoEspecie'];
 
//Si existe imagen y tiene un tamaño correcto
if (($nombre_img == !NULL) && ($_FILES['nuevo_InputFotoEspecie']['size'] <= 2000000) && $dato_especie!='') 
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
	  $cargue_foto->execute(array(":nombre"=>$nombre_img, ":especie"=>$dato_especie));
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

    <title>Cargar foto SICPMT</title>

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
	</script>
  </head>

<body>
<?php include("v.navbar.php"); ?>
<br><br><br>


<div class="container-fluid">
<h2>Cargar foto Especie</h2>

<form enctype="multipart/form-data" method="POST" class="form-inline">
<input type="hidden" name="usuario" value="<?=$dato_usuario?>">


<p></p>
<!-- LISTA DE ESPECIES -->
<div class="row">
<div class="col-lg-4">
  <div class="form-group">
    <label class="sr-only" for="InputEspecies"></label>
    <div class="input-group">
      <div class="input-group-addon">Especies</div>
      <select class="form-control" id="InputEspecies" name="InputEspecies" onchange="this.form.submit()">
	   <option value="<?=$dato_especie?>"><?=$dato_especie?></option>
	   <option value=""> -- </option>
	   <?php echo $b->verLista("especies"); ?>
	  </select>
	  
	  <input type="text" class="form-control" id="nuevo_InputEspecies" name="nuevo_InputEspecies" placeholder="Nuevo valor Especie" onkeyup="javascript:document.getElementById('resultado_Especies').innerHTML='';">
    </div>
	<div id="resultado_Especies"></div>
  </div>
  </div><!-- /.col-lg-8 -->



</div><!-- /.row -->
<!-- FIN LISTA DE ESPECIES -->
<?php if($dato_especie!="") { ?>

<!--<p><img src="imagenes/<?=$row_foto[0]?>"></img></p>-->
<div class='row'>
<div class='col-xs-6 col-md-4'>
    <div class='thumbnail'>
       <img src='imagenes/<?=$row_foto[0]?>' alt='...' width='171px' height='180px'>
	   <div class='caption'>
	   <h3>Actualizar</h3>
	   <input type="file" class="form-control" name="nuevo_InputFotoEspecie" required>
	   
	   <button type="submit" class="btn btn-primary" onclick="if(document.form1.InputEspecies.value=='') { alert('Debe seleccionar una especie'); return false;  } else { if(document.form1.nuevo_InputFotoEspecie.value=='') { alert('Debe seleccionar la foto'); return false; } else { this.form.action='v.foto.php'; this.form.submit(); } }">Actualizar Foto</button>
       
	   </div>
    </div>
</div>
</div>

<?php } ?>
<p></p>
<!-- LISTA DE FOTOS ESPECIES -->
<!--
<div class="row">
<div class="col-lg-4">
  <div class="form-group">
    <label class="sr-only" for="nuevo_InputFotoEspecie"></label>
    <div class="input-group">
      <div class="input-group-addon">Fotos Especies</div>
      <input type="file" class="form-control" name="nuevo_InputFotoEspecie" required>
	  <button type="submit" class="btn btn-primary" onclick="if(document.form1.InputEspecies.value=='') { alert('Debe seleccionar una especie'); return false;  } else { if(document.form1.nuevo_InputFotoEspecie.value=='') { alert('Debe seleccionar la foto'); return false; } else { this.form.action='v.foto.php'; this.form.submit(); } }">Actualizar Foto</button>
      <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
       <span class="caret"></span>
      </button>
    </div>
  </div>
</div>
-->
<!-- /.col-lg-4 -->

  <!-- Split button -->
<!--  
<div class="btn-group">
  <button type="submit" class="btn btn-primary" onclick="if(document.form1.InputEspecies.value=='') { alert('Debe seleccionar una especie'); return false;  } else { if(document.form1.nuevo_InputFotoEspecie.value=='') { alert('Debe seleccionar la foto'); return false; } else { this.form.action='v.foto.php'; this.form.submit(); } }">Actualizar Foto</button>
  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="javascript:void(0);" onclick="MostrarDropdown('c.editar_listas.php?dato='+document.form1.InputEspecies.value+'&opcion=del&use=<?=$dato_usuario?>','Especies')">default</a></li>
  </ul>
</div>
-->
</div><!-- /.row -->
<!-- FIN LISTA FOTOS DE ESPECIES -->

<p></p>


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