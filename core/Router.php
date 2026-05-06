<?php
namespace Core;

class Router {
    protected $routes = [
        'GET' => [],
        'POST' => []
    ];

    public function get($uri, $controller) {
        $this->routes['GET'][$uri] = $controller;
    }

    public function post($uri, $controller) {
        $this->routes['POST'][$uri] = $controller;
    }

    public function direct($uri, $requestType) {
        if (array_key_exists($uri, $this->routes[$requestType])) {
            return $this->callAction(
                ...explode('@', $this->routes[$requestType][$uri])
            );
        }

        // Buscar coincidencia dinámica (ej: servicios/{slug})
        foreach ($this->routes[$requestType] as $route => $controller) {
            $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([^/]+)', $route);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Eliminar coincidencia global
                return $this->callAction(
                    ...array_merge(explode('@', $controller), $matches)
                );
            }
        }

        throw new \Exception('No se definió ninguna ruta para esta URI.');
    }

    protected function callAction($controller, $action, ...$parameters) {
        $controller = "App\\Controllers\\{$controller}";
        $controller = new $controller;

        if (! method_exists($controller, $action)) {
            throw new \Exception(
                "El controlador {$controller} no responde a la acción {$action}."
            );
        }

        return $controller->$action(...$parameters);
    }
}
