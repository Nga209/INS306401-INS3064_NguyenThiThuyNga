<?php

class Router {
    private $routes = [];
    
    public function add($method, $path, $controller, $action) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }
    
    public function dispatch($requestUri, $requestMethod) {
        try {
            $requestUri = parse_url($requestUri, PHP_URL_PATH);
            $requestUri = rtrim($requestUri, '/');
            if ($requestUri === '') $requestUri = '/';
            
            foreach ($this->routes as $route) {
                // Chuyển đổi route pattern thành regex
                $pattern = preg_replace('/\{([a-z]+)\}/', '(?P<$1>[^/]+)', $route['path']);
                $pattern = '#^' . $pattern . '$#';
                
                if ($route['method'] === $requestMethod && preg_match($pattern, $requestUri, $matches)) {
                    $controllerName = $route['controller'];
                    $actionName = $route['action'];
                    
                    if (!class_exists($controllerName)) {
                        throw new Exception("Controller '$controllerName' not found");
                    }
                    
                    $controller = new $controllerName();
                    
                    if (!method_exists($controller, $actionName)) {
                        throw new Exception("Method '$actionName' not found in '$controllerName'");
                    }
                    
                    // Lọc các tham số từ URL
                    $params = array_filter($matches, function($key) {
                        return !is_numeric($key);
                    }, ARRAY_FILTER_USE_KEY);
                    
                    return $controller->$actionName($params);
                }
            }
            
            throw new Exception("Route '$requestUri' not found", 404);
            
        } catch (PDOException $e) {
            http_response_code(500);
            error_log("Database Error: " . $e->getMessage());
            echo "<h1>Database Error</h1>";
            echo "<p>Something went wrong with the database. Please try again later.</p>";
        } catch (Exception $e) {
            $code = $e->getCode() === 404 ? 404 : 500;
            http_response_code($code);
            
            if ($code === 404) {
                echo "<h1>404 - Page Not Found</h1>";
                echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
            } else {
                echo "<h1>Application Error</h1>";
                echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
            }
        }
    }
}