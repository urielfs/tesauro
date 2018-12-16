<?php
/*
include("iniciar.php");

$mvc = new MvcController();

$respuesta = $mvc->consultaController();


$cadena = '{
				  "draw": 1,
				  "recordsTotal": 200,
				  "recordsFiltered": 50,
				  "data": [
		';
		
		foreach($respuesta as $clave=>$valor)
		{
			$cadena .= '{';
			$cadena .= '"operacion": "'.$valor["operacion"].'",';
			$cadena .= '"fase": "'.trim($valor["FASE"]).'",';
			$cadena .= '"cambio": "'.$valor["CAMBIO_ORDEN"].'",';
			$cadena .= '"tarea": "'.$valor["PROYECTO"].'",';
			$cadena .= '"cliente": "'.trim($valor["CLIENTE"]).'",';
			$cadena .= '"fecha": "'.trim($valor["F_PROPUESTA"]).'"';
			
			
			
			$cadena .= '},';
		}
		
		$cadena=substr($cadena,0,(strlen($cadena)-1));
		$cadena .= ']}';
		
*/

	
		// DB table to use
$table = 'tesauro';
 
// Table's primary key
$primaryKey = 'id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'categoria', 'dt' => 0 ),
    array( 'db' => 'autor',  'dt' => 1 ),
	array( 'db' => 'titulo',   'dt' => 2 ),
	array( 
		'db' => 'id',  'dt' => 3,
		'formatter' => function( $d, $row ) {
				
				$cadena_busqueda = '<a href=\'v.consultas.php?id='.$row[3].'\'><span class=\'glyphicon glyphicon-search\' aria-hidden=\'true\'></span></a>';
				
				return $cadena_busqueda;
				# ---
			}
		)

);
 
// SQL server connection information
$sql_details = array(
    'user' => 'redrausc_123',
    'pass' => 't3s4ur0s1cpmt',
    'db'   => 'redrausc_tesauro',
    'host' => 'localhost'
);
 
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
require( 'ssp.class.php' );

$sql = 'deleted=0 && titulo like "%'.$_POST['busca_titulo'].'%"';
//$sqlo = 'order by categoria';

echo json_encode(
    SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns )
	//simple ( $request, $conn, $table, $primaryKey, $columns )
	//SSP::complex ( $_POST, $sql_details, $table, $primaryKey, $columns, $whereResult=null, $whereAll=$sql )
);
