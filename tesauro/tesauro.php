<?php

$dato = $_POST["busca_dato"];

if($_POST["busca_dato"]!="") {
$stmt = $db->prepare("select TE,TG from tesauro_elementos where TG like '$dato%' group by TG");
$stmt->execute();

$cadena = "<address>";

  while($row = $stmt->fetch()) {
  
	  $cadena.="<strong>".$row[1]."</strong><br>";
	  
	  $otro_stmt = $db->prepare("select TE,id from tesauro_elementos where TG=:tg && TE!=''");
	  $otro_stmt->execute(array(":tg"=>$row[1]));
	    
		while($row_stmt = $otro_stmt->fetch()) {
			
			$cadena.="<a href='javascript:void(0);' onclick='javascript:
function objetoAjax(){
        var xmlhttp=false;
        try {
                xmlhttp = new ActiveXObject(\"Msxml2.XMLHTTP\");
        } catch (e) {
                try {
                   xmlhttp = new ActiveXObject(\"Microsoft.XMLHTTP\");
                } catch (E) {
                        xmlhttp = false;
                }
        }

        if (!xmlhttp && typeof XMLHttpRequest!=\"undefined\") {
                xmlhttp = new XMLHttpRequest();
        }
        return xmlhttp;
}

function MostrarConsultaTR(datos) {
 		
        ajax=objetoAjax();
        ajax.open(\"POST\", datos);
        ajax.onreadystatechange=function() {
                
				if (ajax.readyState==3) {
				  
				}
				if (ajax.readyState==4) {
					if(ajax.responseText) {
                        cadena = eval(\"(\"+ajax.responseText+\")\");
						//cadena = ajax.responseText;
						document.getElementById(\"resultadoTR\").innerHTML = cadena.resultadoTR;
			            
						
					}
						
                }
				
				
        }
        ajax.send(null)
		
}
MostrarConsultaTR(\"http://redraus.org/tesauro_wp/wp-content/themes/naturespace/vistas/consulta_tesauroTR.php?busca_datoTR=".$row_stmt[1]."\");'>".$row_stmt[0]."</a><br>";
		}
  }
$cadena.="</address>";


}
