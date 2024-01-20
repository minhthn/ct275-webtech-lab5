<?php

declare(strict_types=1);

define('APP_NAME', 'phoneBook');
define('ROOT_PATH', __DIR__);
define('APP_PAT', ROOT_PATH . '/app');
define('VIEWS_PATH', ROOT_PATH . '/views');

require_once ROOT_PATH . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createMutable(ROOT_PATH);
$dotenv->load();

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule();
$capsule->addConnection([
    'driver' => $_ENV['DB_DRIVER'],
    'host' => $_ENV['DB_HOST'],
    'database' => $_ENV['DB_NAME'],
    'username' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD'],
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();
