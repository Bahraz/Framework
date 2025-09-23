<?php

use Bahraz\Framework\Controllers\Web\DashboardController;

$router->get('/', DashboardController::class . '@index');