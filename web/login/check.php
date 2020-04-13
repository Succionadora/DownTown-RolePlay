<?php 
	require("auxiliar.php");
	require_once 'captcha/securimage.php';
	$IDS = $_POST["IDS"];
	// Code Validation
		$image = new Securimage();
		if ($image->check($_POST['captcha_code']) != true) {
		 if ((comprobarSesionCliente()!=true)&&(comprobarTokenIG($_GET["uID"], $_GET["token1"], $_GET["token2"])!=true)) {
			 header('Location: /index.php?error=4&IDS='.$IDS);
			 exit();
		 }
		}
	if (isset($_POST["usuario_ig"])&&isset($_POST["clave_ig"])&&$_POST["usuario_ig"]!=""&&$_POST["clave_ig"]!="") {
		// El usuario ha solicitado identificación vía IG
		$usuario = $_POST["usuario_ig"];
		$clave = $_POST["clave_ig"];
		if (comprobarDatosIG($usuario, $clave)) {
			// Identificación corecta, solicitamos nuevo token de sesión
			$uIDIG = obteneruIDIGFromUsuario($usuario);
			$regID = obtenerRegIDFromuIDIG($uIDIG);
			if ($regID) {
				$uIDForo = obteneruIDsFromRegID($regID, 2);
				$token = solicitarNuevaSesion($regID, obtenerDireccionIP());
				session_set_cookie_params(43200, '/', 'login.dt-mta.com', true, true);
				session_start();
				$_SESSION["token"] = $token;
				$_SESSION["ip"] = obtenerDireccionIP();
				$_SESSION["regID"] = $regID;
				$_SESSION["uIDIG"] = $uIDIG;
				$_SESSION["uIDForo"] = $uIDForo;
				$_SESSION["tipoLogin"] = 1; // 1 es IG, 2 es foro
				/*
					Inicio de sesión llevado a cabo con éxito!!!
					Comprobamos el ID del servicio solicitado y según el ID, le derivamos a donde corresponda.
					ID 1 = Foro
					ID 2 = CAU
				*/
				if ($IDS=="1") {
					echo 'Servicio no operativo.';
				} elseif ($IDS=="2") {
					$usuarioCAU = $usuario."-".$uIDIG;
					if (actualizarTokenEnCAU($usuarioCAU, $token)==true) {
						header("Location: https://cau.dt-mta.com/login.php?username=$usuarioCAU&password=$token");
					}
				} else {
					echo 'Servicio inválido.';
				}
			} else {
				header('Location: /index.php?error=3&IDS='.$IDS);
				// No tiene una cuenta de foro vinculada.
			}
		} else {
			header('Location: /index.php?error=1&IDS='.$IDS);
			// Credenciales incorrectas
		}
	} elseif (isset($_POST["usuario_foro"])&&isset($_POST["clave_foro"])&&$_POST["usuario_foro"]!=""&&$_POST["clave_foro"]!="") {
		// El usuario ha solicitado identificación vía Foro
		$usuario = $_POST["usuario_foro"];
		$clave = $_POST["clave_foro"];
		if (comprobarDatosForo($usuario, $clave)) {
			// Identificación corecta, solicitamos nuevo token de sesión
			$uIDForo = obteneruIDForoFromUsuario($usuario);
			$regID = obtenerRegIDFromuIDForo($uIDForo);
			if ($regID) {
				$uIDIG = obteneruIDsFromRegID($regID, 1);
				$token = solicitarNuevaSesion($regID, obtenerDireccionIP());
				session_set_cookie_params(43200, '/', 'login.dt-mta.com', true, true);
				session_start();
				$_SESSION["token"] = $token;
				$_SESSION["ip"] = obtenerDireccionIP();
				$_SESSION["regID"] = $regID;
				$_SESSION["uIDIG"] = $uIDIG;
				$_SESSION["uIDForo"] = $uIDForo;
				$_SESSION["tipoLogin"] = 2; // 1 es IG, 2 es foro
				/*
					Inicio de sesión llevado a cabo con éxito!!!
					Comprobamos el ID del servicio solicitado y según el ID, le derivamos a donde corresponda.
					ID 1 = Foro
					ID 2 = CAU
				*/
				if ($IDS=="1") {
					echo 'Servicio no operativo.';
				} elseif ($IDS=="2") {
					$usuario_ig = obtenerUsuarioFromuIDIG($uIDIG);
					$usuarioCAU = $usuario_ig."-".$uIDIG;	
					if (actualizarTokenEnCAU($usuarioCAU, $token)==true) {
						header("Location: https://cau.dt-mta.com/login.php?username=$usuarioCAU&password=$token");
					}
				} else {
					echo 'Servicio inválido.';
				}
			} else {
				header('Location: /index.php?error=3&IDS='.$IDS);
				// No tiene una cuenta de foro vinculada.
			}
		} else {
			header('Location: /index.php?error=1&IDS='.$IDS);
			// Credenciales incorrectas
		}
	} elseif (comprobarSesionCliente()==true) {
		// AUTOLOGIN
		$IDS = $_GET["IDS"]; // Si va por autologin, el servicio nos llega por GET no por POST
		if ($_SESSION["tipoLogin"] == 1) {
			// Login vía IG
			// Identificación corecta, reutilizamos token de sesión
			$uIDIG = $_SESSION["uIDIG"];
			$usuario = obtenerUsuarioFromuIDIG($uIDIG);
			$regID = obtenerRegIDFromuIDIG($uIDIG);
			if ($regID) {
				$token = $_SESSION["token"];
				$uIDForo = $_SESSION["uIDForo"];
				/*
					Inicio de sesión llevado a cabo con éxito!!!
					Comprobamos el ID del servicio solicitado y según el ID, le derivamos a donde corresponda.
					ID 1 = Foro
					ID 2 = CAU
				*/
				if ($IDS=="1") {
					echo 'Servicio no operativo.';
				} elseif ($IDS=="2") {
					$usuarioCAU = $usuario."-".$uIDIG;
					if (actualizarTokenEnCAU($usuarioCAU, $token)==true) {
						header("Location: https://cau.dt-mta.com/login.php?username=$usuarioCAU&password=$token");
					}
				} else {
					echo 'Servicio inválido.';
				}
			}
		} elseif ($_SESSION["tipoLogin"] == 2) {
			// Login vía foro
			// Identificación corecta, solicitamos nuevo token de sesión
			$uIDForo = $_SESSION["uIDForo"];
			$regID = obtenerRegIDFromuIDForo($uIDForo);
			if ($regID) {
				$token = $_SESSION["token"];
				$uIDIG =  $_SESSION["uIDIG"];
				/*
					Inicio de sesión llevado a cabo con éxito!!!
					Comprobamos el ID del servicio solicitado y según el ID, le derivamos a donde corresponda.
					ID 1 = Foro
					ID 2 = CAU
				*/
				if ($IDS=="1") {
					echo 'Servicio no operativo.';
				} elseif ($IDS=="2") {
					$usuario_ig = obtenerUsuarioFromuIDIG($uIDIG);
					$usuarioCAU = $usuario_ig."-".$uIDIG;	
					if (actualizarTokenEnCAU($usuarioCAU, $token)==true) {
						header("Location: https://cau.dt-mta.com/login.php?username=$usuarioCAU&password=$token");
					}
				} else {
					echo 'Servicio inválido.';
				}
			}
		} else {
			header('Location: /logout.php?reauth=1&IDS='.$IDS);
		}
	} elseif (comprobarTokenIG($_GET["uID"], $_GET["token1"], $_GET["token2"])==true) {
		$IDS = $_GET["IDS"]; // Si va por autologin, el servicio nos llega por GET no por POST
		// Login OK via tokens IG.
			// Identificación corecta, reutilizamos token de sesión
			$uIDIG = $_GET["uID"];
			$usuario = obtenerUsuarioFromuIDIG($uIDIG);
			$regID = obtenerRegIDFromuIDIG($uIDIG);
			if ($regID) {						
				$token = solicitarNuevaSesion($regID, obtenerDireccionIP());
				$uIDForo = obteneruIDsFromRegID($regID, 2);
				session_set_cookie_params(43200, '/', 'login.dt-mta.com', true, true);
				session_start();
				$_SESSION["token"] = $token;
				$_SESSION["ip"] = obtenerDireccionIP();
				$_SESSION["regID"] = $regID;
				$_SESSION["uIDIG"] = $uIDIG;
				$_SESSION["uIDForo"] = $uIDForo;
				$_SESSION["tipoLogin"] = 1; // 1 es IG, 2 es foro
				$_SESSION["loginIG"] = true;
				/*
					Inicio de sesión llevado a cabo con éxito!!!
					Comprobamos el ID del servicio solicitado y según el ID, le derivamos a donde corresponda.
					ID 1 = Foro
					ID 2 = CAU
				*/
				if ($IDS=="1") {
					echo 'Servicio no operativo.';
				} elseif ($IDS=="2") {
					$usuarioCAU = $usuario."-".$uIDIG;
					if (actualizarTokenEnCAU($usuarioCAU, $token)==true) {
						header("Location: https://cau.dt-mta.com/login.php?username=$usuarioCAU&password=$token");
					}
				} else {
					echo 'Servicio inválido.';
				}
			} else {
				echo 'No tienes vinculada tu cuenta IG con tu cuenta de foro. Abre un navegador y visita foro.dt-mta.com.';
			}
	} else {
		header('Location: /index.php?error=2&IDS='.$IDS);
	}
?>