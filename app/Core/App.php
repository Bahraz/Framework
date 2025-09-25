<?php 

namespace Bahraz\Framework\Core;

use Dotenv\Dotenv;

class App
{
    private Router $router;

    public function __construct()
    {      
        $this->router = new Router();
    }

    public function bootstrap(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
    }


    public function loadRoutes(): void
    {
        $router = $this->router;
        require Path::app("routes/web.php");
        require Path::app("routes/api.php");
    }

    public function run(): void
    {
        $response = $this->router->dispatch($_SERVER['REQUEST_URI']);

        if ($response instanceof Response) {
            $response->send();
        }else{
            echo $response;
        }
    }
}