<?php
    namespace lib\core\datasources;
    use lib\core\datasources\DataManager;
    //Només permetem una única instància de la classe (una única connexió a base de dades)
    abstract class DataBaseManager extends DataManager{
        //Apliquem Singleton Pattern per limitar l'accés de dades a una única connexió
        private static ?self $instance = null;
        
        private function __construct(){}

        public static function getInstance():self{
            if(static::$instance === null){
                static::$instance = new static();
            }
            return static::$instance;
        }

        private function __clone(){}
    }