<?php

define('TESTE', dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env');
$config = parse_ini_file(__DIR__ . '.env');
define('MODE', $config['MODE'] ?? 'development');

if (MODE === 'development') {
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