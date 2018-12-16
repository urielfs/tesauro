<?php
class Conexion{

	public function conectar(){

		
		$link = new PDO("mysql:host=localhost;dbname=redrausc_tesauro", "redrausc_123", "t3s4ur0s1cpmt", array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''));
		#$link = new PDO("mysql:host=localhost;dbname=redrausc_tesauro","redrausc_123","");
		#$link = setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, TRUE);
		
		return $link;
			
		
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
 
}
