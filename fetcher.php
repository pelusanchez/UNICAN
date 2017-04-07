<?php


/**
Incluir para manejar la base de datos
*/
require_once("DB.php");
require_once("func.php");
require_once("session.php");

if(!isLoggedIn()){ die("{\"Error\": true, \"ErrorCode\": 1}");  }

header('Content-Type: text/html; charset=iso-8859-1');

function estudios(){
	$DB = mysql_connect();
	if($result = $DB->query("SELECT IdEstudios, Nombre FROM Estudios")){
		$i = $result->num_rows;
		echo "{";
		while($fila = $result->fetch_object()){
			echo "\"".$fila->IdEstudios."\":\"".$fila->Nombre."\"\n,";

		}
		echo " \"length\":".$result->num_rows."}";
	}

}

function asignaturas(){
	$idGrado = (isset($_GET["grado"])) ? $_GET["grado"] : "ALL";
	$idCurso = (isset($_GET["curso"])) ? $_GET["curso"] : "ALL";


		$DB = mysql_connect();
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
				$oracion->bind_param("ii", $idGrado, $idCurso);
			}else{

				if($idGrado !== "ALL"){
					$oracion->bind_param("i", $idGrado);
				}

				if($idCurso !== "ALL"){
					$oracion->bind_param("i", $idCurso);
				}
			}

			$oracion->execute();
			if($result = $oracion->get_result()){
				$i = 0;
				echo "{";

				while($fila = $result->fetch_object()){
					echo "\"".($i++)."\":{ \"id\": \"".$fila->IdAsignatura."\", \"Codigo\": \"".$fila->Codigo."\", \"Nombre\" : \"".$fila->Nombre."\", \"Curso\" :\"".$fila->Curso."\"";
					echo "}\n,";

				}
				echo " \"length\":".$result->num_rows."}";
			}

	}

}
/**

function apuntes_id($idApuntes){
	if(is_nan($idApuntes)){ json_void(); }else{
		$DB = mysql_connect();
		if($oracion = $DB->prepare("SELECT Apuntes.Titulo, Usuarios.Nombre AS Usuario, Apuntes.FechaSubida, Tipo.Nombre AS Tipo, Anio.Anio, Documento, Asignatura.Nombre AS Asignatura FROM Apuntes, Tipo, Usuarios, Anio, Asignatura WHERE IdApuntes=? AND Apuntes.Usuarios = Usuarios.IdUsuario AND Anio.IdAnio = Apuntes.Anio AND Tipo.IdTipo = Apuntes.Tipo AND Apuntes.asignatura = Asignatura.IdAsignatura")){
			$oracion->bind_param("i", $idApuntes);
			$oracion->execute();
			if($result = $oracion->get_result()){
				$i = $result->num_rows;
				echo "{";
				while($fila = $result->fetch_object()){
					echo '"Titulo":"'.$fila->Titulo.'",';
					echo '"Usuario":"'.$fila->Usuario.'",';
					echo '"FechaSubida":"'.$fila->FechaSubida.'",';
					echo '"Tipo":"'.$fila->Tipo.'",';
					echo '"Anio":"'.$fila->Anio.'",';
					echo '"Documento":"'.$fila->Documento.'",';
					echo '"Asignatura":"'.$fila->Asignatura;

				}
				echo "}";
			}
		}else{
			json_void();
		}
	}

}

function apuntes_por_asignatura($idAsignatura){
	if(is_nan($idAsignatura)){ json_void(); }else{
		$DB = mysql_connect();
		if($oracion = $DB->prepare("SELECT DISTINCT Apuntes.IdApuntes, Apuntes.Titulo, Usuarios.Nombre AS Usuario, Apuntes.FechaSubida, Tipo.Nombre AS Tipo, Anio.Anio, Documento, Asignatura.Nombre AS Asignatura FROM Apuntes, Tipo, Usuarios, Anio, Asignatura WHERE Apuntes.Asignatura=? AND Apuntes.Usuarios = Usuarios.IdUsuario AND Anio.IdAnio = Apuntes.Anio AND Tipo.IdTipo = Apuntes.Tipo AND Apuntes.asignatura = Asignatura.IdAsignatura")){
			$oracion->bind_param("i", $idAsignatura);
			$oracion->execute();
			if($result = $oracion->get_result()){
				$i=0;
				echo "{";
				while($fila = $result->fetch_object()){
					echo "\"$i\":{";
					echo '"Id":"'.$fila->IdApuntes.'",';
					echo '"Titulo":"'.$fila->Titulo.'",';
					echo '"Usuario":"'.$fila->Usuario.'",';
					echo '"FechaSubida":"'.$fila->FechaSubida.'",';
					echo '"Tipo":"'.$fila->Tipo.'",';
					echo '"Anio":"'.$fila->Anio.'",';
					echo '"Documento":"'.$fila->Documento.'",';
					echo '"Asignatura":"'.$fila->Asignatura.'"';
					echo "},";
					$i++;

				}
				echo "\"length\":".$result->num_rows."}";
			}
		}else{
			json_void();
		}
	}

}*/

function apuntes_query(){
	$idAsignatura = isset($_GET["asignatura"]) ? $_GET["asignatura"] : "ALL";
	$idCurso = isset($_GET["curso"]) ? $_GET["curso"] : "ALL";
	$idGrado = isset($_GET["grado"]) ? $_GET["grado"] : "ALL";
	$DB = mysql_connect();

	if($idAsignatura !== "ALL"){
		
		if($oracion = $DB->prepare("SELECT DISTINCT Apuntes.IdApuntes, Apuntes.Titulo, Usuarios.Nick AS Nick, Apuntes.FechaSubida, Tipo.Nombre AS Tipo, Anio.Anio, Documento, Asignatura.Nombre AS Asignatura, Apuntes.Comentario, Apuntes.Usuarios AS IdUsuario, Estudios.Nombre AS Grado FROM Apuntes, Tipo, Usuarios, Anio, Asignatura, Estudios WHERE Apuntes.Asignatura=? AND Apuntes.Usuarios = Usuarios.IdUsuario AND Anio.IdAnio = Apuntes.Anio AND Tipo.IdTipo = Apuntes.Tipo AND Apuntes.asignatura = Asignatura.IdAsignatura AND Asignatura.Estudios = Estudios.IdEstudios")){
			$oracion->bind_param("i", $idAsignatura);
			$oracion->execute();
			if($result = $oracion->get_result()){
				$i=0;
				echo "{";
				while($fila = $result->fetch_object()){
					echo "\"$i\":{";
					echo '"Id":"'.$fila->IdApuntes.'",';
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
				echo "\"length\":".$result->num_rows."}";
			}
		}else{
			json_void();
		}
	}else{
		$oracionSQL = "SELECT DISTINCT Apuntes.IdApuntes, Apuntes.Titulo, Usuarios.Nick AS Nick, Apuntes.FechaSubida, Tipo.Nombre AS Tipo, Anio.Anio, Documento, Asignatura.Nombre AS Asignatura, Apuntes.Comentario, Apuntes.Usuarios AS IdUsuario, Estudios.Nombre AS Grado FROM Apuntes, Tipo, Usuarios, Anio, Asignatura, Estudios WHERE ";
		if($idCurso !== "ALL"){
			$oracionSQL .= "Asignatura.Curso=? AND ";
		}
		if($idGrado !== "ALL"){
			$oracionSQL .= "Asignatura.Estudios=? AND ";
		}
		 
		 $oracionSQL .= "Apuntes.Usuarios = Usuarios.IdUsuario AND Anio.IdAnio = Apuntes.Anio AND Tipo.IdTipo = Apuntes.Tipo AND Apuntes.asignatura = Asignatura.IdAsignatura AND Asignatura.Estudios = Estudios.IdEstudios";

		if($oracion = $DB->prepare($oracionSQL)){
			
			

		if($idCurso !== "ALL" && $idGrado !== "ALL"){
			$oracion->bind_param("ii", $idCurso, $idGrado);
		}

		if($idCurso !== "ALL" && $idGrado === "ALL"){
			$oracion->bind_param("i", $idCurso);
		}

		if($idCurso === "ALL" && $idGrado !== "ALL"){
			$oracion->bind_param("i", $idGrado);
		}


			$oracion->execute();
			if($result = $oracion->get_result()){
				$i=0;
				echo "{";
				while($fila = $result->fetch_object()){
					echo "\"$i\":{";
					echo '"Id":"'.$fila->IdApuntes.'",';
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
				echo "\"length\":".$result->num_rows."}";
			}
		}else{
			json_void();
		}

	}

}


function search_titulo($query){
	$DB = mysql_connect();
	if($oracion = $DB->prepare("SELECT DISTINCT Apuntes.IdApuntes, Apuntes.Titulo, Usuarios.Nick AS Nick, Apuntes.FechaSubida, Tipo.Nombre AS Tipo, Anio.Anio, Documento, Asignatura.Nombre AS Asignatura, Apuntes.Comentario, Apuntes.Usuarios AS IdUsuario, Estudios.Nombre AS Grado FROM Apuntes, Tipo, Usuarios, Anio, Asignatura, Estudios WHERE Apuntes.Titulo LIKE ? AND Apuntes.Usuarios = Usuarios.IdUsuario AND Anio.IdAnio = Apuntes.Anio AND Tipo.IdTipo = Apuntes.Tipo AND Apuntes.asignatura = Asignatura.IdAsignatura AND Asignatura.Estudios = Estudios.IdEstudios")){

			//Parseamos la búsqueda...
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
			$oracion->bind_param("s", $query_bind);
			$oracion->execute();
			if($result = $oracion->get_result()){
				$i=0;
				echo "{";
				while($fila = $result->fetch_object()){
					echo "\"$i\":{";
					echo '"Id":"'.$fila->IdApuntes.'",';
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
				echo "\"length\":".$result->num_rows."}";
			}
	}else{
		json_void();
	}

}

function getGrados(){
	$DB = mysql_connect();
	if($result = $DB->query("SELECT IdEstudios, Nombre FROM Estudios")){
			$i = $result->num_rows;
			echo "{";
			while($fila = $result->fetch_object()){
				echo "\"".$fila->IdEstudios."\":{ \"Nombre\": \"".$fila->Nombre."\"";
				echo "}\n,";

			}
			echo " \"length\":".$result->num_rows."}";

	}else{
		json_void();
	}
}





/**
function getCursos(){
	$DB = mysql_connect();
	if($result = $DB->query("SELECT IdCurso FROM Curso")){
			$i = $result->num_rows;
			echo "{";
			while($fila = $result->fetch_object()){
				echo "\"".$fila->IdEstudios."\":{ \"Nombre\": \"".$fila->Nombre."\"";
				echo "}\n,";

			}
			echo " \"length\":".$result->num_rows."}";

	}else{
		json_void();
	}
}*/



function json_void(){
		echo "{ \"length\": 0}";
}

if(isset($_GET["func"])){ 
	switch($_GET["func"]){
		case "estudios":
			estudios();
		break;
		case "asignaturas":
			asignaturas();
		break;
		case "search_titulo":
			search_titulo($_GET["query"]);
		break;
		case "getgrados":
			getGrados();
		break;

		case "query":
			apuntes_query();
		break;
		default:
			json_void();
		break;
	}
}else{
	json_void();
}
?>
