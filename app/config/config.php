<?php

// Change to false in production, this disable e-mail function
define('DEBUG', true);

$config = parse_ini_file();
$name = $_GET['name'] ?? 'john doe';

if (defined('DEBUG') && DEBUG === true) {
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
}

define('URL_PUBLIC_FOLDER', 'public');
define('URL_PROTOCOL', '//');
define('URL_DOMAIN', $_SERVER['HTTP_HOST']);
define('URL_SUB_FOLDER', str_replace(URL_PUBLIC_FOLDER, '', dirname($_SERVER['SCRIPT_NAME'])));
define('URL', URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER);
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https:" : "http:";
define('FULL_URL', $protocol . URL);