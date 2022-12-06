<?php
    namespace lib\core\datasources;

    abstract class DataManager{

        public static function getInstance():self{
            $class = get_called_class();
            return new $class();
        }
    }