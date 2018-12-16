<?php
//header('Content-Type: text/html; charset=ISO-8859-1');

require_once(dirname(dirname(__FILE__))."/iniciar.php");

if($_GET["id_t"]!="" && $_GET["descriptor"]!="" && $_GET["datotg"]!="")
{
	$cadena_descriptores .= "<b>Descriptor:</b> ".$b->get_Tesauro("descriptor",$_GET["descriptor"]);
	
	// Consulta TE
	$stmt = $db->prepare("select descriptor,TE from tesauro_elementos where id_t=:id && descriptor=:descriptor && TG=:tg && TE!=''");
	$stmt->execute(array(":id"=>$a->decrypt($_GET["id_t"],"tesa"), ":descriptor"=>$b->get_Tesauro("descriptor",$_GET["descriptor"]), ":tg"=>$b->get_Tesauro("TG",$_GET["datotg"])));
	
	while($row = $stmt->fetch())
	{
		
		$cadena_elementos .= "<li><b>TE</b> :".$row[1]."</li>";
	}
	
	// Consulta TR
	$stmt = $db->prepare("select descriptor,TR from tesauro_elementos where id_t=:id && descriptor=:descriptor && TG=:tg && TR!=''");
	$stmt->execute(array(":id"=>$a->decrypt($_GET["id_t"],"tesa"), ":descriptor"=>$b->get_Tesauro("descriptor",$_GET["descriptor"]), ":tg"=>$b->get_Tesauro("TG",$_GET["datotg"])));
	
	while($row = $stmt->fetch())
	{
		
		$cadena_elementos .= "<li><b>TR</b> :".$row[1]."</li>";
	}
	
	// Consulta NA
	$stmt = $db->prepare("select descriptor,NA from tesauro_elementos where id_t=:id && descriptor=:descriptor && TG=:tg && NA!=''");
	$stmt->execute(array(":id"=>$a->decrypt($_GET["id_t"],"tesa"), ":descriptor"=>$b->get_Tesauro("descriptor",$_GET["descriptor"]), ":tg"=>$b->get_Tesauro("TG",$_GET["datotg"])));
	
	while($row = $stmt->fetch())
	{
		
		$cadena_elementos .= "<li><b>NA</b> :".$row[1]."</li>";
	}
	
	// Consulta USE_for
	$stmt = $db->prepare("select descriptor,USE_for from tesauro_elementos where id_t=:id && descriptor=:descriptor && TG=:tg && USE_for!=''");
	$stmt->execute(array(":id"=>$a->decrypt($_GET["id_t"],"tesa"), ":descriptor"=>$b->get_Tesauro("descriptor",$_GET["descriptor"]), ":tg"=>$b->get_Tesauro("TG",$_GET["datotg"])));
	
	while($row = $stmt->fetch())
	{
		
		$cadena_elementos .= "<li><b>USE_for</b> :".$row[1]."</li>";
	}
	
	// Consulta UP
	$stmt = $db->prepare("select descriptor,UP from tesauro_elementos where id_t=:id && descriptor=:descriptor && TG=:tg && UP!=''");
	$stmt->execute(array(":id"=>$a->decrypt($_GET["id_t"],"tesa"), ":descriptor"=>$b->get_Tesauro("descriptor",$_GET["descriptor"]), ":tg"=>$b->get_Tesauro("TG",$_GET["datotg"])));
	
	while($row = $stmt->fetch())
	{
		
		$cadena_elementos .= "<li><b>UP</b> :".$row[1]."</li>";
	}
	
	// Consulta TC
	$stmt = $db->prepare("select descriptor,TC from tesauro_elementos where id_t=:id && descriptor=:descriptor && TG=:tg && TC!=''");
	$stmt->execute(array(":id"=>$a->decrypt($_GET["id_t"],"tesa"), ":descriptor"=>$b->get_Tesauro("descriptor",$_GET["descriptor"]), ":tg"=>$b->get_Tesauro("TG",$_GET["datotg"])));
	
	while($row = $stmt->fetch())
	{
		
		$cadena_elementos .= "<li><b>TC</b> :".$row[1]."</li>";
	}
	
	// Consulta TTG
	$stmt = $db->prepare("select descriptor,TTG from tesauro_elementos where id_t=:id && descriptor=:descriptor && TG=:tg && TTG!=''");
	$stmt->execute(array(":id"=>$a->decrypt($_GET["id_t"],"tesa"), ":descriptor"=>$b->get_Tesauro("descriptor",$_GET["descriptor"]), ":tg"=>$b->get_Tesauro("TG",$_GET["datotg"])));
	
	while($row = $stmt->fetch())
	{
		
		$cadena_elementos .= "<li><b>TTG</b> :".$row[1]."</li>";
	}
	
	// Consulta TGP
	$stmt = $db->prepare("select descriptor,TGP from tesauro_elementos where id_t=:id && descriptor=:descriptor && TG=:tg && TGP!=''");
	$stmt->execute(array(":id"=>$a->decrypt($_GET["id_t"],"tesa"), ":descriptor"=>$b->get_Tesauro("descriptor",$_GET["descriptor"]), ":tg"=>$b->get_Tesauro("TG",$_GET["datotg"])));
	
	while($row = $stmt->fetch())
	{
		
		$cadena_elementos .= "<li><b>TGP</b> :".$row[1]."</li>";
	}
	
	// Consulta TEG
	$stmt = $db->prepare("select descriptor,TEG from tesauro_elementos where id_t=:id && descriptor=:descriptor && TG=:tg && TEG!=''");
	$stmt->execute(array(":id"=>$a->decrypt($_GET["id_t"],"tesa"), ":descriptor"=>$b->get_Tesauro("descriptor",$_GET["descriptor"]), ":tg"=>$b->get_Tesauro("TG",$_GET["datotg"])));
	
	while($row = $stmt->fetch())
	{
		
		$cadena_elementos .= "<li><b>TEG</b> :".$row[1]."</li>";
	}
	
	$valores = array("descriptores"=>$cadena_descriptores, "elementos"=>$cadena_elementos);
}

$datos = $a->array_to_json($valores);

echo $datos;