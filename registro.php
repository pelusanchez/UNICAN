<?php
require_once("DB.php");
require_once("utiles.php");
require_once("sesion.php");
require_once("captcha/captcha.php");

// Si se envía el formulario, lo registramos
if(isset($_POST["enviado"])){

	// Comprobamos el captcha
	if(comprobarCaptcha($_POST["captcha"])){
		$resultado = registro($_POST["name"], $_POST["apellido1"], $_POST["apellido2"], $_POST["nick"], $_POST["password"], $_POST["email"]);
		switch($resultado){
			case "1":
				echo "OK";
			break;
			case "2":
				echo "Hubo un error grave.";
			break;
			case "3":
				echo "Ya existe ese nick.";
			break;
			case "4":
				echo "Ya existe un usuario con el mismo email.";
			break;
			case "5":
				echo "Hubo un error grave.";
			break;
		}
	}else{
		// Con ésto nos aseguramos que no sea viable el envío de pruebas masivas de captcha
		sleep(2);
		echo "Captcha incorrecto!";
	}
}else{
?>
<html>
	<head>
		<title>Registro | Apunter</title>
		<style type="text/css">
			html, body {
				height:100%;
			
			}
			
			body {
				background:#a7bbc9;
				font-family:Arial;
				margin: 0 auto;
				font-size:16px;
				display:table;
			}
			
			#contenedor {
				height:100%;
				display:table-cell;
				vertical-align: middle;
			}
			
			#login {
				min-width:100px;
				height:auto;
				margin-top:-100px;
				padding:50px 20px 50px 20px;
				background:#FFFFFF;
				overflow:hidden;
				border-radius: 10px;
			}
			
			#login #saludo{
				text-align:center;
				margin-left: auto;
    			margin-right: auto;
    			font-size:20px;
			}
			
			#login table{
				margin-left: auto;
    			margin-right: auto;
    			font-size:20px;
			}
			
			#login input{
				width:200px;
				border:1px solid #CCCCCC;
    			font-size:20px;
			}
			
			#login #entrar{
				cursor:pointer;
			}

			a {
				color:#0000EE;
				text-decoration:none;
			}

			#login #info{
				display: inline-block;
				width:200px;
				word-wrap: break-word;
			}

		</style>
		<script languaje="JavaScript">
		var solicitudEnviada = false;
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

		var withError = false;
		var register = function(){
			var name = document.getElementById("name");
			var ap1 = document.getElementById("ap1");
			var ap2 = document.getElementById("ap2");
			var nick = document.getElementById("nick");
			var pass1 = document.getElementById("passwd");
			var pass2 = document.getElementById("passwd_repeat");
			var email = document.getElementById("email");
			var captchaText = document.getElementById("captchaText");
			if(withError){
				pass1.style.borderColor="#CCCCCC";
				pass2.style.borderColor="#CCCCCC";
				name.style.borderColor="#CCCCCC";
				ap1.style.borderColor="#CCCCCC";
				nick.style.borderColor="#CCCCCC";
				email.style.borderColor="#CCCCCC";
				withError = false;
			}
			//Check data
			if(pass1.value != pass2.value || pass1.value == "" || pass1.value === null){ // If passwords missmatch!
				pass1.style.borderColor="#FF0000";
				pass2.style.borderColor="#FF0000";
				withError=true;
			}

			if(pass1.value.length <5){
				document.getElementById("info").innerHTML="Contrase&ntilde;a muy corta... Por favor, utilice al menos 5 caracteres.";
				document.getElementById("info").style.color="#FF0000";
				pass1.style.borderColor="#FF0000";
				pass2.style.borderColor="#FF0000";
				withError=true;
			}
			if(name.value == "" || name.value == null){ // If name is empty!
				name.style.borderColor="#FF0000";
				withError=true;
			}

			if(ap1.value == "" || ap1.value == null){ // If first name is empty!
				ap1.style.borderColor="#FF0000";
				withError=true;
			}

			if(nick.value == "" || nick.value == null){ // If nick name is empty!
				nick.style.borderColor="#FF0000";
				withError=true;
			}

			if(email.value == "" || email.value == null){ // If email is empty!
				email.style.borderColor="#FF0000";
				withError=true;
			}else{ // Check if email is LIKE %
				if(email.value.indexOf("\@")<1){ //Greater than 0 because there are not sense in first position!
					email.style.borderColor="#FF0000";
					withError=true;
				}

			}

			if(captchaText.value== "" || captchaText.value == null){ // Si el captcha está vacío
				withError = true;
				captchaText.style.borderColor = "#FF0000";
			}
			if(!withError){
				document.getElementById("entrar").value ="Registrandose...";
				//"u="+u+"&p="+md5(p)
				var postHeader = "enviado=1";
				postHeader += "&name="+name.value;
				postHeader += "&apellido1="+ap1.value;
				postHeader += "&apellido2="+ap2.value;
				postHeader += "&nick="+nick.value;
				postHeader += "&password="+md5(pass1.value);
				postHeader += "&email="+email.value;
				postHeader += "&captcha="+captchaText.value;
				ajaxpost( "registro.php", postHeader,
					function(xhttp){
						
						if(xhttp.responseText.trim() == "OK"){
							document.getElementById("entrar").value ="OK";
							window.location.href="entrar.php?registro=ok";
						}else{
							console.log(xhttp.responseText);
							document.getElementById("entrar").value ="Registrarse";
							document.getElementById("info").innerHTML="Error:"+xhttp.responseText;
							document.getElementById("info").style.color="#FF0000";
							document.getElementById("captcha").src="captcha.php?token="+Date.now();
						}
						solicitudEnviada = false;
					}
				);
			}else{
				solicitudEnviada = false;
			}

		}
		window.onload = function(){
			document.getElementById("form_register").addEventListener("submit", function(e){
					e.preventDefault();
					if(!solicitudEnviada){
						solicitudEnviada = true;
						register();
					}
				}
			);
		}
		</script>
		<script languaje="JavaScript" src="md5.js"></script>
	</head>
	<body>
		<div id="contenedor">
			<div id="login">
			<div id="saludo">Registro en Apunter</div>
			<form id="form_register" method="get">
			<table border="0">
				<tr><td></td><td><span id="info"></span></td></tr>
				<tr><td>Nombre:</td><td><input type="text" id="name"/></td></tr>
				<tr><td>Primer apellido:</td><td><input type="text" id="ap1"/></td></tr>
				<tr><td>Segundo apellido:</td><td><input type="text" id="ap2"/></td></tr>
				<tr><td>Nick:</td><td><input type="text" id="nick"/></td></tr>
				<tr><td>Contrase&ntilde;a:</td><td><input type="password" id="passwd"/></td></tr>
				<tr><td>Repetir contrase&ntilde;a:</td><td><input type="password" id="passwd_repeat"/></td></tr>
				<tr><td>Correo electr&oacute;nico:</td><td><input type="text" id="email"/></td></tr>
				<tr><td><img id="captcha" src="captcha.php" alt="error"></td><td><input type="text" id="captchaText"/></td></tr>
				<tr><td></td><td><input type="submit" id="entrar" value="Registrarse"/></td></tr>
			</table>
			</form>
			</div>
		</div>
	</body>
</html>
<?php
}
?>