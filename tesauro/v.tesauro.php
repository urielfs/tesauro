<?php
header('Content-Type: text/html; charset=ISO-8859-1');
require_once(dirname(dirname(__FILE__))."/iniciar.php");
include("tesauro.php");

function consultaPHP($valor) {
$stmt = $db->prepare("select TE from tesauro_elementos where TG=:tg");
$stmt->execute(array(":tg"=>$valor));
$row = $stmt->fetch();

$cadena = array("resultado"=>$row[0]);
return $b->array_to_json($cadena);
}

?>
<div class="container">
<form method="POST" name="form1">
<input type="hidden" name="busca_dato" id="busca_dato">

<nav aria-label="...">
  <ul class="pagination pagination-sm">
        <li><a href="javascript:void(0)" onclick="javascript:document.form1.busca_dato.value='A'; document.form1.submit();">A</a></li>
	<li><a href="javascript:void(0)" onclick="javascript:document.form1.busca_dato.value='B'; document.form1.submit();">B</a></li>
	<li><a href="javascript:void(0)" onClick="javascript:document.form1.busca_dato.value='C'; document.form1.submit();">C</a></li>
	<li><a href="javascript:void(0)" onclick="javascript:document.form1.busca_dato.value='D'; document.form1.submit();">D</a></li>
	<li><a href="javascript:void(0)" onclick="javascript:document.form1.busca_dato.value='E'; document.form1.submit();">E</a></li>
	<li><a href="javascript:void(0)" onclick="javascript:document.form1.busca_dato.value='F'; document.form1.submit();">F</a></li>
	<li><a href="javascript:void(0)" onclick="javascript:document.form1.busca_dato.value='G'; document.form1.submit();">G</a></li>
	<li><a href="javascript:void(0)" onclick="javascript:document.form1.busca_dato.value='H'; document.form1.submit();">H</a></li>
	<li><a href="javascript:void(0)" onclick="javascript:document.form1.busca_dato.value='I'; document.form1.submit();">I</a></li>
	<li><a href="javascript:void(0)" onclick="javascript:document.form1.busca_dato.value='J'; document.form1.submit();">J</a></li>
	<li><a href="javascript:void(0)" onclick="javascript:document.form1.busca_dato.value='K'; document.form1.submit();">K</a></li>
	<li><a href="javascript:void(0)" onclick="javascript:document.form1.busca_dato.value='L'; document.form1.submit();">L</a></li>
	<li><a href="javascript:void(0)" onclick="javascript:document.form1.busca_dato.value='M'; document.form1.submit();">M</a></li>
	<li><a href="javascript:void(0)" onclick="javascript:document.form1.busca_dato.value='N'; document.form1.submit();">N</a></li>
	<li><a href="javascript:void(0)" onclick="javascript:document.form1.busca_dato.value='O'; document.form1.submit();">O</a></li>
	<li><a href="javascript:void(0)" onclick="javascript:document.form1.busca_dato.value='Ó'; document.form1.submit();">Ó</a></li>
	<li><a href="javascript:void(0)" onclick="javascript:document.form1.busca_dato.value='P'; document.form1.submit();">P</a></li>
	<li><a href="javascript:void(0)" onclick="javascript:document.form1.busca_dato.value='Q'; document.form1.submit();">Q</a></li>
	<li><a href="javascript:void(0)" onclick="javascript:document.form1.busca_dato.value='R'; document.form1.submit();">R</a></li>
	<li><a href="javascript:void(0)" onclick="javascript:document.form1.busca_dato.value='S'; document.form1.submit();">S</a></li>
	<li><a href="javascript:void(0)" onclick="javascript:document.form1.busca_dato.value='T'; document.form1.submit();">T</a></li>
	<li><a href="javascript:void(0)" onclick="javascript:document.form1.busca_dato.value='U'; document.form1.submit();">U</a></li>
	<li><a href="javascript:void(0)" onclick="javascript:document.form1.busca_dato.value='V'; document.form1.submit();">V</a></li>
	<li><a href="javascript:void(0)" onclick="javascript:document.form1.busca_dato.value='W'; document.form1.submit();">W</a></li>
	<li><a href="javascript:void(0)" onclick="javascript:document.form1.busca_dato.value='X'; document.form1.submit();">X</a></li>
	<li><a href="javascript:void(0)" onclick="javascript:document.form1.busca_dato.value='Y'; document.form1.submit();">Y</a></li>
	<li><a href="javascript:void(0)" onclick="javascript:document.form1.busca_dato.value='Z'; document.form1.submit();">Z</a></li>
  </ul>
</nav>
<div class="row">
<div class="col-md-6"><?=$cadena?></div>

<!--<div class="row"><div id="resultado"></div></div>-->
<div id="resultadoTR" class="col-md-6"></div>
</div>
</form>
</div>