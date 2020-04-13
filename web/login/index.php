<?php
	require ("auxiliar.php");
	
	// SERVICIO DE AUTOLOGIN
	if (comprobarSesionCliente()==true) {
		if ($_SESSION["tipoLogin"] >= 1) {
			header('Location: /check.php?IDS='.$_GET["IDS"]);
		}
	}
	if (isset($_GET["IG_uID"])) {
		if (comprobarTokenIG($_GET["IG_uID"], $_GET["token1"], $_GET["token2"])==true) {
		// Identificación vía IG mediante token...
		header('Location: /check.php?IDS='.$_GET["IDS"].'&uID='.$_GET["IG_uID"].'&token1='.$_GET["token1"].'&token2='.$_GET["token2"]);
		}
	}
    require_once 'captcha/securimage.php';
	$img_captcha = Securimage::getCaptchaHtml();
?>
<!DOCTYPE html>
<html lang="es" >
	<head>
		<title>Inicio de Sesión - DownTown RolePlay</title>
		<meta charset="UTF-8">
		<link href="/css/style.css" rel="stylesheet">
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script>
		    function validarFormulario()
    {
        var a=document.forms["form_login_foro"]["usuario_foro"].value;
        var b=document.forms["form_login_foro"]["clave_foro"].value;
        var c=document.forms["form_login_ig"]["usuario_ig"].value;
        var d=document.forms["form_login_ig"]["clave_ig"].value;
		if (a!="" && b!="") {
			document.forms["form_login_foro"]["captcha_code"].value = document.getElementById("captcha_code").value;
			document.forms['form_login_foro'].submit();
			return true;
		} else if (c!="" && d!="") {
			document.forms["form_login_ig"]["captcha_code"].value = document.getElementById("captcha_code").value;
			document.forms['form_login_ig'].submit();
			return true;
		} else {
			document.forms["form_login_foro"]["captcha_code"].value = document.getElementById("captcha_code").value;
			document.forms['form_login_foro'].submit();
			return true;
		}
    }
		</script>
	</head>
<div class="container login-container">
	<center>
		<img src="/img/logo.png">
		<?php 	if (isset($_GET["error"])) {
		$err = $_GET["error"];
		if ($err==1) {
			echo '<div class="alert alert-danger" role="alert">Los datos introducidos no son correctos.</div>';
		} else if ($err==2) {
			echo '<div class="alert alert-danger" role="alert">No has introducido usuario y contraseña.</div>';
		} else if ($err==3) {
			echo '<div class="alert alert-danger" role="alert">Necesitas primero activar y vincular tu cuenta IG con tu cuenta de foro. Visita el foro para más información.</div>';
		} else if ($err==4) {
			echo '<div class="alert alert-danger" role="alert">No has introducido correctamente el captcha.</div>';
		} 
	}?>
	</center>
            <div class="row">
                <div class="col-md-6 login-form-1">
                    <h3>Vía Foro</h3>
					<div class="alert alert-primary" role="alert">
						Puedes iniciar sesión con tu cuenta de foro.
					</div>
                    <form method="POST" action="check.php" name="form_login_foro">
                        <div class="form-group">
                            <input name="usuario_foro" type="text" class="form-control" placeholder="Usuario de foro" autocomplete="off" value="" />
                        </div>
                        <div class="form-group">
                            <input name="clave_foro" type="password" class="form-control" placeholder="Clave de foro" autocomplete="off" value="" />
                        </div>
						<input name="IDS" type="hidden" value="<?php echo $_GET["IDS"]; ?>" />
						<input name="captcha_code" type="hidden" value="" />
					</form>
                </div>
                <div class="col-md-6 login-form-2">
                    <h3>Vía Servidor IG</h3>
					<div class="alert alert-primary" role="alert">
						Si lo prefieres, también puedes iniciar sesión con tu cuenta IG.
					</div>
					<form method="POST" action="check.php" name="form_login_ig">
                        <div class="form-group">
                            <input name="usuario_ig" type="text" class="form-control" placeholder="Usuario IG" autocomplete="off" value="" />
                        </div>
                        <div class="form-group">
                            <input name="clave_ig" type="password" class="form-control" placeholder="Clave IG" autocomplete="off" value="" />
                        </div>
						<input name="IDS" type="hidden" value="<?php echo $_GET["IDS"]; ?>" />
						<input name="captcha_code" type="hidden" value="" />
					</form>
                </div>
            </div>
			<center>
			<div class="row">
				<div class="col-md-12 login-form-3" >
					<?php
						echo $img_captcha;
					?>
					<input type="submit" class="btn btn-primary" value="Iniciar Sesión" onclick="validarFormulario();"/>
				</div>
			</div>
			<br><br>
			<div class="alert alert-secondary" role="alert">
				DownTown RolePlay 2019 - Inicio de Sesión Centralizado. 1 login, múltiples servicios.
			</div>
			</center>
		</div>
</html>