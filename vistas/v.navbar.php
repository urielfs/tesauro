<!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">SICPMT </a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li <?php if($activo=='h') { echo 'class="active"'; } else { } ?>><a href="v.historico.php?usuario=<?=$_GET["usuario"]?>">Hist&oacute;rico</a></li>
			<li <?php if($activo==1) { echo 'class="active"'; } else { } ?>><a href="v.editar_datos_1.php?usuario=<?=$_GET["usuario"]?>&token=<?=$_GET["token"]?>">Grupo 1</a></li>
			<li <?php if($activo==2) { echo 'class="active"'; } else { } ?>><a href="v.editar_datos_2.php?usuario=<?=$_GET["usuario"]?>&token=<?=$_GET["token"]?>">Grupo 2</a></li>
			<li <?php if($activo==3) { echo 'class="active"'; } else { } ?>><a href="v.editar_datos_3.php?usuario=<?=$_GET["usuario"]?>&token=<?=$_GET["token"]?>">Grupo 3</a></li>
			<li <?php if($activo==4) { echo 'class="active"'; } else { } ?>><a href="v.editar_datos_4.php?usuario=<?=$_GET["usuario"]?>&token=<?=$_GET["token"]?>">Grupo 4</a></li>
			<li <?php if($activo==5) { echo 'class="active"'; } else { } ?>>
			<a href="v.editar_datos_5.php?usuario=<?=$_GET["usuario"]?>&token=<?=$_GET["token"]?>">Grupo 5</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administraci&oacute;n <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="v.listas.php?usuario=<?=$_GET["usuario"]?>&token=<?=$_GET["token"]?>">Listas desplegables</a></li>
                <?php if($b->validaUsuario($a->decrypt($_GET["usuario"],"dos"))!=0) { ?>
				<li><a href="#">Contacto</a></li>
                <?php } ?>
				<li role="separator" class="divider"></li>
                <li class="dropdown-header">Complementos</li>
				<li><a href="v.foto.php?usuario=<?=$_GET["usuario"]?>&token=<?=$_GET["token"]?>">Subir Foto Especie</a></li>
                <li><a href="../wordcloud" target="_blank">WordCloud</a></li>
				<li><a href="../tesauro/" target="_blank">TESAURO</a></li>
              </ul>
            </li>
          </ul>
		  <ul class="nav navbar-nav navbar-right">
            
            <li><a href="javascript:void(0);" onclick="document.forms[0].action='../logout.php?usuario=<?=$_GET["usuario"]?>'; document.forms[0].submit();"><small><?=$a->decrypt($_GET["usuario"], "dos")?></small>   (salir)</a></li>
            <!--<li class="active"><a href="./">Fixed top <span class="sr-only">(current)</span></a></li>-->
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>