<?php



//echo "<br>".$registro."<br>";

if (is_user_logged_in()) {

include(get_template_directory()."/modelo/db.class.php");


  if($registro = "ok") {

  include(get_template_directory()."/controlador/crear_registro.php");

?>

<form method="POST">
<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <select class="form-control" aria-describedby="basic-addon2" name="tipo_documento">
   <option value="ARTICULO_CIENTIFICO">ART&Iacute;CULO CIENT&Iacute;FICO</option>
   <option value="LEY">LEY</option>
   <option value="DECRETO">DECRETO</option>
   <option value="CONVENIO">CONVENIO</option>
   <option value="LEY">NORMA T&Eacute;CNICA</option>
   <option value="TESIS">TESIS</option>
   <option value="INFORME_TECNICO">INFORME T&Eacute;CNICO</option>
   <option value="CAPITULO_LIBRO">CAP&Iacute;TULO DE LIBRO</option>
   <option value="SENTENCIA">SENTENCIA</option>
   <option value="LIBRO">LIBRO</option>
  </select>
  <span class="input-group-addon" id="basic-addon2">Tipo de Documento</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <select class="form-control" aria-describedby="basic-addon3" name="categoria">
    <option value="INGENIERIA">Ingenier&iacute;a</option>
    <option value="QUIMICA">Qu&iacute;mica</option>
    <option value="BIOLOGIA">Biolog&iacute;a</option>
    <option value="Categoria D">Categor&iacute;a D</option>
  </select>
  <span class="input-group-addon" id="basic-addon3">  Categoria</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
<div class="col-lg-6">
<div class="input-group">
  <input type="date" class="form-control" placeholder="Vigencia" aria-describedby="basic-addon4" name="vigencia">
  <span class="input-group-addon" id="basic-addon4">yyyy-mm-dd</span>
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
<div class="col-lg-6">
<div class="input-group">
 <input type="button" class="btn btn-danger" value="Continuar" onClick="javascript:
this.form.action='http://redraus.org/tesauro_wp/ingreso-datos-2/';
this.form.submit();
" />
 <input type="hidden" name="token" value="<?=$puntero?>" />
</div><!-- /input-group -->
</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

</form>

<div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%;">
    20%
  </div>
</div>

<?php
 }

}
else {
  echo "Debe estar registrado para Ingresar Datos.";
}
?>