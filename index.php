<?php
global $routes;
require 'db.php';
require 'routes.php';

$method = $_SERVER['REQUEST_METHOD'];
$uriOriginal = $_SERVER['REQUEST_URI'];
$uri = parse_url($uriOriginal, PHP_URL_PATH);

if (str_contains($uri, '/api-docs')) {
    echo "Entra : $uri\n";
    exit; // deja que Apache/Nginx sirva archivos estáticos
}

// Elimina el prefijo del proyecto
$basePath = '/ipss/desaBackend/examen/todo-camisetas-ipss';
$uri = str_replace($basePath, '', $uri);
$uri = rtrim($uri, '/');

// Parsear JSON para POST, PUT, DELETE
if (in_array($method, ['POST', 'PUT', 'DELETE'])) {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!is_array($input)) $input = [];
    $_REQUEST = array_merge($_REQUEST, $input);
}

// Recorrer rutas y buscar coincidencia
foreach ($routes as $routeKey => $handler) {
    if (str_contains($routeKey, '-')) {
        [$pattern, $expectedMethod] = explode('-', $routeKey);

        if ($method === $expectedMethod && preg_match($pattern, $uri, $matches)) {
            array_shift($matches);
            [$controller, $methodName] = $handler;

            require_once "controllers/{$controller}.php";

            if (is_callable([$controller, $methodName])) {
                call_user_func_array([$controller, $methodName], $matches);
                exit;
            }
        }
    }
}

// Si no encuentra la ruta
http_response_code(404);
header('Content-Type: application/json');
echo json_encode(['error' => 'Ruta no encontrada']);
