<?php

#EXTENSIÓN DE CLASES: Los objetos pueden ser extendidos, 
# y pueden heredar propiedades y métodos. Para definir una clase como extensión, 
# debo definir una clase padre, y se utiliza dentro de una clase hija.

//require_once "conexion.php";

class Datos extends Conexion{


	# Ver términos TESAURO
	public function verTesauroTEModel($datosModel){
		
		$campo = $datosModel['campo'];
		$stmt = Conexion::conectar()->prepare("select $campo from tesauro_elementos where $campo!='' && id_t=:id && TG=:tg");
		$stmt->bindParam(":id", $datosModel["id"], PDO::PARAM_INT);
		$stmt->bindParam(":tg", $datosModel["tg"], PDO::PARAM_STR);
		$stmt->execute();
		$row = $stmt->fetchAll();
		
		return $row;
	}
	
	
	public function verTesauroGeneralModel($datosModel){
		
		$stmt = Conexion::conectar()->prepare("select TG from tesauro_elementos where id_t=:id && TG!='' group by TG");
		$stmt->bindParam(":id", $datosModel["id"], PDO::PARAM_INT);
		$stmt->execute();
		$row = $stmt->fetch();
		
		return $row;
	}
	
	
	public function terminosTesauroModel($datosModel){
		
		$stmt = Conexion::conectar()->prepare("SELECT descriptor,TG,TE,TR FROM tesauro_elementos WHERE id_t=:id && TG!='' && TE!=''");
		$stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);
		$stmt->execute();
		$row = $stmt->fetchAll();
		
		return $row;
	}
	
	
	public function especiesTesauroModel($datosModel) {
		
		$stmt = Conexion::conectar()->prepare("SELECT * FROM tesauro_c WHERE id_t=:id && deleted=0");
		$stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);
		$stmt->execute();
		$row = $stmt->fetchAll();
		
		return $row;
	}

	
}