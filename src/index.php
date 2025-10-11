<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once 'config/connection.php';

spl_autoload_register(function ($class) {
    $file = str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) require_once $file;
});

$uri = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
$resource = $uri[0] ?? null;
$id = $uri[1] ?? null;
$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents("php://input"), true) ?? [];

$controllerName = 'controllers\\' . ucfirst($resource) . 'Controller';

if (!class_exists($controllerName)) {
    http_response_code(404);
    echo json_encode(["erro" => "Endpoint não encontrado"]);
    exit;
}

$controller = new $controllerName($conn);

try {
    switch ($method) {
        case 'GET':
            $id ? $controller->buscarPorId($id) : $controller->buscarTodos();
            break;
        case 'POST':
            $controller->criar($data);
            break;
        case 'PUT':
            if (!$id) throw new Exception("ID é necessário para editar", 400);
            $controller->editar((int)$id, $data);
            break;
        case 'DELETE':
            if (!$id) throw new Exception("ID é necessário para deletar", 400);
            $controller->deletar((int)$id);
            break;
        default:
            throw new Exception("Método não permitido", 405);
    }
} catch (Exception $e) {
    http_response_code($e->getCode() ?: 400);
    echo json_encode(["erro" => $e->getMessage()]);
}
