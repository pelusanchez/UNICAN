<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="cache-control" content="max-age=0" />
		<meta http-equiv="cache-control" content="no-cache" />
		<meta http-equiv="expires" content="0" />
		<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
		<meta http-equiv="pragma" content="no-cache" />
		<title>Apunter</title>
		<style type="text/css">
			#mensaje_error {

				position:absolute;
				top:20px;
				left:0px;
				height:auto;
				width:300px;
				word-wrap: break-word;
				opacity:0;
				display:none;
				
				border:1px solid rgba(20,20,20,0.5);
				border-radius:5px;
				background:rgba(200,200,200, 0.4);
				color:#000000;
				z-index:9999;
				padding: 20px 20px 20px 20px;
				text-align:center;
				

			}

			body {
				background:#EEEEEE;
				font-family:Arial;
				font-size:16px;
				margin: 0;
				padding:0;
				width:100%;
			}

			

			#header {
				position:absolute;

				/*CSS3 HTML5*/
				display: -webkit-flex;
    			display: flex;
    			align-items: center;

				top:0px;
				left:0px;
				right:0px;
				height:80px;
				background:#FFFFFF;
				border-bottom:1px solid #CCCCCC;

			}

			#header_filtrar {
				color:#0000FF;
			}

			#header_right .closesesion{
				font-size:18px;
				color:#FF0000;
			}
			#header_right .username{
				font-size:18px;
				color:#101010;
			}

			#header_left {
				margin-right:auto;
				padding-left:20px;
				padding-top:5px;
				width:200px;
				color:#101020;
				
			}

			#header_middle {
				/*margin: 0 auto;*/
			}

			#header_searchbox{
				display:table-cell;
				padding-top:10px;
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

			#header_search {
				vertical-align: center;
				min-width:50px;
				height:30px;
				font-size:16px;
				color:#000;
				border: 0px;
				background-color:#EEE;
				border: 1px solid #AAA;
			
			}

			#header_right {
				padding-right:10px;
				margin-left:auto;
				display: table;
				width:200px;
			}

			#header_right .info {
				display:table-row;
				font-size:14px;
			}

			#header_right .info .cell {
				display:table-cell;

			}

			#header_right .textright {
				text-align: right;
				padding-right:5px;
			}

			#header_subir {
				color:#2020EE;
				font-size:16px;
			}

			.colorgray {
				color:#707070;
			}


			#header_grado, #header_asignaturas, #header_filtrar, #header_nombre {
				padding-top:2px;
				padding-right:5px;
				text-align:left;
				height:20px;
				max-height:20px;
				
			}

			#util_bar {
				position:absolute;
				top:80px;
				left:0px;
				right:0px;
				width:100%;
				height:30px;
				border-bottom:1px solid #AAA;
				background:#FFF;
			}

			#canvas {
				position:absolute;
				top:80px;
				left:100px;
				right:100px;
				bottom:10px;
				background:#FFFFFF;
				overflow-y:auto;
				overflow-x:hidden;
				border: 1px solid #AAA;
				z-index:2;

			}

			#canvas::-webkit-scrollbar {
    			width: 10px;
			}
 
			#canvas::-webkit-scrollbar-track {
    				background:#FFFFFF;
			}
 
			#canvas::-webkit-scrollbar-thumb {
  				background-color: #DEDEDF;
				border-radius:10px;
			}

			#canvas::-moz-scrollbar {
    			width: 10px;
			}
 
			#canvas::-moz-scrollbar-track {
    				background:#FFFFFF;
			}
 
			#canvas::-moz-scrollbar-thumb {
  				background-color: #DEDEDF;
				border-radius:10px;
			}
			.resultado {
				color:#404040;
				background:#FEFEFE;
				box-sizing: border-box;
				display:inline-block;
				border-bottom: 1px solid #AAA;
				width:100%;
				padding: 20px 0px 20px 20px;
			
			}

			

			.resultado .left{
				
				float:left;
			}

			.resultado .titulo {
				font-size:30px;
			}

			.resultado .titulo:hover {
				color:#000;
			}

			.puntero, .resultado .titulo:hover {
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

			#botonesNavegacion {
				color:#404040;
				background:#FEFEFE;
				box-sizing: border-box;
				display:inline-block;
				width:100%;
				padding: 20px 0px 20px 20px;
				min-height:50px;

			}

			#boton_izquierda {
				font-size:20px;
				float:left;
				cursor:pointer;
			}

			#boton_derecha {
				font-size:20px;
				float:right;
				cursor:pointer;
			}

			.documento_tipo_0 {
				color:#00EE00;
			}

			.documento_tipo_1 {
				color:#00BB00;
			}

			.documento_tipo_2 {
				color:#FF0000;
			}

			.pequeno {
				height:14px;
				font-size:12px;
			}

			.sinresultado {
				width:100%;
				text-align: center;
				font-size:18px; 
			}
		</style>
		<script languaje="JavaScript">
		var textoBusqueda;
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
						window.location.href="entrar.php?salir=1";
						
					}
				);

				document.getElementById("grado").addEventListener("change",
					function(data){
							cargarAsignaturas(document.getElementById("grado").value, document.getElementById("curso").value);
					}
				);

				document.getElementById("curso").addEventListener("change",
					function(data){
						cargarAsignaturas(document.getElementById("grado").value, document.getElementById("curso").value);
					}
				);

				document.getElementById("header_filtrar").addEventListener("click",
					function(){
						cargarResultados(0);
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
							buscarPorTexto(document.getElementById("header_search_text").value, -1);
						}
					}
				);
				
				document.getElementById("header_search").addEventListener("click",
					function(){
						buscarPorTexto(document.getElementById("header_search_text").value, -1);
					}
				);

				document.getElementById("header_subir").addEventListener("click",
					function(){
						var newWindow = window.open("subir.php");
  						newWindow.focus();
					}
				);

				
				cargarDatos();
			}

			
			function cargarDatos(){
				cargarGrados();
				cargarCursos();
				cargarAsignaturas("ALL","ALL");
				ultimos();
				escribirPuntos(<?php echo idUsuario(); ?>, document.getElementById("puntos"));
			}
			function cargarGrados(){
				ajaxget( "becario.php?func=getgrados",
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
				ajaxget( "becario.php?func=asignaturas&grado="+grado+"&curso="+curso,
					function(xhttp){
						
						var dataJSON = JSON.parse(xhttp.responseText);
						console.log(dataJSON);
						document.getElementById("asignatura").innerHTML='<option value="ALL">Todas</option>';
						for(var i = 0; i<dataJSON.length;i++){
							if(dataJSON[i].Nombre.length>20){
								nombre = dataJSON[i].Nombre;//.substring(0,17)+"...";
							}else{
								nombre = dataJSON[i].Nombre;
							}
							document.getElementById("asignatura").innerHTML+="<option value=\""+dataJSON[i].id+"\" label=\""+dataJSON[i].Nombre+"\">"+nombre+"</option>";
						}
					}
				);
			}


			function mensajeDeError(error){
				var errElm = document.getElementById("mensaje_error");
				errElm.style.display = "block";
				errElm.style.left = (window.innerWidth-342)/2;
				errElm.innerHTML = error;
				var i = 0;
				var opa = 0;
				var mde_timeout = setInterval(
					function(){
						i+=10;
						if(i<=100){
							opa = i/100;
							if(opa>1){opa = 1;}
							errElm.style.opacity = opa;
						}else if(i>= 300 && i<400){
							opa = (400-i)/100;
							if(opa>1){opa = 1;}
							if(opa<0){opa = 0;}
							errElm.style.opacity = opa;
						}else if(i>=400){
							errElm.style.display = "none";
							clearInterval(mde_timeout);
						}
						
					},
				100);
				
			}

			function sinResultados(){
				var resultado = document.createElement("div");
				resultado.className = "sinresultado";

				var nodoTexto = document.createElement("span");   
				nodoTexto.appendChild(document.createTextNode("Sin resultados :/"));
				resultado.appendChild(nodoTexto);				
				document.getElementById("canvas").appendChild(resultado);

			}

			function buscarPorTexto(texto, pagina){
				if(texto == ""){ return 0; }
				if(pagina == -1){ // La pagina es -1 si la busqueda la realiza el usuario
					pagina = 0;
					textoBusqueda = texto;
				}
				

				var tipos = 0;
				/**
				La variable tipos vale:

					Examenes 	Apuntes 	Tipo
					true		true		3
					true		false		2
					false		true		1
				*/
				if(document.getElementById("header_search_check_examenes").checked){
					tipos = 2;
				}
				if(document.getElementById("header_search_check_apuntes").checked){
					tipos++;
				}
				if(tipos>0){
					ajaxget( "becario.php?func=buscar_texto&busqueda="+encodeURI(texto)+"&tipo="+tipos+"&pagina="+pagina,
						function(xhttp){
							console.log(xhttp.responseText);
							var dataJSON = JSON.parse(xhttp.responseText);
							
							var titulo;
							document.getElementById("canvas").innerHTML = "";
							for(var i = 0; i<dataJSON.length;i++){
								appendResult(dataJSON[i]);
							}

							if(dataJSON.length == 0){
								sinResultados();
								return 0;
							}
							
							console.log("Mas de 10"+dataJSON.length);
							if(pagina == 0 && dataJSON.length >= 10){
								anadirBotonesNavegacion("delante", "buscarPorTexto", pagina);
							}
							if(pagina > 0 && dataJSON.length >= 10){
								anadirBotonesNavegacion("ambos", "buscarPorTexto", pagina);
							}
							if(pagina > 0 && dataJSON.length < 10){
								anadirBotonesNavegacion("atras", "buscarPorTexto", pagina);
							}
							
						}
					);
				}else{
					mensajeDeError("Eso no es posible...");
				}

			}

			function ultimos(){

				ajaxget( "becario.php?func=ultimos",
					function(xhttp){
						
						var dataJSON = JSON.parse(xhttp.responseText);

						document.getElementById("canvas").innerHTML = "";
						for(var i = 0; i<dataJSON.length;i++){
							appendResult(dataJSON[i]);
						}
						
					}
				);
			}

			function escribirPuntos(id, elm){

				return ajaxget( "becario.php?func=puntos&id="+id,
					function(xhttp){
						
						var dataJSON = JSON.parse(xhttp.responseText);
						console.log(xhttp.responseText);
						if(dataJSON.length > 0){
							elm.innerHTML = dataJSON.Puntos;
						}else{
							elm.innerHTML = "error";
						}
						
					}
				);
			}



			function irArchivo(id){

				window.location.href="";
			}

			function appendResult(datos){

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
				nodo.onclick = function(){
					var newWindow = window.open("./vista.php?id="+datos.Id, '_blank');
  					newWindow.focus();
				}
				nodoTexto = document.createElement("span");   
				nodoTexto.className="titlecomment documento_tipo_"+datos.IdTipo;
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

			function anadirBotonesNavegacion(tipo, funcion, paginaActual){

				var botonesDiv = document.createElement("div");

				var botonSpan;

				botonesDiv.id = "botonesNavegacion";
				if(tipo == "atras" || tipo == "ambos"){
					botonSpan = document.createElement("span");
					botonSpan.id="boton_izquierda";
					if(funcion == "buscarPorTexto"){
						console.log("CALLBACK");
						botonSpan.onclick = function(){ buscarPorTexto(textoBusqueda, paginaActual-1); console.log("Click");};
					}
					if(funcion == "cargarResultados"){
						botonSpan.onclick = function(){ cargarResultados(paginaActual-1); console.log("Click");};
					}
					botonSpan.appendChild(document.createTextNode(String.fromCharCode(8592)+"Anterior"));
					botonesDiv.appendChild(botonSpan);
				}

				if(tipo == "delante" || tipo == "ambos"){
					botonSpan = document.createElement("span");
					botonSpan.id="boton_derecha";
					if(funcion == "buscarPorTexto"){
						botonSpan.onclick = function(){ buscarPorTexto(textoBusqueda, paginaActual+1); console.log("Click");};
					}
					if(funcion == "cargarResultados"){
						botonSpan.onclick = function(){ cargarResultados(paginaActual+1); console.log("Click");};
					}
					botonSpan.appendChild(document.createTextNode("Siguiente"+String.fromCharCode(8594)));
					botonesDiv.appendChild(botonSpan);
				}
				document.getElementById("canvas").appendChild(botonesDiv);


			}
		
			function cargarResultados(pagina){
				if(pagina == undefined || pagina == ""){ pagina = 0; }

				var asignatura = document.getElementById("asignatura").value;
				var grado = document.getElementById("grado").value;
				var curso = document.getElementById("curso").value;
				console.log(asignatura);
				ajaxget( "becario.php?func=filtrar_apuntes&asignatura="+asignatura+"&curso="+curso+"&grado="+grado+"&pagina="+pagina,
					function(xhttp){
						
						var dataJSON = JSON.parse(xhttp.responseText);
						console.log(xhttp.responseText);
						document.getElementById("canvas").innerHTML = "";
						for(var i = 0; i<dataJSON.length;i++){
							console.log(dataJSON[i].IdTipo);
							appendResult(dataJSON[i]);
						}
						console.log("Mas de 10"+dataJSON.length);

						if(pagina == 0 && dataJSON.next == "true"){
							anadirBotonesNavegacion("delante", "cargarResultados", pagina);
						}
						if(pagina > 0 ){
							if(dataJSON.next == "true"){
								anadirBotonesNavegacion("ambos", "cargarResultados", pagina);
							}else{
								anadirBotonesNavegacion("atras", "cargarResultados", pagina);

							}
						}
					}
				);
			}


		</script>
	</head>
	<body>
		<div id="mensaje_error">
		</div>


		<div id="header">
			<div id="header_left">
				<table border="0" cellspacing="0" cellpadding="0">
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
						<select id="asignatura"  style="max-width:200px;">
							<option value="ALL">Todas</option>
						</select>
					</td></tr>
					<tr><td><div id="header_filtrar" class="puntero">Filtrar</div></td><td></td></tr>
				</table>
			</div>
			<div id="header_middle">
				<div id="header_searchbox">
					<table border="0">
					<tr><td><input type="text" value="Buscar..." id="header_search_text" /></td>
					<td><input type="button" id="header_search" value="Buscar"/></td>
					</tr>
					<tr>
						<td class="pequeno">
						<label><input type="checkbox" id="header_search_check_apuntes" value="1" checked>Apuntes</label>
						<label><input type="checkbox" id="header_search_check_examenes" checked>Examenes</label>
						</td>
					</tr>
					</table>
				</div>
			</div>
			<div id="header_right">
				<div id="header_nombre" class="info">
					<div class="cell username">Hola <?php echo $userInfo->Nombre." ".$userInfo->Apellido1; ?></div>
					<div id="header_closesesion" class="cell closesesion puntero">Salir</div>
				</div>
				<div class="info">
					<div id="header_subir" class="cell textright puntero">Subir archivo</div>
				</div>
				<div class="info">
					<div class="cell textright colorgray">Puntos</div>
					<div class="cell colorgray" id="puntos">69</div>
				</div>
				
			</div>
		</div>
		<div id="canvas">
		</div>
	</body>
</html>