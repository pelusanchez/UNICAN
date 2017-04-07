<?php
/**
Incluir para manejar la base de datos
*/
require_once("DB.php");
require_once("func.php");
require_once("session.php");
if(isLoggedIn()){
	$userInfo = getUserInfo();
	echo "Hola ".$userInfo->Nombre." ".$userInfo->Apellido1." AKA ".$userInfo->Nick;
	$NOMBREUSUARIOCOMPLETO = $userInfo->Nombre." ".$userInfo->Apellido1;
	include("template.php");
?>
<?php
}else{
?>

<html>
	<head>
		<title>Apunter</title>
		<style type="text/css">
			body {
				background:#EEEEFF;
				font-family:Arial;
				font-size:16px;
			}
			#header {
				position:absolute;
				top:0px;
				left:0px;
				right:0px;
				height:100px;
				background:#FFFFFF;
				border-bottom:1px solid #CCCCCC;

			}

			#header_rightbox {
				position:absolute;
				top:5px;
				right:10px;
				bottom:5px;
				width:auto;
				min-width:100px;
				color:#101020;
			}
			#header_rightbox {
				text-align:right;
			}
			#header_grado, #header_asignaturas, #header_filtrar, #header_nombre {
				padding-top:2px;
				padding-right:5px;
				text-align:left;
				
			}
			#header_filtrar {
				color:#0000FF;
			}

			#header_closesesion {
				color:#FF0000;
			}
			#header_left {
				position:absolute;
				top:5px;
				left:10px;
				bottom:5px;
				width:auto;
				min-width:100px;
				color:#101020;
			}
			#header_searchbox{
				display:table-cell;
				padding-top:25px;
			}
			#header_search_text{
				vertical-align: center;
				width:250px;
				height:30px;
				font-size:16px;
				color:#BBB;
				border: 0px;
				border-bottom: 1px solid #AAA;
				padding-left:10px;
				outline: none;
			
			}

			#header_search_text.selected{
				color:#111;
			}

			#header_search{
				vertical-align: center;
				min-width:50px;
				height:30px;
				font-size:16px;
				color:#000;
				border: 0px;
				background-color:#EEE;
				border: 1px solid #AAA;
				padding-left:10px;
			
			}

			#canvas {
				position:absolute;
				top:110px;
				left:100px;
				right:100px;
				bottom:10px;
				background:#FFFFFF;
				overflow-y:auto;
				overflow-x:hidden;
			}

			.resultado {
				color:#404040;
				background:#E9E9E9F0;
				display:inline-block;
				border-bottom: 1px solid #AAA;
				width:100%;
				padding: 20px 20px 20px 20px;
			
			}

			

			.resultado .left{
				
				float:left;
			}

			.resultado .titulo {
				font-size:30px;
			}

			.resultado .titulo:hover {
				color:#000;
				cursor:pointer;
			}

			.resultado .right{
				float:right;
				margin-right:40px;
			}

			.resultado .comentario{
				float:left;
				padding-top:10px;
				color:#505050;
			}

			.resultado .Apuntes {
				color:#00DD00;
			}

			.resultado .Examen {
				color:#DD0000;
			}

			.resultado .titlecomment {
				font-size:16px;
			}
		</style>
		<script languaje="JavaScript">
		/**
		AJAX
		**/
		function ajaxpost( url,  postsend,  callback){
			var xhttp = new XMLHttpRequest();
			xhttp.open("POST", url, true);
			xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xhttp.send(postsend);
			xhttp.onreadystatechange = function(){
				if(xhttp.readyState == 4 && xhttp.status == 200){
					callback(xhttp);
				}
			}
		}

		function ajaxget( url,  callback){
			var xhttp = new XMLHttpRequest();
			xhttp.open("GET", url, true);
			xhttp.send();
			xhttp.onreadystatechange = function(){
				if(xhttp.readyState == 4 && xhttp.status == 200){
					callback(xhttp);
				}
			}
		}

		function getUrlHash(){
			var hash = location.hash.substring(1).split("&");
			var hashObj = {};
			var hashSplitted;
			
			for(var i = 0; i<hash.length; i++){

				hashSplitted = hash[i].split("=");
				hashObj[hashSplitted[0]] = hashSplitted[1];
			}
			return hashObj;
		}

		function addUrlHash(name, data){
			var hashObj = getUrlHash();
			for(var i = 0; i<hash.length; i++){

				hashSplitted = hash[i].split("=");
				hashObj[hashSplitted[0]] = hashSplitted[1];
			}
		}
			window.onload = function(){
				document.getElementById("header_closesesion").addEventListener("click",
					function(){
						window.location.href="login.php?unload=true";
						
					}
				);

				document.getElementById("grado").addEventListener("change",
					function(data){
						if(document.getElementById("grado").value == "ALL"){

						}else{
							cargarAsignaturas(document.getElementById("grado").value, document.getElementById("curso").value);
						}
					}
				);

				document.getElementById("header_filtrar").addEventListener("click",
					function(){
						cargarResultados();
					}
				);

				document.getElementById("header_search_text").addEventListener("focus",
					function(){
						var elm = document.getElementById("header_search_text");
						if(elm.value=="Buscar..."){
							elm.value = "";
							elm.className="selected";
						}
					}
				);

				document.getElementById("header_search_text").addEventListener("blur",
					function(){
						var elm = document.getElementById("header_search_text");
						if(elm.value==""){
							elm.value = "Buscar...";
							elm.className="";
						}
					}
				);
				document.getElementById("header_search_text").addEventListener("keydown",
					function(e){
						if(e.keyCode == 13){
							search_from_text(document.getElementById("header_search_text").value);
						}
					}
				);
				
				document.getElementById("header_search").addEventListener("click",
					function(){
						search_from_text(document.getElementById("header_search_text").value);
					}
				);
				cargarDatos();
			}

			
			function cargarDatos(){
				cargarGrados();
				cargarCursos();
			}
			function cargarGrados(){
				ajaxget( "fetcher.php?func=getgrados",
					function(xhttp){
						
						var dataJSON = JSON.parse(xhttp.responseText);
						console.log(dataJSON.length);
						document.getElementById("grado").innerHTML='<option value="ALL">Todos</option>';
						var nombre;
						for(var i = 0; i<dataJSON.length;i++){
							if(dataJSON[i].Nombre.length>20){
								nombre = dataJSON[i].Nombre.substring(0,17)+"...";
							}else{
								nombre = dataJSON[i].Nombre;
							}
							document.getElementById("grado").innerHTML+="<option value=\""+i+"\">"+nombre+"</option>";
						}
					}
				);
				
			}

			function cargarCursos(){
				document.getElementById("curso").innerHTML='<option value="ALL">Todos</option>';

				for(var i = 1; i<=4;i++){
					document.getElementById("curso").innerHTML+="<option value=\""+i+"\">"+i+"</option>";
				}
				
				
			}

			function cargarAsignaturas(grado, curso){
				ajaxget( "fetcher.php?func=asignaturas&grado="+grado+"&curso="+curso,
					function(xhttp){
						
						var dataJSON = JSON.parse(xhttp.responseText);
						console.log(dataJSON.length);
						document.getElementById("asignatura").innerHTML='<option value="ALL">Todas</option>';
						for(var i = 0; i<dataJSON.length;i++){
							if(dataJSON[i].Nombre.length>20){
								nombre = dataJSON[i].Nombre.substring(0,17)+"...";
							}else{
								nombre = dataJSON[i].Nombre;
							}
							document.getElementById("asignatura").innerHTML+="<option value=\""+i+"\">"+nombre+"</option>";
						}
					}
				);
			}


			function search_from_text(text){

				ajaxget( "fetcher.php?func=search_titulo&query="+encodeURI(text),
					function(xhttp){
						
						var dataJSON = JSON.parse(xhttp.responseText);
						console.log(dataJSON.length);
						var titulo;
						document.getElementById("canvas").innerHTML = "";
						for(var i = 0; i<dataJSON.length;i++){
							appendResult(dataJSON[i]);
						}
						
					}
				);
			}

			function aplicarFiltros(){


				ajaxget( "fetcher.php?func=search_titulo&query="+encodeURI(text),
					function(xhttp){
						
						var dataJSON = JSON.parse(xhttp.responseText);
						console.log(dataJSON.length);
						var titulo;
						document.getElementById("canvas").innerHTML = "";
						for(var i = 0; i<dataJSON.length;i++){
							appendResult(dataJSON[i]);
						}
						
					}
				);
			}


			function appendResult(datos){
				/**
							<div class="resultado">
				<div class="left">
					<div class="titulo">Titulo</div>
					<div class="comentario">comentario</div>
				</div>
				<div class="right">
					<div class="asignatura">Asignatura</div>
					<div class="curso">Curso</div>
					<div class="tipo">Tipo</div>
					<div class="fecha">Fecha</div>
					<div class="usuario">User</div>
				</div>

				
			</div>
				*/

				var titulo;
				var texto, nodo, nodoTexto;
				if(datos.Titulo.length>50){
						titulo = datos.Titulo.substring(0,47)+"...";
					}else{
						titulo = datos.Titulo;
				}
				var tipoText = "<span class=\""+datos.Tipo+" titlecomment\">"+datos.Tipo+"</span>";

				var resultado = document.createElement("div");                 // Crear elemento resultado
				resultado.className="resultado";

				var leftElm = document.createElement("div");                 // Crear elemento derecha AKA left
				leftElm.className="left";

				var rightElm = document.createElement("div");                 // Crear elemento izquierda AKA right
				rightElm.className="right";

				var nodo = document.createElement("div");                 // Crear elemento Titulo
				nodo.className="titulo";
				nodoTexto = document.createElement("span");   
				nodoTexto.className="titlecomment "+datos.Tipo;
				nodoTexto.appendChild(document.createTextNode(datos.Tipo));
				nodo.appendChild(document.createTextNode(titulo));
				nodo.appendChild(nodoTexto);
				leftElm.appendChild(nodo);

				var nodo = document.createElement("div");                 // Crear elemento Comentario
				nodo.className="comentario";
				nodo.appendChild(document.createTextNode(datos.Comentario)); 
				leftElm.appendChild(nodo);

				var nodo = document.createElement("div");                 // Crear elemento Asignatura
				nodo.className="asignatura";
				nodo.appendChild(document.createTextNode(datos.Asignatura)); 
				rightElm.appendChild(nodo);

				var nodo = document.createElement("div");                 // Crear elemento Grado 
				nodo.className="grado";
				nodo.appendChild(document.createTextNode(datos.Grado));
				rightElm.appendChild(nodo);

				var nodo = document.createElement("div");                 // Crear elemento Curso
				nodo.className="curso";
				nodo.appendChild(document.createTextNode(datos.Curso)); 
				rightElm.appendChild(nodo);

				
				var nodo = document.createElement("div");                 // Crear elemento Usuario
				nodo.className="nick";
				nodo.appendChild(document.createTextNode(datos.Nick));
				rightElm.appendChild(nodo);

				var nodo = document.createElement("div");                 // Crear elemento Fecha
				nodo.className="fecha";
				nodo.appendChild(document.createTextNode(datos.Fecha));
				rightElm.appendChild(nodo);

				

				resultado.appendChild(leftElm);
				resultado.appendChild(rightElm);

				document.getElementById("canvas").appendChild(resultado);

			}
		
			function cargarResultados(){
				var asignatura = document.getElementById("asignatura").value;
				var grado = document.getElementById("grado").value;
				var curso = document.getElementById("curso").value;
				console.log(asignatura);
				if(asignatura != "ALL"){
					ajaxget( "fetcher.php?func=resultados&asignatura="+asignatura,
						function(xhttp){
							
							var dataJSON = JSON.parse(xhttp.responseText);
							console.log(dataJSON.length);
						}
					);
				}else{

					ajaxget( "fetcher.php?func=resultados&curso="+asignatura+"&grado="+grado,
						function(xhttp){
							
							var dataJSON = JSON.parse(xhttp.responseText);
							console.log(dataJSON.length);
						}
					);

				}
			}
		</script>
	</head>
	<body>
		<div id="header">
			<div id="header_rightbox">
				<div id="header_nombre">Hola <?php echo $NOMBREUSUARIOCOMPLETO; ?> - <span id="header_closesesion">Salir</span></div>
				<table border="0">
					<tr>
						<td>Grado:</td>
						<td>
							<select id="grado">
								<option value="ALL">Todos</option>
							</select>
						</td>
						<td>Curso</td>
						<td>
							<select id="curso">
								<option value="ALL">Todos</option>
							</select>
						</td>
					</tr>
					<tr><td>Asignatura:</td>
					<td>
						<select id="asignatura">
							<option value="ALL">Todas</option>
						</select>
					</td></tr>
					<tr><td><div id="header_filtrar">Filtrar</div></td><td></td></tr>
				</table>
			</div>
			<div id="header_left">
				<div id="header_searchbox">
					<table border="0">
					<tr><td><input type="text" value="Buscar..." id="header_search_text" /></td>
					<td><input type="button" id="header_search" value="Buscar"/></td>
					</tr>
					</table>
				</div>
			</div>
		</div>
		<div id="canvas">
		</div>
	</body>
</html>

<?php
}
?>