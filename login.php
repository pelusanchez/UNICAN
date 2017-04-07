<?php
require_once("DB.php");
require_once("func.php");
require_once("session.php");

if(isset($_GET["unload"]) &&  $_GET["unload"] == "true"){

	logout();

}

if(isset($_POST["u"]) && isset($_POST["p"])){
	echo login($_POST["u"], $_POST["p"]);
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
			#login {
				position:absolute;
				top:200px;
				left:300px;
				right:300px;
				height:auto;
				padding:50px 20px 50px 20px;
				background:#FFFFFF;
				overflow-y:auto;
				overflow-x:hidden;
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
		var login = function(u, p){
			document.getElementById("entrar").value ="Entrando...";
			ajaxpost( "login.php",  "u="+u+"&p="+md5(p),
				function(xhttp){
					
					if(xhttp.responseText == "1"){
						document.getElementById("entrar").value ="OK";
						window.location.href="index.php";
					}else{
						console.log(xhttp.responseText);
						document.getElementById("entrar").value ="Entrar";
						document.getElementById("info").innerHTML="Datos err&oacute;neos";
						document.getElementById("info").style.color="#FF0000";
					}
					solicitudEnviada = false;
				}
			);

		}
		window.onload = function(){
			document.getElementById("form_login").addEventListener("submit", function(e){
					e.preventDefault();
					if(!solicitudEnviada){
						solicitudEnviada = true;
						login(document.getElementById("user").value,document.getElementById("pass").value);
					}
				}
			);
		}
		</script>
		<script languaje="JavaScript" src="md5.js"></script>
	</head>
	<body>
		<div id="login">
		<div id="saludo">Bienvenido a Apunter</div>
		<form id="form_login" method="get">
		<table border="0">
			<tr><td></td><td><span id="info"></span></td></tr>
			<tr><td>Usuario:</td><td><input type="text" id="user"/></td></tr>
			<tr><td>Contrase&ntilde;a:</td><td><input type="password" id="pass"/></td></tr>
			<tr><td></td><td><input type="submit" id="entrar" value="Entrar"/></td></tr>
		</table>
		</form>
		</div>
	</body>
</html>
<?php
}
?>