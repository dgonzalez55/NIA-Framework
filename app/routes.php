<?php 
    use lib\mvc\Router;

    //PUT YOUR ENDPOINTS HERE
    //Router::addRoute("METHOD","PATH","CONTROLLER","ACTION");
    //? Les rutes arrenquen sempre amb / (l'enrutador afegirà al principi la url base configurada a app/config.php)
    //? Les classes controladores s'han de desar dins app/controllers per tal de ser trobades.
    Router::addRoute("GET","/{firstname}?/{lastname}?","HelloWorldController","sayHello");
