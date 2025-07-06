<?php
header("Content-Type: application/json");

spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../src/Controller/',
        __DIR__ . '/../src/Core/',
        __DIR__ . '/../src/Model/'
    ];
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

$router = new Router();
$router->addRoute('POST', '/api/auth/login', [AuthController::class, 'login']);
$router->addRoute('GET', '/api/auth/me', [AuthController::class, 'me']);
$router->addRoute('GET', '/api/students', [StudentController::class, 'index']);
$router->addRoute('GET', '/api/students/(\d+)', [StudentController::class, 'show']);
$router->addRoute('POST', '/api/students', [StudentController::class, 'store']);
$router->addRoute('PUT', '/api/students/(\d+)', [StudentController::class, 'update']);
$router->addRoute('DELETE', '/api/students/(\d+)', [StudentController::class, 'destroy']);
$router->dispatch();
