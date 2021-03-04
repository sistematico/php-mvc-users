<?php

$config = parse_ini_file(dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env');
define('MODE', $config['MODE'] ?? 'development');
define('SESSION', $config['SESSION'] ?? 3600); // 3600 secs = 1 hour

use App\Core\Application;

session_start();

if (!isset($_COOKIE['id']) && !isset($_COOKIE['user'])) {
    $time = $_SERVER['REQUEST_TIME'];
    if (isset($_SESSION['LAST_ACTIVITY']) && ($time - $_SESSION['LAST_ACTIVITY']) > SESSION) {
        session_unset();
        session_destroy();
        session_start();
        $toast = (object) ['status' => 'success', 'message' => 'Automatically logged out due to downtime.'];
    }
    $_SESSION['LAST_ACTIVITY'] = $time;
}

define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('APP', ROOT . 'app' . DIRECTORY_SEPARATOR);
define('DB_FILE', ROOT . 'db' . DIRECTORY_SEPARATOR . 'banco.sqlite');
define('SQL_FILE', ROOT . 'sql' . DIRECTORY_SEPARATOR . 'database.sql');

require APP . DIRECTORY_SEPARATOR . 'autoload.php';
require APP . DIRECTORY_SEPARATOR . 'config.php';

$app = new Application();