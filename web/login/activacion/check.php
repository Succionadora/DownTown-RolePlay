<?php
/*require ("../auxiliar.php");
	if ($_POST["usuario_ig"]!=""||$_POST["usuario_foro"]!=""||$_POST["clave_foro"]!=""||$_POST["clave_ig"]!="") {
		$usuario_foro = $_POST["usuario_foro"];
		$usuario_ig = $_POST["usuario_ig"];
		$clave_foro = $_POST["clave_foro"];
		$clave_ig = $_POST["clave_ig"];
		if (comprobarDatosIG($usuario_ig, $clave_ig) && comprobarDatosForo($usuario_foro, $clave_foro)) {
			// Todas las credenciales están bien, solicitamos entonces activación.
			$uIDIG = obteneruIDIGFromUsuario($usuario_ig);
			$uIDForo = obteneruIDForoFromUsuario($usuario_foro);
			if (vincularUsuariosIGYForo($uIDIG, $uIDForo)) {
				//Vinculacion OK
				header('Location: index.php?error=1');
			} else {
				//Se ha superado el limite de 1 cuenta de foro cada cuenta IG
				header('Location: index.php?error=2');
			}			
		} else {
			header('Location: index.php?error=3');
		}	
	} else {
		header('Location: index.php?error=4');
	}*/
?> 