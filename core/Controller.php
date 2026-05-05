<?php
namespace Core;

class Controller {
    public function view($name, $data = []) {
        extract($data);
        $viewPath = __DIR__ . "/../app/views/{$name}.php";
        if(file_exists($viewPath)) {
            require $viewPath;
        } else {
            throw new \Exception("La vista {$name} no existe.");
        }
    }

    public function component($name, $data = []) {
        extract($data);
        $componentPath = __DIR__ . "/../app/views/components/{$name}.php";
        if(file_exists($componentPath)) {
            require $componentPath;
        } else {
            echo "<!-- Componente {$name} no encontrado -->";
        }
    }
}
