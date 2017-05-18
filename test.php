<?php
require_once("configuracion.php");

$pdo = new PDO("mysql:host=".BASEDEDATOS["SERVIDOR"].";dbname=".BASEDEDATOS["BASEDEDATOS"].";charset=utf8", BASEDEDATOS["USUARIO"],BASEDEDATOS["CONTRASENA"]);
$stm = $pdo->prepare("SELECT * FROM Usuario");
$stm->execute();
while($fila = $stm->fetchObject()){
	print_r($fila);
	echo "<br>";
}

?>