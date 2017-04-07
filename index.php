<?php
/**
Incluir para manejar la base de datos
*/
require_once("DB.php");
require_once("func.php");
require_once("session.php");
if(isLoggedIn()){
	$userInfo = getUserInfo();
	echo "Hola ".$userInfo->Nombre." ".$userInfo->Apellido1." AKA ".$userInfo->Nick;
	$NOMBREUSUARIOCOMPLETO = $userInfo->Nombre." ".$userInfo->Apellido1;
	include("template.php");
?>
<?php
}else{
?>
<html>
<head>
<script languaje="JavaScript">
	window.onload = function(){ window.location.href="login.php"; };
</script>
</head>
<body>
</body>
</html>
<?php
}
?>
