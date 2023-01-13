<?php 
    use lib\mvc\Router;

    //PUT YOUR ENDPOINTS HERE
    //Router::addRoute("METHOD","PATH","CONTROLLER","ACTION");
    //? Les rutes arrenquen sempre amb / (l'enrutador afegirà al principi la url base configurada a app/config.php)
    Router::addRoute("GET","/{firstname}?/{lastname}?","app\controllers\HelloWorldController","sayHello");
