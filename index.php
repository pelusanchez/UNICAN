<?php
/************************************************************************************************************************************
 * 		Script: index.php
 *			Escrito por David Iglesias Sánchez.
 *			Aplicación programada y diseñada por Jaime Diez Gonzalez-Pardo, Guillermo Pascual Cisneros, Mariam Milad Fernández.
 *
 *		Éste script es el principal:
 *			· Si has entrado al sistema, aparece la página principal con opciones de búsqueda, filtro,...
 *			· Si no has entrado al sistema, te redirige a la página de entrada.
 *
 */


require_once("DB.php");					// Incluir el script que maneja las bases de datos

require_once("utiles.php");				// Incluir el script que contiene funciones útiles

require_once("sesion.php");				// Incluir el script que maneja las sesiones

if(haEntrado()){						// Comprobamos si el usuario se ha metido al sistema.

	
	$userInfo = informacionUsuario();	// Obtenemos la información del usuario en un objeto

	
	include("plantilla.php");			// Incluimos la plantilla

}else{//Else if haEntrado()
?>
	<html>
		<head>
			<link rel="stylesheet" type="text/css" href="basico.css">
			<script languaje="JavaScript">
				window.onload = function(){ window.location.href="entrar.php"; };
			</script>
		</head>
		<body>
			<a href="entrar.php">Entrar</a>
		</body>
	</html>

<?php
}// Final de if haEntrado()
?>