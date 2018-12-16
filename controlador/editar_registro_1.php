<?php

/*
|--------------------------------------------------------------|
| Editar datos PESTAÑA 1                                       |
| Solo se ingresan datos si el usuario esta logueado           |
|--------------------------------------------------------------|
*/



$stmt2 = $db->prepare("select usuario from tesauro where usuario=:usuario");
$stmt2->execute(array(":usuario"=>$a->decrypt($_GET["usuario"],"dos")));
$row2 = $stmt2->fetch();

if($_POST["tipo_documento"]!="" && $_POST["vigencia"]!="" && $_POST["categoria"]!="")
{
    $id_puntero = $a->decrypt($_POST['token'],"tesa");

    $stmt2 = $db->prepare("update tesauro set tipo_documento=:tipo_documento,categoria=:categoria,vigencia=:vigencia where id=:puntero");
    $stmt2->execute(array(":tipo_documento"=>$_POST['tipo_documento'], ":vigencia"=>$_POST['vigencia'], ":categoria"=>$_POST['categoria'], ":puntero"=>$id_puntero));

} 