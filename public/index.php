<?php

if (session_status() === PHP_SESSION_NONE)
{
    session_start();
}

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use Bahraz\Framework\Core\Router;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


$router = new Router();

require __DIR__ . '/../app/routes/web.php';
require __DIR__ . '/../app/routes/api.php';

$router->dispatch($_SERVER['REQUEST_URI']);