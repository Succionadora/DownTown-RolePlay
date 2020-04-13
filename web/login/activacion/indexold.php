<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>DownTown RolePlay - Activación de cuenta de foro</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">


</head>
<body id="main_body" >
	<img id="top" src="top.png" alt="">
	<div id="form_container">
		<h1><a>DownTown RolePlay - Activación de cuenta de foro</a></h1>
		<form id="" class="appnitro"  method="post" action="check.php">
			<div class="form_description">
			<center><img src="https://foro.dt-mta.com/Themes/Reseller/images/logo.png"></center>
			<h2>Activación y vinculación de cuentas de foro e IG</h2>
			<?php
			$textoGeneral = base64_decode("CQkJCgkJCQk8cD5EZXNkZSBhcXXDrSBwb2Ryw6FzIGFjdGl2YXIgdHUgY3VlbnRhIGVuIGZvcm8uIAo8YnI+PGJyPgpBc8OtLCB0dSBjdWVudGEgZGUgZm9ybyBxdWVkYXLDoSB2aW5jdWxhZGEgYSB0dSBjdWVudGEgSUcgKEluLUdhbWUpIHksIHBvciBlamVtcGxvLCBsb3MgcGVybWlzb3MgZGUgZmFjY2lvbmVzIHNlIHRlIGFzaWduYXLDoW4gYXV0b23DoXRpY2FtZW50ZS4KPGJyPjxicj4KUGFyYSBjb250aW51YXIsIGludHJvZHVjZSB0dSB1c3VhcmlvIGRlIGZvcm8geSB0dSB1c3VhcmlvIElHICh1c3VhcmlvLCBubyBwZXJzb25hamUpIGp1bnRvIGNvbiBsYXMgY2xhdmVzIGRlIGNhZGEgdW5vLgo8YnI+PGJyPgpFbiBjYXNvIGRlIHF1ZSBubyB0ZW5nYXMgdW5hIGN1ZW50YSBjcmVhZGEgSUcsIGVzIGRlY2lyLCBkZW50cm8gZGVsIHNlcnZpZG9yLCBkZWJlcsOhcyBjcmVhcmxhIHBhcmEgcG9kZXIgYWN0aXZhciB0dSBjdWVudGEgZGUgZm9yby4KPGJyPjxicj4KUHVlZGVzIGNvbmVjdGFydGUgYWwgc2Vydmlkb3IgYWJyaWVuZG8gdHUgTVRBIHkgY29uZWN0w6FuZG90ZSBhIGxhIElQOiBtdGFzYTovLzEwNC4yMjMuOTMuMTM4OjIyMDAzCjwvcD4=");
			if (isset($_GET["error"])&&$_GET["error"]==1) {
				echo "	
					<h2 style='color:#18d625'>Tu cuenta de foro se ha activado correctamente.</h2>
					<br>
									<p>¡Gracias por activar tu cuenta de foro! 
					<br><br>
					A partir de ahora, podrás iniciar sesión en diversos servicios de la comunidad de DownTown utilizando tus credenciales IG o tus credenciales del foro.
					<br><br>
					Si tienes alguna duda, acude al CAU (Centro de Atención al Usuario) haciendo <a href='https://cau.dt-mta.com'> clic aquí </a>
					</p>";
				
			} else {
				if (isset($_GET["error"])&&$_GET["error"]==2) {
					echo "<h2 style='color:#d63518'>Sólo se permite activar 1 cuenta de foro por cada cuenta IG</h2>";
				} elseif (isset($_GET["error"])&&$_GET["error"]==3) {
					echo "<h2 style='color:#d63518'>Las credenciales son incorrectas. Revísalas y prueba de nuevo.</h2>";
				} elseif (isset($_GET["error"])&&$_GET["error"]==4) {
					echo "<h2 style='color:#d63518'>No has introducido todas las credenciales.</h2>";
				}
				echo $textoGeneral;
				}
			?>
		</div>						
			<ul>
				<li id="li_1" >
					<label class="description" for="element_1">Introduce tu usuario de foro </label>
					<div>
						<input id="usuario_foro" name="usuario_foro" class="element text medium" type="text" maxlength="255" value=""/> 
					</div> 
				</li>		
				<li id="li_2" >
					<label class="description" for="element_2">Introduce tu clave de foro </label>
					<div>
						<input id="clave_foro" name="clave_foro" class="element text medium" type="password" maxlength="255" value=""/> 
					</div> 
				</li>
				<li id="li_3" >
					<label class="description" for="element_3">Introduce tu usuario IG </label>
					<div>
						<input id="usuario_ig" name="usuario_ig" class="element text medium" type="text" maxlength="255" value=""/> 
					</div> 
				</li>		
				<li id="li_4" >
					<label class="description" for="element_4">Introduce tu clave IG </label>
					<div>
						<input id="clave_ig" name="clave_ig" class="element text medium" type="password" maxlength="255" value=""/> 
					</div> 
				</li>
				<li class="buttons">
					<input id="saveForm" class="button_text" type="submit" name="submit" value="Enviar" />
				</li>
			</ul>
		</form>	
		<div id="footer">
			DownTown RolePlay 2019 - Todos los derechos reservados.
		</div>
	</div>
	<img id="bottom" src="bottom.png" alt="">
	</body>
</html>