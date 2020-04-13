<?php
/*

	Archivo auxiliar.php que permite la interconexión de todos los servicios DownTown
	Copyright 2019. Todos los derechos reservados.
	Versión: 1.2

*/

// Function to get the client ip address
function obtenerDireccionIP() {
    $ipaddress = '';
    if ($_SERVER['HTTP_CLIENT_IP'])
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if($_SERVER['HTTP_X_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if($_SERVER['HTTP_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if($_SERVER['HTTP_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if($_SERVER['REMOTE_ADDR'])
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
 
    return $ipaddress;
}

function obtenerEnlaceADBIG() {
	$enlace = mysqli_connect("HOST_MYSQL", "USER_DB_SERVER", "PASS_DB_SERVER", "DBNAME_SERVER");
	if (mysqli_connect_errno()) {
		echo 'Se ha producido un error grave, código 1-IG';
		exit();
	} else {
		return $enlace;
	}
}

function obtenerEnlaceADBForo() {
	$enlace = mysqli_connect("HOST_MYSQL", "USER_DB_FORO", "PASS_DB_FORO", "DBNAME_FORO");
	if (mysqli_connect_errno()) {
		echo 'Se ha producido un error grave, código 1-Foro';
		exit();
	} else {
		return $enlace;
	}
}

function obtenerEnlaceADBLogin() {
	$enlace = mysqli_connect("HOST_MYSQL", "USER_DB_PANEL_LOGIN_WEB", "PASS_DB_PANEL_LOGIN_WEB", "DBNAME_FORO_PANEL_LOGIN_WEB");
	if (mysqli_connect_errno()) {
		echo 'Se ha producido un error grave, código 1-Login';
		exit();
	} else {
		return $enlace;
	}
}

function obtenerEnlaceADBCAU() {
	$enlace = mysqli_connect("HOST_MYSQL", "USER_DB_CAU", "PASS_DB_CAU", "DBNAME_CAU");
	if (mysqli_connect_errno()) {
		echo 'Se ha producido un error grave, código 1-CAU';
		exit();
	} else {
		return $enlace;
	}
}

function comprobarDatosIG($usuario, $clave) {
	if (isset($usuario)&&(isset($clave))) {
		// Establecemos conexión con la DB correspondiente
		$enlace = obtenerEnlaceADBIG();
		if (isset($enlace)&&mysqli_set_charset($enlace, "utf8")) {
			// Limpiamos los parámetros que irán a mysql
			$usuario = mysqli_real_escape_string($enlace, $usuario);
			$sql = mysqli_query($enlace, "SELECT password, username, salt FROM wcf1_user WHERE username = '$usuario'");
				while ($row = mysqli_fetch_assoc($sql)) {
					$salt = $row["salt"];
					$c = sha1($clave);
					$c = $salt . $c;
					$c = sha1($c);
					$c = $salt . $c;
					$c = sha1($c);
					if ( $c==$row["password"] ) {		
						return true;
					}
				}
				return false;
		} else {
			exit();
		}
	}
}

/*
function comprobarDatosForo($usuario, $clave) {
	if (isset($usuario)&&(isset($clave))) {
		// Establecemos conexión con la DB correspondiente
		$enlace = obtenerEnlaceADBForo();
		if (isset($enlace)&&mysqli_set_charset($enlace, "utf8")) {
			// Limpiamos los parámetros que irán a mysql
			$usuario = mysqli_real_escape_string($enlace, $usuario);
			$sql = mysqli_query($enlace, "SELECT passwd FROM smf_members WHERE member_name = '$usuario'");
				while ($row = mysqli_fetch_assoc($sql)) {
					$clave_cifrada = sha1(strtolower($usuario) . $clave);
					if ( $clave_cifrada==$row["passwd"] ) {		
						return true;
					}
				}
				return false;
		} else {
			exit();
		}
	}
}
*/

function hash_verify_password($username, $password, $hash)
{
	if (!function_exists('password_verify'))
		require_once('/Subs-Password.php');

	return password_verify(strtolower($username) . $password, $hash);
}

function comprobarDatosForo($usuario, $clave) {
	if (isset($usuario)&&(isset($clave))) {
		// Establecemos conexión con la DB correspondiente
		$enlace = obtenerEnlaceADBForo();
		if (isset($enlace)&&mysqli_set_charset($enlace, "utf8")) {
			// Limpiamos los parámetros que irán a mysql
			$usuario = mysqli_real_escape_string($enlace, $usuario);
			$sql = mysqli_query($enlace, "SELECT passwd FROM smf_members WHERE member_name = '$usuario'");
				while ($row = mysqli_fetch_assoc($sql)) {
					if (strlen($clave_cifrada)== 40) {
						echo ("Es necesario una actualizacion sobre su cuenta de foro. Inicie sesion en https://foro.dt-mta.com primero.");
						exit();
					}
					$clave_cifrada = hash_verify_password($usuario, $clave, $row["passwd"]);
					if ( $clave_cifrada==true ) {		
						return true;
					}
				}
				return false;
		} else {
			exit();
		}
	}
}

function obteneruIDIGFromUsuario($usuario) {
		if (isset($usuario)) {
		// Establecemos conexión con la DB correspondiente
		$enlace = obtenerEnlaceADBIG();
		if (isset($enlace)&&mysqli_set_charset($enlace, "utf8")) {
			// Limpiamos los parámetros que serán utilizados en la conexión mysql.
			$usuario = mysqli_real_escape_string($enlace, $usuario);
			$sql = mysqli_query($enlace, "SELECT userID FROM wcf1_user WHERE username = '$usuario'");
				while ($row = mysqli_fetch_assoc($sql)) {
					return $row["userID"];
				}
				exit();
		} else {
			exit();
		}
	}
}

function obteneruIDForoFromUsuario($usuario) {
		if (isset($usuario)) {
		// Establecemos conexión con la DB correspondiente
		$enlace = obtenerEnlaceADBForo();
		if (isset($enlace)&&mysqli_set_charset($enlace, "utf8")) {
			// Limpiamos los parámetros que serán utilizados en la conexión mysql.
			$usuario = mysqli_real_escape_string($enlace, $usuario);
			$sql = mysqli_query($enlace, "SELECT id_member FROM smf_members WHERE member_name = '$usuario'");
				while ($row = mysqli_fetch_assoc($sql)) {
					return $row["id_member"];
				}
				exit();
		} else {
			exit();
		}
	}
}

function vincularUsuariosIGYForo($uIDIG, $uIDForo) {
	if (isset($uIDIG)&&(isset($uIDForo))) {
		// Establecemos conexión con la DB correspondiente
		$enlace = obtenerEnlaceADBLogin();
		if (isset($enlace)&&mysqli_set_charset($enlace, "utf8")) {
			// Limpiamos los parámetros
			$uIDIG = mysqli_real_escape_string($enlace, $uIDIG);
			$uIDForo = mysqli_real_escape_string($enlace, $uIDForo);
			$sql = mysqli_query($enlace, "SELECT registroID FROM usuarios WHERE (userIDIG = '$uIDIG' OR userIDForo = '$uIDForo') AND estado = 1;");
				while ($row = mysqli_fetch_assoc($sql)) {
					return false; // Uno de los dos usuarios ya ha sido vinculado.
				}
				$sql_in = mysqli_query($enlace, "INSERT INTO `usuarios` (`registroID`, `userIDIG`, `userIDForo`, `estado`) VALUES (NULL, '$uIDIG', '$uIDForo', '1');");
				if ($sql_in==true) {
					// Establecemos conexión con la DB correspondiente
					$enlace2 = obtenerEnlaceADBForo();
					$sql_in2 = mysqli_query($enlace2, "UPDATE `smf_members` SET `id_group` = '6' WHERE `id_member` = '$uIDForo';"); // Se realiza la activación en el foro.
					if ($sql_in2==true) {
						return true;
					} else {
						return false;
					}
				} else {
					exit();
				}
		} else {
			exit();
		}
	}
}

function obtenerRegIDFromuIDIG($uID) {
		if (isset($uID)) {
		// Establecemos conexión con la DB correspondiente
		$enlace = obtenerEnlaceADBLogin();
		if (isset($enlace)&&mysqli_set_charset($enlace, "utf8")) {
			// Limpiamos los parámetros que serán utilizados en la conexión mysql.
			$uID = mysqli_real_escape_string($enlace, $uID);
			$sql = mysqli_query($enlace, "SELECT registroID FROM usuarios WHERE userIDIG = '$uID'");
				while ($row = mysqli_fetch_assoc($sql)) {
					return $row["registroID"];
				}
				return false;
		} else {
			exit();
		}
	}
}

function obtenerRegIDFromuIDForo($uID) {
		if (isset($uID)) {
		// Establecemos conexión con la DB correspondiente
		$enlace = obtenerEnlaceADBLogin();
		if (isset($enlace)&&mysqli_set_charset($enlace, "utf8")) {
			// Limpiamos los parámetros que serán utilizados en la conexión mysql.
			$uID = mysqli_real_escape_string($enlace, $uID);
			$sql = mysqli_query($enlace, "SELECT registroID FROM usuarios WHERE userIDForo = '$uID'");
				while ($row = mysqli_fetch_assoc($sql)) {
					return $row["registroID"];
				}
				return false;
		} else {
			exit();
		}
	}
}

function solicitarNuevaSesion($regID, $ip) {
	if (isset($regID)&&isset($ip)) {
		// Establecemos conexión con la DB correspondiente
		$enlace = obtenerEnlaceADBLogin();
		if (isset($enlace)&&mysqli_set_charset($enlace, "utf8")) {
			// Limpiamos los parámetros que serán utilizados en la conexión mysql.
			$regID = mysqli_real_escape_string($enlace, $regID);		
			$ip = mysqli_real_escape_string($enlace, $ip);
			$token = bin2hex(openssl_random_pseudo_bytes(32)); // Token aleatorio de 64 carácteres.
			// Tenemos que anular primero todas las sesiones anteriores.
			$sql_first = mysqli_query($enlace, "UPDATE `sesiones` SET `estado` = 0 WHERE `regID` = '$regID';");
			if ($sql_first==true) {
				$sql = mysqli_query($enlace, "INSERT INTO `sesiones` (`sesionID`, `regID`, `token`, `ip`, `time`, `estado`) VALUES (NULL, '$regID', '$token', '$ip', CURRENT_TIMESTAMP, '1');");
				if ($sql==true) {
					return $token;
				}
			}
		} else {
			exit();
		}
	}
}

function comprobarSesion($token, $ip) {
		if (isset($token)&&isset($ip)) {
		// Establecemos conexión con la DB correspondiente
		$enlace = obtenerEnlaceADBLogin();
		if (isset($enlace)&&mysqli_set_charset($enlace, "utf8")) {
			// Limpiamos los parámetros que serán utilizados en la conexión mysql.
			$token = mysqli_real_escape_string($enlace, $token);
			$ip = mysqli_real_escape_string($enlace, $ip);
			$sql = mysqli_query($enlace, "SELECT estado, ip FROM sesiones WHERE token = '$token'");
				while ($row = mysqli_fetch_assoc($sql)) {
					if ($row["estado"]==1&&$row["ip"]==$ip) {
						// Si hemos llegado aquí es que la sesión es VALIDA
						return true;
					}
				}
				// Próxima revisión: abrir incidente en caso de que un token no sea válido bajo ciertas circunstancias.
				return false;
		} else {
			exit();
		}
	}
}

function comprobarSesionCliente() {
	session_set_cookie_params(43200, '/', 'login.dt-mta.com', true, true);
	session_start();
	if (session_status()==2) {
		$token = $_SESSION["token"];
		$ip = $_SESSION["ip"];
		if (comprobarSesion($token, $ip)==true) {
			return true;
		}
	}
}

function destruirSesionCliente() {
	session_set_cookie_params(43200, '/', 'login.dt-mta.com', true, true);
	session_start();
	if (session_status()==2) {
		$token = $_SESSION["token"];
		if (isset($token)) {
			//TODO: crear funcion para anular token
		}
		session_start();
		$_SESSION = array();
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			);
		}
		session_destroy();
	} else {
		echo 'No hay sesion';
		exit();
	}
}

function obtenerUsuarioFromuIDIG($uIDIG) {
		if (isset($uIDIG)) {
		// Establecemos conexión con la DB correspondiente
		$enlace = obtenerEnlaceADBIG();
		if (isset($enlace)&&mysqli_set_charset($enlace, "utf8")) {
			// Limpiamos los parámetros que serán utilizados en la conexión mysql.
			$uIDIG = mysqli_real_escape_string($enlace, $uIDIG);
			$sql = mysqli_query($enlace, "SELECT username FROM wcf1_user WHERE userID = '$uIDIG'");
				while ($row = mysqli_fetch_assoc($sql)) {
					return $row["username"];
				}
				exit();
		} else {
			exit();
		}
	}
}

function obtenerUsuarioFromuIDForo($uIDForo) {
		if (isset($uIDForo)) {
		// Establecemos conexión con la DB correspondiente
		$enlace = obtenerEnlaceADBForo();
		if (isset($enlace)&&mysqli_set_charset($enlace, "utf8")) {
			// Limpiamos los parámetros que serán utilizados en la conexión mysql.
			$uIDForo = mysqli_real_escape_string($enlace, $uIDForo);
			$sql = mysqli_query($enlace, "SELECT member_name FROM smf_members WHERE id_member = '$uIDForo'");
				while ($row = mysqli_fetch_assoc($sql)) {
					return $row["member_name"];
				}
				exit();
		} else {
			exit();
		}
	}
}

function obteneruIDsFromRegID($regID, $tipo) {
	if (isset($regID)) {
		// Establecemos conexión con la DB correspondiente
		$enlace = obtenerEnlaceADBLogin();
		if (isset($enlace)&&mysqli_set_charset($enlace, "utf8")) {
			// Limpiamos los parámetros que serán utilizados en la conexión mysql.
			$regID = mysqli_real_escape_string($enlace, $regID);
			$sql = mysqli_query($enlace, "SELECT userIDForo, userIDIG FROM usuarios WHERE registroID = '$regID'");
				while ($row = mysqli_fetch_assoc($sql)) {
					if ($tipo==1) {
						return $row["userIDIG"];
					} elseif ($tipo==2) {
						return $row["userIDForo"];
					}
				}
				return false;
		} else {
			exit();
		}
	}
}


function actualizarTokenEnCAU($usuario, $token) {
	if (isset($usuario)&&isset($token)) {
		// Establecemos conexión con la DB correspondiente
		$enlace = obtenerEnlaceADBCAU();
		if (isset($enlace)&&mysqli_set_charset($enlace, "utf8")) {
			// Limpiamos los parámetros que serán utilizados en la conexión mysql.
			$usuario = mysqli_real_escape_string($enlace, $usuario);
			$token = mysqli_real_escape_string($enlace, $token);
			$token_sec = md5($token);
			$existe = false;
			// Comprobamos primero si tiene usuario en CAU.
			// Si lo tiene, actualizamos pass con el token y damos paso.
			// Si no lo tiene, lo creamos con dicho token y damos paso igualmente.
			$sql_e = mysqli_query($enlace, "SELECT `id` FROM `cau_user_table` WHERE `username` = '$usuario'");
			while ($row = mysqli_fetch_assoc($sql_e)) {
				$existe = true;
			}
			if ($existe==true) {
				$sql = mysqli_query($enlace, "UPDATE `cau_user_table` SET `password` = '$token_sec' WHERE `username` = '$usuario';");
				if ($sql) {
					return true;
				}
			} else {
				$cookie_sec = bin2hex(openssl_random_pseudo_bytes(32)); // Token aleatorio de 64 caracteres.
				$tiempo = time();
				$sql = mysqli_query($enlace, "INSERT INTO `cau_user_table` (`id`, `username`, `realname`, `email`, `password`, `enabled`, `protected`, `access_level`, `login_count`, `lost_password_request_count`, `failed_login_count`, `cookie_string`, `last_visit`, `date_created`) VALUES (NULL, '$usuario', '', 'cambiame@$usuario.net', '$token_sec', '1', '1', '25', '0', '0', '0', '$cookie_sec', '$tiempo', '$tiempo');");
				if ($sql) {
					return true;
				}
			}
		} else {
			exit();
		}
	}
}

function comprobarTokenIG($uID, $token1, $token2) {
		if (isset($uID)&&isset($token1)&&isset($token2)) {
		// Establecemos conexión con la DB correspondiente
		$enlace = obtenerEnlaceADBIG();
		if (isset($enlace)&&mysqli_set_charset($enlace, "utf8")) {
			// Limpiamos los parámetros que serán utilizados en la conexión mysql.
			$uID = mysqli_real_escape_string($enlace, $uID);
			$token1 = mysqli_real_escape_string($enlace, $token1);
			$token2 = mysqli_real_escape_string($enlace, $token2);
			$sql = mysqli_query($enlace, "SELECT password, salt FROM wcf1_user WHERE userID = '$uID'");
				while ($row = mysqli_fetch_assoc($sql)) {
					if ($row["password"]==$token1&&$row["salt"]==$token2) {
						// Si hemos llegado aquí es que la sesión es VALIDA
						return true;
					}
				}
				// Próxima revisión: abrir incidente en caso de que un token no sea válido bajo ciertas circunstancias.
				return false;
		} else {
			exit();
		}
	}
}
?>