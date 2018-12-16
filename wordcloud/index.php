<?php 
require_once(dirname(dirname(__FILE__))."/iniciar.php");

function nube_etiquetas($etiquetas){
   //saco los valores máximo y minimo de la apariciones de etiquetas
   $valor_max = max($etiquetas);
   $valor_min = min($etiquetas);
   $diferencia = $valor_max - $valor_min;
   
   //ordeno el array
   ksort($etiquetas);
   
   //creo la capa donde se van a mostrar las etiquetas
   echo '<div class="nube">';
   echo '<div class="etiquetas">';
   
   foreach ($etiquetas as $nombreetiqueta => $apariciones){
      //calculo un valor de 0 a 10 para cada etiqueta, porcentualmente según valores máximos y mínimos encontrados
      $valor_relativo = round((($apariciones - $valor_min) / $diferencia) * 10);
      
      
	  // Considero palabras con valor_relativo > 0
	  $contador_tags = 0;
	  if($valor_relativo > 0)
	  {
	    //escribo las etiquetas con su estilo dependiendo del valor porcentual
		echo "<span class='etiquetatam$valor_relativo'>";
        echo $nombreetiqueta;
        echo "</span> <span> </span> ";
		$contador_tags ++;
	  }
   }
   //meto una capa sin float para que tome todo el alto de las etiquetas
   echo "<div style='clear:both'></div>";
   //cierro la nube y las etiquetas
   echo '</div>';
   echo '</div>';
}

?>
<!DOCTYPE html>
<html lang="sp">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="Uriel MArtinez-Jose Vargas">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="icon" href="../../favicon.ico">

	
<style type="text/css">

</style>
	
    <title>WordCLOUD-SICPMT</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="bootstrap/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
	
	<!-- Custom styles for this template -->
    <link href="blog.css" rel="stylesheet">
    
    <!-- Custom styles for this template -->
    <link href="../sticky-footer-navbar.css" rel="stylesheet">
	
	<!-- Wordcloud -->
	<link href="wordcloud.css" rel="stylesheet">
	<link href="words.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script type='text/javascript'>



$(document).ready(function(){
  var element = $('#listaE a');
  var offset = 0;
  var stepping = 0.03;
  var list = $('#listaE');
  var $list = $(list);
  $list.mousemove(function(e){
    var topOfList = $list.eq(0).offset().top;
    var listHeight = $list.height();
    stepping = (e.clientY ) /  listHeight * 0.2 - 0.1;
  });
  for (var i = element.length - 1; i >= 0; i--){
    element[i].elemAngle = i * Math.PI * 2 / element.length;
  }
  setInterval(render, 20);
  list.show();
  function render(){
    for (var i = element.length - 1; i >= 0; i--){
      var angle = element[i].elemAngle + offset;
      x = 120 + Math.sin(angle) * 30;
      y = 45 + Math.cos(angle) * 30;
      size = Math.round(20 - Math.sin(angle) * 20);
      var elementCenter = $(element[i]).width() / 2;
      var leftValue = (($list.width()/2) * x / 100 - elementCenter) + "px";
      $(element[i]).css("fontSize", size + "pt");
      $(element[i]).css("opacity",size/100);
      $(element[i]).css("zIndex" ,size);
      $(element[i]).css("left" ,leftValue);
      $(element[i]).css("top", y + "%");
    }
    offset += stepping;
  }
});

	</script>	

	
	
  </head>
  
<body>

    <div class="blog-masthead">
      <div class="container">
        <nav class="blog-nav">
          <a class="blog-nav-item active" href="#"></a>
          
        </nav>
      </div>
    </div>

    <div class="container">

<form method="POST" name="form1">
<input type="hidden" name="busca_dato" id="busca_dato">

<!--
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
-->	
      <div class="blog-header">
        <h1 class="blog-title">Nube de Palabras - SICPMT</h1>
        
      </div>

      <div class="row">

        <div class="col-sm-8 blog-main">

		  <!--
          <div class="blog-post">
            <h2 class="blog-post-title">Sample blog post</h2>
            <p class="blog-post-meta">January 1, 2014 by <a href="#">Mark</a></p>

            <p>This blog post shows a few different types of content that's supported and styled with Bootstrap. Basic typography, images, and code are all supported.</p>
            <hr>
            <p>Cum sociis natoque penatibus et magnis <a href="#">dis parturient montes</a>, nascetur ridiculus mus. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Sed posuere consectetur est at lobortis. Cras mattis consectetur purus sit amet fermentum.</p>
            <blockquote>
              <p>Curabitur blandit tempus porttitor. <strong>Nullam quis risus eget urna mollis</strong> ornare vel eu leo. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
            </blockquote>
            <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
            <h2>Heading</h2>
            <p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
            <h3>Sub-heading</h3>
            <p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
            <pre><code>Example code block</code></pre>
            <p>Aenean lacinia bibendum nulla sed consectetur. Etiam porta sem malesuada magna mollis euismod. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa.</p>
            <h3>Sub-heading</h3>
            <p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean lacinia bibendum nulla sed consectetur. Etiam porta sem malesuada magna mollis euismod. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
            <ul>
              <li>Praesent commodo cursus magna, vel scelerisque nisl consectetur et.</li>
              <li>Donec id elit non mi porta gravida at eget metus.</li>
              <li>Nulla vitae elit libero, a pharetra augue.</li>
            </ul>
            <p>Donec ullamcorper nulla non metus auctor fringilla. Nulla vitae elit libero, a pharetra augue.</p>
            <ol>
              <li>Vestibulum id ligula porta felis euismod semper.</li>
              <li>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</li>
              <li>Maecenas sed diam eget risus varius blandit sit amet non magna.</li>
            </ol>
            <p>Cras mattis consectetur purus sit amet fermentum. Sed posuere consectetur est at lobortis.</p>
          </div>
		  -->

          <div class="blog-post">
            <h2 class="blog-post-title">Palabras asociadas al campo RESUMEN</h2>
            <p class="blog-post-meta"><?=date("d-m-Y")?> by <a href="#">SICPMT</a></p>

            <p>A continuaci&oacute;n se presentan las coincidencias presentes en el campo RESUMEN de la Base de Datos de SICPMT. </p>
            
            <div id="cadenaDescriptor"></div>
			
			</div>
		
		  <div class="blog-post">
		   <ul class="dropdown-menu">
		    
		   </ul>
		  </div>
		  
		  <div id="cadenaTerminos"></div>
		  <div>
		  <?php
/*
		  $sql = "select SUM(veces) as Total_Veces
from   (select titulo
             , resumen
             , length(resumen) as largo_cadena
             , length(replace(resumen,'es','')) as largo_cadena_sin_palabra
             , (length(resumen)-length(replace(resumen,'es','')))/length('es')
               as veces
        from   tesauro) q1");
*/		  
?>

<!--
<div id="listaE">
  <ul>
    <li><a href="url_etiqueta_1">etiqueta 1</a></li>
    <li><a href="url_etiqueta_2">etiqueta 2</a></li>
    <li><a href="url_etiqueta_3">etiqueta 3</a></li>
   
  </ul>
</div>
-->
<!--
<div class="row">
  <div class="col-md-4">.col-md-4</div>
  <div class="col-md-4 col-md-offset-4">.col-md-4 .col-md-offset-4</div>
</div>
<div class="row">
  <div class="col-md-3 col-md-offset-3">.col-md-3 .col-md-offset-3</div>
  <div class="col-md-3 col-md-offset-3">.col-md-3 .col-md-offset-3</div>
</div>
<div class="row">
  <div class="col-md-6 col-md-offset-3">.col-md-6 .col-md-offset-3</div>
</div>

<div class="row">
  <div class="col-md-1">.col-md-1</div>
  <div class="col-md-1">.col-md-1</div>
  <div class="col-md-1">.col-md-1</div>
  <div class="col-md-1">.col-md-1</div>
  <div class="col-md-1">.col-md-1</div>
  <div class="col-md-1">.col-md-1</div>
  <div class="col-md-1">.col-md-1</div>
  <div class="col-md-1">.col-md-1</div>
  <div class="col-md-1">.col-md-1</div>
  <div class="col-md-1">.col-md-1</div>
  <div class="col-md-1">.col-md-1</div>
  <div class="col-md-1">.col-md-1</div>
</div>
<div class="row">
  <div class="col-md-8">.col-md-8</div>
  <div class="col-md-4">.col-md-4</div>
</div>
<div class="row">
  <div class="col-md-4">.col-md-4</div>
  <div class="col-md-4">.col-md-4</div>
  <div class="col-md-4">.col-md-4</div>
</div>
<div class="row">
  <div class="col-md-6">.col-md-6</div>
  <div class="col-md-6">.col-md-6</div>
</div>
-->
<?php      
		  
		  $stmt = $db->prepare("select resumen from tesauro where deleted=0 && resumen!=''");
		  $stmt->execute();
		  $vector = array();
		  
//		  echo "<div id='listaE'>";
//		  echo "<ul>";
		  
		  while($row_stmt = $stmt->fetch())
		  {
			  
			  			  			  
			  $cadena = explode(" ", $row_stmt[0]);
			  $vector[] = $cadena;
		  }

		  
		  $palabras = array();
		
// Vectores con articulos y preposiciones a eliminar ----------------------------------		
		$vowels = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U");
			  
		$articulos = array(
			   "cabe", "contra", "desde", "entre", "cabe",
			   "g", "segun", "sobre", "tras", "Ante",
			    "para", "por", "segun", "según",
			  "sin", "sobre", "tras", "mg"
			  );
			  		
			  
		$signos = array(",", ".", "-", ":", ";", "“", "”");
// -----------------------------------------------------------------------------------			  
		  
		  foreach($vector as $clave=>$valor)
		  {
			  sort($valor); // Ordeno vector con palabras
			  foreach($valor as $dato)
			  {
				
				// Elimino valores duplicados en el vector
				if($dato!=$temp)
				{
				  
				  $dato = str_replace($signos, "", $dato); // Elimino los signos
				  
				  
				  if(strlen($dato)>3) // Considero las palabras mayores a 3 letras
				  {
					  
				  $string = ($dato);
				  $palabras[$dato] = $b->contar_palabra($string); 
				   
//				  echo "</li>";
				  $temp = $dato;
				  
				  }
				  
				}
			  }
			  
		  }
	  
//		  echo "</ul>";
//		  echo "</div>";


// Depuracion de Articulos y preposiciones
foreach($palabras as $clave=>$valor)
{
	switch($clave)
				  {
					  case "ante":
					  unset($palabras[$clave]);
					  break;
					  
					  case "antes":
					  unset($palabras[$clave]);
					  break;
					  
					  case "A":
					  unset($palabras[$clave]);
					  break;
					  
					  case "así":
					  unset($palabras[$clave]);
					  break;
					  
					  case "cual":
					  unset($palabras[$clave]);
					  break;
					  
					  case "bajo":
					  unset($palabras[$clave]);
					  break;
					  
					  case "bien":
					  unset($palabras[$clave]);
					  break;
					  
					  case "o":
					  unset($palabras[$clave]);
					  break;
					  
					  case "y":
					  $palabras[$clave] = "";
					  break;
					  
					  case "para":
					  unset($palabras[$clave]);
					  break;
					  
					  case "p":
					  $palabras[$clave] = "";
					  break;
					  
					  case "en":
					  unset($palabras[$clave]);
					  break;
					  
					  case "entra":
					  unset($palabras[$clave]);
					  break;
					  
					  case "En":
					  unset($palabras[$clave]);
					  break;
					  
					  case "el":
					  unset($palabras[$clave]);
					  break;
					  
					  
					  case "e":
					  unset($palabras[$clave]);
					  break;
					  
					  case "entre":
					  unset($palabras[$clave]);
					  break;
					  
					  case "es":
					  unset($palabras[$clave]);
					  break;
					  
					  case "esto":
					  unset($palabras[$clave]);
					  break;
					  
					  case "estos":
					  unset($palabras[$clave]);
					  break;
					  
					  case "esta":
					  unset($palabras[$clave]);
					  break;
					  
					  case "esa":
					  unset($palabras[$clave]);
					  break;
					  
					  case "este":
					  unset($palabras[$clave]);
					  break;
					  
					  case "las":
					  $palabras[$clave] = "";
					  break;
					  
					  case "más":
					  unset($palabras[$clave]);
					  break;
					  
					  case "que":
					  unset($palabras[$clave]);
					  break;
					  
					  case "un":
					  $palabras[$clave] = "";
					  break;
					  
					  case "con":
					  $palabras[$clave] = "";
					  break;
					  
					  case "como":
					  $palabras[$clave] = "";
					  break;
					  
					  case "contra":
					  $palabras[$clave] = "";
					  break;
					  
					  case "conla":
					  $palabras[$clave] = "";
					  break;
					  
					  case "la":
					  $palabras[$clave] = "";
					  break;
					  
					  case "La":
					  $palabras[$clave] = "";
					  break;
					  
					  case "de":
					  $palabras[$clave] = "";
					  break;
					  
					  case "desde":
					  $palabras[$clave] = "";
					  break;
					  
					  case "una":
					  $palabras[$clave] = "";
					  break;
					  
					  case "el":
					  $palabras[$clave] = "";
					  break;
					  
					  case "El":
					  $palabras[$clave] = "";
					  break;
					  
					  case "fue":
					  $palabras[$clave] = "";
					  break;
					  
					  case "del":
					  $palabras[$clave] = "";
					  break;
					  
					  case "por":
					  $palabras[$clave] = "";
					  break;
					  
					  case "del":
					  $palabras[$clave] = "";
					  break;
					  
					  case "al":
					  $palabras[$clave] = "";
					  break;
					  
					  case "le":
					  $palabras[$clave] = "";
					  break;
					  
					  case "lo":
					  $palabras[$clave] = "";
					  break;
					  
					  case "los":
					  $palabras[$clave] = "";
					  break;
					  
					  case "contra":
					  $palabras[$clave] = "";
					  break;
					  
					  case "desde":
					  $palabras[$clave] = "";
					  break;
					  
					  case "no":
					  $palabras[$clave] = "";
					  break;
					  
					  case "se":
					  $palabras[$clave] = "";
					  break;
					  
					  case "Se":
					  $palabras[$clave] = "";
					  break;
					  
					  case "ser":
					  $palabras[$clave] = "";
					  break;
					  
					  case "su":
					  unset($palabras[$clave]);
					  break;
					  
					  case "sólo":
					  unset($palabras[$clave]);
					  break;
					  
					  case "sobre":
					  unset($palabras[$clave]);
					  break;
					  
					  case "tales":
					  unset($palabras[$clave]);
					  break;
					  
					  case "tenido":
					  unset($palabras[$clave]);
					  break;
					  
					  
					  
					  case "valores":
					  unset($palabras[$clave]);
					  break;
					  
					  default:
					  ;
				  }
}

$valor_max = max($palabras);
$valor_min = min($palabras);

//echo "<br>MAXIMO: ".$valor_max;
//echo "<br>MINIMO: ".$valor_min;
		
nube_etiquetas($palabras);

// NUBE ROTATIVA .............
/*
		
		  echo "<div id='listaE'>";
		  echo "<ul>";
		  
		  foreach($palabras as $clave=>$valor)
		  {
			  if($valor > 3)
			  {
				  switch($clave)
				  {
					  case "para":
					  break;
					  
					  case "en":
					  break;
					  
					  case "el":
					  break;
					  
					  case "El":
					  break;
					  
					  case "En":
					  break;
					  
					  case "e":
					  break;
					  case "es":
					  break;
					  case "Las":
					  break;
					  case "que":
					  break;
					  
					  case "un":
					  break;
					  
					  case "con":
					  break;
					  
					  case "la":
					  break;
					  
					  case "La":
					  break;
					  
					  case "de":
					  break;
					  
					  case "una":
					  break;
					  
					  case "el":
					  break;
					  
					  case "del":
					  break;
					  
					  case "por":
					  break;
					  
					  case "del":
					  break;
					  
					  case "al":
					  break;
					  
					  case "le":
					  break;
					  
					  case "los":
					  break;
					  
					  case "contra":
					  break;
					  
					  case "desde":
					  break;
					  
					  default:
					  echo "<li><a href='#'>".$clave." ($valor)</a></li>"; 
				  }
				  
			  }
		  }
		  
		  echo "</ul>";
		  echo "</div>";
		  
*/

//echo wordc("resumen");
		
		  ?>
		  </div>
<!--

-->
          <!--<nav>
            <ul class="pager">
              <li><a href="#">Previous</a></li>
              <li><a href="#">Next</a></li>
            </ul>
          </nav>-->
          
        </div><!-- /.blog-main -->

        <div class="col-sm-3 col-sm-offset-1 blog-sidebar">
          <div class="sidebar-module sidebar-module-inset">
            <h4>Nota</h4>
            <p>Con base al filtro por letra de la barra superior se despliegan las coincidencias por <em>T&eacute;rmino General</em></p>
          </div>
          <div class="sidebar-module">
            <h4>T&eacute;rminos Generales</h4>
            <ol class="list-unstyled">
			<?php
			 while($row = $stmt->fetch())
			 {
				 ?>
				 <li><a href="javascript:void(0);" onclick="MostrarDescriptor('c.mostrar_descriptor.php?tg=<?=$row[0]?>')"><?=$row[0]?></a>
				 </li>
				 <?php
			 }
			?>

            </ol>
          </div>
          <div class="sidebar-module">
            <h4>Adicionales</h4>
            <ol class="list-unstyled">
              <li><a href="#">WordCloud</a></li>
            </ol>
          </div>
        </div><!-- /.blog-sidebar -->

      </div><!-- /.row -->

    </div><!-- /.container -->
    
	<!--
    <footer class="blog-footer">
      <p>WordCloud ( Nube de Palabras )-SICPMT <a href="http://redraus.org">REDRAUS</a> by <a href="#">SICPMT</a>.</p>
      <p>
        <a href="#">Ir al inicio</a>
      </p>
    </footer>
	-->

<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    
    <script>window.jQuery || document.write('<script src="bootstrap/assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="bootstrap/assets/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="bootstrap/assets/js/ie10-viewport-bug-workaround.js"></script>	
	
</body>
</html>