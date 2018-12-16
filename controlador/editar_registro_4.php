<?php

/*
|--------------------------------------------------------------|
| Editar datos PESTAÑA 4                                       |
| Solo se modifican datos si el usuario esta logueado          |
|--------------------------------------------------------------|
*/

// Nombre Campos a actualizar
   $campos = "pais_muestreo=:pais_muestreo,
              region=:region,
			  latitud=:latitud,
			  longitud=:longitud,
			  matriz=:matriz,
			  especie=:especie,
			  contaminante=:contaminante,
			  unidades=:unidades";


$stmt2 = $db->prepare("select usuario from tesauro where usuario=:usuario");
$stmt2->execute(array(":usuario"=>$a->decrypt($_GET["usuario"],"dos")));
$row2 = $stmt2->fetch();

  if($a->decrypt($_GET["usuario"],"dos") == $row2[0] && ($_POST["toke"]=="act" || $_POST["toke"]=="acth"))
  {
    $id_puntero = $a->decrypt($_GET['token'],"tesa");
    
    
    $stmt2 = $db->prepare("update tesauro set $campos where id=:puntero");
    $stmt2->execute(array(
                          ':pais_muestreo'=>$_POST['pais_muestreo'],
                          ':region'=>$_POST['region'],
                          ':latitud'=>$_POST['latitud_g']."|".$_POST['latitud_m']."|".$_POST['latitud_s'],
						  ':longitud'=>$_POST['longitud_g']."|".$_POST['longitud_m']."|".$_POST['longitud_s'],
						  ':matriz'=>$_POST['matriz'],
						  ':especie'=>$_POST['especie1']."|".$_POST['especie2']."|".$_POST['especie3']."|".$_POST['especie4'],
						  ':contaminante'=>$_POST['contaminante'],
						  ':unidades'=>$_POST['und_latitud']."|".$_POST['und_longitud'],
                          ':puntero'=>$id_puntero
						  )
					);
	
	// Averiguo el numero de especies
	$cuantas_especies = $b->cuantasEspecies($id_puntero);
	
	for($k=1;$k<=$cuantas_especies;$k++) {
		
		$variable = "especie_".$k;
		$variablect = "contaminante_".$k;
		$variablecc = "concentracion_".$k;
		$variablema = "matriz_".$k;
		$variablemax = "concentracion_max_".$k;
		$variablemin = "concentracion_min_".$k;
		$variableundmax = "und_concentracion_max_".$k;
		$variableundmin = "und_concentracion_min_".$k;
		$variablelatg = "lat_grados_".$k;
		$variablelatm = "lat_minutos_".$k;
		$variablelats = "lat_segundos_".$k;
		$variablelat = "latitud_".$k;
		$variablelong = "lon_grados_".$k;
		$varibalelonm = "lon_minutos_".$k;
		$variablelons = "lon_segundos_".$k;
		$variablelon = "longitud_".$k;
		
		$cadena_concentracion_max = $_POST[$variablemax]."|".$_POST[$variableundmax];
		$cadena_concentracion_min = $_POST[$variablemin]."|".$_POST[$variableundmin];

		$stmt3 = $db->prepare("update tesauro_c set especie=:especie,contaminante=:contaminante,concentracion=:concentracion,matriz=:matriz,concentracion_max=:concentracion_max,concentracion_min=:concentracion_min,fecha_creado=:act,lat_grados=:lat_grados,lat_minutos=:lat_minutos,lat_segundos=:lat_segundos,latitud=:latitud,lon_grados=:lon_grados,lon_minutos=:lon_minutos,lon_segundos=:lon_segundos,longitud=:longitud where id_t=:id && id=:id_c");
		$stmt3->bindParam(":especie", $_POST[$variable], PDO::PARAM_STR);
		$stmt3->bindParam(":contaminante", $_POST[$variablect], PDO::PARAM_STR);
		$stmt3->bindParam(":concentracion", $_POST[$variablecc], PDO::PARAM_STR);
		$stmt3->bindParam(":matriz", $_POST[$variablema], PDO::PARAM_STR);
		$stmt3->bindParam(":concentracion_max", ($cadena_concentracion_max), PDO::PARAM_STR);
		$stmt3->bindParam(":concentracion_min", ($cadena_concentracion_min), PDO::PARAM_STR);
		$stmt3->bindParam(":act", date("Y-m-d H:i:s"), PDO::PARAM_STR);
		$stmt3->bindParam(":lat_grados", $_POST[$variablelatg], PDO::PARAM_INT);
		$stmt3->bindParam(":lat_minutos", $_POST[$variablelatm], PDO::PARAM_INT);
		$stmt3->bindParam(":lat_segundos", $_POST[$variablelats], PDO::PARAM_INT);
		$stmt3->bindParam(":latitud", $_POST[$variablelat], PDO::PARAM_STR);
		$stmt3->bindParam("lon_grados", $_POST[$variablelong], PDO::PARAM_INT);
		$stmt3->bindParam(":lon_minutos", $_POST[$varibalelonm], PDO::PARAM_INT);
		$stmt3->bindParam(":lon_segundos", $_POST[$variablelons], PDO::PARAM_INT);
		$stmt3->bindParam(":longitud", $_POST[$variablelon], PDO::PARAM_STR);
		$stmt3->bindParam(":id", $id_puntero, PDO::PARAM_INT);
		$stmt3->bindParam(":id_c", $k, PDO::PARAM_INT);
		
		$stmt3->execute();
	}


	// Consulta de las especies ingresadas, almacenado en vector $valor_especies[]
       
	   $valores_especie = $b->datos_ext($id_puntero);
	
	   $cadena_especie = "";
	   
	    
		while($row_especie = $valores_especie->fetch()) {
			
			// Unidades -------
			
			$und_concentracion_max = explode("|", $row_especie["concentracion_max"]);  // Concentracion Max		
			$und_concentracion_min = explode("|", $row_especie["concentracion_min"]);  // Concentracion Min
			// ----------------
			
			//................................Consulto foto disponible para la Especie...........
			$sql_foto = $db->prepare("select valor2 from tesauro_cstm where label='especies' && valor=:valor");
			$sql_foto->execute(array(":valor"=>$row_especie[0]));
			$row_foto = $sql_foto->fetch();
			//...................................................................................
			
			
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
			   <select name='especie_".$row_especie[3]."' class='form-control' aria-describedby='basic-addon11'>
				<option value='".$row_especie[0]."'>".$row_especie[0]."</option>
				<option value=''> --- </option>
				".$b->verLista("especies")."
			   </select>
			   <span class='input-group-addon' id='basic-addon11'>. Especie</span>
			 </div><!-- /input-group -->
			 </div><!-- /.col-lg-6 -->
			 <div class='col-xs-6 col-md-3'>
              <a href='#' class='thumbnail'>
              <img src='imagenes/".$row_foto[0]."' alt='...' width='171px' heigth='180px'>
              </a>
             </div>
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
			   <select name='contaminante_".$row_especie[3]."' class='form-control' aria-describedby='basic-addon11'>
				<option value='".$row_especie[2]."'>".$row_especie[2]."</option>
				<option value=''> --- </option>
				".$b->verLista("contaminantes")."
			   </select>
			   <span class='input-group-addon' id='basic-addon11'>. Contaminante</span>
			 </div><!-- /input-group -->
			 </div><!-- /.col-lg-6 -->
			 
			  <div class='col-lg-6'>
			 <div class='input-group'>
			   <select name='matriz_".$row_especie[3]."' class='form-control' aria-describedby='basic-addon11'>
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
			   <input type='text' name='concentracion_max_".$row_especie[3]."' class='form-control' aria-describedby='basic-addon11' value='".$und_concentracion_max[0]."'>
			   <span class='input-group-addon' id='basic-addon11'>. Concentraci&oacute;n Max.</span>
			 </div><!-- /input-group -->
			 </div><!-- /.col-lg-6 -->
			 
			 <div class='col-lg-2'>
			 <div class='input-group'>
			   <select name='und_concentracion_max_".$row_especie[3]."' class='form-control' aria-describedby='basic-addon11'>
			    <option value='".$und_concentracion_max[1]."'>".$und_concentracion_max[1]."</option>
				<option value=''>---</option>
				".$b->verLista("undconcentracion")."
				
			   </select>
			   <span class='input-group-addon' id='basic-addon11'>. Und</span>
			 </div><!-- /input-group -->
			 </div><!-- /.col-lg-6 -->
			 
			  <div class='col-lg-3'>
			 <div class='input-group'>
			   <input type='text' name='concentracion_min_".$row_especie[3]."' class='form-control' aria-describedby='basic-addon11' value='".$und_concentracion_min[0]."'>
			   <span class='input-group-addon' id='basic-addon11'>. Concentraci&oacute;n M&iacute;n.</span>
			 </div><!-- /input-group -->
			 </div><!-- /.col-lg-6 -->
			 
			 <div class='col-lg-3'>
			 <div class='input-group'>
			   <select name='und_concentracion_min_".$row_especie[3]."' class='form-control' aria-describedby='basic-addon11'>
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
			   <input type='number' min='0' name='lat_grados_".$row_especie[3]."' class='form-control' aria-describedby='basic-addon11' value='".$row_especie['lat_grados']."'>
			   <span class='input-group-addon' id='basic-addon11'>. Grados Lat.</span>
			 </div><!-- /input-group -->
			 </div><!-- /.col-lg-3 -->
			 
			 <div class='col-lg-3'>
			 <div class='input-group'>
			   <input type='number' min='0' name='lat_minutos_".$row_especie[3]."' class='form-control' aria-describedby='basic-addon11' value='".$row_especie['lat_minutos']."'>
			   <span class='input-group-addon' id='basic-addon11'>. Minutos Lat.</span>
			 </div><!-- /input-group -->
			 </div><!-- /.col-lg-3 -->
			 
			 
			 <div class='col-lg-3'>
			 <div class='input-group'>
			   <input type='number' min='0' name='lat_segundos_".$row_especie[3]."' class='form-control' aria-describedby='basic-addon11' value='".$row_especie['lat_segundos']."'>
			   <span class='input-group-addon' id='basic-addon11'>. Segundos Lat.</span>
			 </div><!-- /input-group -->
			 </div><!-- /.col-lg-3 -->
			 
			 <div class='col-lg-3'>
			 <div class='input-group'>
			   <select name='latitud_".$row_especie[3]."' class='form-control' aria-describedby='basic-addon11'>
			     <option value='".$row_especie['latitud']."'>".$row_especie['latitud']."</option>
				 <option value=''>---</option>
				 <option value='N'>N</option>
				 <option value='S'>S</option>
			   </select>
			   <span class='input-group-addon' id='basic-addon11'>. Latitud</span>
			 </div><!-- /input-group -->
			 </div><!-- /.col-lg-3 -->
			 
			 </div><!-- /.row -->
			 
			 
			 <div class='row'>
			 
			 <div class='col-lg-3'>
			 <div class='input-group'>
			   <input type='number' min='0' name='lon_grados_".$row_especie[3]."' class='form-control' aria-describedby='basic-addon11' value='".$row_especie['lon_grados']."'>
			   <span class='input-group-addon' id='basic-addon11'> Grados Lon.</span>
			 </div><!-- /input-group -->
			 </div><!-- /.col-lg-3 -->
			 
			 <div class='col-lg-3'>
			 <div class='input-group'>
			   <input type='number' min='0' name='lon_minutos_".$row_especie[3]."' class='form-control' aria-describedby='basic-addon11' value='".$row_especie['lon_minutos']."'>
			   <span class='input-group-addon' id='basic-addon11'> Minutos Lon.</span>
			 </div><!-- /input-group -->
			 </div><!-- /.col-lg-3 -->
			 
			 <div class='col-lg-3'>
			 <div class='input-group'>
			   <input type='number' min='0' name='lon_segundos_".$row_especie[3]."' class='form-control' aria-describedby='basic-addon11' value='".$row_especie['lon_segundos']."'>
			   <span class='input-group-addon' id='basic-addon11'> Segundos Lon.</span>
			 </div><!-- /input-group -->
			 </div><!-- /.col-lg-3 -->
			 
			 <div class='col-lg-3'>
			 <div class='input-group'>
			   <select name='longitud_".$row_especie[3]."' class='form-control' aria-describedby='basic-addon11'>
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
		}		

	
  }



//echo "EL PUNTERO ES: ".$id_puntero."<br>";
