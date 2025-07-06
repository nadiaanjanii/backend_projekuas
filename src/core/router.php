<?php
class Router {
    private $routes = [];

    public function addRoute($method, $path, $handler) {
        $this->routes[] = compact('method', 'path', 'handler');
    }

    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes as $route) {
            if ($route['method'] == $method && preg_match("#^{$route['path']}$#", $uri, $params)) {
                array_shift($params);
                [$class, $method] = $route['handler'];
                $controller = new $class();
                return call_user_func_array([$controller, $method], $params);
            }
        }
        Response::json(['message' => 'Not Found'], 404);
    }
}
