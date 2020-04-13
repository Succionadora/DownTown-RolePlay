<?php
	require("auxiliar.php");
	
	session_set_cookie_params(43200, '/', 'login.dt-mta.com', true, true);
	session_start();
	if (session_status()==2) {
		if (isset($_SESSION["loginIG"])) {
			destruirSesionCliente();
			echo 'Sesión cerrada correctamente, puedes cerrar la ventana.';
			die();
		}
	}
	destruirSesionCliente();
	if ($_GET["reauth"]==1) {
		//Redirigimos a login directamente
		header('Location: /index.php?IDS='.$_GET["IDS"]);
	}
?>

<!DOCTYPE html>
<html>
<head>
   <!-- HTML meta refresh URL redirection -->
   <meta charset="UTF-8" http-equiv="refresh"
   content="2; url=https://foro.dt-mta.com">
</head>
<body>
   <p>Has cerrado sesión correctamente. Serás redirigido al foro en unos segundos.</p>
</body>
</html>