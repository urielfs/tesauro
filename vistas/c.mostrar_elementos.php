<?php
//header('Content-Type: text/html; charset=ISO-8859-1');

require_once(dirname(dirname(__FILE__))."/iniciar.php");

// ---------------------- Script para ingresar DAtos -------------
// No se permiten valores repetidos para el mismo item -----------
// ---------------------------------------------------------------

if(($_GET["datotg"]=="" || $_GET["datodes"]=="") || $_GET["dato"]=="")
{
	$resultado = "<div class='alert alert-warning' role='alert'>Ocurrio un error!</div>";
	$datoTE = "<option></option>";
}
else
{

// Despliego los Terminos expecificos de cada dupla Tg-Descriptor ----
//  segun el TE seleccionado -----------------------------------------
$campo = $_GET["dato"];
$datoTE = "";
$stmt = $db->prepare("select $campo,id from tesauro_elementos where id_t=:id && TG=:tg && descriptor=:descriptor && $campo!=''");

if($stmt->execute(array(":id"=>$a->decrypt($_GET["id_t"],"tesa"), ":tg"=>$b->get_Tesauro("TG",$_GET["datotg"]), ":descriptor"=>$b->get_Tesauro("descriptor",$_GET["datodes"]))))
{

while($row = $stmt->fetch())
{
	$datoTE .= "<option value='".$row[1]."'>".$row[0]."</option>";
	
	
}
//--------------------------------------------------------------------
//$resultado = "<div class='alert alert-warning' role='alert'>Cadena OK!</div>";
$resultado = "";
}
}
$valores = array("resultado"=>$resultado, "datoTE"=>$datoTE);
$datos = $a->array_to_json($valores);

echo $datos;