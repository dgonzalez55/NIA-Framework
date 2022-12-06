<?php 
    use lib\core\mvc\Router;

    //GET ENDPOINTS
    Router::addRoute("GET",    "/",           "app\controllers\UserController",   "login");
    Router::addRoute("GET",    "/logout",     "app\controllers\UserController",   "logout");
    //POST ENDPOINTS
    Router::addRoute("POST",   "/",           "app\controllers\UserController",   "processLogin");
    Router::addRoute("POST",   "/register",   "app\controllers\UserController",   "processRegisterEntry");
