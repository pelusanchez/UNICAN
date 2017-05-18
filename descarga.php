<?php
/**
Incluir para manejar la base de datos
*/
require_once("DB.php");
require_once("configuracion.php");

require_once("utiles.php");
require_once("sesion.php");

if(haEntrado()){
	if(!isset($_GET["id"])){ exit(); } // Comprobamos si se ha pasado un identificador

	$idApuntes = $_GET["id"];
	
	if(!is_nan($idApuntes)){ // Comprobamos si el identificador es un número por seguridad...

		$DB = sql_connect();
		if($oracion = $DB->prepare("SELECT DISTINCT Documentos.IdDocumento, Documentos.Titulo, Usuario.Nick AS Nick, Documentos.FechaSubida, Tipo.Nombre AS Tipo, Anio.Anio, Documento, Asignatura.Nombre AS Asignatura, Documentos.Comentario, Documentos.Usuario AS IdUsuario, Estudios.Nombre AS Grado FROM Documentos, Tipo, Usuario, Anio, Asignatura, Estudios WHERE Documentos.IdDocumento=? AND Documentos.Usuario = Usuario.IdUsuario AND Anio.IdAnio = Documentos.Anio AND Tipo.IdTipo = Documentos.Tipo AND Documentos.Asignatura = Asignatura.IdAsignatura AND Asignatura.Estudios = Estudios.IdEstudios")){
			
			$oracion->bindParam(1, $idApuntes, PDO::PARAM_INT);
			if($oracion->execute()){

				if($fila = $oracion->fetchObject()){

					// Se genera un nombre para el fichero
					header("Content-Disposition:attachment;filename='".creaNombreDeFichero($fila->Titulo).".pdf'");

					//ob_clean(); 
					//flush(); 
					//echo DIRECTORIO_SECRETO."/".$fila->Documento;
					echo file_get_contents(DIRECTORIO_SECRETO."/".$fila->Documento);    

				}else{
					exit(); // Error: no existe el apunte en la base de datos
				}
			}
		}else{
			echo "Error grave";
			exit(); // Error: consulta sql mal echa (?)
		}
	}else{
		exit(); // Error: el identificador no es un número (Inyección PHP ?)
	}
}else{?>

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
}?>