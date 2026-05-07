<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
session_start();

// Si se usa el servidor integrado de PHP, permitir que sirva archivos estáticos directamente
if (php_sapi_name() === 'cli-server') {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (is_file(__DIR__ . $path)) {
        return false;
    }
}
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/helpers.php';

use Core\Router;

$router = new Router();
require __DIR__ . '/../routes/web.php';

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$scriptName = dirname($_SERVER['SCRIPT_NAME']);

$uri = $requestUri;
if ($scriptName !== '/' && $scriptName !== '\\') {
    $scriptName = str_replace('\\', '/', $scriptName);
    if (strpos($uri, $scriptName) === 0) {
        $uri = substr($uri, strlen($scriptName));
    }
}
$uri = trim($uri, '/');

$method = $_SERVER['REQUEST_METHOD'];

try {
    $router->direct($uri, $method);
} catch (Exception $e) {
    http_response_code(404);
    echo "<h1>404 Not Found</h1>";
    echo "<p>" . $e->getMessage() . "</p>";
}
