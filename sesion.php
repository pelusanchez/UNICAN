<?php
/**
Script: sesion.php
	Escrito por David Iglesias Sánchez
	Aplicación programada y diseñada por Jaime Diez Gonzalez-Pardo, Guillermo Pascual Cisneros, Mariam

	Éste script maneja las funciones de sesión:
		Functión:	haEntrado()
			Retorna true si el usuario ha entrado o false en cualquier otro caso.

		Función:	informacionUsuario()
			Retorna en forma de objeto la información del usuario

		Función: entrada()
			Verifica la entrada del usuario y si es correcta, envía una cookie al cliente
			con la información de la sesión.

				Argumentos: se le pasa el nombre de usuario y la contraseña encriptada con el
				algoritmo md5.

		Función: registro()
			Registra a un usuario en el sistema.
			Argumentos: se le pasa en nombre, primer apellido, segundo apellido, el nick, la contraseña y el
			e-mail.

		Función: salir()
			Asegura la salida del sistema eliminando la sesión de la base de datos y la cookie en el cliente.


*/
require_once("DB.php");

require_once("utiles.php");
$USERINFO = array();

/**
Functión:	haEntrado()
	Retorna true si el usuario ha entrado o false en cualquier otro caso.

	Busca si existe una sesión con la cookie.
*/
function haEntrado(){
	if(!isset($_COOKIE["usersession"])){ return false;}
	$usersession = $_COOKIE["usersession"];


	//echo "User = ".."<br>";
	$DB = sql_connect();
	if($oracionSesion = $DB->prepare("SELECT IdUsuario FROM Sesion WHERE IdSesion=?")){

		if(!$oracionSesion->bindParam(1, $usersession)){return "0";}
		if(!$oracionSesion->execute()){return "0";}
		
		
		
		if($oracionSesion->rowCount() > 0){
			$filaSesion = $oracionSesion->fetchObject();

			$idUsuario = $filaSesion->IdUsuario;

			setcookie("usersession", $usersession, time()+3600);
			if($oracion = $DB->prepare("SELECT IdUsuario, Nombre, Apellido1, Apellido2, Nick, Email FROM Usuario WHERE IdUsuario=?")){
				$oracion->bindParam(1, $idUsuario);
				$oracion->execute();
				if($oracion->rowCount()>0){

					$GLOBALS["USERINFO"] = $oracion->fetchObject();
					return true;
				}
			}

		}

	}


	return false;
}

/**
Función:	idUsuario()
	Retorna el id del usuario
*/

function idUsuario(){
	return $GLOBALS["USERINFO"]->IdUsuario;
}


/**
Función:	informacionUsuario()
	Retorna en forma de objeto la información del usuario
*/

function informacionUsuario(){
	return $GLOBALS["USERINFO"];
}

/**
 *Función: entrada()
 *	Verifica la entrada del usuario y si es correcta, envía una cookie al cliente
 *	con la información de la sesión.
 *
 *		Argumentos: se le pasa el nombre de usuario y la contraseña encriptada con el
 *		algoritmo md5.
 *
 */
function entrada($user, $pass){
	$DB = sql_connect();
	if($oracion = $DB->prepare("SELECT IdUsuario, Email, Apellido1, Apellido2 FROM Usuario WHERE Nick=? AND Password=?")){
		$oracion->bindParam(1, $user, PDO::PARAM_STR);
		$oracion->bindParam(2, $pass, PDO::PARAM_STR);
		$oracion->execute();
			if($oracion->rowCount() > 0){
				$fila = $oracion->fetchObject();


				$usersession = generarCodigoSecreto($fila->Email.$fila->IdUsuario.$fila->Apellido2.$fila->Apellido1.$pass);

				//Eliminamos si existe una sesion anterior en la base de datos
				$DB->query("DELETE FROM Sesion WHERE IdUsuario=".$fila->IdUsuario);


				if($oracionSesion = $DB->prepare("INSERT INTO Sesion(IdSesion, IdUsuario) VALUES(?, ?)")){

					if(!$oracionSesion->bindParam(1, $usersession, PDO::PARAM_STR)){return "0";}
					if(!$oracionSesion->bindParam(2, $fila->IdUsuario, PDO::PARAM_INT)){return "0";}
					if(!$oracionSesion->execute()){return "0";}

					setcookie("usersession", $usersession, time()+3600);
					return "1";
				}else{
					return "Error";
				}
			}else{
				sleep(2);// Amortiguamos en caso de un envío masivo.
				return "0";
			}

	}else{
		sleep(2);// Amortiguamos en caso de un envío masivo.
		return "0";
	}
}

/**
 *	Función: registro()
 *		Registra a un usuario en el sistema.
 *		Argumentos: se le pasa en nombre, primer apellido, segundo apellido, el nick, la contraseña y el e-mail.	
 */
function registro($name, $apellido1, $apellido2, $nick, $password, $email){

	sleep(2); // Amortiguamos en caso de un envío masivo.
	if(isset($name) && isset($apellido1) && isset($apellido2) && isset($nick) && isset($password) && isset($email)){
		$DB = sql_connect();
		if($oracion = $DB->prepare("SELECT Nick, Email FROM Usuario WHERE Nick=? OR Email=?")){
			$oracion->bindParam(1, $nick);
			$oracion->bindParam(2, $email);
			$oracion->execute();
			
			if($oracion->rowCount()>0){ // If Nick or Email Exists!
				while($fila = $oracion->fetchObject()){
					if($fila->Nick == $nick){return 3;}
					if($fila->Email == $email){return 4;}
				}
				
			}else{
				if($oracionNum = $DB->prepare("SELECT COUNT(*) AS num FROM Usuario")){
					if($oracionNum->execute()){
						$filaNum = $oracionNum->fetchObject();
						$IdUsuario = $filaNum->num;
					}else{
						return 5;
					}

				}
				if($oracion = $DB->prepare("INSERT INTO `Usuario` (`IdUsuario`, `Nombre`, `Apellido1`, `Apellido2`, `Password`, `Nick`, `Email`) VALUES(?, ?, ?, ?, ?, ?, ?)")){
					$oracion->bindParam(1, $IdUsuario, PDO::PARAM_INT);
					$oracion->bindParam(2, $name, PDO::PARAM_STR);
					$oracion->bindParam(3, $apellido1, PDO::PARAM_STR);
					$oracion->bindParam(4, $apellido2, PDO::PARAM_STR);
					$oracion->bindParam(5, $password, PDO::PARAM_STR);
					$oracion->bindParam(6, $nick, PDO::PARAM_STR);
					$oracion->bindParam(7, $email, PDO::PARAM_STR);
					if($oracion->execute()){
						return 1;

					}else{
						return 5;
					}
				}

			}

		}

			
	}else{
		return 2;
	}
}

/**
 *	Función: salir()
 *		Asegura la salida del sistema eliminando la sesión de la base de datos y la cookie en el cliente.
 */
function salir(){
	$DB = sql_connect();
	if(isset($_COOKIE["usersession"])){
		if($oracion = $DB->prepare("DELETE FROM Sesion WHERE idSesion=?")){
			$oracion->bindParam(1, $_COOKIE["usersession"], PDO::PARAM_STR);
			if($oracion->execute()){ return true;
				
	    		setcookie('usersession', '', time()-1000, '/');
	    		unset($_COOKIE["usersession"]);
			}
		}
	}
	return false;
}
?>