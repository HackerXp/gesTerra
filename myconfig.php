<?php

define('CONFIG_MYSQL_PORT', '3306');  // porta da maquina onde encontra-se a base de dados...
define('CONFIG_MYSQL_HOST', 'localhost'); // nome da maquina onde encontra-se a base de dados no SGBD
define('CONFIG_MYSQL_USER', 'root');  // utilizador da base de dados no SGBD
define('CONFIG_MYSQL_PASS', '');   // palavra-passe do utilizador da base de dados no SGBD
define('CONFIG_MYSQL_DB', 'bd_portal_sigies');  // nome da base de dados no SGBD
define('CONFIG_MYSQL_DV', 'mysqli');  // nome da base de dados no SGBD

$protocolServer = isset($_SERVER['HTTPS']) ? "https://" : "http://";

$hostServer = filter_input(INPUT_SERVER, 'HTTP_HOST');
$fileName = filter_input(INPUT_SERVER, 'SCRIPT_NAME');
define('CONFIG_BASE_URL', $protocolServer . $hostServer . preg_replace('@/+$@', '', dirname($fileName)) . '/');
