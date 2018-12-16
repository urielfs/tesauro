<?php 
include(get_template_directory()."/modelo/db.class.php");
include(get_template_directory()."/controlador/crear_registro_3.php");


if (is_user_logged_in()) {

 ?>


<form method="POST">

<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <input type="text" class="form-control" aria-describedby="basic-addon1" value="" name="pais">
  <span class="input-group-addon" id="basic-addon1">Pais de publicacion</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
<div class="col-lg-4">
<div class="input-group">
  <input type="date" class="form-control" aria-describedby="basic-addon2" name="fecha">
  <span class="input-group-addon" id="basic-addon2">Año</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-4 -->
</div><!-- /.row -->

<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <input type="text" class="form-control" placeholder="" aria-describedby="basic-addon3" name="revista">
  <span class="input-group-addon" id="basic-addon3">Revista</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <input type="text" class="form-control" placeholder="" aria-describedby="basic-addon4" name="volumen" value="">
  <span class="input-group-addon" id="basic-addon4">Volumen</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <input type="text" class="form-control" placeholder="" aria-describedby="basic-addon5" name="articulo_n" value="">
  <span class="input-group-addon" id="basic-addon5">Artículo Nº</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <input type="text" class="form-control" placeholder="" aria-describedby="basic-addon6" name="issue">
  <span class="input-group-addon" id="basic-addon6">Issue</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
<div class="col-lg-6">
<div class="input-group">
<input type="button" value="Continuar" class="btn btn-danger" onClick="javascript:
this.form.action=' http://redraus.org/tesauro_wp/ingreso-datos-4';
this.form.submit();
">
<input type="hidden" name="token" value="<?=$_POST['token']?>" />
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

</form>

<div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
    60%
  </div>
</div>

<?php
}

else {
  echo "Debe estar registrado para Ingresar Datos.";
}
?>