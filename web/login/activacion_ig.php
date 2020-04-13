<?php
/*

	Archivo activacion_ig.php que permite activación y vinculación de forma IG.
	Copyright 2019. Todos los derechos reservados.
	Versión: 1

*/
	require ("auxiliar.php");
	if ($_GET["usuario_foro"]!=""||$_GET["clave_foro"]!=""||$_GET["uIDIG"]!=""||$_GET["token"]!="") {
		$usuario_foro = $_GET["usuario_foro"];
		$clave_foro = $_GET["clave_foro"];
		$uIDIG = $_GET["uIDIG"];
		$token = $_GET["token"];
		$token2 = "yo5345azxd3ey7unvbapolki1q2wAu7y28jXv790ReqwAZs2Q9iusacVX9o";
		if ($token === $token2) {
			if (comprobarDatosForo($usuario_foro, $clave_foro)) {
				// Todas las credenciales están bien, solicitamos entonces activación.
				$uIDForo = obteneruIDForoFromUsuario($usuario_foro);
				if (vincularUsuariosIGYForo($uIDIG, $uIDForo)) {
					//Vinculacion OK
					echo("0");
				} else {
					//Se ha superado el limite de 1 cuenta de foro cada cuenta IG
					echo("1");
				}			
			} else {
				echo("2");
			}
		}
	} else {
		echo("3");
	}
?>