<?php
header('Content-Type: text/html; charset=ISO-8859-1');

require_once(dirname(dirname(__FILE__))."/iniciar.php");


// Consulta para terminos TE -------------
$stmt = $db->prepare("select TE from tesauro_elementos where TG=:tg && descriptor=:descriptor && TE!=''");
$stmt->execute(array(":tg"=>$_GET["tg"], ":descriptor"=>$_GET["des"]));
$cadena = "<footer><strong>TE:</strong> <cite title='Source Title'>";

while($row = $stmt->fetch())
{
	$cadena .= $row[0]." ,";
}
$cadena = substr($cadena, 0, -1);
$cadena .= "</cite></footer>";

// Consulta para terminos TR -------------
$stmt = $db->prepare("select TR from tesauro_elementos where TG=:tg && descriptor=:descriptor && TR!=''");
$stmt->execute(array(":tg"=>$_GET["tg"], ":descriptor"=>$_GET["des"]));
$cadena .= "<footer><strong>TR:</strong> <cite title='Source Title'>";

while($row = $stmt->fetch())
{
	$cadena .= $row[0]." ,";
}
$cadena = substr($cadena, 0, -1);
$cadena .= "</cite></footer>";


// Consulta para terminos NA -------------
$stmt = $db->prepare("select NA from tesauro_elementos where TG=:tg && descriptor=:descriptor && NA!=''");
$stmt->execute(array(":tg"=>$_GET["tg"], ":descriptor"=>$_GET["des"]));
$cadena .= "<footer><strong>NA:</strong> <cite title='Source Title'>";

while($row = $stmt->fetch())
{
	$cadena .= $row[0]." ,";
}
$cadena = substr($cadena, 0, -1);
$cadena .= "</cite></footer>";


// Consulta para terminos USE_for -------------
$stmt = $db->prepare("select USE_for from tesauro_elementos where TG=:tg && descriptor=:descriptor && USE_for!=''");
$stmt->execute(array(":tg"=>$_GET["tg"], ":descriptor"=>$_GET["des"]));
$cadena .= "<footer><strong>USE_for:</strong> <cite title='Source Title'>";

while($row = $stmt->fetch())
{
	$cadena .= $row[0]." ,";
}
$cadena = substr($cadena, 0, -1);
$cadena .= "</cite></footer>";

// Consulta para terminos UP -------------
$stmt = $db->prepare("select UP from tesauro_elementos where TG=:tg && descriptor=:descriptor && UP!=''");
$stmt->execute(array(":tg"=>$_GET["tg"], ":descriptor"=>$_GET["des"]));
$cadena .= "<footer><strong>UP:</strong> <cite title='Source Title'>";

while($row = $stmt->fetch())
{
	$cadena .= $row[0]." ,";
}
$cadena = substr($cadena, 0, -1);
$cadena .= "</cite></footer>";


// Consulta para terminos TC -------------
$stmt = $db->prepare("select TC from tesauro_elementos where TG=:tg && descriptor=:descriptor && TC!=''");
$stmt->execute(array(":tg"=>$_GET["tg"], ":descriptor"=>$_GET["des"]));
$cadena .= "<footer><strong>TC:</strong> <cite title='Source Title'>";

while($row = $stmt->fetch())
{
	$cadena .= $row[0]." ,";
}
$cadena = substr($cadena, 0, -1);
$cadena .= "</cite></footer>";


// Consulta para terminos TTG -------------
$stmt = $db->prepare("select TTG from tesauro_elementos where TG=:tg && descriptor=:descriptor && TTG!=''");
$stmt->execute(array(":tg"=>$_GET["tg"], ":descriptor"=>$_GET["des"]));
$cadena .= "<footer><strong>TTG:</strong> <cite title='Source Title'>";

while($row = $stmt->fetch())
{
	$cadena .= $row[0]." ,";
}
$cadena = substr($cadena, 0, -1);
$cadena .= "</cite></footer>";


// Consulta para terminos TGP -------------
$stmt = $db->prepare("select TGP from tesauro_elementos where TG=:tg && descriptor=:descriptor && TGP!=''");
$stmt->execute(array(":tg"=>$_GET["tg"], ":descriptor"=>$_GET["des"]));
$cadena .= "<footer><strong>TGP:</strong> <cite title='Source Title'>";

while($row = $stmt->fetch())
{
	$cadena .= $row[0]." ,";
}
$cadena = substr($cadena, 0, -1);
$cadena .= "</cite></footer>";


// Consulta para terminos TEG -------------
$stmt = $db->prepare("select TEG from tesauro_elementos where TG=:tg && descriptor=:descriptor && TEG!=''");
$stmt->execute(array(":tg"=>$_GET["tg"], ":descriptor"=>$_GET["des"]));
$cadena .= "<footer><strong>TEG:</strong> <cite title='Source Title'>";

while($row = $stmt->fetch())
{
	$cadena .= $row[0]." ,";
}
$cadena = substr($cadena, 0, -1);
$cadena .= "</cite></footer>";

echo $cadena;

