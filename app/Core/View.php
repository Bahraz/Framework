<?php

namespace Bahraz\Framework\Core;

use Bahraz\Framework\Core\Path;
use RuntimeException;

class View{
    public static function render(string $view, array $data = []): void
    {
        $viewFile   = Path::app("Views/$view.php");
        $headerFile = Path::app("Views/Components/header.php");
        $footerFile = Path::app("Views/Components/footer.php");


        foreach([$headerFile,$viewFile,$footerFile] as $file){
            if(!file_exists($file)){
                throw new RuntimeException("View file not found: $file");
            }
        }

        ob_start();
        
        $viewData = $data;
        
        require $headerFile;
        require $viewFile;
        require $footerFile;

        echo ob_get_clean();
    
    }
}