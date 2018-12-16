<?php
header('Content-Type: text/html; charset=ISO-8859-1');

require_once(dirname(dirname(__FILE__))."/iniciar.php");

$tg = $_GET["tg"];

$stmt = $db->prepare("select descriptor,id from tesauro_elementos where TG like '$tg%' && descriptor!='' group by descriptor");
$stmt->execute();
$cadena = "";

while($row = $stmt->fetch())
{
	$cadena .= "<blockquote><p><a href='javascript:void(0);' onclick='javascript:MostrarTerminos(\"c.mostrar_terminos.php?tg=".$tg."&des=".$row[0]."&puntero=".$row[1]."\",".$row[1].");'>".ucfirst($row[0])."</a></p>";
	$cadena .= "<div id='cadena_".$row[1]."'>...</div></blockquote>";
}

$valores = array("cadena"=>$cadena);

$datos = $a->array_to_json($valores);

echo $cadena;