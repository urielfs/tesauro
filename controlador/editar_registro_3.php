<?php

/*
|--------------------------------------------------------------|
| Editar datos PESTAÑA 3                                       |
| Solo se modifican datos si el usuario esta logueado          |
| * Se construye script para mostrar especies segun el puntero |
|   indicado por el usuario ( Lin 51 a 82 )                    |
|--------------------------------------------------------------|
*/

// Nombre Campos a actualizar
   $campos = "nombre_publicacion=:nombre_publicacion,
			  pais=:pais,
              fecha=:fecha,
			  revista=:revista,
			  volumen=:volumen,
			  articulo_numero=:articulo_numero,
			  issue=:issue,
			  link1=:link1,
			  link2=:link2,
			  page_start=:page_start,
			  page_end=:page_end";

$id_puntero = $a->decrypt($_GET['token'],"tesa");

$stmt2 = $db->prepare("select usuario from tesauro where usuario=:usuario");
$stmt2->execute(array(":usuario"=>$a->decrypt($_GET["usuario"],"dos")));
$row2 = $stmt2->fetch();

  if($a->decrypt($_GET["usuario"],"dos") == $row2[0] && $_POST["toke"]=="act")
  {
    
    
    
    $stmt2 = $db->prepare("update tesauro set $campos where id=:puntero");
    $stmt2->execute(array(
                          ':nombre_publicacion'=>$_POST['nombre_publicacion'],
						  ':pais'=>$_POST['pais'],
                          ':fecha'=>$_POST['fecha'],
                          ':revista'=>$_POST['revista'],
						  ':volumen'=>$_POST['volumen'],
						  ':articulo_numero'=>$_POST['articulo_n'],
						  ':issue'=>$_POST['issue'],
						  ':link1'=>$_POST['Inputlink1'],
						  ':link2'=>$_POST['Inputlink2'],
						  ':page_start'=>$_POST['Inputpaginicio'],
						  ':page_end'=>$_POST['Inputpagfin'],
                          ':puntero'=>$id_puntero
						  )
					);
					
	


  }



// Agregar /Eliminar lineas de Especie
	if($_GET['token_especie'] == 'add') {
		
		$stmt3 = $db->prepare("insert into tesauro_c (id_t,fecha_creado) values(:id,:fecha)");
		$stmt3->execute(array(":id"=>$id_puntero, ":fecha"=>date("Y-m-d H:i:s"))); 
		
	}
	elseif($_GET['token_especie'] == 'del') {
		$stmt3 = $db->prepare("update tesauro_c set deleted=1 where id=:id");
		$stmt3->execute(array(":id"=>$_GET["id_especie"]));
		
	}
	else {}

  
	// Consulta de las especies ingresadas, almacenado en vector $valor_especies[]
       
	   $valores_especie = $b->datos_ext($id_puntero);
	
	   $cadena_especie = "";
	   $contador_especies = 1; // Contador de las especies ingresadas en el Artículo
							   // $row_especie[3], puntero del id en tabla( ANTES )
	    
		while($row_especie = $valores_especie->fetch()) {
			
			// Unidades -------
			
			$und_concentracion_max = explode("|", $row_especie["concentracion_max"]);  // Concentracion Max		
			$und_concentracion_min = explode("|", $row_especie["concentracion_min"]);  // Concentracion Min
			// ----------------
			
		
			
			$cadena_especie.="
			<div class='panel panel-info'>
            <div class='panel-heading'>
            <h3 class='panel-title'>Grupo especie #".$row_especie[3]."
			  <input type='button' class='btn btn-info' value='-' onClick='javascript:
			  this.form.action=\"v.editar_datos_4.php?token_especie=del&usuario=".$_GET['usuario']."&token=".$_GET['token']."&id_especie=".$row_especie[3]."\";
			  this.form.submit();'>
			</h3>
            </div>
            <div class='panel-body'>
			
			<!-- IMPRESION DATOS -->
			 <div class='row'>
			 
			 <div class='col-lg-6'>
			 <div class='input-group'>
			   <select name='especie_".$contador_especies."' class='form-control' aria-describedby='basic-addon11'>
				<option value='".$row_especie[0]."'>".$row_especie[0]."</option>
				<option value=''> --- </option>
				".$b->verLista("especies")."
			   </select>
			   <span class='input-group-addon' id='basic-addon11'>. Especie</span>
			 </div><!-- /input-group -->
			 </div><!-- /.col-lg-6 -->
			 ";
		/*	 
			  <div class='col-lg-6'>
			 <div class='input-group'>
			   <select name='concentracion_".$row_especie[3]."' class='form-control' aria-describedby='basic-addon11'>
				<option value='".$row_especie[1]."'>".$row_especie[1]."</option>
				<option value=''> --- </option>
				".$b->verLista("concentracion")."
			   </select>
			   <span class='input-group-addon' id='basic-addon11'>. Concentraci&oacute;n</span>
			 </div><!-- /input-group -->
			 </div><!-- /.col-lg-6 -->
		*/	 
			 $cadena_especie.="
			 </div><!-- /.row -->
			 

			
			 <div class='row'>
			 
			 <div class='col-lg-6'>
			 <div class='input-group'>
			   <select name='contaminante_".$contador_especies."' class='form-control' aria-describedby='basic-addon11'>
				<option value='".$row_especie[2]."'>".$row_especie[2]."</option>
				<option value=''> --- </option>
				".$b->verLista("contaminantes")."
			   </select>
			   <span class='input-group-addon' id='basic-addon11'>. Contaminante</span>
			 </div><!-- /input-group -->
			 </div><!-- /.col-lg-6 -->
			 
			  <div class='col-lg-6'>
			 <div class='input-group'>
			   <select name='matriz_".$contador_especies."' class='form-control' aria-describedby='basic-addon11'>
				<option value='".$row_especie[4]."'>".$row_especie[4]."</option>
				<option value=''> --- </option>
				".$b->verLista("matriz")."
			   </select>
			   <span class='input-group-addon' id='basic-addon11'>. Matriz</span>
			 </div><!-- /input-group -->
			 </div><!-- /.col-lg-6 -->
			 
			 </div><!-- /.row -->
			 
			 
			 <div class='row'>
			 
			 <div class='col-lg-4'>
			 <div class='input-group'>
			   <input type='text' name='concentracion_max_".$contador_especies."' class='form-control' aria-describedby='basic-addon11' value='".$und_concentracion_max[0]."'>
			   <span class='input-group-addon' id='basic-addon11'>. Concentraci&oacute;n Max.</span>
			 </div><!-- /input-group -->
			 </div><!-- /.col-lg-6 -->
			 
			 <div class='col-lg-2'>
			 <div class='input-group'>
			   <select name='und_concentracion_max_".$contador_especies."' class='form-control' aria-describedby='basic-addon11'>
			   <option value='".$und_concentracion_max[1]."'>".$und_concentracion_max[1]."</option>
				<option value=''>---</option>
				".$b->verLista("undconcentracion")."
			   </select>	
			   <span class='input-group-addon' id='basic-addon11'>. Und</span>
			 </div><!-- /input-group -->
			 </div><!-- /.col-lg-6 -->
			 
			 
			 <div class='col-lg-4'>
			 <div class='input-group'>
			   <input type='text' name='concentracion_min_".$contador_especies."' class='form-control' aria-describedby='basic-addon11' value='".$und_concentracion_min[0]."'>
			   <span class='input-group-addon' id='basic-addon11'>. Concentraci&oacute;n M&iacute;n.</span>
			 </div><!-- /input-group -->
			 </div><!-- /.col-lg-4 -->
			 
			 <div class='col-lg-2'>
			 <div class='input-group'>
			   <select name='und_concentracion_min_".$contador_especies."' class='form-control' aria-describedby='basic-addon11'>
			    <option value='".$und_concentracion_min[1]."'>".$und_concentracion_min[1]."</option>
				<option value=''>---</option>
				".$b->verLista("undconcentracion")."
			   </select>	
			   <span class='input-group-addon' id='basic-addon11'>. Und</span>
			 </div><!-- /input-group -->
			 </div><!-- /.col-lg-6 -->
			 
			 </div><!-- /.row -->
			 <hr>
			 
			 <div class='row'>
			 
			 <div class='col-lg-3'>
			 <div class='input-group'>
			   <input type='number' min='0' name='lat_grados_".$contador_especies."' class='form-control' aria-describedby='basic-addon11' value='".$row_especie['lat_grados']."'>
			   <span class='input-group-addon' id='basic-addon11'> Grados Lat.</span>
			 </div><!-- /input-group -->
			 </div><!-- /.col-lg-3 -->
			 
			 <div class='col-lg-3'>
			 <div class='input-group'>
			   <input type='number' min='0' name='lat_minutos_".$contador_especies."' class='form-control' aria-describedby='basic-addon11' value='".$row_especie['lat_minutos']."'>
			   <span class='input-group-addon' id='basic-addon11'> Minutos Lat.</span>
			 </div><!-- /input-group -->
			 </div><!-- /.col-lg-3 -->
			 
			 
			 <div class='col-lg-3'>
			 <div class='input-group'>
			   <input type='number' min='0' name='lat_segundos_".$contador_especies."' class='form-control' aria-describedby='basic-addon11' value='".$row_especie['lat_segundos']."'>
			   <span class='input-group-addon' id='basic-addon11'> Segundos Lat.</span>
			 </div><!-- /input-group -->
			 </div><!-- /.col-lg-3 -->
			 
			 <div class='col-lg-3'>
			 <div class='input-group'>
			   <select name='latitud_".$contador_especies."' class='form-control' aria-describedby='basic-addon11' required>
			     <option value='".$row_especie['latitud']."'>".$row_especie['latitud']."</option>
				 <option value=''>---</option>
				 <option value='N'>N</option>
				 <option value='S'>S</option>
			   </select>
			   <span class='input-group-addon' id='basic-addon11'> Latitud</span>
			 </div><!-- /input-group -->
			 </div><!-- /.col-lg-3 -->
			 
			 </div><!-- /.row -->
			 
			 
			 <div class='row'>
			 
			 <div class='col-lg-3'>
			 <div class='input-group'>
			   <input type='number' min='0' name='lon_grados_".$contador_especies."' class='form-control' aria-describedby='basic-addon11' value='".$row_especie['lon_grados']."'>
			   <span class='input-group-addon' id='basic-addon11'> Grados Lon.</span>
			 </div><!-- /input-group -->
			 </div><!-- /.col-lg-3 -->
			 
			 <div class='col-lg-3'>
			 <div class='input-group'>
			   <input type='number' min='0' name='lon_minutos_".$contador_especies."' class='form-control' aria-describedby='basic-addon11' value='".$row_especie['lon_minutos']."'>
			   <span class='input-group-addon' id='basic-addon11'> Minutos Lon.</span>
			 </div><!-- /input-group -->
			 </div><!-- /.col-lg-3 -->
			 
			 <div class='col-lg-3'>
			 <div class='input-group'>
			   <input type='number' min='0' name='lon_segundos_".$contador_especies."' class='form-control' aria-describedby='basic-addon11' value='".$row_especie['lon_segundos']."'>
			   <span class='input-group-addon' id='basic-addon11'> Segundos Lon.</span>
			 </div><!-- /input-group -->
			 </div><!-- /.col-lg-3 -->
			 
			 <div class='col-lg-3'>
			 <div class='input-group'>
			   <select name='longitud_".$contador_especies."' class='form-control' aria-describedby='basic-addon11' required>
			     <option value='".$row_especie['longitud']."'>".$row_especie['longitud']."</option>
				 <option value=''>---</option>
				 <option value='E'>E</option>
				 <option value='W'>W</option>
			   </select>
			   <span class='input-group-addon' id='basic-addon11'> Longitud</span>
			 </div><!-- /input-group -->
			 </div><!-- /.col-lg-3 -->
			 
			 </div><!-- /.row -->
			 
			 <!-- FIN IMPRESION DATOS -->
			 </div><!-- /.panel-body -->
			 </div><!-- /.panel panel-info -->
			";
			
			$contador_especies ++;
		}			
		 

//echo "EL PUNTERO ES: ".$id_puntero."<br>";