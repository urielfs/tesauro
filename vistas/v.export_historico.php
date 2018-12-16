<?php
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=SICPMT.xls");
header("Pragma: no-cache");
header("Expires: 0");

require_once(dirname(dirname(__FILE__))."/iniciar.php");
echo $_GET["buscaTitulo"];

$mvc = new MvcController();

$campos = "tipo_documento,categoria,status,usuario,autor,titulo,id";
$dato_buscado = $_GET["buscaTitulo"];

$datos = $b->consulta_standard($campos,"where deleted=0 && titulo like '%$dato_buscado%'");
$cadena_datos = '<table class="table table-hover"><thead><th>CATEGORIA</th><th>AUTOR</th><th>TITULO</th><th>TESAURO</th><th>ESPECIES</th><th colspan="3"></th></thead><tbody>';


   while($row_datos=$datos->fetch()) {
	   
	   $stmt = $db->prepare("select usuario,status from tesauro where id=:id");
	   $stmt->execute(array(":id"=>$row_datos['id']));
	   $row_user = $stmt->fetch();
	   
	   
	   # ------- Imprimo Terminos TESAURO ----------------------------------#
	     $datoTerminos = array("id"=>$row_datos['id']);               #
	     $terminosTesauro = $mvc->terminosTesauroController($datoTerminos); #
	   # -------------------------------------------------------------------#
	   
	   # ----------- Especies --------- #
	                    #
	     $especiesTesauro = $mvc->especiesTesauroController($datoTerminos);
	   # ------------------------------ #
	   
	   $cadena_datos .= '<tr>';
	   $cadena_datos .= '<td>'.$row_datos['categoria'].'</td>';
	   $cadena_datos .= '<td>'.$row_datos['autor'].'</td>';
	   $cadena_datos .= '<td>'.htmlspecialchars($row_datos['titulo']).'</td>';
	   $cadena_datos .= '<td>'.$terminosTesauro.'</td>';
	   $cadena_datos .= '<td>'.$especiesTesauro.'</td>';
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
   
   echo $cadena_datos;