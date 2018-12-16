<?php
//header('Content-Type: text/html; charset=ISO-8859-1');
require_once(dirname(dirname(__FILE__))."/iniciar.php");

if($_GET["use"]!="")
{
	$b->validaUsuario($a->decrypt($_GET["use"],"dos"));
	
		
}
else {
	echo "Sesion cerrada <a href='../index.php' role='link'>Inicio</a>";
	exit;
}

// ---------------------- Script para ingresar DAtos -------------
// No se permiten valores repetidos para el mismo item -----------
// ---------------------------------------------------------------

if($_GET["dato"]!="" && $_GET["opcion"]!="del") {
	
	$sql = $db->prepare("select valor from tesauro_cstm where label=:item && valor=:valor && deleted=0");
	$sql->execute(array(":item"=>$_GET["item"], ":valor"=>$_GET["dato"]));
	$row_sql = $sql->fetch();
	
	if($row_sql[0]==$_GET["dato"]) {
		
		$resultado = "<div class='alert alert-info' role='alert'>Dato existente!</div>";
		
		$valores = array("token"=>"true", "resultado"=>$resultado);

	}
	else {
		
		if($_GET["item"] == "especies")
		{
			
			
			$nombre_img = $_GET['dato2'];
			$stmt = $db->prepare("insert into tesauro_cstm (label,valor,valor2,usuario,act,deleted) values(:item,:valor,:valor2,:usuario,:act,:deleted)");
			$valores_ingresados = array(":item"=>$_GET["item"], ":valor"=>$_GET["dato"], ":valor2"=>$nombre_img, ":usuario"=>$a->decrypt($_GET["use"],"dos"), ":act"=>date("Y-m-d H:i:s"), ":deleted"=>"0");
		} else 
		{
			$stmt = $db->prepare("insert into tesauro_cstm (label,valor,usuario,act,deleted) values(:item,:valor,:usuario,:act,:deleted)");
			$valores_ingresados = array(":item"=>$_GET["item"], ":valor"=>$_GET["dato"], ":usuario"=>$a->decrypt($_GET["use"],"dos"), ":act"=>date("Y-m-d H:i:s"), ":deleted"=>"0");
		}
	
		
		
		if($stmt->execute($valores_ingresados))
		{
	
			$resultado = "<div class='alert alert-success' role='alert'>Valor Ingresado!</div>";
		}
		else 
		{
			$resultado = "<div class='alert alert-warning' role='alert'>Ocurrio un error!</div>";
		}


	$stmt2 = $db->prepare("select MAX(id) from tesauro_cstm");
	$stmt2->execute();
	$row_stmt2 = $stmt2->fetch();

	$valores = array("token"=>"false", "dato_v"=>$row_stmt2[0], "dato_t"=>$_GET["dato"], "resultado"=>$resultado);

	

		}

}




// ----------------- Script para borrar datos -------------------

if($_GET["opcion"]=="del")
{
	$stmt = $db->prepare("update tesauro_cstm set deleted=1,act=:fecha where valor=:id");
	
	if($stmt->execute(array(":id"=>$_GET["dato"], ":fecha"=>date("Y-m-d H:i:s"))))
	{
		$resultado = "<div class='alert alert-danger' role='alert'>Registro borrado!</div>";
		$valores = array("token"=>"true", "resultado"=>$resultado, "opcion"=>"borrado", "valor"=>$_GET["dato"]);

		
	}
	else 
	{
		$resultado = "<div class='alert alert-warning' role='alert'>Ocurrio un error!</div>";
		$valores = array("token"=>"true", "resultado"=>$resultado);

		
	}
}

//$valores = array("resultado"=>"Imprimo resultado");
//$valores = array("token"=>"false", "dato_v"=>"un valor", "dato_t"=>"un texto", "resultado"=>"resultado actualizado");
$datos = $a->array_to_json($valores);

echo $datos;
