<?php

declare(strict_types=1);

use Bramus\Router\Router;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();

require_once __DIR__ . '/../bootstrap.php';

$router = new Router();

$router->set404(function () {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    echo '404, Route not found ~~!';
});

$router->get('/', function () {
    echo 'Welcome to phoneBook!';
});

$router->run();
