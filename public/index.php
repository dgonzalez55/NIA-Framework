<?php
    //Carreguem paràmetres de configuració i autoloader
    require_once '../app/consts.php';
    require_once '../app/config.php';
    require_once '../lib/autoload.php';
    //Carreguem els endpoints a l'enrutador MVC
    require_once '../app/routes.php';

    //Posem en marxa l'enrutador MVC
    use lib\core\mvc\Router;
    Router::run();

