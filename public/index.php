<?php

session_start();

if (!isset($_COOKIE['id']) && !isset($_COOKIE['user'])) {
    // Default session time if 'Remember me' option is not enabled on login
    $sessionlimit = 3600; // 3600 secs = 1 hour

    $time = $_SERVER['REQUEST_TIME'];
    if (isset($_SESSION['LAST_ACTIVITY']) && ($time - $_SESSION['LAST_ACTIVITY']) > $sessionlimit) {
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

if (file_exists(APP . 'config/config.php')) {
    require APP . 'config/config.php';
}

$app = new App\Core\Application();
