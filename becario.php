<?php
/************************************************************************************************************************************
 * 		Script: becario.php
 *			Escrito por David Iglesias Sánchez.
 *			Aplicación programada y diseñada por Jaime Diez Gonzalez-Pardo, Guillermo Pascual Cisneros, Mariam Milad Fernández.
 *
 *		Éste script es el encargado de enlazar las consultas de la base de datos con la página web (mediante AJAX).
 *		Se compone de las siguientes funciones:
 *
 *			Función: obtener_estudios
 *				Se encarga de mostrar los estudios disponibles en la  base de datos.
 *
 *			Función: obtener_asignaturas
 *				Retorna las asignaturas en base al grado y al curso pasado por GET al script.
 *
 *			Función: filtrar_apuntes
 *				Muestra los apuntes aplicando los filtros de búsqueda.
 *
 *			Función: buscar_texto
 *				Retorna los apuntes buscando por título o comentario. Además, seleciona si busca exámenes, apuntes,
 *				o ambos dependiendo de la variable tipo pasada como argumento.
 *			
 *			Función: obtener_ultimos
 *				Retorna los últimos apuntes subidos.
 *
 *			Función: informacion_documento
 *				Retorna la información del documento pasado por su identificador mediante get.
 */
/**
Incluir para manejar la base de datos
*/
require_once("configuracion.php");
require_once("DB.php");
require_once("utiles.php");
require_once("sesion.php");

//Comprobar si el usuario ha entrado al sistema
if(!haEntrado()){
	die("{\"Error\": true, \"ErrorCode\": 1}");
}


//Enviar la cabecera con la codificación iso-8859-1 para evitar errores en los caracteres.



//Comprobar si el usuario ha entrado al sistema
if(!haEntrado()){
	die("{\"Error\": true, \"ErrorCode\": 1}");
}


//Enviar la cabecera con la codificación iso-8859-1 para evitar errores en los caracteres.
header('Content-Type: text/html; charset=utf-8');

/**
Función: obtener_estudios
	Retorna los estudios disponibles de la base de datos
*/
function obtener_estudios(){
	$DB = sql_connect();

	if($puntero = $DB->query("SELECT IdEstudios, Nombre FROM Estudios")){
		$i = $puntero->rowCount();
		echo "{";
		while($fila = $puntero->fetchObject()){
			echo "\"".$fila->IdEstudios."\":\"".$fila->Nombre."\"\n,";

		}
		echo " \"length\":".$puntero->rowCount()."}";
	}

}

/**
Función: obtener_tipos
	Retorna los tipos de apuntes disponibles de la base de datos
*/
function obtener_tipos(){
	$DB = sql_connect();
	if(isset($_GET["tipo"])){
		if($oracion = $DB->prepare("SELECT IdTipo, Nombre FROM Tipo WHERE IdTipo = ?")){
			$oracion->bindParam(1, $_GET["tipo"]);
			$oracion->execute();
				if($fila = $oracion->fetchObject()){
					echo "{\"Nombre\":\"".$fila->Nombre."\"}";
				}
	
		}
	}else{
		if($oracion = $DB->query("SELECT IdTipo, Nombre FROM Tipo")){
			$i = $oracion->rowCount();
			echo "{";
			while($fila = $oracion->fetchObject()){
				echo "\"".$fila->IdTipo."\":\"".$fila->Nombre."\"\n,";

			}
			echo " \"length\":".$oracion->rowCount()."}";
		}
	}
}
/**
Función: obtener_cursos
	Retorna la fecha de los cursos
*/
function obtener_cursos(){
	$DB = sql_connect();

	if($puntero = $DB->query("SELECT IdAnio, Anio FROM Anio")){
		$i = $puntero->rowCount();
		echo "{";
		while($fila = $puntero->fetchObject()){
			echo "\"".$fila->IdAnio."\":\"".$fila->Anio."\"\n,";

		}
		echo " \"length\":".$puntero->rowCount()."}";
	}
}

/**
Funcion: puntos
	Calcula los puntos de un usuario.
*/
function puntos(){
	if(!isset($_GET["id"])){ json_void(); return 0;}
	$idUsuario = $_GET["id"];
	$DB = sql_connect();
	if($oracion = $DB->prepare("SELECT COUNT(*)*10 AS puntos FROM `Documentos` WHERE Usuario = ?")){
		$oracion->bindParam(1, $idUsuario);
		$oracion->execute();
			if($fila = $oracion->fetchObject()){
				echo "{\"length\": \"1\", \"Puntos\": \"".$fila->puntos."\"}";
				return ;
			}
	}
	json_void();
	
}

/**
Función: obtener_asignaturas
	Retorna las asignaturas en base al grado y al curso pasado por GET al script.
*/
function obtener_asignaturas(){
	$DB = sql_connect();
	$idGrado = (isset($_GET["grado"])) ? $_GET["grado"] : "ALL";
	$idCurso = (isset($_GET["curso"])) ? $_GET["curso"] : "ALL";


		// Preparamos la sentencia SQL, dependiendo de los parámetros pasados

		$oracionSQL = "SELECT IdAsignatura, Codigo, Nombre, Estudios, Curso FROM Asignatura";

		if($idGrado !== "ALL" && $idCurso !== "ALL"){
			$oracionSQL .= " WHERE Estudios=? AND Curso=?";
		}else{

			if($idGrado !== "ALL"){
				$oracionSQL .= " WHERE Estudios=?";
			}

			if($idCurso !== "ALL"){
				$oracionSQL .= " WHERE Curso=?";
			}
		}

		if($oracion = $DB->prepare($oracionSQL)){

			if($idGrado !== "ALL" && $idCurso !== "ALL"){
				$oracion->bindParam(1, $idGrado, PDO::PARAM_INT);
				$oracion->bindParam(2, $idCurso, PDO::PARAM_INT);
			}else{

				if($idGrado !== "ALL"){
					$oracion->bindParam(1, $idGrado, PDO::PARAM_INT);
				}

				if($idCurso !== "ALL"){
					$oracion->bindParam(1, $idCurso, PDO::PARAM_INT);
				}
			}

			$oracion->execute();

				$i = 0;
				echo "{";

				while($fila = $oracion->fetchObject()){
					echo "\"".($i++)."\":{ \"id\": \"".$fila->IdAsignatura."\", \"Codigo\": \"".$fila->Codigo."\", \"Nombre\" : \"".$fila->Codigo." ".$fila->Nombre."\", \"Curso\" :\"".$fila->Curso."\"";
					echo "}\n,";

				}
				echo " \"length\":".$oracion->rowCount()."}";
	

	}

}

/**
Función: obtener_grados
	Retorna los grados disponibles en la plataforma.
*/

function obtener_grados(){
	$DB = sql_connect();
	if($puntero = $DB->query("SELECT IdEstudios, Nombre FROM Estudios")){
			$i = $puntero->rowCount();
			echo "{";
			while($fila = $puntero->fetchObject()){
				echo "\"".$fila->IdEstudios."\":{ \"Nombre\": \"".$fila->Nombre."\"";
				echo "}\n,";

			}
			echo " \"length\":".$puntero->rowCount()."}";

	}else{
		json_void();
	}
}

/**
Función: filtrar_apuntes
	Muestra los apuntes aplicandoles filtro de búsqueda.
*/
function filtrar_apuntes(){
	$DB = sql_connect();

	$idAsignatura = isset($_GET["asignatura"]) ? $_GET["asignatura"] : "ALL";
	$idCurso = isset($_GET["curso"]) ? $_GET["curso"] : "ALL";
	$idGrado = isset($_GET["grado"]) ? $_GET["grado"] : "ALL";
	$pagina  = isset($_GET["pagina"]) ? $_GET["pagina"] : 0;
	$offset = $pagina*10; 

	if($idAsignatura !== "ALL"){
		
		if($oracion = $DB->prepare("SELECT DISTINCT Documentos.IdDocumento, Documentos.Titulo, Usuario.Nick AS Nick, Documentos.FechaSubida, Tipo.Nombre AS Tipo, Documentos.Tipo AS IdTipo, Anio.Anio, Documento, Asignatura.Nombre AS Asignatura, Documentos.Comentario, Documentos.Usuario AS IdUsuario, Estudios.Nombre AS Grado FROM Documentos, Tipo, Usuario, Anio, Asignatura, Estudios WHERE Documentos.Asignatura=? AND Documentos.Usuario = Usuario.IdUsuario AND Anio.IdAnio = Documentos.Anio AND Tipo.IdTipo = Documentos.Tipo AND Documentos.asignatura = Asignatura.IdAsignatura AND Asignatura.Estudios = Estudios.IdEstudios ORDER BY FechaSubida, IdDocumento DESC LIMIT 10 OFFSET ?")){

			$oracion->bindParam(1, $idAsignatura, PDO::PARAM_INT);
			$oracion->bindParam(2, $offset, PDO::PARAM_INT);
			$oracion->execute();
				$i=0;
				echo "{";
				while($fila = $oracion->fetchObject()){
					echo "\"$i\":{";
					echo '"Id":"'.$fila->IdDocumento.'",';
					echo '"Titulo":"'.$fila->Titulo.'",';
					echo '"Nick":"'.$fila->Nick.'",';
					echo '"IdUsuario":"'.$fila->IdUsuario.'",';
					echo '"Comentario":"'.$fila->Comentario.'",';
					echo '"Fecha":"'.$fila->FechaSubida.'",';
					echo '"Tipo":"'.$fila->Tipo.'",';
					echo '"Curso":"'.$fila->Anio.'",';
					echo '"Grado":"'.$fila->Grado.'",';
					echo '"Documento":"'.$fila->Documento.'",';
					echo '"Asignatura":"'.$fila->Asignatura.'",';
					echo '"IdTipo":"'.$fila->IdTipo.'"';
					echo "},";
					$i++;

				}
				echo "\"length\":".$oracion->rowCount()."}";
		}else{
			json_void();
		}
	}else{
		$oracionSQL = "SELECT DISTINCT Documentos.IdDocumento, Documentos.Titulo, Usuario.Nick AS Nick, Documentos.FechaSubida, Tipo.Nombre AS Tipo, Anio.Anio, Documento, Asignatura.Nombre AS Asignatura, Documentos.Comentario, Documentos.Usuario AS IdUsuario, Estudios.Nombre AS Grado, Documentos.Tipo AS IdTipo FROM Documentos, Tipo, Usuario, Anio, Asignatura, Estudios WHERE ";
		if($idCurso !== "ALL"){
			$oracionSQL .= "Asignatura.Curso=? AND ";
		}
		if($idGrado !== "ALL"){
			$oracionSQL .= "Asignatura.Estudios=? AND ";
		}
		 
		 $oracionSQL .= "Documentos.Usuario = Usuario.IdUsuario AND Anio.IdAnio = Documentos.Anio AND Tipo.IdTipo = Documentos.Tipo AND Documentos.asignatura = Asignatura.IdAsignatura AND Asignatura.Estudios = Estudios.IdEstudios ORDER BY Documentos.FechaSubida, IdDocumento DESC LIMIT 11 OFFSET ?";

		if($oracion = $DB->prepare($oracionSQL)){
			
			

		if($idCurso !== "ALL" && $idGrado !== "ALL"){
			$oracion->bindParam(1, $idCurso, PDO::PARAM_INT);
			$oracion->bindParam(2, $idGrado, PDO::PARAM_INT);
			$oracion->bindParam(3, $offset, PDO::PARAM_INT);
		}

		if($idCurso !== "ALL" && $idGrado === "ALL"){
			$oracion->bindParam(1, $idCurso, PDO::PARAM_INT);
			$oracion->bindParam(2, $offset, PDO::PARAM_INT);
		}

		if($idCurso === "ALL" && $idGrado !== "ALL"){
			$oracion->bindParam(1, $idGrado, PDO::PARAM_INT);
			$oracion->bindParam(2, $offset, PDO::PARAM_INT);
		}

		if($idCurso === "ALL" && $idGrado === "ALL"){

			$oracion->bindParam(1, $offset, PDO::PARAM_INT);

		}

			$oracion->execute();
				$i=0;
				echo "{";
				while(($fila = $oracion->fetchObject()) && $i<10){
					echo "\"$i\":{";
					echo '"Id":"'.$fila->IdDocumento.'",';
					echo '"Titulo":"'.$fila->Titulo.'",';
					echo '"Nick":"'.$fila->Nick.'",';
					echo '"IdUsuario":"'.$fila->IdUsuario.'",';
					echo '"Comentario":"'.$fila->Comentario.'",';
					echo '"Fecha":"'.$fila->FechaSubida.'",';
					echo '"Tipo":"'.$fila->Tipo.'",';
					echo '"Curso":"'.$fila->Anio.'",';
					echo '"Grado":"'.$fila->Grado.'",';
					echo '"Documento":"'.$fila->Documento.'",';
					echo '"Asignatura":"'.$fila->Asignatura.'",';
					echo '"IdTipo":"'.$fila->IdTipo.'"';
					echo "},";
					$i++;

				}

				if($i == 10){ echo "\"next\": \"true\",";}else{echo "\"next\": \"false\",";}
				echo "\"length\":".$i."}";
	
		}else{
			json_void();
		}

	}

}

/**
Función: buscar_texto
	Retorna los apuntes buscando por título o comentario. Además, seleciona si busca exámenes, apuntes, o ambos dependiendo de la variable tipo
	pasada por GET. Se muestra a continuación la tabla de verdad entre el valor de tipo y la búsqueda de Examenes o Apuntes:
		Examenes 	Apuntes 	Tipo
		true		true		3
		true		false		2
		false		true		1	
*/
function buscar_texto(){
	$DB = sql_connect();					// Nos conectamos con la base de datos

	$query = $_GET["busqueda"];				// Texto de búsqueda

	$tipo = $_GET["tipo"];					// Variable tipo: Si buscamos apuntes, examenes o ambos.

	// Calculamos el OFFSET
	$pagina  = isset($_GET["pagina"]) ? $_GET["pagina"] : 0;
	$offset = $pagina*10;

	/**
		A partir de éste punto, generamos la consulta SQL dependiendo de los datos recibidos.
	*/
	$oracionSQL = "SELECT DISTINCT Documentos.IdDocumento, Documentos.Titulo, Usuario.Nick AS Nick, Documentos.FechaSubida, Tipo.Nombre AS Tipo, Anio.Anio, Documentos.Documento , Asignatura.Nombre AS Asignatura, Documentos.Comentario, Documentos.Usuario AS IdUsuario, Estudios.Nombre AS Grado, Documentos.Tipo AS IdTipo FROM Documentos, Tipo, Usuario, Anio, Asignatura, Estudios WHERE ( Documentos.Titulo LIKE ? OR Documentos.Comentario LIKE ? )AND Documentos.Usuario = Usuario.IdUsuario AND Anio.IdAnio = Documentos.Anio AND Tipo.IdTipo = Documentos.Tipo AND Documentos.asignatura = Asignatura.IdAsignatura AND Asignatura.Estudios = Estudios.IdEstudios";

	/**
		Dependiendo de la variable tipo, añadimos (o no) restricciones a la consulta SQL.
	*/
	switch($tipo){ 
		case "1":
			$oracionSQL .= " AND Documentos.Tipo = 0";		//	Añadimos la restricción de que sean sólo Apuntes
		break;
		case "2":
			$oracionSQL .= " AND Documentos.Tipo = 1";		//	Añadimos la restricción de que sean sólo Exámenes
		break;
		case "3":										// En éste caso no necesitamos ninguna restricción...
		break;
		default:
			exit(); 									// Si no es ninguno de los valores, entonces puede haber inyección SQL (?)
		break;
	}

	$oracionSQL .= " ORDER BY Documentos.FechaSubida, Documentos.IdDocumento LIMIT 10 OFFSET ?";
	if($oracion = $DB->prepare($oracionSQL)){			// Si no hay ningún error al preparar la oración SQL

			/**
				Parseamor la búsqueda, dependiendo del texto:
					· Si la búsqueda empieza y acaba con comillas ("), entonces generamos una consulta donde
					  tenga que aparecer explicitamente la búsqueda.
					· Si la búsqueda no empieza y acaba con comillas, entonces generamos una consulta donde se
					  busquen apuntes cuyo título y/o compentario contengan las palabras en el órden dado.
			*/
			if($query[0] == '"' && $query[strlen($query)-1] == '"'){
				$query_bind = "%".str_replace("\"", "", $query)."%";
			}else{

				$query_palabras = explode(" ", $query);
				$i = 0;
				$query_bind = "";
				while($i<count($query_palabras)){
					$query_bind.="%".$query_palabras[$i];
					$i++;
				}
				$query_bind.="%";
			}

			// Añadimos las cadenas de texto a la consulta y el OFFSET
			$oracion->bindParam(1, $query_bind, PDO::PARAM_STR);
			$oracion->bindParam(2, $query_bind, PDO::PARAM_STR);
			$oracion->bindParam(3, $offset, PDO::PARAM_INT);

			$oracion->execute();									// Ejecutamos la consulta

				$i=0;
				echo "{";
				while($fila = $oracion->fetchObject()){				// Generamos el código JSON para enviarlo por AJAX.
					echo "\"$i\":{";
					echo '"Id":"'.$fila->IdDocumento.'",';
					echo '"Titulo":"'.$fila->Titulo.'",';
					echo '"Nick":"'.$fila->Nick.'",';
					echo '"IdUsuario":"'.$fila->IdUsuario.'",';
					echo '"Comentario":"'.$fila->Comentario.'",';
					echo '"Fecha":"'.$fila->FechaSubida.'",';
					echo '"Tipo":"'.$fila->Tipo.'",';
					echo '"Curso":"'.$fila->Anio.'",';
					echo '"Grado":"'.$fila->Grado.'",';
					echo '"Documento":"'.$fila->Documento.'",';
					echo '"Asignatura":"'.$fila->Asignatura.'",';
					echo '"IdTipo":"'.$fila->IdTipo.'"';
					echo "},";
					$i++;

				}
				echo "\"length\":".$oracion->rowCount()."}";
		
	}else{
		json_void();
	}

}

/**
Función: obtener_ultimos
	Retorna los últimos apuntes subidos.
*/
function obtener_ultimos(){

	$DB = sql_connect();
	if($puntero = $DB->query("SELECT DISTINCT Documentos.IdDocumento, Documentos.Titulo, Usuario.Nick AS Nick, Documentos.FechaSubida, Tipo.Nombre AS Tipo, Anio.Anio,Documento , Asignatura.Nombre AS Asignatura, Documentos.Comentario, Documentos.Usuario AS IdUsuario, Estudios.Nombre AS Grado, Documentos.Tipo AS IdTipo FROM Documentos, Tipo, Usuario, Anio, Asignatura, Estudios WHERE Documentos.Usuario = Usuario.IdUsuario AND Anio.IdAnio = Documentos.Anio AND Tipo.IdTipo = Documentos.Tipo AND Documentos.asignatura = Asignatura.IdAsignatura AND Asignatura.Estudios = Estudios.IdEstudios ORDER BY Documentos.FechaSubida DESC LIMIT 10")){
			$i=0;
			echo "{";
				while($fila = $puntero->fetchObject()){
					echo "\"$i\":{";
					echo '"Id":"'.$fila->IdDocumento.'",';
					echo '"Titulo":"'.$fila->Titulo.'",';
					echo '"Nick":"'.$fila->Nick.'",';
					echo '"IdUsuario":"'.$fila->IdUsuario.'",';
					echo '"Comentario":"'.$fila->Comentario.'",';
					echo '"Fecha":"'.$fila->FechaSubida.'",';
					echo '"Tipo":"'.$fila->Tipo.'",';
					echo '"Curso":"'.$fila->Anio.'",';
					echo '"Grado":"'.$fila->Grado.'",';
					echo '"Documento":"'.$fila->Documento.'",';
					echo '"Asignatura":"'.$fila->Asignatura.'",';
					echo '"IdTipo":"'.$fila->IdTipo.'"';
					echo "},";
					$i++;

				}
				echo "\"length\":".$puntero->rowCount()."}";
	}else{
		json_void();
	}

}

/**
Función: informacion_documento
	Retorna la información del documento pasado por su identificador mediante get.
*/
function informacion_documento(){
	$DB = sql_connect();
	if(!isset($_GET["id"])){json_void();}else{
		$idApuntes = $_GET["id"];
	
	
	
		if($oracion = $DB->prepare("SELECT DISTINCT Documentos.IdDocumento, Documentos.Titulo, Usuario.Nick AS Nick, Documentos.FechaSubida, Tipo.Nombre AS Tipo, Anio.Anio, Documento, Asignatura.Nombre AS Asignatura, Documentos.Comentario, Documentos.Usuario AS IdUsuario, Estudios.Nombre AS Grado FROM Apuntes, Tipo, Usuario, Anio, Asignatura, Estudios WHERE Documentos.IdDocumento=? AND Documentos.Usuario = Usuario.IdUsuario AND Anio.IdAnio = Documentos.Anio AND Tipo.IdTipo = Documentos.Tipo AND Documentos.asignatura = Asignatura.IdAsignatura AND Asignatura.Estudios = Estudios.IdEstudios")){

			$oracion->bindParam(1, $idApuntes, PDO::PARAM_INT);
			$oracion->execute();
				$i=0;
				echo "{";
				while($fila = $oracion->fetchObject()){
					echo "\"$i\":{";
					echo '"Id":"'.$fila->IdDocumentos.'",';
					echo '"Titulo":"'.$fila->Titulo.'",';
					echo '"Nick":"'.$fila->Nick.'",';
					echo '"IdUsuario":"'.$fila->IdUsuario.'",';
					echo '"Comentario":"'.$fila->Comentario.'",';
					echo '"Fecha":"'.$fila->FechaSubida.'",';
					echo '"Tipo":"'.$fila->Tipo.'",';
					echo '"Curso":"'.$fila->Anio.'",';
					echo '"Grado":"'.$fila->Grado.'",';
					echo '"Documento":"'.$fila->Documento.'",';
					echo '"Asignatura":"'.$fila->Asignatura.'"';
					echo "},";
					$i++;

				}
				echo "\"length\":".$oracion->rowCount()."}";
			
		}else{
			json_void();
		}
	}

}





function json_error($id_error, $msg_error){
		echo "{\"Error\": true, \"mensaje\": \"".$msg_error."\", \"ErrorCode\": $id_error}";
}

function json_void(){
		echo "{ \"length\": 0}";
}

if(isset($_GET["func"])){ 
	switch($_GET["func"]){
		case "estudios":
			obtener_estudios();
		break;
		case "asignaturas":
			obtener_asignaturas();
		break;
		case "grados":
			obtener_grados();
		break;
		case "tipos":
			obtener_tipos();
		break;
		case "puntos":
			puntos();
		break;
		case "buscar_texto":
			buscar_texto();
		break;

		case "cursos":
			obtener_cursos();
		break;

		case "documento":
			informacion_documento();
		break;
		case "filtrar_apuntes":
			filtrar_apuntes();
		break;
		case "ultimos":
			obtener_ultimos();
		break;
		default:
			json_void();
		break;
	}
}else{
	json_void();
}

?>