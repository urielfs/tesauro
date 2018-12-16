<?php


$a=new database;
$b=new opciones;

$db=$a->Conectarse();

$campos="pais,fecha,revista,volumen,articulo_numero,issue";
$resultado=$b->consulta($campos,$_POST['busca_revista']);

