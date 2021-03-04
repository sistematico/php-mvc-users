<?php

use App\Core\Application;

if (file_exists(dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env'))
    $config = parse_ini_file(dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env');

define('SESSIONLIMIT', $config['SESSIONLIMIT'] ?? 3600); // 3600 secs = 1 hour

session_start();

if (!isset($_COOKIE['id']) && !isset($_COOKIE['user'])) {
    $time = $_SERVER['REQUEST_TIME'];
    if (isset($_SESSION['last_activity']) && ($time - $_SESSION['last_activity']) > SESSIONLIMIT) {
        session_unset();
        session_destroy();
        session_start();
        $_SESSION['last_message'] = 'Automatically logged out due to afk, the inactive time limit is ' . SESSIONLIMIT . 'secs.';
        $_SESSION['last_class'] = 'warning';
    }
    $_SESSION['last_activity'] = $time;
}

define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('APP', ROOT . 'app' . DIRECTORY_SEPARATOR);
define('MODE', $config['MODE'] ?? 'development');
define('USERS_TABLE', $config['USERS_TABLE'] ?? 'users');
define('CHAT_TABLE', $config['CHAT_TABLE'] ?? 'chat');
define('DB_FILE', isset($config['DB_FILE']) ? ROOT . 'db' . DIRECTORY_SEPARATOR . $config['DB_FILE'] : ROOT . 'db' . DIRECTORY_SEPARATOR . 'database.sqlite');
define('SQL_FILE', isset($config['SQL_FILE']) ? ROOT . 'sql' . DIRECTORY_SEPARATOR . $config['SQL_FILE'] : ROOT . 'sql' . DIRECTORY_SEPARATOR . 'database.sql');

require APP . DIRECTORY_SEPARATOR . 'autoload.php';
require APP . DIRECTORY_SEPARATOR . 'config.php';

$app = new Application();