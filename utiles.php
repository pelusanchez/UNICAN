<?php
/**
#9DB2AC
EEFFFA
FFF2EE
*/
$color1 = "#9DB2AC";
$color2 = "#EEFFFA";
$color3 = "#FFF2EE";


/**
 *	Función: generarCodigoSecreto
 *		Genera un código no reversible utilizando una función de PHP que
 *		retorna bytes pseudoaleatorios. Además, el ususario puede introducir
 *		un valor a la función, con el cual será encriptado.
 */
function generarCodigoSecreto($valor){
	$bytes = openssl_random_pseudo_bytes(12);
	$sal = bin2hex($bytes);
	return md5($sal.$valor);
}

function creaNombreDeFichero($valor){
	return str_replace(' ', '_', $valor);
}


function __mysqlentities($a){
	$toRtn ="";
	for($b = 0; $b<strlen($a); $b++){
		switch(ord($a[$b])){
			case 193:
				$toRtn.="&Aacute;";
			break;
			case 201:
				$toRtn.="&Eacute;";
			break;
			case 205:
				$toRtn.="&Iacute;";
			break;
			case 211:
				$toRtn.="&Oacute;";
			break;
			case 218:
				$toRtn.="&Uacute;";
			break;
			case 225:
				$toRtn.="&aacute;";
			break;
			case 233:
				$toRtn.="&eacute;";
			break;
			case 237:
				$toRtn.="&iacute;";
			break;
			case 241:
				$toRtn.="&ntilde;";
			break;
			case 243:
				$toRtn.="&oacute;";
			break;
			case 250:
				$toRtn.="&uacute;";
			break;
			default:
				$toRtn .=$a[$b];
			break;
		}
	}
	return $toRtn;
}

function magic_folder(){
	$carpetas = array("98w0brcq382yrn0x38yr0xp384rycnq03yr0fpx8043f3", "9283b3q87rtbx837tfb874qtc8bo7rnxrynqixury3b9rynqf8y", "78w3rbqx9837trbx83tf7wqeyctr7qytf7qx");
	$date = time();
	return $carpetas[$date%3];
}

?>
