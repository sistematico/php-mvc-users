<?php

$config = parse_ini_file(dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env');
define('MODE', $config['MODE'] ?? 'development');
define('SESSIONLIMIT', (int) $config['SESSIONLIMIT'] ?? 3600); // 3600 secs = 1 hour

use App\Core\Application;

session_start();

if (!isset($_COOKIE['id']) && !isset($_COOKIE['user'])) {
    $time = $_SERVER['REQUEST_TIME'];
    if (isset($_SESSION['LAST_ACTIVITY']) && ($time - $_SESSION['LAST_ACTIVITY']) > SESSIONLIMIT) {
        session_unset();
        session_destroy();
        session_start();
        $toast = ['status' => 'success', 'class' => 'text-white bg-danger border-0', 'message' => 'Automatically logged out due to afk.'];
    }
    $_SESSION['LAST_ACTIVITY'] = $time;
}

if (isset($toast))
    var_dump($toast);

if (isset($_COOKIE['id']) && !isset($_COOKIE['user'])) {
    var_dump($_COOKIE['id']);
}

if (isset($_COOKIE['user'])) {
    //var_dump($_COOKIE['user']);
}

//var_dump($_SESSION['LAST_ACTIVITY']);


define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('APP', ROOT . 'app' . DIRECTORY_SEPARATOR);
define('DB_FILE', ROOT . 'db' . DIRECTORY_SEPARATOR . 'banco.sqlite');
define('SQL_FILE', ROOT . 'sql' . DIRECTORY_SEPARATOR . 'database.sql');

require APP . DIRECTORY_SEPARATOR . 'autoload.php';
require APP . DIRECTORY_SEPARATOR . 'config.php';

$app = new Application();