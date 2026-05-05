<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';

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
