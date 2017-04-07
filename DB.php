<?php
function mysql_connect(){
	$mysqli = new mysqli("localhost", "Apuntes","123445", "Apuntes");
	if($mysqli->connect_errno){
		die("Error grave!");
	}
	return $mysqli;
}
?>
