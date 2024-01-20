<?php

declare(strict_types=1);

use App\Controllers\Auth\RegisterController;
use App\Controllers\Auth\LoginController;
use App\Controllers\HomeController;
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

$router->get('/register', RegisterController::class . '@index');
$router->post('/register', RegisterController::class . '@store');
$router->get('/login', LoginController::class . '@index');
$router->post('/login', LoginController::class . '@store');
$router->post('/logout', LoginController::class . '@logoutUser');

$router->get('/', HomeController::class . '@index');
$router->get('/home', HomeController::class . '@index');

$router->run();
