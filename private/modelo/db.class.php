<?php

class database {
	private $conexion;
	
 public function Conectarse()

 {


    try {
        $db = new PDO("mysql:host=localhost;dbname=redrausc_tesauro", "redrausc_123", "t3s4ur0s1cpmt", array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''));
        $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, TRUE);
		//mysql_query("SET NAMES 'utf8'");
        return($db);
    } catch (PDOException $e) {
        cabecera("Error grave");
        print "<p>Error: No puede conectarse con la base de datos.</p>\n";
//      print "<p>Error: " . $e->getMessage() . "</p>\n";
        pie();
        exit();
    }	 

	}
	 
 public function encrypt($string, $key) 
 {

   $result = '';

   for($i=0; $i<strlen($string); $i++) {

      $char = substr($string, $i, 1);

      $keychar = substr($key, ($i % strlen($key))-1, 1);

      $char = chr(ord($char)+ord($keychar));

      $result.=$char;

   }

   return base64_encode($result);

 }

 public function decrypt($string, $key) 
 {

   $result = '';

   $string = base64_decode($string);

   for($i=0; $i<strlen($string); $i++) {

      $char = substr($string, $i, 1);

      $keychar = substr($key, ($i % strlen($key))-1, 1);

      $char = chr(ord($char)-ord($keychar));

      $result.=$char;

   }

   return $result;

 }
 
 public function recoge($var) 
 {
    $tmp = (isset($_REQUEST[$var]))
        ? strip_tags(trim(htmlspecialchars($_REQUEST[$var], ENT_QUOTES, "ISO-8859-1"))) 
        : "";
    if (get_magic_quotes_gpc()) {
        $tmp = stripslashes($tmp);
    }
    return $tmp;
 }

 public function array_to_json( $array ){

    if( !is_array( $array ) ){
        return false;
    }

    $associative = count( array_diff( array_keys($array), array_keys( array_keys( $array )) ));
    if( $associative ){

        $construct = array();
        foreach( $array as $key => $value ){

            // We first copy each key/value pair into a staging array,
            // formatting each key and value properly as we go.

            // Format the key:
            if( is_numeric($key) ){
                $key = "key_$key";
            }
            $key = "'".addslashes($key)."'";

            // Format the value:
            if( is_array( $value )){
                $value = array_to_json( $value );
            } else if( !is_numeric( $value ) || is_string( $value ) ){
                $value = "'".addslashes($value)."'";
            }

            // Add to staging array:
            $construct[] = "$key: $value";
        }

        // Then we collapse the staging array into the JSON form:
        $result = "{ " . implode( ", ", $construct ) . " }";

    } else { // If the array is a vector (not associative):

        $construct = array();
        foreach( $array as $value ){

            // Format the value:
            if( is_array( $value )){
                $value = array_to_json( $value );
            } else if( !is_numeric( $value ) || is_string( $value ) ){
                $value = "'".addslashes($value)."'";
            }

            // Add to staging array:
            $construct[] = $value;
        }

        // Then we collapse the staging array into the JSON form:
        $result = "[ " . implode( ", ", $construct ) . " ]";
    }

    return $result;
}

public function hin($string) {
	return htmlspecialchars($string);
}

}

class opciones extends database {

 public function consulta($campos,$revista) {

  $db=$this->Conectarse();

  $sql = $db->prepare("select $campos from tesauro where revista=:revista");
  $sql->execute(array(":revista"=>$revista));

  $row = $sql->fetch();
  return $row;

 }
 
 public function consulta_sql($tabla,$campos,$condicion) {
	 $db = $this->Conectarse();
	 
	 $sql = $db->prepare("select $campos from $tabla $condicion");
	 $sql->execute();
	 
	 return $sql;
 }

 public function consulta_standard($campos,$condicion) {
  
  $db=$this->Conectarse();
  
  $sql = $db->prepare("select $campos from tesauro $condicion");
  $sql->execute();

  
  return $sql;

 }

 
 public function datos_ext($id_puntero) {
	 $db = $this->Conectarse();
	 
	 $stmt = $db->prepare("select especie,concentracion,contaminante,id,matriz,concentracion_max,concentracion_min,lat_grados,lat_minutos,lat_segundos,latitud,lon_grados,lon_minutos,lon_segundos,longitud from tesauro_c where id_t=:id && deleted=0");
     $stmt->execute(array(":id"=>$id_puntero));
	 
	 
	 return $stmt;
 }
 
 public function cuantasEspecies($id_puntero) {
	 
	 $db = $this->Conectarse();
	 $stmt = $db->prepare("select count(id_t),id_t from tesauro_c where deleted=0 && id_t=:id && deleted=0 group by id_t");
	 $stmt->execute(array(":id"=>$id_puntero));
	 
	 return $stmt;
 }
 
 public function verLista($item) {
	 $db = $this->Conectarse();
	 
	 $stmt = $db->prepare("select valor from tesauro_cstm where label=:label && deleted=0 order by valor");
	 $stmt->execute(array(":label"=>$item));
	 $cadena = "";
	 
	 while($row = $stmt->fetch()) {
		 
		 $cadena .= "<option value='".$row[0]."'>".$row[0]."</option>";
	 }
	 
	 return $cadena;
 }
 
 public function get_Tesauro($item,$id) {
	 $db = $this->Conectarse();
	 $stmt = $db->prepare("select $item from tesauro_elementos where id=:id");
	 $stmt->execute(array(":id"=>$id));
	 $row = $stmt->fetch();
	 
	 return $row[0];
 }

 public function registroUser($usuario,$pas) {
   $db = $this->Conectarse();
   

   $password_encriptado = password_hash($pas, PASSWORD_BCRYPT);
   
   $stmt = $db->prepare("insert into usuarios(usuario,pas) values(:usuario,:pas)");
   if($stmt->execute(array(":usuario"=>$usuario, ":pas"=>$password_encriptado))) {

     $mensaje = true;
   }
   else {
     $mensaje = false;
   }

   return $mensaje;

}


 public function validaPerfil($usuario) {
   $db = $this->Conectarse();
   $stmt = $db->prepare("select perfil from usuarios where usuario=:usuario");
   $stmt->execute(array(":usuario"=>$usuario));
   $row = $stmt->fetch();

    if($row[0]!="") {
      
      $permisos = $row[0];
    }
    else {

      $permisos = false;
    }
  
  return $permisos;

 }
 
 public function validaUsuario($usuario) {
	 $db = $this->Conectarse();
	 
	 $stmt = $db->prepare("select status,time from usuarios where usuario=:usuario");
	 $stmt->execute(array(":usuario"=>$usuario));
	 $row = $stmt->fetch();
	 
	 if($row[0]==0)
	 {
		 echo "Sesion cerrada <a role='link' href='../index.php'>Inicio</a>";
		 exit;
	 }
	 
	 
 }
 
 public function sesionUsuario($usuario) {
	 $db = $this->Conectarse();
	 
	 $stmt = $db->prepare("update usuarios set status=1 where usuario=:usuario");
	 $stmt->execute(array(":usuario"=>$usuario));
 }


 public function ingresoUsuario($usuario,$pas) {

  $db = $this->Conectarse();
  $stmt = $db->prepare("select pas from usuarios where usuario=:usuario");
  $stmt->execute(array(":usuario"=>$usuario));
  $row = $stmt->fetch();

  $coincide_password = password_verify($pas, $row[0]);
  $dato = ($coincide_password ? 'Correcto' : 'Credenciales Incorrectas');
  
  if($dato == 'Correcto')
  {
	  $otrostmt = $db->prepare("update usuarios set status=1 where usuario=:usuario");
	  $otrostmt->execute(array(":usuario"=>$usuario));
  }
  return $dato;
 
 }
 
 public function ver_TG($id) {
	 $db = $this->Conectarse();
	 
	 $stmt = $db->prepare("select TG,id from tesauro_elementos where id_t=:id group by TG");
	 $stmt->execute(array(":id"=>$id));
	 $cadena = "";
	 
	 while($row = $stmt->fetch())
	 {
		 $cadena .= "<option value='".$row[1]."'>".$row[0]."</option>";
	 }
	 
	 return $cadena;
 }
 
 public function ver_Descriptor($id,$tg) {
	 $db = $this->Conectarse();
	 
	 $stmt = $db->prepare("select descriptor,id from tesauro_elementos where id_t=:id && TG=:tg && descriptor!='' group by descriptor");
	 $stmt->execute(array(":id"=>$id, ":tg"=>$tg));
	 
	 while($row = $stmt->fetch())
	 {
		 $cadena .= "<option value='".$row[1]."'>".$row[0]."</option>";
	 }
	 
	 return $cadena;
 }
 
 public function ver_TE($id,$tg,$descriptor)
 {
	$db = $this->Conectarse();
	$stmt = $db->prepare("select TE,TR,NA from tesauro_elementos where id_t=:id && TG=:tg && descriptor=:descriptor");
	$stmt->execute(array(":id"=>$id, ":tg"=>$tg, ":descriptor"=>$descriptor));
	
	while($row = $stmt->fetch())
	{
		$cadena .= "<option>TE:$row[0]|TR:$row[1]|NA:$row[2]</option>";
	}
	 return $cadena;
 }

 public function redirigir_a($new_location) {
  header("Location: " . $new_location);
  exit;
 }

  public function convertirGD($lat_g,$lat_m,$lat_s,$lon_g,$lon_m,$lon_s,$lat_und,$lon_und) {
	 
	 $valores = array();

// Coordenadas GD
  $latitud = $lat_g+($lat_m/60)+($lat_s/3600);
  $longitud = $lon_g+($lon_m/60)+($lon_s/3600);
   
   if($lat_und=="S")
   { $latitud = $latitud*(-1); }
   if($lon_und=="W")
   { $longitud = $longitud*(-1); }

  $valores[]=$latitud;
  $valores[]=$longitud;
  $valores[]=$lat_entero;
  $valores[]=$lon_entero;
	 return $valores;
	 
 }
 
 public function contar_palabra($string)
 {
	 $db = $this->Conectarse();
	 
	 $sql = "select titulo
             , resumen
             , length(resumen) as largo_cadena
             , length(replace(resumen,'$string','')) as largo_cadena_sin_palabra
             , format(((length(resumen)-length(replace(resumen,'$string','')))/length('$string')), 0)
               as veces
        from   tesauro where resumen!='' && deleted=0";
		
		  $consulta = $db->prepare($sql);
		  $consulta->execute();
		  $contador = 0;
		  
		  while($row_consulta = $consulta->fetch(PDO::FETCH_ASSOC))
		  {
			  $contador = $contador + $row_consulta["veces"];
		  }
	 
	 return $contador;
 }
 
 public function wordc($campo)
 {
	$db = $this->Conectarse();
	$stmt = $db->prepare("select $campo from tesauro where deleted=0 && $campo!=''");
	$stmt->execute();
	$vector = array();
	
	while($row_stmt = $stmt->fetch())
		  {
			  $cadena = explode(" ", $row_stmt[0]);
			  $vector[] = $cadena;
		  }
	
	foreach($vector as $clave=>$valor)
		  {
			  sort($valor); // Ordeno vector con palabras
			  foreach($valor as $dato)
			  {
				
				// Elimino valores duplicados en el vector
				if($dato!=$temp)
				{	
				  $string = $dato;
//				  echo "<li><a href='#'>";
				  
				  
//				  echo $dato." |".$b->contar_palabra($string)."|</a>";
				  $palabras[$dato] = $b->contar_palabra($string); 
//				  echo "</li>";
				  $temp = $dato;
				  
				}
			  }
			  
		  }
		  
	$palabras = array();
	
	$resultado = "<div id='listaE'>";
	$resultado .=  "<ul>";
		  
		  foreach($palabras as $clave=>$valor)
		  {
			  if($valor > 5)
			  {
				  switch($clave)
				  {
					  case "para":
					  break;
					  
					  case "en":
					  break;
					  
					  case "el":
					  break;
					  
					  case "e":
					  break;
					  
					  case "un":
					  break;
					  
					  case "con":
					  break;
					  
					  case "la":
					  break;
					  
					  case "del":
					  break;
					  
					  case "por":
					  break;
					  
					  case "del":
					  break;
					  
					  default:
					  $resultado .= "<li><a href='#'>".$clave."</a></li>"; 
				  }
				  
			  }
		  }
		  
		  $resultado .= "</ul>";
		  $resultado .= "</div>";
	
	return $resultado;
 }

 public function envioCorreo($destino,$message) {
   $db = $this->Conectarse();
   
$to = $destino;
$subject = "Registro en SICPMT";

if($message == "")
{
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
}

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <no-responder@sicpmt.com>' . "\r\n";
$headers .= 'BCc: ellie.lopez@usa.edu.co' . "\r\n";
$headers .= 'BCc: urielmartinez2012@me.com' . "\r\n";
//$headers .= 'BCc: masterjovs@hotmail.com' . "\r\n";

 if(mail($to,$subject,$message,$headers))
 {
	 return true;
 }
 else
 {
	 return false;
 }


 }


 public function forgotClave($destino) {
   $db = $this->Conectarse();
   
   $stmt = $db->prepare("select usuario from usuarios where usuario=:usuario");
   $stmt->execute(array(":usuario"=>$destino));
   $row = $stmt->fetch();
   
$to = $destino;
$subject = "Reinicio acceso en SICPMT";

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
<th>Clave</th>
</tr>
<tr>
<td>".$row[0]."</td>
<td></td>
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
	 return true;
 }
 else
 {
	 return false;
 }


 }
 

}

// Inicializo la Conexion

$a = new database;
$b = new opciones;

$db = $a->Conectarse();

?>