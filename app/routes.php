<?php 
    use lib\mvc\Router;

    //PUT YOUR ENDPOINTS HERE
    //Router::addRoute("METHOD","PATH","CONTROLLER","ACTION");
    Router::addRoute("GET","/{firstname}?/{lastname}?","app\controllers\HelloWorldController","sayHello");
