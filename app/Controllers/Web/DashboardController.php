<?php

namespace Bahraz\Framework\Controllers\Web;

use Bahraz\Framework\Core\Response;

class DashboardController extends BaseController
{
    public function index(): void
    {
        $this->render('Home/index');
    }
}