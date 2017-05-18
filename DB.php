<?php
require_once("configuracion.php");

require_once("./pdo/pdo.php");

function sql_connect(){
	switch(BASEDEDATOS["TIPO"]){
		case "mysql":
			return pdo_connect();
		break;
		case "mssql":
			//return mssql_connect();
		break;
	}
}

?>
