<?php
// Personalizar todas las inicializaciones aqui

// Definir constantes
// y directorios privados
define("APP_ROOT", dirname(dirname(__FILE__)));


define("PRIVATE_PATH", APP_ROOT . "/sicpmt/private");
define("PUBLIC_PATH", APP_ROOT . "/sicpmt/tesauro");

//session_start();

require_once(PRIVATE_PATH . "/modelo/db.class.php");
require(PRIVATE_PATH . "/modelo/conexion.php");
require(PRIVATE_PATH . "/modelo/crud.php");
require(PRIVATE_PATH . "/controlador2/controlador.php")


?>
