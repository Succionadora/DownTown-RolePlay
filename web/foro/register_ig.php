<?php
require_once('SSI.php');

global $sourcedir;

require_once($sourcedir . '/Subs-Members.php');

$regOptions = array(
    'username' => $_GET['usuario_foro'],
    'email' => $_GET['usuario_foro'].'@dt-mta.com',
    'password' => $_GET['clave_foro'],
	'password_check' => $_GET['clave_foro'],
	'require' => 'nothing',
);
				
if (registerMember($regOptions)) {
    echo "1";
}

?>