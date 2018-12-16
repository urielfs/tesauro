<?php
header('Content-Type: text/html; charset=ISO-8859-1');

require_once(dirname(dirname(__FILE__))."/iniciar.php");

$b->validaUsuario($a->decrypt($_GET["usuario"],"dos"));


$to = $destino;
$subject = "Registro en SICPMT";

$message = "
<html>
<head>
<title>Notificaci&oacute;n de registros</title>
</head>
<body>
<p>Notificación de ingreso SICPMT</p>
<table>
<tr>
<th>Usuario</th>
</tr>
<tr>
<td>".$to."</td>
</tr>
</table>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <no-responder@sicpmt.com>' . "\r\n";
$headers .= 'BCc: urielmartinez2012@me.com' . "\r\n";
//$headers .= 'BCc: masterjovs@hotmail.com' . "\r\n";

 if(mail($to,$subject,$message,$headers))
 {
	 echo "<div>Correo enviado<a role='link' href='index.php'>Inicio</a></div>";
 }
 else
 {
	 echo "Ocurrió un error <a role='link' href='http://redraus.org/sicpmt'>Inicio</a>";
 }
