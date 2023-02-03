<?php
    namespace lib\mvc;

    final class Router{
        private $routing = [];
        //Aplicació del patró de disseny Singleton ($instance o és de tipus Router o és null)
        private static ?self $instance = null;
        
        //Aplicació del patró de disseny Singleton (El constructor és privat)
        private function __construct(){
            $this->routing = [
                "GET"=>[],
                "POST"=>[],
                "PUT"=>[],
                "DELETE"=>[]
            ];
        }
       
        //Aplicació del patró de disseny Singleton (obtenim instància en memòria o la creem de 0)
        public static function getInstance():self{
            if(static::$instance === null){
                static::$instance = new static();
            }
            return static::$instance;
        }

        private function __clone(){}

        public static function addRoute(string $method, string $path, string $controller, string $action){
            $router = self::getInstance();
            $paramMatches = [];
            $path = APP_BASE_URL . $path;
            //Afegim el namespace de la classe controladora si no hi és ja
            $controller = strpos($controller,'app\\controllers\\',0) === 0 ? $controller : 'app\\controllers\\' . $controller;
            //Capturem els paràmetres que segueixen la sintaxi {param}
            preg_match_all("/(?<={).+?(?=})/", $path, $paramMatches);
            $params = $paramMatches[0];
            //Expressió regular per paràmetres opcionals en ruta ({param}?)
            $pattern = preg_replace('/\{([^}]+)\}\?/', '([^/]+)?', $path);
            //Això és per fer la barra de ruta opcional si hi han paràmetres previs al opcional
            $pattern = preg_replace('/\/\(\[\^\/\]\+\)\?/', '/?([^/]+)?', $pattern);
            //Expressió per paràmetres obligatoris en ruta
            $pattern = preg_replace('/\{.+?\}/', '([^/]+)', $pattern);
            //Escapem barres de ruta per utilitzar la cadena com expressió regular
            $pattern = preg_replace('/\//', '\/', $pattern);
            $pattern = "/^".$pattern."$/";
            $router->routing[$method][] = [
                "pattern"=>$pattern,
                "controller"=>$controller,
                "action"=>$action,
                "params"=>$params
            ];

        }

        public static function run(){
            $router = self::getInstance();
            $method = $_SERVER['REQUEST_METHOD'];
            $path   = $_SERVER['REQUEST_URI'];
            $queryParams = [];
            $params = [];
            parse_str(file_get_contents("php://input"),$params);
            $path   = preg_replace("/\?.*/", "", $path);

            // Check for query parameters in the URL
            $query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
            if ($query) {
                parse_str($query, $queryParams);
                $params = array_merge($params, $queryParams);
            }

            foreach($router->routing[$method] as $route){
                $matches=[];
                if(preg_match($route['pattern'], $path, $matches)){
                    array_shift($matches);
                    foreach($route['params'] as $key=>$param){
                        if(isset($matches[$key])) $params[$param] = $matches[$key];
                    }
                    $controller = new $route['controller'];
                    $action     = $route['action'];
                    $controller->$action($params);
                    return;
                }
            }
            http_response_code(404);
        }
    }

