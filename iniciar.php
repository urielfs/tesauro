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


/*
require_once(PRIVATE_PATH . "/funciones/funciones_generales.php");

require_once(PRIVATE_PATH . "/funciones/csrf_funciones_solicitud.php");
require_once(PRIVATE_PATH . "/funciones/csrf_funciones_token.php");
require_once(PRIVATE_PATH . "/funciones/solicitudes_suplantadas.php");
require_once(PRIVATE_PATH . "/funciones/metodos_interceptar_fijar_sesiones.php");
require_once(PRIVATE_PATH . "/funciones/sqli_funciones_escape.php");
require_once(PRIVATE_PATH . "/funciones/funciones_limitar.php");
require_once(PRIVATE_PATH . "/funciones/funciones_lista_negra.php");
require_once(PRIVATE_PATH . "/funciones/validaciones.php");
require_once(PRIVATE_PATH . "/funciones/xss_funciones_desinfectar.php");
*/
?>
