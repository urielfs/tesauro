<?php 
include(get_template_directory()."/modelo/db.class.php");
include(get_template_directory()."/controlador/crear_registro_2.php");

?>

<?php 
if (is_user_logged_in()) {


?>
<form method="POST">
<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <input type="text" class="form-control" aria-describedby="basic-addon1" name="autor">
  <span class="input-group-addon" id="basic-addon1">Emisor Autor</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <input type="text" class="form-control" placeholder="Titulo" aria-describedby="basic-addon2" name="titulo">
  <span class="input-group-addon" id="basic-addon2">Título</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <input type="text" class="form-control" placeholder="" aria-describedby="basic-addon3" name="palabras">
  <span class="input-group-addon" id="basic-addon3">Palabras claves</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <textarea class="form-control" aria-describedby="basic-addon4" name="resumen"></textarea>
  <span class="input-group-addon" id="basic-addon4">Resumen</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <input type="button" class="btn btn-danger" value="Continuar" onClick="javascript:
this.form.action='http://redraus.org/tesauro_wp/ingreso-datos-3';
this.form.submit();
">
  <input type="hidden" name="token" value="<?=$_POST['token']?>">
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%;">
    40%
  </div>
</div>

</form>
<?php
}

else {
  echo "Debe estar registrado para Ingresar Datos.";
}
?>