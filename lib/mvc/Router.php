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
            preg_match_all("/(?<={).+?(?=})/", $path, $paramMatches);
            $params = $paramMatches[0];
            $pattern = preg_replace("/\{.+?\}/", "([^/]+)", $path);
            $pattern = preg_replace("/\//", "\/", $pattern);
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
            $params = $_REQUEST;
            $path   = preg_replace("/\?.*/", "", $path);
            foreach($router->routing[$method] as $route){
                $matches=[];
                if(preg_match($route['pattern'], $path, $matches)){
                    array_shift($matches);
                    foreach($route['params'] as $key=>$param){
                        $params[$param] = $matches[$key];
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

