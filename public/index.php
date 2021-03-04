<?php

use App\Core\Application;

$config = parse_ini_file(dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env');
define('MODE', $config['MODE'] ?? 'development');
define('SESSIONLIMIT', (int) $config['SESSIONLIMIT'] ?? 3600); // 3600 secs = 1 hour

session_start();

if (!isset($_COOKIE['id']) && !isset($_COOKIE['user'])) {
    $time = $_SERVER['REQUEST_TIME'];
    if (isset($_SESSION['last_activity']) && ($time - $_SESSION['last_activity']) > SESSIONLIMIT) {
        session_unset();
        session_destroy();
        session_start();
        $_SESSION['last_message'] = 'Automatically logged out due to afk, the inactive time limit is ' . SESSIONLIMIT . 'secs.';
        $_SESSION['last_class'] = 'text-white bg-danger';
    }
    $_SESSION['last_activity'] = $time;
}

define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('APP', ROOT . 'app' . DIRECTORY_SEPARATOR);
define('DB_FILE', ROOT . 'db' . DIRECTORY_SEPARATOR . 'database.sqlite');
define('SQL_FILE', ROOT . 'sql' . DIRECTORY_SEPARATOR . 'database.sql');

require APP . DIRECTORY_SEPARATOR . 'autoload.php';
require APP . DIRECTORY_SEPARATOR . 'config.php';

$app = new Application();