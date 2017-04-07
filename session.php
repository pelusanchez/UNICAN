<?php
/**
Session
*/
require_once("DB.php");
require_once("func.php");
$USERINFO = array();
function isLoggedIn(){
	if(!isset($_COOKIE["usersession"])){ return false;}
	$usersession = $_COOKIE["usersession"];


	//echo "User = ".."<br>";
	$DB = mysql_connect();
	if($oracionSesion = $DB->prepare("SELECT IdUsuario FROM Sesion WHERE IdSesion=?")){

		if(!$oracionSesion->bind_param("s", $usersession)){return "0";}
		if(!$oracionSesion->execute()){return "0";}
		
		
		$resultadoSesion = $oracionSesion->get_result();
		if($resultadoSesion->num_rows > 0){
			$filaSesion = $resultadoSesion->fetch_object();

			$idUsuario = $filaSesion->IdUsuario;

			setcookie("usersession", $usersession, time()+3600);
			if($oracion = $DB->prepare("SELECT IdUsuario, Nombre, Apellido1, Apellido2, Nick, Email FROM Usuarios WHERE IdUsuario=?")){
				$oracion->bind_param("s", $idUsuario);
				$oracion->execute();
				if($result = $oracion->get_result()){
					if($result->num_rows>0){

						$GLOBALS["USERINFO"] = $result->fetch_object();
						return true;
					}
				}
			}

		}

	}


	return false;
}

function getUserInfo(){
	return $GLOBALS["USERINFO"];
}


function login($user, $pass){
	$DB = mysql_connect();
	if($oracion = $DB->prepare("SELECT IdUsuario, Email, Apellido1, Apellido2 FROM Usuarios WHERE Nick=? AND Password=?")){
		$oracion->bind_param("ss", $user, $pass);
		$oracion->execute();

		if($result = $oracion->get_result()){
			if($result->num_rows>0){
				$fila = $result->fetch_object();

				$bytes = openssl_random_pseudo_bytes(12);
				$sal = bin2hex($bytes);
				$usersession = md5($user.$fila->Email.$fila->IdUsuario.$sal.$fila->Apellido2.$fila->Apellido1.$pass);

				//Eliminamos si existe una sesion anterior en la base de datos
				$DB->query("DELETE FROM Sesion WHERE IdUsuario=".$fila->IdUsuario);


				if($oracionSesion = $DB->prepare("INSERT INTO Sesion(IdSesion, IdUsuario) VALUES(?, ?)")){

					if(!$oracionSesion->bind_param("si", $usersession, $fila->IdUsuario)){return "0";}
					if(!$oracionSesion->execute()){return "0";}

					setcookie("usersession", $usersession, time()+3600);
					return "1";
				}else{
					return "Error";
				}
			}else{
				usleep(2000000);
				return "0";
			}
		}else{
			usleep(2000000);
			return "0";
		}

	}else{
		usleep(2000000);
		return "0";
	}
}

function logout(){
	$DB = mysql_connect();
	if(isset($_COOKIE["usersession"])){
		if($oracion = $DB->prepare("DELETE FROM Sesion WHERE IdSesion=?")){
			$oracion->bind_param("s", $_COOKIE["usersession"]);
			if($oracion->execute()){ return true;
				
	    		setcookie('usersession', '', time()-1000, '/');
	    		unset($_COOKIE["usersession"]);
			}
		}
	}
	return false;
}
/*
if(isset($_POST["u"]) && isset($_POST["p"])){
	$DB = mysql_connect();
	if($oracion = $DB->prepare("SELECT IdUsuario FROM Usuarios WHERE Nick=? AND password=?")){
		$oracion->bind_param("ss", $_POST["u"], $_POST["p"]);
		$oracion->execute();
		if($result = $oracion->get_result()){
			if($result->num_rows>0){
				echo "1";
				setcookie("sessiondata", 'u='.$_POST["u"].'&p='.$_POST["p"], time()+3600);
			}else{
				usleep(2000000);
				echo "0";
			}
		}else{
			usleep(2000000);
			echo "0";
		}
	}else{
		usleep(2000000);
		echo "0";
	}
}*/
?>