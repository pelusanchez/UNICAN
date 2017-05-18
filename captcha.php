<?php
	require_once("captcha/captcha.php");
	// Enviamos el contenido como imagen png.
	header('Content-Type: image/png');
	// Obtenemos la imagen generada llamando a la función generarCaptcha()
	$imagen = generarCaptcha();
	// Pintamos la imagen y la destruímos de la memoria.
	imagepng($imagen);
	imagedestroy($imagen);
?>