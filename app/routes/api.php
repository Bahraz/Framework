<?php

use Bahraz\Framework\Controllers\Api\BaseApiController;

$router->get('/api/test', BaseApiController::class . '@test');
