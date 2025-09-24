<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Bahraz\Framework\Core\App;

$app = new App();
$app->bootstrap();
$app->loadRoutes();
$app->run();