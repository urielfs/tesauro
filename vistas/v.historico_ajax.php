<?php

function array_to_json( $array ){

    if( !is_array( $array ) ){
        return false;
    }

    $associative = count( array_diff( array_keys($array), array_keys( array_keys( $array )) ));
    if( $associative ){

        $construct = array();
        foreach( $array as $key => $value ){

            // We first copy each key/value pair into a staging array,
            // formatting each key and value properly as we go.

            // Format the key:
            if( is_numeric($key) ){
                $key = "key_$key";
            }
            $key = "'".addslashes($key)."'";

            // Format the value:
            if( is_array( $value )){
                $value = array_to_json( $value );
            } else if( !is_numeric( $value ) || is_string( $value ) ){
                $value = "'".addslashes($value)."'";
            }

            // Add to staging array:
            $construct[] = "$key: $value";
        }

        // Then we collapse the staging array into the JSON form:
        $result = "{ " . implode( ", ", $construct ) . " }";

    } else { // If the array is a vector (not associative):

        $construct = array();
        foreach( $array as $value ){

            // Format the value:
            if( is_array( $value )){
                $value = array_to_json( $value );
            } else if( !is_numeric( $value ) || is_string( $value ) ){
                $value = "'".addslashes($value)."'";
            }

            // Add to staging array:
            $construct[] = $value;
        }

        // Then we collapse the staging array into the JSON form:
        $result = "[ " . implode( ", ", $construct ) . " ]";
    }

    return $result;
}

require_once(dirname(dirname(__FILE__))."/iniciar.php");

# Despliego datos en Hostorico
$campos = "tipo_documento,categoria,status,usuario,autor,titulo,id";
$dato_buscado = $_POST["buscaTitulo"];

$datos = $b->consulta_standard($campos,"where deleted=0 && titulo like '%$dato_buscado%'");
$cadena_datos = '<table class="table table-hover"><thead><th>CATEGORIA</th><th>AUTOR</th><th>TITULO</th><th colspan="3"></th></thead><tbody>';

   while($row_datos=$datos->fetch()) {
	   
	   $stmt = $db->prepare("select usuario,status from tesauro where id=:id");
	   $stmt->execute(array(":id"=>$row_datos['id']));
	   $row_user = $stmt->fetch();
	   
	   $cadena_datos .= '<tr>';
	   $cadena_datos .= '<td>'.$row_datos['categoria'].'</td>';
	   $cadena_datos .= '<td>'.$row_datos['autor'].'</td>';
	   $cadena_datos .= '<td>'.htmlspecialchars($row_datos['titulo']).'</td>';
	   $cadena_datos .= '<td>';
	   
		 if($row_user[1]!='OK' && $a->decrypt($_POST["usuario"],"dos")==$row_user[0]) {
			 
			
			$cadena_datos .= '<a href="javascript:void(0);" onClick="javascript:';
			$cadena_datos .= 'href=\'v.editar_datos_1.php?token='.$a->encrypt($row_datos[6],'tesa').'&usuario='.$_POST["usuario"].'\';">';
			$cadena_datos .= '<span class="glyphicon glyphicon-hand-left" aria-hidden="true"></span>';
			$cadena_datos .= '</a>';
			
			
			// Linea para test-BORRAR
			#$cadena_datos .= '<a href="#"><span class="glyphicon glyphicon-hand-left" aria-hidden="true"></span></a>';
			   
		 }
		 else {
			 
		 }
		 $cadena_datos .= '</td><td>';
		 
		        
				$cadena_datos .= '<a href="javascript:void(0);" onClick="javascript:';
				$cadena_datos .= 'href=\'v.consultas.php?token='.$a->encrypt($row_datos[6],'tesa').'&usuario='.$_POST["usuario"].'\';">';
				$cadena_datos .= '<span class="glyphicon glyphicon-search" aria-hidden="true"></span>';
				$cadena_datos .= '</a>';
				
				
				// Linea para test-BORRAR
				#$cadena_datos .= '<a><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>';
		 	 
		 $cadena_datos .= '</td><td>';
		     if($a->decrypt($_POST["usuario"],"dos")==$row_user[0]) {
			 
				
				$cadena_datos .= '<a href="javascript:void(0);" onClick="javascript:if(confirm(\'Esta accion elimina el registro\nDesea continuar?\')) {';
				$cadena_datos .= 'href=\'v.historico.php?tokenpt='.$a->encrypt($row_datos[6],'sicpmt').'&usuario='.$_POST["usuario"].'\';';
				$cadena_datos .= '} else { return false; }" align="center">';
				$cadena_datos .= '<span class="glyphicon glyphicon-trash" aria-hidden="true" align="center"></span></a>';
				$cadena_datos .= '</td></tr>';
				
				
				// Linea para test-BORRAR
				#$cadena_datos .= '<a href="#"><span class="glyphicon glyphicon-trash" aria-hidden="true" align="center"></span></a>';
	   
   }
   
   $cadena_datos .= '</td></tr>';
   
   }
   
   $cadena_datos .= '</tbody></table>';
   
   $datos = array("accion"=>"historico", "resultado"=>$cadena_datos);
   $cadena = array_to_json($datos);
   
   echo $cadena;