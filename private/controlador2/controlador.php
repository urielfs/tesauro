<?php
class MvcController{


	
	
	public function enlacesPaginasController(){

		if(isset($_GET["action"])){
			
			#$rutas = array();
			#$rutas = explode("/", $_GET["action"]);
			
			$enlaces = $_GET["action"];
		
		}

		else{

			$enlaces = "inicio";
		}

		$respuesta = Paginas::enlacesPaginasModel($enlaces);

		include $respuesta;

	}
	
	
	# Ver elementos TESAURO
	public function verTesauroController($datosController){
		
		$losterminos = array();
		$losterminos[] = 'TE';
		$losterminos[] = 'TR';
		$losterminos[] = 'NA';
		$losterminos[] = 'USE_for';
		$respuesta = Datos::verTesauroGeneralModel($datosController);
		
		
		
		foreach($respuesta as $valor=>$valor2){
			
			$datosController['tg'] = $valor2;
			
			
			foreach($losterminos as $dato){
				
				$datosController['campo'] = $dato;
				$especificos = Datos::verTesauroTEModel($datosController);
			    			
				
				foreach($especificos as $clave=>$vale){
				
					
					if($vale!='') { echo '<p>('.$valor2.') '.$dato.': '.$vale[$clave].'</p>'; }
				}
				echo '<hr>';
			}
			
			echo '<br> --';
		}
		
		
	}
	
	
	public function terminosTesauroController($datosController){
		
		$respuesta = Datos::terminosTesauroModel($datosController["id"]);
		$mensaje = "<br><table class='table'><thead><th>Descriptor</th><th>Térm. General</th><th>Térm. Espec.</th><th>TR</th></thead>";
		$mensaje .= "<tbody>";
		
		foreach($respuesta as $valor=>$clave)
		{
			$mensaje .= "<tr><td>".$clave["descriptor"]."</td><td>".$clave["TG"]."</td><td>".$clave["TE"]."</td><td>".$clave["TR"]."</td></tr>";
		}
		
		$mensaje .= "</tbody></table>";
		
		return $mensaje;
	}
	
	
	public function especiesTesauroController($datosController) {
		
		$respuesta = Datos::especiesTesauroModel($datosController["id"]);
		$cadena = "<table><thead><th>especie</th><th>fecha_creado</th><th>contaminante</th><th>concentracion_max</th><th>concentracion_min</th><th>matriz</th><th>pais</th><th>region</th><th>lat_grados</th><th>lat_minutos</th><th>lat_segundos</th><th>latitud</th><th>lon_grados</th><th>lon_minutos</th><th>lon_segundos</th><th>longitud</th></thead>";
		$cadena .= "<tbody>";
		
		foreach($respuesta as $valor=>$clave)
		{
			$cadena .= "<tr><td>".$clave["especie"]."</td><td>".$clave["fecha_creado"]."</td><td>".$clave["contaminante"]."</td><td>".$clave["concentracion_max"]."</td><td>".$clave["concentracion_min"]."</td><td>".$clave["matriz"]."</td><td>".$clave["pais"]."</td><td>".$clave["region"]."</td><td>".$clave["lat_grados"]."</td><td>".$clave["lat_minutos"]."</td><td>".$clave["lat_segundos"]."</td><td>".$clave["latitud"]."</td><td>".$clave["lon_grados"]."</td><td>".$clave["lon_minutos"]."</td><td>".$clave["lon_segundos"]."</td><td>".$clave["longitud"]."</td></tr>";
		}
		
		$cadena .= "</tbody></table>";
		
		return $cadena;
	}

}