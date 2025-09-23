<?php

namespace Bahraz\Framework\Controllers\Web;

use Bahraz\Framework\Core\View;

class BaseController{
    protected function render(string $view, array $data = []): void
    {
        View::render($view,$data);
    }
}