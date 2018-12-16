<?php

/*
|--------------------------------------------------------------|
| Editar datos PESTAÑA 2                                       |
| autor=:autor,titulo,keywords,resumen                         |
| Solo se modifican datos si el usuario esta logueado          |
|--------------------------------------------------------------|
*/

// Nombre Campos a actualizar
   $campos = "autor=:autor,titulo=:titulo,keywords=:keywords,resumen=:resumen";




$stmt2 = $db->prepare("select usuario from tesauro where usuario=:usuario");
$stmt2->execute(array(":usuario"=>$a->decrypt($_GET["usuario"],"dos")));
$row2 = $stmt2->fetch();


    $id_puntero = $a->decrypt($_GET['token'],"tesa");
    
    if($_POST['autor']!="" && $_POST['titulo']!="" && $_POST['palabras']!="" && $_POST['resumen']!="")
	{
    $stmt2 = $db->prepare("update tesauro set $campos where id=:puntero");
    $stmt2->execute(array(
                          ':autor'=>$_POST['autor'],
                          ':titulo'=>($_POST['titulo']),
                          ':keywords'=>$_POST['palabras'],
						  ':resumen'=>$_POST['resumen'],
                          ':puntero'=>$id_puntero
						  )
					);
	}
