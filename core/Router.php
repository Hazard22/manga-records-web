
<?php

class Router {
    private $routes = [];

    public function add($route, $controller, $method = 'index', $httpMethod = 'GET') {
        $routePattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $route);
        $this->routes[$httpMethod][$routePattern] = ['controller' => $controller, 'method' => $method];
    }

    public function dispatch($url, $httpMethod = 'GET') {
        try {
            if($url === 'public/public'){
                require_once "../app/controllers/UserController.php";
                $controller = new UserController();
                $controller->index();
                return;
            }
            foreach ($this->routes[$httpMethod] as $routePattern => $routeInfo) {
                if (preg_match("#^$routePattern$#", $url, $matches)) {
                    require_once "../app/controllers/{$routeInfo['controller']}.php";
                    $controller = new $routeInfo['controller']();
                    $method = $routeInfo['method'];

                    // Filtrar solo los parámetros dinámicos
                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                    // Llamar al método con los parámetros extraídos
                    call_user_func_array([$controller, $method], $params);
                    return;
                }
            }

            echo "404 - Página no encontrada";
        } catch (\Throwable $th) {
            echo $th;
        }
    }
}

