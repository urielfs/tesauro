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

include_once(dirname(dirname(__FILE__))."/controlador/editar_registro_4.php");

// Consulto los datos en base al ID para edicion
$stmt_datos = $db->prepare("select * from tesauro where id=:id");
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
						
						if(cadena.tok=="true") {
							document.getElementById('resultado_'+entrada).innerHTML = cadena.resultado;
							document.getElementById('nuevo_Input'+entrada).value = "";
						}
						else {
						option.value = cadena.dato_v;
						option.text = cadena.dato_t;
						
						document.getElementById('Input'+entrada).appendChild(option);
						//document.getElementById('InputTerminoEspecifico').innerHTML = "<select name='InputTerminoEspecifico' id='InputTerminoEspecifico' class='form-control' aria-describedby='basic-addon1'>"+cadena.datoTE+"</select>";
						document.getElementById('resultado_'+entrada).innerHTML = cadena.resultado;
						document.getElementById('nuevo_Input'+entrada).value = "";
						}
						
						if(cadena.opcion=="borrado")
						{
							//document.getElementById('Input'+entrada).find('option[cadena.valor]').remove();
							document.getElementById('Input'+entrada).options[document.getElementById('Input'+entrada).selectedIndex] = null;
							//document.getElementById('InputTerminoEspecifico').innerHTML = "<select name='InputTerminoEspecifico' id='InputTerminoEspecifico' class='form-control' aria-describedby='basic-addon1'>"+cadena.datoTE+"</select>";
							document.getElementById('resultado_'+entrada).innerHTML = cadena.resultado;
						}
					}
						
                }
				
				
        }
        ajax.send(null)
		
}

function MostrarDatos(datos,entrada) {
 		
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
						var x=document.getElementById('Input'+entrada);
						
						x.options = cadena.opciones;
					
						
					}
						
                }
				
				
        }
        ajax.send(null)
		
}

function MostrarTerminos(datos)
{
        ajax=objetoAjax();
        ajax.open("POST", datos);
        ajax.onreadystatechange=function() {
                
				if (ajax.readyState==3) {
				  //carga.style.visibility = 'visible';
				}
				if (ajax.readyState==4) {
					if(ajax.responseText) {
                        cadena = eval("("+ajax.responseText+")");
						
						document.getElementById('lista_Descriptores').innerHTML = cadena.descriptores;
						document.getElementById('lista_Elementos').innerHTML = cadena.elementos;
						
					}
						
                }
				
				
        }
        ajax.send(null)
}

function MostrarTE(datos)
{
        ajax=objetoAjax();
        ajax.open("POST", datos);
        ajax.onreadystatechange=function() {
                
				if (ajax.readyState==3) {
				  //carga.style.visibility = 'visible';
				}
				if (ajax.readyState==4) {
					if(ajax.responseText) {
                        cadena = eval("("+ajax.responseText+")");
						
						
						//document.getElementById('InputTerminoEspecifico').appendChild = cadena.datoTE;
						document.getElementById('InputTerminoEspecifico').innerHTML = "";
						document.getElementById('resultado_TerminoEspecifico').innerHTML = cadena.resultado;
						document.getElementById('InputTerminoEspecifico').innerHTML = "<select name='InputTerminoEspecifico' id='InputTerminoEspecifico' class='form-control' aria-describedby='basic-addon1'>"+cadena.datoTE+"</select>";
						
					}
						
                }
				
				
        }
        ajax.send(null)
}
	</script>	

  </head>
  
<body>
<?php $activo=5; ?>
<?php include("v.navbar.php"); ?>

<div class="container container-fluid">
<h2>Grupo 5</h2>

<form method="POST" name="form1" class="form-horizontal" action="v.editar_datos_6.php?usuario=<?=$_GET["usuario"]?>&token=<?=$_GET["token"]?>">

<div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-title">T&eacute;rminos Tesauro</h3>
  </div>
  <div class="panel-body">
    <div class="row">
    <div class="col-xs-10 col-md-10">
    <div class="input-group">
	<label class="sr-only" for="InputTerminoGeneral"></label>
     <select class="form-control" aria-describedby="basic-addon1" name="InputTerminoGeneral" id="InputTerminoGeneral" onchange="javascript:this.form.action='v.editar_datos_5.php?usuario=<?=$_GET["usuario"]?>&token=<?=$_GET["token"]?>'; this.form.InputDescriptor.value=''; this.form.submit();">
	  <option value="<?=$_POST["InputTerminoGeneral"]?>"><?=$b->get_Tesauro("TG",$_POST["InputTerminoGeneral"])?></option>
	  <option value=""> -- </option>
	  <?=$b->ver_TG($a->decrypt($_GET['token'],"tesa"))?>
	 </select>
	 <input type="text" class="form-control" name="nuevo_InputTerminoGeneral" id="nuevo_InputTerminoGeneral" placeholder="Nuevo T&eacute;rmino general">
     <span class="input-group-addon" id="basic-addon1">T&eacute;rmino General</span>
	 
    </div><!-- /input-group -->
	
	    <!-- Split button -->
<div class="btn-group">
  <button type="button" class="btn btn-primary" onclick="MostrarDropdown('c.editar_tesauro.php?dato='+this.form.nuevo_InputTerminoGeneral.value+'&item=TG&id_t=<?=$_GET['token']?>','TerminoGeneral')">Agregar T&eacute;rmino general</button>
  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="javascript:void(0);" onclick="MostrarDropdown('c.editar_tesauro.php?dato='+document.form1.InputTerminoGeneral.value+'&opcion=del&id_t=<?=$_GET['token']?>','TerminoGeneral')">Borrar T&eacute;rmino general</a></li>
  </ul>
</div><!-- /.btn-group -->
<div id="resultado_TerminoGeneral"></div>
    </div><!-- /.col-xs-6 -->
    </div><!-- /.row -->
	
	
	<br/>
    <div class="row">
    <div class="col-xs-10 col-md-10">
    <div class="input-group">
	<label class="sr-only" for="InputDescriptor"></label>
     <select class="form-control" aria-describedby="basic-addon1" name="InputDescriptor" id="InputDescriptor" onchange="javascript:MostrarTerminos('c.terminos_elementos.php?usuario=<?=$_GET["usuario"]?>&id_t=<?=$_GET["token"]?>&descriptor='+document.form1.InputDescriptor.value+'&datotg='+document.form1.InputTerminoGeneral.value)">
	 <option value="<?=$_POST["InputDescriptor"]?>"><?=$b->get_Tesauro("descriptor",$_POST["InputDescriptor"])?></option>
	 <option value=""> -- </option>
	 <?php echo $b->ver_Descriptor($a->decrypt($_GET['token'],"tesa"),$b->get_Tesauro("TG",$_POST["InputTerminoGeneral"])); ?>
	 </select>
	 <input type="text" class="form-control" name="nuevo_InputDescriptor" id="nuevo_InputDescriptor" placeholder="Nuevo Descriptor">
     <span class="input-group-addon" id="basic-addon1">Descriptores</span>
	 
    </div><!-- /input-group -->
		    <!-- Split button -->
<div class="btn-group">
  <button type="button" class="btn btn-primary" onclick="MostrarDropdown('c.editar_tesauro_tg.php?dato='+this.form.nuevo_InputDescriptor.value+'&datotg='+document.form1.InputTerminoGeneral.value+'&item=descriptor&use=<?=$_GET["usuario"]?>&id_t=<?=$_GET["token"]?>','Descriptor')">Agregar Descriptor</button>
  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="javascript:void(0);" onclick="MostrarDropdown('c.editar_tesauro_tg.php?datoB='+document.form1.InputDescriptor.value+'&opcion=del&datotg='+document.form1.InputTerminoGeneral.value+'&id_t=<?=$_GET["token"]?>','Descriptor')">Borrar Descriptor</a></li>
  </ul>
</div><!-- /.btn-group -->
<div id="resultado_Descriptor"></div>
    </div><!-- /.col-xs-6 -->
    </div><!-- /.row -->
	<br/>
    <div class="row">
    <div class="col-xs-10 col-md-10">
    <div class="input-group">
     <select class="form-control" aria-describedby="basic-addon1" name="InputTipo" id="InputTipo" onchange="MostrarTE('c.mostrar_elementos.php?datodes='+document.form1.InputDescriptor.value+'&datotg='+document.form1.InputTerminoGeneral.value+'&dato='+document.form1.InputTipo.value+'&id_t=<?=$_GET["token"]?>')">
	  <option value="TE">TE</option>
	  <option value="TR">TR</option>
	  <option value="NA">NA</option>
	  <option value="UP">UP</option>
	  <option value="TC">TC</option>
	  <option value="TTG">TTG</option>
	  <option value="TEG">TEG</option>
	  <option value="TGP">TGP</option>
	  <option value="USE_for">USE_for</option>
	 </select>
	 <select class="form-control" aria-describedby="basic-addon1" name="InputTerminoEspecifico" id="InputTerminoEspecifico">
	  <option value=""> -- </option>
	 </select>
	 <!--<div id="InputTerminoEspecifico"></div>-->
	 <input type="text" class="form-control" name="nuevo_InputTerminoEspecifico" id="nuevo_InputTerminoEspecifico" placeholder="Nuevo T&eacute;rmino Espec&iacute;fico">
     <span class="input-group-addon" id="basic-addon1">T&eacute;rmino Espec&iacute;fico</span>
	 
    </div><!-- /input-group -->
		    <!-- Split button -->
<div class="btn-group">
  <button type="button" class="btn btn-primary" onclick="MostrarDropdown('c.editar_tesauro_te.php?dato='+this.form.nuevo_InputTerminoEspecifico.value+'&datodes='+document.form1.InputDescriptor.value+'&datotg='+document.form1.InputTerminoGeneral.value+'&use=<?=$_GET["usuario"]?>&id_t=<?=$_GET["token"]?>&item='+document.form1.InputTipo.value,'TerminoEspecifico')">Agregar TE</button>
  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="javascript:void(0);" onclick="MostrarDropdown('c.editar_tesauro_te.php?dato='+document.form1.InputTerminoEspecifico.value+'&opcion=del&use=<?=$_GET["usuario"]?>&id_t=<?=$_GET["token"]?>','TerminoEspecifico')">Borrar TE</a></li>
  </ul>
</div><!-- /.btn-group -->
<div id="resultado_TerminoEspecifico"></div>
    </div><!-- /.col-xs-6 -->
    </div><!-- /.row -->
	<div class="row">
	 <div class="col-xs-6" id="lista_Descriptores"></div>
	 <div class="col-xs-6" id="lista_Elementos"></div>
	</div>
	</div><!-- /.panel-heading -->

</div><!-- /.panel panel-default -->

<div class="panel panel-default">
  <div class="panel-heading">Generales</div>
  <div class="panel-body">

<div class="row">
<div class="col-lg-8">
<div class="input-group">
  <input type="text" class="form-control" aria-describedby="basic-addon1" value="<?=$row_stmt_datos["titulador"]?>" name="titulador">
  <span class="input-group-addon" id="basic-addon1">Titulador</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->


<div class="row">
<div class="col-lg-8">
<div class="input-group">
  <input type="text" class="form-control" aria-describedby="basic-addon1" value="<?=$row_stmt_datos["estado_titulacion"]?>" name="estado_titulacion">
  <span class="input-group-addon" id="basic-addon1">Estado titulaci&oacute;n</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
<div class="col-lg-8">
<div class="input-group">
  <input type="date" class="form-control" aria-describedby="basic-addon1" value="<?=$row_stmt_datos["fecha_entrega"]?>" name="fecha_entrega">
  <span class="input-group-addon" id="basic-addon1">Fecha Entrega</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->


<div class="row">
<div class="col-lg-8">
<div class="input-group">
  <input type="text" class="form-control" aria-describedby="basic-addon1" value="<?=$row_stmt_datos["revision_titulacion"]?>" name="revision_titulacion">
  <span class="input-group-addon" id="basic-addon1">Revisi&oacute;n titulaci&oacute;n</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->


<div class="row">
<div class="col-lg-8">
<div class="input-group">
  <input type="date" class="form-control" aria-describedby="basic-addon1" value="<?=$row_stmt_datos["fecha_revision"]?>" name="fecha_revision">
  <span class="input-group-addon" id="basic-addon1">Fecha revisi&oacute;n</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->


<div class="row">
<div class="col-lg-8">
<div class="input-group">
  <textarea class="form-control" aria-describedby="basic-addon1" name="observaciones" rows="3"><?=$row_stmt_datos["observaciones"]?></textarea>
  <span class="input-group-addon" id="basic-addon1">Observaciones</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->


<div class="row">
<div class="col-lg-8">
<div class="input-group">
  <textarea class="form-control" aria-describedby="basic-addon1" name="notas_relacion"><?=$row_stmt_datos[7]?></textarea>
  <span class="input-group-addon" id="basic-addon1">Notas relaci&oacute;n</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

</div><!-- /.panel-body -->
</div><!-- /.panel panel-default -->

<div class="row">
<div class="col-lg-8">
<div class="input-group">
<input type="hidden" name="toke">
<input type="submit" value="Guardar y Terminar" class="btn btn-danger" onClick="javascript:this.form.toke.value='act';">
<!--<input type="hidden" name="token" value="<?=$_POST['token']?>" />-->
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

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