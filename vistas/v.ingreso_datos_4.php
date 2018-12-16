<?php 
include(get_template_directory()."/modelo/db.class.php");
include(get_template_directory()."/controlador/crear_registro_4.php");


if (is_user_logged_in()) {

 ?>


<form method="POST">

<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <input type="text" class="form-control" aria-describedby="basic-addon1" value="" name="pais_muestreo">
  <span class="input-group-addon" id="basic-addon1">Pais muestreo</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <input type="text" class="form-control" aria-describedby="basic-addon1" value="" name="region">
  <span class="input-group-addon" id="basic-addon1">Regi&oacute;n</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->


<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <input type="text" class="form-control" aria-describedby="basic-addon1" value="" name="latitud">
  <select name="und_latitud">
    <option value="N">N</option>
	<option value="S">S</option>
  </select>
  <span class="input-group-addon" id="basic-addon1">Latitud</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <input type="text" class="form-control" aria-describedby="basic-addon1" value="" name="longitud">
  <select name="und_longitud">
    <option value="E">E</option>
	<option value="O">O</option>
  </select>
  <span class="input-group-addon" id="basic-addon1">Longitud</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->


<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <input type="text" class="form-control" aria-describedby="basic-addon1" value="" name="matriz">
  <span class="input-group-addon" id="basic-addon1">Matriz</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<?=$cadena_especie?>

<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <!--<select name="especie" class="form-control" aria-describedby="basic-addon1">
    <option value="SALMON">SALM&Oacute;N</option>
	<option value="ROBALO">R&Oacute;BALO</option>
	<option value="ATUN">AT&Uacute;N</option>
	<option value="BASA">BASA</option>
  </select> -->
  <input type="button" class="btn btn-info" value="+" onClick="javascript:
  this.form.action='http://redraus.org/tesauro_wp/ingreso-datos-4?token_especie=add';
  this.form.submit();">
  <input type="button" class="btn btn-info" value="-" onClick="javascript:
  this.form.action='http://redraus.org/tesauro_wp/ingreso-datos-4?token_especie=del';
  this.form.submit();">
  <span class="input-group-addon" id="basic-addon1">Especie</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->


<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <input type="text" class="form-control" aria-describedby="basic-addon1" value="" name="contaminante">
  <span class="input-group-addon" id="basic-addon1">Contaminante</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
<div class="col-lg-6">
<div class="input-group">
<input type="button" value="Continuar" class="btn btn-danger" onClick="javascript:
this.form.action=' http://redraus.org/tesauro_wp/ingreso-datos-5';
this.form.submit();
">
<input type="hidden" name="token" value="<?=$_POST['token']?>" />
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

</form>

<div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%;">
    80%
  </div>
</div>

<?php
}

else {
  echo "Debe estar registrado para Ingresar Datos.";
}
?>