<html>
<?php
require_once("iniciar.php");
 
 
 $stmt = $db->prepare("update usuarios set status=0,time=0 where usuario=:usuario");
 $stmt->execute(array(":usuario"=>$a->decrypt($_GET["usuario"], "dos")));
 
 sleep(6);
?>
<body onload="document.form1.submit()">
<form method="GET" name="form1" action="index.php">

</form>
</body>
</html>