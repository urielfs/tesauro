<?php

/*
|--------------------------------------------------------------|
| Editar datos PESTAÑA 5                                       |
| Solo se modifican datos si el usuario esta logueado          |
|--------------------------------------------------------------|
*/

// Nombre Campos a actualizar
   $campos = "titulador=:titulador,
			  estado_titulacion=:estado_titulacion,
			  fecha_entrega=:fecha_entrega,
			  fecha_revision=:fecha_revision,
			  observaciones=:observaciones,
			  notas_relacion=:notas_relacion,
			  revision_titulacion=:revision,
			  status=:status,
			  fecha_act=:fecha_act";



$stmt2 = $db->prepare("select usuario,titulo from tesauro where usuario=:usuario");
$stmt2->execute(array(":usuario"=>$a->decrypt($_GET["usuario"],"dos")));
$row2 = $stmt2->fetch();

  if($a->decrypt($_GET["usuario"],"dos") == $row2[0] && $_POST["toke"]=="act")
  {
    $id_puntero = $a->decrypt($_GET['token'],"tesa");
    
    
    $stmt2 = $db->prepare("update tesauro set $campos where id=:puntero");
    if($stmt2->execute(array(':titulador'=>$_POST['titulador'],
						  ':estado_titulacion'=>$_POST['estado_titulacion'],
						  ':fecha_entrega'=>$_POST['fecha_entrega'],
						  ':fecha_revision'=>$_POST['fecha_revision'],
						  ':observaciones'=>$_POST['observaciones'],
						  ':notas_relacion'=>$_POST['notas_relacion'],
						  ':revision'=>$_POST['revision_titulacion'],
						  ':status'=>'OK',
						  ':fecha_act'=>date('Y-m-d H:i:s'),
                          ':puntero'=>$id_puntero)))
	{
		
// ---------    Envio notificacion a marlenny.diaz@usa.edu.co,     -----------------------------------
// ---------    si la Revision Titulacion tiene mas de 3 caracteres		------------------------------
		
		$envio_titulacion = strlen($_POST['revision_titulacion']);
		if($envio_titulacion > 3)
		{
			$datoTerminos = array("id"=>$id_puntero);
			$terminosTesauro = $mvc->terminosTesauroController($datoTerminos);
			
			$envio_mensaje = "Artículo: <b>".$row2[1]."</b>";
			$envio_mensaje .= "<p>Titulador: <b>".$_POST['titulador']."</b></p>";
			$envio_mensaje .= "<p>Estado: <b>".$_POST['estado_titulacion']."</b></p>";
			$envio_mensaje .= "<p>Fecha revisi&oacute;n: <b>".$_POST['fecha_revision']."</b></p>";
			$envio_mensaje .= "<p>Revisi&oacute;n: <b>".$_POST['revision_titulacion']."</b></p>";
			$envio_mensaje .= "<br>".$terminosTesauro;
			$dato = $b->envioCorreo("marlenny.diaz@usa.edu.co",$envio_mensaje);
		}
// ---------------------------------------------------------------------------------------------------		
		?>
		<div>Registro editado correctamente</div>
		<div class="progress">
		<div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">100%</div>
        </div>
		<?php				
	}
					
/*
|----------------------------------------------------------------------|
|  Verifico que todos los campos tengan dato registrado                |
|  Si al menos un (1) campo esta vacio, se deja el registro pendiente  |
|----------------------------------------------------------------------|
*/

$sql = $db->prepare("select tipo_documento,
categoria,
autor,
titulo,
fecha,
keywords,
resumen,
pais,
volumen,
issue,
articulo_numero,
page_start,
page_end,
page_count,
vigencia,
link1,
link2,
pais_muestreo,
region,
latitud,
longitud,
unidades,
notas_relacion,
titulador,
revision_titulacion,
fecha_revision,
estado_titulacion,
observaciones,
fecha_entrega,
nombre_publicacion
from tesauro where id=:id");
$sql->execute(array(":id"=>$id_puntero));
$row = $sql->fetch(PDO::FETCH_ASSOC);
$error = false;
$resultado = "";

  foreach($row as $clave=>$valor) {
	  if($valor == "") {
		  $error = true;
		  $resultado .= "Valor pendiente: ".$clave."<br>";
	  }
  }
  
  if($error == true) {
	  
	  $sql2 = $db->prepare("update tesauro set status='pendiente' where id=:id");
	  $sql2->execute(array(":id"=>$id_puntero));
  }
  
  else {
	  
	  $sql2 = $db->prepare("update tesauro set status='OK' where id=:id");
	  $sql2->execute(array(":id"=>$id_puntero));
  }
  
  }

  echo $resultado;
