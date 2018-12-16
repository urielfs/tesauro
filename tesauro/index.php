<?php 
header('Content-Type: text/html; charset=ISO-8859-1');
require_once(dirname(dirname(__FILE__))."/iniciar.php");

$tg = $_POST["busca_dato"];
$stmt = $db->prepare("select TG from tesauro_elementos where TG like '$tg%' group by TG");
$stmt->execute();

?>
<!DOCTYPE html>
<html lang="sp">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="Uriel MArtinez-Jose Vargas">
    <link rel="icon" href="../../favicon.ico">

    <title>Tesauro-SICPMT</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="bootstrap/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
	
	<!-- Custom styles for this template -->
    <link href="blog.css" rel="stylesheet">
    
    <!-- Custom styles for this template -->
    <link href="../sticky-footer-navbar.css" rel="stylesheet">
	<script type='text/javascript'>
	var cadena;

function objetoAjax(){
        var xmlhttp=false;
        try {
                xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
                try {
                   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (E) {
                        xmlhttp = false;
                }
        }

        if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
                xmlhttp = new XMLHttpRequest();
        }
        return xmlhttp;
}
	// Funcion para Select de Dropdown -------
function MostrarDropdown(datos,entrada) {
 		
        ajax=objetoAjax();
        ajax.open("POST", datos);
        ajax.onreadystatechange=function() {
                
				if (ajax.readyState==3) {
				  //carga.style.visibility = 'visible';
				}
				if (ajax.readyState==4) {
					if(ajax.responseText) {
                        cadena = eval("("+ajax.responseText+")");
						
						
						var option=document.createElement("option");
						
						if(cadena.tok=="true") {
							document.getElementById('resultado_'+entrada).innerHTML = cadena.resultado;
							document.getElementById('nuevo_Input'+entrada).value = "";
						}
						else {
						option.value = cadena.dato_v;
						option.text = cadena.dato_t;
						
						document.getElementById('Input'+entrada).appendChild(option);
						document.getElementById('resultado_'+entrada).innerHTML = cadena.resultado;
						document.getElementById('nuevo_Input'+entrada).value = "";
						}
						
						if(cadena.opcion=="borrado")
						{
							//document.getElementById('InputOC').find('option[cadena.valor]').remove();
							document.getElementById('Input'+entrada).options[document.getElementById('Input'+entrada).selectedIndex] = null;
							document.getElementById('resultado_'+entrada).innerHTML = cadena.resultado;
						}
					}
						
                }
				
				
        }
        ajax.send(null)
		
}

function MostrarDescriptor(datos) {
 		
        ajax=objetoAjax();
        ajax.open("POST", datos);
        ajax.onreadystatechange=function() {
                
				if (ajax.readyState==3) {
				  //carga.style.visibility = 'visible';
				}
				if (ajax.readyState==4) {
					if(ajax.responseText) {
                        //cadena = eval("("+ajax.responseText+")");
						cadena = ajax.responseText;
						
						document.getElementById('cadenaDescriptor').innerHTML = cadena;
					
						
					}
						
                }
				
				
        }
        ajax.send(null)
		
}

function MostrarTerminos(datos,puntero) {
 		
        ajax=objetoAjax();
        ajax.open("POST", datos);
        ajax.onreadystatechange=function() {
                
				if (ajax.readyState==3) {
				  //carga.style.visibility = 'visible';
				}
				if (ajax.readyState==4) {
					if(ajax.responseText) {
                        //cadena = eval("("+ajax.responseText+")");
						cadena = ajax.responseText;
						
						document.getElementById('cadena_'+puntero).innerHTML = cadena;
					
						
					}
						
                }
				
				
        }
        ajax.send(null)
		
}
	</script>	

  </head>
  
<body>



    <div class="blog-masthead">
      <div class="container">
        <nav class="blog-nav">
          <a class="blog-nav-item active" href="#">Historico</a>
          
        </nav>
      </div>
    </div>

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
	
      <div class="blog-header">
        <h1 class="blog-title">T&eacute;rminos TESAURO - SICPMT</h1>
        
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
            <h2 class="blog-post-title">Descriptores asociados</h2>
            <p class="blog-post-meta"><?=date("d-m-Y")?> by <a href="#">SICPMT</a></p>

            <p>A continuaci&oacute;n se presentan los descriptores asociados al T&eacute;rmino General que empiezan por la letra: <strong><?=ucfirst($tg)?></strong>.</p>
            
            <div id="cadenaDescriptor"></div>
			
			</div>
		
		  <div class="blog-post">
		   <ul class="dropdown-menu">
		    
		   </ul>
		  </div>
		  
		  <div id="cadenaTerminos"></div>
<!--
          <div class="blog-post">
            <h2 class="blog-post-title">New feature</h2>
            <p class="blog-post-meta">December 14, 2013 by <a href="#">Chris</a></p>

            <p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean lacinia bibendum nulla sed consectetur. Etiam porta sem malesuada magna mollis euismod. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
            
			<ul>
              <li>Praesent commodo cursus magna, vel scelerisque nisl consectetur et.</li>
              <li>Donec id elit non mi porta gravida at eget metus.</li>
              <li>Nulla vitae elit libero, a pharetra augue.</li>
            </ul>
            <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
            <p>Donec ullamcorper nulla non metus auctor fringilla. Nulla vitae elit libero, a pharetra augue.</p>
          </div>
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

    <footer class="blog-footer">
      <p>T&eacute;rminos TESAURO-SICPMT <a href="http://redraus.org">REDRAUS</a> by <a href="#">SICPMT</a>.</p>
      <p>
        <a href="#">Ir al inicio</a>
      </p>
    </footer>

<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="bootstrap/assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="bootstrap/assets/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="bootstrap/assets/js/ie10-viewport-bug-workaround.js"></script>	
	
</body>
</html>