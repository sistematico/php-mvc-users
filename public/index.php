<?php

// Remove this in production
ini_set('display_errors', 'On');
error_reporting(E_ALL);

session_start();

if (!isset($_COOKIE['id']) && !isset($_COOKIE['user'])) {
    $time = $_SERVER['REQUEST_TIME'];
    if (isset($_SESSION['LAST_ACTIVITY']) && ($time - $_SESSION['LAST_ACTIVITY']) > 7200) {
        session_unset();
        session_destroy();
        session_start();
    }
    $_SESSION['LAST_ACTIVITY'] = $time;
}

define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('APP', ROOT . 'app' . DIRECTORY_SEPARATOR);
define('DB_FILE', ROOT . 'db' . DIRECTORY_SEPARATOR . 'banco.sqlite');

require ROOT . 'vendor/autoload.php';

if (file_exists(APP . 'config/config.php'))
    require APP . 'config/config.php';

$app = new App\Core\Application();
