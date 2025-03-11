<?php

class Router {
    private $routes = [];

    public function add($route, $controller, $method = 'index', $httpMethod = 'GET') {
        $this->routes[$route][$httpMethod] = ['controller' => $controller, 'method' => $method];
    }

    public function dispatch($url, $httpMethod = 'GET') {
        try {
            if($url === 'public/public'){
                require_once "../app/controllers/UserController.php";
                $controller = new UserController();
                $controller->index();
            }
            else if (isset($this->routes[$url][$httpMethod])) {
                $controllerName = $this->routes[$url][$httpMethod]['controller'];
                $method = $this->routes[$url][$httpMethod]['method'];

                require_once "../app/controllers/{$controllerName}.php";
                $controller = new $controllerName();
                $controller->$method();
            } else {
                echo "404 - Página no encontrada";
            }
        } catch (\Throwable $th) {
            echo $th;
        }
    }
}
