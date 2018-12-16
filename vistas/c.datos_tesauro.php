<?php
header('Content-Type: text/html; charset=ISO-8859-1');

require_once(dirname(dirname(__FILE__))."/iniciar.php");

// ---------------------- Script para ingresar DAtos -------------
// No se permiten valores repetidos para el mismo item -----------
// ---------------------------------------------------------------

if($_GET["token"]!="" && $_GET["valor"]!="")
{
	$campo = $_GET["item"];
	//$campo = "descriptor",
	$otro_stmt = $db->prepare("select $campo from tesauro_elementos where id=:id");
	$otro_stmt->execute(array(":id"=>$_GET["valor"]));
	$row_otro = $otro_stmt->fetch();
	
	//$valor_tesauro = $b->get_Tesauro($campo,$_GET["valor"]);
	
	$stmt = $db->prepare("select $campo,id from tesauro_elementos where TG=:tg && $campo!='' id_t=:id");
	$stmt->execute(array(":tg"=>$row_otro[0], ":id"=>$a->decrypt($_GET["token"],"tesa")));
	$cadena = "<option value=''>$campo -- $valor_tesauro</option>";
	
	while($row = $stmt->fetch())
	{
		$cadena .= "<option vaue='".$row[1]."'>".$row[0]."</option>";
	}
	
$valores = array("opciones"=>$cadena);

$datos = $a->array_to_json($valores);
	
}


echo $datos;