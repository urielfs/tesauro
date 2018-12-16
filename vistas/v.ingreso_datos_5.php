<?php 
include(get_template_directory()."/modelo/db.class.php");
include(get_template_directory()."/controlador/crear_registro_5.php");


if (is_user_logged_in()) {

 ?>


<form method="POST">

<div class="row">
<div class="col-lg-8">
<div class="input-group">
  <input type="text" class="form-control" aria-describedby="basic-addon1" value="" name="terminos_tesauro">
  <span class="input-group-addon" id="basic-addon1">T&eacute;rminos Tesauro</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
<div class="col-lg-8">
<div class="input-group">
  <input type="text" class="form-control" aria-describedby="basic-addon1" value="" name="titulador">
  <span class="input-group-addon" id="basic-addon1">Titulador</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->


<div class="row">
<div class="col-lg-8">
<div class="input-group">
  <input type="text" class="form-control" aria-describedby="basic-addon1" value="" name="estado_titulacion">
  <span class="input-group-addon" id="basic-addon1">Estado titulaci&oacute;n</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
<div class="col-lg-8">
<div class="input-group">
  <input type="date" class="form-control" aria-describedby="basic-addon1" value="" name="fecha_entrega">
  <span class="input-group-addon" id="basic-addon1">Fecha entrega</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->


<div class="row">
<div class="col-lg-8">
<div class="input-group">
  <input type="text" class="form-control" aria-describedby="basic-addon1" value="" name="revision_titulacion">
  <span class="input-group-addon" id="basic-addon1">Revisi&oacute;n titulaci&oacute;n</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->


<div class="row">
<div class="col-lg-8">
<div class="input-group">
  <input type="date" class="form-control" aria-describedby="basic-addon1" value="" name="fecha_revision">
  <span class="input-group-addon" id="basic-addon1">Fecha revisi&oacute;n</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->


<div class="row">
<div class="col-lg-8">
<div class="input-group">
  <textarea class="form-control" aria-describedby="basic-addon1" name="observaciones"></textarea>
  <span class="input-group-addon" id="basic-addon1">Observaciones</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->


<div class="row">
<div class="col-lg-8">
<div class="input-group">
  <textarea class="form-control" aria-describedby="basic-addon1" name="notas_relacion"></textarea>
  <span class="input-group-addon" id="basic-addon1">Notas relaci&oacute;n</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
<div class="col-lg-8">
<div class="input-group">
<input type="button" value="Continuar" class="btn btn-danger" onClick="javascript:
this.form.action=' http://redraus.org/tesauro_wp/ingreso-datos-6';
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