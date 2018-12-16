<?php
header('Content-Type: text/html; charset=ISO-8859-1');

require_once(dirname(dirname(__FILE__))."/iniciar.php");

// ---------------------- Script para ingresar DAtos -------------
// No se permiten valores repetidos para el mismo item -----------
// ---------------------------------------------------------------

// ------------- Valido la selección de un Descriptor ------------ 
if($_GET["datotg"]=="" && $_GET["opcion"]!="del")
{
	$resultado = "<div class='alert alert-warning' role='alert'>Debe seleccionar un Descriptor!</div>";
		$valores = array("tok"=>"true", "resultado"=>$resultado);
		$datos = $a->array_to_json($valores);

echo $datos;
exit;
}

if($_GET["dato"]!="" && $_GET["opcion"]!="del") {

	$campo = $_GET["item"];
	
	$sql = $db->prepare("select $campo from tesauro_elementos where $campo=:campo_valor && TG=:tg && id_t=:valor");
	$sql->execute(array(":campo_valor"=>$_GET["dato"], ":tg"=>$b->get_Tesauro("TG",$_GET["datotg"]), ":valor"=>$a->decrypt($_GET["id_t"],"tesa")));
	$row_sql = $sql->fetch();

	if($row_sql[0]==$_GET["dato"]) {
	
		$resultado = "<div class='alert alert-info' role='alert'>Dato existente!</div>";
		
		$valores = array("tok"=>"true","resultado"=>$resultado);

	}
	else {
		
		$stmt = $db->prepare("insert into tesauro_elementos(id_t,$campo,TG) values(:id_t,:dato,:tg)");
		
		if($stmt->execute(array(":id_t"=>$a->decrypt($_GET["id_t"],"tesa"), ":dato"=>$_GET["dato"], ":tg"=>$b->get_Tesauro("TG",$_GET["datotg"])))) 
		{
	
			$resultado = "<div class='alert alert-success' role='alert'>Valor Ingresado!</div>";
		}

		else 
		{
			$resultado = "<div class='alert alert-warning' role='alert'>Ocurrio un error!</div>";
		}


	$stmt2 = $db->prepare("select MAX(id) from tesauro_elementos");
	$stmt2->execute();
	$row_stmt2 = $stmt2->fetch();

	$valores = array("tok"=>"false", "dato_v"=>$row_stmt2[0], "dato_t"=>$_GET["dato"], "resultado"=>$resultado);

	

		}

}


// ----------------- Valida valor vacio para Agregar /Eliminar -------------------
if($_GET["dato"]=="" && $_GET["opcion"]!="del")
{
	$resultado = "<div class='alert alert-warning' role='alert'>Debe ingresar un valor!</div>";
		$valores = array("tok"=>"true", "resultado"=>$resultado);
		$datos = $a->array_to_json($valores);

echo $datos;
exit;
}

// ----------------- Script para borrar datos -------------------
if($_GET["opcion"]=="del" && $_GET["datoB"]!="")
{

	$stmt = $db->prepare("delete from tesauro_elementos where TG=:tg && descriptor=:descriptor && id_t=:id");
	
	if($stmt->execute(array(":tg"=>$b->get_Tesauro("TG",$_GET["datotg"]), ":descriptor"=>$b->get_Tesauro("descriptor",$_GET["datoB"]), ":id"=>$a->decrypt($_GET["id_t"],"tesa"))))
	{
		$resultado = "<div class='alert alert-danger' role='alert'>Registro borrado!</div>";
		$valores = array("tok"=>"true", "resultado"=>$resultado, "opcion"=>"borrado", "valor"=>$_GET["datoB"]);

	
	}
	else 
	{
		$resultado = "<div class='alert alert-warning' role='alert'>Ocurrio un error!</div>";
		$valores = array("tok"=>"true", "resultado"=>$resultado);

		
	}

}	
	


//$valores = array("dato_v"=>"El valor", "dato_t"=>"El texto", "tok"=>"Un resultado", "resultado"=>$resultado);
$datos = $a->array_to_json($valores);

echo $datos;